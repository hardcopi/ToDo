@extends('layouts.app')
@section('title')
    Edit Todo
@endsection
@section('content')
    @auth
    <form action="/update/{{$todos->id}}" method="post" class="mt-4 p-4">
        @csrf
        <div class="form-group m-3">
            <label for="title">Todo Name</label>
            <input type="text" class="form-control" value="{{$todos->title}}" name="title">
        </div>
        <div class="form-group m-3">
            <label for="due_date">Due Date</label>
            <input type="date" class="form-control" name="due_date" value="{{$todos->due_date}}">
        </div>
        <div class="form-group m-3">
            <label for="content">Todo Description</label>
            <textarea class="form-control" name="content" rows="3"> {{$todos->content}} </textarea>
        </div>
        <div class="form-group m-3">
            <input type="submit" class="btn btn-primary float-end" value="Submit">
        </div>
    </form>
    @endauth

    @guest
        You must be logged in
    @endguest

@endsection
