<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'user_created_id',
        'topic_id',
        'image_path'
    ];
}
