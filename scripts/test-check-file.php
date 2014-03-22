<?php

require_once 'class.check-input.php';

function title($text) {
	echo '<h2>' . $text . '</h2>';
}

$test = new CheckInput();

$test_link = 'localhost://link.com/test';

$test_name = 'This is a test name;!';

$check_link = $test->check('link', $test_link);

$check_name = $test->check('name', $test_name);

$errors = $test->get_errors();


title('Check Link');
var_dump($check_link);

title('Check Name');
var_dump($check_name);

title('Errors');
var_dump($errors);