@extends('app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">{{trans('rule.update_rule')}}</div>

					<div class="panel-body">
						@if (Session::has('message'))
							<div class="alert alert-info">{{ Session::get('message') }}</div>
						@endif
						{!! Html::ul($errors->all()) !!}

						{!! Form::model($rule, array('route' => array('rules.update', $rule->id), 'method' => 'PUT', 'files' => false)) !!}
						{!! Form::hidden('username', csrf_token()) !!}
						<div class="form-group">
							{!! Form::label('name', trans('rule.charge_name').'*') !!}
							{!! Form::text('name', Input::old('name'), array('class' => 'form-control')) !!}
						</div>

						<div class="form-group">
							{!! Form::label('type', trans('rule.charge_type').' *') !!}
							{!! Form::select('type', array('1' => '%', '2' => '+'), Input::old('type'), array('class' => 'form-control')) !!}
						</div>

						<div class="form-group">
							{!! Form::label('amount', trans('rule.charge_amount').'*') !!}
							{!! Form::text('amount', Input::old('amount'), array('class' => 'form-control')) !!}
						</div>

						<div class="form-group">
							{!! Form::label('description', trans('rule.description')) !!}
							{!! Form::textarea('description', Input::old('description'), array('class' => 'form-control')) !!}
						</div>

						<div class="form-group">
							{!! Form::label('active', trans('rule.active')) !!}
							{!! Form::checkbox('active', 1,  Input::old('active'), array('class' => 'form-control')) !!}
						</div>

						{!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary')) !!}

						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection