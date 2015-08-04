@extends('master')

@section('top-bar')
	<a href="{{ url('/') }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>{{ $list->name }}</span>
	<a href="{{ url('list/add-product', $list->id) }}" class="button right action">{!! HTML::image('images/icons/create.png', '+') !!}</a>
@stop

@section('content')
	<ul class="list">
		@foreach($list->products()->get() as $product)
			<li><a href="{{ url('lists/list', 1) }}">{{ $product->name }}</a></li>
		@endforeach
	</ul>
@stop