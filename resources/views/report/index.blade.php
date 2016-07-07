@extends('app')

@section('content')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Report</div>

                    <div class="panel-body">
                        <div class="well">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="text-center">Report from {{$data['startDate']->format('j F, Y')}}
                                        to {{ $data['endDate']->format('j F, Y') }}</h2>
                                </div>
                            </div>
                            </br>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-2">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label for="startDate">Start Date</label>
                                            <input type="text" class="form-control datepicker" name="startDate"
                                                   id="startDate" value="{{$data['startDate']->format('Y-m-d')}}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="endDate">End Date</label>
                                            <input type="text" class="form-control datepicker" name="endDate"
                                                   id="endDate" value="{{$data['endDate']->format('Y-m-d')}}"/>
                                        </div>
                                        <button type="submit" class="btn btn-default">Generate</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <th>Date</th>
                                    <th>Total Sale Count</th>
                                    <th>Total Item Count</th>
                                    <th>Total Drinks Count</th>
                                    <th>Total Main Course Count</th>
                                    <th>Total Sale Amount</th>
                                    <th>Total Profit</th>
                                    <th>Total Payment Received</th>
                                    </thead>
                                    <tbody>
                                    @foreach ($data['sales'] as $sale)
                                        <tr>
                                            <td class="col-md-2">
                                                {{ $sale['date']->format('j M Y') }}
                                            </td>
                                            <td class="col-md-1">
                                                {{ $sale['saleCount'] }}
                                            </td>
                                            <td class="col-md-1">
                                                {{ $sale['saleItemCount'] }}
                                            </td>
                                            <td class="col-md-1">
                                                {{ $sale['drinksItemCount'] }}
                                            </td>
                                            <td class="col-md-1">
                                                {{ $sale['mainCourseCount'] }}
                                            </td>
                                            <td class="col-md-1">
                                                {{ $sale['saleAmount'] }}
                                            </td>
                                            <td class="col-md-1">
                                                {{ $sale['saleProfit'] }}
                                            </td>
                                            <td class="col-md-1">
                                                {{ $sale['salePaymentReceived'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td class="col-md-2">Sum</td>
                                        <td class="col-md-1">{{ array_sum(array_column($data['sales'],'saleCount')) }}</td>
                                        <td class="col-md-1">{{ array_sum(array_column($data['sales'],'saleItemCount')) }}</td>
                                        <td class="col-md-1">{{ array_sum(array_column($data['sales'],'drinksItemCount')) }}</td>
                                        <td class="col-md-1">{{ array_sum(array_column($data['sales'],'mainCourseCount')) }}</td>
                                        <td class="col-md-1">{{ array_sum(array_column($data['sales'],'saleAmount')) }}</td>
                                        <td class="col-md-1">{{ array_sum(array_column($data['sales'],'saleProfit')) }}</td>
                                        <td class="col-md-1">{{ array_sum(array_column($data['sales'],'salePaymentReceived')) }}</td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
            });
        });
    </script>
@endsection
