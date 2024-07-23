<?php
//EndBloco ChatGPT
$config = require 'config.php';

function getPDOConnection($config, $dbType = 'mysql') {
    switch ($dbType) {
        case 'mysql':
            $dsn = "{$config['mysql']['driver']}:host={$config['mysql']['host']};dbname={$config['mysql']['database']};";
            $username = $config['mysql']['username'];
            $password = $config['mysql']['password'];
            break;

        case 'sqlite':
            $dsn = "{$config['sqlite']['driver']}:{$config['sqlite']['database']}";
            $username = null;
            $password = null;
            break;

        case 'firebird':
            $dsn = "{$config['firebird']['driver']}:dbname={$config['firebird']['host']}:{$config['firebird']['database']};";
            $username = $config['firebird']['username'];
            $password = $config['firebird']['password'];
            break;

        default:
            throw new InvalidArgumentException("Tipo de banco de dados desconhecido: $dbType");
    }

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }
}//EndBloco ChatGPT