<?php
include_once("funcoes.php");

// Verificar se a sessão já está ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function montaMenu() {
    // Obtém a página atual a partir da URL
    $paginaAtual = basename($_SERVER['PHP_SELF']); // Retorna, por exemplo, 'agendamentos.php'

    // Obtendo o tipo de funcionário da sessão
    $tipoFuncionarioID = $_SESSION['tipoFuncionario'] ?? 1; // Assume 1 (Atendente) como padrão

    // Configuração de menus por tipo de funcionário
    $menus = [
        'admin' => [
            'agendamentos.php' => ['icon' => 'far fa-calendar-plus', 'label' => 'Agendamentos', 'link' => './agendamentos.php'],
            'calendario.php' => ['icon' => 'far fa-calendar-alt', 'label' => 'Calendário', 'link' => './calendario.php'],
            'racas.php' => ['icon' => 'fas fa-paw', 'label' => 'Raças', 'link' => './racas.php'],
            'servicos.php' => ['icon' => 'ion ion-scissors', 'label' => 'Serviços', 'link' => './servicos.php'],
            'funcionarios.php' => ['icon' => 'ion ion-person-stalker', 'label' => 'Funcionários', 'link' => './funcionarios.php'],
            'clientes.php' => ['icon' => 'ion ion-ios-people', 'label' => 'Clientes', 'link' => './clientes.php'],
            'pets.php' => ['icon' => 'fas fa-dog', 'label' => 'Pets', 'link' => './pets.php'],
        ],
        'esteticista pet' => [
            'agendamentos.php' => ['icon' => 'far fa-calendar-plus', 'label' => 'Agendamentos', 'link' => './agendamentos.php'],
            'calendario.php' => ['icon' => 'far fa-calendar-alt', 'label' => 'Calendário', 'link' => './calendario.php'],
        ],
        'atendente' => [
            'agendamentos.php' => ['icon' => 'far fa-calendar-plus', 'label' => 'Agendamentos', 'link' => './agendamentos.php'],
            'calendario.php' => ['icon' => 'far fa-calendar-alt', 'label' => 'Calendário', 'link' => './calendario.php'],
            'racas.php' => ['icon' => 'fas fa-paw', 'label' => 'Raças', 'link' => './racas.php'],
            'servicos.php' => ['icon' => 'ion ion-scissors', 'label' => 'Serviços', 'link' => './servicos.php'],
            'clientes.php' => ['icon' => 'ion ion-ios-people', 'label' => 'Clientes', 'link' => './clientes.php'],
            'pets.php' => ['icon' => 'fas fa-dog', 'label' => 'Pets', 'link' => './pets.php'],            
        ],
    ];

    // Início do HTML
    $html = '<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">';

    // Adiciona menus baseados no tipo de funcionário
    if ($tipoFuncionarioID == 3) { // Admin
        $html .= renderMenuItems($menus['admin'], $paginaAtual);
    }
    if ($tipoFuncionarioID == 2) { // Esteticista Pet ou superior
        $html .= renderMenuItems($menus['esteticista pet'], $paginaAtual);
    }
    if ($tipoFuncionarioID == 1) { // Atendente ou superior
        $html .= renderMenuItems($menus['atendente'], $paginaAtual);
    }

    // Item de logoff, disponível para todos
    $html .= '
        <li class="nav-item">
            <a href="./perfil.php" class="nav-link ' . ($paginaAtual === 'perfil.php' ? 'active' : '') . '">
                <i class="nav-icon fas fa-user"></i>
                <p>Meu Perfil</p>
            </a>
        </li>
    
        <li class="nav-item">
            <a href="php/validaLogoff.php" class="nav-link">
                <i class="fas fa-sign-out-alt nav-icon"></i>
                <p>Sair</p>
            </a>
        </li>';

    $html .= '</ul></nav>';
    return $html;
}

function renderMenuItems($menuItems, $paginaAtual) {
    $html = '';
    foreach ($menuItems as $fileName => $item) {
        $activeClass = ($paginaAtual === $fileName) ? 'active' : '';
        $html .= '
            <li class="nav-item">
                <a href="' . $item['link'] . '" class="nav-link ' . $activeClass . '">
                    <i class="nav-icon ' . $item['icon'] . '"></i>
                    <p>' . $item['label'] . '</p>
                </a>
            </li>';
    }
    return $html;
}



?>
