<?php
require_once 'phpword/vendor/autoload.php';

// PHPWordインスタンス
$phpWord = new \PhpOffice\PhpWord\PhpWord();
 
// セクションを追加
$section = $phpWord->addSection();
 
// 文字列の記述
$section->addText("テスト");
 
// Word作成
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
 
// サーバーに出力
$filename = "sample_" . date('YmdHis') . ".docx"; //ファイル名
$objWriter->save("./data/" . $filename);

/*
$templete = new \PhpOffice\PhpWord\TemplateProcessor("mainFunctionTemplete.docx");

$template->setValue('variableType', 'variableType');
$template->setValue('mainFunctionArg', 'mainFunctionArg');
$template->setValue('variableName', 'variableName');
$template->setValue('functionName', 'functionName');
$template->setValue('functionArg', 'functionArg');
$template->setValue('functionArgType', 'functionArgType');
$template->setValue('returnType', 'returnType');

$filename = 'test.docx';
header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename='.$filename);
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
ob_end_clean(); //バッファ消去
$templateProcessor->saveAs("php://output");

*/