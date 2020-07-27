<?php

// ここにソースコードを書く
$SOURCE = '
#include<stdio.h>

int main() {

    double a, b, c, d, e, mean, var, max, min;
    int x, y;

    printf("任意の数値を入力して、Enterを押してください。1/5つ目\n"); //あいうえお
    scanf("%lf", &a);

    printf("任意の数値を入力して、Enterを押してください。2/5つ目\n");
    scanf("%lf", &b);

    printf("任意の数値を入力して、Enterを押してください。3/5つ目\n");
    scanf("%lf", &c);

    printf("任意の数値を入力して、Enterを押してください。4/5つ目\n");
    scanf("%lf", &d);

    printf("任意の数値を入力して、Enterを押してください。5/5つ目\n");
    scanf("%lf", &e);

    mean = (a + b + c + d + e)/5;
    var = ((a - mean) * (a - mean) + (b - mean) * (b - mean) + (c - mean) * (c - mean) + (d - mean) * (d - mean) + (e - mean) * (e - mean))/5;

    max = a;
    min = a;
    
    if (b > max){
        max = b;
    }
    if (c > max){
        max = c;
    }
    if (d > max){
        max = d;
    }
    if (e > max){
        max = e;
    }
     if (b < min){
        min = b;
    }
    if (c < min){
        min = c;
    }
    if (d < min){
        min = d;
    }
    if (e < min){
        min = e;
    }

    printf("平均：%f\n分散：%f\n最大値：%f\n最小値：%f", mean, var, max, min);
    return 0;
}
';

// 改行コードを削除
str_replace("\n", "", $SOURCE);
// 無駄な空白削除
str_replace(" {", "{", $SOURCE);
// コメントアウト削除
$SOURCE = preg_replace("/\/\/(.*)\n/", "", $SOURCE);


// int関数宣言削除　抽出して保持する
$SOURCE = preg_replace("/int (.*){/", "", $SOURCE);

echo $SOURCE;

// double宣言抽出
$doubleSplit = preg_split("/double /", $SOURCE);
$double = preg_split("/[;]/", $doubleSplit[1]);
$doubleVariable = $double[0];
// int宣言抽出
$intSplit = preg_split("/int /", $SOURCE);
$int = preg_split("/[;]/", $intSplit[1]);
$intVariable = $int[0];

#echo "int = ".$intVariable."<br>";
#echo "double = ".$doubleVariable;
?>