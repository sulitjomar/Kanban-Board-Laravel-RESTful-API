<?php

namespace App\Http\Controllers;

use App\Models\KanbanTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KanbanController extends Controller
{
    public function index()
    {
        $tasks = KanbanTask::all();

        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'No tasks found'], 404);
        }

        return response()->json(['data' => $tasks], 200);
    }

    public function show($taskId)
    {
        $task = KanbanTask::find($taskId);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return response()->json(['data' => $task], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $task = KanbanTask::create($request->all());

        return response()->json(['message' => 'Task created successfully'], 201);
    }

    public function update(Request $request, $taskId)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $task = KanbanTask::find($taskId);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->update($request->all());

        return response()->json(['message' => 'Task updated successfully'], 200);
    }

    public function destroy($taskId)
    {
        $task = KanbanTask::find($taskId);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully'], 200);
    }
}