<?php
	// フォルダの名前を決めて24時間cookieに保存する
	$dir = rand(10000, 99999);
	setcookie("folder", $dir, time()+3600*24); 
	$count = count($_FILES['files']['tmp_name']);
	for($i = 0 ; $i < $count ; $i ++ ){
		if (is_uploaded_file($_FILES["files"]["tmp_name"][$i])){
			if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $dir.$_FILES["files"]["name"][$i])){
                //echo "ok:" . $_FILES["files"]["name"][$i] . "\n";
                echo "ファイルのアップロードが完了しました。\n".$_FILES["files"]["name"][$i];
			}
			else{
                echo "ファイルがアップロードできませんでした。\n" . $_FILES["files"]["name"][$i];
			}
		}
		else{
			echo "ファイルが存在しません。" . $i;
		}
	}
?>