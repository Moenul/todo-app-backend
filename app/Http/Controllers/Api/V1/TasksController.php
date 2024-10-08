<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth('sanctum')->user()->id;
        
        return TaskResource::collection(Task::where('user_id', $userId)->orderBy('id', 'desc')->get()->load('priority'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'content' => 'required|string|min:3|max:255',
            'user_id' => 'required|exists:users,id',
            'priority_id' => 'nullable|exists:priorities,id'
        ]);

        $task = Task::create($validate);

        $task->load('priority');

        return TaskResource::make($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::where('user_id', auth('sanctum')->user()->id)->findOrFail($id);
        return dd($task);
        $task->load('priority');

        return TaskResource::make($task);
    }

    // public function show(Task $task)
    // {
    //     return TaskResource::make($task);
    // }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $task = Task::findOrFail($id);

        $validate = $request->validate([
            'content' => 'required|string|min:3|max:255',
            'is_completed' => 'boolean',
            'priority_id' => 'nullable|exists:priorities,id'
        ]);
        
        $task->update($validate);
        $task->load('priority');

        return TaskResource::make($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->noContent();
    }

    public function truncate()
    {
        Task::where('user_id', auth('sanctum')->user()->id)->delete();
    }
}
