<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'rating',
        'comments',
        'user_show',
        'is_delete'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}
