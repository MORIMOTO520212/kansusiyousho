<?php
require 'console.php';
function transform($status, $fileName){
    console_log("[ transform ]");

    console_log("file get contents");
    $VFtemp    = file_get_contents("wordXmlTemplete/kansusiyoushoVF.xml");
    $Vtemp     = file_get_contents("wordXmlTemplete/kansusiyoushoV.xml" );
    $Ftemp     = file_get_contents("wordXmlTemplete/kansusiyoushoF.xml" );
    $addV_temp = file_get_contents("wordXmlTemplete/addVariable.xml"    );
    $addF_temp = file_get_contents("wordXmlTemplete/addFunction.xml"    );

    console_log("preg replace");
    $pattern   = "/<!--.*-->/";
    $VFtemp    = preg_replace($pattern, "", $VFtemp);
    $Vtemp     = preg_replace($pattern, "", $Vtemp);
    $Ftemp     = preg_replace($pattern, "", $Ftemp);
    $addV_temp = preg_replace($pattern, "", $addV_temp);
    $addF_temp = preg_replace($pattern, "", $addF_temp);

    $docId = "{6DA8B8D9-FBDD-4927-A623-E8288315FC7F}";
    $fmid  = "{D5CDD505-2E9C-101B-9397-08002B2CF9AE}";

    $val           = false;
    $func          = false;
    $variable_temp = "";
    $function_temp = "";
    $returnType    = "";

    # 変数がある場合
    console_log("variable count");
    if( count($status["variable"]) ){
        $val = true;
    }
    # 関数がある場合
    console_log("function count");
    if( count($status["function"]) ){
        $func = true;
    }
    # main関数だけだった場合は関数なしにする
    console_log("checking main function");
    if( count($status["function"]) == 1 ){
        if( array_key_exists("int", $status["function"]) ){
            if( array_key_exists("main", $status["function"]["int"]) ){
                $func = false;
            }
        }
    }
    
    # テンプレートを使ってwordを作る
    # 変数と関数の仕様書
    if( $val and $func ){

        console_log("[variable and function] buiding");

        # 変数の表を作る
        foreach ($status["variable"] as $variableType => $value) { # 変数の型

            foreach ($status["variable"][$variableType] as $variableName) { # 変数名
                
                $variable_temp .= sprintf($addV_temp, $variableName, $variableType);
            }
        }

        # 関数の表を作る
        foreach ($status["function"] as $functionType => $value) { # 戻り値の型
            $returnType = $functionType;

            foreach ($status["function"][$functionType] as $functionName => $value) { # 関数名

                $argument_type = "";
                $argument_name = "";

                if($functionName != "main"){
                    console_log("[\$functionName] ".$functionName);
                    foreach ($status["function"][$functionType][$functionName] as $argumentType => $value) { # 引数の型
                        console_log("[\$argumentType] ".$argumentType);
                        if($argumentType != "return"){ # 型の場所に入っているreturnは除外
                            $argument_type .= $argumentType.", ";

                            foreach ($status["function"][$functionType][$functionName][$argumentType] as $argumentName) { # 引数名
                                $argument_name .= $argumentName.", ";
                                $argumentInfo   = $argument_name;
                            }
                        }
                    }
                }
                # 引数がなければ
                if($functionName != "main"){ # main関数でない場合
                    if (!$argument_name){
                        $argument_name = "なし";
                    }
                    if (!$argument_type){ 
                        $argument_type = "なし";
                    }
                    if ($functionType == "void"){
                        $functionType  = "なし";
                    }
                    $function_temp .= sprintf($addF_temp, $functionName, $functionType, $argument_name, $argument_type);
                }
            }
        }


        if( array_key_exists("main", $status) ){
            console_log("find main function");
            $returnType   = "なし";
            $argumentInfo = "なし";
        }

        $VFtemp = str_replace("1%s", $variable_temp, $VFtemp);
        $VFtemp = str_replace("2%s", $function_temp, $VFtemp);
        $VFtemp = str_replace("3%s", $fileName     , $VFtemp);
        $VFtemp = str_replace("4%s", $returnType   , $VFtemp);
        $VFtemp = str_replace("5%s", $argumentInfo , $VFtemp);
        $word = $VFtemp;

    }
    # 関数のみの仕様書
    elseif( $func ){

        console_log("[function] buiding");

        foreach ($status["function"] as $functionType => $value) { # 戻り値の型
            $returnType = $functionType;

            if($functionType != "main"){ # 関数リストからmain関数は除外
                foreach ($status["function"][$functionType] as $functionName => $value) { # 関数名
                    $argument_type = "";
                    $argument_name = "";

                    foreach ($status["function"][$functionType][$functionName] as $argumentType => $value) {
                        
                        if($argumentType != "return"){
                            $argument_type .= $argumentType.", ";

                            foreach ($status["function"][$functionType][$functionName][$argumentType] as $argumentName) { # 引数名
                                $argument_name .= $argumentName.", ";
                                $argumentInfo   = $argument_name;
                            }
                        }
                    }
                    # 引数がなければ
                    if($functionName != "main"){ # 関数リストからmain関数は除外 2
                        if( !$argument_name ){
                            $argument_name = "なし";
                        }
                        if( !$argument_type ){
                            $argument_type = "なし";
                        }
                        if($functionType == "void"){
                            $functionType = "なし";
                        }
                        $function_temp .= sprintf($addF_temp, $functionName, $functionType, $argumentInfo, $argument_type);
                    }
                }
            }
        }

        if( $status["function"]["main"] ){
            $returnType   = "なし";
            $argumentInfo = "なし";
        }

        $Ftemp = str_replace("1%s", $function_temp, $Ftemp);
        $Ftemp = str_replace("2%s", $fileName,      $Ftemp);
        $Ftemp = str_replace("3%s", $returnType,    $Ftemp);
        $Ftemp = str_replace("4%s", $argument_name, $Ftemp);
        $word = $Ftemp;

    }
    else{
        console_log("ERROR: status data not found.");
        $word = false;
    }

    console_log("build successfully");
    return $word;
}

$status = array(
    "variable" => array(
        "int" => array(
            "input[10]", 
            "output[10]", 
            "data1[10]", 
            "data2[10]", 
            "i"
        )
    ), 
    "function" => array(
        "void" => array(
            "InsertionSort" => array(
                "int" => array(
                    "n", 
                    "input[]", 
                    "output[]"
                )
            ),
            "SelectionSort" => array(
                "int" => array(
                    "n", 
                    "data[]"
                )
            ),
            "BubbleSort" => array(
                "int" => array(
                    "n", 
                    "data[]"
                )
            )
        ),
        "int" => array(
            "main" => array()
        )
    ), 
    "main" => true
);
$fileName = "project001";
$result = transform($status, $fileName);

echo $result;