<?php
session_start();
require_once 'config/database.php';

// Buscar dados do usuário se estiver logado
$usuario = null;
if (isset($_SESSION['usuario_id'])) {
    $stmt = $conn->prepare("SELECT nome, email, foto_perfil FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caça aos fatos - Aprendendo História</title>
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
            transform-style: preserve-3d;
        }
        
        .game-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="min-h-screen hero-pattern">
    <!-- Header -->
    <?php include 'header.php'; ?>

    <!-- Hero Section -->
    <section class="py-40 relative">
        <div class="absolute inset-0 z-0">
            <img src="assets/images/mosaico.jpeg" alt="Background" class="w-full h-full object-cover opacity-45">
        </div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-5xl font-bold text-amber-800 mb-6">Viaje no Tempo!</h2>
                <p class="text-xl text-gray-700 mb-8 font-bold">Descubra o passado de forma divertida com nossos jogos de história para alunos das séries iniciais.</p>
                <div class="flex justify-center space-x-4">
                    <a href="jogos.php" class="bg-amber-500 hover:bg-amber-600 text-amber-900 font-bold py-3 px-6 rounded-full text-lg shadow-lg transform transition hover:scale-105">
                        <i class="fas fa-hourglass-start mr-2"></i> Começar a Jogar
                    </a>
                    <a href="#modules" class="bg-white hover:bg-gray-100 text-amber-800 font-bold py-3 px-6 rounded-full text-lg shadow-lg transform transition hover:scale-105">
                        <i class="fas fa-book mr-2"></i> Ver Matérias
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Subjects Section -->
    <section id="modules" class="py-12 bg-amber-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-amber-800 mb-12">Nossa Matéria: História</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Module 1 -->
                <div class="bg-amber-100 rounded-xl p-6 shadow-lg game-card">
                    <div class="text-center mb-4">
                        <div class="inline-block bg-amber-600 text-white p-3 rounded-full">
                            <i class="fas fa-ship text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-center text-amber-800 mb-3">Descobrimento do Brasil</h3>
                    <p class="text-gray-700 mb-4">Conheça como os portugueses chegaram ao Brasil e o primeiro contato com os povos indígenas.</p>
                    <div class="flex justify-center">
                        <a href="descobrimento.php" class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg">
                            Ver Conteúdo
                        </a>
                    </div>
                </div>
                
                <!-- Module 2 -->
                <div class="bg-amber-100 rounded-xl p-6 shadow-lg game-card">
                    <div class="text-center mb-4">
                        <div class="inline-block bg-amber-600 text-white p-3 rounded-full">
                            <i class="fas fa-landmark text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-center text-amber-800 mb-3">Período Colonial</h3>
                    <p class="text-gray-700 mb-4">Explore como foi o desenvolvimento do Brasil durante o período em que foi colônia de Portugal.</p>
                    <div class="flex justify-center">
                        <a href="periodo-colonial.php" class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg">
                            Ver Conteúdo
                        </a>
                    </div>
                </div>
                
                <!-- Module 3 -->
                <div class="bg-amber-100 rounded-xl p-6 shadow-lg game-card">
                    <div class="text-center mb-4">
                        <div class="inline-block bg-amber-600 text-white p-3 rounded-full">
                            <i class="fas fa-scroll text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-center text-amber-800 mb-3">Inconfidência Mineira</h3>
                    <p class="text-gray-700 mb-4">Descubra sobre o movimento que marcou o início da luta pela independência do Brasil.</p>
                    <div class="flex justify-center">
                        <a href="inconfidencia-mineira.php" class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg">
                            Ver Conteúdo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="sobre" class="py-16 bg-amber-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-amber-800 mb-6">Sobre o Caça aos fatos</h2>
                <p class="text-lg text-gray-700 mb-8 leading-relaxed">
                    O Caça aos fatos é uma plataforma educativa dedicada ao ensino da História do Brasil de forma interativa e envolvente. 
                    Nossa missão é despertar o interesse das crianças pelas raízes do nosso país através de conteúdos ricos, quizzes interativos 
                    e histórias que transportam os alunos para diferentes momentos da nossa trajetória. Com uma abordagem lúdica e moderna, 
                    transformamos o aprendizado da história em uma jornada fascinante de descobertas.
                </p>
                <div class="flex justify-center space-x-6">
                    <div class="bg-amber-100 p-6 rounded-xl shadow-md">
                        <div class="text-amber-600 text-4xl mb-3">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h4 class="font-bold text-amber-800 mb-2">Conteúdo Rico</h4>
                        <p class="text-gray-700">Módulos completos sobre a História do Brasil.</p>
                    </div>
                    <div class="bg-amber-100 p-6 rounded-xl shadow-md">
                        <div class="text-amber-600 text-4xl mb-3">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <h4 class="font-bold text-amber-800 mb-2">Quizzes Interativos</h4>
                        <p class="text-gray-700">Teste seus conhecimentos de forma divertida.</p>
                    </div>
                    <div class="bg-amber-100 p-6 rounded-xl shadow-md">
                        <div class="text-amber-600 text-4xl mb-3">
                            <i class="fas fa-history"></i>
                        </div>
                        <h4 class="font-bold text-amber-800 mb-2">Histórias Vivas</h4>
                        <p class="text-gray-700">Narrativas interativas sobre nosso passado.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="footer" class="bg-amber-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center">
                        <i class="fas fa-landmark text-3xl mr-2"></i>
                        <h3 class="text-2xl font-bold">Caça aos fatos</h3>
                    </div>
                    <p class="mt-2 text-amber-200">Aprendendo sobre o passado</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-amber-200 hover:text-white text-xl">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-amber-200 hover:text-white text-xl">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-amber-200 hover:text-white text-xl">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-amber-700 text-center text-amber-200">
                <p>&copy; 2024 Caça aos fatos. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'conta_excluida'): ?>
    <div id="mensagem-sucesso" class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        <p>Sua conta foi excluída com sucesso. Esperamos vê-lo novamente em breve!</p>
    </div>
    <script>
        setTimeout(function() {
            var mensagem = document.getElementById('mensagem-sucesso');
            if (mensagem) {
                mensagem.style.transition = 'opacity 0.5s ease-in-out';
                mensagem.style.opacity = '0';
                setTimeout(function() {
                    mensagem.remove();
                }, 500);
            }
        }, 5000);
    </script>
    <?php endif; ?>
</body>
</html> 