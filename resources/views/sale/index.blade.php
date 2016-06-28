@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Sales</div>
               
				<div class="panel-body">
				<a class="btn btn-small btn-success" href="{{ URL::to('pos') }}">New Sale</a>
				<hr />
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Sale ID</td>
            <td>Date</td>
            <td>Item Count</td>
            <td>Total Payment</td>
            <td>Table Info</td>
            <td>Comments</td>
            <td> Status </td>
            <td>&nbsp</td>
        </tr>
    </thead>
    <tbody>
    @foreach($sales as $sale)
        <tr>
            <td>{{ $sale->id }}</td>
            <td>{{ $sale->updated_at }}</td>
            <td>{{ $sale->items->count() }}</td>
            <td>{{ $sale->saleAmountWithCharge() }}</td>
            <td>{{ $sale->table_info }}</td>
            <td>{{ substr($sale->comments, 0, 20) }}</td>
            <td>{{ $sale->status }} </td>
            <td>
                @if ($sale->status == 'on-hold')
                    <a target="_blank" href="{{ url('/pos/'.$sale->id.'/edit')}}"> Edit </a> |
                @endif
                <a target = "_blank" href="{{ url('/receipt/'.$sale->id)}}"> Receipt </a>
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