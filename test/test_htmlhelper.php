<?php

include 'testutils.php';
include '../htmlhelper.php';

$html_okwithoutops = file_get_contents('resources/response_okwithoutops.html');
$html_ok = file_get_contents('resources/response_ok.html');
$html_fail = file_get_contents('resources/response_fail.html');

echo "</br>getCurrentBalance</br>";
echo assertEquals(getCurrentBalance($html_okwithoutops), "0") . "</br>";
echo assertEquals(getCurrentBalance($html_ok), "34,56") . "</br>";
echo assertEquals(getCurrentBalance($html_fail), "") . "</br>";

echo "</br>getLastOperation</br>";
echo assertEquals(getLastOperation($html_okwithoutops), "") . "</br>";

echo "</br>Remove Last Operation</br>";
echo assertEquals(removeLastWord("hola"), "hola") . "</br>";
echo assertEquals(removeLastWord(" hola "), "hola") . "</br>";
echo assertEquals(removeLastWord("  hola "), "hola") . "</br>";
echo assertEquals(removeLastWord("   hola M"), "hola") . "</br>";

?>