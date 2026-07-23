<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function portfolio(){
        return $this->belongsToMany(portfolio::class, 'portfolio_tag');
    }
}
