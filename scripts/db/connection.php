<?php

	require_once 'db-config.php';

	class start_mysqli extends mysqli {
		public function __construct() {
			parent::__construct(DBHOST, DBUSER, DBPASSWORD, DBNAME);

			if (mysqli_connect_error()) {
				die('Error connecting');
			}
		}
	}

	$db = new start_mysqli(DBHOST, DBUSER, DBPASSWORD, DBNAME);
