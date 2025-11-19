<?php
$host = 'localhost';
$dbname = 'jogo_adivinhacao';
$user = 'root';     // altere se necessário
$pass = '';         // senha do seu MySQL (se houver)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
