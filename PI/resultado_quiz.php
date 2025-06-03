<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : '';
$acertos = isset($_GET['acertos']) ? (int)$_GET['acertos'] : 0;
$erros = isset($_GET['erros']) ? (int)$_GET['erros'] : 0;

// Buscar histórico de resultados do usuário
$stmt = $conn->prepare("SELECT * FROM resultados_quiz WHERE usuario_id = ? ORDER BY data_realizacao DESC LIMIT 5");
$stmt->execute([$_SESSION['usuario_id']]);
$historico = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    </style>
</head>
<body class="min-h-screen hero-pattern">
    <?php include 'header.php'; ?>

    <!-- Header Section -->
    <div class="bg-amber-700 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Resultado do Quiz</h1>
            <p class="text-xl">Nível: <?php echo ucfirst($nivel); ?></p>
        </div>
    </div>

    <!-- Result Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div class="bg-amber-100 rounded-xl p-8 shadow-lg mb-8">
                    <h2 class="text-2xl font-bold text-amber-800 mb-6">Seu Resultado</h2>
                    
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div class="bg-white rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-green-600 mb-2"><?php echo $acertos; ?></div>
                            <div class="text-amber-800">Acertos</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-red-600 mb-2"><?php echo $erros; ?></div>
                            <div class="text-amber-800">Erros</div>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="text-2xl font-bold text-amber-800 mb-2">
                            Pontuação: <?php echo ($acertos * ($nivel === 'facil' ? 10 : ($nivel === 'medio' ? 20 : 30))); ?> pontos
                        </div>
                    </div>
                </div>

                <!-- Histórico de Resultados -->
                <div class="bg-amber-100 rounded-xl p-8 shadow-lg">
                    <h2 class="text-2xl font-bold text-amber-800 mb-6">Seu Histórico</h2>
                    
                    <?php if (!empty($historico)): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-amber-200">
                                        <th class="px-4 py-2 text-left">Data</th>
                                        <th class="px-4 py-2 text-left">Nível</th>
                                        <th class="px-4 py-2 text-left">Pontuação</th>
                                        <th class="px-4 py-2 text-left">Acertos</th>
                                        <th class="px-4 py-2 text-left">Erros</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historico as $resultado): ?>
                                        <tr class="border-b border-amber-200">
                                            <td class="px-4 py-2"><?php echo date('d/m/Y H:i', strtotime($resultado['data_realizacao'])); ?></td>
                                            <td class="px-4 py-2"><?php echo ucfirst($resultado['nivel']); ?></td>
                                            <td class="px-4 py-2"><?php echo $resultado['pontuacao']; ?></td>
                                            <td class="px-4 py-2"><?php echo $resultado['acertos']; ?></td>
                                            <td class="px-4 py-2"><?php echo $resultado['erros']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-amber-800 text-center">Nenhum resultado anterior encontrado.</p>
                    <?php endif; ?>
                </div>

                <div class="flex justify-between mt-8">
                    <a href="selecionar-nivel.php" class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-6 rounded-lg">
                        <i class="fas fa-redo mr-2"></i>Jogar Novamente
                    </a>
                    <a href="dashboard.php" class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-6 rounded-lg">
                        Voltar ao Dashboard<i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html> 