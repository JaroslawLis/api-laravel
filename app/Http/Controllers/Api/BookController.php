<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Opinion;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //ADD BOOK API - POST
    public function addBook(Request $request)
    {
        // validation
        $request->validate([
            "title" => "required|min:1|max:200",
            "description" => "required|min:1",
            "isbn" => "required|min:4|max:13|unique:books",
        ]);

        // create book object
        $book = new Book();

        $book->user_id = auth()->user()->id;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->isbn = $request->isbn;

        $book->save();


        // send response

        return response()->json([
            "status" => 1,
            "message" => "Book added successfully"
        ]);
    }

    // DELETE BOOK API - GET
    public function deleteBook($id)
    {
        // user id
        $user_id = auth()->user()->id;

        if (Book::where([
            "id" => $id,
            "user_id" => $user_id
        ])->exists()) {

            $book = Book::find($id);

            if ($book->opinions()->count()) {
                return
                    response()->json([
                        "status" => 0,
                        "message" => "Canceled - Book has opinion"
                    ]);
            }

            $book->delete();

            return response()->json([
                "status" => 1,
                "message" => "Book deleted successfully"
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Book not found "
            ]);
        }
    }

    // UPDATE BOOK API - UPDATE
    public function editBook(Request $request, $id)
    {
        // validation
        $request->validate([
            "title" => "min:1|max:200",
            "description" => "min:1"

        ]);
        // user id
        $user_id = auth()->user()->id;

        if (Book::where([
            "id" => $id,
            "user_id" => $user_id
        ])->exists()) {

            $book = Book::find($id);

            $book->title = !empty($request->title) ? $request->title : $book->title;
            $book->description = !empty($request->description) ? $request->description : $book->description;


            $book->save();

            return response()->json([
                "status" => 1,
                "message" => "Book update successfully"
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Book not found"
            ]);
        }
    }
    public function  mybookslist()
    {
        $id = auth()->user()->id;

        $books = User::find($id)->books;

        return response()->json([
            "status" => 1,
            "message" => "Your books",
            "data" => $books
        ]);
    }

    public function listOfBooks(Request $request)
    {
        if ($request->input('title')) {
            $title = $request->input('title');
            $result = Book::where('title', 'LIKE', '%' . $title . '%')->get();
            return $result;
        }
        if ($request->input('description')) {
            $description = $request->input('description');
            $result = Book::where('description', 'LIKE', '%' . $description . '%')->get();
            return $result;
        } else {
            return Book::orderBy('created_at', 'desc')->paginate(10);
        }
    }

    public function bookDetails($id)
    {
        $details = Book::find($id);
        $opinions = Book::find($id)->opinions;
        return response()->json([
            "status" => 1,
            "details" => $details,
            "message" => "Opinions",
            "data" => $opinions
        ]);
    }
}
