<?php

include 'datamanager.php';
include 'htmlhelper.php';
include 'response.php';

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
