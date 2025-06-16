<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Auth::user()->tasks()->latest()->get();

        return $this->sendResponse(true, Response::HTTP_OK, 'Tasks retrieved successfully', $tasks);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, Response::HTTP_BAD_REQUEST, $validator->errors()->first(), 'Validation Error');
        }

        // Check for duplicate title for the same user
        $exists = Auth::user()->tasks()->where('title', $request->title)->exists();

        if ($exists) {
            return $this->sendResponse(false, Response::HTTP_CONFLICT, 'A task with this title already exists.', null);
        }

        $task = Auth::user()->tasks()->create($validator->validated());

        return $this->sendResponse(true, Response::HTTP_CREATED, 'Task created successfully', $task);
    }


    public function show($id)
    {
        $task = Task::find($id);

        if (!$task || $task->user_id !== Auth::id()) {
            return $this->sendResponse(false, Response::HTTP_NOT_FOUND, 'Task not found or unauthorized');
        }

        return $this->sendResponse(true, Response::HTTP_OK, 'Task retrieved successfully', $task);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task || $task->user_id !== Auth::id()) {
            return $this->sendResponse(false, Response::HTTP_NOT_FOUND, 'Task not found or unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, Response::HTTP_BAD_REQUEST, $validator->errors()->first(), 'Validation Error');
        }

        $task->update($validator->validated());

        return $this->sendResponse(true, Response::HTTP_OK, 'Task updated successfully', $task);
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task || $task->user_id !== Auth::id()) {
            return $this->sendResponse(false, Response::HTTP_NOT_FOUND, 'Task not found or unauthorized');
        }

        $task->delete();

        return $this->sendResponse(true, Response::HTTP_OK, 'Task deleted successfully');
    }

    public function searchTask(Request $request)
    {
        $query = Task::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('completed')) {
            $query->where('completed', $request->completed);
        }

        $tasks = $query->get();

        return $this->sendResponse(true, Response::HTTP_OK, 'Search results retrieved successfully.', $tasks);
    }
}
