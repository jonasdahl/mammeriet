@extends('master')

@section('top-bar')
	<a href="{{ url('/') }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Lägg till produkt att priskolla</span>
	<a href="" onclick="$('#form').submit();return false;" class="button right action">
		{!! HTML::image('images/icons/save.png', 'Spara') !!}
	</a>
@stop

@section('content')
	{!! Form::open(['url' => url('pricecheck/new'), 'id' => 'form']) !!}
		<ul class="list nonlink">
			<li>Produktnamn: {!! Form::text('name') !!}</li>
			<li>Ansvarig person: {!! Form::select('responsibleperson', App\User::htmlSelectAll()) !!}</li>
			<li>Affär: {!! Form::select('shop', array(0 => 'Spelar ingen roll')) !!}</li>
		</ul>
	{!! Form::close() !!}
@stop