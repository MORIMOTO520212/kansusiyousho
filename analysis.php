<?php
require 'word.php';


// ブロック検出
$blockDetector = "0";

// 関数名や変数名をここに格納する
console_log("create status array");
$status = array();
// 変数
$status["variable"] = array();
// 関数
$status["function"] = array();
// メインファイルかどうかを判断する
$status["main"] = false;
// externの有無
$externString = false;

function multiplyCombineCheckandSet($dictpath, $type, $variableName){
    // 関数の　引数の型　関数名　を格納する
    console_log("[ multiplyCombineCheckandSet ]");
    global $status;
    // statusに引数の変数名と型が存在しなかった場合は作成する
    $variableName = str_replace($type." ", "", $variableName);
    $variableName = str_replace(" ", "", $variableName);

    // $dictpath[0] 型名, $dictpath[1] 関数名
    console_log("array -> \$status[function][".$dictpath[0]."][".$dictpath[1]."][".$type."][".$variableName."]");

    if(array_key_exists($type, $status["function"][$dictpath[0]][$dictpath[1]])){ // 存在する場合
        array_push($status["function"][$dictpath[0]][$dictpath[1]][$type], $variableName);

    }else{ // 存在しない場合
        $status["function"][$dictpath[0]][$dictpath[1]][$type] = array();
        array_push($status["function"][$dictpath[0]][$dictpath[1]][$type], $variableName);
    }
}
function multiplyCombine($data, $dictpath){
    console_log("[ multiplyCombine ]");
    // 関数の引数をstatusに格納する
    foreach ($data as $functionv) {
        if(strpos($functionv, "int") !== false){
            multiplyCombineCheckandSet($dictpath, "int", $functionv);
        }
        elseif(strpos($functionv, "double") !== false){
            multiplyCombineCheckandSet($dictpath, "double", $functionv);
        }
        elseif(strpos($functionv, "float") !== false){
            multiplyCombineCheckandSet($dictpath, "float", $functionv);
        }
        elseif(strpos($functionv, "char") !== false){
            multiplyCombineCheckandSet($dictpath, "char", $functionv);
        }
        elseif(strpos($functionv, "short") !== false){
            multiplyCombineCheckandSet($dictpath, "short", $functionv);
        }
        elseif(strpos($functionv, "long") !== false){
            multiplyCombineCheckandSet($dictpath, "long", $functionv);
        }
    }
}
function addVariable($type, $var){
    console_log("[ addVariable ]");
    global $status;
    // 変数名を抽出してstatusに格納する
    $var = str_replace($type." ", "", $var);
    $var = str_replace(";", "", $var);
    $var = preg_split("/[,]/", $var);

    foreach ($var as $variable) {
        $variable = preg_split("/[=]/", $variable);
        $variable = str_replace(" ", "", $variable[0]);
        
        console_log("array -> \$status[variable][".$type."][".$variable."]");
        if(array_key_exists($type, $status["variable"])){ // 存在する場合
            array_push($status["variable"][$type], $variable);
        }else{ // 存在しない場合
            $status["variable"][$type] = array();
            array_push($status["variable"][$type], $variable);
        }
    }

}
function multiplyCheckandSet($type, $functionName){
    console_log("[ multiplyCheckandSet ]");
    global $status;
    // 関数名と型がstatusに格納されているか判断し、なかった場合は作成する
    if(array_key_exists($type, $status["function"])){ // 存在する場合
        $status["function"][$type][$functionName] = array();
    }else{ // 存在しない場合
        $status["function"][$type] = array();
        $status["function"][$type][$functionName] = array();
        $status["function"][$type][$functionName];
    }
    return array($type, $functionName);
}
function addFunction($type, $function){
    console_log("[ addFunction ]");
    // 関数かどうかを判断して関数でなければFalseを返す
    if(!strcmp($type, "void")){
        $function = substr($function, 5);              // 型名削除
        $function = preg_split("/[\(\)]/", $function); // ex: ["function", "int a, int b"]
        $funv = preg_split("/[,]/", $function[1]);         // ex: ["int a", "int b"]
        if(strpos($function[0], " ") === false){       // 関数名に余白がない場合
            $Funcdict = multiplyCheckandSet($type, $function[0]);
            multiplyCombine($funv, $Funcdict);
            return $function[0];
        }
    }
    if(!strcmp($type, "int")){
        $function = substr($function, 4);
        $function = preg_split("/[\(\)]/", $function);
        $funv = preg_split("/[,]/", $function[1]);
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
        $funv = preg_split("/[,]/", $function[1]);
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
        $funv = preg_split("/[,]/", $function[1]);
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
        $funv = preg_split("/[,]/", $function[1]);
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
        $funv = preg_split("/[,]/", $function[1]);
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
        $funv = preg_split("/[,]/", $function[1]);
        if(strpos($function[0], " ") === false){
            $Funcdict = multiplyCheckandSet($type, $function[0]);
            multiplyCombine($funv, $Funcdict);
            return $function[0];
        }
        return false;
    }
}

