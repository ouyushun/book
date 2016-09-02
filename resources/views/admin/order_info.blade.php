@extends('admin.master')

@section('content')
<div class="pd-20">
	<div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
			{{-- <a href="javascript:;" onclick="category_add('添加会员','/admin/member_add')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加会员</a> --}}
		</span>
		<span class="r">共有数据：<strong>{{count($items)}}</strong> 条</span>
	</div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="80">OrderID</th>
				<th width="100">书籍名称</th>
				<th width="40">数量</th>
				<th width="90">单价</th>
				<th width="50">总金额</th>
				<th width="50">缩略图</th>
			
				
			</tr>
		</thead>
		<tbody>
			@foreach($items as $item)
				<tr class="text-c">
					<td>{{$item->order_id}}</td>
					<td>{{$item->book->name}}</td>
					<td>{{$item->count}}</td>
					<td>{{$item->book->price * $item->count}}</td>
					<td>{{$item->book->preview}}</td>
					
				</tr>
			@endforeach
		</tbody>
	</table>
	</div>
</div>
@endsection


