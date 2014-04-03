<?php

$sql = file_get_contents('scripts/startpage.sql');

$single = explode(';', $sql);

foreach ($single as $key => $value) {
	var_dump($key);
	echo '<br><br>';
	var_dump($value);
}

// echo $sql;

// var_dump($single);