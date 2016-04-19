(function(){
    var app = angular.module('tutapos', [ ]);

    app.controller("SearchItemCtrl", [ '$scope', '$http', function($scope, $http) {
        $scope.items = [ ];
        $http.get('api/v1/items').success(function(data) {
            $scope.items = data;
        });
        $scope.saletemp = [ ];
        $scope.newsaletemp = { };

        $scope.invoiceItems = [];
        $http.get('api/saletemp').success(function(data, status, headers, config) {
            $scope.saletemp = data;
        });

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
        $scope.sum = function(list) {
            var total=0;
            angular.forEach(list , function(newsaletemp){
                total+= parseFloat(newsaletemp.item.selling_price * newsaletemp.quantity);
            });
            return total;
        }

    }]);
})();