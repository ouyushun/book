@extends('admin.master')

@section('content')
<div class="pd-20">
	<div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
			{{-- <a href="javascript:;" onclick="category_add('添加会员','/admin/member_add')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加会员</a> --}}
		</span>
		<span class="r">共有数据：<strong>{{count($orders)}}</strong> 条</span>
	</div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="80">ID</th>
				<th width="100">订单号</th>
				<th width="40">订单名称</th>
				<th width="90">支付金额</th>
				<th width="50">支付方式</th>
				<th width="50">订单状态</th>
				<th width="50">用户ID</th>
				<th width="50">下单时间</th>
				<th width="100">查看</th>
				
			</tr>
		</thead>
		<tbody>
			@foreach($orders as $order)
				<tr class="text-c">
					<td>{{$order->id}}</td>
					<td>{{$order->order_no}}</td>
					<td>{{$order->name}}</td>
					<td>{{$order->total_price}}</td>
					<td>@if($order->payway == 1)
					  支付宝
					@elseif($order->payway == 2)
            微信
          @else
            其他
					@endif</td>
					<td onclick="changeStatus(this, '{{$order->id}}');">
					@if($order->status == 1)
						<span class="label label-danger radius">未支付</span>
          @elseif($order->status == 2)
						<span class="label label-success radius">已支付</span>
					@elseif($order->status == 3)
						<span class="label label-success radius">等待发货</span>
					@elseif($order->status == 4)
						<span class="label label-success radius">已发货</span>
					@elseif($order->status == 5)
						<span class="label label-success radius">已签收</span>
					@endif</td>
          <td>{{$order->member_id}}</td>
          <td>{{date('Y-m-d H:i:s',$order->created_at)}}</td>
                    <td class="td-manage">
						<a title="详情" href="javascript:;" onclick="order_info('订单详情','/admin/order/info?id={{$order->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe695;</i></a>
						<a title="编辑" href="javascript:;" onclick="order_edit('编辑订单','/admin/order/edit?id={{$order->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
						{{-- <a title="删除" href="javascript:;" onclick='category_del("{{$member->nickname}}", "{{$member->id}}")' class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a> --}}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	</div>
</div>
@endsection

@section('my-js')
<script type="text/javascript">

	function order_edit(title, url){
		layer_show(title,url,500,200);
	}

	function order_info(title, url) {
		var index = layer.open({
			type: 2,
			title: title,
			content: url
		});
		layer.full(index);
	}
</script>
@endsection
