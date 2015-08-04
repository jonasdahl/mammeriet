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
			<li class="input-wrapper">
				{!! Form::text('name', NULL, ['placeholder' => 'Produktnamn', 'class' => 'thin']) !!}
				<div class="clear"></div>
			</li>
			<li class="input-wrapper">
				{!! Form::text('responsibleperson', NULL, ['placeholder' => 'Ditt namn', 'class' => 'thin']) !!}
				<div class="clear"></div>
			</li>
			<li class="input-wrapper">
				{!! Form::text('responsiblepersonemail', NULL, ['placeholder' => 'Din e-postadress', 'class' => 'thin']) !!}
				<div class="clear"></div>
			</li>
		</ul>
	{!! Form::close() !!}
@stop