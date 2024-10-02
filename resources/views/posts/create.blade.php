<!-- resources/views/posts/create.blade.php -->
@extends('layouts/contentNavbarLayout')

@section('content')
    <h1>Create Post</h1>
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <label for="title">Title:</label>
        <input type="text" name="title" id="title">
        <br>
        <label for="content">Content:</label>
        <textarea name="content" id="content"></textarea>
        <br>
        <button type="submit">Create Post</button>
    </form>
@endsection
