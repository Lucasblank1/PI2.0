-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    foto_perfil VARCHAR(255),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultimo_acesso TIMESTAMP NULL
);

-- Tabela de níveis do quiz
CREATE TABLE IF NOT EXISTS niveis_quiz (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT,
    pontos_necessarios INT DEFAULT 0
);

-- Tabela de resultados do quiz
CREATE TABLE IF NOT EXISTS resultados_quiz (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    quiz_id INT NOT NULL,
    pontuacao INT NOT NULL,
    tempo_gasto INT NOT NULL,
    data_realizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (quiz_id) REFERENCES niveis_quiz(id)
);

-- Tabela de progresso do usuário
CREATE TABLE IF NOT EXISTS progresso_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    nivel_id INT NOT NULL,
    pontos INT DEFAULT 0,
    ultima_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (nivel_id) REFERENCES niveis_quiz(id)
); 