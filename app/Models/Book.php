<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //use HasFactory;
    protected $fillable = [
        'work_id',
        'title',
        'authors',
        'cover_url',
        'description',
        'published_year',
    ];

    public function buyers()
    {
        return $this->belongsToMany(User::class);
    }
}
