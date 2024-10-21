<?php
	include('models.php');
	include('validation.php');
	session_start();
	function message($message) {
	    // Set the file path for the log file
	    $logFile = 'log/error.log';

	    // Get the current date/time
	    $timestamp = date('Y-m-d H:i:s');

	    // Construct the log entry
	    $logEntry = "[$timestamp] $message\n";

	    // Open the log file in append mode or create it if it doesn't exist
	    if ($file = fopen($logFile, 'a')) {
	        // Write the log entry to the file
	        fwrite($file, $logEntry);
	        fclose($file); // Close the file handle
	    } else {
	        // Handle errors if unable to open the file
	        echo "Unable to open or create the log file.";
	        // You might want to log this failure elsewhere or handle it according to your needs
	    }
	}

	function getRotarianList($club_value = ""){
		try {
			$data = fetchRotariansList($club_value);
			
			$dropDownOptions = [];
			foreach ($data as $value) {
				$dropDownOptions[] = [
					"key" => $value["member_id"],
					"value" => $value["full_name"],
					"mobile"=> $value["phone_number"]
				];
			}
			return $dropDownOptions;
		} catch (Exception $e) {
			message($e);
		}
		
	}

	function getRotaryClubs($value='')
	{
		try {
			$data = fetchRotaryClubList();
			$dropDownOptions = [];
			foreach ($data as $value) {
				$dropDownOptions[] = [
					"key" => $value["club_name"],
					"value" => $value["club_name"]
				];
			}
			return $dropDownOptions;
		} catch (Exception $e) {
			message($e);
		}
	}

	function getRotarianDetailsByID($id)
	{
		try {
			$data = fetchRotariansDetails($id);
			$data = [
				"mobile_no" => $data['phone_number'],
				"email_address" => $data['email_address'],
				"rotary_member_id" => $data["rotary_member_id"]
			];
			return $data;
		} catch (Exception $e) {
			message($e);
		}
	}

	function formatAndInsertData($formData,$receipt)
	{
		try {
			$rotariansDetails = [];
			$guestDetails = [];
			$annDetails = [];
			$annetteDetails = [];

			$rotarianValidationRule = [
				"rotarianSearch" => "string",
				"rotarian_mobile" => "string"
			];
			$questValidationRule = [
				"guest_name" => "string",
				"guest_call_name" =>"string"
			];
			$annValidationRule = [
				"ann_name" => "string",
				"ann_call_name" =>"string"
			];
			$annetteValidationRule = [
				"annette_name" => "string",
				"annette_call_name" =>"string"
			];
			$transactionData =[
				"rotaryClubListSearch" => $formData['rotaryClubListSearch'],
				"transactionRef" => $formData['transactionRef'],
				"transactionDate" => date("Y-m-d"),
				"totalAmount" => $formData['totalAmount'],
				"registerer_club" => $formData['registerer_club'],
				"registerer_name" => $formData['registerer_name'],
				"registerer_email" => $formData['registerer_email'],
				"registerer_mobile" => $formData['registerer_mobile'],
				"receipt" => $receipt
			];
			$transactionValidateRule = [
				"transactionRef" => "notnull",
				"receipt" => "file",
				"totalAmount" => "notnull",
				"registerer_name" => "notnull",
				"registerer_email" => "notnull",
				"registerer_mobile" => "notnull"
			];
			$transactionValidateResult = validateFormData($transactionData,$transactionValidateRule);
			$rotariansValidateResult = validateFormData($formData,$rotarianValidationRule);
			$guestValidateResult = validateFormData($formData,$guestValidationRule);
			$annValidateResult = validateFormData($formData,$annValidationRule);
			$annetteValidateResult = validateFormData($formData,$annetteValidationRule);

			if(($rotariansValidateResult["error"]==1) || ($guestValidateResult["error"] == 1) || ($annValidateResult["error"] == 1) || ($annetteValidateResult["error"] == 1)||$transactionValidateResult['error'] == 1){
				$validateErrors = [
					"rotarian" => $rotariansValidateResult["data"],
					"guest" => $guestValidateResult["data"],
					"ann" => $annValidateResult["data"],
					"annette" => $annetteValidateResult["data"],
					"transaction" => $transactionValidateResult["data"]
				];
				return array("error" => 1,"message"=> "Invalid data.", "data" => $validateErrors);
			}else{
				$target_dir = "uploads/";
				$targetFile = $target_dir . basename($receipt["name"]);
				move_uploaded_file($receipt["tmp_name"], $targetFile);
				$transactionData["transactionRecipt"] =$targetFile;
				$transactionRecord = insertTransactionDetails($transactionData);
			}
			
			for ($i=0; $i < count($formData['rotarianSearch']); $i++) { 
				$rotariansDetails[] = [
					"rotarianSearch" =>$formData['rotarianSearch'][$i],
					"rotarian_call_name"=> $formData['rotarian_call_name'][$i],
					"foodPrefrence"=> $formData['rotarian_checkVeg'][$i],
					"rotarian_mobile"=>$formData['rotarian_mobile'][$i],
					"member_type" => 1,
					"fktransaction_id"=>$transactionRecord['id']
				];
			}

			for ($i=0; $i < count($formData['guest_name']); $i++) { 
				$annDetails[] = [
					"ann_name" =>$formData['guest_name'][$i],
					"ann_call_name"=> $formData['guest_call_name'][$i],
					"foodPrefrence"=> $formData['guest_checkVeg'][$i],
					"ann_mobile"=> $formData['guest_mobile'][$i],
					"member_type" => 4,
					"fktransaction_id"=>$transactionRecord['id']
				];
			}

			for ($i=0; $i < count($formData['ann_name']); $i++) { 
				$annDetails[] = [
					"ann_name" =>$formData['ann_name'][$i],
					"ann_call_name"=> $formData['ann_call_name'][$i],
					"foodPrefrence"=> $formData['ann_checkVeg'][$i],
					"ann_mobile"=> $formData['ann_mobile'][$i],
					"member_type" => 2,
					"fktransaction_id"=>$transactionRecord['id']
				];
			}

			for ($i=0; $i < count($formData['annette_name']); $i++) { 
				$annetteDetails[] = [
					"annette_name" =>$formData['annette_name'][$i],
					"annette_call_name"=> $formData['annette_call_name'][$i],
					"foodPrefrence"=> $formData['annette_checkVeg'][$i],
					"annette_mobile"=> $formData['annette_mobile'][$i],
					"member_type" => 3,
					"fktransaction_id"=>$transactionRecord['id']
				];
			}			

			insertRotariansDetails($rotariansDetails);
			insertAnnDetails($annDetails);
			insertAnnetteDetails($annetteDetails);
			
			return array("error" => 0,"message"=> "Rotarians are register successfully!.", "data" => []);
		} catch (Exception $e) {
			message($e);
		}
		
	}

	function validateFormData($formData,$validationRule){
		try {
			$error = [];
			foreach($validationRule as $col => $rule){

				$data = $formData[$col];
				$rules = explode("|",$rule);
				foreach($rules as $entity){
					$result = validate($data,$entity);
					
					if($result["error"] == 1){
						if(!empty($result["data"]))
							$error[$col] = $result["data"]; 
					}
				}
			}
			if(count($error) > 0){
				return array("error" => 1,"message"=>"Invaid fields", "data" =>$error);
			}
			else{
				return array("error" => 0,"message"=>"Form verified", "data" =>[]);;
			}
		} catch (Exception $e) {
			message($e);
		}	
	}

	function fetchEventRegisterDetails()
	{
		return getEventRegisterDetails();
	}

	function fetchTransactionDetails()
	{
		return getTransactionDetails();
	}