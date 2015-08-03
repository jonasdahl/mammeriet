<!DOCTYPE html>
<html>
    <head>
        <title>@yield('html-title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        {!! HTML::style('css/style.css') !!}
        @yield('head-extra')
    </head>
    <body>
    	<div class="top-bar">
    		<span>Inköpslistor</span>
    		<a href="" class="button right action">{!! HTML::image('images/icons/create.png', '+') !!}</a>
    	</div>
    	<div class="top-push"></div>
    	<div class="content">
	        @yield('content')
	    </div>
    </body>
</html>
