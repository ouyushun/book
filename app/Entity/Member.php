<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $table = "members";
    public $primaryKey = "member_id";
    public $timestamps = false;
}
