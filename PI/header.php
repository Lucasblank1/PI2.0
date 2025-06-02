<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';

// Buscar dados do usuário se estiver logado
$usuario = null;
if (isset($_SESSION['usuario_id'])) {
    $stmt = $conn->prepare("SELECT nome, email, foto_perfil FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<header class="bg-amber-800 text-white shadow-lg">
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="assets/images/nova_logo.jpeg" alt="Nova Logo" class="h-20 w-36 opacity-80 rounded-lg">
            </div>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="index.php" class="hover:text-amber-200 font-semibold">Início</a></li>
                    <li><a href="<?php echo isset($_SESSION['usuario_id']) ? 'jogos.php' : 'login.php?redirect=jogos'; ?>" class="hover:text-amber-200 font-semibold">Jogos</a></li>
                    <li><a href="index.php#sobre" class="hover:text-amber-200 font-semibold">Sobre</a></li>
                    <li><a href="index.php#contato" class="hover:text-amber-200 font-semibold">Contato</a></li>
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <li class="relative">
                            <button id="userMenuButton" class="flex items-center space-x-2 hover:text-amber-200 font-semibold">
                                <img src="<?php echo $usuario['foto_perfil'] ?: 'assets/images/default-avatar.png'; ?>" 
                                     alt="Foto de perfil" 
                                     class="w-8 h-8 rounded-full border-2 border-amber-200">
                                <span><?php echo htmlspecialchars($usuario['nome']); ?></span>
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                            <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden z-50">
                                <a href="perfil.php" class="block px-4 py-2 text-gray-800 hover:bg-amber-100">Meu Perfil</a>
                                <a href="dashboard.php" class="block px-4 py-2 text-gray-800 hover:bg-amber-100">Dashboard</a>
                                <a href="logout.php" class="block px-4 py-2 text-gray-800 hover:bg-amber-100">Sair</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li><a href="login.php" class="hover:text-amber-200 font-semibold">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenu = document.getElementById('userMenu');
    let isMenuOpen = false;

    userMenuButton.addEventListener('click', function(e) {
        e.stopPropagation();
        isMenuOpen = !isMenuOpen;
        userMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', function(e) {
        if (isMenuOpen && !userMenu.contains(e.target) && !userMenuButton.contains(e.target)) {
            isMenuOpen = false;
            userMenu.classList.add('hidden');
        }
    });
});
</script> 