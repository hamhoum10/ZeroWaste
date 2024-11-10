<!-- resources/views/posts/show.blade.php -->
@extends('layout')

@section('content')
    <h1>{{ $post->title }}</h1>
    <h1>{{ $post->id }}</h1>
    <p>{{ $post->content }}</p>
    <a href="{{ route('posts.index') }}">Back to Posts</a>
@endsection

