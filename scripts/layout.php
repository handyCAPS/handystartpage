<?php

function get_layout($db, $name = 'default') {
	$layout = ask_the_db($db, 'layout', '*', "name = '$name'");
	if (!is_array($layout)) {
		var_dump($layout);
		return;
	}
	return $layout;
}

function get_num_bestof($db) {
	$layout = get_layout($db);
	return $num_bestof = $layout[0]['num_best'];
}