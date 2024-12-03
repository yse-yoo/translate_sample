<?php
// データベース接続情報
$host = 'localhost';
$dbname = 'translate';
$user = 'root';
$password = '';

try {
    // PDOを使用してデータベースに接続
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("データベース接続に失敗しました: " . $e->getMessage());
}