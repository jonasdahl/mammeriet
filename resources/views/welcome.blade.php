@extends('master')

@section('top-bar')
	<span>Inköpslistor</span>
	<a href="" class="button right action">{!! HTML::image('images/icons/create.png', '+') !!}</a>
@stop

@section('content')
	<h2>Nästa inköpslista</h2>
	<ul class="list">
		<li><a href="{{ url('list/show', 1) }}">TTG <span>2015-08-16</span></a></li>
		<li><a href="{{ url('list/show', 2) }}">Arkitektgasque <span>2015-08-20</span></a></li>
	</ul>
@stop