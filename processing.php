<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
</html>
<?php
require 'analysis.php';

function download($pPath, $pMimeType = null){

    console_log("download XML");

    //-- ファイルが読めない時はエラー(もっときちんと書いた方が良いが今回は割愛)
    if (!is_readable($pPath)) { die($pPath); }

    //-- Content-Typeとして送信するMIMEタイプ(第2引数を渡さない場合は自動判定) ※詳細は後述
    $mimeType = (isset($pMimeType)) ? $pMimeType: (new finfo(FILEINFO_MIME_TYPE))->file($pPath);

    //-- 適切なMIMEタイプが得られない時は、未知のファイルを示すapplication/octet-streamとする
    if (!preg_match('/\A\S+?\/\S+/', $mimeType)) {
        $mimeType = 'application/octet-stream';
    }

    //-- Content-Type
    header('Content-Type: ' . $mimeType);

    //-- ウェブブラウザが独自にMIMEタイプを判断する処理を抑止する
    header('X-Content-Type-Options: nosniff');

    //-- ダウンロードファイルのサイズ
    header('Content-Length: ' . filesize($pPath));

    //-- ダウンロード時のファイル名
    header('Content-Disposition: attachment; filename="' . basename($pPath) . '"');

    //-- keep-aliveを無効にする
    header('Connection: close');

    //-- readfile()の前に出力バッファリングを無効化する ※詳細は後述
    while (ob_get_level()) { ob_end_clean(); }

    //-- 出力
    readfile($pPath);
    console_log("download now");

}

// cookieからフォルダ名を取り出す
$folderName = $_COOKIE["folder"];
// cookieからファイル名のリストを取り出す
$fileNames = $_COOKIE["fileName"];
// cookieリストを配列化
$fileNames = preg_split('/,/', $fileNames);

// ZIPファイル圧縮
$zipfileName = "関数仕様書";
$zip = new ZipArchive;
$zip->open("process/".$folderName."/".$zipfileName.".zip", ZipArchive::CREATE|ZipArchive::OVERWRITE);

// 配列からファイル名を取り出す
foreach ($fileNames as $fileName) {
    if("0" != $fileName){
        $dir = "process/".$folderName;

        // ソースコードを解析して関数仕様書を書き出す
        analysis($dir, $fileName);

        // 拡張子を除外する
        $_fileName = $fileName;
        $fileName = str_replace(".cpp", "", $fileName);
        $fileName = str_replace(".c", "", $fileName);

        $downloadDir = "process/".$folderName."/".$fileName."関数仕様書.xml";
        
        // ファイルをZIPに圧縮
        $zip->addFile($downloadDir);
    }
}

// ZIPに圧縮する
$zip->close();

foreach ($fileNames as $fileName) {
    if("0" != $fileName){
        // 最後にファイルを削除
        //unlink("process/".$folderName."/".$fileName); // example.cpp

        // 拡張子を除外する
        $fileName = str_replace(".cpp", "", $fileName);
        $fileName = str_replace(".c", "", $fileName);
        $downloadDir = "process/".$folderName."/".$fileName."関数仕様書.xml";
        //unlink($downloadDir); // example関数仕様書.xml
    }
}

// ダウンロード
download("process/".$folderName."/".$zipfileName.".zip", "application/zip");

// ZIPファイル削除
//unlink("process/".$folderName."/".$zipfileName.".zip");

// ディレクトリを削除
console_log("remove directory");
//rmdir("process/".$folderName);

exit;