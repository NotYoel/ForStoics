@extends('layout')

@section('content')
    <div class="h-screen flex justify-center">
        <div class="self-center h-4/6 w-1/4 flex flex-col mb-12">
            <h1 class="text-center text-white text-3xl mt-4">Editing: <span class="font-semibold">{{$post->title}}</span></h1>
            <form action="/posts/{{$post->id}}" method="POST"  enctype="multipart/form-data" class="flex flex-col self-center w-full font-serif mt-6">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="title" class="text-white text-2xl">Post Title:</label>
                    <input type="text" id="title" name="title" class="w-full h-8 bg-transparent border-2 rounded pl-2 text-white" autocomplete="off" value="{{$post->title}}">
                    @error('title')
                        <p class='text-red-400'>{{$message}}</p>
                    @enderror
                </div>
                

                <div class="mb-6">
                    <label for="content" class="text-white text-2xl">Post Content:</label>
                    <textarea class="whitespace-pre-wrap w-full" name="content" id="content" rows="10">{{$post->content}}</textarea>
                    @error('content')
                        <p class='text-red-400'>{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="text-white text-xl" for="cover_image">Upload a blog cover image (optional):</label>
                    <input class="text-white" type="file" name="cover_image" id="cover_image">
                    @error('cover_image')
                        <p class='text-red-400'>{{$message}}</p>
                    @enderror
                </div>

                <input type="submit" value="Edit Post" class="w-full border-2 rounded h-12 text-white text-xl hover:bg-neutral-700 cursor-pointer">
            </form>
        </div>
    </div>
@endsection