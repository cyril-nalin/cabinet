<?php

define('PWD_INIT', 'key_pass');
define('PWD_KEY', 'azertyuiopqsdfgh');
define('PWD_CASE_INSENSITIVE', FALSE);

function keygen($s, $raw_result = FALSE):string {
	return hash_hmac('SHA256', PWD_INIT . ((TRUE === PWD_CASE_INSENSITIVE) ? strtolower($s) : $s), PWD_KEY, $raw_result);
}
?>
