@extends('app')

@section('content')





    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Money Receipt</div>

                <div class="panel-body">
                    <button class="btn btn-info" id = "printReceipt"> Print Receipt</button>
                    <hr />
                    <div class="panel panel-default">
                        <div id="printable">
                            <div class="row">
                                <div class="col-xs-8 col-sm-8 col-md-8 col-md-offset-2 col-xs-offset-2 col-sm-offset-2">
                                    <p class="text-center">
                                        {!! $data['receiptHeader'] !!}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-8 col-sm-8 col-md-8 col-md-offset-2 col-xs-offset-2 col-sm-offset-2">
                                    <p class="text-center">
                                        <em>Time: {{ date('d-M-Y h:i A', strtotime($data['updated_at'])) }}</em>
                                    </p>
                                    <p class="text-center">
                                        <em>Receipt #: {{ $data['id'] }}</em>
                                    </p>
                                </div>
                            </div>
                            <hr style="border-top: dashed  2px;" />
                            <table class="table table-borderless table-condensed">
                                <thead>
                                <th class="col-md-1" style="text-align: center">
                                    Qty
                                </th>
                                <th class="col-md-9">
                                    Item Name
                                </th>
                                <th class="col-md-1 text-center">
                                    Price
                                </th>
                                <th class="col-md-1 text-center">
                                    T.Price
                                </th>
                                </thead>
                                <tbody>
                                @foreach ( $data['items'] as $key => $value )
                                    <tr>
                                        <td class="col-md-1" style="text-align: center">
                                            {{ $value['quantity'] }}
                                        </td>
                                        <td class="col-md-9">
                                            {{ substr($value['name'], 0, 30) }}
                                        </td>
                                        <td  class="col-md-1 text-center">
                                            {{ $value['selling_price'] }}
                                        </td>
                                        <td  class="col-md-1 text-center">
                                            {{ number_format($value['selling_price'] * $value['quantity'], 2, '.', '')  }}
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <hr style="border-top: 3px double #8c8b8b;" />

                            <table class="table table-borderless table-condensed" style="margin: 0px;">
                                <tr>
                                    <td class="col-md-1"></td>
                                    <td class="col-md-10" style="text-align: left">
                                        <b>GROSS TOTAL :</b>
                                    </td>
                                    <td class="col-md-1 text-center">
                                        {{ number_format($data['grossTotal'], 2, '.', '')  }}
                                    </td>
                                </tr>
                            </table>
                            <hr style="border-top: 3px double #8c8b8b;" />


                            <table class="table table-borderless table-condensed" style="margin: 0px;">
                                @foreach($data['discounts'] as $discount)
                                    <tr>
                                        <td class="col-md-1"></td>
                                        <td class="col-md-10" style="text-align: left">
                                            <b>{{ $discount['name'] }}</b>
                                            <b>{{ $discount['amount'] }}</b>
                                            <b>{{ ($discount['type'] == 1)?'%':'-' }}</b>
                                        </td>
                                        <td class="col-md-1 text-center">
                                            -{{  number_format($discount['value'], 2, '.', '') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <table class="table table-borderless table-condensed" style="margin: 0px;">
                                @foreach($data['charges'] as $charge)
                                    <tr>
                                        <td class="col-md-1"></td>
                                        <td class="col-md-10" style="text-align: left">
                                            <b>{{ $charge['name'] }}</b>
                                            <b>{{ $charge['amount'] }}</b>
                                            <b>{{ ($charge['type'] == 1)?'%':'-' }}</b>
                                        </td>
                                        <td class="col-md-1 text-center">
                                            {{ number_format($charge['value'], 2, '.', '') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <hr style="border-top: 3px double #8c8b8b;" />
                            <h4 style="margin: 10px 5%;">
                                <b>Total Payment:  {{ number_format($data['totalPayment'], 2, '.', '') }}</b>
                            </h4>
                            <div class="payment" >
                                <b>Payment: </b> <br/>
                                <p>
                                    Payment Mode: {{$data['payment_mode']}}
                                </p>
                                <p>
                                    Paid : {{ number_format($data['paid'], 2, '.', '')  }}
                                </p>
                                <p>
                                    Returned : {{ number_format($data['returnAmount'], 2, '.', '') }}
                                </p>
                                <p>
                                    <b></b>{{ $data['paymentDone'] }}</b>
                                </p>
                            </div>

                            <hr style="border-top: 3px double #8c8b8b;" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('#printReceipt').on('click', function(){
                $("#printable").print({
                    globalStyles: true,
                    mediaPrint: true,
                    stylesheet: null,
                    noPrintSelector: ".no-print",
                    iframe: true,
                    append: null,
                    prepend: null,
                    manuallyCopyFormValues: true,
                    deferred: $.Deferred(),
                    timeout: 250,
                    title: null,
                    doctype: '<!doctype html>'
                });

            });

        });

    </script>

@endsection