@extends('master')

@section('top-bar')
	<a href="javascript:history.go(-1)" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Byt lösenord</span>
	<a href="" onclick="$('#form').submit();return false;" class="button right action save">
		{!! HTML::image('images/icons/save.png', 'Spara') !!}
	</a>
@stop

@section('content')
	{!! Form::open(['url' => url('user/change-password'), 'id' => 'form']) !!}
		<ul class="list nonlink">
			<li class="input-wrapper">
				{!! Form::password('old_password', ['placeholder' => 'Ditt gamla lösenord', 'class' => 'thin']) !!}
				<div class="clear"></div>
			</li>
			<li class="input-wrapper">
				{!! Form::password('password', ['placeholder' => 'Ditt nya lösenord', 'class' => 'thin']) !!}
				<div class="clear"></div>
			</li>
			<li class="input-wrapper">
				{!! Form::password('password_confirmation', ['placeholder' => 'Ditt nya lösenord igen', 'class' => 'thin']) !!}
				<div class="clear"></div>
			</li>
		</ul>
		{!! Form::submit('Byt lösenord') !!}
	{!! Form::close() !!}
@stop