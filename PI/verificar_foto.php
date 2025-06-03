<?php
require_once 'config/database.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    die("Usuário não logado");
}

// Buscar informações do usuário
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$usuario = $stmt->fetch();

echo "<pre>";
echo "Dados do usuário:\n";
print_r($usuario);

if (!empty($usuario['foto'])) {
    $foto_path = 'uploads/fotos/' . $usuario['foto'];
    echo "\nCaminho da foto: " . $foto_path;
    echo "\nArquivo existe? " . (file_exists($foto_path) ? 'Sim' : 'Não');
    if (file_exists($foto_path)) {
        echo "\nTamanho do arquivo: " . filesize($foto_path) . " bytes";
        echo "\nPermissões do arquivo: " . substr(sprintf('%o', fileperms($foto_path)), -4);
    }
}
echo "</pre>";
?> 