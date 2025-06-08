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
    <title>Selecionar Nível - Caça aos fatos História</title>
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
        
        .level-card {
            transition: all 0.3s ease;
        }
        
        .level-card:hover {
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
            <h1 class="text-4xl font-bold mb-4">Selecione o Nível</h1>
            <p class="text-xl">Escolha o nível de dificuldade do quiz</p>
        </div>
    </div>

    <!-- Levels Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Fácil -->
                <div class="level-card bg-amber-100 rounded-xl p-6 shadow-lg">
                    <div class="text-center mb-4">
                        <div class="inline-block bg-green-500 text-white p-3 rounded-full">
                            <i class="fas fa-star text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-center text-amber-800 mb-3">Fácil</h3>
                    <p class="text-gray-700 mb-4">
                        Perfeito para iniciantes! Questões básicas sobre fatos históricos importantes.
                    </p>
                    <div class="flex justify-center">
                        <a href="quiz.php?nivel=facil" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg">
                            Começar Quiz
                        </a>
                    </div>
                </div>

                <!-- Médio -->
                <div class="level-card bg-amber-100 rounded-xl p-6 shadow-lg">
                    <div class="text-center mb-4">
                        <div class="inline-block bg-yellow-500 text-white p-3 rounded-full">
                            <i class="fas fa-star text-2xl"></i>
                            <i class="fas fa-star text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-center text-amber-800 mb-3">Médio</h3>
                    <p class="text-gray-700 mb-4">
                        Para quem já tem um bom conhecimento histórico. Questões mais elaboradas e contextualizadas.
                    </p>
                    <div class="flex justify-center">
                        <a href="quiz.php?nivel=medio" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg">
                            Começar Quiz
                        </a>
                    </div>
                </div>

                <!-- Difícil -->
                <div class="level-card bg-amber-100 rounded-xl p-6 shadow-lg">
                    <div class="text-center mb-4">
                        <div class="inline-block bg-red-500 text-white p-3 rounded-full">
                            <i class="fas fa-star text-2xl"></i>
                            <i class="fas fa-star text-2xl"></i>
                            <i class="fas fa-star text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-center text-amber-800 mb-3">Difícil</h3>
                    <p class="text-gray-700 mb-4">
                        Desafie-se com questões complexas e detalhadas sobre eventos históricos específicos.
                    </p>
                    <div class="flex justify-center">
                        <a href="quiz.php?nivel=dificil" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg">
                            Começar Quiz
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Botão Voltar -->
    <div class="container mx-auto px-4 text-center mb-12">
        <a href="index.php" class="inline-flex items-center bg-amber-600 hover:bg-amber-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i>
            Voltar para a Página Inicial
        </a>
    </div>

    <footer class="bg-amber-800 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Caça aos fatos - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html> 