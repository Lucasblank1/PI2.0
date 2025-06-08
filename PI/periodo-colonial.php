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
    <title>Período Colonial - Caça aos fatos</title>
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
    </style>
</head>
<body class="min-h-screen hero-pattern">
    <!-- Header -->
    <?php include 'header.php'; ?>

    <!-- Conteúdo Principal -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8">
                <h1 class="text-4xl font-bold text-amber-800 mb-6 text-center">Período Colonial</h1>
                
                <div class="mb-8">
                    <img src="assets/images/periodo-colonial.jpg" alt="Período Colonial" class="w-full h-96 object-cover rounded-lg shadow-md">
                </div>

                <div class="prose max-w-none">
                    <p class="text-lg text-gray-700 mb-4">
                        O Período Colonial do Brasil (1500-1822) foi marcado pela exploração econômica e pela imposição da cultura europeia sobre os povos nativos e africanos trazidos à força.
                    </p>
                    
                    <p class="text-lg text-gray-700 mb-4">
                        Nos primeiros anos, a atividade se concentrou na extração do pau-brasil. A partir de 1530, iniciou-se a colonização efetiva com as Capitanias Hereditárias e, posteriormente, com o Governo-Geral. 
                        Salvador, fundada em 1549, foi a primeira capital.
                    </p>

                    <p class="text-lg text-gray-700 mb-4">
                        A economia colonial era baseada no sistema de plantation, com uso intensivo de mão de obra escrava africana, principalmente para a produção de açúcar, 
                        além de atividades como mineração de ouro e diamantes no século XVIII.
                    </p>

                    <p class="text-lg text-gray-700 mb-4">
                        A sociedade era extremamente hierarquizada, dividida entre grandes proprietários, burocratas, homens livres pobres e uma enorme população escravizada.
                    </p>

                    <div class="mt-8 bg-amber-50 p-6 rounded-lg">
                        <h2 class="text-2xl font-bold text-amber-800 mb-4">Curiosidades</h2>
                        <ul class="list-disc list-inside space-y-2">
                            <li class="text-lg text-gray-700">
                                O Quilombo dos Palmares resistiu por quase 100 anos, sendo um dos maiores símbolos da resistência negra no Brasil.
                            </li>
                            <li class="text-lg text-gray-700">
                                As cidades de Ouro Preto, Mariana e Sabará surgiram durante o Ciclo do Ouro e até hoje conservam muito da arquitetura colonial.
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-8 flex justify-center">
                    <a href="index.php" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-full text-lg shadow-lg transform transition hover:scale-105">
                        <i class="fas fa-arrow-left mr-2"></i> Voltar para a Página Inicial
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html> 