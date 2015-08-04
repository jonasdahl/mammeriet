@extends('master')

@section('top-bar')
	<a href="{{ url('/') }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Produkter att priskolla</span>
	<a href="{{ url('pricecheck/new') }}" class="button right action">{!! HTML::image('images/icons/create.png', '+') !!}</a>
@stop

@section('content')
	<ul class="list">
		@foreach(App\PriceCheck::all() as $pricecheck)
			<li><a href="{{ url('lists/list', 1) }}">{{ $pricecheck->productInfo->name }}</a></li>
		@endforeach
	</ul>
@stop