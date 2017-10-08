<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Order;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth', ['only' => 'store', 'destroy']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Order $order)
    {
        $user_id = auth()->user()->id;
        $text = request('text');
        $comment = $order->comments()->create(compact('user_id', 'text'));
        return response()->json([
            'user_id' => $comment->user->id,
            'user_name' => $comment->user->name,
            'comment_id' => $comment->id,
            'comment_text' => $comment->text,
            'comment_created_at' => $comment->created_at->diffForHumans(),
            'comments_count' => $order->comments->count(),
            'order_id' => $order->id,
            'avatar_filename' => $comment->user->avatar->filename,
            'csrf_token' => csrf_token(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order, Comment $comment)
    {
        $comment_id = $comment->id;
        $comment->delete();
        return response()->json([
            'comment_id' => $comment_id,
            'comments_count' => $order->comments->count(),
        ]);
    }
}
