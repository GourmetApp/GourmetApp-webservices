<?php

function getHTMLCurlRequest($user, $pass) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,            "http://tarjetagourmet.chequegourmet.com/processLogin_iphoneApp.jsp" );
	curl_setopt($ch, CURLOPT_POSTFIELDS,     "usuario=" . $user . "&contrasena=" . $pass . "&token=xAeSYsTQQTCVyPOGWLpR" ); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$html = curl_exec($ch);
	curl_close($ch);
	return $html;
}

function getCurrentBalance($html) {
	$doc = new DOMDocument();
	@$doc->loadHTML($html);
	foreach ($doc->getElementsByTagName('div') as $tag) {
		if ($tag->getAttribute('id') !== "TotalSaldo") {
			continue;
		}
		return trim(cleanString($tag->nodeValue));
	}
}

function getLastOperation($html) {
	$pos = 0;
	$doc = new DOMDocument();
	@$doc->loadHTML($html);

	$operations = "";
	foreach ($doc->getElementsByTagName('td') as $tag) {
		if (trim($tag->nodeValue) === "fin") {
			break;
		}
		if ($tag->getAttribute('id') === "fecha") {
			$operations[$pos]->date = cleanString($tag->nodeValue);
		} else if ($tag->getAttribute('id') === "operacion") {
			$operations[$pos]->name = removeLastWord($tag->nodeValue);
		} else if ($tag->getAttribute('id') === "importe") {
			$operations[$pos]->price = cleanString($tag->nodeValue);
		} else if ($tag->getAttribute('id') === "horaOperacion") {
			$operations[$pos]->hour = cleanString($tag->nodeValue);
			$pos++;
		}
	}
	return $operations;
}

function removeLastWord($value) {
	$value = cleanString($value);
	if (ctype_upper(substr($value, (strlen($value)-1), strlen($value)))) {
		$value = substr($value, 0, (strlen($value)-1));
		$value = cleanString($value);
	}
	return $value;
}

function cleanString($value) {
	return trim(str_replace(array("\n", "\t", "\r", "Saldo: "), '', $value));
}

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

$passGourmet;
$userGourmet;

/* BODY */
switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		$userGourmet = $_GET['user'];
		$passGourmet = $_GET['pass'];
		break;
	case 'POST':
		$userGourmet = $_POST['user'];
		$passGourmet = $_POST['pass'];
	default:
		break;
}

$jsonResponse = (isset($userGourmet) && isset($passGourmet)) ? displayResponse($userGourmet, $passGourmet) : displayError(1);
header('Content-type: application/json');
echo json_encode($jsonResponse);

?>