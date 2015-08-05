@extends('master')

@section('head-extra')
	<script type="text/javascript">
		function changeText() {
			if ($('input[name=moms]:checked').val() == 'yes') {
				$('#price').html('Pris med moms: ');
				$('#momsli').hide();
			} else {
				$('#price').html('Pris utan moms: ');
				$('#momsli').show();
			}
		}
	</script>
@stop

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
			<li><b>Beskrivning:</b> {{ $pricecheck->productInfo->description }}</li>
			<li><b>Ansvarig person:</b> {{ $pricecheck->responsibleperson }} ({{ $pricecheck->responsiblepersonemail }})</li>
			<li>
				<b>Ange pris:</b> 
				<label>
					{!! Form::radio('moms', 'yes', true, ['onchange' => 'changeText()']) !!} med moms
				</label>
				<label>
					{!! Form::radio('moms', 'no', false, ['onchange' => 'changeText()']) !!} utan moms
				</label>
			</li>
			<li id="momsli" style="display: none;">
				<b>Momssats: </b>
				{!! Form::select('momssats', array(12 => '12 %', 25 => '25 %')) !!}
			</li>
			<li class="input-wrapper"><span class="label" id="price">Pris:</span>{!! Form::input('number', 'price', $pricecheck->unitprice, ['placeholder' => 'Pris']) !!}</li>
			<li class="input-wrapper"><span class="label">Information om förpackningen:</span>{!! Form::textarea('unit', $pricecheck->unit, ['placeholder' => 'Förpackningsinformation']) !!}</li>
		</ul>
		{!! Form::submit('Skicka') !!}
	{!! Form::close() !!}
@stop