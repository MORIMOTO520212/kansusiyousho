<!doctype html>
<html>
    <head>
        <title>C言語基礎 - 関数仕様書生成</title>
        <link rel="stylesheet" type="text/css" href="assets/index.php.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="https://fonts.googleapis.com/earlyaccess/mplus1p.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script>
            function analysis(){
                var sourceCode = document.forms.box.textarea.value;
                console.log(sourceCode);
                window.location.href = "processing.php?source="+btoa(sourceCode);
            }
            Cookies.set("fileName", "0")
        </script>
        <script>
            $(function(){
            /*================================================
                ファイルをドロップした時の処理
            =================================================*/
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
            
            /*================================================
                ダミーボタンを押した時の処理
            =================================================*/
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
            
            /*================================================
                アップロード処理
            =================================================*/
            function uploadFiles(files) {
            // FormDataオブジェクトを用意
            var fd = new FormData();
            
            // ファイルの個数を取得
            var filesLength = files.length;
            
            // ファイル情報を追加
            for (var i = 0; i < filesLength; i++) {
                alert("FILE NAME: "+files[i]["name"]);
                // ファイル名をcookieに保存
                dt = Cookies.get("fileName")+","+files[i]["name"];
                Cookies.set("fileName", dt);
                fd.append("files[]", files[i]);
            }
            
            // Ajaxでアップロード処理をするファイルへ内容渡す
            $.ajax({
                url: 'filesave.php',
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
            <p>アップロードするファイルをドロップ</p>
            <p>または</p>
            <div class="btn-group">
                <input type="file" multiple="multiple" style="display:none;" name="files"/>
                <button id="btn">ファイルを選択</button>
            </div>
        </div>
        <div class="analysis">
            <a href="javascript:analysis()"></a>
            <p>解析</p>
        </div>
        <div class="footer"></div>
    </body>
</html>