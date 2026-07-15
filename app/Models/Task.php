<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
    'workspace_id',
    'assigned_to',
    'title',
    'description',
    'status',
    'deliverable_link'
];

public function workspace()
{
    return $this->belongsTo(Workspace::class);
}

public function assignedUser()
{
    return $this->belongsTo(User::class, 'assigned_to');
}
}
