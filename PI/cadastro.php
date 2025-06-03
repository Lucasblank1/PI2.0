<?php
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Caça aos fatos História</title>
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
        
        .requirements {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .requirements ul {
            list-style-type: none;
            padding-left: 0;
        }
        
        .requirements li {
            margin-bottom: 8px;
            color: #4a5568;
        }
        
        .requirements li:before {
            content: "•";
            color: #b45309;
            font-weight: bold;
            margin-right: 8px;
        }
        
        .error-message {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="min-h-screen hero-pattern">
    <?php include 'header.php'; ?>

    <!-- Header Section -->
    <div class="bg-amber-700 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Criar Nova Conta</h1>
            <p class="text-xl">Junte-se ao Caça aos fatos e comece sua jornada de aprendizado</p>
        </div>
    </div>

    <main class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
            <?php if (isset($_GET['erro'])): ?>
                <div class="error-message">
                    <?php
                    switch($_GET['erro']) {
                        case 'campos_vazios':
                            echo "Por favor, preencha todos os campos.";
                            break;
                        case 'email_invalido':
                            echo "O email deve conter o símbolo @.";
                            break;
                        case 'senhas_diferentes':
                            echo "As senhas não coincidem.";
                            break;
                        case 'senha_fraca':
                            echo "A senha deve ter pelo menos 6 caracteres e conter letras e números.";
                            break;
                        case 'email_existe':
                            echo "Este email já está cadastrado.";
                            break;
                        case 'sistema':
                            echo "Erro no sistema. Por favor, tente novamente.";
                            break;
                    }
                    ?>
                </div>
            <?php endif; ?>

            <div class="requirements">
                <h4 class="text-lg font-bold mb-3 text-amber-800">Requisitos para cadastro:</h4>
                <ul>
                    <li>Nome completo é obrigatório</li>
                    <li>Email deve conter o símbolo @</li>
                    <li>Senha deve ter no mínimo 6 caracteres</li>
                    <li>Senha deve conter letras e números</li>
                    <li>As senhas devem ser idênticas</li>
                </ul>
            </div>

            <form action="processar-cadastro.php" method="POST" class="space-y-4">
                <div class="form-group">
                    <input type="text" name="nome" placeholder="Nome completo" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="E-mail" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
                <div class="form-group">
                    <input type="password" name="senha" placeholder="Senha" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
                <div class="form-group">
                    <input type="password" name="confirmar_senha" placeholder="Confirmar senha" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
                <div class="form-group">
                    <button type="submit" 
                            class="w-full bg-amber-600 text-white py-2 px-4 rounded-lg hover:bg-amber-700 transition duration-300">
                        Cadastrar
                    </button>
                </div>
            </form>
            <div class="text-center mt-6">
                <p class="text-gray-600">Já tem uma conta? 
                    <a href="index.php" class="text-amber-600 hover:text-amber-700 font-semibold">Faça login</a>
                </p>
            </div>
        </div>
    </main>

    <footer class="bg-amber-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Caça aos fatos - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html> 