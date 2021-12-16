@extends('layouts.app')

@section('title')
    Details
@endsection

@section('content')
    @auth
    <div class="card text-center mt-5">
        <div class="card-header">
            <b>TODO DETAILS</b>
        </div>
        @auth
            @if ($todos->user_id == Auth::id())
                <div class="card-body">
                    <h5 class="card-title">{{$todos->title}}</h5>
                    <p class="card-text">
                        Due Date: {{$todos->due_date}}<br><br>
                        {{$todos->content}}
                    </p>
                    <a href="/edit/{{$todos->id}}"><span class="btn btn-primary">Edit</span></a>
                    <a href="/delete/{{$todos->id}}"><span class="btn btn-danger">Delete</span></a>
                </div>
            @else
                <div class="alert alert-danger mt-5">
                    You do not have permission to delete this.
                </div>
            @endif
        @endauth
        @guest
            You must be logged in
        @endguest
    </div>
    @endauth
    @guest
        You must be logged in
    @endguest

@endsection
