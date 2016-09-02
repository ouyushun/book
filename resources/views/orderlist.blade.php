
@extends('master')

@section('title', '我的订单')  <!--两个参数，已经闭合，无需关闭-->

@section('content')
    @if(count($orders) !=0)
    @foreach($orders as $order)
        <div class="weui_cells_title">
            <span>订单号: {{$order->order_no}}</span>

            @if($order->status == 1)
                <span style="float: right;" class="bk_price">
            未支付
          </span>
            @else
                <span style="float: right;" class="bk_important">
            已支付
          </span>
            @endif

        </div>
        <div class="weui_cells">
            @foreach($order->order_items as $order_item)
                <div class="weui_cell">
                    <div class="weui_cell_hd">
                        <img src="{{$order_item->book->preview}}"  style="width:90px;height:120px;" alt="" class="bk_icon">
                    </div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <p class="bk_summary">{{$order_item->book->name}}</p>
                    </div>
                    <div class="weui_cell_ft">
                        <span class="bk_summary">{{$order_item->book->price}}</span>
                        <span> x </span>
                        <span class="bk_important">{{$order_item->count}}</span>
                    </div>
                </div>
            @endforeach
               
        </div>
        <div class="weui_cells_tips" style="text-align: right;">合计: <span class="bk_price">{{$order->total_price}}</span></div>
    @endforeach
    @else
        <p>没有订单</p>
    @endif
@endsection

@section('my-js')
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" charset="utf-8"></script>
    <script type="text/javascript">
       
    </script>
@endsection
