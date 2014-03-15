<?php

require_once 'db/connection.php';
require_once 'query.php';

require_once 'get-bestof.php';

function update_bestof($db) {

	$n = $_POST['bestOfRange'];

	update_the_db($db, 'layout', "num_best = '$n'", "name = 'default'");

	return get_bestof($db, $n);
}

echo update_bestof($db);