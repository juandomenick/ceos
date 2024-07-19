<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sidebar Items
    |--------------------------------------------------------------------------
    |
    | Itens do sidebar do dashboard.
    |
    */

    'sidebar_items' => [
        [
            'title' => 'Usuários',
            'role' => 'administrador|professor|diretor|coordenador',
            'icon' => 'fas fa-users-cog',
            'subitems' => [
                [
                    'title' => 'Diretores',
                    'icon' => 'fas fa-user-tie',
                    'route' => 'diretores.index',
                    'role' => 'administrador'
                ],
                [
                    'title' => 'Coordenadores',
                    'icon' => 'fas fa-user-tag',
                    'route' => 'coordenadores.index',
                    'role' => 'administrador|diretor'
                ],
                [
                    'title' => 'Professores',
                    'icon' => 'fas fa-graduation-cap',
                    'route' => 'professores.index',
                    'role' => 'administrador|diretor|coordenador'
                ],
                [
                    'title' => 'Alunos',
                    'icon' => 'fas fa-user',
                    'route' => 'alunos.index'
                ]
            ]
        ],
        [
            'title' => 'Acadêmico',
            'role' => 'administrador|diretor|coordenador|professor|aluno',
            'icon' => 'fas fa-school',
            'subitems' => [
                [
                    'title' => 'Instituições',
                    'icon' => 'fas fa-university',
                    'route' => 'instituicoes.index',
                    'role' => 'administrador|diretor'
                ],
                [
                    'title' => 'Cursos',
                    'icon' => 'fas fa-sitemap',
                    'route' => 'cursos.index',
                    'role' => 'administrador|diretor|coordenador'
                ],
                [
                    'title' => 'Disciplinas',
                    'icon' => 'fas fa-code-branch',
                    'route' => 'disciplinas.index',
                    'role' => 'administrador|diretor|coordenador|professor'
                ],
                [
                    'title' => 'Turmas',
                    'icon' => 'fas fa-chalkboard-teacher',
                    'route' => 'turmas.index',
                    'role' => 'administrador|diretor|coordenador|professor|aluno'
                ],
                [
                    'title' => 'Ingressar em Turma',
                    'icon' => 'fas fa-sign-in-alt',
                    'route' => 'turmas.ingresso.index',
                    'role' => 'aluno'
                ],
                [
                    'title' => 'Equipes',
                    'icon' => 'fas fa-users',
                    'route' => 'equipes.index',
                    'role' => 'administrador|diretor|coordenador|professor'
                ],
                [
                    'title' => 'Competências',
                    'icon' => 'fas fa-network-wired',
                    'route' => 'competencias.index',
                    'role' => 'administrador|diretor|coordenador|professor'
                ],
                [
                    'title' => 'Habilidades',
                    'icon' => 'fab fa-stack-overflow',
                    'route' => 'habilidades.index',
                    'role' => 'administrador|diretor|coordenador|professor'
                ],
                [
                    'title' => 'Questões',
                    'icon' => 'fas fa-question',
                    'route' => 'questoes.index',
                    'role' => 'administrador|diretor|coordenador|professor'
                ],
                [
                    'title' => 'Atividades',
                    'icon' => 'fas fa-edit',
                    'route' => 'atividades.index',
                    'role' => 'administrador|diretor|coordenador|professor'
                ],
                [
                    'title' => 'Perguntas de Humor',
                    'icon' => 'fab fa-weixin',
                    'route' => 'home',
                    'role' => 'professor'
                ],
                [
                    'title' => 'Anotações de Aula',
                    'icon' => 'fas fa-tasks',
                    'route' => 'anotacoes-aula.index',
                    'role' => 'professor'
                ],
                [
                    'title' => 'Fotos da Lousa',
                    'icon' => 'fas fa-chalkboard',
                    'route' => 'home',
                    'role' => 'professor'
                ]
            ]
        ],
        [
            'title' => 'Geral',
            'role' => 'administrador|professor',
            'icon' => 'fas fa-cogs',
            'subitems' => [
                [
                    'title' => 'Termo de Aceite',
                    'icon' => 'fas fa-scroll',
                    'route' => 'termos-aceite.index'
                ]
            ]
        ],
        [
            'title' => 'Notícias',
            'role' => 'administrador|professor|aluno',
            'icon' => 'fas fa-newspaper',
            'subitems' => [
                [
                    'title' => 'Minhas Notícias',
                    'icon' => 'fas fa-question-circle',
                    'route' => 'home',
                ],
                [
                    'title' => 'Todas Notícias',
                    'icon' => 'fas fa-list-alt',
                    'route' => 'home',
                    'role' => 'professor|aluno',
                ]
            ]
        ],
        [
            'title' => 'Jogos',
            'role' => 'professor|aluno',
            'icon' => 'fas fa-gamepad',
            'subitems' => [
                [
                    'title' => 'Carta',
                    'icon' => 'fas fa-address-card',
                    'route' => 'home',
                    'role' => 'professor'
                ],
                [
                    'title' => 'Game',
                    'icon' => 'fas fa-dice',
                    'route' => 'home',
                    'role' => 'professor'
                ],
                [
                    'title' => 'Tabuleiro',
                    'icon' => 'fas fa-chess-board',
                    'route' => 'home',
                    'role' => 'professor|aluno',
                ],
                [
                    'title' => 'Main World',
                    'icon' => 'fas fa-globe-americas',
                    'route' => 'jogos.main-world',
                ]
            ]
        ],
        [
            'title' => 'Entretenimento',
            'role' => 'administrador|professor|aluno',
            'icon' => 'fas fa-puzzle-piece',
            'subitems' => [
                [
                    'title' => 'Eventos',
                    'icon' => 'fas fa-calendar-alt',
                    'route' => 'home'
                ]
            ]
        ],
        [
            'title' => 'Correções',
            'role' => 'professor',
            'icon' => 'fas fa-check-circle',
            'subitems' => [
                [
                    'title' => 'Individual',
                    'icon' => 'fas fa-user',
                    'route' => 'home'
                ],
                [
                    'title' => 'Equipe',
                    'icon' => 'fas fa-users',
                    'route' => 'home'
                ],
                [
                    'title' => 'Turma',
                    'icon' => 'fas fa-chalkboard-teacher',
                    'route' => 'home'
                ]
            ]
        ],
        [
            'title' => 'Vagas',
            'role' => 'professor',
            'icon' => 'fas fa-id-badge',
            'subitems' => [
                [
                    'title' => 'Vaga Estágio',
                    'icon' => 'fas fa-plus-square',
                    'route' => 'home'
                ],
                [
                    'title' => 'Indicar Estagiário',
                    'icon' => 'fas fa-bullhorn',
                    'route' => 'home'
                ]
            ]
        ],
        [
            'title' => 'Relatórios',
            'role' => 'administrador|professor|aluno',
            'icon' => 'fas fa-chart-line',
            'route' => 'home'
        ],
        [
            'title' => 'Minhas Atividades',
            'role' => 'aluno',
            'icon' => 'fas fa-edit',
            'subitems' => [
                [
                    'title' => 'Individual',
                    'icon' => 'fas fa-user',
                    'route' => 'atividades-individuais.index'
                ],
                [
                    'title' => 'Equipe',
                    'icon' => 'fas fa-users',
                    'route' => 'atividades-equipes.index'
                ],
                [
                    'title' => 'Turma',
                    'icon' => 'fas fa-chalkboard-teacher',
                    'route' => 'atividades-turmas.index'
                ]
            ]
        ],
        [
            'title' => 'Responder Questionário',
            'role' => 'responsavel',
            'icon' => 'fas fa-copy',
            'route' => 'home'
        ]
    ]
];