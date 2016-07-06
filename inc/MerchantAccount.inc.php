<?php
class MerchantAccount {
	/** @var array $individual initialized array to hold values for individual info
	 *	@var array $business initialized array to hold values for business info
	 *	@var array $funding initialized array to hold values for funding
	 *	@var boolean $tos if the terms of service have been checked
	 *	@var integer $id the ID for the SubMerchant
	 */
	protected $individual = array();
	protected $business = array();
	protected $funding = array();
	protected $tos;
	protected $masterMerchantAccountId;
	protected $id;

	/**
	 * Creates a new Merchant Account Object
	 *
	 * @param      string  $key   The name of the attribute that is being updated
	 * @param      string $val 	  The value that is being inserted for the specific $key
	 * @param      string  $group  The group array that the attribute belongs to. Default to NULL in case param is not provided / not needed
	 *
	 * @return     string  returns either the attribute that was updated or an error message
	 */
	public function updateParam($key, $val, $group=NULL){
		switch($group){
			case "individual":
				$this->individual[$key] = $val;
				return $this->individual[$key];
			break;

			case "business":
				$this->business[$key] = $val;
				return $this->business[$key];
			break;

			case "funding":
				$this->funding[$key] = $val;
				return $this->funding[$key];
			break;
			default:
				if($key === "tos"){
					$this->tos = $val;
					return $this->tos;
				} elseif($key === "masterMerchantAccountId"){
					$this->masterMerchantAccountId = $val;
					return $this->masterMerchantAccountId;
				} elseif($key === "id"){
					$this->id = $val;
					return $this->id;
				} else {
					return $error = "There is no such parameter. Nothing updated.";
				}
		} // END switch statement
	} // END updateParam()
} // end class MerchantAccount