<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function createProductComment(Request $request) {
        // get data from front
        $id = $request->id;
        $productComment = $request->productComment;
        // set comment to db and get comment
        $comment = Comment::with('user')->create([
            'product_id' => $id,
            'user_id' => Auth::user()->id,
            'comment' => $productComment
        ]);

        return response()->json($comment->load('user'));
    }

    public function getProductComments($id) {
        $comment = Comment::with('user')->get();

        return response()->json($comment);
    }
}
