<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public $table = "cart_item";
    public $primaryKey = "id";
    public $timestamps = false;

}
