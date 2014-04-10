<?php

// require_once 'db/connection.php';
require_once 'db/sp-config.php';

class TalkToDB {

	private $db;

	private $values = array();

	public function __construct() {

		$this->db = new mysqli(DBHOST, DBUSER, DBPASSWORD, 'starttester');

		if ($this->db->connect_errno) {
			die('Connection error: ' . $this->db->connect_error);
		}

	}

	public function insert($table, $columns, $values, $types) {

	}

}