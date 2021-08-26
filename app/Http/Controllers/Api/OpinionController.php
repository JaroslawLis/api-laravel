<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Opinion;
use App\Models\Book;
use Illuminate\Http\Request;

class OpinionController extends Controller
{
    public function addOpinion(Request $request, $id)
    {
        // validation
        $request->validate([
            "note" => "required",
            "description" => "required|min:2|max:500",
            "author" => "required|min:2|max:100",
            "email" => "email",
        ]);

        // create book object
        $opinion = new Opinion();

        $opinion->book_id = $id;
        $opinion->note = $request->note;
        $opinion->descritpion = $request->description;
        $opinion->author = $request->author;
        $opinion->email = $request->email ?? "";

        $opinion->save();


        // send response

        return response()->json([
            "status" => 1,
            "message" => "Opinion added successfully"
        ]);
    }
}
