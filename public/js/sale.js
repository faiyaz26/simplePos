(function(){
    var app = angular.module('simplePos', ['ui.bootstrap','selectize','cgPrompt']);
    app.directive('ngReallyClick', [function() {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                element.bind('click', function() {
                    var message = attrs.ngReallyMessage;
                    if (message && confirm(message)) {
                        scope.$apply(attrs.ngReallyClick);
                    }
                });
            }
        }
    }]);


    app.controller("PosCtrl",function($scope, $http, $window, prompt) {
        $scope.onlyNumbers = /^\d+$/;

        $scope.searchButtonText = "Fetch";
        $scope.test = "false";

        $scope.url = window.url + '/api/v1';

        console.log($scope.url);

        $scope.sale = {};


        $scope.items = [ ];
        $scope.charges = [];
        $scope.discountOptions = [];
        $scope.customerList = [];


        $scope.sale = {
            saleItems : [],
            discounts    : [],
            customerId   : 0,
            serviceType  : 'Check-In',
            paymentMode  : 'Cash',
            referenceNumber : '',
            tableInfo    : '',
            comment      : '',
            paid         : 0,
            status       : 'on-hold',
            pinCode      : ''
        }


        if(window.saleId != 0){
            $http.get($scope.url+'/sales/'+window.saleId).success(function(data, status, headers, config){
                $scope.sale = {
                    saleItems : data.items,
                    discounts    : data.discounts,
                    customerId   : data.customer_id,
                    serviceType  : data.service_type,
                    paymentMode  : data.payment_mode,
                    referenceNumber : data.reference_number,
                    tableInfo    : data.table_info,
                    comment      : data.comment,
                    paid         : data.paid,
                    status       : data.status
                };
                if(data.status == "done"){
                    location.reload();
                }
            });
        }


        $scope.refreshCustomerList = function () {
            $scope.test = "true";
            $scope.searchButtonText = "Fetching";
            // Do your searching here

            $http.get($scope.url+'/customers').success(function (data, status, headers, config) {
                //  console.log('sdsd', data);
                $scope.searchButtonText = "Fetch";
                $scope.customerList = data;
            });
        }


        $http.get($scope.url+'/items').success(function(data) {
            $scope.items = data;
        });


        /* Get Customer */
        $http.get($scope.url+'/customers').success(function(data, status, headers, config) {
            $scope.customerList = data;
        });


        /* Get Charges */
        $http.get($scope.url+'/charges').success(function(data, status, headers, config) {
            $scope.charges = data;
        });

        $http.get($scope.url+'/discounts').success(function(data, status, headers, config) {
            $scope.discountOptions = data;
        });



        $scope.customerListConfig = {
            create: false,
            searchField: ['name', 'phone_number'],
            valueField: 'id',
            labelField: 'name',
            delimiter: '|',
            placeholder: 'Pick someone',
            onInitialize: function(selectize){
                // receives the selectize object as an argument
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
        };

        /* Item Operation */
        $scope.addToInvoice = function(item){
            for(i = 0; i < $scope.sale.saleItems.length ; i++){
                if($scope.sale.saleItems[i].id == item.id){
                    $scope.sale.saleItems[i].quantity++;
                   // console.log($scope.invoiceItems);
                    return;
                }
            }
            item.quantity = 1;
            $scope.sale.saleItems.push(item);
            return;
        }



        $scope.removeItem = function(item){
            for(i=0;i< $scope.sale.saleItems.length ; i++){
                if(item.id == $scope.sale.saleItems[i].id){
                    $scope.sale.saleItems.splice(i, 1);
                    return;
                }
            }
        }


        /* Discount Operation */


        $scope.addDiscount = function(discount){
            console.log(discount);
            $scope.sale.discounts.push(angular.copy(discount));
            return;
        }

        $scope.getDiscountedPrice = function(amount, type){
            if(type == 2){
                return amount;
            }
            return ($scope.getGrossTotal() * parseFloat(amount))/100.0;
        }
        $scope.removeDiscount = function(item){
            for(i=0;i< $scope.sale.discounts.length ; i++){
                if(item.id == $scope.sale.discounts[i].id){
                    $scope.sale.discounts.splice(i, 1);
                    return;
                }
            }
            return;
        }


        function getDiscountSum(val){
            var sum = 0;
            angular.forEach($scope.sale.discounts, function(value, key) {
                sum += $scope.getDiscountedPrice($scope.sale.discounts[key].amount, $scope.sale.discounts[key].type);
            });

            return sum;
        }

        /* Charges Operation */
        function getChargeSum(val){
            var sum = 0;
            angular.forEach($scope.charges, function(value, key) {
                $scope.charges[key].value = val;
                if($scope.charges[key].type == 1){ // %
                    $scope.charges[key].value = ($scope.charges[key].value * parseFloat($scope.charges[key].amount))/100.0;
                }else{ // +
                    $scope.charges[key].value = (parseFloat($scope.charges[key].amount));
                }

                sum += $scope.charges[key].value;
            });
            return sum;
        }

        $scope.getTotalPayment = function(){
            var sum = $scope.getGrossTotal();

            sum -= getDiscountSum(sum);
            sum += getChargeSum(sum);

            return sum;
        }
        $scope.getGrossTotal = function(){
            var total=0;
            angular.forEach($scope.sale.saleItems , function(item){
                total+= parseFloat(item.selling_price * item.quantity);
            });
            return total;
        }

        $scope.getDue = function(){
            var val = $scope.sale.paid - $scope.getTotalPayment();
            return val;
        }


        $scope.completeSale = function(){
            if($scope.sale.saleItems.length == 0){
                prompt({
                    "title": "Error",
                    "message": "No item added to the list, please add some",
                    "buttons": [
                        {
                            "label": "Ok",
                            "cancel": true,
                            "primary": true
                        }
                    ]
                }).then(function(){
                    //he hit ok and not cancel
                    return;
                });
                return;
            }


            if($scope.getDue() < 0) {
              //  alert("You cannot complete sale unless due amount is non negative, please click on hold button");

                prompt({
                    "title": "Error",
                    "message": "You cannot complete sale unless due amount is non negative, please click on Hold button",
                    "buttons": [
                        {
                            "label": "Ok",
                            "cancel": true,
                            "primary": true
                        }
                    ]
                }).then(function(){
                    //he hit ok and not cancel
                    return;
                });
                return;
            }


            if(window.saleId == 0){
                prompt({
                    "title": "Confirmation",
                    "message": "Are you sure to complete the sale ?",
                    "buttons": [
                        {
                            "label": "Yes",
                            "cancel": false,
                            "primary": true
                        },
                        {
                            "label": "No",
                            "cancel": true,
                            "primary": false
                        }
                    ]
                }).then(function(){
                    //he hit ok and not cancel
                    $scope.storeSaleData();
                });
            }else{
                prompt({
                    "title": "Confirmation",
                    "message": "If you are sure to complete the sale, Please put the pin-code ?",
                    "input": true,
                    "label": "Pin-code",
                    "value": "",
                    "buttons": [
                        {
                            "label": "Submit",
                            "cancel": false,
                            "primary": true
                        },
                        {
                            "label": "Cancel",
                            "cancel": true,
                            "primary": false
                        }
                    ]
                }).then(function(pinCode){
                    //he hit ok and not cancel
                    $scope.sale.pinCode = pinCode;
                    $scope.storeSaleData();
                });
            }

            return;
        }

        $scope.holdSale = function(){
            if($scope.sale.saleItems.length == 0){
                prompt({
                    "title": "Error",
                    "message": "No item added to the list, please add some",
                    "buttons": [
                        {
                            "label": "Ok",
                            "cancel": true,
                            "primary": true
                        }
                    ]
                }).then(function(){
                    //he hit ok and not cancel
                    return;
                });
                return;
            }



            if(window.saleId == 0){
                prompt({
                    "title": "Confirmation",
                    "message": "Are you sure to hold the sale ?",
                    "buttons": [
                        {
                            "label": "Yes",
                            "cancel": false,
                            "primary": true
                        },
                        {
                            "label": "No",
                            "cancel": true,
                            "primary": false
                        }
                    ]
                }).then(function(){
                    //he hit ok and not cancel
                    $scope.storeSaleData();
                });
            }else{
                prompt({
                    "title": "Confirmation",
                    "message": "If you are sure to hold the sale, Please put the pin-code ?",
                    "input": true,
                    "label": "Pin-code",
                    "value": "",
                    "buttons": [
                        {
                            "label": "Submit",
                            "cancel": false,
                            "primary": true
                        },
                        {
                            "label": "Cancel",
                            "cancel": true,
                            "primary": false
                        }
                    ]
                }).then(function(pinCode){
                    //he hit ok and not cancel
                    $scope.sale.pinCode = pinCode;
                    $scope.storeSaleData();
                });
            }

            return;
        }

        $scope.storeSaleData = function (){

            if($scope.getDue() < 0) {
                $scope.sale.status = "on-hold";
            }else{
                $scope.sale.status = "done";
            }

            $scope.sale.charges = $scope.charges;

            console.log($scope.sale);
            var data = {
                saleData: JSON.stringify($scope.sale)
            };

            if(window.saleId == 0){
                $http.post($scope.url+"/sales", data).success(function(newData, status) {
                    if(newData.success == false){
                        alert(newData.message);
                        return;
                    }
                    window.location.href = window.url+'/receipt/'+newData.data.id;
                    $scope.clearSaleData();
                    return ;
                }).error(function(data,status,headers,config) {
                    alert("Something went wrong, please try again");
                });
            }else{
                $http.put($scope.url+"/sales/"+window.saleId, data).success(function(newData, status) {
                    if(newData.success == false){
                        alert(newData.message);
                        return;
                    }
                    window.location.href = window.url+'/receipt/'+newData.data.id;
                    $scope.clearSaleData();
                    return ;
                }).error(function(data,status,headers,config) {
                    alert("Something went wrong, please try again");
                });
            }

        }


        $scope.clearSaleData = function(){
            $scope.sale = {
                saleItems : [],
                discounts    : [],
                customerId   : 0,
                serviceType  : 'Check-In',
                paymentMode  : 'Cash',
                referenceNumber : '',
                tableInfo    : '',
                comment      : '',
                paid         : 0,
                status       : 'on-hold',
                pinCode      : ''
            }
        }

    });
})();