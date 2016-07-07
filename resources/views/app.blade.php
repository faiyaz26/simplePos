<!DOCTYPE html>
<html ng-app="simplePos">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Simple POS</title>

	<link href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
	<script src="//code.jquery.com/jquery-2.2.0.min.js" crossorigin="anonymous"></script>
	<script src="{{asset('/js/jquery.print.js')}}" crossorigin="anonymous"></script>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/footer.css') }}" rel="stylesheet">
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet"  crossorigin="anonymous">

	<link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon" />


	{!! Html::style('css/print.css') !!}

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">Simple-POS</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">{{trans('menu.dashboard')}}</a></li>
					@if (Auth::check())
						<li><a href="{{ url('/customers') }}">{{trans('menu.customers')}}</a></li>
						<li><a href="{{ url('/items') }}">{{trans('menu.items')}}</a></li>
                        <li><a href="{{ url('/rules') }}">{{trans('menu.rules')}}</a></li>
                        <li><a href="{{ url('/discounts') }}">{{trans('menu.discounts')}}</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Sales <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/sales') }}">All Sales</a></li>
								<li><a href="{{ url('/sales?q=on-hold') }}">Sales On Hold</a></li>
							</ul>
						</li>

						<li><a href="{{ url('/pos') }}">{{trans('menu.pos')}}</a></li>
						<!--
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{trans('menu.reports')}} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/reports/receivings') }}">{{trans('menu.receivings_report')}}</a></li>
								<li><a href="{{ url('/reports/sales') }}">{{trans('menu.sales_report')}}</a></li>
							</ul>
						</li>
						-->
						<li><a href="{{ url('/users') }}">{{trans('menu.users')}}</a></li>
						<li><a href="{{ url('/reports') }}">Reports</a></li>
					@endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								@if ( Auth::user()->username == 'admin')
								<li><a href="{{ url('/settings') }}">{{trans('menu.application_settings')}}</a></li>
								@endif

								<li class="divider"></li>
								<li><a href="{{ url('/auth/logout') }}">{{trans('menu.logout')}}</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<footer class="footer hidden-print">
      <div class="container">
        <p class="text-muted">You are using <a href="#">Simple-POS</a> by <a href="#">Axiara Co.</a>.
        </p>
      </div>
    </footer>
	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
