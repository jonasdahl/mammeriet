@extends('master')

@section('head-extra')
	<script type="text/javascript">
		function calculate() {
			var res = $('#unitprice').val() * $('#quantity').val();
			$('#total').val(res);
		}

		$(document).ready(function() {
			$('#unitpricenomoms').val(Math.round(100 * $('#unitprice').val() / (parseInt($("#moms").val())+100)*100) / 100);
			
			$('#quantity').keyup(function() {
				calculate();
			});
			$('#unitprice').keyup(function() {
				$('#unitpricenomoms').val(Math.round(100 * $('#unitprice').val() / (parseInt($("#moms").val())+100)*100) / 100);
				calculate();
			});
			$('#unitpricenomoms').keyup(function() {
				$('#unitprice').val(Math.round(100 * $('#unitpricenomoms').val() * (parseInt($("#moms").val())+100)/100) / 100);
				calculate();
			});
			$('#moms').change(function() {
				$('#unitprice').val(Math.round(100 * $('#unitpricenomoms').val() * (parseInt($("#moms").val())+100)/100) / 100);
				calculate();
			});
		});
	</script>
@stop

@section('top-bar')
	<a href="{{ url('list/show', $list->id) }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Ändra produkt "{{ $product->name }}"</span>
	<a href="" onclick="$('#form').submit();return false;" class="button right action save">
		{!! HTML::image('images/icons/save.png', 'Spara') !!}
	</a>
@stop

@section('content')
	{!! Form::open(['url' => url('list/edit-product', $list->id), 'id' => 'form']) !!}
		{!! Form::hidden('id', $product->id) !!}
		{!! Form::hidden('back', $back) !!}
		<ul class="list nonlink">
			<li><b>Lista:</b>{!! Form::select('list', $events, NULL) !!}</li>
			<li class="input-wrapper">
				<span class="label">Produktnamn:</span>
				{!! Form::text('name', $product->name, ['placeholder' => 'Produktnamn']) !!}
			</li>
			<li class="input-wrapper">
				<span class="label">Antal:</span>
				{!! Form::input('number', 'quantity', round($product->quantity, 2), ['id' => 'quantity', 'placeholder' => 'Antal']) !!}
			</li>
			<li>
				<b>Momssats:</b><br>
				{!! Form::select('moms', [12 => '12 %', 25 => '25 %'], $product->moms, ['id' => 'moms']) !!}
			</li>
			<li class="input-wrapper">
				<div class="left col">
					<div class="ic">
						<span class="label">Pris/st ex moms:</span>
						{!! Form::input('number', 'unitprice', round($product->unitprice, 2), ['id' => 'unitpricenomoms', 'placeholder' => 'Pris per styck']) !!}
					</div>
				</div>
				<div class="right col">
					<div class="ic">
						<span class="label">Pris/st ink moms:</span>
						{!! Form::input('number', 'unitprice', round($product->unitprice, 2), ['id' => 'unitprice', 'placeholder' => 'Pris per styck']) !!}
					</div>
				</div>
				<div class="clear"></div>
			</li>
			<li class="input-wrapper">
				<span class="label">Totalt ink moms:</span>
				{!! Form::input('number', 'total', $product->quantity * $product->unitprice, ['disabled' => 'true', 'id' => 'total', 'placeholder' => 'Totalt']) !!}
			</li>
		</ul>
		{!! Form::submit('Ändra') !!}
	{!! Form::close() !!}
@stop