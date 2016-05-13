@extends('app')

@section('content')
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Dashboard</div>

				<div class="panel-body">
					{{ trans('dashboard.welcome') }}
					<hr />
					<div class="panel panel-default">
					  <div class="panel-heading">
						  <div class="row">
							  <div class="col-md-3">
								  <h3 class="panel-title">{{$saleInfo['date']}}'s Stat</h3>
							  </div>
							  <div class="col-md-4">
								  Date: <input type="text" class= "form-control" id="datepicker">
							  </div>
						  </div>


					  </div>
					  <div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<div class="well">Total Number of Sale: {{$saleInfo['saleCount']}}</div>
									<div class="well">Total Number of Item Sale: {{$saleInfo['saleItemCount']}}</div>
									<div class="well">Total Sale Amount : {{$saleInfo['saleAmount']}}</div>
									<div class="well">Total Payment Received : {{$saleInfo['salePaymentReceived']}}</div>
								</div>
							</div>

					  </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<script>
		$(function() {
			$( "#datepicker" ).datepicker({
				onSelect: function(date) {
					var url = "{{url('/')}}" + "?date="+ date;
					window.location.href = url;
					return;
				},
				dateFormat: 'yy-mm-dd',

			}).datepicker("setDate", "0");;
		});
	</script>
@endsection
