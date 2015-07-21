<?php

function assertEquals($arg1, $arg2) {
	if ($arg1 == $arg2) {
		return "<font color=\"green\">" . $arg1 . " is equals " . $arg2 . "</font>";
	} else {
		return  "<font color=\"red\">" . $arg1 . " not equals " . $arg2 . "</font>";
	}
}

?>