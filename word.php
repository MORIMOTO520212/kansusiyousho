<?php
# ~ VF ~ < 変数の表と関数の表 >
# 0 - 変数のデータの記述 addV
# 1 - 関数のデータの記述 addF
# 2 - 1.関数名
# 3 - 2.戻り値の型
# 4 - 3.引数情報
# -------------------------
# ~ V ~ < 変数の表のみ >
# 0 - 変数のデータの記述
# 1 - 1.関数名
# 2 - 2.戻り値の型
# 3 - 3.引数情報
# -------------------------
# ~ F ~ < 関数の表のみ >
# 0 - 関数のデータの記述
# 1 - 1.関数名
# 2 - 2.戻り値の型
# 3 - 3.引数情報
# -------------------------
# ~ addV ~ < 変数の表を追加 > 増やす場合は繋げる
# 0 - 変数名
# 1 - 変数の型
# -------------------------
# ~ addF ~ < 関数の表を追加 > 増やす場合は繋げる
# 0 - 関数名
# 1 - 戻り値の型
# 2 - 引数名
# 3 - 引数の型

# テンプレート
# VFtemp.format(addV_temp, addF_temp, "関数名", "戻り値の型", "引数情報", docId, fmid)
# Vtemp.format(addV_temp, "関数名", "戻り値の型", "引数情報", docId, fmid)
# Ftemp.format(addF_temp, "関数名", "戻り値の型", "引数情報", docId, fmid)

$VFtemp    = file_get_contents("wordXmlTemplete/kansusiyoushoVF.xml");
$Vtemp     = file_get_contents("wordXmlTemplete/kansusiyoushoV.xml" );
$Ftemp     = file_get_contents("wordXmlTemplete/kansusiyoushoF.xml" );
$addV_temp = file_get_contents("wordXmlTemplete/addVariable.xml"    );
$addF_temp = file_get_contents("wordXmlTemplete/addFunction.xml"    );

$pattern   = "/<!--.*-->/"
$VFtemp    = preg_replace($pattern, "", $VFtemp);
$Vtemp     = preg_replace($pattern, "", $Vtemp);
$Ftemp     = preg_replace($pattern, "", $Ftemp);
$addV_temp = preg_replace($pattern, "", $addV_temp);
$addF_temp = preg_replace($pattern, "", $addF_temp);

docId = "{6DA8B8D9-FBDD-4927-A623-E8288315FC7F}"
fmid  = "{D5CDD505-2E9C-101B-9397-08002B2CF9AE}"

function transform(){}

?>