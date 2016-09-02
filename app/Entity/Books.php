<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    public $table = "books";
    public $primaryKey = "book_id";
    public $timestamps = false;
}
