@extends('master')

@section('top-bar')
	<a href="{{ url('/') }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Produkter att priskolla</span>
	<a href="{{ url('pricecheck/new') }}" class="button right action">{!! HTML::image('images/icons/create.png', '+') !!}</a>
@stop

@section('content')
	<div class="section">
		<ul class="list">
			@foreach(App\PriceCheck::whereNull('unitprice')->whereNull('checked_at')->get() as $pricecheck)
				<li><a href="{{ url('pricecheck/set-price', $pricecheck->id) }}">{{ $pricecheck->productInfo->name }} <span>Ange pris</span></a></li>
			@endforeach
		</ul>
	</div>
	<div class="section">
		<h2>Redan kollade produkter</h2>
		<ul class="list">
			@foreach(App\PriceCheck::whereNotNull('unitprice')->whereNotNull('checked_at')->orderBy('checked_at', 'desc')->get() as $pricecheck)
				<li><a href="{{ url('pricecheck/set-price', $pricecheck->id) }}">{{ $pricecheck->productInfo->name }} <span>{{ $pricecheck->unitprice }} kr</span></a></li>
			@endforeach
		</ul>
	</div>
@stop