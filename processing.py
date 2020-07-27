import re, pprint
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
source = \
'''
#include<stdio.h>
double maxfunction(int za, int zb){
    int i;
    return result;
}
double minfunction(double xa, double xb){
    int sum;
    for(int i = 0; i < 10; i++){
        sum += i;
    }
    return sum;
}
int main(){
    double result, result2;
    result  = minfunction(5, 10);
    result2 = maxfunction(5, 10);
    printf("%d%d",result ,result2);
    return 0;
}
'''

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
            multiplyCombineCheckandSet(dictpath, "int", functionv)

        elif "double" in functionv:
            multiplyCombineCheckandSet(dictpath, "double", functionv)

        elif "float" in functionv:
            multiplyCombineCheckandSet(dictpath, "float", functionv)

        elif "char" in functionv:
            multiplyCombineCheckandSet(dictpath, "char", functionv)

        elif "short" in functionv:
            multiplyCombineCheckandSet(dictpath, "short", functionv)

        elif "long" in functionv:
            multiplyCombineCheckandSet(dictpath, "long", functionv)

def addVariable(type, var):
    # 変数名抽出してstatusに格納する
    var = var.replace(type+" ", "")
    var = var.replace(";", "")
    var = var.split(",")
    for variable in var:
        variable = variable.split("=") # イコール削除
        variable = variable[0].replace(" ", "") # 余白削除
        try:
            status["variable"][type].append(variable)
        except:
            status["variable"][type] = [variable]

def multiplyCheckandSet(type, functionName):
    # 関数名と型がstatusに格納されているか判断し、なかった場合は作成
    try:
        status["function"][type][functionName] = {}
        intFuncdict = status["function"][type][functionName]
    except:
        status["function"][type] = {}
        status["function"][type][functionName] = {}
        intFuncdict = status["function"][type][functionName]
    return intFuncdict

def addFunction(type, function):
    # 関数かどうかを判断して関数でなければFalseを返す
    if type == "int":
        function = function[4:] # 型名削除
        function = re.split("[\(\)]", function) # ex: ['function','int a, int b']
        funv = function[1].split(",") # ex: ['int a', 'int b']
        if " " not in function[0]:    # 関数名に余白がない場合
            intFuncdict = multiplyCheckandSet("int", function[0])
            multiplyCombine(funv, intFuncdict)
            return function[0]
        return False


    if type == "double":
        function = function[7:]
        function = re.split("[\(\)]", function)
        funv = function[1].split(",")
        if " " not in function[0]:
            intFuncdict = multiplyCheckandSet("double", function[0])
            multiplyCombine(funv, intFuncdict)
            return function[0]
        return False

    if type == "float":
        function = function[6:]
        function = re.split("[\(\)]", function)
        funv = function[1].split(",")
        if " " not in function[0]:
            intFuncdict = multiplyCheckandSet("float", function[0])
            multiplyCombine(funv, intFuncdict)
            return function[0]
        return False

    if type == "char":
        function = function[5:]
        function = re.split("[\(\)]", function)
        funv = function[1].split(",")
        if " " not in function[0]:
            intFuncdict = multiplyCheckandSet("char", function[0])
            multiplyCombine(funv, intFuncdict)
            return function[0]
        return False

    if type == "short":
        function = function[6:] # 型名削除
        function = re.split("[\(\)]", function) # ex: ['function','int a, int b']
        funv = function[1].split(",") # ex: ['int a', 'int b']
        if " " not in function[0]:
            intFuncdict = multiplyCheckandSet("short", function[0])
            multiplyCombine(funv, intFuncdict)
            return function[0]
        return False

    if type == "long":
        function = function[5:] # 型名削除
        function = re.split("[\(\)]", function) # ex: ['function','int a, int b']
        funv = function[1].split(",") # ex: ['int a', 'int b']
        if " " not in function[0]:
            intFuncdict = multiplyCheckandSet("long", function[0])
            multiplyCombine(funv, intFuncdict)
            return function[0]
        return False

# 変数の型と変数名を検出する
for string in code:
    # 非貪欲マッチ
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

# 関数を検出し、関数宣言子と引数の型と引数名を調べる
for string in code:
    # 非貪欲マッチ
    int_match    = re.findall('int .*\(.*\)', string) # ex: int function(int a, int b)
    double_match = re.findall('double .*\(.*\)', string)
    float_match  = re.findall('float .*\(.*\)', string)
    char_match   = re.findall('char .*\(.*\)', string)
    short_match  = re.findall('short .*\(.*\)', string)
    long_match   = re.findall('long .*\(.*\)', string)

    if [] != int_match:
        functionName = addFunction("int", int_match[0])
        if functionName: # 関数だった場合
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
'''
if status["main"]:
    print("関数名: main\n")
print("< - 変数 - >")
for variableType in status["variable"].keys():
    print("型",variableType,":", end="")
    for variableName in status["variable"][variableType]:
        print(variableName," ", end="")
    print("")
print("\n< - 関数 - >")
for functionType in status["function"].keys():
    print("関数宣言子",functionType,":")
    for functionName in status["function"][functionType].keys():
        print("| 関数名",functionName,":")
        for variableType in status["function"][functionType][functionName].keys():
            if "return" != variableType:
                print("| | 型",variableType,":", end="")
                for variableName in status["function"][functionType][functionName][variableType]:
                    print(variableName," ", end="")
                print("")
            else:
                print("| | 戻り値あり")
'''