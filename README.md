# C言語基礎 - 関数仕様書生成

### 使用言語 PHP7.3.x, Python3.6.5

## ファイルの説明

**index.php**  
ホームページ  

**processing.php**  
processing.pyを呼び出しwordのxmlファイルをダウンロード  

**upload.php**  
ドロップされたファイルを一時的にサーバーに保存する。  
処理が完了したら自動的に削除する。  

**processing.py**  
ソースコードから変数、引数、関数名などを調べる。  

**word.py**  
wordを作る。

**index.php.css**  
index.phpに使われるCSS  

## フォルダの説明

**wordXmlTemplete**  
wordを作るためのテンプレート。  
テンプレートとはdocxのファイルをxmlに変換したもの。