<!doctype html>
<html>
    <head>
        <title>C/C++関数仕様書生成ツール</title>
        <link rel="stylesheet" type="text/css" href="assets/index.php.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="https://fonts.googleapis.com/earlyaccess/mplus1p.css" rel="stylesheet" />
        <script>
            function analysis(){
                var sourceCode = document.forms.box.textarea.value;
                console.log(sourceCode);
            }
        </script>        
    </head>
    <body>
        <div class="header"></div>
        <div class="title"><p>C/C++ 関数仕様書生成ツール</p></div>
        <form class="box" name="box"><!-- cols->width, rows->height -->
            <textarea name="textarea" value="1" cols="86" rows="50" placeholder="ここにソースコードを張り付けて下さい。"></textarea>
        </form>
        <div class="analysis">
            <a href="javascript:analysis()"></a>
            <p>解析</p>
        </div>
        <div class="footer"></div>
    </body>
</html>