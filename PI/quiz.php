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
            'pergunta' => 'Em que ano ocorreu o Descobrimento do Brasil?',
            'opcoes' => ['1500', '1492', '1502', '1498'],
            'resposta' => '1500'
        ],
        [
            'pergunta' => 'Quem liderou a frota que descobriu o Brasil?',
            'opcoes' => ['Pedro Álvares Cabral', 'Cristóvão Colombo', 'Vasco da Gama', 'Bartolomeu Dias'],
            'resposta' => 'Pedro Álvares Cabral'
        ],
        [
            'pergunta' => 'Qual foi a primeira capital do Brasil Colonial?',
            'opcoes' => ['Salvador', 'Rio de Janeiro', 'São Paulo', 'Recife'],
            'resposta' => 'Salvador'
        ],
        [
            'pergunta' => 'Qual era o nome do escrivão que registrou o Descobrimento do Brasil?',
            'opcoes' => ['Pero Vaz de Caminha', 'Gaspar de Lemos', 'Bartolomeu Dias', 'Duarte Pacheco'],
            'resposta' => 'Pero Vaz de Caminha'
        ],
        [
            'pergunta' => 'Em que estado brasileiro ocorreu o primeiro desembarque dos portugueses?',
            'opcoes' => ['Bahia', 'Rio de Janeiro', 'São Paulo', 'Pernambuco'],
            'resposta' => 'Bahia'
        ]
    ],
    'medio' => [
        [
            'pergunta' => 'Qual foi o principal produto explorado no início do Período Colonial?',
            'opcoes' => ['Pau-brasil', 'Açúcar', 'Ouro', 'Café'],
            'resposta' => 'Pau-brasil'
        ],
        [
            'pergunta' => 'Em que ano ocorreu a Inconfidência Mineira?',
            'opcoes' => ['1789', '1792', '1788', '1790'],
            'resposta' => '1789'
        ],
        [
            'pergunta' => 'Qual era o objetivo principal dos inconfidentes?',
            'opcoes' => ['Criar uma república independente', 'Reduzir impostos', 'Melhorar a mineração', 'Aumentar o comércio'],
            'resposta' => 'Criar uma república independente'
        ],
        [
            'pergunta' => 'Qual foi o sistema de governo estabelecido no Brasil em 1549?',
            'opcoes' => ['Governo-Geral', 'Capitanias Hereditárias', 'Vice-Reino', 'Conselho Ultramarino'],
            'resposta' => 'Governo-Geral'
        ],
        [
            'pergunta' => 'Qual era o nome do líder mais conhecido da Inconfidência Mineira?',
            'opcoes' => ['Tiradentes', 'Tomás Antônio Gonzaga', 'Cláudio Manuel da Costa', 'Alvarenga Peixoto'],
            'resposta' => 'Tiradentes'
        ]
    ],
    'dificil' => [
        [
            'pergunta' => 'Qual tratado garantiu a Portugal a posse das terras brasileiras?',
            'opcoes' => ['Tratado de Tordesilhas', 'Tratado de Madri', 'Tratado de Utrecht', 'Tratado de Paris'],
            'resposta' => 'Tratado de Tordesilhas'
        ],
        [
            'pergunta' => 'Quem delatou os inconfidentes para a Coroa Portuguesa?',
            'opcoes' => ['Joaquim Silvério dos Reis', 'Tomás Antônio Gonzaga', 'Cláudio Manuel da Costa', 'Alvarenga Peixoto'],
            'resposta' => 'Joaquim Silvério dos Reis'
        ],
        [
            'pergunta' => 'Qual foi o sistema econômico predominante no Brasil Colonial?',
            'opcoes' => ['Plantação', 'Mercantilismo', 'Feudalismo', 'Capitalismo'],
            'resposta' => 'Plantation'
        ],
        [
            'pergunta' => 'Qual era o nome do quilombo que resistiu por quase 100 anos durante o período colonial?',
            'opcoes' => ['Palmares', 'Quilombo do Ambrósio', 'Quilombo do Campo Grande', 'Quilombo do Piolho'],
            'resposta' => 'Palmares'
        ],
        [
            'pergunta' => 'Qual era o nome do imposto que causou grande revolta entre os mineradores e contribuiu para a Inconfidência Mineira?',
            'opcoes' => ['Derrama', 'Quinto', 'Dízimo', 'Sisa'],
            'resposta' => 'Derrama'
        ]
    ]
];

