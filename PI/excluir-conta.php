<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';

try {
    error_log("Iniciando processo de exclusão de conta para usuário ID: " . $_SESSION['usuario_id']);
    
    // Iniciar transação
    $conn->beginTransaction();
    error_log("Transação iniciada");

    // Excluir resultados de quiz do usuário
    $stmt = $conn->prepare("DELETE FROM resultados_quiz WHERE usuario_id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    error_log("Resultados de quiz excluídos");

    // Excluir progresso do usuário
    $stmt = $conn->prepare("DELETE FROM progresso_usuario WHERE usuario_id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    error_log("Progresso do usuário excluído");

    // Excluir foto de perfil se existir
    $stmt = $conn->prepare("SELECT foto_perfil FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $foto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($foto && $foto['foto_perfil'] && $foto['foto_perfil'] !== 'assets/images/default-avatar.png') {
        if (file_exists($foto['foto_perfil'])) {
            unlink($foto['foto_perfil']);
            error_log("Foto de perfil excluída");
        }
    }

    // Excluir usuário
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    error_log("Usuário excluído do banco de dados");

    // Confirmar transação
    $conn->commit();
    error_log("Transação confirmada");

    // Encerrar sessão
    session_destroy();
    error_log("Sessão encerrada");

    // Redirecionar para página inicial com mensagem de sucesso
    header("Location: index.php?sucesso=conta_excluida");
    exit();
} catch(PDOException $e) {
    error_log("Erro ao excluir conta: " . $e->getMessage());
    // Reverter transação em caso de erro
    $conn->rollBack();
    header("Location: perfil.php?erro=exclusao&mensagem=" . urlencode($e->getMessage()));
    exit();
}
?> 