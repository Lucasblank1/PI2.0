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

$mensagem = '';
$tipo_mensagem = '';

// Processar o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Iniciar transação
        $conn->beginTransaction();

        // Atualizar nome e email
        $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
        $stmt->execute([
            $_POST['nome'],
            $_POST['email'],
            $_SESSION['usuario_id']
        ]);

        // Atualizar senha se fornecida
        if (!empty($_POST['nova_senha'])) {
            if ($_POST['nova_senha'] === $_POST['confirmar_senha']) {
                $senha_hash = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
                $stmt->execute([$senha_hash, $_SESSION['usuario_id']]);
            } else {
                throw new Exception("As senhas não coincidem!");
            }
        }

        // Processar upload de foto
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            error_log("Iniciando upload de foto");
            error_log("Dados do arquivo: " . print_r($_FILES['foto'], true));
            
            $foto = $_FILES['foto'];
            $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
            $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($extensao, $extensoes_permitidas)) {
                throw new Exception("Tipo de arquivo não permitido. Use apenas: " . implode(', ', $extensoes_permitidas));
            }

            if ($foto['size'] > 5 * 1024 * 1024) { // 5MB
                throw new Exception("A foto deve ter no máximo 5MB");
            }

            $nome_arquivo = 'perfil_' . $_SESSION['usuario_id'] . '_' . time() . '.' . $extensao;
            $diretorio = 'uploads/perfil/';
            $caminho_completo = $diretorio . $nome_arquivo;

            error_log("Caminho do arquivo: " . $caminho_completo);

            // Criar diretório se não existir
            if (!file_exists($diretorio)) {
                error_log("Criando diretório: " . $diretorio);
                if (!mkdir($diretorio, 0777, true)) {
                    error_log("Erro ao criar diretório: " . error_get_last()['message']);
                    throw new Exception("Erro ao criar diretório de uploads");
                }
            }

            // Verificar permissões do diretório
            if (!is_writable($diretorio)) {
                error_log("Diretório não tem permissão de escrita: " . $diretorio);
                throw new Exception("Diretório de uploads não tem permissão de escrita");
            }

            // Remover todas as fotos antigas do usuário
            $padrao = $diretorio . 'perfil_' . $_SESSION['usuario_id'] . '_*';
            foreach (glob($padrao) as $foto_antiga) {
                error_log("Removendo foto antiga: " . $foto_antiga);
                if (file_exists($foto_antiga)) {
                    if (!unlink($foto_antiga)) {
                        error_log("Erro ao remover foto antiga: " . error_get_last()['message']);
                    } else {
                        error_log("Foto antiga removida com sucesso: " . $foto_antiga);
                    }
                }
            }

            // Tentar fazer o upload
            error_log("Tentando mover arquivo para: " . $caminho_completo);
            if (!move_uploaded_file($foto['tmp_name'], $caminho_completo)) {
                error_log("Erro no upload: " . print_r(error_get_last(), true));
                throw new Exception("Erro ao fazer upload da foto. Verifique as permissões do diretório.");
            }

            // Verificar se o arquivo foi realmente criado
            if (!file_exists($caminho_completo)) {
                error_log("Arquivo não encontrado após upload: " . $caminho_completo);
                throw new Exception("Arquivo não foi criado após o upload");
            }

            error_log("Arquivo criado com sucesso. Tamanho: " . filesize($caminho_completo));

            // Atualizar caminho da foto no banco
            $stmt = $conn->prepare("UPDATE usuarios SET foto_perfil = ? WHERE id = ?");
            if (!$stmt->execute([$caminho_completo, $_SESSION['usuario_id']])) {
                error_log("Erro ao atualizar foto no banco: " . print_r($stmt->errorInfo(), true));
                throw new Exception("Erro ao salvar informações da foto no banco de dados");
            }

            error_log("Foto atualizada com sucesso no banco: " . $caminho_completo);

            // Atualizar dados do usuário após o upload
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$_SESSION['usuario_id']]);
            $usuario = $stmt->fetch();
            error_log("Dados do usuário após atualização: " . print_r($usuario, true));

            // Limpar cache do navegador
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
        } else {
            error_log("Nenhum arquivo enviado ou erro no upload: " . print_r($_FILES['foto'] ?? 'Arquivo não definido', true));
        }

        // Confirmar transação
        $conn->commit();
        $mensagem = "Perfil atualizado com sucesso!";
        $tipo_mensagem = "success";

    } catch (Exception $e) {
        // Reverter transação em caso de erro
        $conn->rollBack();
        $mensagem = "Erro ao atualizar perfil: " . $e->getMessage();
        $tipo_mensagem = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - Caça aos fatos História</title>
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

        .foto-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #d97706;
        }
    </style>
</head>
<body class="min-h-screen hero-pattern">
    <?php include 'header.php'; ?>

    <!-- Header Section -->
    <div class="bg-amber-700 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Editar Perfil</h1>
            <p class="text-xl">Atualize suas informações pessoais</p>
        </div>
    </div>

    <!-- Edit Profile Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <?php if ($mensagem): ?>
                <div class="max-w-2xl mx-auto mb-6 p-4 rounded-lg <?php echo $tipo_mensagem === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                    <?php echo $mensagem; ?>
                </div>
            <?php endif; ?>

            <div class="max-w-2xl mx-auto">
                <form action="" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl p-8 shadow-lg profile-card">
                    <!-- Foto de Perfil -->
                    <div class="mb-8 text-center">
                        <div class="relative inline-block">
                            <img src="<?php echo !empty($usuario['foto_perfil']) ? $usuario['foto_perfil'] : 'assets/img/default-avatar.png'; ?>" 
                                 alt="Foto de Perfil" 
                                 class="foto-preview mb-4"
                                 id="foto-preview">
                            <label for="foto" class="absolute bottom-0 right-0 bg-amber-600 text-white p-2 rounded-full cursor-pointer hover:bg-amber-700">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" 
                                   name="foto" 
                                   id="foto" 
                                   accept="image/*" 
                                   class="hidden"
                                   onchange="previewFoto(this)">
                        </div>
                        <p class="text-sm text-gray-600">Clique no ícone da câmera para alterar sua foto</p>
                        <p class="text-xs text-gray-500 mt-1">Formatos aceitos: JPG, JPEG, PNG, GIF (máx. 5MB)</p>
                    </div>

                    <!-- Informações Pessoais -->
                    <div class="space-y-6">
                        <div>
                            <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome</label>
                            <input type="text" 
                                   name="nome" 
                                   id="nome" 
                                   value="<?php echo htmlspecialchars($usuario['nome']); ?>" 
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                   required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="<?php echo htmlspecialchars($usuario['email']); ?>" 
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                   required>
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Alterar Senha</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="nova_senha" class="block text-sm font-medium text-gray-700 mb-2">Nova Senha</label>
                                    <input type="password" 
                                           name="nova_senha" 
                                           id="nova_senha" 
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                           minlength="6">
                                </div>

                                <div>
                                    <label for="confirmar_senha" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nova Senha</label>
                                    <input type="password" 
                                           name="confirmar_senha" 
                                           id="confirmar_senha" 
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                           minlength="6">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="perfil.php" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-2 rounded-lg transition-colors">
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <footer class="bg-amber-800 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Caça aos fatos - Todos os direitos reservados</p>
        </div>
    </footer>

    <script>
    function previewFoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('foto-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</body>
</html> 