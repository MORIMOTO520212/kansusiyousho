import re
VF   = "wordXmlTemplete/kansusiyoushoVF.xml"
V    = "wordXmlTemplete/kansusiyoushoV.xml"
F    = "wordXmlTemplete/kansusiyoushoF.xml"
addF = "wordXmlTemplete/addFunction.xml"
addV = "wordXmlTemplete/addVariable.xml"
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
# 1 - 戻り値
# 2 - 引数名
# 3 - 引数の型

# テンプレート
# VFtemp.format(addV_temp, addF_temp, "関数名", "戻り値の型", "引数情報", docId, fmid)
# Vtemp.format(addV_temp, "関数名", "戻り値の型", "引数情報", docId, fmid)
# Ftemp.format(addF_temp, "関数名", "戻り値の型", "引数情報", docId, fmid)

with open(VF, 'r', encoding='utf-8') as f:
    VFtemp = f.read()
with open(V, 'r', encoding='utf-8') as f:
    Vtemp = f.read()
with open(F, 'r', encoding='utf-8') as f:
    Ftemp = f.read()
with open(addV, 'r', encoding='utf-8') as f:
    addV_temp = f.read()
with open(addF, 'r', encoding='utf-8') as f:
    addF_temp = f.read()

docId = "{6DA8B8D9-FBDD-4927-A623-E8288315FC7F}"
fmid  = "{D5CDD505-2E9C-101B-9397-08002B2CF9AE}"

VFtemp    = re.sub('<!--.*?-->', "", VFtemp, flags=(re.MULTILINE | re.DOTALL))
Vtemp     = re.sub('<!--.*?-->', "", Vtemp, flags=(re.MULTILINE | re.DOTALL))
Ftemp     = re.sub('<!--.*?-->', "", Ftemp, flags=(re.MULTILINE | re.DOTALL))
addV_temp = re.sub('<!--.*?-->', "", addV_temp, flags=(re.MULTILINE | re.DOTALL))
addF_temp = re.sub('<!--.*?-->', "", addF_temp, flags=(re.MULTILINE | re.DOTALL))
variable = addV_temp + addV_temp + addV_temp
function = addF_temp + addF_temp + addF_temp
word = VFtemp.format(variable, function, "function1", "int", "no", docId, fmid)
#word = Ftemp.format(addF_temp, "main", "int", "なし", docId, fmid)

with open("test.xml", "w", encoding='utf-8') as f:
    f.write(word)