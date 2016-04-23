@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('rule.list')}}</div>
               
				<div class="panel-body">
				<a class="btn btn-small btn-success" href="{{ URL::to('discounts/create') }}">{{trans('discount.new')}}</a>
				<hr />
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>{{trans('discount.id')}}</td>
            <td>{{trans('discount.name')}}</td>
            <td>{{trans('discount.type')}}</td>
            <td>{{trans('discount.amount')}}</td>
            <td>{{trans('discount.active')}}</td>
            <td>{{trans('discount.automatic')}}</td>
            <td>&nbsp;</td>
        </tr>
    </thead>
    <tbody>
    @foreach($discounts as $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ ($value->type == 1)?'%':'-' }}</td>
            <td>{{ $value->amount }}</td>
            <td>{{ ($value->active == 1)?"Yes":"No" }}</td>
            <td>{{ ($value->automatic == 1)?"Yes":"No" }}</td>
            <td>

                <a class="btn btn-small btn-info" href="{{ URL::to('discounts/' . $value->id . '/edit') }}">{{trans('rule.edit')}}</a>
                {!! Form::open(array('url' => 'discounts/' . $value->id, 'class' => 'pull-right')) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    {!! Form::submit(trans('rule.delete'), array('class' => 'btn btn-warning')) !!}
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection