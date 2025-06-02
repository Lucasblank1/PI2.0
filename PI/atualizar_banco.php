<?php
require_once 'config/database.php';

try {
    // Verifica se a tabela usuarios existe
    $stmt = $conn->query("SHOW TABLES LIKE 'usuarios'");
    if ($stmt->rowCount() == 0) {
        // Se não existir, cria a tabela
        $conn->exec("CREATE TABLE usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            senha VARCHAR(255) NOT NULL,
            data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
            total_pontos INT DEFAULT 0,
            nivel VARCHAR(20) DEFAULT 'iniciante',
            ultimo_login DATETIME,
            foto VARCHAR(255)
        )");
        echo "Tabela usuarios criada com sucesso!<br>";
    } else {
        // Verifica e adiciona colunas necessárias
        $colunas = [
            'total_pontos' => "ADD COLUMN total_pontos INT DEFAULT 0",
            'nivel' => "ADD COLUMN nivel VARCHAR(20) DEFAULT 'iniciante'",
            'ultimo_login' => "ADD COLUMN ultimo_login DATETIME",
            'foto' => "ADD COLUMN foto VARCHAR(255)"
        ];

        foreach ($colunas as $coluna => $sql) {
            $stmt = $conn->query("SHOW COLUMNS FROM usuarios LIKE '$coluna'");
            if ($stmt->rowCount() == 0) {
                $conn->exec("ALTER TABLE usuarios $sql");
                echo "Coluna $coluna adicionada à tabela usuarios com sucesso!<br>";
            }
        }
    }

    // Verifica se a tabela resultados_quiz existe
    $stmt = $conn->query("SHOW TABLES LIKE 'resultados_quiz'");
    if ($stmt->rowCount() == 0) {
        // Se não existir, cria a tabela
        $conn->exec("CREATE TABLE resultados_quiz (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario_id INT NOT NULL,
            nivel VARCHAR(20) NOT NULL,
            pontuacao INT NOT NULL,
            data_realizacao DATETIME DEFAULT CURRENT_TIMESTAMP,
            tempo_gasto INT DEFAULT 0,
            acertos INT DEFAULT 0,
            erros INT DEFAULT 0,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
        )");
        echo "Tabela resultados_quiz criada com sucesso!<br>";
    } else {
        // Verifica e adiciona colunas necessárias
        $colunas = [
            'nivel' => "ADD COLUMN nivel VARCHAR(20) NOT NULL AFTER usuario_id",
            'tempo_gasto' => "ADD COLUMN tempo_gasto INT DEFAULT 0",
            'acertos' => "ADD COLUMN acertos INT DEFAULT 0",
            'erros' => "ADD COLUMN erros INT DEFAULT 0"
        ];

        foreach ($colunas as $coluna => $sql) {
            $stmt = $conn->query("SHOW COLUMNS FROM resultados_quiz LIKE '$coluna'");
            if ($stmt->rowCount() == 0) {
                $conn->exec("ALTER TABLE resultados_quiz $sql");
                echo "Coluna $coluna adicionada à tabela resultados_quiz com sucesso!<br>";
            }
        }

        // Remove coluna quiz_id se existir
        $stmt = $conn->query("SHOW COLUMNS FROM resultados_quiz LIKE 'quiz_id'");
        if ($stmt->rowCount() > 0) {
            $conn->exec("ALTER TABLE resultados_quiz DROP COLUMN quiz_id");
            echo "Coluna quiz_id removida da tabela resultados_quiz com sucesso!<br>";
        }
    }

    // Verifica se a tabela progresso_usuario existe
    $stmt = $conn->query("SHOW TABLES LIKE 'progresso_usuario'");
    if ($stmt->rowCount() == 0) {
        // Se não existir, cria a tabela
        $conn->exec("CREATE TABLE progresso_usuario (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario_id INT NOT NULL,
            tipo_jogo ENUM('quiz', 'historia') NOT NULL,
            nivel VARCHAR(20) NOT NULL,
            pontuacao INT DEFAULT 0,
            data_jogo DATETIME DEFAULT CURRENT_TIMESTAMP,
            acertos INT DEFAULT 0,
            erros INT DEFAULT 0,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
        )");
        echo "Tabela progresso_usuario criada com sucesso!<br>";
    } else {
        // Verifica e adiciona colunas necessárias
        $colunas = [
            'acertos' => "ADD COLUMN acertos INT DEFAULT 0 AFTER data_jogo",
            'erros' => "ADD COLUMN erros INT DEFAULT 0 AFTER acertos"
        ];

        foreach ($colunas as $coluna => $sql) {
            $stmt = $conn->query("SHOW COLUMNS FROM progresso_usuario LIKE '$coluna'");
            if ($stmt->rowCount() == 0) {
                $conn->exec("ALTER TABLE progresso_usuario $sql");
                echo "Coluna $coluna adicionada à tabela progresso_usuario com sucesso!<br>";
            }
        }

        // Remove coluna tempo_jogado se existir
        $stmt = $conn->query("SHOW COLUMNS FROM progresso_usuario LIKE 'tempo_jogado'");
        if ($stmt->rowCount() > 0) {
            $conn->exec("ALTER TABLE progresso_usuario DROP COLUMN tempo_jogado");
            echo "Coluna tempo_jogado removida da tabela progresso_usuario com sucesso!<br>";
        }
    }

    // Recria os índices
    $conn->exec("DROP INDEX IF EXISTS idx_resultados_quiz ON resultados_quiz");
    $conn->exec("CREATE INDEX idx_resultados_quiz ON resultados_quiz(usuario_id, nivel)");
    echo "Índices recriados com sucesso!<br>";

    echo "<br>Banco de dados atualizado com sucesso!<br>";
    echo "<a href='quiz.php'>Voltar para o Quiz</a>";

} catch(PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?> 