a = {}
a["A"] = {}
a["A"]["B"] = "C"

def f(v):
    print(v)

f(a["A"]["B"])