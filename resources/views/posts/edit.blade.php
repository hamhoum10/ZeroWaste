<!-- resources/views/posts/edit.blade.php -->
@extends('layout')

@section('content')
    <h1>Edit Post</h1>
    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="{{ $post->title }}">
        <br>
        <label for="content">Content:</label>
        <textarea name="content" id="content">{{ $post->content }}</textarea>
        <br>
        <button type="submit">Update Post</button>
    </form>
@endsection
