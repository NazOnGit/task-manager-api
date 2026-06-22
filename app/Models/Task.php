<?php
// The model represents one row inside that table.
// Model represents the table created in migrations and defines which fields can be crud upon.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // Tell Laravel which fields are allowed to be inserted/CRUD upon by TaskController.

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
        'priority',
        'category',
    ];
}
