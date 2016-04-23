@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('discount.new')}}</div>

				<div class="panel-body">
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
					{!! Html::ul($errors->all()) !!}

					{!! Form::open(array('url' => 'discounts', 'files' => false)) !!}
					{!! Form::hidden('username', csrf_token()) !!}
					<div class="form-group">
					{!! Form::label('name', trans('discount.name').'*') !!}
					{!! Form::text('name', Input::old('name'), array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('type', trans('discount.type').' *') !!}
					{!! Form::select('type', array('1' => '%', '2' => '-'), Input::old('type'), array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
						{!! Form::label('amount', trans('discount.amount').'*') !!}
						{!! Form::text('amount', Input::old('amount'), array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('description', trans('discount.description')) !!}
					{!! Form::textarea('description', Input::old('description'), array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
						{!! Form::label('active', trans('discount.active')) !!}
						{!! Form::checkbox('active', 1 ,Input::old('active'), array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
						{!! Form::label('automatic', trans('discount.automatic')) !!}
						{!! Form::checkbox('automatic', 1, Input::old('automatic'), array('class' => 'form-control')) !!}
					</div>

					{!! Form::submit(trans('discount.submit'), array('class' => 'btn btn-primary')) !!}

					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection