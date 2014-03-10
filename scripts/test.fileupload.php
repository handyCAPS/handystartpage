<?php

require_once 'class.fileupload.php';

$file = $_FILES['image'];

echo "<h3>Root Folder</h3>";

$root = File_Upload::get_root_path();
var_dump($root);

$imgupload = new Image_Upload('ups');

$imgupload->upload($file);

echo "<h3>Upload result</h3>";
$resultupload = $imgupload->save();
// if ($resultupload['state']) {
	var_dump($resultupload);
// }



echo "<h3>File Location</h3>";

$filelocation = $imgupload->get_location();
var_dump($filelocation);




echo "<h3>Img Upload Errors</h3>";
