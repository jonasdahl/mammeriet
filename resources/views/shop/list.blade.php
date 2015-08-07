@extends('master')

@section('head-extra')
	<script type="text/javascript">
		function setDoneGraphics(productId) {
			if ($("#link" + productId).hasClass('done')) {
				return;
			}
			
			$("#done" + productId).parent().parent().slideUp(300, function() {
				$("#done" + productId).parent().parent().parent().append($("#done" + productId).parent().parent());
				$("#done" + productId).parent().hide();
				$("#link" + productId).addClass('done');
				$("#done" + productId).parent().parent().slideDown();
			});
		}

		function setUnDoneGraphics(productId) {
			if (!$("#link" + productId).hasClass('done')) {
				return;
			}

			$("#done" + productId).parent().parent().slideUp(300, function() {
				$("#done" + productId).parent().parent().parent().prepend($("#done" + productId).parent().parent());
				$("#done" + productId).parent().hide();
				$("#link" + productId).removeClass('done');
				$("#done" + productId).parent().parent().slideDown();
			});
		}

		function jonas(productId) {
			$.ajax({
			    url: '{{ url('api/product/set-done') }}/' + productId,
			    cache: false
			})
			    .done(function(html) {
			    	if (html.done) {
			    		setDoneGraphics(productId);
					} else {
			    		setUnDoneGraphics(productId);
					}

					$('#done_products').html(html.list.done_products + ' kr');
					$('#all_products').html(html.list.all_products + ' kr');
					$('#budget').html(html.list.budget + ' kr');
			    });
			return false;
		}
		
		$(document).ready(function() {
			setInterval(function () {
				$.ajax({
				    url: '{{ url('api/shop/products-status', $date) }}',
				    cache: false
				})
				    .done(function( html ) {
				    	if (html.statuses.done) {
					    	for (var i = 0; i < html.statuses.done.length; i++) {
					    		setDoneGraphics(html.statuses.done[i]);
					    	}
					    }
				    	if (html.statuses['']) {
					    	for (var i = 0; i < html.statuses[''].length; i++) {
					    		setUnDoneGraphics(html.statuses[''][i]);
					    	}
					    }

			    		$('#list').children().each(function(el) {
			    			for (var i = 0; i < html.deleted_products.length; i++) {
				    			if ($(this).prop('id') == 'el' + html.deleted_products[i]) 
				    				$(this).slideUp(300);
			    			}

			    			for (var i = 0; i < html.product_info.length; i++) {
				    			if ($(this).prop('id') == 'el' + html.product_info[i].id) {
            						$('#el' + html.product_info[i].id + ' .quantity').html(Math.round(html.product_info[i].quantity* 100) / 100 + ' st');
            						$('#el' + html.product_info[i].id + ' .unitprice').html(Math.round(html.product_info[i].unitprice* 100) / 100 + ' kr/st');
            						$('#el' + html.product_info[i].id + ' .sum').html(Math.round(html.product_info[i].quantity * html.product_info[i].unitprice* 100) / 100 + ' kr');
            						$('#el' + html.product_info[i].id + ' .unitmoms').html(Math.round(html.product_info[i].unitprice * 100) / 100 + '');
            						$('#el' + html.product_info[i].id + ' .unitnomoms').html(Math.round(html.product_info[i].unitprice / ((html.product_info[i].moms + 100) / 100) * 100) / 100);
            						$('#el' + html.product_info[i].id + ' .name').html(html.product_info[i].name);
				    			}
			    			}
			    		});

				    	if (html.lists) {
				    		$('.listspec').each(function(el) {
						    	for (var i = 0; i < html.lists.length; i++) {
						    		if ($(this).prop('id') == 'ls' + html.lists[i].id) {
										$('#ls' + html.lists[i].id + ' .done_products').html(html.lists[i].done_products + ' kr');
										$('#ls' + html.lists[i].id + ' .all_products').html(html.lists[i].all_products + ' kr');
										$('#ls' + html.lists[i].id + ' .budget').html(html.lists[i].budget + ' kr');

										console.log('#ls' + html.lists[i].id + ' .done_products');
						    		}
						    	}
				    		});
					    }
				    });
			}, 3000);
		});
		
	</script>
@stop


@section('top-bar')
	<a href="{{ url('/') }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Inköpslista för {{ $date }}</span>
	<a href="{{ url('shop/add-product', $date) }}" class="button right action">{!! HTML::image('images/icons/create.png', '+') !!}</a>
	<a href="{{ url('shop/settings', $date) }}" class="button right">{!! HTML::image('images/icons/settings.png', '+') !!}</a>
@stop

@section('content')
	@foreach ($lists as $list)
		<h2>{{ $list->name }} ({{ substr($list->name, 0, 3) }})</h2>
		<table class="listspec" id="ls{{ $list->id }}">
			<tr>
				<th>Grönmarkerade produkter:</th>
				<td class="done_products">
					{{ round(DB::table('products')->select(DB::raw('sum(unitprice*quantity) as product_sum'))->whereNull('deleted_at')->where('list', '=', $list->id)->where('status', 'done')->first()->product_sum) }} kr
				</td>
			</tr>
			<tr>
				<th>Alla produkter i listan:</th>
				<td class="all_products">
					{{ round(DB::table('products')->select(DB::raw('sum(unitprice*quantity) as product_sum'))->whereNull('deleted_at')->where('list', '=', $list->id)->first()->product_sum) }} kr
				</td>
			</tr>
			<tr>
				<th>Total budget:</th>
				<td class="budget">
					{{ round($list->budget) }} kr
				</td>
			</tr>
		</table>
	@endforeach

	<ul class="list shopping" id="list">
		@if (($num = App\PriceCheck::whereNull('checked_at')->count()) > 0)
			<li class="active">
				<a href="{!! url('pricecheck/all') !!}">Kolla priser på {{ $num }} produkter.</a>
			</li>
		@endif
		@foreach($products as $product)
			<li id="el{{ $product->id }}">
				<a id="link{{ $product->id }}" href="" onclick="$('#more{{ $product->id }}').slideToggle(100);return false;"{!! $product->status == 'done' ? ' class="done"' : '' !!}>
					<span class="name">{{ $product->name }}</span>
					<span class="info">
						<span class="quantity">{{ round($product->quantity, 2) }} st</span>
						<span class="unitprice">{{ round($product->unitprice, 2) }} kr/st</span>
						<span class="sum">{{ round($product->unitprice * $product->quantity, 2) }} kr</span>
					</span>
					<div class="clear"></div>
				</a>
				<div class="more" id="more{{ $product->id }}">
					<a id="done{{ $product->id }}" href="{{ url('shop/done-product', $product->id) }}" onclick="jonas('{{ $product->id }}');return false;" class="button check">
						{!! HTML::image('images/icons/save.png', 'Klar') !!}
					</a>
					<a href="{{ url('list/edit-product', [$product->id, 'shop']) }}" class="button bad">
						{!! HTML::image('images/icons/edit.png', 'Ändra') !!}
					</a>
					<a onclick="return confirm('Är du säker på att du vill ta bort denna produkt från alla listor? Den kan inte återskapas.');" href="{{ url('list/delete-product', $product->id) }}" class="button bad">
						{!! HTML::image('images/icons/delete.png', 'Finns ej') !!}
					</a>
					<span>
						<span class="u unitmoms">{{ round($product->unitprice, 2) }}</span> kr/st ink moms, <br> 
						<span class="u unitnomoms">{{ round($product->unitprice / (($product->moms + 100) / 100), 2) }}</span> kr/st ex moms
					</span>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</li>
		@endforeach
	</ul>
@stop