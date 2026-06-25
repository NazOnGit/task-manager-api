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
     * BUILDING A QUERY
     * Display a listing of the resource.
     * Return every task stored in the database.
     */
    public function index(Request $request)
    {



        // Fetch every row from the "tasks" table.
        // Or
        // Start a query for rows in the tasks table using the Task model.
        $query = Task::query();

        // SEARCH
        // If the client sends ?search=value in the URL now being stored in $request,
        // only return rows where the title column contains that value from the client.
        if ($request->search) {
            // Search the "title" column in the tasks table.
            // LIKE '%text%' means the title can contain the search text
            // at the beginning, middle, or end of the title.
            $query->where('title', 'like', '%' . $request->search . '%');
        }


        // SORT
        // Client examples: GET /api/tasks?sort=due_date or GET /api/tasks?sort=created_at
        // Laravel exposes that query value as $request->sort.
        // When a valid column is provided, apply it to the query ordering.
        if ($request->sort === 'due_date' || $request->sort === 'created_at') {


            // Use the sort value sent from Postman only if it matches
            // one of the allowed database columns: due_date or created_at
            // 
            // This decides which column Laravel uses to order
            // the rows returned from the tasks table.
            $query->orderBy($request->sort);
        }

        // Run the query.
        // Without search URL query from postman client: returns all rows from the tasks table.
        // With search URL query from postman client: returns only matching rows from the tasks table.
        // return response()->json($query->get(), 201);


        // PAGINATE():
        // Return rows from the tasks table in pages instead of all at once.
        // paginate(2) means return 2 rows per page.
        //
        // The client (Postman) chooses WHICH page by sending ?page=1, ?page=2, etc. in the URL.
        // Laravel automatically reads that page number from the URL and retrieves
        // only the corresponding number of rows from the tasks table,
        // using the number passed to paginate().
        return response()->json($query->paginate(2), 200);
    }

    /**
     * STORE A NEWLY CREATED RESOURCE IN STORAGE.
     * $request is A box that contains everything the client (Postman) sent.
     * store() received data from Postman because Postman was sending a JSON body.
     * Laravel stores that data inside the Request object.
     */
    public function store(Request $request)
    {
        /**
         * VALIDATION RULES FOR STORE()
         * 
         * Validate the JSON body before creating a new row in the tasks table.
         * If any rule fails, Laravel automatically stops here and returns a 422 validation error to Postman.
         */
        $validateData = $request->validate([
            // Title is required because every task must have a name.
            // string means the value must be text.
            // max:255 matches the database column limit from the migration.
            'title' => 'required|string|max:255',

            // Description can be empty.
            // nullable means the client may send null or skip this field.
            // string means if it is sent, it must be text.
            'description' => 'nullable|string',

            // Due date is required because the assignment says every task has a deadline.
            // date means Laravel must be able to understand it as a valid date/time.
            'due_date' => 'required|date',

            // Status is required.
            // in: means only these exact values are allowed.
            'status' => 'required|in:completed,not_completed',

            // Priority is required.
            // Only low, medium, or high are allowed.
            'priority' => 'required|in:low,medium,high',

            // Category is required because every task should belong to a group.
            // max:255 keeps it compatible with the database string column.
            'category' => 'required|string|max:255',
        ]);



        // Create a new database row using only the validated data.
        // This protects the database from invalid or unexpected request values.

        $task = Task::create($validateData);


        /** 
         * UNSANITIZED VERSION
         * 
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
         */


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
     * UPDATE SPECIFIC RESOURCE OR ID IN STORAGE.
     * 
     * $request is A box that contains everything the client (Postman) sent.
     * 'string' tells PHP the expected data type of the ID.
     * string $id → the ID extracted from the URL.
     *  $id comes from the URL and identifies the database row.
     */
    public function update(Request $request, string $id)
    {
        // Find the task by ID from the URL.
        // $task is: The row that was found and is about to be changed.
        // $task is the database rows returned as objects.
        // the current existing row NOT yet updated with Postman data objects.
        $task = Task::findOrFail($id);

        // Update the task using data sent by Postman.
        $validatedData = $request->validate([
            // Title is required and must fit the database string column.
            'title' => 'required|string|max:255',

            // Description is optional, but if sent, it must be text.
            'description' => 'nullable|string',

            // Due date must be a valid date/time value.
            'due_date' => 'required|date',

            // Status must be one of the values allowed by our database enum.
            'status' => 'required|in:completed,not_completed',

            // Priority must be one of the values allowed by our database enum.
            'priority' => 'required|in:low,medium,high',

            // Category is required and must fit the database string column.
            'category' => 'required|string|max:255',
        ]);

        // Update the row using only validated values from Postman.
        $task->update($validatedData);

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
