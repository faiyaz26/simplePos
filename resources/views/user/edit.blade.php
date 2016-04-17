@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('user.update_user')}}</div>

				<div class="panel-body">
					{!! Html::ul($errors->all()) !!}

					{!! Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) !!}
					<div class="form-group">
					{!! Form::label('name', trans('user.name').' *') !!}
					{!! Form::text('name', null, array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
						{!! Form::label('username', trans('user.username').' *') !!}
						{!! Form::text('username', null, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('email', trans('user.email').' *') !!}
					{!! Form::text('email', null, array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('password', trans('user.password')) !!}
					<input type="password" class="form-control" name="password" placeholder="Password">
					</div>

					<div class="form-group">
					{!! Form::label('password_confirmation', trans('user.confirm_password')) !!}
					<input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
					</div>

					{!! Form::submit(trans('user.submit'), array('class' => 'btn btn-primary')) !!}

					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection