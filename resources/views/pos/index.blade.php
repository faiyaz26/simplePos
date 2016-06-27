@extends('app')
@section('content')
{!! Html::script('bower_components/angular/angular.min.js', array('type' => 'text/javascript')) !!}
{!! Html::script('js/sale.js?v=121', array('type' => 'text/javascript')) !!}
{!! Html::style('bower_components/selectize/dist/css/selectize.default.css') !!}
{!! Html::script('bower_components/selectize/dist/js/standalone/selectize.min.js', array('type' => 'text/javascript')) !!}
{!! Html::script('bower_components/angular-selectize2/dist/angular-selectize.js', array('type' => 'text/javascript')) !!}
{!! Html::script('bower_components/angular-bootstrap/ui-bootstrap.min.js', array('type' => 'text/javascript')) !!}
{!! Html::script('bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js', array('type' => 'text/javascript')) !!}
{!! Html::script('bower_components/angular-prompt/dist/angular-prompt.min.js', array('type' => 'text/javascript')) !!}

<div class="container-fluid">
   <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> {{trans('sale.sales_register')}}</div>

            <div class="panel-body pos-body">

                @if (Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif
                {!! Html::ul($errors->all()) !!}
                
                <div class="row" ng-controller="PosCtrl">

                    <div class="col-md-4 ">
                        <label>{{trans('sale.search_item')}} <input ng-model="searchKeyword" class="form-control"></label>

                        <div class="list-group item-list">
                            <a href="#" class="list-group-item singleItem" ng-repeat="item in items  | filter: searchKeyword" ng-click="addToInvoice(item)">
                                <h4 class="list-group-item-heading">@{{item.name}}</h4>
                                <p class="list-group-item-text">@{{item.description}}</p>
                            </a>
                        </div>
                        <!--
                        <table class="table table-hover">
                            <tr ng-repeat="item in items  | filter: searchKeyword | limitTo:10">

                                <td>@{{item.name}}</td>
                                <td><button class="btn btn-success btn-xs" type="button" ng-click="addSaleTemp(item, newsaletemp)"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></button></td>

                            </tr>
                        </table>
                        -->
                    </div>

                    <div class="col-md-8">

                        <div class="row">
                            
                            {!! Form::open(array('url' => 'sales', 'class' => 'form-horizontal')) !!}

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="user" class="col-sm-3 control-label">{{trans('sale.user')}}</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="user" value="{{ Auth::user()->username }}" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="user" class="col-sm-3 control-label">{{trans('sale.customer')}}</label>
                                        <div class="col-md-7">
                                            <selectize config='customerListConfig' options='customerList' ng-model="sale.customerId"></selectize>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="#" class="btn btn-primary" ng-click="refreshCustomerList()">
                                                <span ng-show="searchButtonText == 'Fetching'"><i class="glyphicon glyphicon-refresh spinning"></i></span>
                                                @{{ searchButtonText }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <a target="_blank" href="{{url('customers/create') }}"> Create New Customer </a>
                                </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12" style="min-height: 300px;">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>{{trans('sale.item_name')}}</th>
                                        <th>Category</th>
                                        <th>{{trans('sale.price')}}</th>
                                        <th>{{trans('sale.quantity')}}</th>
                                        <th>{{trans('sale.total')}}</th>
                                        <th></th>
                                    </tr>
                                    <tr ng-repeat="item in sale.saleItems">
                                        <td>
                                            @{{ item.name }}
                                        </td>
                                        <td>
                                            @{{ item.category }}
                                        </td>
                                        <td>
                                            @{{ item.selling_price }}
                                        </td>
                                        <td>
                                            <input type="number" ng-model = "item.quantity" maxlength="4" size="4" min="0" ng-pattern="onlyNumbers"/>
                                        </td>
                                        <td>
                                            @{{item.selling_price * item.quantity | currency}}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-xs" aria-label="Left Align" ng-really-message="Are you sure to delete the item ?"  ng-really-click="removeItem(item)">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </button>


                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_type" class="col-sm-4 control-label">{{trans('sale.service_type')}}</label>
                                        <div class="col-sm-8">
                                            <select required ng-model="sale.serviceType" class="form-control">
                                                <option value="Check-In">Check-In</option>
                                                <option value="Take-Away">Take-Away</option>
                                                <option value="Home-Delivery">Home-Delivery</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="form-group">
                                        <label for="total" class="col-sm-4 control-label">{{trans('sale.add_payment')}}</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input type="number" class="form-control" id="add_payment" ng-model="sale.paid"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="form-group">
                                        <label for="payment_type" class="col-sm-4 control-label">{{trans('sale.payment_type')}}</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" ng-model="sale.paymentMode">
                                                <option value="Cash" selected>Cash</option>
                                                <option value="Check">Check</option>
                                                <option value="Debit_Card">Debit Card</option>
                                                <option value="Credit_Card">Credit Card</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="form-group">
                                        <label for="employee" class="col-sm-4 control-label">{{trans('sale.reference_no')}}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="comments" id="reference" ng-model="sale.referenceNumber"/>
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="form-group">
                                        <label for="employee" class="col-sm-4 control-label">{{trans('sale.table_info')}}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="tableInfo" id="tableInfo" ng-model="sale.tableInfo"/>
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="form-group">
                                        <label for="employee" class="col-sm-4 control-label">{{trans('sale.comments')}}</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" name="comments" id="comments" ng-model="sale.comment"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="discount" class="col-sm-4 control-label">Discounts</label>
                                        <div class="col-sm-8" class="form-control" style="margin-top: 10px;">
                                            <div class="span1" ng-repeat="discount in discountOptions">
                                                <a href="#" class="btn btn-primary btn-lg" ng-really-message="Are you sure to add the discount ?"  ng-really-click="addDiscount(discount)">
                                                    <i class="icon-pencil icon-white"></i>
                                                    <span>
                                                        <strong>@{{discount.name}}</strong>
                                                        <p>
                                                            @{{discount.amount | number : 2}}
                                                            @{{ (discount.type == 1)?'%':'-' }}
                                                        </p>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-sm-6 control-label">{{trans('sale.sum')}}</label>
                                        <div class="col-sm-6">
                                            <p class="form-control-static">
                                                <span>BDT </span><b>@{{getGrossTotal()}}</b>
                                            </p>
                                        </div>
                                    </div>


                                    <div class="form-group" ng-repeat="discount in sale.discounts">
                                        <label for="@{{discount.name}}" class="col-sm-6 control-label">@{{discount.name}} @{{discount.amount}} @{{discount.type ==1 ? '%' : '-'}}</label>
                                        <div class="col-sm-6">
                                            <p class="form-control-static">
                                                <span>- BDT </span>@{{ getDiscountedPrice(discount.amount, discount.type) | number: 2}}
                                                <span>
                                                    <button type="button" class="btn btn-danger btn-xs" aria-label="Right Align" ng-click="removeDiscount(discount)">
                                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                    </button>
                                                </span>
                                            </p>
                                        </div>
                                    </div>



                                    <div class="form-group" ng-repeat="charge in charges">
                                        <label for="@{{charge.name}}" class="col-sm-6 control-label">@{{charge.name}} @{{charge.amount}} @{{charge.type ==1 ? '%' : '+'}}</label>
                                        <div class="col-sm-6">
                                            <p class="form-control-static"><span>+ BDT </span>@{{ charge.value | number: 2}}</p>
                                        </div>
                                    </div>





                                    <div class="form-group">
                                        <label for="supplier_id" class="col-sm-6 control-label">{{trans('sale.grand_total')}}</label>
                                        <div class="col-sm-6">
                                            <p class="form-control-static">
                                                <span>BDT </span><b>@{{getTotalPayment() | number: 2 }}</b>
                                            </p>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label for="amount_due" class="col-sm-6 control-label">{{trans('sale.amount_due')}}</label>
                                        <div class="col-sm-6">
                                            <p class="form-control-static"><span>BDT </span>@{{ getDue() | number: 2 }}</p>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <button type="button" class="btn btn-success btn-block" ng-click="completeSale()">{{trans('sale.submit')}}</button>
                                            <button type="button" class="btn btn-warning btn-block" ng-click="holdSale()">{{trans('sale.hold')}}</button>
                                            <button type="button" class="btn btn-danger btn-block" ng-really-message="Are you sure to clear data ?"  ng-really-click="clearSaleData()">{{trans('sale.clear')}}</button>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            {!! Form::close() !!}
                            
                        

                    </div>

                </div>

            </div>
            </div>
        </div>
    </div>
</div>
    <script>
        window.saleId = {{ $data['id'] }};
        window.edit   = {{ $data['edit'] }};
        window.url    = "{{ url('/') }}";
    </script>
@endsection