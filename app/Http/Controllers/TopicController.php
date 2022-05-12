<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Models\topic;
use App\Models\post;
use Illuminate\Http\Request; //added
use App\Http\Requests\StoretopicRequest;
use App\Http\Requests\UpdatetopicRequest;
use Auth; //added

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = topic::latest()->paginate(5);
        return view('dashboard', compact('topics'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
                
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // \Log::info(json_encode($request->all()));
        return view('create-topic');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoretopicRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //StoretopicRequest $request
    {
        $request->validate([
            'topicName' => 'required|unique:topics,name|string|min:3|max:255'
        ]);

        $user_id = Auth::user()->id;
        $newTopic = new topic;
        $newTopic->name = $request->topicName;
        $newTopic->description = $request->topicDescription;
        $newTopic->user_created_id = $user_id;
        $newTopic->save();
        //\Log::info(json_encode($newTopic->all()));

        return redirect()->route('dashboard')->with('topicCreatedSuccess','Topic created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(topic $topic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit($topic_id)
    {
        $selectedTopic = topic::find($topic_id);
        return view('edit-topic', compact('selectedTopic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatetopicRequest  $request
     * @param  \App\Models\topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(request $request, $topic_id)
    {
        $request->validate([
            'topicName' => 'required|unique:topics,name|string|min:3|max:255'
        ]);
      
        $updateTopicData = topic::find($topic_id);
        $receivedName = $request->topicName;
        $receivedDescription = $request->topicDescription;
        if ($updateTopicData != null){
            if($updateTopicData->name != $request->topicName || $updateTopicData->description != $request->topicDescription){
                $updateTopicData->update(['name'=> $receivedName, 'description' => $receivedDescription]);
                return redirect()->route('dashboard')->with('topicEditedSuccess','Topic edited successfully!');
            }
            else{
                return redirect()->route('dashboard')->with('topicEditedFailNochanges','Topic was not edited: there was no changes!');
            }
        }
        return redirect()->route('dashboard')->with('topicEditedFail','Topic was not edited!}');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy($topic_id)
    {
        post::where('topic_id', '=', $topic_id)->delete();
        topic::find($topic_id)->delete();
        return redirect()->route('dashboard')->with('topicDeletedSuccess','Topic deleted successfully');
    }
}
