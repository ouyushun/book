<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $table = "order_item";
    public $primaryKey = "id";
}
