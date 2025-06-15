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
    <title>Descobrimento do Brasil - Caça aos fatos</title>
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
                <h1 class="text-4xl font-bold text-amber-800 mb-6 text-center">Descobrimento do Brasil</h1>
                
                <div class="mb-8">
                    <img src="assets/images/descobrimentos.jpg" alt="Descobrimento do Brasil" class="w-full h-96 object-cover rounded-lg shadow-md">
                </div>

                <div class="prose max-w-none">
                    <p class="text-lg text-gray-700 mb-4">
                        O Descobrimento do Brasil, oficialmente datado de 22 de abril de 1500, é um dos episódios mais emblemáticos da história brasileira. 
                        A frota portuguesa, liderada por Pedro Álvares Cabral, tinha como destino as Índias, mas ao desviar sua rota, encontrou terras que hoje formam o Brasil.
                    </p>
                    
                    <p class="text-lg text-gray-700 mb-4">
                        Esse encontro se deu no contexto das Grandes Navegações, movidas pela busca de novas rotas comerciais, riquezas e expansão territorial. 
                        O Tratado de Tordesilhas (1494) já previa a divisão do mundo entre portugueses e espanhóis, garantindo a Portugal a posse da terra encontrada.
                    </p>

                    <p class="text-lg text-gray-700 mb-4">
                        O primeiro contato dos portugueses foi com povos indígenas que aqui habitavam há milhares de anos. 
                        Eles possuíam uma cultura rica, dominavam técnicas agrícolas, pesca e caça, além de uma organização social sofisticada.
                    </p>

                    <div class="mt-8 bg-amber-50 p-6 rounded-lg">
                        <h2 class="text-2xl font-bold text-amber-800 mb-4">Curiosidades</h2>
                        <ul class="list-disc list-inside space-y-2">
                            <li class="text-lg text-gray-700">
                                A carta de Pero Vaz de Caminha, considerada a certidão de nascimento do Brasil, descreve com detalhes os habitantes, 
                                a fauna, flora e as primeiras impressões dos europeus.
                            </li>
                            <li class="text-lg text-gray-700">
                                Existem teorias que indicam que Portugal já sabia da existência de terras a oeste antes da viagem de Cabral.
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
