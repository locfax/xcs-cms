<?php

$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_pass = '12345678';
$mysql_db = 'pj_web';
$mysql_port = '3306';

$dsn = array(
    'general' => array( //用于保存系统配置 缓存等数据
        'driver' => 'pdo',
        'dsn' => "mysql:host={$mysql_host};port={$mysql_port};dbname={$mysql_db}",
        'host' => $mysql_host,
        'port' => $mysql_port,
        'dbname' => $mysql_db,
        'login' => $mysql_user,
        'secret' => $mysql_pass,
        'rundev' => true
    ),
    'portal' => array( //用于保存系统配置 缓存等数据
        'driver' => 'pdo',
        'dsn' => "mysql:host={$mysql_host};port={$mysql_port};dbname={$mysql_db}",
        'host' => $mysql_host,
        'port' => $mysql_port,
        'dbname' => $mysql_db,
        'login' => $mysql_user,
        'secret' => $mysql_pass,
        'rundev' => true
    )
);

\Xcs\App::mergeVars('dsn', $dsn);
$dsn = null;
