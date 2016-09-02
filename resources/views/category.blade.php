@extends('master')
@section('title','书籍类别')  <!--两个参数，已经闭合，无需关闭-->

@section('content')
    <div class="weui_cells_title">选择书籍类别</div>
    <div class="weui_cells">
        <div class="weui_cell weui_cell_select">
            <div class="weui_cell_bd weui_cell_primary">
                <select class="weui_select" name="select1">
                    @foreach($categories as $category)
                    <option value="{{$category->cate_id}}">{{$category->cate_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="weui_cells weui_cells_access" style="margin-left: 40px;">
        
    </div>


    
@endsection

@section('my_js')

<script>
    
    _category();
    
    $('.weui_select').change(function(event){
        _category();
    });
    
    function _category() {
        var parent_id = $('.weui_select option:selected').val();
        $.ajax({
            type: "GET",
            url: '/service/category/parent_id/' + parent_id,
            dataType: 'json',
            cache: false,
            //data: {username: username,password: password, validate_code: validate_code, _token: "{{csrf_token()}}"},
            success: function(data) {
                
                $('.weui_cells_access').html('');
                
                for(var i=0;i<data.length;i++){
                    var next = 'book/category_id/' + data[i].cate_id;
                    var node = '<a class="weui_cell" href="' + next + '">' +
                                    '<div class="weui_cell_hd"><img src="' + data[i].preview + '"" alt="" style="width:20px;margin-right:5px;display:block"></div>'+
                                '<div class="weui_cell_bd weui_cell_primary">' +
                                    '<p>' + data[i].cate_name + '</p>' +
                                '</div>' +
                                '<div class="weui_cell_ft"></div>' +
                            '</a>' ;

                    $('.weui_cells_access').append(node);
                }
                    
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });//end ajax
    }
</script>
    


@endsection