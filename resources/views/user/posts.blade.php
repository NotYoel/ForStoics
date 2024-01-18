@extends('layout')

@section('content')
    <div class="flex flex-col gap-24 items-center mb-12">
        <h1 class="text-white font-bold text-5xl">{{$user->name}}'s Posts</h1>
        <div class="px-32 flex justify-center flex-wrap gap-8">
            @foreach ($user->posts->sortByDesc('updated_at') as $post)
                <div class="w-64 h-64 border-2 border-black rounded-lg">
                    <a href="/posts/{{$post->id}}">
                        <img class="border-b-2 border-black rounded-lg rounded-b-none" src="{{asset('website_images/no-photo-available.png')}}" alt="No Photo Available">
                    </a>
                    
                    <div class="flex flex-col justify-center items-center">
                        <a href="/posts/{{$post->id}}"><h1 class="text-white text-center font-bold text-xl">{{$post->title}}</h1></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection