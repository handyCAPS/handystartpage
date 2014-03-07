<?php

	function get_root_path() {
		$start = $first_slash = strpos(__FILE__, '\\', strlen($_SERVER['DOCUMENT_ROOT']));

		$length = (strpos(__FILE__, '\\', $first_slash + 1) - $first_slash) + 1;

		return $root_map = $_SERVER['DOCUMENT_ROOT'] . substr(__FILE__, $start, $length);
	}

	define('DBNAME', 'startpage');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASSWORD', '');

	define('ROOT_PATH', get_root_path());