<?php
// テスト用


$VFtemp = file_get_contents("wordXmlTemplete/kansusiyoushoVF.xml");

$pattern   = "/<!--.*-->/";
$VFtemp = preg_replace($pattern, "", $VFtemp);

$VFtemp = str_replace("1%s", "-----1", $VFtemp);
$VFtemp = str_replace("2%s", "-----2", $VFtemp);
$VFtemp = str_replace("3%s", "-----3", $VFtemp);
$VFtemp = str_replace("4%s", "-----4", $VFtemp);
$VFtemp = str_replace("5%s", "-----5", $VFtemp);
$VFtemp = str_replace("6%s", "-----6", $VFtemp);
$VFtemp = str_replace("7%s", "-----7", $VFtemp);

echo $VFtemp;
