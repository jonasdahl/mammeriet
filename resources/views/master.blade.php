<!DOCTYPE html>
<html>
    <head>
        <title>@yield('html-title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        {!! HTML::style('css/style.css') !!}
        {!! HTML::script('js/jquery.js') !!}
        @yield('head-extra')
    </head>
    <body>
        <div class="wrapper">
        	<div class="top-bar">
                <div class="inner">
        		    @yield('top-bar')
                </div>
        	</div>
        	<div class="top-push"></div>
        	<div class="content">
                <div class="inner">
        			@include('includes.messages')
        	        @yield('content')
                </div>
    	    </div>
        </div>
    </body>
</html>
