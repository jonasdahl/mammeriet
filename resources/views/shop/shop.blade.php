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

		function testIt() {
			if (someChecked()) {
				$("#continue").show();
			} else {
				$("#continue").hide();
			}
		}

		function tog(el) {
			$("#n" + el).prop('checked', !$("#n" + el).prop('checked'));
		}

		$(document).ready(function() {
			$("input[type='checkbox']").change(function(el) {
				testIt();
			});
			testIt();
		});
	</script>
@stop

@section('top-bar')
	<a href="{{ url('/') }}" class="button">{!! HTML::image('images/icons/back.png', '<') !!}</a>
	<span>Dagens handling</span>
	<a href="" style="display:none;" class="button right action" id="continue" onclick="$('#form').submit();return false;">
		{!! HTML::image('images/icons/next.png', '<') !!}
	</a>
@stop

@section('content')
	<p>Till vilka event ska det handlas idag?</p>
	{!! Form::open(['url' => url('shop/add-list', date('Y-m-d')), 'id' => 'form']) !!}
		<ul class="list nonlink">
			@foreach(App\ShoppingList::where('eventdate', '>=', Carbon\Carbon::now())->orderBy('eventdate')->get() as $entry)
				<li onclick="tog({{ $entry->id }});testIt();">
					{!! Form::checkbox('lists[]', $entry->id, false, ['id' => 'n' . $entry->id]) !!} {{ $entry->name }} 
					<span>{{ date("Y-m-d", strtotime($entry->eventdate)) }}</span>
				</li>
			@endforeach
		</ul>
	{!! Form::close() !!}
@stop