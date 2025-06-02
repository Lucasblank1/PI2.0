<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : '';

// Array com as histórias
$historias = [
    'independencia' => [
        'titulo' => 'Independência do Brasil',
        'descricao' => 'O processo de independência do Brasil foi um dos momentos mais importantes da nossa história.',
        'conteudo' => [
            [
                'titulo' => 'Contexto Histórico',
                'texto' => 'No início do século XIX, o Brasil ainda era uma colônia de Portugal. A família real portuguesa, fugindo das tropas napoleônicas, transferiu-se para o Brasil em 1808, estabelecendo a sede do governo português no Rio de Janeiro.'
            ],
            [
                'titulo' => 'O Dia do Fico',
                'texto' => 'Em 9 de janeiro de 1822, D. Pedro I, então príncipe regente, declarou que ficaria no Brasil, contrariando as ordens das Cortes Portuguesas que exigiam seu retorno a Portugal. Este episódio ficou conhecido como "O Dia do Fico".'
            ],
            [
                'titulo' => 'O Grito do Ipiranga',
                'texto' => 'Em 7 de setembro de 1822, às margens do rio Ipiranga, em São Paulo, D. Pedro I proclamou a independência do Brasil, declarando: "Independência ou Morte!". Este momento histórico marcou o fim do domínio português sobre o Brasil.'
            ],
            [
                'titulo' => 'Consequências',
                'texto' => 'A independência do Brasil trouxe mudanças significativas na estrutura política e social do país. O Brasil se tornou uma monarquia independente, com D. Pedro I como seu primeiro imperador.'
            ]
        ]
    ],
    'republica' => [
        'titulo' => 'Proclamação da República',
        'descricao' => 'A proclamação da República em 1889 marcou o fim do período imperial no Brasil.',
        'conteudo' => [
            [
                'titulo' => 'Crise do Império',
                'texto' => 'O Império brasileiro enfrentava diversas crises, incluindo a abolição da escravidão em 1888, que desagradou os fazendeiros, e o descontentamento do Exército com a monarquia.'
            ],
            [
                'titulo' => 'O Golpe Militar',
                'texto' => 'Em 15 de novembro de 1889, um golpe militar liderado pelo Marechal Deodoro da Fonseca derrubou o governo imperial. O imperador D. Pedro II foi deposto e exilado.'
            ],
            [
                'titulo' => 'A Nova República',
                'texto' => 'Com a proclamação da República, o Brasil adotou um novo sistema de governo, com a separação entre os poderes Executivo, Legislativo e Judiciário.'
            ],
            [
                'titulo' => 'Primeiros Anos',
                'texto' => 'Os primeiros anos da República foram marcados por instabilidade política e conflitos entre diferentes grupos que disputavam o poder.'
            ]
        ]
    ],
    'vargas' => [
        'titulo' => 'Era Vargas',
        'descricao' => 'O período do governo de Getúlio Vargas foi um dos mais importantes da história do Brasil.',
        'conteudo' => [
            [
                'titulo' => 'Revolução de 1930',
                'texto' => 'Getúlio Vargas chegou ao poder através da Revolução de 1930, que derrubou a República Velha e iniciou um novo período na política brasileira.'
            ],
            [
                'titulo' => 'Estado Novo',
                'texto' => 'Em 1937, Vargas instaurou o Estado Novo, um regime autoritário que durou até 1945. Durante este período, foram implementadas diversas reformas sociais e trabalhistas.'
            ],
            [
                'titulo' => 'Legado',
                'texto' => 'O governo de Vargas deixou um importante legado, incluindo a criação da CLT, o voto feminino e diversas políticas de industrialização e modernização do país.'
            ],
            [
                'titulo' => 'Fim do Período',
                'texto' => 'O período Vargas terminou em 1954, com o suicídio do presidente, após uma grave crise política que envolvia acusações de corrupção e pressão militar.'
            ]
        ]
    ],
    'ditadura' => [
        'titulo' => 'Ditadura Militar',
        'descricao' => 'O período da ditadura militar no Brasil foi marcado por repressão e transformações sociais.',
        'conteudo' => [
            [
                'titulo' => 'Golpe de 1964',
                'texto' => 'Em 31 de março de 1964, um golpe militar derrubou o presidente João Goulart, iniciando um período de 21 anos de regime militar no Brasil.'
            ],
            [
                'titulo' => 'Anos de Chumbo',
                'texto' => 'O período mais repressivo da ditadura, conhecido como "Anos de Chumbo", foi marcado por censura, tortura e perseguição política.'
            ],
            [
                'titulo' => 'Abertura Política',
                'texto' => 'A partir de 1979, iniciou-se um processo de abertura política, com a anistia aos presos políticos e a restauração gradual da democracia.'
            ],
            [
                'titulo' => 'Fim da Ditadura',
                'texto' => 'A ditadura militar terminou em 1985, com a eleição indireta de Tancredo Neves, marcando o início da Nova República e o retorno à democracia.'
            ]
        ]
    ]
];

$historia = isset($historias[$periodo]) ? $historias[$periodo] : null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $historia ? $historia['titulo'] . ' - ' : ''; ?>GameLearn História</title>
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

    <?php if ($historia): ?>
        <!-- Header Section -->
        <div class="bg-amber-700 text-white py-12">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl font-bold mb-4"><?php echo $historia['titulo']; ?></h1>
                <p class="text-xl"><?php echo $historia['descricao']; ?></p>
            </div>
        </div>

        <!-- Story Section -->
        <section class="py-12">
            <div class="container mx-auto px-4">
                <div class="max-w-3xl mx-auto">
                    <?php foreach ($historia['conteudo'] as $index => $parte): ?>
                        <div class="bg-amber-100 rounded-xl p-8 shadow-lg story-card mb-8">
                            <h2 class="text-2xl font-bold text-amber-800 mb-4"><?php echo $parte['titulo']; ?></h2>
                            <p class="text-amber-700"><?php echo $parte['texto']; ?></p>
                        </div>
                    <?php endforeach; ?>

                    <div class="flex justify-between mt-8">
                        <a href="historia-interativa.php" class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-6 rounded-lg">
                            <i class="fas fa-arrow-left mr-2"></i>Voltar
                        </a>
                        <a href="selecionar-nivel.php" class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-6 rounded-lg">
                            Fazer Quiz<i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php else: ?>
        <!-- Error Section -->
        <div class="bg-amber-700 text-white py-12">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl font-bold mb-4">História não encontrada</h1>
                <p class="text-xl">A história solicitada não existe.</p>
            </div>
        </div>

        <section class="py-12">
            <div class="container mx-auto px-4">
                <div class="max-w-3xl mx-auto text-center">
                    <a href="historia-interativa.php" class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-6 rounded-lg">
                        <i class="fas fa-arrow-left mr-2"></i>Voltar para Histórias
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <footer class="bg-amber-800 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 GameLearn - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html> 