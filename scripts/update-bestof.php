<?php

require_once 'db/connection.php';
require_once 'query.php';

require_once 'get-bestof.php';

function update_bestof($db) {
	$n = $_REQUEST['bestOfRange'];
	return get_bestof($db, $n);
}

echo update_bestof($db);