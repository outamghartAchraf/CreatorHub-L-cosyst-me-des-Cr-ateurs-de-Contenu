<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'media_url',
        'media_type'
    ];

    public function user(){
        return $this->belongsTo(User::class);

    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'portfolio_tag');
    }
}
