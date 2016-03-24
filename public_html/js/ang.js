(function(){
	var app = angular.module('apis', [ ]);
	// Angular controller to use scope and http to get the products/products.json file with all API methods in them and output
	// the data to the navigation on the page.
	app.controller('APIController', ['$scope', '$http', function($scope, $http){
		$http.get('products/products.json').success(function(data){
			$scope.products = data;
		});

		// getParams gets the required parameters from an API method and puts them in the reqParams textarea
		$scope.getParams = function(obj){
			console.log('required params');

			// empty out the text areas
			$("#reqParams").val('');
			// obj is an object with key / values for parameters
			if($.isPlainObject(obj)){
				var strParams = "";
				// add credentials to the request parameters
				strParams += "USER=" + $('#user').val() + "\r\n";
				strParams += "PWD=" + $('#pwd').val() + "\r\n";
				strParams += "SIGNATURE=" + $('#signature').val() + "\r\n";
				for(var key in obj){
					if(obj.hasOwnProperty(key)){
						strParams +=  key + "=" + obj[key] + "\r\n";
					}
				}
				// check the end of the string, since the last line also has \r\n characters, and remove the last ones or they
				// eventually become part of the array that is later created from each line of the textarea $_POST value
				if(strParams.substr(-2,2) == "\r\n"){
					strParams = strParams.trim(strParams);
				}
				// add strParams to textarea#reqParams
				$("#reqParams").val(strParams);
			} else {
				// @TODO work on error handling
				throw new Error("This is not an object");
			}
		} // end getParams()
		
	}]); // end app.controller('APIController'
})(); // end (function(){})()
