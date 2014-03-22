<?php

function ask_the_db($db, $table, $select = '*', $where = '', $order = '', $dir = '', $limit = '') {
	if ($where !== '') {
		$where = "WHERE " . $where;
	}
	if ($order !== '') {
		$order = "ORDER BY " . $order;
	}
	if ($limit !== '') {
		$limit = "LIMIT " . $limit;
	}
	$result_array = array();

	$sql = "SELECT $select FROM $table $where $order $dir $limit";
	if ($results = $db->query($sql)) {
		while ($row = $results->fetch_assoc()) {
			array_push($result_array, $row);
		}
	}
	if (DEBUG && !$results) {
		return $db->error . ' ' . $sql;
	}
	return $result_array;
}

function update_the_db($db, $table, $rows, $where) {

	$sql = "UPDATE $table SET $rows WHERE $where";

	$results = $db->query($sql);

	if (DEBUG && !$results) {
		return $db->error . ' ' . $sql;
	}

	return $results;
}

function add_to_the_db($db, $table, $rows, $values) {

	$sql = "INSERT INTO $table ($rows) VALUES ($values)";

	$results = $db->query($sql);

	if (DEBUG && !$results) {
		return $db->error . ' ' . $sql;
	}

	return $results;
}

function remove_from_the_db($db, $table, $where) {

	$sql = "DELETE FROM $table WHERE $where";

	$results = $db->query($sql);

	if (DEBUG && !$results) {
		return $db->error . ' ' . $sql;
	}

	return $results;
}