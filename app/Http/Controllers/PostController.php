<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\comment;
use Illuminate\Http\Request; //added
use App\Http\Requests\StorepostRequest;
use App\Http\Requests\UpdatepostRequest;
use Auth; //added

class PostController extends Controller
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
    public function create($topic_id)
    {
        return view('create-post')->with('topic_id', $topic_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $topic_id)
    {
        $request->validate([
            'postName' => 'required|string|min:3|max:255'
        ]);

        $user_id = Auth::user()->id;
        $newPost = new post;
        $newPost->name = $request->postName;
        $newPost->description = $request->postDescription;
        $newPost->user_created_id = $user_id;
        $newPost->topic_id = $topic_id;
        //$receivedImage = $request->postImage;

        if($request->hasFile('postImage'))
        {
            $imageName = time()."-".$request->postName.".".$request->postImage->extension();
            $test = $request->postImage;
            $test->move(public_path('images'), $imageName);
            //$image = $request->file('postImage')->store('resources/images');
            //$filename = $request->file('postImage')->hashName();
            $newPost->image_path = $imageName;
        }

        $newPost->save();
        return redirect()->route('posts', ['topic_id' => $topic_id])->with('postCreatedSuccess','Post created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($topic_id)
    {
        $posts = post::where('topic_id', '=', $topic_id)
        ->join('users', 'posts.user_created_id', '=', 'users.id')
        ->select('posts.*', 'users.name AS userName')
        ->latest()->paginate(5);
        return view('posts', compact('posts'))->with('topic_id', $topic_id)
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($topic_id, $post_id)
    {
        $selectedPost = post::find($post_id);
        return view('edit-post', compact('selectedPost'))->with('topic_id', $topic_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepostRequest  $request
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $topic_id, $post_id)
    {
        $request->validate([
            'postName' => 'required|string|min:3|max:255'
        ]);

        $updatePostData = post::find($post_id);
        $receivedName = $request->postName;
        $receivedDescription = $request->postDescription;
        $receivedImage = $request->postImage;
        if ($updatePostData != null){
            if($updatePostData->name != $receivedName || $updatePostData->description !=  $receivedDescription || $receivedImage != null){
                if($request->hasFile('postImage'))
                {
                    $imageName = time()."-".$receivedName.".".$receivedImage->extension();
                    $test = $request->postImage;
                    $test->move(public_path('images'), $imageName);
                    $updatePostData->update(['name'=> $receivedName, 'description' => $receivedDescription, 'image_path' => $imageName]);
                }else{
                    $updatePostData->update(['name'=> $receivedName, 'description' => $receivedDescription]);
                }
                return redirect()->route('posts', ['topic_id' => $topic_id])->with('postEditedSuccess','Post edited successfully!');
            }
            else{
                return redirect()->route('posts', ['topic_id' => $topic_id])->with('postEditedFailNochanges','Post was not edited: there was no changes!');
            }
        }
        return redirect()->route('posts', ['topic_id' => $topic_id])->with('postEditedFail','Post was not edited!}');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($topic_id, $post_id)
    {
        comment::where('post_id', '=', $post_id)->delete();
        post::find($post_id)->delete();
        return redirect()->route('posts', ['topic_id' => $topic_id])->with('postDeletedSuccess','Post deleted successfully');
    }
}
