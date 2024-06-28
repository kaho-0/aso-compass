<?php
const SERVER = 'mysql304.phy.lolipop.lan';
const DBNAME = 'LAA1517471-asocompas';
const USER = 'LAA1517471';
const PASS = 'asocompas';

$dsn = 'mysql:host=' . SERVER . ';dbname=' . DBNAME . ';charset=utf8';

try {
    $pdo = new PDO($dsn, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'データベース接続失敗: ' . $e->getMessage();
    exit;
}
?>
