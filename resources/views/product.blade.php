@extends('master')
@section('title',$book->name)  <!--两个参数，已经闭合，无需关闭-->

@section('content')
<div class="page bk_content" style="top: 0;">
    <!--轮播图代码-->
    <link href="{{asset('css/swipe.css')}}" rel="stylesheet" type="text/css" />
    <div class="addWrap">
        <div class="swipe" id="mySwipe">
            <div class="swipe-wrap">
                @foreach($pdt_images as $pdt_image)
                    <div>
                        <a href="javascript:"><img class="img-responsive" src="{{$pdt_image->image_path}}" /></a>
                    </div>
                @endforeach
            </div>
        </div>
        <ul id="position">
            @foreach($pdt_images as $index => $pdt_image)
                <li class={{$index == 0 ? 'cur' : ''}}></li>
            @endforeach
        </ul>
    </div>
    <!--轮播图结束-->
    
    <div class="weui_cells_title">
              <span class="bk_title">{{$book->name}}</span>
              <span class="bk_price">￥{{$book->price}}</span>
    </div>
    <div class="weui_cells">
         <p class="bk_summary">{{$book->summary}}</p>
    </div>
    <div class="weui_cells_title">书籍详情</div>
        <div class="weui_cells">
            @if($product != null)
            <p class="bk_content">{!! $product->pdt_content !!}</p>
            @else
                <p class="bk_content">无商品详情</p>
            @endif    
        </div>
    
    <!--购物车和结算按钮-->
    <div class="bk_fix_bottom">
        <div class="bk_half_area">
            <button class="weui_btn weui_btn_primary" onclick="_addCart();">加入购物车</button>
        </div>
        <div class="bk_half_area">
            <button class="weui_btn weui_btn_default" onclick="_toCart()">查看购物车(<span id="cart_num"  class="m3_price">{{$count}}</span>)</button>
        </div>
    </div>
</div>    
    
    
@endsection

@section('my_js')
    <script src="{{asset('JS/swipe.min.js')}}"></script>
<script>
    //轮播图
    var bullets = document.getElementById('position').getElementsByTagName('li');
    Swipe(document.getElementById('mySwipe'), {
        auto: 2000,
        continuous: true,
        disableScroll: false,
        callback: function(pos) {
            var i = bullets.length;
            while (i--) {
                bullets[i].className = '';
            }
            bullets[pos].className = 'cur';
        }
    });//轮播图结束
    
</script>
    
<script>
    
    function _addCart(){
        var book_id = "{{$book->book_id}}";
        $.ajax({
            type: "GET",
            url: '/service/cart/add/' + book_id,
            dataType: 'json',
            cache: false,
            //data: {username: username,password: password, validate_code: validate_code, _token: "{{csrf_token()}}"},
            success: function(data) {
                if(data == null) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html('服务端错误');
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return;
                }
                if(data.status != 0) {
                    $('.bk_toptips').show();
                    $('.bk_toptips span').html(data.message);
                    setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                    return;
                }

                $('.bk_toptips').show();
                $('.bk_toptips span').html(data.message);
                setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });//end ajax
       

        $('#cart_num').html(parseInt($('#cart_num').html()) + 1);
        
    }

    function _toCart() {
        location.href = '{{url('cart/cartview')}}';
    }
    
</script>

@endsection