<?php

namespace App;

use OpenApi\Attributes as OA;

#[OA\Info(
  title: 'Task Manager API',
  version: '1.0.0',
  description: 'REST API for creating, viewing, updating, deleting, searching, sorting, and paginating tasks.'
)]
class OpenApiSpec
{
  // TASKS ENDPOINT: LIST TASKS DOCUMENTATION START
  #[OA\Get(
    path: '/api/tasks',
    summary: 'Get task list',
    description: 'Returns rows from the tasks table. Supports search by title, sorting by due_date or created_at, and pagination. Query parameters can be combined.',
    tags: ['Tasks'],
    parameters: [
      new OA\Parameter(
        name: 'search',
        in: 'query',
        required: false,
        description: 'Return only rows whose title contains the search text.',
        schema: new OA\Schema(type: 'string')
      ),
      new OA\Parameter(
        name: 'sort',
        in: 'query',
        required: false,
        description: 'Sort rows by due_date or created_at.',
        schema: new OA\Schema(
          type: 'string',
          enum: ['due_date', 'created_at'],
          example: 'due_date'
        )
      ),
      new OA\Parameter(
        name: 'page',
        in: 'query',
        required: false,
        description: 'Page number for paginated results.',
        schema: new OA\Schema(type: 'integer', example: 1)
      ),
    ],
    responses: [
      new OA\Response(
        response: 200,
        description: 'Task list returned successfully'
      )
    ]
  )]
  public function listTasksDocumentation()
  {
    // This method is only for Swagger documentation.
    // Laravel does not call this method when handling API requests.
  }
  // TASKS ENDPOINT: LIST TASKS DOCUMENTATION END

  // TASKS ENDPOINT: CREATE TASK DOCUMENTATION START
  #[OA\Post(
    path: '/api/tasks',
    summary: 'Create a new task',
    description: 'Creates a new row in the tasks table using JSON data sent by the client.',
    tags: ['Tasks'],
    requestBody: new OA\RequestBody(
      required: true,
      description: 'Task data sent by the client.',
      content: new OA\JsonContent(
        required: ['title', 'due_date', 'status', 'priority', 'category'],
        properties: [
          new OA\Property(
            property: 'title',
            type: 'string',
            example: 'Learn Laravel'
          ),
          new OA\Property(
            property: 'description',
            type: 'string',
            nullable: true,
            example: 'Complete the task manager API'
          ),
          new OA\Property(
            property: 'due_date',
            type: 'string',
            format: 'date-time',
            example: '2026-06-25 18:00:00'
          ),
          new OA\Property(
            property: 'status',
            type: 'string',
            enum: ['completed', 'not_completed'],
            example: 'not_completed'
          ),
          new OA\Property(
            property: 'priority',
            type: 'string',
            enum: ['low', 'medium', 'high'],
            example: 'high'
          ),
          new OA\Property(
            property: 'category',
            type: 'string',
            example: 'Work'
          ),
        ]
      )
    ),
    responses: [
      new OA\Response(
        response: 201,
        description: 'Task created successfully',
        content: new OA\JsonContent(
          properties: [
            new OA\Property(
              property: 'id',
              type: 'integer',
              example: 1
            ),
            new OA\Property(
              property: 'message',
              type: 'string',
              example: 'Task created successfully'
            ),
          ]
        )
      ),
      new OA\Response(
        response: 422,
        description: 'Validation error'
      ),
    ]
  )]
  public function createTaskDocumentation()
  {
    // This method is only for Swagger documentation.
    // Laravel does not call this method when creating tasks.
  }
  // TASKS ENDPOINT: CREATE TASK DOCUMENTATION END

  // TASKS ENDPOINT: GET TASK BY ID DOCUMENTATION START
  #[OA\Get(
    path: '/api/tasks/{id}',
    summary: 'Get one task by ID',
    description: 'Returns one row from the tasks table using the ID from the URL.',
    tags: ['Tasks'],
    parameters: [
      new OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'ID of the task row to retrieve.',
        schema: new OA\Schema(type: 'integer', example: 1)
      ),
    ],
    responses: [
      new OA\Response(
        response: 200,
        description: 'Task returned successfully',
        content: new OA\JsonContent(
          properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: 'Learn Laravel'),
            new OA\Property(property: 'description', type: 'string', example: 'Complete the task manager API'),
            new OA\Property(property: 'due_date', type: 'string', example: '2026-06-25 18:00:00'),
            new OA\Property(property: 'status', type: 'string', example: 'not_completed'),
            new OA\Property(property: 'priority', type: 'string', example: 'high'),
            new OA\Property(property: 'category', type: 'string', example: 'Work'),
            new OA\Property(property: 'created_at', type: 'string', example: '2026-06-25T08:00:00.000000Z'),
            new OA\Property(property: 'updated_at', type: 'string', example: '2026-06-25T08:00:00.000000Z'),
          ]
        )
      ),
      new OA\Response(
        response: 404,
        description: 'Task not found'
      ),
    ]
  )]
  public function getTaskByIdDocumentation()
  {
    // This method is only for Swagger documentation.
    // Laravel does not call this method when returning one task.
  }
  // TASKS ENDPOINT: GET TASK BY ID DOCUMENTATION END

  // TASKS ENDPOINT: UPDATE TASK BY ID DOCUMENTATION START
  #[OA\Put(
    path: '/api/tasks/{id}',
    summary: 'Update a task by ID',
    description: 'Updates one row in the tasks table using the ID from the URL and JSON data sent by the client.',
    tags: ['Tasks'],
    parameters: [
      new OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'ID of the task row to update.',
        schema: new OA\Schema(type: 'integer', example: 1)
      ),
    ],
    requestBody: new OA\RequestBody(
      required: true,
      description: 'Updated task data sent by the client.',
      content: new OA\JsonContent(
        required: ['title', 'due_date', 'status', 'priority', 'category'],
        properties: [
          new OA\Property(property: 'title', type: 'string', example: 'Learn Laravel API'),
          new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Update task endpoint completed'),
          new OA\Property(property: 'due_date', type: 'string', format: 'date-time', example: '2026-06-26 18:00:00'),
          new OA\Property(property: 'status', type: 'string', enum: ['completed', 'not_completed'], example: 'completed'),
          new OA\Property(property: 'priority', type: 'string', enum: ['low', 'medium', 'high'], example: 'medium'),
          new OA\Property(property: 'category', type: 'string', example: 'Work'),
        ]
      )
    ),
    responses: [
      new OA\Response(
        response: 200,
        description: 'Task updated successfully',
        content: new OA\JsonContent(
          properties: [
            new OA\Property(property: 'message', type: 'string', example: 'Task updated successfully'),
          ]
        )
      ),
      new OA\Response(
        response: 404,
        description: 'Task not found'
      ),
      new OA\Response(
        response: 422,
        description: 'Validation error'
      ),
    ]
  )]
  public function updateTaskDocumentation()
  {
    // This method is only for Swagger documentation.
    // Laravel does not call this method when updating tasks.
  }
  // TASKS ENDPOINT: UPDATE TASK BY ID DOCUMENTATION END

  // TASKS ENDPOINT: DELETE TASK BY ID DOCUMENTATION START
  #[OA\Delete(
    path: '/api/tasks/{id}',
    summary: 'Delete a task by ID',
    description: 'Deletes one row from the tasks table using the ID from the URL.',
    tags: ['Tasks'],
    parameters: [
      new OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'ID of the task row to delete.',
        schema: new OA\Schema(type: 'integer', example: 1)
      ),
    ],
    responses: [
      new OA\Response(
        response: 200,
        description: 'Task deleted successfully',
        content: new OA\JsonContent(
          properties: [
            new OA\Property(
              property: 'message',
              type: 'string',
              example: 'Task deleted successfully'
            ),
          ]
        )
      ),
      new OA\Response(
        response: 404,
        description: 'Task not found'
      ),
    ]
  )]
  public function deleteTaskDocumentation()
  {
    // This method is only for Swagger documentation.
    // Laravel does not call this method when deleting tasks.
  }
  // TASKS ENDPOINT: DELETE TASK BY ID DOCUMENTATION END

}
