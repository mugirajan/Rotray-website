<?php
	function validate( $data, $rule){
		
		switch ($rule) {
			case 'notnull':
				if(is_array($data)){
					$error = [];
					foreach($data as $key => $value){
						$result = isNotNull($value,$key);
						if($result["error"] == 1){
							$error[] =$result["message"]; 
						}
					}
					return array("error"=>1,"data"=>$error);
				}else{
					$error ="";
					$result = isNotNull($data);
					if($result["error"] == 1){
						$error =$result["message"]; 
					}
					return 	array("error"=>1,"data"=>$error);	
				}
				
				break;
			case 'string':
				if(is_array($data)){
					$error = [];
					foreach($data as $key => $value){
						$result = isString($value,$key);
						if($result["error"] == 1){
							$error[] =$result["message"]; 
						}
					}
					if(count($error) >0)
						return array("error"=>1,"data"=>$error);
					else
						return array("error"=>0,"data"=>[]);
				}else{
					$error ="";
					$result = isString($value,$key);
					if($result["error"] == 1){
						$error =$result["message"]; 
					}
					return array("error"=>1,"data"=>$error);	
				}
				break;
			case 'int':
				if(is_array($data)){
					$error = [];
					foreach($data as $key => $value){
						$result = isInt($value,$key);
						if($result["error"] == 1){
							$error[] =$result["message"]; 
						}
					}
					if(count($error) >0)
						return array("error"=>1,"data"=>$error);
					else
						return array("error"=>0,"data"=>[]);
				}else{
					$error ="";
					$result = isInt($data);
					if($result["error"] == 1){
						$error =$result["message"];
						return 	array("error"=>1,"data"=>$error);
					}
					return array("error"=>0,"data"=>[]);					
				}
				break;
			case 'bool':
				return isBool($data);
				break;
			case 'file':
				if(is_array($data)){
					$error = [];
					if(!isset($data['name'])){
						foreach($data as $key => $value){
							$result = isFile($value,$key);
							if($result["error"] == 1){
								$error[] =$result["message"]; 
							}
						}
						if(count($error) >0)
							return array("error"=>1,"data"=>$error);
						else
							return array("error"=>0,"data"=>[]);
					}else{
						$error ="";
						$result = isFile($data);

						if($result["error"] == 1){
							$error =$result["message"];
							return 	array("error"=>1,"data"=>$error);
						}else{
							return array("error"=>0,"data"=>[]);	
						}
					}
					
				}
				break;
			
			default:
				return array("status"=>"Faild","message"=>"{$rule}-Invalid Rule or Rule is not defined.");
				break;
		}
	}

	function isNotNull($data, $col = null){
		if(!is_null($data) && ($data != "")){
			return array("error"=>0,"message"=>"valid data.");
		}else{
			if($col != null){
				return array("error"=>1,"message" => "{$col}-Field is required.");
			}else{
				return array("error"=>1,"message"=>"Field is required	.");
			}
		}
	}

	function isInt($data, $col = null){
		if(is_int($data)){
			return array("error"=>0,"message"=>"is valid data.");
		}else{
			if($col != null){
				return array("error"=>1,"message" => "{$col}-invalid data");
			}else{
				return array("error"=>1,"message"=>"invalid data.");
			}
		}
	}

	function isString($data, $col = null)
	{
		if(is_string($data)){
			return array("error"=>0,"message"=>"valid data.");
		}else{
			if($col != null){
				return array("error"=>1,"message" => "{$col}-invalid data");
			}else{
				return array("error"=>1,"message"=>"invalid data.");
			}
		}
	}

	function isBool($data, $col = null)
	{
		// code...
	}

	function isFile($data, $col = null)
	{
		if($data['name'] != ""){
			return array("error"=>0,"message"=>"valid data.");
		}else{
			if($col != null){
				return array("error"=>1,"message" => "{$col}-Field is required.");
			}else{
				return array("error"=>1,"message"=>"Field is required.");
			}
		}
	}