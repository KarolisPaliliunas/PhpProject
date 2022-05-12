@extends('layouts.layout')
<x-app-layout>
    <x-slot name="header">
    </x-slot>    
</x-app-layout>


@section('content') 

<br><br>
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Topics</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('create-topic') }}"> Create New Topic</a>
            </div>
        </div>
    </div>
<!--MESSAGES-->
    @if ($message = Session::get('topicCreatedSuccess'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('topicEditedSuccess'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('topicEditedFail'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('topicEditedFailNochanges'))
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('topicDeletedSuccess'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
<!--ENDOFMESSAGES-->
        <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Description</th>
        </tr>
        @foreach ($topics as $topic)
    <form action="{{ route('delete-topic', ['topic_id' => $topic->id]) }}" method="post">
    <tr href="">
            <td>{{ $topic->name }}</td>
            <td>{{ $topic->description }}</td>
    <td>
    @csrf
   <a class="btn btn-info" href="{{ route('posts', ['topic_id' => $topic->id]) }}">Show posts</a>
   @if ($topic->user_created_id == Auth::user()->id || Auth::user()->is_admin == 1)
   <a class="btn btn-primary" href="{{ route('edit-topic', ['topic_id' => $topic->id]) }}">Edit topic</a>

   <button type="submit" class="btn btn-danger">Delete topic</button>
   @endif
</td>
</tr>
</form>
@endforeach
</table>

{{ $topics->links('pagination::bootstrap-4') }}

@endsection