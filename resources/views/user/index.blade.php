@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('user.list_users')}}</div>

				<div class="panel-body">
				<a class="btn btn-small btn-success" href="{{ URL::to('users/create') }}">{{trans('user.new_user')}}</a>
				<hr />
                @if (Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>{{trans('user.person_id')}}</td>
                            <td>{{trans('user.name')}}</td>
                            <td>{{trans('user.username')}}</td>
                            <td>{{trans('user.email')}}</td>
                            <td>&nbsp;</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->username}} </td>
                            <td>{{ $value->email }}</td>
                            <td>

                                <a class="btn btn-small btn-info" href="{{ URL::to('users/' . $value->id . '/edit') }}">{{trans('user.edit')}}</a>
                                {!! Form::open(array('url' => 'users/' . $value->id, 'class' => 'pull-right')) !!}
                                    {!! Form::hidden('_method', 'DELETE') !!}
                                    {!! Form::submit(trans('user.delete'), array('class' => 'btn btn-warning')) !!}
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