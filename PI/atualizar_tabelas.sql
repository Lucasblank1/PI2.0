-- Atualizar a tabela resultados_quiz
ALTER TABLE resultados_quiz
DROP FOREIGN KEY resultados_quiz_ibfk_1,
DROP COLUMN quiz_id,
ADD COLUMN nivel VARCHAR(20) NOT NULL AFTER usuario_id;

-- Atualizar a tabela progresso_usuario
ALTER TABLE progresso_usuario
DROP COLUMN tempo_jogado,
ADD COLUMN acertos INT DEFAULT 0 AFTER data_jogo,
ADD COLUMN erros INT DEFAULT 0 AFTER acertos;

-- Recriar os índices
DROP INDEX IF EXISTS idx_resultados_quiz ON resultados_quiz;
CREATE INDEX idx_resultados_quiz ON resultados_quiz(usuario_id, nivel);

-- Recriar as chaves estrangeiras
ALTER TABLE resultados_quiz
ADD CONSTRAINT resultados_quiz_ibfk_1
FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
ON DELETE CASCADE;

-- Tabela de progresso das histórias interativas
CREATE TABLE IF NOT EXISTS progresso_historia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    historia_id VARCHAR(50) NOT NULL,
    capitulo_atual INT NOT NULL DEFAULT 0,
    ultima_escolha VARCHAR(50),
    data_inicio DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Índice para melhor performance
CREATE INDEX idx_progresso_historia ON progresso_historia(usuario_id, historia_id); 