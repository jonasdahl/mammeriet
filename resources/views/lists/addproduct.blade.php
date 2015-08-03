@extends('master')

@section('top-bar')
	<a href="{{ url('list/show', $list->id) }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Lägg till produkt i "{{ $list->name }}"</span>
	<a href="{{ url('list/add-product', $list->id) }}" class="button right action">{!! HTML::image('images/icons/save.png', 'Spara') !!}</a>
@stop

@section('content')
	<ul class="list nonlink">
		@foreach($list->products()->get() as $product)
			<li>Namn: {!! Form::text('name') !!}</li>
		@endforeach
	</ul>
@stop