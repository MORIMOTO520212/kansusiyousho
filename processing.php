<?php
// cookieからフォルダ名を取り出す
$folderName = $_COOKIE["folder"];
// cookieからファイル名のリストを取り出す
$fileNames = $_COOKIE["fileName"];
// リストを配列化
$fileNames = preg_split('/,/', $fileNames);
// 配列からファイル名を取り出す
foreach ($fileNames as $fileName) {
    if("0" != $fileName){
        $dir = "process/".$folderName."/".$fileName;
        // python実行
        $command = "python processing.py ".$dir." ".$fileName;
        exec($command, $output);
        // -- 保存したwordをダウンロード -- //


        // 最後にファイルを削除
        unlink("process/".$_COOKIE["folder"]."/".$fileName);
    }
}
// プログラムの終了にディレクトリを削除
rmdir("process/".$_COOKIE["folder"]);