@extends('master')

@section('head-extra')
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#eventdate").datepicker({
				dateFormat: 'yy-mm-dd'
			});
		});
 	</script>
@stop

@section('top-bar')
	<a href="javascript:history.go(-1)" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Skapa ny inköpslista</span>
	<a href="" onclick="$('#form').submit();return false;" class="button right action save">
		{!! HTML::image('images/icons/save.png', 'Spara') !!}
	</a>
@stop

@section('content')
	{!! Form::open(['url' => url('list/new'), 'id' => 'form']) !!}
		<ul class="list nonlink">
			<li class="input-wrapper">
				{!! Form::text('name', NULL, ['placeholder' => 'Eventnamn', 'class' => 'thin']) !!}
				<div class="clear"></div>
			</li>
			<li class="input-wrapper">
				{!! Form::text('eventdate', NULL, ['placeholder' => 'Eventets datum', 'class' => 'thin', 'id' => 'eventdate']) !!}
				<div class="clear"></div>
			</li>
			<li class="input-wrapper">
				{!! Form::input('number', 'budget', NULL, ['placeholder' => 'Total bugdet', 'class' => 'thin']) !!}
				<div class="clear"></div>
			</li>
		</ul>
		{!! Form::submit('Lägg till') !!}
	{!! Form::close() !!}
@stop