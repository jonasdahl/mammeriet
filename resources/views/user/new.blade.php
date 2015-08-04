@extends('master')

@section('top-bar')
	<a href="javascript:history.go(-1)" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Skapa ny användare</span>
	<a href="" onclick="$('#form').submit();return false;" class="button right action">
		{!! HTML::image('images/icons/save.png', 'Spara') !!}
	</a>
@stop

@section('content')
	{!! Form::open(['url' => url('user/new'), 'id' => 'form']) !!}
		<ul class="list nonlink">
			<li class="input-wrapper">
				{!! Form::text('name', NULL, ['placeholder' => 'Mammeristens namn', 'class' => 'thin', 'id' => 'eventdate']) !!}
				<div class="clear"></div>
			</li>
			<li class="input-wrapper">
				{!! Form::email('email', NULL, ['placeholder' => 'Mammeristens e-postadress', 'class' => 'thin']) !!}
				<div class="clear"></div>
			</li>
			<li class="input-wrapper">
				{!! Form::text('password', NULL, ['placeholder' => 'Mammeristens lösenord', 'class' => 'thin']) !!}
				<div class="clear"></div>
			</li>
		</ul>
	{!! Form::close() !!}
@stop