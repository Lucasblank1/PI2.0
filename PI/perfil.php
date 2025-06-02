<?php
require_once 'config/database.php';
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

// Buscar informações do usuário
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$usuario = $stmt->fetch();

// Buscar estatísticas do usuário
$stmt = $conn->prepare("
    SELECT 
        COUNT(*) as total_quizzes,
        AVG(pontuacao) as media_pontuacao,
        MAX(pontuacao) as maior_pontuacao,
        SUM(acertos) as total_acertos,
        SUM(erros) as total_erros
    FROM resultados_quiz 
    WHERE usuario_id = ?
");
$stmt->execute([$_SESSION['usuario_id']]);
$estatisticas = $stmt->fetch();

// Buscar histórico de quizzes
$stmt = $conn->prepare("
    SELECT 
        r.*,
        r.nivel as quiz_titulo
    FROM resultados_quiz r
    WHERE r.usuario_id = ?
    ORDER BY r.data_realizacao DESC
    LIMIT 5
");
$stmt->execute([$_SESSION['usuario_id']]);
$historico_quizzes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - GameLearn História</title>
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
        
        .profile-card {
            transition: all 0.3s ease;
        }
        
        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="min-h-screen hero-pattern">
    <?php include 'header.php'; ?>

    <!-- Profile Header -->
    <div class="bg-amber-700 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center mb-6 md:mb-0">
                    <div class="w-24 h-24 rounded-full bg-amber-600 flex items-center justify-center text-4xl text-white mr-6 overflow-hidden">
                        <?php 
                        $foto_path = '';
                        if (!empty($usuario['foto'])) {
                            $foto_path = 'uploads/fotos/' . $usuario['foto'];
                        } elseif (!empty($usuario['foto_perfil'])) {
                            $foto_path = $usuario['foto_perfil'];
                        }

                        if (!empty($foto_path) && file_exists($foto_path)):
                        ?>
                            <img src="<?php echo htmlspecialchars($foto_path); ?>" 
                                 alt="Foto de Perfil" 
                                 class="w-full h-full object-cover"
                                 onerror="this.onerror=null; this.src='assets/img/default-avatar.png';">
                        <?php 
                        else:
                            echo strtoupper(substr($usuario['nome'], 0, 1));
                        endif; 
                        ?>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold mb-2"><?php echo htmlspecialchars($usuario['nome']); ?></h1>
                        <p class="text-amber-100"><?php echo htmlspecialchars($usuario['email']); ?></p>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <a href="editar-perfil.php" class="bg-amber-600 hover:bg-amber-500 text-white px-6 py-2 rounded-lg transition-colors">
                        <i class="fas fa-edit mr-2"></i>Editar Perfil
                    </a>
                    <button onclick="confirmarExclusaoConta()" class="bg-red-600 hover:bg-red-500 text-white px-6 py-2 rounded-lg transition-colors">
                        <i class="fas fa-trash-alt mr-2"></i>Excluir Conta
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-amber-800 mb-6">Estatísticas</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-lg stat-card">
                    <div class="text-center">
                        <div class="inline-block bg-amber-600 text-white p-3 rounded-full mb-4">
                            <i class="fas fa-trophy text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-amber-800 mb-2">Total de Quizzes</h3>
                        <p class="text-3xl font-bold text-gray-700"><?php echo $estatisticas['total_quizzes']; ?></p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-lg stat-card">
                    <div class="text-center">
                        <div class="inline-block bg-amber-600 text-white p-3 rounded-full mb-4">
                            <i class="fas fa-star text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-amber-800 mb-2">Média de Pontuação</h3>
                        <p class="text-3xl font-bold text-gray-700"><?php echo number_format($estatisticas['media_pontuacao'], 1); ?></p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-lg stat-card">
                    <div class="text-center">
                        <div class="inline-block bg-amber-600 text-white p-3 rounded-full mb-4">
                            <i class="fas fa-check text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-amber-800 mb-2">Total de Acertos</h3>
                        <p class="text-3xl font-bold text-gray-700"><?php echo $estatisticas['total_acertos']; ?></p>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg stat-card">
                    <div class="text-center">
                        <div class="inline-block bg-amber-600 text-white p-3 rounded-full mb-4">
                            <i class="fas fa-times text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-amber-800 mb-2">Total de Erros</h3>
                        <p class="text-3xl font-bold text-gray-700"><?php echo $estatisticas['total_erros']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- History Section -->
    <section class="py-12 bg-amber-50">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-amber-800 mb-6">Histórico de Quizzes</h2>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-amber-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Nível</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Data</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Pontuação</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Acertos</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Erros</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Tempo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($historico_quizzes as $quiz): ?>
                        <tr class="hover:bg-amber-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900"><?php echo ucfirst($quiz['quiz_titulo']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo date('d/m/Y H:i', strtotime($quiz['data_realizacao'])); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900"><?php echo $quiz['pontuacao']; ?> pontos</td>
                            <td class="px-6 py-4 text-sm text-gray-900"><?php echo $quiz['acertos']; ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900"><?php echo $quiz['erros']; ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo $quiz['tempo_gasto']; ?> segundos</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <footer class="bg-amber-800 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 GameLearn - Todos os direitos reservados</p>
        </div>
    </footer>

    <script>
    function confirmarExclusaoConta() {
        if (confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.')) {
            window.location.href = 'excluir-conta.php';
        }
    }
    </script>
</body>
</html> 