(function(){
	var app = angular.module('apis', [ ]);

	app.controller('APIController', function(){
		this.product = products;
	});

	products = {
		[
			title:	"Express Checkout",
			[
				method: 	"SetExpressCheckout",
				reqParams: [

				]
			],
			[			
				method: "GetExpressCheckoutDetails",
				reqParams: [

				]
			],
			[
				method: "DoExpressCheckoutPayment",
				reqParams: [

				]
			],
			[
				method: "Callback",
				reqParams: [

				]
			]
		], // end Express Checkout
		[
			title: "Authorization and Capture",
			[
				method: "DoAuthorization",
				reqParams: [

				]
			],
			[
				method: "DoCapture",
				reqParams: [

				]
			],
			[
				method: "DoReauthorization",
				reqParams: [

				]
			],
			[
				method: "DoVoid",
				reqParams: [

				]
			],
			[
				method: "UpdateAuthorization",
				reqParams: [

				]
			]
		], // end Authorization and Capture
		[
			title: "Recurring Payments / Reference Transactions",
			[
				method: "BAUpdate",
				reqParams: [

				]
			],
			[
				method: "BillOutstandingAmount",
				reqParams: [

				]
			],
			[
				method: "CreateBillingAgreement",
				reqParams: [

				]
			],
			[
				method: "CreateRecurringPaymentsProfile",
				reqParams: [

				]
			],
			[
				method: "DoReferenceTransaction",
				reqParams: [

				]
			],
			[
				method: "GetBillingAgreementCustomerDetails",
				reqParams: [

				]
			],
			[
				method: "GetRecurringPaymentsProfileDetails",
				reqParams: [

				]
			],
			[
				method: "ManageRecurringPaymentsProfileStatus",
				reqParams: [

				]
			],
			[
				method: "SetCustomerBillingAgreement",
				reqParams: [

				]
			],
			[
				method: "UpdateRecurringPaymentsProfile",
				reqParams: [

				]
			]
		], // end Recurring Payments
		[
			title: "Refunds",
			[
				method: "RefundTransaction",
				reqParams: [

				]
			],
		], // end Refunds
		[
			title: "Inventory Management",
			[	
				method: "GetTransactionDetails",
				reqParams: [

				]
			],
			[
				method: "TransactionSearch",
				reqParams: [

				]
			],
		], // end Inventory Management
		[
			title: "PayPal Accounts",
			[
				method: "AddressVerify",
				reqParams: [

				]
			],
			[
				method: "GetBalance",
				reqParams: [

				]
			],
			[
				method: "GetPalDetails",
				reqParams: [

				]
			]
		] // end PayPal Accounts
	}; // end products

})();