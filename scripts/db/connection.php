<?php

require_once 'sp-config.php';


class start_mysqli extends mysqli {
	public function __construct($dbhost, $dbuser, $dbpassword, $dbname) {
		parent::__construct($dbhost, $dbuser, $dbpassword, $dbname);

		if ($this->connect_errno) {
			die('Error connecting ' . $this->connect_error);
		}
	}
}

$db = new start_mysqli(DBHOST, DBUSER, DBPASSWORD, DBNAME);
