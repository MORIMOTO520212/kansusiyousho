<?php
$folderName = $_COOKIE["folder"];
// cookieからファイル名のリストを取り出す
$fileNames = $_COOKIE["fileName"];
// リストを配列化
$fileNames = preg_split('/,/', $fileNames);
// 配列からファイル名を取り出す
foreach ($fileNames as $fileName) {
    if "0" != $fileNames:
        $source = file_get_contents("process/".$folderName."/".$fileName, true);
        // python実行
        $command = "python processing.py \"".$source."\"";
        exec($command, $output);
        $str = str_replace("'", "\"", $output[0]);
        $str = str_replace("\"{", "{", $str);
        $str = str_replace("}\"", "}", $str);
        $str = str_replace(": True", ": true", $str);
        $str = str_replace(": False", ": false", $str);
        $status = json_decode($str, true);
        echo $fileName." :\n";
        var_dump($status);

}
// 最後にファイルとディレクトリを削除
// unlink($_COOKIE["folder"].$filename);
// rmdir($_COOKIE["folder"]);