<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    protected $fillable = [
        'creator_id',
        'title',
        'description'
    ];
    
    public function creator()
{
    return $this->belongsTo(User::class, 'creator_id');
}

public function tasks()
{
    return $this->hasMany(Task::class);
}

public function members()
{
    return $this->belongsToMany(
        User::class,
        'workspace_members'
    );
}
}
