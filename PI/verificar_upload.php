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

if (!empty($usuario['foto_perfil'])) {
    $foto_path = $usuario['foto_perfil'];
    echo "\nCaminho da foto: " . $foto_path;
    echo "\nArquivo existe? " . (file_exists($foto_path) ? 'Sim' : 'Não');
    if (file_exists($foto_path)) {
        echo "\nTamanho do arquivo: " . filesize($foto_path) . " bytes";
        echo "\nPermissões do arquivo: " . substr(sprintf('%o', fileperms($foto_path)), -4);
        echo "\nÚltima modificação: " . date("Y-m-d H:i:s", filemtime($foto_path));
    }
}

// Verificar diretório de uploads
$diretorio = 'uploads/perfil/';
echo "\n\nVerificando diretório de uploads:";
echo "\nDiretório existe? " . (file_exists($diretorio) ? 'Sim' : 'Não');
if (file_exists($diretorio)) {
    echo "\nPermissões do diretório: " . substr(sprintf('%o', fileperms($diretorio)), -4);
    echo "\nDiretório é gravável? " . (is_writable($diretorio) ? 'Sim' : 'Não');
    echo "\nConteúdo do diretório:";
    print_r(scandir($diretorio));
}

// Verificar configurações do PHP
echo "\n\nConfigurações do PHP:";
echo "\nupload_max_filesize: " . ini_get('upload_max_filesize');
echo "\npost_max_size: " . ini_get('post_max_size');
echo "\nmax_file_uploads: " . ini_get('max_file_uploads');
echo "\ntemp_dir: " . ini_get('upload_tmp_dir');
echo "</pre>";
?> 