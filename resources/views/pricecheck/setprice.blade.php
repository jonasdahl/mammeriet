@extends('master')

@section('top-bar')
	<a href="{{ url('pricecheck/all') }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Ange pris för produkt</span>
	<a href="" onclick="$('#form').submit();return false;" class="button right action save">
		{!! HTML::image('images/icons/save.png', 'Spara') !!}
	</a>
@stop

@section('content')
	{!! Form::model($pricecheck, ['url' => url('pricecheck/set-price', $pricecheck->id), 'id' => 'form']) !!}
		{!! Form::hidden('id') !!}
		<ul class="list nonlink">
			<li><b>Produktnamn:</b> {{ $pricecheck->productInfo->name }}</li>
			<li><b>Ansvarig person:</b> {{ $pricecheck->responsibleperson }} ({{ $pricecheck->responsiblepersonemail }})</li>
			<li class="input-wrapper">{!! Form::input('number', 'price', $pricecheck->unitprice, ['placeholder' => 'Pris']) !!}</li>
			<li class="input-wrapper">{!! Form::textarea('unit', $pricecheck->unit, ['placeholder' => 'Förpackningsinformation']) !!}</li>
		</ul>
		{!! Form::submit('Skicka') !!}
	{!! Form::close() !!}
@stop