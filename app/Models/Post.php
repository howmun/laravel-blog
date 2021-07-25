<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    # all other fields can be mass assignment
    protected $guarded = ['id'];
    # only these fiedls can be mass assigment
    // protected $fillable = ['title', 'excerpt', 'body']
    # completely disable mass assignment
    // protected $guarded = [];

    public function category()
    {
        return $this->belongsTo((Category::class));
    }
}
