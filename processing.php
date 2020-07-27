<?php
$fileName = $_COOKIE["fileName"];
$fileName = preg_split('/,/', $fileName);
//$source = base64_decode($_GET["source"]);
$command = "python processing.py";
exec($command, $output);
$str = str_replace("'", "\"", $output[0]);
$str = str_replace("\"{", "{", $str);
$str = str_replace("}\"", "}", $str);
$str = str_replace(": True", ": true", $str);
$str = str_replace(": False", ": false", $str);
$status = json_decode($str, true);

//var_dump($status);

var_dump($status["variable"]["int"]);

// 最後にファイルとディレクトリを削除
// unlink($_COOKIE["folder"].$filename);
// rmdir($_COOKIE["folder"]);