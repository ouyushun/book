<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Books;
use App\Entity\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Order;
use App\Models\M3Result;

class OrderController extends Controller
{
  public function toOrder(Request $request)
  {
    $orders = Order::all();
    return view('admin.order')->with('orders', $orders);
  }

  public function toOrderEdit(Request $request)
  {
    $order = Order::find($request->input('id', ''));
    return view('admin.order_edit')->with('order', $order);
  }

  
  public function orderEdit(Request $request)
  {
    $order = Order::find($request->input('id', ''));
    $order->status = $request->input('status', 1);
    $order->save();

    $m3_result = new M3Result;
    $m3_result->status = 0;
    $m3_result->message = '添加成功';

    return $m3_result->toJson();
  }

    public function orderInfo(Request $request)
    {
        $id = $request->input('id', '');
        $items = OrderItem::where('order_id',$id)->get();
        $book = Books::find($id);
        foreach ($items as $item){
            $item->book = $book;
        }
        return view('admin/order_info')->with('items',$items);
    }
}
