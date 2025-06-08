<?php
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Caça aos fatos História</title>
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

    <!-- Recuperação de Senha Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-amber-700 text-white p-6">
                    <h2 class="text-2xl font-bold text-center">Recuperar Senha</h2>
                </div>
                <div class="p-6">
                    <?php if (isset($_GET['erro'])): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">
                                <?php
                                switch($_GET['erro']) {
                                    case 'email_nao_encontrado':
                                        echo "Este e-mail não está cadastrado em nosso sistema.";
                                        break;
                                    case 'email_invalido':
                                        echo "Por favor, insira um e-mail válido.";
                                        break;
                                    default:
                                        echo "Ocorreu um erro. Por favor, tente novamente.";
                                }
                                ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['sucesso'])): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">
                                Um e-mail foi enviado com instruções para recuperar sua senha.
                            </span>
                        </div>
                    <?php endif; ?>

                    <p class="text-gray-600 mb-6 text-center">
                        Digite seu e-mail cadastrado para receber o código de recuperação.
                    </p>
                    
                    <form action="processar-recuperacao.php" method="POST" class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                placeholder="seu@email.com">
                        </div>
                        
                        <div>
                            <button type="submit"
                                class="w-full bg-amber-700 hover:bg-amber-800 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
                                Enviar Código
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-6 text-center">
                        <p class="text-gray-600">
                            <a href="login.php" class="text-amber-700 hover:text-amber-800 font-semibold">
                                Voltar para o login
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-amber-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <div class="flex items-center">
                        <i class="fas fa-landmark text-3xl mr-2"></i>
                        <h3 class="text-2xl font-bold">Caça aos fatos História</h3>
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
                <p>&copy; 2024 Caça aos fatos História. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html> 