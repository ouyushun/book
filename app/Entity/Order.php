<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = "order";
    public $primaryKey = "id";
}
