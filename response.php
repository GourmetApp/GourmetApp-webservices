<?php

function displayResponse($userGourmet, $passGourmet) {
	$html = getHTMLCurlRequest($userGourmet, $passGourmet);
	if ($html) {
		if (getType(getCurrentBalance($html)) === "string") {
			if (getCurrentBalance($html) !== 0) {
				if (getLastOperation($html)) {
					$json = array(
  						"currentBalance" => getCurrentBalance($html),
  						"operations" => getLastOperation($html),
  						"errorCode" => "0",
  						"errorMessage" => ""
					);
				} else {
					$json = array(
		  				"currentBalance" => getCurrentBalance($html),
		  				"errorCode" => "0",
		  				"errorMessage" => ""
		  			);		
				}
			} else {
				$json = displayError(2);
			}
		} else {
			$json = displayError(2);
		}
	} else {
		$json = displayError(1);
	}
	return $json;
}

function displayError($errorNumber) {
	switch ($errorNumber) {
    case 1:
        $errorCode = 1;
        $errorMessage = "User or password not found";
        break;
    case 2:
    	$errorCode = 2;
        $errorMessage = "User or password incorrect";
        break; 
    case 3:
        $errorCode = 3;
        $errorMessage = "The server not response";
        break;
    default:
        $errorCode = $errorNumber;
        $errorMessage = "Unknown code " . $errorNumber;  
        break;
	}

	$json = array(
		"errorCode" => $errorCode,
		"errorMessage" => $errorMessage
	);
	return $json;
}

?>