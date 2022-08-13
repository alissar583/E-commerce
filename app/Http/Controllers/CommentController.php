<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments=Comment::query()->get();
        return $comments;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        $comments=Comment::query()->create([
            'value'=>$request->value,
            'owner_id'=>Auth::id(),
            'product_id'=>$request->product_id,
        ]);
        return $comments;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(User $user_id)
    {
        $user_id->products()->whereDate('expired_date', '>=', now());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        if (Auth::id() == $comment->owner_id){
            $comment->update([
                'value'=>$request->value,
                'owner_id'=>Auth::id(),
                'product_id'=>$request->product_id,
            ]);
            return response()->json(["key"=>$comment, 200]);
        }else
            return response()->json(null, 403);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if (Auth::id() == $comment->owner_id){
            $comment->delete();
        }else
            return response()->json(null, 403);

    }
}
