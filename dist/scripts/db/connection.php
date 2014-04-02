<?php

require_once 'sp-config.php';


class start_mysqli extends mysqli {
	public function __construct($dbhost, $dbuser, $dbpassword, $dbname) {
		parent::__construct($dbhost, $dbuser, $dbpassword, $dbname);

		if (mysqli_connect_error()) {
			die('Error connecting');
		}
	}
}

$db = new start_mysqli(DBHOST, DBUSER, DBPASSWORD, DBNAME);
