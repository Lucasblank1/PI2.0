<?php
session_start();
require_once 'config/historias_interativas.php';

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
    <title>História Interativa - GameLearn História</title>
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
        
        .story-card {
            transition: all 0.3s ease;
        }
        
        .story-card:hover {
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
            <h1 class="text-4xl font-bold mb-4">História Interativa</h1>
            <p class="text-xl">Explore os principais momentos da história do Brasil</p>
        </div>
    </div>

    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'historia_completa'): ?>
        <div class="container mx-auto px-4 mt-8">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Parabéns!</strong>
                <span class="block sm:inline"> Você completou a história e ganhou <?php echo $_GET['pontuacao']; ?> pontos!</span>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'salvar_progresso'): ?>
        <div class="container mx-auto px-4 mt-8">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Erro!</strong>
                <span class="block sm:inline"> Não foi possível salvar seu progresso. Por favor, tente novamente.</span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Stories Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php foreach ($historias_interativas as $id => $historia): ?>
                <div class="bg-amber-100 rounded-xl p-8 shadow-lg story-card">
                    <div class="text-center mb-6">
                        <i class="fas fa-book text-4xl text-amber-800 mb-4"></i>
                        <h2 class="text-2xl font-bold text-amber-800 mb-2"><?php echo htmlspecialchars($historia['titulo']); ?></h2>
                        <p class="text-amber-700"><?php echo htmlspecialchars($historia['descricao']); ?></p>
                    </div>
                    <a href="jogar-historia.php?id=<?php echo $id; ?>&capitulo=0" class="block text-center bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-6 rounded-lg">
                        Explorar História
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html> 