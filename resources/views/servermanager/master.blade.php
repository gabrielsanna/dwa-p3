<!DOCTYPE html>
<html>
<head>
	<title>Project 3</title>
	<meta charset='utf-8'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="/css/foobooks.css" type='text/css' rel='stylesheet'>

    @stack('head')
</head>
<body>

	<header>
		<h1>Project 3</h1>
	</header>

	<section>
		@yield('content')
	</section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    @stack('body')

</body>
</html>