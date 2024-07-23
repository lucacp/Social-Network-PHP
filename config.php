<?php

$autoloadDir = './vendor/autoload.php';
require $autoloadDir;

$dotEnv = Dotenv\Dotenv::createImmutable($autoloadDir);
//Bloco ChatGPT alterado
$dbHost = $_ENV['DBHOST'];
$dbName = $_ENV['DBNAME'];
$dbUser = $_ENV['DBUSER'];
$dbPass = $_ENV['DBPASS'];
$appName= $_ENV['APPNAME'];
$dbType = $_ENV['DBTYPE'];

return [
    'mysql' => [
        'driver'   => 'mysql',
        'host'     => $dbHost,
        'database' => $dbName,
        'username' => $dbUser,
        'password' => $dbPass,
    ],
    'sqlite' => [
        'driver'   => 'sqlite',
        'database' => __DIR__ . '/.'.$dbName.'.sqlite',
    ],
    'firebird' => [
        'driver'   => 'firebird',
        'host'     => $dbHost,
        'database' => __DIR__ . '/.'.$dbName.'.fdb',
        'username' => $dbUser,
        'password' => $dbPass,
    ],
];
//EndBloco ChatGPT alterado