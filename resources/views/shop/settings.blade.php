@extends('master')

@section('head-extra')
	<script type="text/javascript">
		function someChecked() {
			var found = false;
			$("input[type='checkbox']").each(function() {
				found = found || $(this).prop('checked');

				if ($(this).prop('checked'))
					$(this).parent().addClass('active');
				else
					$(this).parent().removeClass('active');
			});
			return found;
		}

		function tog(el) {
			$("#n" + el).prop('checked', !$("#n" + el).prop('checked'));
		}

		$(document).ready(function() {
			$("input[type='checkbox']").change(function(el) {
				someChecked();
			});
			someChecked();
		});
	</script>
@stop

@section('top-bar')
	<a href="{{ url('/') }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Inställningar för listan {{ $date }}</span>
	<a href="" class="button right action" id="continue" onclick="$('#form').submit();return false;">
		{!! HTML::image('images/icons/save.png', 'Spara') !!}
	</a>
@stop

@section('content')
	<p>Till vilka event ska det handlas denna dag?</p>
	{!! Form::open(['url' => url('shop/settings', date('Y-m-d')), 'id' => 'form']) !!}
		{!! Form::hidden('date', $date) !!}
		<ul class="list nonlink">
			@foreach(App\ShoppingList::where('eventdate', '>=', Carbon\Carbon::now())->orderBy('eventdate')->get() as $entry)
				<li onclick="tog({{ $entry->id }});someChecked();">
					{!! Form::checkbox('lists[]', $entry->id, in_array($entry->id, $activelists), ['id' => 'n' . $entry->id]) !!} {{ $entry->name }} 
					<span>{{ date("Y-m-d", strtotime($entry->eventdate)) }}</span>
				</li>
			@endforeach
		</ul>
	{!! Form::close() !!}
@stop