<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : '';

// Array de perguntas por nível
$perguntas = [
    'facil' => [
        [
            'pergunta' => 'O Brasil foi descoberto em 1500?',
            'opcoes' => ['Verdadeiro', 'Falso'],
            'resposta' => 'Verdadeiro'
        ],
        [
            'pergunta' => 'A independência do Brasil foi proclamada em 1822?',
            'opcoes' => ['Verdadeiro', 'Falso'],
            'resposta' => 'Verdadeiro'
        ],
        [
            'pergunta' => 'A capital do Brasil é Brasília?',
            'opcoes' => ['Verdadeiro', 'Falso'],
            'resposta' => 'Verdadeiro'
        ]
    ],
    'medio' => [
        [
            'pergunta' => 'Qual foi o primeiro presidente do Brasil?',
            'opcoes' => ['Deodoro da Fonseca', 'Floriano Peixoto', 'Prudente de Morais', 'Campos Sales'],
            'resposta' => 'Deodoro da Fonseca'
        ],
        [
            'pergunta' => 'Em que ano foi assinada a Lei Áurea?',
            'opcoes' => ['1888', '1889', '1887', '1890'],
            'resposta' => '1888'
        ],
        [
            'pergunta' => 'Qual foi o primeiro nome do Brasil?',
            'opcoes' => ['Terra de Vera Cruz', 'Terra de Santa Cruz', 'Ilha de Vera Cruz', 'Terra do Brasil'],
            'resposta' => 'Terra de Vera Cruz'
        ]
    ],
    'dificil' => [
        [
            'pergunta' => 'Qual foi o primeiro presidente eleito democraticamente após o regime militar?',
            'opcoes' => ['Fernando Collor de Mello', 'José Sarney', 'Tancredo Neves', 'Itamar Franco'],
            'resposta' => 'Fernando Collor de Mello'
        ],
        [
            'pergunta' => 'Em que ano foi promulgada a primeira Constituição do Brasil?',
            'opcoes' => ['1824', '1822', '1823', '1825'],
            'resposta' => '1824'
        ],
        [
            'pergunta' => 'Qual foi o primeiro partido político brasileiro?',
            'opcoes' => ['Partido Liberal', 'Partido Conservador', 'Partido Republicano', 'Partido Socialista'],
            'resposta' => 'Partido Liberal'
        ]
    ]
];

// Verifica se o nível existe
if (!isset($perguntas[$nivel])) {
    header("Location: selecionar-nivel.php");
    exit();
}

$perguntas_nivel = $perguntas[$nivel];
$total_perguntas = count($perguntas_nivel);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Caça aos fatos História</title>
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
        
        .question-card {
            transition: all 0.3s ease;
        }
        
        .question-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .option-button {
            transition: all 0.3s ease;
        }

        .option-button:hover {
            transform: translateY(-2px);
        }

        .option-button.selected {
            background-color: #d97706;
            color: white;
        }

        .option-button.correct {
            background-color: #059669;
            color: white;
        }

        .option-button.incorrect {
            background-color: #dc2626;
            color: white;
        }
    </style>
