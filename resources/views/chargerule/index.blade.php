@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('rule.list_rules')}}</div>
               
				<div class="panel-body">
				<a class="btn btn-small btn-success" href="{{ URL::to('rules/create') }}">{{trans('rule.new_rule')}}</a>
				<hr />
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>{{trans('rule.charge_id')}}</td>
            <td>{{trans('rule.charge_name')}}</td>
            <td>{{trans('rule.charge_type')}}</td>
            <td>{{trans('rule.charge_amount')}}</td>
            <td>{{trans('rule.charge_active')}}</td>
            <td>&nbsp;</td>
        </tr>
    </thead>
    <tbody>
    @foreach($rules as $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ ($value->type == 1)?'%':'+' }}</td>
            <td>{{ $value->amount }}</td>
            <td>{{ ($value->active == 1)?"Yes":"No" }}</td>
            <td>

                <a class="btn btn-small btn-info" href="{{ URL::to('rules/' . $value->id . '/edit') }}">{{trans('rule.edit')}}</a>
                {!! Form::open(array('url' => 'rules/' . $value->id, 'class' => 'pull-right')) !!}
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