<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

// Imports the Task Eloquent model, which represents rows in the tasks table
// and lets this controller query or change task records, like Task::all() in index().
use App\Models\Task;

// Contains everything the client (Postman) sends,
// including JSON body data and query parameters.
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     * Return every task stored in the database.
     */
    public function index(Request $request)
    {

        // SEARCH AND LIST

        // Fetch every row from the "tasks" table.
        // Or
        // Start a query for rows in the tasks table using the Task model.
        $query = Task::query();

        // If the client sends ?search=value in the URL now being stored in $request,
        // only return rows where the title column contains that value from the client.
        if ($request->search) {
            // Search the "title" column in the tasks table.
            // LIKE '%text%' means the title can contain the search text
            // at the beginning, middle, or end of the title.
            $query->where('title', 'like', '%' . $request->search . '%');
        }


        // SORT
        if ($request->sort == 'due_date') {
            // Sort rows from the tasks table by the due_date column.
            // By default, the earliest due date appears first.
            $query->orderBy('due_date');
        }

        // Run the query.
        // Without search URL query: returns all rows from the tasks table.
        // With search URL query: returns only matching rows from the tasks table.
        return response()->json($query->get(), 201);
    }

    /**
     * STORE A NEWLY CREATED RESOURCE IN STORAGE.
     * $request is A box that contains everything the client (Postman) sent.
     * store() received data from Postman because Postman was sending a JSON body.
     * Laravel stores that data inside the Request object.
     */
    public function store(Request $request)
    {
        // Create a new database row using values from the request sent from Postman (the client).
        $task = Task::create([

            // Get the "title" value from the postman json body request and pass it into the database row column.
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'priority' => $request->priority,
            'category' => $request->category,
        ]);

        // Send this JSON response back to postman that made the request
        // 201 HTTP status codes tell the client whether the request succeeded or failed
        return response()->json([
            'id' => $task->id,
            'message' => 'Task created successfully',
        ], 201);
    }

    /**
     * DISPLAY THE SPECIFIED RESOURCE.
     * Return one task by its ID.
     */
    public function show(string $id)
    {
        // $task is: The row that was found and is about to be changed.
        // Find the database row whose ID matches the URL.
        // If no row exists, Laravel automatically returns 404.
        $task = Task::findOrFail($id);

        // Send the task back as JSON to the client (Postman).
        return response()->json($task, 200);
    }

    /**
     * Update the specified resource in storage.
     * $request is A box that contains everything the client (Postman) sent.
     * 'string' tells PHP the expected data type of the ID.
     * string $id → the ID extracted from the URL.
     *  $id comes from the URL and identifies the database row.
     */
    public function update(Request $request, string $id)
    {
        // Find the task by ID from the URL.
        // $task is: The row that was found and is about to be changed.
        // is the database rows returned as objects.
        // the current existing row NOT yet updated with Postman data objects.
        $task = Task::findOrFail($id);

        // Update the task using data sent by Postman.
        $task->update([
            // Take the title from Postman $request and put it into the database row.
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'priority' => $request->priority,
            'category' => $request->category,
        ]);

        // Send a success message back to the client(Postman).
        return response()->json([
            'message' => 'Task updated successfully',
        ], 200);
    }

    /**
     * DELETE A DATABASE ROW
     * Remove the specified resource from storage.
     * The client only needs to tell Laravel WHICH task or database row to delete.
     * No JSON body is needed because no data is being changed.
     */
    public function destroy(string $id)
    {

        // Find the database row by ID from the URL.
        // $task is the entire database row.
        // $task is the database rows returned as objects.
        // $task is the current existing row NOT yet updated with Postman data objects.
        $task = Task::findOrFail($id);

        // Delete the database row
        $task->delete();

        // Tell the client Postman that the delete succeeded.
        return response()->json([
            'message' => 'Task deleted successfully',
        ], 200);
    }
}
