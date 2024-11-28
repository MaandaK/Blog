<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;


class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $post = Post::findOrFail($id);
        return response()->json($post->comments()->paginate(10), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        $comment->update($request->all());
        return response()->json(['Message'=>'Successfully Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id ,Comment $comment)
    {
        $user = Auth::user();
        if($comment['user_id']== $user['id'])
        {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json(['message' => 'Comment deleted'], 200);
        //
        }
        else
        {
            return response()->json(['message'=>'you dont have access to delete']);
        }
    }
}