</head>
<body class="min-h-screen hero-pattern">
    <?php include 'header.php'; ?>

    <!-- Header Section -->
    <div class="bg-amber-700 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Quiz Histórico</h1>
            <p class="text-xl">Nível: <?php echo ucfirst($nivel); ?></p>
        </div>
    </div>

    <!-- Quiz Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <?php if (!empty($perguntas_nivel)): ?>
                <div class="max-w-3xl mx-auto">
                    <div class="bg-amber-100 rounded-xl p-8 shadow-lg question-card">
                        <div class="flex justify-between items-center mb-6">
                            <div class="text-amber-800 font-bold">
                                Pergunta <span id="pergunta-atual">1</span> de <?php echo $total_perguntas; ?>
                            </div>
                            <div class="text-amber-800 font-bold">
                                Tempo: <span id="tempo">30</span>s
                            </div>
                        </div>

                        <div id="pergunta-container">
                            <h2 class="text-2xl font-bold text-amber-800 mb-6" id="pergunta-texto"></h2>
                            <div class="grid grid-cols-1 gap-4" id="opcoes-container"></div>
                        </div>

                        <div class="flex justify-between mt-8">
                            <button id="btn-anterior" class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                <i class="fas fa-arrow-left mr-2"></i>Anterior
                            </button>
                            <button id="btn-proximo" class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg">
                                Próxima<i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    const perguntas = <?php echo json_encode($perguntas_nivel); ?>;
                    let perguntaAtual = 0;
                    let respostas = new Array(perguntas.length).fill(null);
                    let tempoRestante = <?php echo $nivel === 'dificil' ? 30 : 0; ?>;
                    let timer;
                    let acertos = 0;
                    let erros = 0;

                    function atualizarPergunta() {
                        const pergunta = perguntas[perguntaAtual];
                        document.getElementById('pergunta-atual').textContent = perguntaAtual + 1;
                        document.getElementById('pergunta-texto').textContent = pergunta.pergunta;

                        const opcoesContainer = document.getElementById('opcoes-container');
                        opcoesContainer.innerHTML = '';

                        pergunta.opcoes.forEach((opcao, index) => {
                            const button = document.createElement('button');
                            button.className = 'option-button w-full text-left p-4 rounded-lg bg-white hover:bg-amber-200 transition duration-300';
                            button.textContent = opcao;
                            button.onclick = () => selecionarOpcao(index);
                            opcoesContainer.appendChild(button);
                        });

                        // Restaurar resposta anterior se existir
                        if (respostas[perguntaAtual] !== null) {
                            const opcoes = opcoesContainer.getElementsByClassName('option-button');
                            opcoes[respostas[perguntaAtual]].classList.add('selected');
                        }

                        // Atualizar botões de navegação
                        document.getElementById('btn-anterior').disabled = perguntaAtual === 0;
                        document.getElementById('btn-proximo').textContent = 
                            perguntaAtual === perguntas.length - 1 ? 'Finalizar' : 'Próxima';

                        // Iniciar timer apenas para nível difícil
                        if ('<?php echo $nivel; ?>' === 'dificil') {
                            iniciarTimer();
                        } else {
                            document.getElementById('tempo').textContent = '--';
                        }
                    }

                    function iniciarTimer() {
                        clearInterval(timer);
                        tempoRestante = 30;
                        document.getElementById('tempo').textContent = tempoRestante;
                        
                        timer = setInterval(() => {
                            tempoRestante--;
                            document.getElementById('tempo').textContent = tempoRestante;
                            
                            if (tempoRestante <= 0) {
                                clearInterval(timer);
                                // Marcar como erro se o tempo acabar
                                erros++;
                                proximaPergunta();
                            }
                        }, 1000);
                    }

                    function selecionarOpcao(index) {
                        const opcoes = document.getElementsByClassName('option-button');
                        for (let opcao of opcoes) {
                            opcao.classList.remove('selected');
                        }
                        opcoes[index].classList.add('selected');
                        respostas[perguntaAtual] = index;

                        // Verificar resposta
                        const pergunta = perguntas[perguntaAtual];
                        const respostaCorreta = pergunta.opcoes.indexOf(pergunta.resposta);
                        
                        if (index === respostaCorreta) {
                            acertos++;
                        } else {
                            erros++;
                        }

                        // Se for nível difícil, parar o timer
                        if ('<?php echo $nivel; ?>' === 'dificil') {
                            clearInterval(timer);
                        }
                    }

                    function proximaPergunta() {
                        if (perguntaAtual < perguntas.length - 1) {
                            perguntaAtual++;
                            atualizarPergunta();
                        } else {
                            finalizarQuiz();
                        }
                    }

                    function finalizarQuiz() {
                        // Prepara os dados para envio
                        const dados = {
                            nivel: '<?php echo $nivel; ?>',
                            acertos: acertos,
                            erros: erros,
                            tempo_gasto: '<?php echo $nivel; ?>' === 'dificil' ? 30 - tempoRestante : 0
                        };

                        console.log('Enviando dados:', dados);

                        // Salvar resultados no banco de dados
                        fetch('salvar_resultado_quiz.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(dados)
                        })
                        .then(response => {
                            console.log('Resposta recebida:', response);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Dados processados:', data);
                            if (data.success) {
                                window.location.href = 'resultado_quiz.php?nivel=<?php echo $nivel; ?>&acertos=' + acertos + '&erros=' + erros;
                            } else {
                                alert('Erro ao salvar resultado: ' + (data.message || 'Erro desconhecido'));
                            }
                        })
                        .catch(error => {
                            console.error('Erro na requisição:', error);
                            alert('Erro ao salvar resultado. Por favor, tente novamente.');
                        });
                    }

                    // Inicializar o quiz
                    atualizarPergunta();

                    // Event listeners para os botões
                    document.getElementById('btn-anterior').addEventListener('click', () => {
                        if (perguntaAtual > 0) {
                            perguntaAtual--;
                            atualizarPergunta();
                        }
                    });

                    document.getElementById('btn-proximo').addEventListener('click', () => {
                        if (respostas[perguntaAtual] !== null) {
                            proximaPergunta();
                        } else {
                            alert('Por favor, selecione uma resposta antes de continuar.');
                        }
                    });
                </script>
            <?php else: ?>
                <div class="max-w-3xl mx-auto text-center">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Erro!</strong>
                        <span class="block sm:inline">Nível de dificuldade inválido.</span>
                    </div>
                    <a href="selecionar-nivel.php" class="inline-block mt-4 bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-6 rounded-lg">
                        <i class="fas fa-arrow-left mr-2"></i>Voltar
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="bg-amber-800 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Caça aos fatos - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html> 