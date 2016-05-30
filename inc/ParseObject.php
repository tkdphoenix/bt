<?php
class ParseObject {
	private $finalString;

	function __construct(){
		 $this->finalString = NULL;	
	}
	
	public function parseObjToString($obj, $prefix = NULL) {
		$this->finalString;
		foreach($obj as $key => $value){
			$type = gettype($value);
			if($type == "object" || $type == "array") {
				$this->parseObjToString($value, $key);
			} else {
				switch($type){
					case "string":
					case "double":
					case "integer":
						(isset($prefix)) ? $this->finalString .= $prefix ."-". $value . "<br>" : $this->finalString .= $value . "<br>";
						break;

					case "boolean":
						if(isset($prefix)){
							($obj) ? $this->finalString .= "$prefix - true<br>" : "$prefix - false<br>";
						} else {
							($obj) ? $this->finalString .= "true<br>" : "false<br>";
						}
						break;

					default:
						(isset($prefix)) ? $this->finalString .= "$prefix - NULL<br>" : $this->finalString .= "NULL<br>";
						break;
				} // END switch / case
			}
		} // END foreach
		return $this->finalString;
	}
} // END ParseObject class