<?php

$kiwi = 'vert';
$fruit = &$kiwi;
$fruit = array();
$fruit['kiwi'] = $kiwi;


$a = 'ki' || 'wi';
$b = 'ki' or 'wi';



print_r($fruit['kiwi']);
var_dump($a, $b);
die;

phpinfo();