
@extends('master')

@section('title', '订单提交')  <!--两个参数，已经闭合，无需关闭-->

@section('content')
    <div class="page bk_content" style="top: 0;">
        <div class="weui_cells">
            @foreach($cart_items as $cart_item)
                <div class="weui_cell">
                    <div class="weui_cell_hd">
                        <img src="{{$cart_item->book->preview}}" style="width:90px;height:120px;" alt="" class="bk_icon">
                    </div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <p class="bk_summary">{{$cart_item->book->name}}</p>
                    </div>
                    <div class="weui_cell_ft">
                        <span class="bk_important">{{$cart_item->count}}</span>
                        <span> x </span>
                        <span class="bk_price">￥{{$cart_item->book->price}}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="weui_cells_title">支付方式</div>
        <div class="weui_cells">
            <div class="weui_cell weui_cell_select">
                <div class="weui_cell_bd weui_cell_primary">
                    <select class="weui_select" name="payway">
                        <option selected="" value="1">支付宝</option>
                        <option value="2">微信</option>
                    </select>
                </div>
            </div>
        </div>

        <form action="/service/alipay" id="alipay" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="total_price" value="{{$total_price}}" />
            <input type="hidden" name="name" value="" />
            <input type="hidden" name="order_no" value="" />
        </form>

        <div class="weui_cells">
            <div class="weui_cell">
                <div class="weui_cell_bd weui_cell_primary">
                    <p>总计:</p>
                </div>
                <div class="weui_cell_ft bk_price" style="font-size: 25px;">￥ {{$total_price}}</div>
            </div>
        </div>
    </div>
    <div class="bk_fix_bottom">
        <div class="bk_btn_area">
            <button class="weui_btn weui_btn_primary" onclick="_onPay();">提交订单</button>
        </div>
    </div>

@endsection

@section('my-js')
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" charset="utf-8"></script>
    <script type="text/javascript">
       
    </script>
@endsection
