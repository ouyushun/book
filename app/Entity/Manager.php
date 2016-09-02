<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    public $table = "manager";
    public $primaryKey = "id";
    public $timestamps = false;
}
