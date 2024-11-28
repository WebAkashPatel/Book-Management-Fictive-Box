<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Feedback;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    

     public function index(Request $request)
     {
         $query = Book::query();
     
         if ($request->filled('title')) {
             $query->where('title', 'like', '%' . $request->input('title') . '%');
         }
     
         if ($request->filled('author')) {
             $query->where('author', 'like', '%' . $request->input('author') . '%');
         }
     
         // Fetch books with their feedbacks, applying 'user_show' and 'is_delete' conditions on the feedback table
         $books = $query->with(['feedbacks' => function ($query) {
             $query->where('user_show', 'yes')->where('is_delete', 'no');
         }])->where('is_delete', 'no')->get();  // Only 'is_delete' condition for books
     
         foreach ($books as $book) {
             $averageRating = $book->feedbacks->avg('rating');
             $book->averageRating = $averageRating ? round($averageRating, 1) : 0;
         }
     
         return view('home', compact('books'));
     }
     
     
    
    

     public function show($encryptedId)
{
    $id = Crypt::decrypt($encryptedId);
    $book = Book::findOrFail($id);

    // Apply 'user_show' and 'is_delete' conditions to feedback table, not on the book
    $reviews = DB::table('feedback')
        ->join('users', 'feedback.user_id', '=', 'users.id')
        ->where('feedback.book_id', $id)
        ->where('feedback.user_show', 'yes')  // Apply 'user_show' condition here
        ->where('feedback.is_delete', 'no')   // Apply 'is_delete' condition here
        ->select(
            'feedback.rating',
            'feedback.comments',
            'feedback.created_at',
            'users.name as username'
        )
        ->get();

    $averageRating = $reviews->avg('rating');
    $averageRating = $averageRating ? round($averageRating, 1) : 0;  

    $hasReviewed = DB::table('feedback')
        ->where('book_id', $id)
        ->where('user_id', Auth::id())
        ->exists();

    return view('book_details', compact('book', 'reviews', 'hasReviewed', 'averageRating'));
}

    

    public function storeReview(Request $request, $encryptedBookId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $bookId = Crypt::decrypt($encryptedBookId);

        Feedback::create([
            'book_id' => $bookId,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comments' => $request->comment,
        ]);

        return back()->with('success', 'Thank you for your review! Your feedback has been submitted.');

    }
}
