import re, sys, pprint, word
#-------------- 出力例 ----------------------#
#関数名: main
#
#< - 変数 - >
#型 int :e  f  g  a  b  c  d  average  i  
#型 double :a  b  c  result  
#
#< - 関数 - >
#関数宣言子 int :
#| 関数名 function1 :
#  | 型 int :a  c  
#  | 型 double :b  
#| 関数名 main :
#関数宣言子 double :
#| 関数名 function2 :
#  | 型 int :a  b  
#  | 型 double :c 
#-----------------------------------------#
args = sys.argv
dirpath  = "process"
fileName = "main.cpp"
#dirpath  = args[1]
#fileName = args[2]

dir = dirpath + "/" + fileName

# 拡張子を除外する
fileName = fileName.replace(".cpp", "")
fileName = fileName.replace(".c", "")

with open(dir, 'r') as f: # encoding='utf-8'
    source = f.read()
# 改行コード削除
source = source.replace("\n", "")
# 無駄な空白削除
source = source.replace(" {", "{")
source = source.replace("{ ", "{")
source = source.replace(" ;", ";")
# コメントアウト削除
source = source.replace("//*\n", "")
# 配列化
code = re.split("[{}]", source)
# ブロック検出
blockDetector = "0"
functionName  = ""
# 関数名や変数名をここに格納する
status = {}
# 変数
status["variable"] = {}
# 関数
status["function"] = {}
# メインファイルか判断する
status["main"] = False
# externの有無
externString = False

def multiplyCombineCheckandSet(dictpath, type, variableName):
    # statusに引数の変数名と型が存在しなかった場合は作成する
    variableName = variableName.replace(type+" ", "").replace(" ", "")
    try:
        dictpath[type].append(variableName)
    except:
        dictpath[type] = [variableName]

def multiplyCombine(data, dictpath):
    # 関数の引数をstatusに格納する
    for functionv in data:
        if "int" in functionv:
            multiplyCombineCheckandSet(dictpath, "int",    functionv)

        elif "double" in functionv:
            multiplyCombineCheckandSet(dictpath, "double", functionv)

        elif "float" in functionv:
            multiplyCombineCheckandSet(dictpath, "float",  functionv)

        elif "char" in functionv:
            multiplyCombineCheckandSet(dictpath, "char",   functionv)

        elif "short" in functionv:
            multiplyCombineCheckandSet(dictpath, "short",  functionv)

        elif "long" in functionv:
            multiplyCombineCheckandSet(dictpath, "long",   functionv)

def addVariable(type, var):
    # 変数名抽出してstatusに格納する
    var = var.replace(type+" ", "")
    var = var.replace(";", "")
    var = var.split(",")
    for variable in var:
        variable = variable.split("=")          # イコール削除
        variable = variable[0].replace(" ", "") # 余白削除
        try:
            status["variable"][type].append(variable)
        except:
            status["variable"][type] = [variable]

def multiplyCheckandSet(type, functionName):
    # 関数名と型がstatusに格納されているか判断し、なかった場合は作成
    try:
        status["function"][type][functionName] = {}
        Funcdict = status["function"][type][functionName]
    except:
        status["function"][type] = {}
        status["function"][type][functionName] = {}
        Funcdict = status["function"][type][functionName]
    return Funcdict

