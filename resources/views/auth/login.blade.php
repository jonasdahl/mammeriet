@extends('master')

@section('top-bar')
	<a href="javascript:history.go(-1)" class="button">{!! HTML::image('images/icons/back.png', '') !!}</a>
	<span>Mammeriet</span>
@stop

@section('content')
	{!! Form::open(['url' => url('auth/login')]) !!}
		{!! csrf_field() !!}
		<div class="section">
			<ul class="list nonlink">
				<li class="input-wrapper">{!! Form::email('email', NULL, ['placeholder' => 'Användarnamn']) !!}</li>
				<li class="input-wrapper">{!! Form::password('password', ['placeholder' => 'Lösenord']) !!}</li>
				<li><label>{!! Form::checkbox('remember') !!} Kom ihåg mig</label></li>
			</ul>
			{!! Form::submit('Logga in', ['class' => 'display']) !!}
		</div>
	{!! Form::close() !!}
@stop