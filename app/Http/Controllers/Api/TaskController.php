<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with([
            'workspace',
            'assignedUser'
        ])->latest()->get();

        return response()->json($tasks);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $task = Task::create([
            'workspace_id' => $request->workspace_id,
            'assigned_to' => $request->assigned_to,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'todo',
        ]);

        return response()->json([
            'message' => 'Task created successfully',
            'data' => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load([
            'workspace',
            'assignedUser'
        ]);

        return response()->json($task);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->update([
            'assigned_to' => $request->assigned_to,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'deliverable_link' => $request->deliverable_link,
        ]);

        return response()->json([
            'message' => 'Task updated successfully',
            'data' => $task
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully'
        ]);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:todo,in_progress,review,validated'
        ]);

        $task->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Task status updated',
            'data' => $task
        ]);
    }

    public function submitDeliverable(Request $request, Task $task)
    {
        $request->validate([
            'deliverable_link' => 'required|url'
        ]);

        $task->update([
            'deliverable_link' => $request->deliverable_link,
            'status' => 'review'
        ]);

        return response()->json([
            'message' => 'Deliverable submitted successfully',
            'data' => $task
        ]);
    }
}
