<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
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

        return response()->json($comment->load('user')->load('likes'));
    }

    public function getProductComments($id) {
        $comment = Comment::with('user')
                          ->where('product_id', $id)
                          ->with('likes')
                          ->get();
        return response()->json([$comment, Auth::user()->id]);
    }

    public function deleteProductComment($id) {
        Comment::with('user')
               ->where('id', $id)
               ->where('user_id', Auth::user()->id)
               ->delete();
        return response()->json($id);
    }

    public function likeProductComments($id) {
        $like = Like::where('user_id', Auth::user()->id)
                    ->where('likeable_id', $id)
                    ->where('likeable_type', Comment::class)
                    ->first();

        if (!$like) {
            $like = Like::create([
                'likeable_id' => $id,
                'likeable_type' => Comment::class,
                'user_id' => Auth::user()->id,
                'count' => 1
            ]);
//            $comment = Comment::with('user')
//                              ->whereHas('likes', function($query) use ($like) {
//                                  $query->where('id', $like->id);
//                              })->first();
            return response()->json($like);
        }
        return response()->json('Failure');
    }

    public function dislikeProductComments($id) {
        $comment = Like::where('user_id', Auth::user()->id)
                       ->where('likeable_id', $id)
                       ->where('likeable_type', Comment::class)
                       ->first();
        if ($comment) {
            $comment->delete();
            return response()->json($comment);
        }
        return response()->json('Failure');
    }
}
