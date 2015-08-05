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
	<span>Lägg till produkt i "{{ $list->name }}"</span>
	<a href="" onclick="$('#form').submit();return false;" class="button right action save">
		{!! HTML::image('images/icons/save.png', 'Spara') !!}
	</a>
@stop

@section('content')
	{!! Form::open(['url' => url('list/add-product', $list->id), 'id' => 'form']) !!}
		{!! Form::hidden('id', $list->id) !!}
		<ul class="list nonlink">
			<li class="input-wrapper">
				<span class="label">Produktnamn:</span>
				{!! Form::text('name', null, ['placeholder' => 'Produktnamn']) !!}
			</li>
			<li class="input-wrapper">
				<span class="label">Antal:</span>
				{!! Form::input('number', 'quantity', null, ['id' => 'quantity', 'placeholder' => 'Antal']) !!}
			</li>
			<li>
				<b>Momssats:</b><br>
				{!! Form::select('moms', [12 => '12 %', 25 => '25 %'], null, ['id' => 'moms']) !!}
			</li>
			<li class="input-wrapper">
				<div class="left col">
					<div class="ic">
						<span class="label">Pris/st ex moms:</span>
						{!! Form::input('number', 'unitprice', null, ['id' => 'unitpricenomoms', 'placeholder' => 'Pris per styck']) !!}
					</div>
				</div>
				<div class="right col">
					<div class="ic">
						<span class="label">Pris/st ink moms:</span>
						{!! Form::input('number', 'unitprice', null, ['id' => 'unitprice', 'placeholder' => 'Pris per styck']) !!}
					</div>
				</div>
				<div class="clear"></div>
			</li>
			<li class="input-wrapper">
				<span class="label">Totalt ink moms:</span>
				{!! Form::input('number', 'total', null, ['disabled' => 'true', 'id' => 'total', 'placeholder' => 'Totalt']) !!}
			</li>
			<li><label>{!! Form::checkbox('stay', 'yes', $stay) !!} Stanna kvar på denna sida när du sparat</label></li>
		</ul>
		{!! Form::submit('Lägg till') !!}
	{!! Form::close() !!}
@stop