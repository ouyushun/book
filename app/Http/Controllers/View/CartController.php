<?php

namespace App\Http\Controllers\View;
use App\Entity\Books;
use App\Entity\CartItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class CartController extends Controller
{
    public function cartView(Request $request)
    {
        
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = ($bk_cart !=null ? explode(',', $bk_cart) : array())  ;
        $cart_items = Array();

        //判断是否登录
        $member = $request->session()->get('member','');
        if($member != null){
            $member_id = $member->member_id;
            $cart_items = $this->syncCart($member_id,$bk_cart_arr);
            return response()->view('cartview',compact('cart_items'))->withCookie('bk_cart',null);
        }
        
        foreach($bk_cart_arr as $key=> $value){ // 引用传值
            $index = strpos($value,':');
            $book_id = intval(substr($value, 0,$index));
            $count = intval(substr($value, ($index+1)));
            
            
            $cart_item = new CartItem();
            $cart_item->book_id = $book_id;
            $cart_item->count = $count;
            $book = Books::find($book_id);
            $cart_item->book = $book;
            
            array_push($cart_items, $cart_item);
        }
        
        return view('cartview',compact('cart_items'));
    }

    private function syncCart($member_id, $bk_cart_arr)
    {
        $cart_items = CartItem::where('member_id', $member_id)->get();

        $cart_items_arr = array();
        foreach ($bk_cart_arr as $value) {
            $index = strpos($value, ':');
            $book_id = substr($value, 0, $index);
            $count = (int) substr($value, $index+1);

            // 判断离线购物车中product_id 是否存在 数据库中
            $exist = false;
            foreach ($cart_items as $temp) {
                if($temp->book_id == $book_id) {
                    if($temp->count < $count) {
                        $temp->count = $count;
                        $temp->save();
                    }
                    $exist = true;
                    break;
                }
            }

            // 不存在则存储进来
            if($exist == false) {
                $cart_item = new CartItem;
                $cart_item->member_id = $member_id;
                $cart_item->book_id = $book_id;
                $cart_item->count = $count;
                $cart_item->save();
                
                $book = Books::find($book_id);
                $cart_item->book = $book;

                array_push($cart_items_arr, $cart_item);
                
            }
        }
        // 为其余的（）对象附加产品对象便于显示
        foreach ($cart_items as $cart_item) {
            $book_id = $cart_item->book_id;
            $book = Books::find($book_id);
            $cart_item->book = $book;
            array_push($cart_items_arr, $cart_item);
        }
        return $cart_items_arr;
    }
}
