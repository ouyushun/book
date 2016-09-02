<?php

namespace App\Http\Controllers\View;
use App\Entity\Books;
use App\Entity\CartItem;
use App\Entity\Member;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class OrderController extends Controller
{
    public function orderCommit(Request $request)
    {
        $member = $request->session()->get('member','');
        $member_id = $member->member_id;
        
        $book_ids = $request->input('book_ids','');
        $book_ids_arr = $book_ids != "" ? explode(',', $book_ids) : array();
        $cart_items = CartItem::where('member_id',$member_id)->whereIn('book_id',$book_ids_arr)->get();
        
        $total_price = 0;
        $cart_items_arr = array();
        foreach($cart_items as $cart_item){
            $book = Books::find($cart_item->book_id);
            $cart_item->book = $book;
            $total_price = $total_price + $book->price * $cart_item->count;
            //array_push($cart_items_arr, $cart_item);
        }
        
        return view('ordercommit',compact('cart_items','total_price'));
    }

    public function orderList(Request $request)
    {
        $member = $request->session()->get('member','');
        $member_id = $member->member_id;
        $orders = Order::where('member_id',$member_id)->get();
        foreach($orders as $order){
            $order_id = $order->id;
            $order_items = OrderItem::where('order_id',$order_id)->get();
            $order->order_items = $order_items;
            foreach ($order_items as $order_item){
                $book_id = $order_item->book_id;
                $book = Books::find($book_id);
                $order_item->book = $book;
                //可以不使用array_push函数。
            }
        }
        return view('orderlist',compact('orders'));
        
    }
}
