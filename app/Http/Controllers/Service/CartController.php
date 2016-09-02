<?php

namespace App\Http\Controllers\Service;

use App\Entity\CartItem;
use App\Models\M3Result;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function addCart(Request $request,$book_id)
    {
        
        //判断是否登录
        $member = $request->session()->get('member','');
        if($member != null){
            $member_id = $member->member_id;
            $cart_items = CartItem::where('member_id', $member_id)->get();
            
            $exist = false;
            foreach ($cart_items as $cart_item) {
                if($cart_item->book_id == $book_id) {
                    $cart_item->count = $cart_item->count + 1;
                    $cart_item->save();
                    
                    $exist = true;
                    break;
                }
            }
            
            if($exist == false) {
                $cart_item = new CartItem;
                $cart_item->book_id = $book_id;
                $cart_item->count = 1;
                $cart_item->member_id = $member->member_id;
                $cart_item->save();
            }
            $m3_result = new M3Result;
            $m3_result->status = 0;
            $m3_result->message = '添加成功';
            return $m3_result->toJson();
        }
        
        //未登录
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = ($bk_cart !=null ? explode(',', $bk_cart) : array())  ;
        $count = 1;
        foreach($bk_cart_arr as &$value){ // 引用传值
            $index = strpos($value,':');
            if($book_id == substr($value, 0,$index)){
                $count = intval(substr($value, ($index+1))) +1;
                $value = $book_id . ':' . $count;
                break;
            }
        }
        
        if($count == 1){
            array_push($bk_cart_arr, $book_id.':'.$count);
        }
        
        $m3_result = new M3Result();
        $m3_result->status = 0;
        $m3_result->message = "购物车添加成功";
        
        return response($m3_result->toJson())->withCookie('bk_cart',implode(',',$bk_cart_arr));
    }

    public function deleteCart(Request $request)
    {

       
        
        
        
        $book_ids = $request->input('book_ids','');
        $book_ids_arr = explode(',', $book_ids);
        
        if($book_ids == ''){
            $m3_result->status = 1;
            $m3_result->message = "未选择要删除的对象";
            return $m3_result->tojson();    
        }
        
        //已登录
        $member = $request->session()->get('member', '');
        if($member != '') {
            CartItem::whereIn('book_id', $book_ids_arr)->delete();

            $m3_result = new M3Result();
            $m3_result->status = 0;
            $m3_result->message = "删除成功";
            return $m3_result->toJson();
        }
        
        // 未登录
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = ($bk_cart !=null ? explode(',', $bk_cart) : array())  ;
        
        foreach($bk_cart_arr as $key =>$value){ 
            $index = strpos($value,':');
            $book_id = substr($value,0,$index);
            if(in_array($book_id, $book_ids_arr)){
                array_splice($bk_cart_arr, $key,1);
                continue;
            }
        }
        $m3_result->status = 0;
        $m3_result->message = "删除成功";
        return response($m3_result->toJson())->withCookie('bk_cart',implode(',',$bk_cart_arr));
    }

    
}
