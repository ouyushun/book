<?php

namespace App\Http\Controllers\Service;

use App\Entity\Category;
use Illuminate\Http\Request;
use App\Models\M3Result;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function cateList($parent_id)
    {
        $categories = Category::where('parent_id',$parent_id)->get();
        
        /*$m3_result = new M3Result();
        $m3_result->status = 0;
        $m3_result->categories = $categories;
        return $m3_result->toJson();*/
        
        return $categories;
    }

    

    
}
