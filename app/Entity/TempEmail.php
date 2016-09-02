<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class TempEmail extends Model
{
    public $table = "temp_email";
    public $primaryKey = "id";
    public $timestamps = false;
}
