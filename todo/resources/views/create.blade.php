@extends('layouts.app')

@section('title')
    Create Todo
@endsection

@section('content')

    <form action="{{ route('store') }}" method="post" class="mt-4 p-4">
        @csrf
        <div class="form-group m-3">
            <label for="title">Todo Name</label>
            <input type="text" class="form-control" name="title">
        </div>
        <div class="form-group m-3">
            <label for="due_date">Due Date</label>
            <input type="date" class="form-control" name="due_date">
        </div>
        <div class="form-group m-3">
            <label for="content">Todo Description</label>
            <textarea class="form-control" name="content" rows="3"></textarea>
        </div>
        <div class="form-group m-3">
            <input type="submit" class="btn btn-primary float-end" value="Submit">
        </div>
    </form>

@endsection
