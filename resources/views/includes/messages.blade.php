@if(Session::has('success'))
	<p class="success">
		{{ Session::get('success') }}
	</p>
@endif

@if(isset($errors) && $errors->count() > 0)
	<p class="error">
		Felaktiga inloggningsuppgifter. Försök igen.
	</p>
@endif