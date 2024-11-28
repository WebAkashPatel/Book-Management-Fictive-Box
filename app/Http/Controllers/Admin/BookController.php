<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Structure;
use App\Models\Book;
use Illuminate\Http\Request;
use Validator;

class BookController extends Controller
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
        return view('admin.content.books');
    }

    public function data(Request $request)
    {
        $table = Book::query();
        $rows = $table->orderBy('id', 'DESC')->get();

        return datatables()->of($rows)->addIndexColumn()
            ->addColumn('id', function ($data) {
                return '#book-' . $data->id;
            })

            ->addColumn('title', function ($data) {
                return $data->title;
            })

            ->addColumn('author', function ($data) {
                return $data->author;
            })

            ->addColumn('images', function ($data) {
                return $data->images ?
                '<a href="javascript:void(0);" class="open-image-modal" data-image="' . asset('images/' . $data->images) . '">
                    <img src="' . asset('images/' . $data->images) . '" alt="Book Image" width="50" height="50">
                </a>' : 'No image';
            })
            ->rawColumns(['images'])

            ->addColumn('description', function ($data) {
                $description = isset($data->description) ? $data->description : '';
                $words = explode(' ', $description);
                return implode(' ', array_slice($words, 0, 10)) . (count($words) > 10 ? '...' : '');
            })

            ->addColumn('created_at', function ($data) {
                return isset($data->created_at) ? $data->created_at : 0;
            })

            ->addColumn('actions', function ($data) {
                return '<a href="' . route('admin.books.edit', $data->id) . '" class="btn btn-primary btn-sm rounded-pill">Edit</a>';
                $buttons = '<div class="ui float-right" style="width: 100px;">';
                // View Option
                $buttons .= '<a href="#" class="text-primary" data-toggle="tooltip" data-placement="top" title="View trip details"><i class="bx bx-show-alt fa-2x"></i></a>';
                // Manage Token Option
                // $buttons .= ' <a href="javascript:void(0);" data-id="'.$data->id.'" class="text-warning add-cd-token-btn" data-toggle="tooltip" data-placement="top" title="Add new token"><i class="bx bx-receipt fa-2x"></i></a>';

                // Edit Option
                $buttons .= ' <a href="#" class="text-info edit-trip-btn" data-toggle="tooltip" data-placement="top" title="Edit trip details"><i class="bx bx-edit fa-2x"></i></a>';

                // Delete Option
                $buttons .= ' <a href="javascript:void(0);" data-id="' . $data->id . '" class="text-danger delete-token-btn" data-toggle="tooltip" data-placement="top" title="Delete token"><i class="bx bx-trash fa-2x"></i></a>';
                $buttons .= '</div>';

                return $buttons;
            })

            ->rawColumns(['id', 'title', 'author', 'description', 'images', 'created_at', 'actions'])
            ->make(true);

    }

    public function add()
    {
        return view('admin.content.add_book');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.content.add_book', compact('book'));
    }

    public function store(Request $request, $id = null)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
        ]);
    
       
        $book = $id ? Book::findOrFail($id) : new Book();
        
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
    
      
        if ($request->hasFile('images')) {
            $imageName = time() . '.' . $request->images->extension();
            $request->images->move(public_path('images'), $imageName);
            $book->images = $imageName;
        }
    
        $book->save();
    
        return redirect()->route('admin.books')->with('success', $id ? 'Book updated successfully!' : 'Book created successfully!');
    }
    

   

}
