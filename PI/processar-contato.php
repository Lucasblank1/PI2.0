<?php
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém e sanitiza os dados do formulário
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $assunto = filter_input(INPUT_POST, 'assunto', FILTER_SANITIZE_STRING);
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);

    // Valida os dados
    $erros = [];
    if (empty($nome)) {
        $erros[] = "O nome é obrigatório.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "E-mail inválido.";
    }
    if (empty($assunto)) {
        $erros[] = "O assunto é obrigatório.";
    }
    if (empty($mensagem)) {
        $erros[] = "A mensagem é obrigatória.";
    }

    // Se não houver erros, processa o envio
    if (empty($erros)) {
        // Configura o e-mail
        $para = "contato@gamelearn.com.br";
        $assunto_email = "Contato via Site - " . $assunto;
        $corpo = "Nome: " . $nome . "\n";
        $corpo .= "E-mail: " . $email . "\n\n";
        $corpo .= "Mensagem:\n" . $mensagem;
        $cabecalhos = "From: " . $email;

        // Tenta enviar o e-mail
        if (mail($para, $assunto_email, $corpo, $cabecalhos)) {
            $_SESSION['mensagem'] = "Mensagem enviada com sucesso! Entraremos em contato em breve.";
            $_SESSION['tipo'] = "sucesso";
        } else {
            $_SESSION['mensagem'] = "Erro ao enviar mensagem. Por favor, tente novamente mais tarde.";
            $_SESSION['tipo'] = "erro";
        }
    } else {
        // Se houver erros, armazena-os na sessão
        $_SESSION['mensagem'] = implode("<br>", $erros);
        $_SESSION['tipo'] = "erro";
    }
}

// Redireciona de volta para a página de contato
header("Location: contato.php");
exit();
?> 