// パラメータ取得
function analysis($dirpath, $fileName){
    console_log("--- start analysis ---");
    global $status, $blockDetector;
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

    // 変数の型と変数名を検出する
    foreach ($code as $string) {
        // 非貪欲マッチ
        if( strpos($string, "extern") === false ){ // externで宣言された関数が含まれていない場合　※引数を検出させないために
            preg_match("/int .*?;/",    $string, $int_match);
            preg_match("/double .*?;/", $string, $double_match);
            preg_match("/float .*?;/",  $string, $float_match);
            preg_match("/char .*?;/",   $string, $char_match);
            preg_match("/short .*?;/",  $string, $short_match);
            preg_match("/long .*?;/",   $string, $long_match);

            if([] != $int_match){
                foreach ($int_match as $var) {
                    console_log("variable int match");
                    addVariable("int", $var);
                }
            }
            if([] != $double_match){
                foreach ($double_match as $var) {
                    console_log("variable double match");
                    addVariable("double", $var);
                }
            }
            if([] != $float_match){
                foreach ($float_match as $var) {
                    console_log("variable float match");
                    addVariable("float", $var);
                }
            }
            if([] != $char_match){
                foreach ($char_match as $var) {
                    console_log("variable char match");
                    addVariable("char", $var);
                }
            }
            if([] != $short_match){
                foreach ($short_match as $var) {
                    console_log("variable short match");
                    addVariable("short", $var);
                }
            }
            if([] != $long_match){
                foreach ($long_match as $var) {
                    console_log("variable long match");
                    addVariable("long", $var);
                }
            }
        }
        else{ // externが含まれている場合
            $externString = $string;
        }
    }

    if($externString){
        // ついでにexternで宣言された関数を見つけ、code配列に関数を追加
        console_log("extern function match");
        $externString = explode(";", $externString);
        foreach ($externString as $externfunc) {
            $externfunc = str_replace("extern", "", $externfunc);
            array_push($code, $externfunc);
        }
    }


    // 関数を検出し、関数宣言子と引数の型と引数名を調べる
    foreach ($code as $string) {
        // 非貪欲マッチ
        if( strpos($string, "extern") === false ){ // externで宣言された関数が含まれていない場合
            preg_match("/void .*\(.*\)/",   $string, $void_match);
            preg_match("/int .*\(.*\)/",    $string, $int_match);  // ex: int function(int a, int b)
            preg_match("/double .*\(.*\)/", $string, $double_match);
            preg_match("/float .*\(.*\)/",  $string, $float_match);
            preg_match("/char .*\(.*\)/",   $string, $char_match);
            preg_match("/short .*\(.*\)/",  $string, $short_match);
            preg_match("/long .*\(.*\)/",   $string, $long_match);
            
            if([] != $void_match){
                console_log("function void match");
                $functionName = addFunction("void", $void_match[0]);
                if($functionName){ // 関数だった場合
                    $type = "void";
                }
            }
            if([] != $int_match){
                console_log("function int match");
                $functionName = addFunction("int", $int_match[0]);
                if($functionName){
                    $type = "int";
                    if(strpos($int_match[0], "main") !== false){ // メインファイルだった場合
                        $status["main"] = true;
                    }
                }
            }
            if([] != $double_match){
                console_log("function double match");
                $functionName = addFunction("double", $double_match[0]);
                if($functionName){
                    $type = "double";
                }
            }
            if([] != $float_match){
                console_log("function float match");
                $functionName = addFunction("float", $float_match[0]);
                if($functionName){
                    $type = "float";
                }
            }
            if([] != $char_match){
                console_log("function char match");
                $functionName = addFunction("char", $char_match[0]);
                if($functionName){
                    $type = "char";
                }
            }
            if([] != $short_match){
                console_log("function short match");
                $functionName = addFunction("short", $short_match[0]);
                if($functionName){
                    $type = "short";
                }
            }
            if([] != $long_match){
                console_log("function long match");
                $functionName = addFunction("long", $long_match[0]);
                if($functionName){
                    $type = "long";
                }
            }

            // 関数の中の戻り値を検出する
            if(!$functionName){
                $functionName = $blockDetector;
            }
            if($functionName){
                if($functionName == $blockDetector){
                    if(strpos($string, "return") !== false){
                        if(strpos($string, "return 0") === false){
                            $status["function"][$type][$functionName]["return"] = $type;
                        }
                    }
                }else{
                    $blockDetector = $functionName;
                }
            }
        }
    }

    // transform関数を使ってwordを作成する
    console_log("--- start transform ---");
    $word = transform($status, "main");
    // xml形式でwordを保存
    console_log("save xml");
    $file = fopen($dirpath."/".$fileName."関数仕様書.xml", "w");
    fwrite($file, $word);
    fclose($file);

}
?>