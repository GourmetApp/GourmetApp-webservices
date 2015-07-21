<?php

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

?>