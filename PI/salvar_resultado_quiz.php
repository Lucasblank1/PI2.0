<?php
session_start();
require_once 'config/database.php';

// Adiciona log para debug
error_log("Iniciando salvamento do resultado do quiz");

if (!isset($_SESSION['usuario_id'])) {
    error_log("Erro: Usuário não autenticado");
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit();
}

// Recebe os dados do POST
$raw_data = file_get_contents('php://input');
error_log("Dados brutos recebidos: " . $raw_data);

$data = json_decode($raw_data, true);
error_log("Dados decodificados: " . print_r($data, true));

if (!$data) {
    error_log("Erro: Dados inválidos ou JSON mal formatado");
    echo json_encode(['success' => false, 'message' => 'Dados inválidos ou JSON mal formatado']);
    exit();
}

try {
    // Calcula a pontuação baseada no nível e acertos
    $pontuacao = 0;
    switch ($data['nivel']) {
        case 'facil':
            $pontuacao = $data['acertos'] * 10;
            break;
        case 'medio':
            $pontuacao = $data['acertos'] * 20;
            break;
        case 'dificil':
            $pontuacao = $data['acertos'] * 30;
            break;
    }

    error_log("Pontuação calculada: " . $pontuacao);
    error_log("Dados para inserção: " . print_r([
        'usuario_id' => $_SESSION['usuario_id'],
        'nivel' => $data['nivel'],
        'pontuacao' => $pontuacao,
        'tempo_gasto' => $data['tempo_gasto'],
        'acertos' => $data['acertos'],
        'erros' => $data['erros']
    ], true));

    // Inicia a transação
    $conn->beginTransaction();

    // Salva o resultado do quiz
    $stmt = $conn->prepare("INSERT INTO resultados_quiz (usuario_id, nivel, pontuacao, tempo_gasto, acertos, erros) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    
    $result = $stmt->execute([
        $_SESSION['usuario_id'],
        $data['nivel'],
        $pontuacao,
        $data['tempo_gasto'],
        $data['acertos'],
        $data['erros']
    ]);

    if (!$result) {
        error_log("Erro ao executar INSERT em resultados_quiz: " . print_r($stmt->errorInfo(), true));
        throw new PDOException("Erro ao salvar resultado do quiz");
    }

    // Atualiza o progresso do usuário
    $stmt = $conn->prepare("INSERT INTO progresso_usuario (usuario_id, tipo_jogo, nivel, pontuacao, acertos, erros) 
                           VALUES (?, 'quiz', ?, ?, ?, ?)");
    
    $result = $stmt->execute([
        $_SESSION['usuario_id'],
        $data['nivel'],
        $pontuacao,
        $data['acertos'],
        $data['erros']
    ]);

    if (!$result) {
        error_log("Erro ao executar INSERT em progresso_usuario: " . print_r($stmt->errorInfo(), true));
        throw new PDOException("Erro ao salvar progresso do usuário");
    }

    // Atualiza o total de pontos do usuário
    $stmt = $conn->prepare("UPDATE usuarios SET total_pontos = total_pontos + ? WHERE id = ?");
    $result = $stmt->execute([$pontuacao, $_SESSION['usuario_id']]);

    if (!$result) {
        error_log("Erro ao executar UPDATE em usuarios: " . print_r($stmt->errorInfo(), true));
        throw new PDOException("Erro ao atualizar pontos do usuário");
    }

    // Confirma a transação
    $conn->commit();
    error_log("Resultado do quiz salvo com sucesso");
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    // Em caso de erro, desfaz a transação
    $conn->rollBack();
    error_log("Erro ao salvar resultado do quiz: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    echo json_encode(['success' => false, 'message' => 'Erro ao salvar resultado: ' . $e->getMessage()]);
}
?> 