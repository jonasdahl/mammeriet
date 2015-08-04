@extends('master')

@section('head-extra')
	<script type="text/javascript">
		function calculate() {
			var res = $('#unitprice').val() * $('#quantity').val();
			$('#total').val(res);
		}

		$(document).ready(function() {
			$('#quantity').keyup(function() {
				calculate();
			});
			$('#unitprice').keyup(function() {
				calculate();
			});
		});
	</script>
@stop

@section('top-bar')
	<a href="{{ url('shop/list', $date) }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Lägg till produkt i listan {{ $date }}</span>
	<a href="" onclick="$('#form').submit();return false;" class="button right action">
		{!! HTML::image('images/icons/save.png', 'Spara') !!}
	</a>
@stop

@section('content')
	{!! Form::open(['url' => url('shop/add-product', $date), 'id' => 'form']) !!}
		{!! Form::hidden('date', $date) !!}
		<ul class="list nonlink">
			<li>{!! Form::select('list', $events, NULL, ['placeholder' => 'Produktnamn']) !!}</li>
			<li class="input-wrapper">{!! Form::text('name', NULL, ['placeholder' => 'Produktnamn']) !!}</li>
			<li class="input-wrapper">{!! Form::input('number', 'quantity', NULL, ['id' => 'quantity', 'placeholder' => 'Antal']) !!}</li>
			<li class="input-wrapper">{!! Form::input('number', 'unitprice', NULL, ['id' => 'unitprice', 'placeholder' => 'Pris per styck']) !!}</li>
			<li class="input-wrapper">{!! Form::input('number', 'total', NULL, ['disabled' => 'true', 'id' => 'total', 'placeholder' => 'Totalt']) !!}</li>
		</ul>
	{!! Form::close() !!}
@stop