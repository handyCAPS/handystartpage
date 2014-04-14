<?php

require_once 'scripts/class.talktodb.php';

$dbcall = new TalkToDB();

if($errors = $dbcall->get_errors()) {
	var_dump($errors);
}

$testvalues = array();

$testvalues = array(2);

$dbcall->query('SELECT')->from(array('users'))->where(array('id = ?'))->types('s')->values($testvalues);

$dbcall->test('build_query_string');

//$dbcall->test('prepare');

//$dbcall->test('bind');
$dbcall->executeQuery();

var_dump($dbcall);
