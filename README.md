# C言語基礎 - 関数仕様書生成

### 使用言語 PHP7.3.x, Python3.6.5

## 説明
複数のC言語で書かれたファイルをドロップし解析ボタンを押すとwordで出力され、ダウンロードされる。
ダウンロードするファイルが複数ある場合はzip形式でダウンロードされる。

## ファイルの説明

**index.php**  
ホームページ  

**processing.php**  
processing.pyを呼び出しwordのxmlファイルをダウンロード  
execを使いpythonを呼び出す。  

**upload.php**  
ドロップされたファイルを一時的にサーバーに保存する。  
処理が完了したら自動的に削除する。  

**processing.py**  
ソースコードから変数、引数、関数名などを調べる。  
完璧に調べられているのかはまだ不明である。  

**word.py**  
wordを作る。

**index.php.css**  
index.phpに使われるCSS。  

**.py**  
テスト用  

**.php**  
テスト用  

## フォルダの説明

**wordXmlTemplete**  
wordを作るためのテンプレート。  
テンプレートとはdocxのファイルをxmlに変換したもの。