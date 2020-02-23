<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Products</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
		<script  src="https://code.jquery.com/jquery-3.4.1.min.js" ></script>

         <link href="{{asset('css/app.css')}}" rel="stylesheet">
    </head>
    <body>
	<div class="container">
      @yield('content');
	  </div>
    </body>
</html>
