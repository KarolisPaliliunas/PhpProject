@extends('layouts.layout')
@section('content') 
            <form method="post" enctype="multipart/form-data" action="{{ route('update-post', ['topic_id' => $topic_id, 'post_id' => $selectedPost->id]) }}">
            @csrf
            <br><label for ='postName'>Name</label><br>
            <input type="text" name="postName" value="{{ $selectedPost->name }}"></input><br>
            <label for ='postDescription'>Description</label><br>
            <input type="text" name="postDescription" value="{{ $selectedPost->description }}"><br>
            <label for ='postImage'>Image</label><br>
            <input type="file" name="postImage" accept="image/*"><br><br>
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