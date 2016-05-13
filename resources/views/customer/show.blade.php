@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Customer Information</div>

                    <div class="panel-body">
                        {!! Html::ul($errors->all()) !!}

                        {!! Form::model($customer, array('route' => array('customers.update', $customer->id), 'method' => 'PUT', 'files' => false)) !!}

                        <div class="form-group">
                            {!! Form::label('name', trans('customer.name').' *') !!}
                            {!! Form::text('name', null, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('email', trans('customer.email')) !!}
                            {!! Form::text('email', null, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('phone_number', trans('customer.phone_number')) !!}
                            {!! Form::text('phone_number', null, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('addrees', trans('customer.address')) !!}
                            {!! Form::text('address', null, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('city', trans('customer.city')) !!}
                            {!! Form::text('city', null, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('zip', trans('customer.zip')) !!}
                            {!! Form::text('zip', null, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('comment', trans('customer.comment')) !!}
                            {!! Form::textarea('comment', Input::old('comment'), array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                        </div>

                        <a class="btn btn-info" href="{{ url('/customers/'.$customer->id.'/edit') }}">Edit</a>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection