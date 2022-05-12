@extends('layouts.layout')

<x-app-layout>
    <x-slot name="header">
    </x-slot>
</x-app-layout>

@section('content')
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Posts</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('create-post', ['topic_id' => $topic_id]) }}"> Create New Post</a>
            </div>
        </div>
    </div>

<!--MESSAGES-->
    @if ($message = Session::get('postCreatedSuccess'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('postEditedSuccess'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('postEditedFailNochanges'))
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('postEditedFail'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('postDeletedSuccess'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
<!--ENDOFMESSAGES-->

        <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th>User Created</th>
            <th>Image</th>
        </tr>
        @foreach ($posts as $post)
    <form action="{{ route('delete-post', ['topic_id' => $topic_id, 'post_id' => $post->id]) }}" method="post">
    <tr href="">
            <td>{{ ++$i }}</td>
            <td>{{ $post->name }}</td>
            <td>{{ $post->description }}</td>
            <td>{{ $post->userName }}</td>
            @if ($post->image_path)
            <td><img src="{{ asset('images/'.$post->image_path) }}" alt="" width="100" height="100" class="img-rounded"></img><td>
            @else
            <td><img src="{{ asset('images/no-image.png') }}" alt="" width="100" height="100" class="img-rounded"></img><td>
            @endif
    <td>
    @csrf
   <a class="btn btn-info" href="{{ route('comments', ['post_id' => $post->id]) }}">Show comments</a>
   @if ($post->user_created_id == Auth::user()->id || Auth::user()->is_admin == 1)
   <a class="btn btn-primary" href="{{ route('edit-post', ['topic_id' => $topic_id, 'post_id' => $post->id]) }}">Edit post</a>
   <button type="submit" class="btn btn-danger">Delete post</button>
   @endif
</td>
</tr>
</form>
@endforeach
</table>

{{ $posts->links('pagination::bootstrap-4') }}

@endsection