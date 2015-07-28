<?php
include('htmlhelper.php');

function displayResponse($html) {
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
        $errorMessage = "El usuario o la contraseña no existe";
        break;
    case 2:
    	$errorCode = 2;
        $errorMessage = "Usuario o contraseña incorrectos";
        break; 
    case 3:
        $errorCode = 3;
        $errorMessage = "El servidor no responde";
        break;
    default:
        $errorCode = $errorNumber;
        $errorMessage = "Error con código " . $errorNumber;
        break;
	}

	$json = array(
		"errorCode" => $errorCode,
		"errorMessage" => $errorMessage
	);
	return $json;
}

?>