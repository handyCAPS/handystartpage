<?php

require_once 'db/connection.php';
require_once 'query.php';

require_once 'class.fileupload.php';

$upload = new Image_Upload();

$result = $upload->upload($_FILES['image']);

var_dump($result);