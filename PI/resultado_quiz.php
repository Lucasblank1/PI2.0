<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$nivel = $_GET['nivel'] ?? '';
$acertos = $_GET['acertos'] ?? 0;
$erros = $_GET['erros'] ?? 0;
$pontos = $_GET['pontos'] ?? 0;

$total_perguntas = $acertos + $erros;
$porcentagem = $total_perguntas > 0 ? ($acertos / $total_perguntas) * 100 : 0;

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
                <div class="bg-white rounded-xl p-8 shadow-lg">
                    <h2 class="text-3xl font-bold text-amber-800 mb-6 text-center">Resultado do Quiz</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div class="bg-amber-50 p-6 rounded-lg">
                            <h3 class="text-xl font-bold text-amber-800 mb-4">Estatísticas</h3>
                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Nível:</span>
                                    <span class="font-bold text-amber-800"><?php echo ucfirst($nivel); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Acertos:</span>
                                    <span class="font-bold text-green-600"><?php echo $acertos; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Erros:</span>
                                    <span class="font-bold text-red-600"><?php echo $erros; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Pontuação:</span>
                                    <span class="font-bold text-amber-800"><?php echo $pontos; ?> pontos</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Porcentagem de acerto:</span>
                                    <span class="font-bold text-amber-800"><?php echo number_format($porcentagem, 1); ?>%</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-amber-50 p-6 rounded-lg">
                            <h3 class="text-xl font-bold text-amber-800 mb-4">Mensagem</h3>
                            <p class="text-gray-700">
                                <?php
                                if ($porcentagem >= 80) {
                                    echo "Parabéns! Você é um verdadeiro conhecedor da história do Brasil!";
                                } elseif ($porcentagem >= 60) {
                                    echo "Bom trabalho! Você tem um bom conhecimento sobre a história do Brasil.";
                                } elseif ($porcentagem >= 40) {
                                    echo "Continue estudando! Você está no caminho certo para aprender mais sobre a história do Brasil.";
                                } else {
                                    echo "Não desanime! A história do Brasil é fascinante e há muito mais para aprender.";
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex justify-center space-x-4">
                        <a href="selecionar-nivel.php" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-full text-lg shadow-lg transform transition hover:scale-105">
                            <i class="fas fa-redo mr-2"></i> Tentar Novamente
                        </a>
                        <a href="index.php" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-full text-lg shadow-lg transform transition hover:scale-105">
                            <i class="fas fa-home mr-2"></i> Voltar ao Início
                        </a>
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
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html> 