def addFunction(type, function):
    # 関数かどうかを判断して関数でなければFalseを返す

    if type == "void":
        function = function[5:]
        function = re.split("[\(\)]", function)
        funv = function[1].split(",")
        if " " not in function[0]:
            Funcdict = multiplyCheckandSet(type, function[0])
            multiplyCombine(funv, Funcdict)
            return function[0]

    if type == "int":
        function = function[4:]                 # 型名削除
        function = re.split("[\(\)]", function) # ex: ['function','int a, int b']
        funv = function[1].split(",")           # ex: ['int a', 'int b']
        if " " not in function[0]:              # 関数名に余白がない場合
            Funcdict = multiplyCheckandSet(type, function[0])
            multiplyCombine(funv, Funcdict)
            return function[0]
        return False

    if type == "double":
        function = function[7:]
        function = re.split("[\(\)]", function)
        funv = function[1].split(",")
        if " " not in function[0]:
            Funcdict = multiplyCheckandSet(type, function[0])
            multiplyCombine(funv, Funcdict)
            return function[0]
        return False

    if type == "float":
        function = function[6:]
        function = re.split("[\(\)]", function)
        funv = function[1].split(",")
        if " " not in function[0]:
            Funcdict = multiplyCheckandSet(type, function[0])
            multiplyCombine(funv, Funcdict)
            return function[0]
        return False

    if type == "char":
        function = function[5:]
        function = re.split("[\(\)]", function)
        funv = function[1].split(",")
        if " " not in function[0]:
            Funcdict = multiplyCheckandSet(type, function[0])
            multiplyCombine(funv, Funcdict)
            return function[0]
        return False

    if type == "short":
        function = function[6:]
        function = re.split("[\(\)]", function)
        funv = function[1].split(",")
        if " " not in function[0]:
            Funcdict = multiplyCheckandSet(type, function[0])
            multiplyCombine(funv, Funcdict)
            return function[0]
        return False

    if type == "long":
        function = function[5:]
        function = re.split("[\(\)]", function)
        funv = function[1].split(",")
        if " " not in function[0]:
            Funcdict = multiplyCheckandSet(type, function[0])
            multiplyCombine(funv, Funcdict)
            return function[0]
        return False


# 変数の型と変数名を検出する
for string in code:
    # 非貪欲マッチ
    if "extern" not in string: # externで宣言された関数が含まれていない場合　※引数を検出させないために
        int_match    = re.findall('int .*?;', string)
        double_match = re.findall('double .*?;', string)
        float_match  = re.findall('float .*?;', string)
        char_match   = re.findall('char .*?;', string)
        short_match  = re.findall('short .*?;', string)
        long_match   = re.findall('long .*?;', string)

        if [] != int_match:
            for var in int_match:
                addVariable("int", var)
        
        if [] != double_match:
            for var in double_match:
                addVariable("double", var)
        
        if [] != float_match:
            for var in float_match:
                addVariable("float", var)
        
        if [] != char_match:
            for var in char_match:
                addVariable("char", var)

        if [] != short_match:
            for var in short_match:
                addVariable("short", var)

        if [] != long_match:
            for var in long_match:
                addVariable("long", var)
    else: # externが含まれている場合
        externString = string

if externString:
    # ついでにexternで宣言された関数を見つけ、code配列に関数を追加
    for externfunc in externString.split(";"):
        externfunc = externfunc.replace("extern", "")
        code.append(externfunc)
        

# 関数を検出し、関数宣言子と引数の型と引数名を調べる
for string in code:
    # 非貪欲マッチ
    if "extern" not in string: # externで宣言された関数が含まれていない場合
        void_match   = re.findall('void .*\(.*\)',   string)
        int_match    = re.findall('int .*\(.*\)',    string) # ex: int function(int a, int b)
        double_match = re.findall('double .*\(.*\)', string)
        float_match  = re.findall('float .*\(.*\)',  string)
        char_match   = re.findall('char .*\(.*\)',   string)
        short_match  = re.findall('short .*\(.*\)',  string)
        long_match   = re.findall('long .*\(.*\)',   string)

        if [] != void_match:
            functionName = addFunction("void", void_match[0])
            if functionName: # 関数だった場合
                type = "void"

        if [] != int_match:
            functionName = addFunction("int", int_match[0])
            if functionName:
                type = "int"
                if "main" in int_match[0]:
                    status["main"] = True # メインファイルだった場合

        if [] != double_match:
            functionName = addFunction("double", double_match[0])
            if functionName:
                type = "double"

        if [] != float_match:
            functionName = addFunction("float", float_match[0])
            if functionName:
                type = "float"
        
        if [] != char_match:
            functionName = addFunction("char", char_match[0])
            if functionName:
                type = "char"
        
        if [] != short_match:
            functionName = addFunction("short", short_match[0])
            if functionName:
                type = "short"

        if [] != long_match:
            functionName = addFunction("long", long_match[0])
            if functionName:
                type = "long"

        # 関数の中の戻り値を検出する
        if not functionName:
            functionName = blockDetector
        if functionName:
            if functionName == blockDetector:
                if "return" in string:
                    if "return 0" not in string:
                        status["function"][type][functionName]["return"] = type
            else:
                blockDetector = functionName

#pprint.pprint(status, indent=4, width=80)

print(status)