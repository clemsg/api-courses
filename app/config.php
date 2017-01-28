<?php
$app['db.options'] = array(
	'driver'   => 'pdo_mysql',
	'charset'  => 'utf8',
	'host'     => 'localhost',  // Mandatory for PHPUnit testing
	'port'     => '3306',
	'dbname'   => 'courses',
	'user'     => 'root',
	'password' => 'clemsg28',
);

// enable the debug mode
$app['debug'] = true;