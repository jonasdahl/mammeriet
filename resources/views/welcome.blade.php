@extends('master')

@section('top-bar')
	<a href="" class="button logo">{!! HTML::image('images/mammeriet.png', '') !!}</a>
	<span>Mammeriet</span>
	@if (Auth::check())
		<a href="{{ url('auth/logout') }}" class="button right">{!! HTML::image('images/icons/logout.png', '') !!}</a>
	@else
		<a href="{{ url('auth/login') }}" class="button right">{!! HTML::image('images/icons/login.png', '') !!}</a>
	@endif
@stop

@section('content')
	@if (Auth::check())
		<div class="section">
			<h2>Dagens handling</h2>
			<a href="{{ url('shop') }}" class="action">Dagens handling</a>
		</div>

		<div class="section">
			<h2>Priskoll</h2>
			<ul class="list">
				<li><a href="{{ url('pricecheck/new') }}">Lägg till vara att kolla pris på</a></li>
				<li><a href="{{ url('pricecheck/all') }}">Se varor som ska priskollas</a></li>
			</ul>
		</div>

		<div class="section">
			<h2>Inköpslistor per evenemang</h2>
			<ul class="list">
				@foreach(App\ShoppingList::where('eventdate', '>=', Carbon\Carbon::now())->orderBy('eventdate')->get() as $list)
					<li>
						<a href="{{ url('list/show', $list->id) }}">
							{{ $list->name }} <span>{{ date("Y-m-d", strtotime($list->eventdate)) }}</span>
						</a>
					</li>
				@endforeach
			</ul>
		</div>
	@else
		<a href="{{ url('pricecheck/new') }}" class="action">Jaha, du vill veta pris på någonting? ...nu igen? Klicka här, då...</a>
	@endif
@stop