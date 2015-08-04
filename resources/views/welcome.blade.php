@extends('master')

@section('top-bar')
	<span>Mammeriet</span>
	<a href="" class="button right action">{!! HTML::image('images/icons/create.png', '+') !!}</a>
@stop

@section('content')
	@include('includes.messages')
	
	<div class="section">
		<h2>Priskoll</h2>
		<ul class="list">
			<li><a href="{{ url('pricecheck/new') }}">Lägg till vara att kolla pris på</a></li>
			<li><a href="{{ url('pricecheck/all') }}">Se varor som ska priskollas</a></li>
		</ul>
	</div>

	@if(($list = App\ShoppingList::where('eventdate', '>=', new DateTime('today'))->orderBy('eventdate', 'asc')->first()) != null)
		<div class="section">
			<h2>Nästa inköpslista</h2>
			<ul class="list">
				<li><a href="{{ url('list/show', $list->id) }}">{{ $list->name }} <span>{{ date("Y-m-d", strtotime($list->eventdate)) }}</span></a></li>
			</ul>
		</div>
	@endif
@stop