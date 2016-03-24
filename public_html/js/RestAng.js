(function(){
	var RestApp = angular.module('apis', [ ]);
	// Angular controller to use scope and http to get the products/rest.json file with all API methods in them and output
	// the data to the navigation on the page.
	RestApp.controller('APIController', ['$scope', '$http', function($scope, $http){
		$http.get('../products/rest.json').success(function(data){
			$scope.products = data;
		});


		// getParams gets the parameters from the database and puts them in the #reqParams textarea
		$scope.getParams = function($event){
			// empty out the text area
			$("#reqParams").val('');
			$("#sOperation").html('');
			console.info($event.currentTarget.id);
			$id = $event.currentTarget.id;
			$.ajax({
				url: "../rest/getRESTParams.php",
				data: {action: $id}, // this is the id of the button which should match the method name in the DB to call
				// datatype: "text",
				type: "post",
				success: function(data){
					var result = JSON.parse(data);
					console.log(result); // @TODO remove
					blah = result; // @TODO remove
					$("#reqParams").val(result.dataParams);
					$("#sOperation").html(result.operation);
					$("#sMethod").html(result.method);
					$("#sUrl").html("https://api.sandbox.paypal.com" + result.urlAppend);
				}
			});
			
		} // end getParams()

	}]); // end RestApp.controller('APIController'
})(); // end (function(){})()
