<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogos - GameLearn História</title>
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
        
        .game-card {
            transition: all 0.3s ease;
        }
        
        .game-card:hover {
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
            <h1 class="text-4xl font-bold mb-4">Jogos Educativos</h1>
            <p class="text-xl">Escolha um jogo para começar a aprender história de forma divertida</p>
        </div>
    </div>

    <!-- Games Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Quiz Histórico -->
                <div class="game-card bg-amber-100 rounded-xl p-6 shadow-lg">
                    <div class="text-center mb-4">
                        <div class="inline-block bg-amber-600 text-white p-3 rounded-full">
                            <i class="fas fa-question-circle text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-center text-amber-800 mb-3">Quiz Histórico</h3>
                    <p class="text-gray-700 mb-4">
                        Teste seus conhecimentos sobre a história do Brasil com nossos quizzes interativos. 
                        Escolha o nível de dificuldade e responda às perguntas para ganhar pontos!
                    </p>
                    <div class="flex justify-center">
                        <a href="selecionar-nivel.php" class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg">
                            Jogar Quiz
                        </a>
                    </div>
                </div>

                <!-- História Interativa -->
                <div class="game-card bg-amber-100 rounded-xl p-6 shadow-lg">
                    <div class="text-center mb-4">
                        <div class="inline-block bg-amber-600 text-white p-3 rounded-full">
                            <i class="fas fa-book text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-center text-amber-800 mb-3">História Interativa</h3>
                    <p class="text-gray-700 mb-4">
                        Explore diferentes períodos da história do Brasil através de narrativas interativas. 
                        Faça escolhas e descubra como os eventos históricos se desenrolaram!
                    </p>
                    <div class="flex justify-center">
                        <a href="historia-interativa.php" class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg">
                            Explorar Histórias
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-amber-800 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 GameLearn - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html> 