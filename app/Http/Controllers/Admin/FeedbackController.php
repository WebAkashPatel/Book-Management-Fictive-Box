<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Structure;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    use Structure;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.content.feedback');
    }

    public function data(Request $request)
    {

        $table = Feedback::query()
            ->join('users', 'feedback.user_id', '=', 'users.id')
            ->join('books', 'feedback.book_id', '=', 'books.id')
            ->select([
                'feedback.*',
                'users.name as user_name',
                'books.title as book_title',
            ]);

        $rows = $table->orderBy('feedback.id', 'DESC')->get();

        return datatables()->of($rows)->addIndexColumn()
            ->addColumn('id', function ($data) {
                return '#feedback-' . $data->id;
            })
            ->addColumn('username', function ($data) {
                return $data->user_name ?? '';
            })
            ->addColumn('book_title', function ($data) {
                return $data->book_title ?? '';
            })
            ->addColumn('rating', function ($data) {
                return isset($data->rating) ? $data->rating . '/' . 5 : 0;
            })

            ->addColumn('comment', function ($data) {
                $words = explode(' ', $data->comments ?? 'No comments');
                $shortComment = implode(' ', array_slice($words, 0, 5));
                return (count($words) > 5) ? $shortComment . '...' : $shortComment;
            })

            ->addColumn('created_at', function ($data) {
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('actions', function ($data) {
                return '<a href="' . route('admin.feedback.view', $data->id) . '" class="btn btn-primary btn-sm rounded-pill">View</a>';
            })
            ->rawColumns(['id', 'username', 'book_title', 'rating', 'comment', 'created_at', 'actions'])
            ->make(true);
    }

    public function view(Request $request)
    {
        if (isset($request->id)) {

            $feedbacks = Feedback::where('feedback.id', $request->id)
                ->join('users', 'feedback.user_id', '=', 'users.id')
                ->join('books', 'feedback.book_id', '=', 'books.id')
                ->select([
                    'feedback.id',
                    'feedback.rating',
                    'feedback.comments',
                    'feedback.created_at',
                    'users.name as user_name',
                    'books.title as book_title',
                ])
                ->first();

            if (!$feedbacks) {
                return response()->json(['message' => 'Feedback not found'], 404);
            }

            return view('admin.content.feedback_view', compact('feedbacks'));
        }
        return response()->json(['message' => 'Feedback not found'], 404);

    }

}
