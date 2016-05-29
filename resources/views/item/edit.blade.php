@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('item.update_item')}}</div>

				<div class="panel-body">
					{!! Html::ul($errors->all()) !!}

					{!! Form::model($item, array('route' => array('items.update', $item->id), 'method' => 'PUT', 'files' => false)) !!}

					<div class="form-group">
						{!! Form::label('code', trans('item.item_code')) !!}
						{!! Form::text('code', Input::old('code'), array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('category', 'Category*') !!}
					{!! Form::select('category', ['drinks' => 'Drinks', 'main_course' => 'Main Course'], Input::old('category'), ['placeholder' => 'Select Category', 'class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						{!! Form::label('name', trans('item.item_name').' *') !!}
						{!! Form::text('name', Input::old('name'), array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
						{!! Form::label('description', trans('item.description')) !!}
						{!! Form::textarea('description', Input::old('description'), array('class' => 'form-control')) !!}
					</div>


					<div class="form-group">
					{!! Form::label('cost_price', trans('item.cost_price')) !!}
					{!! Form::text('cost_price', null, array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('selling_price', trans('item.selling_price')) !!}
					{!! Form::text('selling_price', null, array('class' => 'form-control')) !!}
					</div>



					{!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary')) !!}

					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection