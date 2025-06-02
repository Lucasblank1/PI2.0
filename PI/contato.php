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
    <title>Contato - GameLearn História</title>
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
        
        .contact-card {
            transition: all 0.3s ease;
        }
        
        .contact-card:hover {
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
            <h1 class="text-4xl font-bold mb-4">Entre em Contato</h1>
            <p class="text-xl">Estamos aqui para ajudar e ouvir suas sugestões</p>
        </div>
    </div>

    <!-- Contact Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <?php if (isset($_SESSION['mensagem'])): ?>
                    <div class="mb-8 p-4 rounded-lg <?php echo $_SESSION['tipo'] === 'sucesso' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                        <?php 
                        echo $_SESSION['mensagem'];
                        unset($_SESSION['mensagem']);
                        unset($_SESSION['tipo']);
                        ?>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Contact Form -->
                    <div class="bg-amber-100 rounded-xl p-8 shadow-lg contact-card">
                        <h2 class="text-2xl font-bold text-amber-800 mb-6">Envie uma Mensagem</h2>
                        <form action="processar-contato.php" method="POST">
                            <div class="mb-4">
                                <label for="nome" class="block text-amber-800 font-medium mb-2">Nome</label>
                                <input type="text" id="nome" name="nome" required
                                    class="w-full px-4 py-2 rounded-lg border border-amber-300 focus:outline-none focus:border-amber-500">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-amber-800 font-medium mb-2">E-mail</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-2 rounded-lg border border-amber-300 focus:outline-none focus:border-amber-500">
                            </div>
                            <div class="mb-4">
                                <label for="assunto" class="block text-amber-800 font-medium mb-2">Assunto</label>
                                <input type="text" id="assunto" name="assunto" required
                                    class="w-full px-4 py-2 rounded-lg border border-amber-300 focus:outline-none focus:border-amber-500">
                            </div>
                            <div class="mb-6">
                                <label for="mensagem" class="block text-amber-800 font-medium mb-2">Mensagem</label>
                                <textarea id="mensagem" name="mensagem" rows="4" required
                                    class="w-full px-4 py-2 rounded-lg border border-amber-300 focus:outline-none focus:border-amber-500"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-6 rounded-lg">
                                Enviar Mensagem
                            </button>
                        </form>
                    </div>

                    <!-- Contact Info -->
                    <div class="bg-amber-100 rounded-xl p-8 shadow-lg contact-card">
                        <h2 class="text-2xl font-bold text-amber-800 mb-6">Informações de Contato</h2>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-amber-800 text-xl mr-4"></i>
                                <a href="mailto:contato@gamelearn.com.br" class="text-amber-700 hover:text-amber-800">
                                    contato@gamelearn.com.br
                                </a>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-phone text-amber-800 text-xl mr-4"></i>
                                <span class="text-amber-700">(11) 99999-9999</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-amber-800 text-xl mr-4"></i>
                                <span class="text-amber-700">São Paulo, SP - Brasil</span>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-amber-800 mb-4">Redes Sociais</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="text-amber-800 hover:text-amber-600">
                                    <i class="fab fa-facebook text-2xl"></i>
                                </a>
                                <a href="#" class="text-amber-800 hover:text-amber-600">
                                    <i class="fab fa-instagram text-2xl"></i>
                                </a>
                                <a href="#" class="text-amber-800 hover:text-amber-600">
                                    <i class="fab fa-twitter text-2xl"></i>
                                </a>
                                <a href="#" class="text-amber-800 hover:text-amber-600">
                                    <i class="fab fa-youtube text-2xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="mt-12 bg-amber-100 rounded-xl p-8 shadow-lg contact-card">
                    <h2 class="text-2xl font-bold text-amber-800 mb-6">Perguntas Frequentes</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-bold text-amber-800 mb-2">Como posso começar a usar a plataforma?</h3>
                            <p class="text-amber-700">
                                Basta criar uma conta gratuita e começar a explorar nossos jogos e histórias interativas.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-amber-800 mb-2">A plataforma é gratuita?</h3>
                            <p class="text-amber-700">
                                Sim! Oferecemos acesso gratuito a todo o conteúdo básico. Temos também planos premium com recursos adicionais.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-amber-800 mb-2">Como posso reportar um problema?</h3>
                            <p class="text-amber-700">
                                Você pode usar o formulário de contato acima ou enviar um e-mail diretamente para nossa equipe de suporte.
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