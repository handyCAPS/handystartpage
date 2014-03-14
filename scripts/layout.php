<?php

function get_layout($db, $name = 'default') {
	return $layout = ask_the_db($db, 'layout', '*', "name = $name");
}

function get_num_bestof($db) {
	$layout = get_layout($db);
	return $num_bestof = $layout['num_best'];
}