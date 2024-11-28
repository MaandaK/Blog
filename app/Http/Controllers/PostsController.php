<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // dd($request->all());
        $allPosts = Post::whereAny(['title','content'] ,'like',"%".$request['filter'].'%')->get() ;
        // $allPosts = Post::orderBy("created_at","desc")->paginate(10);
        // $allPosts = Post::all();  
        return response()->json([$allPosts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


    }   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);
        $user  = Auth::user();
        // dd($user);
        // return response()->json(['data'=> $user['id']]);

        Post::create([
            'title' => $userData['title'],
            'content' => $userData['content'],
            'user_id' => $user['id']]);
        return response()->json(['data'=> 'successfully created']);

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $Post)
    {
        //
        return response()->json([$Post]);
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
    public function update(Request $request, Post $post)
    {
        //
        $data = $post->all();
        $userData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);
        $user  = Auth::user();
        if($post['user_id']== $user['id'])
        {
        $post->update($userData);
        return response()->json(['message'=>'record sucessfully updated']);
        }
        else
        {
            return response()->json(['message'=>'you dont have access to update']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $Post)
    {
        $user  = Auth::user();
        // dd($Post['user_id'], $user['id']);
        if($Post['user_id']== $user['id'])
        {
            $Post->delete();
            return response()->json(['message'=>'record sucessfully deleted']);
        }
        else
        {
            return response()->json(['message'=>'you dont have access to delete']);
        }
    }
    public function getComments(Request $request)
    {
        $user = Auth::user();
        $query = Post::query();
        
        if ($request->filled('search')) {
            $query
                    ->where('title', 'like', "%{$request->search}%")
                    ->orWhere('content', 'like', "%{$request->search}%");
            }
    
            if ($request->filled('user_id')) {
                $query
                    ->where('user_id', $request->user_id);
            }
    
            return response()->json($query->paginate(10), 200);    
    }
    public function addComments(Request $request ,Post $post_id)
    {
        $user = Auth::user();
        // dd($post_id->id);
        $data = $request->validate([
            'content' => 'required|string',
        ]);
        Comment::create([
            'content' => $data['content'],
            'user_id' => $user['id'],
            'post_id' => $post_id->id,
        ]);
        return response()->json(['Message' => 'Comment Created Successfully']);

    }

}
