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
	<a href="{{ url('list/show', $list->id) }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Lägg till produkt i "{{ $list->name }}"</span>
	<a href="" onclick="$('#form').submit();return false;" class="button right action">
		{!! HTML::image('images/icons/save.png', 'Spara') !!}
	</a>
@stop

@section('content')
	{!! Form::open(['url' => url('list/add-product', $list->id), 'id' => 'form']) !!}
		{!! Form::hidden('id', $list->id) !!}
		<ul class="list nonlink">
			<li>Namn: {!! Form::text('name') !!}</li>
			<li>{!! Form::label('quantity', 'Antal:') !!} {!! Form::input('number', 'quantity', NULL) !!}</li>
			<li>{!! Form::label('unitprice', 'Pris/st:') !!} {!! Form::input('number', 'unitprice', NULL) !!}</li>
			<li>{!! Form::label('total', 'Totalt pris:') !!} {!! Form::input('number', 'total', NULL, ['disabled' => 'true']) !!}</li>
		</ul>
	{!! Form::close() !!}
@stop