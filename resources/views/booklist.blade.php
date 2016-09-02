@extends('master')
@section('title','书籍列表')  <!--两个参数，已经闭合，无需关闭-->

@section('content')
    <div class="weui_cells weui_cells_access">
        @if(count($books) !=0 )
            @foreach($books as $book)
            <a class="weui_cell" href="{{url("product/content/$book->book_id")}}">
                <div class="weui_cell_hd"><img class="bk_preview" src="{{$book->preview}}" ></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <div>
                        <span class="bk_title">{{$book->name}}</span><span class="bk_price">￥{{$book->price}}</span>
                        
                    </div>
                    <p class="bk_summary">{{$book->summary}}</p>
                </div>
            </a>
            @endforeach
        @else
                <span class="bk_summary">此栏目下暂无商品</span>
        @endif    
    </div>
@endsection

@section('my_js')

<script>
    
</script>
    


@endsection