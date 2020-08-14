<?php
require 'word.php';
require 'console.php';

$status = array(
    "variable" => array(),
    "function" => array(
        "double" => array(
            "stimate" => array(
                "double" => array("a", "b")
            )
        ),
        "int" => array(
            "main" => array()
        ),
        "main" => true
    )
);

console("start transform");
$word = transform($status, "main");
if($word){
    var_dump($word);
}
?>