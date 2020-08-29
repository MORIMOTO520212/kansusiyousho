<?php
$externString = "";

if($externString){
    // ついでにexternで宣言された関数を見つけ、code配列に関数を追加
    $externString = explode("extern", $externString);
    foreach ($externString as $externfunc) {
        var_dump($externfunc);
    }
}