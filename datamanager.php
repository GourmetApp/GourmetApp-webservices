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

?>