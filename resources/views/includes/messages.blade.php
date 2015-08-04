@if(Session::has('success'))
	<p class="success">
		{{ Session::get('success') }}
	</p>
@endif