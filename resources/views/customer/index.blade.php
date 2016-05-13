@extends('app')

@section('content')
    <link rel="stylesheet" href="bower_components/selectize/dist/css/selectize.default.css ">
    <script type="text/javascript" src="bower_components/selectize/dist/js/standalone/selectize.min.js"></script>

    <div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('customer.list_customers')}}</div>

				<div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a class="btn btn-small btn-success" href="{{ URL::to('customers/create') }}">{{trans('customer.new_customer')}}</a>
                        </div>
                        <div class="col-md-6">
                            <select id="customer-search" placeholder="Pick some one..."></select>
                        </div>
                    </div>

				<hr />
@if (Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>{{trans('customer.customer_id')}}</td>
            <td>{{trans('customer.name')}}</td>
            <td>{{trans('customer.email')}}</td>
            <td>{{trans('customer.phone_number')}}</td>
            <td>&nbsp;</td>
        </tr>
    </thead>
    <tbody>
    @foreach($customer as $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->email }}</td>
            <td>{{ $value->phone_number }}</td>
            <td>
                <a class="btn btn-small btn-info" href="{{ URL::to('customers/' . $value->id ) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                <a class="btn btn-small btn-primary" href="{{ URL::to('customers/' . $value->id . '/edit') }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                {!! Form::open(array('url' => 'customers/' . $value->id, 'style' => 'display: inline;')) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    <button type="submit" class="btn btn-small btn-warning"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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

    <script>
        jQuery(document).ready(function($) {
            $.get( "{{url('api/v1/customers')}}", function( data ) {
                $('#customer-search').selectize({
                    create: false,
                    searchField: ['name', 'phone_number'],
                    valueField: 'id',
                    labelField: 'name',
                    delimiter: '|',
                    options: data,
                    placeholder: 'Pick someone',
                    onInitialize: function(selectize){
                        // receives the selectize object as an argument
                    },
                    onChange : function(value){
                        window.location.href = "{{url('customers')}}" + "/" + value;
                        return;
                    },
                    render: {
                        item: function (item, escape) {
                            return '<div>' +
                                    (item.name ? '<span class="name">' + escape(item.name) + '</span>' : ' ') +
                                    (item.phone_number ? '<span class="email">' + escape(item.phone_number) + '</span>' : '') +
                                    '</div>';
                        },
                        option: function(item, escape) {
                            var label = item.name || item.phone_number;
                            var caption = item.phone_number ? item.phone_number : null;
                            return '<div>' +
                                    '<strong>' + escape(label) + '</strong>' +
                                    (caption ? '<p class="caption">' + escape(caption) + '</p>' : '') +
                                    '</div>';
                        }
                    },
                    maxItems: 1
                });
            });


        });
    </script>
@endsection