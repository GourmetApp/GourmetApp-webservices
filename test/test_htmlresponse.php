<?php

include 'testutils.php';
include '../response.php';

$html_okwithoutops = file_get_contents('resources/response_okwithoutops.html');
$html_ok = file_get_contents('resources/response_ok.html');
$html_fail = file_get_contents('resources/response_fail.html');

$test_okwithoutops = file_get_contents('resources/test_okwithoutops.json');
$test_ok = file_get_contents('resources/test_ok.json');
$test_fail = file_get_contents('resources/test_fail.json');

echo "displayResponse</br>";
echo assertEquals(json_encode(displayResponse($html_okwithoutops)), $test_okwithoutops) . "</br>";
echo assertEquals(json_encode(displayResponse($html_ok)), $test_ok) . "</br>";
echo assertEquals(json_encode(displayResponse($html_fail)), $test_fail) . "</br>";

?>