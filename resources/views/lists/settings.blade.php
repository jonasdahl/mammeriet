@extends('master')

@section('head-extra')
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#datepicker").datepicker({
				dateFormat: 'yy-mm-dd'
			});
		});
 	</script>
@stop

@section('top-bar')
	<a href="{{ url('/') }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Inställningar för listan {{ $list->name }}</span>
	<a href="" class="button right action save" id="continue" onclick="$('#form').submit();return false;">
		{!! HTML::image('images/icons/save.png', 'Spara') !!}
	</a>
@stop

@section('content')
	{!! Form::open(['url' => url('list/settings', $list->id), 'id' => 'form']) !!}
		{!! Form::hidden('id', $list->id) !!}
		<ul class="list nonlink">
			<li class="input-wrapper">
				<span class="label">Eventets namn:</span>
				{!! Form::text('name', $list->name) !!}
			</li>
			<li class="input-wrapper">
				<span class="label">Eventets datum (YYYY-mm-dd):</span>
				{!! Form::text('eventdate', date("Y-m-d", strtotime($list->eventdate)), ['id' => 'datepicker']) !!}
			</li>
			<li class="input-wrapper">
				<span class="label">Budget:</span>
				{!! Form::input('number', 'budget', $list->budget) !!}
			</li>
		</ul>
		{!! Form::submit('Spara') !!}
	{!! Form::close() !!}
@stop