<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$pontuacao = isset($_GET['pontuacao']) ? (int)$_GET['pontuacao'] : 0;
$total = isset($_GET['total']) ? (int)$_GET['total'] : 0;
$acertos = isset($_GET['acertos']) ? (int)$_GET['acertos'] : 0;

// Definir mensagem e cor com base na pontuação
$mensagem = '';
$cor = '';

if ($pontuacao >= 80) {
    $mensagem = 'Excelente! Você é um mestre da história!';
    $cor = 'text-green-600';
} elseif ($pontuacao >= 60) {
    $mensagem = 'Muito bom! Você tem um bom conhecimento histórico!';
    $cor = 'text-amber-600';
} else {
    $mensagem = 'Continue estudando! A história tem muito a ensinar!';
    $cor = 'text-red-600';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Quiz - Caça aos fatos História</title>
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
        
        .result-card {
            transition: all 0.3s ease;
        }
        
        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="min-h-screen hero-pattern">
    <?php include 'header.php'; ?>

    <!-- Header Section -->
    <div class="bg-amber-700 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Resultado do Quiz</h1>
            <p class="text-xl">Veja como você se saiu!</p>
        </div>
    </div>

    <!-- Result Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div class="bg-amber-100 rounded-xl p-8 shadow-lg result-card">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-amber-800 mb-4">Sua Pontuação</h2>
                        <div class="text-6xl font-bold <?php echo $cor; ?> mb-4">
                            <?php echo $pontuacao; ?>%
                        </div>
                        <p class="text-xl <?php echo $cor; ?> mb-4"><?php echo $mensagem; ?></p>
                        <div class="text-amber-800">
                            <p class="text-lg">Você acertou <?php echo $acertos; ?> de <?php echo $total; ?> questões</p>
                        </div>
                    </div>

                    <div class="flex justify-center space-x-4">
                        <a href="selecionar-nivel.php" class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-6 rounded-lg">
                            <i class="fas fa-redo mr-2"></i>Jogar Novamente
                        </a>
                        <a href="jogos.php" class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-6 rounded-lg">
                            <i class="fas fa-gamepad mr-2"></i>Outros Jogos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-amber-800 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Caça aos fatos - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html> 