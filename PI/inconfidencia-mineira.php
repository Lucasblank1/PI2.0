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
    <title>Inconfidência Mineira - Caça aos fatos</title>
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
                <h1 class="text-4xl font-bold text-amber-800 mb-6 text-center">Inconfidência Mineira</h1>
                
                <div class="mb-8">
                    <img src="assets/images/inconfidencia-mineira.jpg" alt="Inconfidência Mineira" class="w-full h-96 object-cover rounded-lg shadow-md">
                </div>

                <div class="prose max-w-none">
                    <p class="text-lg text-gray-700 mb-4">
                        A Inconfidência Mineira, ocorrida em 1789, foi o primeiro grande movimento de caráter separatista no Brasil. 
                        Surgiu no contexto da decadência da mineração e da opressiva cobrança de impostos pela Coroa Portuguesa, especialmente a temida 'derrama'.
                    </p>
                    
                    <p class="text-lg text-gray-700 mb-4">
                        Inspirados pelos ideais do Iluminismo, da Independência dos EUA e da Revolução Francesa, os inconfidentes — em sua maioria membros da elite mineradora, 
                        intelectuais, militares e religiosos — desejavam proclamar uma república independente em Minas Gerais.
                    </p>

                    <p class="text-lg text-gray-700 mb-4">
                        O movimento foi descoberto antes de ser colocado em prática, após ser delatado por Joaquim Silvério dos Reis. 
                        Seus líderes foram presos, julgados e condenados. Apenas Tiradentes foi executado publicamente, tornando-se mártir da luta pela liberdade.
                    </p>

                    <div class="mt-8 bg-amber-50 p-6 rounded-lg">
                        <h2 class="text-2xl font-bold text-amber-800 mb-4">Curiosidades</h2>
                        <ul class="list-disc list-inside space-y-2">
                            <li class="text-lg text-gray-700">
                                O nome 'Tiradentes' vem de sua profissão de dentista, uma de suas atividades além da carreira militar.
                            </li>
                            <li class="text-lg text-gray-700">
                                Partes do corpo de Tiradentes foram espalhadas por vilas e estradas como exemplo para desencorajar futuros movimentos rebeldes.
                            </li>
                            <li class="text-lg text-gray-700">
                                A Inconfidência inspirou diversos movimentos futuros, sendo símbolo da luta pela independência brasileira.
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