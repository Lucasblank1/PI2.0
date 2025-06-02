<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'config/database.php';
require_once 'config/historias_interativas.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$historia_id = $_GET['id'] ?? null;
$capitulo_atual = $_GET['capitulo'] ?? 0;
$escolha = $_GET['escolha'] ?? null;

if (!$historia_id || !isset($historias_interativas[$historia_id])) {
    header("Location: historia-interativa.php");
    exit();
}

$historia = $historias_interativas[$historia_id];

// Garantir que o capítulo atual seja um número inteiro
$capitulo_atual = (int)$capitulo_atual;

// Verificar se o capítulo atual é válido
if ($capitulo_atual < 0 || $capitulo_atual >= count($historia['capitulos'])) {
    header("Location: historia-interativa.php");
    exit();
}

// Se houver uma escolha, salvar o progresso
if ($escolha !== null) {
    error_log('Escolha recebida: ' . $escolha . ' | Capítulo atual: ' . $capitulo_atual);
    try {
        // Verificar se já existe um progresso
        $stmt = $conn->prepare("SELECT * FROM progresso_historia WHERE usuario_id = ? AND historia_id = ?");
        $stmt->execute([$_SESSION['usuario_id'], $historia_id]);
        $progresso = $stmt->fetch();

        if ($progresso) {
            // Atualizar progresso existente
            $stmt = $conn->prepare("UPDATE progresso_historia SET capitulo_atual = ?, ultima_escolha = ?, data_atualizacao = NOW() WHERE usuario_id = ? AND historia_id = ?");
            $stmt->execute([$capitulo_atual, $escolha, $_SESSION['usuario_id'], $historia_id]);
        } else {
            // Criar novo progresso
            $stmt = $conn->prepare("INSERT INTO progresso_historia (usuario_id, historia_id, capitulo_atual, ultima_escolha, data_inicio, data_atualizacao) VALUES (?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$_SESSION['usuario_id'], $historia_id, $capitulo_atual, $escolha]);
        }

        // Se chegou ao final da história
        if ($escolha === '0' || $escolha === 0) {
            $pontuacao = count($historia['capitulos']) * 10;
            $stmt = $conn->prepare("UPDATE usuarios SET total_pontos = total_pontos + ? WHERE id = ?");
            $stmt->execute([$pontuacao, $_SESSION['usuario_id']]);
            header("Location: historia-interativa.php?sucesso=historia_completa&pontuacao=" . $pontuacao);
            exit();
        }

        // Redirecionar para o próximo capítulo
        $next_url = "jogar-historia.php?id=" . $historia_id . "&capitulo=" . $escolha;
        error_log('Redirecionando para: ' . $next_url);
        header("Location: " . $next_url);
        exit();
    } catch (PDOException $e) {
        error_log("Erro ao salvar progresso da história: " . $e->getMessage());
        echo '<div style="color:red;">Erro ao salvar progresso da história: ' . $e->getMessage() . '</div>';
        header("Location: historia-interativa.php?erro=salvar_progresso");
        exit();
    }
}

$capitulo = $historia['capitulos'][$capitulo_atual];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($historia['titulo']); ?> - GameLearn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap');
        
        body {
            font-family: 'Comic Neue', cursive;
            background-color: #f0f9ff;
        }
        
        .hero-pattern {
            background-image: radial-gradient(circle at 10% 20%, rgba(255,200,124,0.5) 0%, rgba(252,251,121,0.3) 90%);
        }
        
        .story-card {
            transition: all 0.3s ease;
        }
        
        .story-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .choice-button {
            transition: all 0.3s ease;
        }

        .choice-button:hover {
            transform: scale(1.02);
        }

        .progress-bar {
            height: 4px;
            background-color: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background-color: #d97706;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body class="min-h-screen hero-pattern">
    <?php include 'header.php'; ?>

    <main class="py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-4xl font-bold text-center text-amber-800 mb-8"><?php echo htmlspecialchars($historia['titulo']); ?></h1>
                
                <div class="text-center mb-8">
                    <span class="bg-amber-600 text-white px-4 py-2 rounded-full">
                        Capítulo <?php echo $capitulo_atual + 1; ?> de <?php echo count($historia['capitulos']); ?>
                    </span>
                    <div class="mt-4 progress-bar">
                        <div class="progress-bar-fill" style="width: <?php echo (($capitulo_atual + 1) / count($historia['capitulos'])) * 100; ?>%"></div>
                    </div>
                </div>

                <div class="bg-amber-100 rounded-xl p-8 shadow-lg story-card mb-8">
                    <h2 class="text-2xl font-bold text-amber-800 mb-4"><?php echo htmlspecialchars($capitulo['titulo']); ?></h2>
                    <p class="text-amber-700 text-lg mb-6"><?php echo htmlspecialchars($capitulo['conteudo']); ?></p>

                    <div class="space-y-4">
                        <?php foreach ($capitulo['escolhas'] as $escolha): ?>
                            <a href="jogar-historia.php?id=<?php echo $historia_id; ?>&capitulo=<?php echo (int)$escolha['proximo_capitulo']; ?>&escolha=<?php echo (int)$escolha['proximo_capitulo']; ?>" 
                               class="block bg-amber-600 hover:bg-amber-700 text-white font-medium py-3 px-6 rounded-lg text-center transition-colors choice-button">
                                <?php echo htmlspecialchars($escolha['texto']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="text-center">
                    <a href="historia-interativa.php" class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Voltar para Histórias
                    </a>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html> 