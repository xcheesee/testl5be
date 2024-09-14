<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$db   = $_ENV['DB_DATABASE'];
$user = $_ENV['DB_USERNAME'];
$pass = $_ENV['DB_PASSWORD'];
$root = $_ENV['DB_ROOT'];
$rootpw = $_ENV['DB_ROOTPW']; 

try {
    $dbConn = new \PDO(
        "mysql:host=$host;port=$port;charset=utf8mb4",
        $root,
        $rootpw
    );

    $dbConn->exec("
        CREATE DATABASE IF NOT EXISTS `$db`;
        CREATE USER IF NOT EXISTS '$user'@'$host' IDENTIFIED BY '$pass';
        GRANT ALL ON `$db`.* TO '$user'@'$host';
    ");

    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}

$statement = <<<EOS
    USE `$db`;
    CREATE TABLE IF NOT EXISTS logs (
        id INT NOT NULL AUTO_INCREMENT,
        request_type VARCHAR(100) NOT NULL,
        request_url VARCHAR(100) NOT NULL,
        requested_at DATETIME NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;

    CREATE TABLE IF NOT EXISTS comments (
        id INT NOT NULL AUTO_INCREMENT,
        comment VARCHAR(100) NOT NULL,
        film_id INT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;
EOS;

try {
    $createTable = $dbConn->exec($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}
