<?php

namespace App\Http\Controllers;

use App\Models\comment;
use Illuminate\Http\Request; //added
use App\Http\Requests\StorecommentRequest;
use App\Http\Requests\UpdatecommentRequest;
use Auth; //added

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorecommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {
        $request->validate([
            'commentText' => 'required|string|min:3|max:500'
        ]);

        $user_id = Auth::user()->id;
        $newComment = new comment;
        $newComment->text = $request->commentText;
        $newComment->user_created_id = $user_id;
        $newComment->post_id = $post_id;
        $newComment->save();
        return redirect()->route('comments', ['post_id' => $post_id])->with('commentCreatedSuccess','Comment created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($post_id)
    {
        $comments = comment::where('post_id', '=', $post_id)
        ->join('users', 'comments.user_created_id', '=', 'users.id')
        ->select('comments.*', 'users.name AS userName')
        ->latest()->paginate(5);
        return view('comments', compact('comments'))->with('post_id', $post_id)
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatecommentRequest  $request
     * @param  \App\Models\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecommentRequest $request, comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($post_id, $comment_id)
    {
        comment::find($comment_id)->delete();
        return redirect()->route('comments', ['post_id' => $post_id])->with('commentDeletedSuccess','Comment deleted successfully');
    }
}
