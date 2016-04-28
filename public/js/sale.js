(function(){
    var app = angular.module('tutapos', ['selectize']);
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
    app.controller("SearchItemCtrl", [ '$scope', '$http', function($scope, $http) {
        $scope.onlyNumbers = /^\d+$/;

        $scope.paid = 0;
        $scope.items = [ ];
        $http.get('api/v1/items').success(function(data) {
            $scope.items = data;
        });
        $scope.saletemp = [ ];
        $scope.newsaletemp = { };

        $scope.invoiceItems = [];


        $scope.charges = [];

        $scope.discountOptions = [];
        $scope.discountTrack = [];

        $scope.customerList = [];
        $scope.customer = undefined;

        $http.get('api/v1/customers').success(function(data, status, headers, config) {
          //  console.log('sdsd', data);
            $scope.customerList = data;
        });

        $http.get('api/v1/charges').success(function(data, status, headers, config) {
            $scope.charges = data;
        });

        $http.get('api/v1/discounts').success(function(data, status, headers, config) {
            $scope.discountOptions = data;
        });

        $scope.addDiscount = function(discount){
            $scope.discountTrack.push(angular.copy(discount));
            return;
        }


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
                        (item.name ? '<span class="name">' + escape(item.name) + '</span>' : '') +
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
            }
            // maxItems: 1
        };


        $scope.getDiscountedPrice = function(amount, type){
            if(type == 2){
                return amount;
            }
            return ($scope.getTotal() * parseFloat(amount))/100.0;
        }
        $scope.removeDiscount = function(item){
            for(i=0;i< $scope.discountTrack.length ; i++){
                if(item.id == $scope.discountTrack[i].id){
                    $scope.discountTrack.splice(i, 1);
                    return;
                }
            }
            return;
        }
        $scope.addToInvoice = function(item){
            for(i = 0; i < $scope.invoiceItems.length ; i++){
                if($scope.invoiceItems[i].id == item.id){
                    $scope.invoiceItems[i].quantity++;
                   // console.log($scope.invoiceItems);
                    return;
                }
            }
            item.quantity = 1;
            $scope.invoiceItems.push(item);
            return;
        }



        $scope.removeItem = function(item){
            for(i=0;i< $scope.invoiceItems.length ; i++){
                if(item.id == $scope.invoiceItems[i].id){
                    $scope.invoiceItems.splice(i, 1);
                    return;
                }
            }
        }

        $scope.addSaleTemp = function(item, newsaletemp) {
            $http.post('api/saletemp', { item_id: item.id, cost_price: item.cost_price, selling_price: item.selling_price }).
            success(function(data, status, headers, config) {
                $scope.saletemp.push(data);
                    $http.get('api/saletemp').success(function(data) {
                    $scope.saletemp = data;
                    });
            });
        }
        $scope.updateSaleTemp = function(newsaletemp) {
            
            $http.put('api/saletemp/' + newsaletemp.id, { quantity: newsaletemp.quantity, total_cost: newsaletemp.item.cost_price * newsaletemp.quantity,
                total_selling: newsaletemp.item.selling_price * newsaletemp.quantity }).
            success(function(data, status, headers, config) {
                
                });
        }
        $scope.removeSaleTemp = function(id) {
            $http.delete('api/saletemp/' + id).
            success(function(data, status, headers, config) {
                $http.get('api/saletemp').success(function(data) {
                        $scope.saletemp = data;
                        });
                });
        }

        $scope.getTotal = function(){
            var sum = $scope.getTotalWithRealPrice();
            angular.forEach($scope.charges, function(value, key) {
                $scope.charges[key].value = $scope.getTotalWithRealPrice();
                if($scope.charges[key].type == 1){ // %
                    $scope.charges[key].value = ($scope.charges[key].value * parseFloat($scope.charges[key].amount))/100.0;
                }else{ // +
                    $scope.charges[key].value = (parseFloat($scope.charges[key].amount));
                }

                sum += $scope.charges[key].value;
            });
            return sum;
        }
        $scope.getTotalWithRealPrice = function(){
            var total=0;
            angular.forEach($scope.invoiceItems , function(item){
                total+= parseFloat(item.selling_price * item.quantity);
            });
            return total;
        }

        $scope.getDue = function(){
            var val = $scope.paid - $scope.getTotal();
            return val;
        }

    }]);
})();