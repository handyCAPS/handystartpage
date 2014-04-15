<?php

// require_once 'db/connection.php';
require_once 'db/sp-config.php';

class TalkToDB {

	/**
	 * Mysqli instance
	 * @var object
	 */
	private $db;

	/**
	 * Any errors that occur
	 * @var array
	 */
	private $errors = array();

	/**
	 * Values to be inserted
	 * @var array
	 */
	private $value_array = array();

	/**
	 * Columns to be created, read or updated
	 * @var array
	 */
	private $column_array = array();

	/**
	 * Types for prepare functions
	 * @var string
	 */
	private $type_string;

	/**
	 * Any and all where clauses
	 * @var array
	 */
	private $where_array = array();

	/**
	 * The query type to be executed
	 * @var string
	 */
	private $query_type;

	/**
	 * The query seperated into an array
	 * @var array
	 */
	private $query_array = array();

	/**
	 * The built up string that gets executed
	 * @var string
	 */
	private $sql;

	/**
	 * The table(s) to select from
	 * @var array
	 */
	private $from_table_array = array();

	/**
	 * Tables to work with
	 * @var array
	 */
	private $table_array = array();

	/**
	 * How to order results
	 * @var array
	 */
	private $ordering = array();

	/**
	 * The direction for the sorting
	 * @var string
	 */
	private $direction;

	private $stmt;

	public function __construct($user = 'root', $pw = '', $datab = 'starttester', $host = DBHOST) {

		try {
			// Surpressing errors to handle them myself
			@$this->db = new mysqli($host, $user, $pw, $datab);

			if ($this->db->connect_errno) {
				throw new Exception($this->db->connect_error);
			}

		} catch (Exception $e) {
				$this->set_errors($e->getMessage());
			}

	}

	public function query($type = null) {

		$this->query_type = $type;

		// Returning self, so the method is chainable
		return $this;
	}

	public function columns($columns = array()) {

		if (!empty($columns)) {
			$this->column_array = $columns;
		}

		// Returning self, so the method is chainable
		return $this;
	}

	public function types($types = null) {

		$this->type_string = $types;

		// Returning self, so the method is chainable
		return $this;
	}

	public function values($values = array()) {

		$type_array = array();

		foreach ($values as $type => $value) {
			$type_array[] = $type;
			$this->value_array[] = $value;
		}

		$this->type_string = implode('', $type_array);

		// Returning self, so the method is chainable
		return $this;
	}

	public function from($tablename = array()) {

		$this->from_table_array = $tablename;

		// Returning self, so the method is chainable
		return $this;
	}

	public function tables($tables = array()) {
		if (empty($tables)) {
			$this->set_errors('No tables selected');
		}

		$this->table_array = $tables;

		// Returning self, so the method is chainable
		return $this;
	}

	public function where($where = array()) {
		if (empty($where)) {
			$this->set_errors('No where clause provided');
		}
		$this->where_array = $where;

		// Returning self, so the method is chainable
		return $this;
	}

	public function order($by = array(), $dir = '') {
		if (empty($by) && empty($dir)) {
			$this->set_errors('No order provided');
		}
		$this->ordering = $by;
		$this->direction = $dir;
	}

	public function insert($tablename) {
		$this->query_array[] = "INSERT INTO $tablename";
		$this->query_type = 'insert';
		// Returning self, so method is chainable
		return $this;
	}

	public function update($tablename) {
		$this->query_array[] = "UPDATE $tablename SET";
		$this->query_type = 'update';
		// Returning self, so method is chainable
		return $this;
	}

	private function _buildQueryString() {

		switch (strtolower($this->query_type)) {

			case 'update':
				$this->query_array[] = implode(' = ?,', $this->column_array);
				$this->query_array[] = ' = ?';
				break;

			case 'insert':
				$this->query_array[] = '(';
				$this->query_array[] = implode(',', $this->column_array);

			default:
				# code...
				break;
		}

		$this->sql = implode(' ', $this->query_array);
	}

	private function build_query_string() {

		// $this->query_array[] = $this->query_type;

		if (!empty($this->from_table_array)) {

			if (empty($this->column_array)) {
				$col = '*';

			} else {

				$col = implode(',', $this->column_array);
			}

			$this->query_array[] = $col;

			$from_tables = implode(',', $this->from_table_array);
			$this->query_array[] = 'FROM ' . $from_tables;

		} else {

			if (!empty($this->table_array)) {
				$this->query_array[] = implode(',', $this->table_array);
			}

			if (!empty($this->column_array)) {
				$col = implode(',', $this->column_array);
				$this->query_array[] = $col;
			}
		}

		if (!empty($this->where_array)) {
			$where = implode(' AND ', $this->where_array);
			$this->query_array[] = 'WHERE ' . $where;
		}

		if (!empty($this->ordering)) {
			$order = implode(',', $this->ordering);
			$this->query_array[] = 'ORDER BY ' . $order;

			if (!is_null($this->direction)) {
				$this->query_array[] = $this->direction;
			}
		}

		$this->sql = implode(' ', $this->query_array);

	}

	private function prepare() {

		if (!$this->stmt = $this->db->prepare($this->sql)) {
			$this->set_errors($this->db->error);
		}
		return $this->stmt;

	}

	private function bind() {
		if ($this->check_values()) {
			call_user_func_array(array($this->stmt, "bind_param"), $this->getRefArray());
		}
	}
	private function execute() {
		$this->stmt->execute();
	}

	public function getStmt() {
		return $this->stmt;
	}

	private function getRefArray() {
		$refArray = array($this->type_string);
		foreach($this->value_array as $value) {
			$refArray[] = &$value;
		}
		return $refArray;
	}

	private function check_values() {
		if (is_null($this->type_string)) {
			$this->set_errors('Type string is empty');
			return FALSE;
		}
		if (strlen($this->type_string) !== count($this->value_array)) {
			$this->set_errors('Types and values don\'t match');
			return FALSE;
		}
		return TRUE;
	}

	public function test($func, $params = array()) {
		call_user_func_array(array($this, $func), $params);
	}

	private function set_errors($error) {
		$this->errors[] = $error;
	}

	public function get_errors() {
		if (empty($this->errors)) {
			return FALSE;
		}
		return $this->errors;
	}
}