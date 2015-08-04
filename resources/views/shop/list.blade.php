@extends('master')

@section('top-bar')
	<a href="{{ url('/') }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Inköpslista för {{ $date }}</span>
	<a href="{{ url('shop/add-product', $date) }}" class="button right action">{!! HTML::image('images/icons/create.png', '+') !!}</a>
	<a href="{{ url('shop/settings', $date) }}" class="button right">{!! HTML::image('images/icons/settings.png', '+') !!}</a>
@stop

@section('content')
	@foreach ($lists as $list)
		<h2>{{ $list->name }} ({{ substr($list->name, 0, 3) }})</h2>
		<table>
			<tr>
				<th>Grönmarkerade produkter:</th>
				<td>
					{{ round(DB::table('products')->select(DB::raw('sum(unitprice*quantity) as product_sum'))->where('list', '=', $list->id)->where('status', 'done')->first()->product_sum) }} kr
				</td>
			</tr>
			<tr>
				<th>Alla produkter i listan:</th>
				<td>
					{{ round(DB::table('products')->select(DB::raw('sum(unitprice*quantity) as product_sum'))->where('list', '=', $list->id)->first()->product_sum) }} kr
				</td>
			</tr>
			<tr>
				<th>Total budget:</th>
				<td>
					{{ round($list->budget) }} kr
				</td>
			</tr>
		</table>
	@endforeach

	<ul class="list">
		@if (($num = App\PriceCheck::whereNull('checked_at')->count()) > 0)
			<li class="active">
				<a href="{!! url('pricecheck/all') !!}">Kolla priser på {{ $num }} produkter.</a>
			</li>
		@endif
		@foreach($products as $product)
			<li>
				<a href="" onclick="$('#more{{ $product->id }}').slideToggle(100);return false;"{!! $product->status == 'done' ? ' class="done"' : '' !!}>
					<span class="name">{{ $product->name }} ({{ substr($product->shoppingList->name, 0, 3) }})</span>
					<span class="info">
						<span class="quantity">{{ round($product->quantity) }} á</span>
						<span class="unitprice">{{ $product->unitprice }} kr</span>
						<span class="sum">{{ $product->unitprice * $product->quantity }} kr</span>
					</span>
					<div class="clear"></div>
				</a>
				<div class="more" id="more{{ $product->id }}">
					<a href="{{ url('shop/done-product', $product->id) }}" class="button check">
						{!! HTML::image('images/icons/save.png', 'Klar') !!}
					</a>
					<a onclick="return confirm('Är du säker på att du vill ta bort denna produkt från alla listor? Den kan inte återskapas.');" href="{{ url('list/delete-product', $product->id) }}" class="button bad">
						{!! HTML::image('images/icons/delete.png', 'Finns ej') !!}
					</a>
					<div class="clear"></div>
				</div>
			</li>
		@endforeach
	</ul>
@stop