// Array de perguntas extras para cada nível
$perguntas_extras = [
    'facil' => [
        [
            'pergunta' => 'Qual era o nome do navio principal da frota de Cabral?',
            'opcoes' => ['Nau Capitânia', 'Santa Maria', 'São Gabriel', 'São Rafael'],
            'resposta' => 'Nau Capitânia'
        ],
        [
            'pergunta' => 'Qual foi o primeiro nome dado ao Brasil?',
            'opcoes' => ['Terra de Vera Cruz', 'Terra de Santa Cruz', 'Ilha de Vera Cruz', 'Terra do Brasil'],
            'resposta' => 'Terra de Vera Cruz'
        ],
        [
            'pergunta' => 'Qual era a principal atividade dos indígenas quando os portugueses chegaram?',
            'opcoes' => ['Agricultura', 'Mineração', 'Comércio', 'Pecuária'],
            'resposta' => 'Agricultura'
        ]
    ],
    'medio' => [
        [
            'pergunta' => 'Qual era o nome do primeiro governador-geral do Brasil?',
            'opcoes' => ['Tomé de Sousa', 'Duarte da Costa', 'Mem de Sá', 'Francisco de Sousa'],
            'resposta' => 'Tomé de Sousa'
        ],
        [
            'pergunta' => 'Qual era o nome do líder do Quilombo dos Palmares?',
            'opcoes' => ['Zumbi', 'Ganga Zumba', 'Dandara', 'Acotirene'],
            'resposta' => 'Zumbi'
        ],
        [
            'pergunta' => 'Qual era o nome do poeta inconfidente que escreveu "Marília de Dirceu"?',
            'opcoes' => ['Tomás Antônio Gonzaga', 'Cláudio Manuel da Costa', 'Alvarenga Peixoto', 'Inácio José de Alvarenga'],
            'resposta' => 'Tomás Antônio Gonzaga'
        ]
    ],
    'dificil' => [
        [
            'pergunta' => 'Qual era o nome do tratado que redefiniu as fronteiras do Brasil em 1750?',
            'opcoes' => ['Tratado de Madri', 'Tratado de Tordesilhas', 'Tratado de Utrecht', 'Tratado de Santo Ildefonso'],
            'resposta' => 'Tratado de Madri'
        ],
        [
            'pergunta' => 'Qual era o nome do sistema de capitanias que antecedeu o Governo-Geral?',
            'opcoes' => ['Capitanias Hereditárias', 'Capitanias Gerais', 'Capitanias Reais', 'Capitanias Provinciais'],
            'resposta' => 'Capitanias Hereditárias'
        ],
        [
            'pergunta' => 'Qual era o nome do imposto que cobrava 20% de todo o ouro extraído?',
            'opcoes' => ['Quinto', 'Dízimo', 'Sisa', 'Derrama'],
            'resposta' => 'Quinto'
        ]
    ]
];

// Função para selecionar perguntas aleatórias
function selecionarPerguntasAleatorias($perguntas_base, $perguntas_extras, $quantidade = 5) {
    $todas_perguntas = array_merge($perguntas_base, $perguntas_extras);
    shuffle($todas_perguntas);
    return array_slice($todas_perguntas, 0, $quantidade);
}

// Seleciona 5 perguntas aleatórias para o nível atual
$perguntas_nivel = selecionarPerguntasAleatorias($perguntas[$nivel], $perguntas_extras[$nivel]);

// Verifica se o nível existe
if (!isset($perguntas[$nivel])) {
    header("Location: selecionar-nivel.php");
    exit();
}

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
            animation: flash-green 0.5s;
        }

        .option-button.incorrect {
            background-color: #dc2626;
            color: white;
            animation: flash-red 0.5s;
        }

        @keyframes flash-green {
            0% { background-color: #059669; }
            50% { background-color: #10b981; }
            100% { background-color: #059669; }
        }

        @keyframes flash-red {
            0% { background-color: #dc2626; }
            50% { background-color: #ef4444; }
            100% { background-color: #dc2626; }
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
                    let pontos = 0;

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
                            opcao.classList.remove('selected', 'correct', 'incorrect');
                        }
                        
                        const pergunta = perguntas[perguntaAtual];
                        const respostaCorreta = pergunta.opcoes.indexOf(pergunta.resposta);
                        
                        opcoes[index].classList.add('selected');
                        respostas[perguntaAtual] = index;
                        
                        if (index === respostaCorreta) {
                            opcoes[index].classList.add('correct');
                            acertos++;
                            pontos += 10; // Adiciona 10 pontos para resposta correta
                        } else {
                            opcoes[index].classList.add('incorrect');
                            opcoes[respostaCorreta].classList.add('correct');
                            erros++;
                        }

                        // Desabilita todas as opções após a seleção
                        for (let opcao of opcoes) {
                            opcao.disabled = true;
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
                            tempo_gasto: '<?php echo $nivel; ?>' === 'dificil' ? 30 - tempoRestante : 0,
                            pontos: pontos
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
                                window.location.href = 'resultado_quiz.php?nivel=<?php echo $nivel; ?>&acertos=' + acertos + '&erros=' + erros + '&pontos=' + pontos;
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
