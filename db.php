<?php
$host = 'sql100.infinityfree.com';
$dbname = 'if0_&0¨&913%_jogo_adivinhacao';
$user = 'if0_*0%$913@';     // altere se necessário
$pass = '13270514';         // senha do seu MySQL (se houver)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

