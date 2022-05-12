@extends('layouts.layout')
 
<x-app-layout>
    <x-slot name="header">
    </x-slot>   
</x-app-layout>

@section('content')
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Comments</h2>
            </div>
        </div>
    </div>

    @if ($message = Session::get('commentCreatedSuccess'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('commentDeletedSuccess'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

        <table class="table table-bordered">
        <tr>
            <th>Text</th>
            <th>User Created</th>
            <th>Created at</th>
        </tr>
    @foreach ($comments as $comment)
    <form action="{{ route('delete-comment', ['post_id' => $post_id, 'comment_id' => $comment->id]) }}" method="post">
    @csrf
    <tr href="">
            <td>{{ $comment->text }}</td>
            <td>{{ $comment->userName }}</td>
            <td>{{ $comment->created_at }}</td>
    <td>
    @if ($comment->user_created_id == Auth::user()->id || Auth::user()->is_admin == 1)
   <button type="submit" class="btn btn-danger">Delete comment</button>
   @endif
</td>
</tr>
</form>
@endforeach
</table>

{{ $comments->links('pagination::bootstrap-4') }}

<div class="pull-left" style="width:50%">
    <form action="{{ route('store-comment', ['post_id' => $post_id]) }}" method="post">
        @csrf
        <label for="commentText">New Comment</label><br>
        <textarea name="commentText" style="max-height:200px;width:100%;height:100px"></textarea>
        <br>
        <button type="submit" class="btn btn-success">Write a comment</button>
    </form>

    <br>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger">
        <p>{{ $error }}</p>
    </div>
    @endforeach
@endif

</div>

@endsection