<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Support\Facades\Auth;;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(){
        $todo = Todo::where("user_id", Auth::id())->orderBy('created_at', 'asc')->get();
        return view('welcome')->with('todos', $todo);
    }

    public function index_api(){
        //$todo = Todo::where("user_id", Auth::id())->orderBy('created_at', 'asc')->get();
        $todo = Todo::paginate(10);
        return $todo;
    }

    public function create(){
        return view('create');
    }

    public function details(Todo $todo){
        return view('details')->with('todos', $todo);
    }

    public function details_api(Todo $todo){
        return $todo;
    }


    public function edit(Todo $todo){

        return view('edit')->with('todos', $todo);

    }
    public function update(Todo $todo){

        try {
            $this->validate(request(), [
                'title' => ['required'],
                'due_date' => ['required'],
                'content' => ['required'],

            ]);
        } catch (ValidationException $e) {
        }

        $data = request()->all();

        $todo->title = $data['title'];
        $todo->due_date = $data['due_date'];
        $todo->content = $data['content'];
        if ($todo->user_id == Auth::id()) {
            $todo->save();
            session()->flash('success', 'Todo updated successfully');
        } else {
            session()->flash('success', 'You do not have permission to delete this.');
        }

        return redirect('/');

    }
    public function delete(Todo $todo){
        $result = $todo->where('user_id',Auth::id())->delete();
        if ($result){
            session()->flash('success', 'Todo updated successfully');
        }else {
            session()->flash('failure', 'You do not have permission to delete this.');
            return redirect('/');
        }

    }

    public function store(){
        try {
            $this->validate(request(), [
                'title' => ['required'],
                'content' => ['required'],
                'due_date' => ['required']
            ]);
        } catch (ValidationException $e) {
        }
        $data = request()->all();
        $todo = new Todo();
        //On the left is the field name in DB and on the right is field name in Form/view
        $todo->user_id = Auth::id();
        $todo->title = $data['title'];
        $todo->content = $data['content'];
        $todo->due_date = $data['due_date'];
        $todo->completed = 0;
        $todo->save();
        return "To do created successfully";
    }

    public function store_api(Request $request)
    {
        try {
            $this->validate(request(), [
                'title' => ['required'],
                'content' => ['required'],
                'due_date' => ['required']
            ]);
        } catch (ValidationException $e) {
        }
        $data = request()->all();
        $todo = new Todo();
        //On the left is the field name in DB and on the right is field name in Form/view
        $newItem = new Todo;
        $newItem->user_id = $todo->user_id = Auth::id();
        $newItem->title = $todo->title = $data['title'];
        $newItem->content = $todo->content = $data['content'];
        $newItem->due_date = $todo->due_date = $data['due_date'];
        $newItem->completed = $todo->completed = 0;
        $todo->save();
        session()->flash('success', 'To do created successfully');

        return $newItem;
    }
}
