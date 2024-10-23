<?php
	include 'controller.php';
	$f = "file2.txt";

	$method = $_POST['target']; 
	$getData = $_POST['data'];

	switch ($method) {
		case 'getRotarians':
			echo json_encode(getRotariansByClubID($getData['value']));
			break;
		case 'getRotarianDetail':
			echo json_encode(getRotariansDetails($getData['value']));
			break;
		case 'formSubmit':
			echo json_encode(saveFormData($_REQUEST));
			break;
		case 'calculateMemberRegistrationFee':
			file_put_contents($f, "SEssion unset", FILE_APPEND | LOCK_EX);
			echo json_encode(calculateMemberFees($getData['value']), FILE_APPEND | LOCK_EX);
			break;
		default:
			return print("Undefined function...");
			break;
	}

	function getRotariansByClubID($value){
		$data = getRotarianList($value);
		return array("status"=>"success","data"=>$data);
	}

	function getRotariansDetails($value){
		$data = getRotarianDetailsByID($value);
		return array("status"=>"success","data"=>$data);
	}

	function saveFormData($data, $getFormCal = false){
		$formData = [];
		foreach($data as $key => $value){
			// if($key != 'rotaryClubListSearch'){
				$index = $key;
				if($key == 'receipt'){
					$formData['receipt'] = $value;
				}
				if(isset($formData[$index])){
					if(strpos($index, "rotarian_checkVeg") !== false){
						$formData["rotarian_checkVeg"][] = $value;
					}elseif(strpos($index, "ann_checkVeg") !== false){
						$formData["ann_checkVeg"][] = $value;
					}elseif(strpos($index, "annette_checkVeg") !== false){
						$formData["annette_checkVeg"][] = $value;
					}elseif(strpos($index, "guest_checkVeg") !== false){ // New case for guests
						$formData["guest_checkVeg"][] = $value;
					}else{
						$formData[$index] = $value;
					}
				}else{
					if(strpos($index, "rotarian_checkVeg") !== false){
						$formData["rotarian_checkVeg"][] = $value;
					}elseif(strpos($index, "ann_checkVeg") !== false){
						$formData["ann_checkVeg"][] = $value;
					}elseif(strpos($index, "annette_checkVeg") !== false){
						$formData["annette_checkVeg"][] = $value;
					}elseif(strpos($index, "guest_checkVeg") !== false){ // New case for guests
						$formData["guest_checkVeg"][] = $value;
					}else{
						$formData[$index] = $value;
					}
				}
			// }
		}
		if($getFormCal){
			return $formData;
		}
		$result = formatAndInsertData($formData, $_FILES['receipt']);
		if($result["error"] == 1){
		    return $result;
		}else{
			return $result;
		}
		// return array("status"=>"success","message"=>"Data updated successfully","data"=>$result);
	}

	function calculateMemberFees($data)
	{
		$ff = "file.txt";

		$formData = formDataArrange($data);

		$rotarian_sum = 0;
		$ann_sum = 0;
		$annette_sum = 0;
		$guest_sum = 0;


		if (isset($formData['rotarianSearch'])) {
			foreach($formData['rotarianSearch'] as $rotarian){
				if($rotarian != ""){
					$rotarian_sum += 1500;
				}
			}
		}

		if (isset($formData['ann_name[]'])) {
			foreach($formData['ann_name[]'] as $ann){
				if($ann != ""){
					$ann_sum += 1500;
				}
			}
		}

		if (isset($formData['annette_name[]'])) {
			foreach($formData['annette_name[]'] as $annette){
				if($annette != ""){
					$annette_sum += 1500;
				}
			}
		}

		if (isset($formData['guest_name[]'])) {
			foreach($formData['guest_name[]'] as $guest){ 
				if($guest != ""){
					$guest_sum += 1500; 
				}
			}
		}


		$total = $rotarian_sum + $ann_sum + $annette_sum + $guest_sum;

		return array(
			"rotarian" => $rotarian_sum,
			"ann" => $ann_sum,
			"annette" => $annette_sum,
			"guest" => $guest_sum,
			"total" => $total
		);
	}




	function formDataArrange($data){
		$f = "file2.txt";

		$formData = [];
		foreach($data as $form){
			if($form['name'] != 'rotaryClubListSearch'){
				$index = $form['name'];
				if(isset($formData[$index])){
					if(strpos($index, "rotarian_checkVeg") !== false){
						$formData["rotarian_checkVeg"][] = $form['value'];
					}elseif(strpos($index, "ann_checkVeg") !== false){
						$formData["ann_checkVeg"][] = $form['value'];
					}elseif(strpos($index, "annette_checkVeg") !== false){
						$formData["annette_checkVeg"][] = $form['value'];
					}elseif(strpos($index, "guest_checkVeg") !== false){ // Handle guests
						$formData["guest_checkVeg"][] = $form['value'];
					}elseif(strpos($index, "rotarianSearch") !== false){
						$formData["rotarianSearch"][] = $form['value'];
					}else{
						$formData[$index][] = $form['value'];
					}
				}else{
					if(strpos($index, "rotarian_checkVeg") !== false){
						$formData["rotarian_checkVeg"][] = $form['value'];
					}elseif(strpos($index, "ann_checkVeg") !== false){
						$formData["ann_checkVeg"][] = $form['value'];
					}elseif(strpos($index, "annette_checkVeg") !== false){
						$formData["annette_checkVeg"][] = $form['value'];
					}elseif(strpos($index, "guest_checkVeg") !== false){ // Handle guests
						$formData["guest_checkVeg"][] = $form['value'];
					}elseif(strpos($index, "rotarianSearch") !== false){
						$formData["rotarianSearch"][] = $form['value'];
					}else{
						$formData[$index][] = $form['value'];
					}
				}

			}
		}
		file_put_contents($f, print_r( $formData ,true), FILE_APPEND | LOCK_EX);	
		return $formData;
	}
	
?>