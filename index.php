<?php
// フォルダの名前を決めて24時間cookieに保存する - 既にある場合はリセットするため削除する
if(isset($_COOKIE['folder'])){
    setcookie('folder', '', time()-3600*24);
}
?>
<!doctype html>

<html lang="ja">
    <head>
        <title>C言語基礎 - 関数仕様書生成</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="description" content="" />
        <link href="https://fonts.googleapis.com/earlyaccess/mplus1p.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/style.css">
        <script>
            function analysis(){
                if("0" != Cookies.get("fileName")){
                    window.location.href = "processing.php";
                    console.log("window location href: processing.php")
                }
                else{
                    alert("ファイルをアップロードしてください。");
                    console.log("cookie failue.")
                }
            }
            Cookies.set("fileName", "0");
            console.log("cookie set: ['fileName'] -> 0");
        </script>
        <script>
            $(function(){
                $('#drag-area').bind('drop', function(e){
                    // デフォルトの挙動を停止
                    e.preventDefault();
                
                    // ファイル情報を取得
                    var files = e.originalEvent.dataTransfer.files;
                
                    uploadFiles(files);
                
                }).bind('dragenter', function(){
                    // デフォルトの挙動を停止
                    return false;
                }).bind('dragover', function(){
                    // デフォルトの挙動を停止
                    return false;
                });
                
                $('#btn').click(function() {
                    // ダミーボタンとinput[type="file"]を連動
                    $('input[type="file"]').click();
                });
                
                $('input[type="file"]').change(function(){
                    // ファイル情報を取得
                    var files = this.files;
                
                    uploadFiles(files);
                });
            });
            
            function uploadFiles(files) {
            // FormDataオブジェクトを用意
            var fd = new FormData();
            
            // ファイルの個数を取得
            var filesLength = files.length;
            
            // ファイル情報を追加
            for (var i = 0; i < filesLength; i++) {
                console.log("get file name: "+files[i]["name"]);
                // ファイル名をcookieに保存
                cookiesGet = Cookies.get('fileName');
                if(cookiesGet.indexOf(files[i]["name"]) == -1){
                    dt = Cookies.get("fileName")+","+files[i]["name"];
                    Cookies.set("fileName", dt);
                    console.log("cookie set: ['fileName'] -> "+files[i]["name"]);
                    // ファイル名をページに表示させる
                    fileNameElement = document.getElementById("filename");
                    fileNameElement.innerHTML = fileNameElement.textContent + "　" + files[i]["name"];
                }
                fd.append("files[]", files[i]);
            }
            
            // Ajaxでアップロード処理をするファイルへ内容渡す
            $.ajax({
                url: 'upload.php',
                type: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {
                alert(data);
                }
            });
            }
        </script>
    </head>
    <body>
        <div class="header"></div>
        <div class="title"><p>C言語基礎 - 関数仕様書生成</p></div>
        <!-- ソースコードをテキストエリアに貼る
        <form class="box" name="box">
            <textarea name="textarea" value="1" cols="86" rows="50" placeholder="ここにソースコードを張り付けて下さい。"></textarea>
        </form>
        -->
        <div id="drag-area">
            <p>アップロードするファイルをまとめてドロップ</p>
            <p>または</p>
            <div class="btn-group">
                <input type="file" multiple="multiple" style="display:none;" name="files"/>
                <button id="btn">ファイルを選択</button>
            </div>
        </div>
        <div class="filename-area">
            <div id="filename" class="filename"></div>
        </div>
        <div class="analysis">
            <a href="javascript:analysis()"></a>
            <p>解析</p>
        </div>
        <div class="footer"></div>
    </body>
</html>