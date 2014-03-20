<?php

require_once 'class.check-input.php';

$test = new CheckInput();

$test_link = 'localhost://link.com/test';

$check_link = $test->check('link', $test_link);

$errors = $test->get_errors();

var_dump($check_link);

var_dump($errors);