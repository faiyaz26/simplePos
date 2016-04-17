@extends('app')

@section('content')
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
						<h3 class="panel-title">{{trans('dashboard.statistics')}}</h3>
					  </div>
					  <div class="panel-body">
							<div class="row">
								<div class="col-md-4">
									<div class="well">{{trans('dashboard.total_users')}} : {{$users}}</div>
								</div>
							</div>

					  </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
