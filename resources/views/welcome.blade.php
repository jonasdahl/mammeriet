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
			<a href="{{ url('shop') }}" class="action">Dagens handling ({{ DB::table('daylist')->where('day', '=', date("Y-m-d"))->join('products', 'products.list', '=', 'daylist.list')->where('status', '!=', 'done')->count() }})</a>
		</div>

		<div class="section">
			<h2>Priskoll</h2>
			<ul class="list">
				<li><a href="{{ url('pricecheck/new') }}">Lägg till vara att kolla pris på</a></li>
				<li><a href="{{ url('pricecheck/all') }}">Se varor som ska priskollas ({{ App\PriceCheck::whereNull('checked_at')->count() }})</a></li>
			</ul>
		</div>

		<div class="section">
			<h2>Inköpslistor per arr <a href="{{ url('list/new') }}" class="action small">{!! HTML::image('images/icons/create.png') !!}</a></h2>
			<ul class="list">
				@foreach(App\ShoppingList::where('eventdate', '>=', Carbon\Carbon::now())->orderBy('eventdate')->get() as $list)
					<li>
						<a href="{{ url('list/show', $list->id) }}">
							{{ $list->name }} ({{ $list->products()->where('status', '!=', 'done')->count() }}) <span>{{ date("Y-m-d", strtotime($list->eventdate)) }}</span>
						</a>
					</li>
				@endforeach
			</ul>
		</div>

		<div class="section">
			<h2>Administration</h2>
			<ul class="list">
				<li><a href="{{ url('user/change-password') }}">Byt lösenord</a></li>
				<li><a href="{{ url('user/new') }}">Skapa ny användare</a></li>
			</ul>
		</div>
	@else
		<a href="{{ url('pricecheck/new') }}" class="action">Jaha, du vill veta pris på någonting? ...nu igen? Klicka här, då...</a>
	@endif
@stop