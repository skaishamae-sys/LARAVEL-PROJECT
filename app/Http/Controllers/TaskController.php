<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'due_date' => 'required|date',
        ]);

        Task::create($request->all());

        return response('', 302)
            ->header('Location', '/tasks');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'task_name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'due_date' => 'required|date',
        ]);

        $task->update($request->all());

        return response('', 302)
            ->header('Location', '/tasks');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response('', 302)
            ->header('Location', '/tasks');
    }
}