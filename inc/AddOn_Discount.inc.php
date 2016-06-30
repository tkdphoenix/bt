<?php
/**
 * @author Joel Grissom <jogrissom@paypal.com>
 * 
 */
class AddOn_Discount {
	/**
	 *
	 * @var        array $newAddOnsArray		An array of AddOns for the object
	 * @var        array $$newDiscountsArray 	An array of Discounts for the object
	 * 
	 */
	public $newAddOnsArray = array();
	public $newDiscountsArray = array();

	/**
	 * [__construct description]
	 */
	function __construct(){
		$this->createArrays($_POST);
	}

	/**
	 * createArrays function is designed to take a $_POST array and parse it, looking for "newAddOnAmount" or "newDiscountAmount" and creating a new array of Add-ons or Discounts since the values sent from the client may be sequential or not since form elements can be added or removed as needed.
	 * 
	 * @global     array $_POST 
	 * @var        array $tempArray 		A temporary array to store values which are later pushed to either the $newAddOnsArray or $newDiscountsArray
	 * @var        string $suffix 			The last few characters of a $_POST key name - should be digits; used to identify the set of values belonging to one add-on or discount.
	 * 
	 */
	private function createArrays(){
		foreach($_POST as $key => $value){
			// find if $key starts with 'newAddOn' and ends with a certain number
			if(preg_match("/^newAddOnAmount/", $key)){
				preg_match("/\d/", $key, $matches);
				$suffix = substr($key, strpos($key, $matches[0]));
				$tempArray = array();
				// @TODO - correct the echo value now that this is object oriented
				if(empty($_POST["newAddOnInheritedFromId{$suffix}"])){
					echo "The value for the discount ID is required."; 
				} else {
					$tempArray["newAddOnInheritedFromId"] = strip_tags($_POST["newAddOnInheritedFromId{$suffix}"]);
				}
				if(!empty($_POST["newAddOnAmount{$suffix}"])){
					$tempArray["newAddOnAmount"] = strip_tags($_POST["newAddOnAmount{$suffix}"]);
				}
				if(!empty($_POST["newAddOnNeverExpires{$suffix}"])){
					$tempArray["newAddOnNeverExpires"] = strip_tags($_POST["newAddOnNeverExpires{$suffix}"]);
				}
				if(!empty($_POST["newAddOnNumberOfBillingCycles{$suffix}"])){
					$tempArray["newAddOnNumberOfBillingCycles"] = strip_tags($_POST["newAddOnNumberOfBillingCycles{$suffix}"]);
				}
				if(!empty($_POST["newAddOnQuantity{$suffix}"])){
					$tempArray["newAddOnQuantity"] = strip_tags($_POST["newAddOnQuantity{$suffix}"]);
				}
				array_push($this->newAddOnsArray, $tempArray);
			} elseif(preg_match("/^newDiscountAmount/", $key)){
				preg_match("/\d/", $key, $matches);
				$suffix = substr($key, strpos($key, $matches[0]));
				$tempArray = array();
				if(empty($_POST["newDiscountInheritedFromId{$suffix}"])){
					echo "The value for the discount ID is required."; 
				} else {
					$tempArray["newDiscountInheritedFromId"] = strip_tags($_POST["newDiscountInheritedFromId{$suffix}"]);
				}
				if(!empty($_POST["newDiscountAmount{$suffix}"])){
					$tempArray["newDiscountAmount"] = strip_tags($_POST["newDiscountAmount{$suffix}"]);
				}
				if(!empty($_POST["newDiscountNeverExpires{$suffix}"])){
					$tempArray["newDiscountNeverExpires"] = strip_tags($_POST["newDiscountNeverExpires{$suffix}"]);
				}
				if(!empty($_POST["newDiscountNumberOfBillingCycles{$suffix}"])){
					$tempArray["newDiscountNumberOfBillingCycles"] = strip_tags($_POST["newDiscountNumberOfBillingCycles{$suffix}"]);
				}
				if(!empty($_POST["newDiscountQuantity{$suffix}"])){
					$tempArray["newDiscountQuantity"] = strip_tags($_POST["newDiscountQuantity{$suffix}"]);
				}
				array_push($this->newDiscountsArray, $tempArray);
			} // END elseif(preg_match("/^newDiscountAmount/", $key))
		} // END foreach()
	} // END createArrays()
	
	/**
	 * This function consolidates AddOn checks and Discount checks into a simpler function
	 * 
	 *  @param   string $regexString 	A string to represent the regex string needed for preg_match()
	 *  @param   string $key 			The key from a key=>value pair to be evaluated for preg_match()
	 *  @param   array $arrayName 		The name of the array where the $tempArray will be pushed
	 *  
	 * @global   array $_POST 
	 * @var      array $tempArray 		A temporary array to store values which are later pushed to either the $newAddOnsArray or $newDiscountsArray
	 * @var      string $suffix 		The last few characters of a $_POST key name - should be digits; used to identify the set of values belonging to one add-on or discount.
	 * 
	 */
	private function divideValues($regexString, $key, $arrayName){
		// find if $key starts with 'newAddOn' or 'newDiscount' and ends with a certain number
		if(preg_match($regexString, $key)){
			preg_match("/\d/", $key, $matches);
			$suffix = substr($key, strpos($key, $matches[0]));
			$tempArray = array();
			// @TODO - correct the echo value now that this is object oriented
			if(empty($_POST["newAddOnInheritedFromId{$suffix}"])){
				echo "The value for the discount ID is required."; 
			} else {
				$tempArray["newAddOnInheritedFromId"] = strip_tags($_POST["newAddOnInheritedFromId{$suffix}"]);
			}
			if(!empty($_POST["newAddOnAmount{$suffix}"])){
				$tempArray["newAddOnAmount"] = strip_tags($_POST["newAddOnAmount{$suffix}"]);
			}
			if(!empty($_POST["newAddOnNeverExpires{$suffix}"])){
				$tempArray["newAddOnNeverExpires"] = strip_tags($_POST["newAddOnNeverExpires{$suffix}"]);
			}
			if(!empty($_POST["newAddOnNumberOfBillingCycles{$suffix}"])){
				$tempArray["newAddOnNumberOfBillingCycles"] = strip_tags($_POST["newAddOnNumberOfBillingCycles{$suffix}"]);
			}
			if(!empty($_POST["newAddOnQuantity{$suffix}"])){
				$tempArray["newAddOnQuantity"] = strip_tags($_POST["newAddOnQuantity{$suffix}"]);
			}
			array_push($arrayName, $tempArray);
		}

		return;
	}

} // END AddOn_Discount class
	  