@extends('master')

@section('top-bar')
	<a href="{{ url('/') }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>{{ $list->name }}</span>
	<a href="{{ url('list/add-product', $list->id) }}" class="button right action">{!! HTML::image('images/icons/create.png', '+') !!}</a>
	<a href="{{ url('list/settings', $list->id) }}" class="button right">{!! HTML::image('images/icons/settings.png', '+') !!}</a>
@stop

@section('content')
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
	<ul class="list shopping">
		@foreach($list->products()->orderBy('status')->orderBy('name')->get() as $product)
			<li>
				<a href="" onclick="$('#more{{ $product->id }}').slideToggle(100);return false;"{!! $product->status == 'done' ? ' class="done"' : '' !!}>
					<span class="name">{{ $product->name }}</span>
					<span class="info">
						<span class="quantity">{{ round($product->quantity, 2) }} st</span>
						<span class="unitprice">{{ round($product->unitprice, 2) }} kr/st</span>
						<span class="sum">{{ round($product->unitprice * $product->quantity, 2) }} kr</span>
					</span>
					<div class="clear"></div>
				</a>
				<div class="more" id="more{{ $product->id }}">
					<a href="{{ url('shop/done-product', $product->id) }}" class="button check">
						{!! HTML::image('images/icons/save.png', 'Klar') !!}
					</a>
					<a href="{{ url('list/edit-product', [$product->id, 'list']) }}" class="button bad">
						{!! HTML::image('images/icons/edit.png', 'Ändra') !!}
					</a>
					<a onclick="return confirm('Är du säker på att du vill ta bort denna produkt från alla listor? Den kan inte återskapas.');" href="{{ url('list/delete-product', $product->id) }}" class="button bad">
						{!! HTML::image('images/icons/delete.png', 'Finns ej') !!}
					</a>
					<span>
						{{ round($product->unitprice, 2) }} kr/st ink moms, <br> 
						{{ round($product->unitprice / (($product->moms + 100) / 100), 2) }} kr/st ex moms
					</span>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</li>
		@endforeach
	</ul>
@stop