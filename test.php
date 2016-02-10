<?php

require_once 'scripts/db/connection.php';
require_once 'scripts/class.fileupload.php';

print_r(File_Upload::get_root_path());
exit();

require_once 'scripts/class.talktodb.php';

$dbcall = new TalkToDB();

if($errors = $dbcall->get_errors()) {
	var_dump($errors);
}

// $testvalues = array();

$testvalues = array(2);

$dbcall->update('users')
->columns(array('name', 'color'))
->values(array('s' => 'Tim', 's' => 'brown'));

$dbcall->test('_buildQueryString');

$dbcall->test('prepare');

// $dbcall->test('bind');
// $dbcall->test('execute');

var_dump($dbcall);

print_r($dbcall->getStmt());
