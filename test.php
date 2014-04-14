<?php

require_once 'scripts/class.talktodb.php';

$dbcall = new TalkToDB();

if($errors = $dbcall->get_errors()) {
	var_dump($errors);
}

$testvalues = array();

for ($i = 0; $i < 2; $i++) {
	$testvalues[$i] = 'Test' . $i;
}

$dbcall->query('SELECT')->from(array('users'))->where(array('name = ?', 'id = ?'))->types('ss')->values($testvalues);

$dbcall->test('build_query_string');

$dbcall->test('prepare');

$dbcall->test('bind');


var_dump($dbcall);
