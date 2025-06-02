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
    <title>Sobre - GameLearn História</title>
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
        
        .feature-card {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
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
            <h1 class="text-4xl font-bold mb-4">Sobre o GameLearn História</h1>
            <p class="text-xl">Aprenda história de forma divertida e interativa</p>
        </div>
    </div>

    <!-- About Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div class="bg-amber-100 rounded-xl p-8 shadow-lg mb-12">
                    <h2 class="text-2xl font-bold text-amber-800 mb-4">Nossa Missão</h2>
                    <p class="text-amber-700 mb-6">
                        O GameLearn História nasceu com o objetivo de tornar o aprendizado da história do Brasil mais envolvente e acessível. 
                        Acreditamos que a educação pode ser divertida e que os jogos são uma poderosa ferramenta de aprendizado.
                    </p>
                    <p class="text-amber-700">
                        Nossa plataforma combina elementos de jogos com conteúdo histórico de qualidade, criando uma experiência 
                        educativa única que estimula o interesse e facilita a compreensão dos principais eventos da história do Brasil.
                    </p>
                </div>

                <!-- Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    <div class="bg-amber-100 rounded-xl p-6 shadow-lg feature-card">
                        <div class="text-center mb-4">
                            <i class="fas fa-question-circle text-4xl text-amber-800"></i>
                        </div>
                        <h3 class="text-xl font-bold text-amber-800 mb-2 text-center">Quiz Histórico</h3>
                        <p class="text-amber-700 text-center">
                            Teste seus conhecimentos com perguntas sobre diferentes períodos da história do Brasil.
                        </p>
                    </div>

                    <div class="bg-amber-100 rounded-xl p-6 shadow-lg feature-card">
                        <div class="text-center mb-4">
                            <i class="fas fa-book-open text-4xl text-amber-800"></i>
                        </div>
                        <h3 class="text-xl font-bold text-amber-800 mb-2 text-center">História Interativa</h3>
                        <p class="text-amber-700 text-center">
                            Explore os principais eventos históricos através de narrativas envolventes e interativas.
                        </p>
                    </div>

                    <div class="bg-amber-100 rounded-xl p-6 shadow-lg feature-card">
                        <div class="text-center mb-4">
                            <i class="fas fa-chart-line text-4xl text-amber-800"></i>
                        </div>
                        <h3 class="text-xl font-bold text-amber-800 mb-2 text-center">Acompanhamento de Progresso</h3>
                        <p class="text-amber-700 text-center">
                            Acompanhe seu desenvolvimento e veja como seus conhecimentos evoluem ao longo do tempo.
                        </p>
                    </div>
                </div>

                <!-- Team Section -->
                <div class="bg-amber-100 rounded-xl p-8 shadow-lg">
                    <h2 class="text-2xl font-bold text-amber-800 mb-6 text-center">Nossa Equipe</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="bg-amber-600 text-white p-4 rounded-full inline-block mb-4">
                                <i class="fas fa-user-graduate text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-amber-800 mb-2">Educadores</h3>
                            <p class="text-amber-700">
                                Profissionais dedicados a garantir a qualidade e precisão do conteúdo histórico.
                            </p>
                        </div>

                        <div class="text-center">
                            <div class="bg-amber-600 text-white p-4 rounded-full inline-block mb-4">
                                <i class="fas fa-code text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-amber-800 mb-2">Desenvolvedores</h3>
                            <p class="text-amber-700">
                                Especialistas em tecnologia criando uma plataforma moderna e intuitiva.
                            </p>
                        </div>

                        <div class="text-center">
                            <div class="bg-amber-600 text-white p-4 rounded-full inline-block mb-4">
                                <i class="fas fa-paint-brush text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-amber-800 mb-2">Designers</h3>
                            <p class="text-amber-700">
                                Criativos que tornam a experiência de aprendizado mais atraente e envolvente.
                            </p>
                        </div>
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