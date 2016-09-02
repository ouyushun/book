<?php

namespace App\Http\Controllers\View;
use App\Entity\Books;
use App\Entity\CartItem;
use App\Entity\Category;
use App\Entity\PdtImage;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class BookController extends Controller
{
    public function category()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('category',compact('categories'));
    }

    public function bookList($category_id)
    {
        $books = Books::where('category_id',$category_id)->get();
        return view('booklist',compact('books'));
    }

    public function toproduct(Request $request,$book_id)
    {
        $book = Books::find($book_id);
        $product = Product::where("book_id",$book_id)->first();
        $pdt_images = PdtImage::where('book_id',$book_id)->get();
        //已登录
        $member = $request->session()->get('member','');
        if($member != null) {
            $member_id = $member->member_id;
            $cart_items = CartItem::where('member_id', $member_id)->get();
            $cart_item = CartItem::where('book_id',$book_id)->first();
            if($cart_item == null){
                $count = 0;
            }else{
                $count = $cart_item->count;
            }
            return view('product',compact('product','book','pdt_images','count'));
        }    


            //从cookie中查找购物车内的商品信息
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = ($bk_cart !=null ? explode(',', $bk_cart) : array())  ;
        $count = 0;
        foreach($bk_cart_arr as $value){ // 引用传值
            $index = strpos($value,':');
            if($book_id == substr($value, 0,$index)){
                $count = (int)substr($value, $index+1);
                break;
            }
        }
        
        return view('product',compact('product','book','pdt_images','count'));
    }
    
}
