<?php
// フォルダの名前を決めて24時間cookieに保存する - 既にある場合は既存のものを使う
if(isset($_COOKIE['folder'])){
	$dir = $_COOKIE['folder'];
}else{
	$dir = rand(10000, 99999);
	mkdir("process/".$dir);
}

setcookie("folder", $dir, time()+3600*24); 
$count = count($_FILES['files']['tmp_name']);
for($i = 0 ; $i < $count ; $i ++ ){
	if (is_uploaded_file($_FILES["files"]["tmp_name"][$i])){
		if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], "process/".$dir."/".$_FILES["files"]["name"][$i])){
			//echo "ok:" . $_FILES["files"]["name"][$i] . "\n";
			echo "ファイルのアップロードが完了しました。\n";
		}
		else{
			echo "ファイルがアップロードできませんでした。\nページを更新してください。" . $_FILES["files"]["name"][$i];
		}
	}
	else{
		echo "ファイルが存在しません。" . $i;
	}
}
exit;
?>