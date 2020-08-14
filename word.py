import re
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

VF   = "wordXmlTemplete/kansusiyoushoVF.xml"
V    = "wordXmlTemplete/kansusiyoushoV.xml"
F    = "wordXmlTemplete/kansusiyoushoF.xml"
addF = "wordXmlTemplete/addFunction.xml"
addV = "wordXmlTemplete/addVariable.xml"

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

VFtemp    = re.sub('<!--.*?-->', "", VFtemp, flags=(re.MULTILINE | re.DOTALL))
Vtemp     = re.sub('<!--.*?-->', "", Vtemp, flags=(re.MULTILINE | re.DOTALL))
Ftemp     = re.sub('<!--.*?-->', "", Ftemp, flags=(re.MULTILINE | re.DOTALL))
addV_temp = re.sub('<!--.*?-->', "", addV_temp, flags=(re.MULTILINE | re.DOTALL))
addF_temp = re.sub('<!--.*?-->', "", addF_temp, flags=(re.MULTILINE | re.DOTALL))

docId = "{6DA8B8D9-FBDD-4927-A623-E8288315FC7F}"
fmid  = "{D5CDD505-2E9C-101B-9397-08002B2CF9AE}"

def transform(status, fileName):
    val  = False
    func = False
    variable_temp = ""
    function_temp = ""
    returnType    = ""
    
    # 変数がある場合
    if(len(status["variable"])):
        val  = True
    # 関数がある場合
    if(len(status["function"])):
        func = True

    # main関数だけだった場合は関数なしにする
    if(len(status["function"]) == 1):
        if(status["function"]["int"]["main"]):
            func = False

    # テンプレートを使ってwordを作る
    if(val and func):

        # 変数の表を作る
        for variableType in status["variable"].keys(): # 変数の型
            for variableName in status["variable"][variableType]: # 変数名
                variable_temp += addV_temp.format(variableName, variableType)

        # 関数の表を作る
        for functionType in status["function"].keys(): # 戻り値の型
            returnType = functionType

            for functionName in status["function"][functionType].keys(): # 関数名
                argument_type = ""
                argument_name = ""

                for argumentType in status["function"][functionType][functionName].keys(): # 引数の型
                    
                    if argumentType != "return": # 型の場所に入っているreturnは除外
                        argument_type += argumentType + ", "

                        for argumentName in status["function"][functionType][functionName][argumentType]: # 引数名
                            argument_name += argumentName + ", "
                            argumentInfo = argument_name

                if functionName != "main": # 関数リストからmain関数は除外
                    if not argument_name:
                        argument_name = "なし"
                    if not argument_type:
                        argument_type = "なし"
                    if functionType == "void":
                        functionType = "なし"

                    function_temp += addF_temp.format(functionName, functionType, argument_name, argument_type)

        if status["main"]:
            returnType   = "なし"
            argumentInfo = "なし"
        word = VFtemp.format(variable_temp, function_temp, fileName, returnType, argumentInfo, docId, fmid) # 組み立て


    elif(func):
        # 関数の表を作る
        for functionType in status["function"].keys(): # 戻り値の型
            returnType = functionType

            for functionName in status["function"][functionType].keys(): # 関数名
                argument_type = ""
                argument_name = ""

                for argumentType in status["function"][functionType][functionName].keys(): # 引数の型
                    
                    if argumentType != "return": # 型の場所に入っているreturnは除外
                        argument_type += argumentType + ", "

                        for argumentName in status["function"][functionType][functionName][argumentType]: # 引数名
                            argument_name += argumentName + ", "
                            argumentInfo = argument_name

                if functionName != "main": # main関数は除外
                    if not argument_name:
                        argument_name = "なし"
                    if not argument_type:
                        argument_type = "なし"
                    if functionType == "void":
                        functionType = "なし"

                    function_temp += addF_temp.format(functionName, functionType, argumentInfo, argument_type)

        if status["main"]:
            returnType   = "なし"
            argumentInfo = "なし"
            
        word = Ftemp.format(function_temp, fileName, returnType, argument_name, docId, fmid) # 組み立て
    
    else:
        word = False

    return word