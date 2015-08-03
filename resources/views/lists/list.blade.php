@extends('master')

@section('top-bar')
	<span>{{ $list->name }}</span>
	<a href="{{ url('list/add-product', $list->id) }}" class="button right action">{!! HTML::image('images/icons/create.png', '+') !!}</a>
@stop

@section('content')
	<ul class="list">
		<li><a href="{{ url('lists/list', 1) }}">TTG <span>2015-08-16</span></a></li>
		<li><a href="{{ url('lists/list', 2) }}">Arkitektgasque <span>2015-08-20</span></a></li>
	</ul>
@stop