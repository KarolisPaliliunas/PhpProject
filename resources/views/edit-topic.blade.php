@extends('layouts.layout')
@section('content') 
            <form method="post" action="{{ route('update-topic', ['topic_id' => $selectedTopic->id]) }}">
            @csrf
            <br><label for ='topicName'>Name</label><br>
            <input type="text" name="topicName" value="{{ $selectedTopic->name }}"></input><br>
            <label for ='topicDescription'>Description</label><br>
            <input type="text" name="topicDescription" value="{{ $selectedTopic->description }}"><br>
            <button type="submit">Save</button>
            </form>
            <br>

            @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    <p>{{ $error }}</p>
                </div>
            @endforeach
            @endif
@endsection