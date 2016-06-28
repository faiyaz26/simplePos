@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">App Settings</div>

                    <div class="panel-body">
                        Set Up application
                        <hr />
                        <div class="panel panel-default">

                            <div class="panel-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                                @endif
                                {!! Form::open(array('url' => 'settings', 'files' => false)) !!}
                                    <div class="form-group">
                                        {!! Form::label('company', 'Company Name') !!}
                                        {!! Form::text('company', $data['company'], array('class' => 'form-control')) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('receiptHeader', 'Money Receipt Header') !!}
                                        {!! Form::textarea('receiptHeader', $data['receiptHeader'], array('class' => 'form-control')) !!}

                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('pinCode', 'Pin Code') !!}
                                        {!! Form::text('pinCode', $data['pinCode'], array('class' => 'form-control')) !!}
                                    </div>
                                    {!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary')) !!}
                                {!! Form::close() !!}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection