<?php
require 'word.php';
require 'console.php';

// パラメータ取得
$dirpath  = $_GET["dirpath"];
$fileName = $_GET["fileName"];

$dir = $dirpath."/".$fileName;

// 拡張子を除外する
$fileName = str_replace(".cpp", "", $fileName);
$fileName = str_replace(".c",   "", $fileName);

$source = file_get_contents($dir);

// 改行コード
$source = str_replace("\n", "", $source);
// 無駄な空白削除
$source = str_replace(" {", "{", $source);
$source = str_replace("{ ", "{", $source);
$source = str_replace(" ;", ";", $source);
// コメントアウト削除
$source = str_replace("//*\n", "", $source);
// 配列化
$code = preg_split("/[\{\}]/", $source);
// ブロック検出
$blockDetector = "0";
$functionName  = "";
// 関数名や変数名をここに格納する
$status = array();
// 変数
$status["variable"] = array();
// 関数
$status["function"] = array();
// メインファイルかどうかを判断する
$status["main"] = false;

function multiplyCombineCheckandSet($dictpath, $type, $variableName){
    // statusに引数の変数名と型が存在しなかった場合は作成する
    $variableName = str_replace($type." ", "", $variableName);
    $variableName = str_replace(" ", "", $variableName);

    if(array_key_exists($type, $dictpath)){ // 存在する場合
        array_push($dictpath[$type], $variableName);
    }else{ // 存在しない場合
        $dictpath[$type] = array();
    }
}
function multiplyCombine($data, $dictpath){
    // 関数の引数をstatusに格納する
    foreach ($data as $functionv) {
        if(strpos($functionv, "int") !== false){
            multiplyCombineCheckandSet($dictpath, "int", functionv);
        }
        elseif(strpos($functionv, "double") !== false){
            multiplyCombineCheckandSet($dictpath, "double", functionv);
        }
        elseif(strpos($functionv, "float") !== false){
            multiplyCombineCheckandSet($dictpath, "float", functionv);
        }
        elseif(strpos($functionv, "char") !== false){
            multiplyCombineCheckandSet($dictpath, "char", functionv);
        }
        elseif(strpos($functionv, "short") !== false){
            multiplyCombineCheckandSet($dictpath, "short", functionv);
        }
        elseif(strpos($functionv, "long") !== false){
            multiplyCombineCheckandSet($dictpath, "long", functionv);
        }
    }
}
function addVariable($type, $var){
    // 変数名を抽出してstatusに格納する
    $var = str_replace($type." ", "", $var);
    $var = str_replace(";", "", $var);
    $var = preg_split(";", $var);
    foreach ($var as $variable) {
        $variable = preg_split("=", $variable);
        $variable = str_replace(" ", "", $variable[0]);

        if(array_key_exists($type, $status["variable"])){ // 存在する場合
            array_push($status["variable"][$type], $variable);
        }else{ // 存在しない場合
            $status["variable"][$type] = array();
        }
    }

}
function multiplyCheckandSet($type, $functionName){
    // 関数名と型がstatusに格納されているか判断し、なかった場合は作成する
    if(array_key_exists($type, $status["function"])){ // 存在する場合
        $status["function"][$type][$functionName] = array();
    }else{ // 存在しない場合
        $status["variable"][$type] = array();
        $status["variable"][$type][$functionName] = array();
        $Funcdict = $status["variable"][$type][$functionName];
    }
    return $Funcdict;
}
function addFunction($type, $function){
    // 関数かどうかを判断して関数でなければFalseを返す
    if(!strcmp($type, "void")){
        $function = substr($function, 5);              // 型名削除
        $function = preg_split("/[\(\)]/", $function); // ex: ["function", "int a, int b"]
        $funv = preg_split(",", $function[1]);         // ex: ["int a", "int b"]
        if(strpos($function[0], " ") === false){       // 関数名に余白がない場合
            $Funcdict = multiplyCheckandSet($type, $function[0]);
            multiplyCombine($funv, $Funcdict);
            return $function[0];
        }
    }
    if(!strcmp($type, "int")){
        $function = substr($function, 4);
        $function = preg_split("/[\(\)]/", $function);
        $funv = preg_split(",", $function[1]);
        if(strpos($function[0], " ") === false){
            $Funcdict = multiplyCheckandSet($type, $function[0]);
            multiplyCombine($funv, $Funcdict);
            return $function[0];
        }
        return false;
    }
    if(!strcmp($type, "double")){
        $function = substr($function, 7);
        $function = preg_split("/[\(\)]/", $function);
        $funv = preg_split(",", $function[1]);
        if(strpos($function[0], " ") === false){
            $Funcdict = multiplyCheckandSet($type, $function[0]);
            multiplyCombine($funv, $Funcdict);
            return $function[0];
        }
        return false;
    }
    if(!strcmp($type, "float")){
        $function = substr($function, 6);
        $function = preg_split("/[\(\)]/", $function);
        $funv = preg_split(",", $function[1]);
        if(strpos($function[0], " ") === false){
            $Funcdict = multiplyCheckandSet($type, $function[0]);
            multiplyCombine($funv, $Funcdict);
            return $function[0];
        }
        return false;
    }
    if(!strcmp($type, "char")){
        $function = substr($function, 5);
        $function = preg_split("/[\(\)]/", $function);
        $funv = preg_split(",", $function[1]);
        if(strpos($function[0], " ") === false){
            $Funcdict = multiplyCheckandSet($type, $function[0]);
            multiplyCombine($funv, $Funcdict);
            return $function[0];
        }
        return false;
    }
    if(!strcmp($type, "short")){
        $function = substr($function, 6);
        $function = preg_split("/[\(\)]/", $function);
        $funv = preg_split(",", $function[1]);
        if(strpos($function[0], " ") === false){
            $Funcdict = multiplyCheckandSet($type, $function[0]);
            multiplyCombine($funv, $Funcdict);
            return $function[0];
        }
        return false;
    }
    if(!strcmp($type, "long")){
        $function = substr($function, 5);
        $function = preg_split("/[\(\)]/", $function);
        $funv = preg_split(",", $function[1]);
        if(strpos($function[0], " ") === false){
            $Funcdict = multiplyCheckandSet($type, $function[0]);
            multiplyCombine($funv, $Funcdict);
            return $function[0];
        }
        return false;
    }
}


/* ---- Test Json Data ----
$status = array(
    "variable" => array(
        "int" => array("e", "r")
    ),
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
*/
console("start transform");

// 変数の型と変数名を検出する
foreach ($code as $string) {
    // 非貪欲マッチ
    preg_match("/int .*?;/",    $string, $int_match);
    preg_match("/double .*?;/", $string, $double_match);
    preg_match("/float .*?;/",  $string, $float_match);
    preg_match("/char .*?;/",   $string, $char_match);
    preg_match("/short .*?;/",  $string, $short_match);
    preg_match("/long .*?;/",   $string, $long_match);

    if([] != $int_match){
        foreach ($int_match as $var) {
            addVariable("int", var);
        }
    }
    if([] != $double_match){
        foreach ($double_match as $var) {
            addVariable("double", var);
        }
    }
    if([] != $float_match){
        foreach ($float_match as $var) {
            addVariable("float", var);
        }
    }
    if([] != $char_match){
        foreach ($char_match as $var) {
            addVariable("char", var);
        }
    }
    if([] != $short_match){
        foreach ($short_match as $var) {
            addVariable("short", var);
        }
    }
    if([] != $long_match){
        foreach ($long_match as $var) {
            addVariable("long", var);
        }
    }
}

// 関数を検出し、関数宣言子と引数の型と引数名を調べる
foreach ($code as $string) {
    // 非貪欲マッチ
    preg_match("/void .*\(.*\)/",   $string, $void_match);
    preg_match("/int .*\(.*\)/",    $string, $int_match);  // ex: int function(int a, int b)
    preg_match("/double .*\(.*\)/", $string, $double_match);
    preg_match("/float .*\(.*\)/",  $string, $float_match);
    preg_match("/char .*\(.*\)/",   $string, $char_match);
    preg_match("/short .*\(.*\)/",  $string, $short_match);
    preg_match("/long .*\(.*\)/",   $string, $long_match);
    
    if([] != $void_match){
        $functionName = addFunction("void", void_match[0]);
    }
    if([] != $int_match){
    }
    if([] != $double_match){
    }
    if([] != $float_match){
    }
    if([] != $char_match){
    }
    if([] != $short_match){
    }
    if([] != $long_match){
    }
}

$word = transform($status, "main");
if($word){
    var_dump($word);
}
?>