@extends('layout')

@section('content')
    <div class="min-h-screen max-h-content mb-8">
        <div class="w-full flex flex-col pt-4 px-48 font-serif">
            <h1 class="text-center text-white text-5xl mb-4 font-semibold">{{$post->title}}</h1>
            <img src="{{$post->cover_image ? asset('storage/' . $post->cover_image) : asset('website_images/no-photo-available.png')}}"  alt="" class="w-1/3 self-center mb-4">
            <div class="mb-4 flex justify-between items-center">
                <p class="text-white flex gap-2">
                    Created By: 
                    <span class="inline-block h-6 w-6 rounded-full border-2">
                        <a href="/user/{{$post->user->id}}"><img
                            class="h-full w-full rounded-full"
                            src="{{$post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : asset('website_images/default-profile-picture.png')}}" 
                            alt="User Profile Picture"
                            >
                        </a>
                    </span> <a class="font-bold" href="/user/{{$post->user->id}}">{{$post->user->name}}</a>
                </p>
    
                <div class="text-white flex gap-4">
                    <div class="flex gap-4">
                        <form action="/posts/{{$post->id}}/like" method="POST">
                            @csrf
                            <span class="@if(auth()->check() && auth()->user()->hasLiked($post)) text-amber-400 @endif">
                                <button type="submit"><i class="fa-solid fa-thumbs-up"></i></button>
                                {{count($post->likes)}}
                            </span>
                        </form>
                    </div>
                    
                    <!-- If they're the owner of the blog page !-->
                    @if (auth()->check() && auth()->user()->id == $post->user->id)
                        <a href="/posts/{{$post->id}}/edit"><i class='bx bxs-edit text-xl'></i></a>
                        <form action="/posts/{{$post->id}}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button><a href="/posts/{{$post->id}}"><i class='bx bx-trash text-xl'></i></a></button>
                        </form>
                    @endif
                </div>
    
            </div>
            <div class="w-full border bg-neutral-600"></div>
            <div class=" pt-8 text-white text-lg leading-7">
                <p class="break-words w-full">
                    @php
                        echo nl2br($post->content, false);
                    @endphp
                </p>
            </div>
        </div>
    </div>
@endsection