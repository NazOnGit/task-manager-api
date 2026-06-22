<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// Imports the Task Eloquent model, which represents rows in the tasks table
// and lets this controller query or change task records, like Task::all() in index().
use App\Models\Task;
// Imports Laravel's Request object, which carries incoming API data such as
// JSON body fields, query parameters, headers, and the authenticated user.
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Create a new task in the database using data sent from Postman (the client).
        $task = Task::create([
            // Get the "title" value from the request.
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'priority' => $request->priority,
            'category' => $request->category,
        ]);

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
