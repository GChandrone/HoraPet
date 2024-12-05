<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!function_exists('descrTipoFuncionario')) {
    // Função para buscar a descrição do tipo de usuário
    function descrTipoFuncionario($id) {
        if ($id == 1) {
            return "Comum";
        } elseif ($id == 2) {
            return "Operador";
        } else {
            return "Admim";
        }
    }
}

function montaMenu() {
    // Obtendo o tipo de funcionário da sessão
    $tipoFuncionarioID = $_SESSION['tipoFuncionario'] ?? 1; // Assumir 1 como padrão
    $descricaoTipo = descrTipoFuncionario($tipoFuncionarioID);

    $html = '<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">';

    // Itens disponíveis para "Admim" (ID 3)
    if ($tipoFuncionarioID == 3) {
        $html .= '
        <li class="nav-item">
            <a href="./painel.php" class="nav-link">
                <i class="ion ion-pie-graph nav-icon"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="./usuarios.php" class="nav-link">
                <i class="far fa-user nav-icon"></i>
                <p>Usuários</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="./funcionarios.php" class="nav-link">
                <i class="ion ion-person-stalker nav-icon"></i>
                <p>Funcionários</p>
            </a>
        </li>';
    }

    // Itens disponíveis para "Operador" (ID 2) e superiores
    if ($tipoFuncionarioID == 2 || $tipoFuncionarioID == 3) {
        $html .= '
        <li class="nav-item">
            <a href="./produtos.php" class="nav-link">
                <i class="ion ion-bag nav-icon"></i>
                <p>Produtos</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="./agendamentos.php" class="nav-link">
                <i class="far fa-calendar-plus nav-icon"></i>
                <p>Agendamentos</p>
            </a>
        </li>';
    }

    // Itens disponíveis para "Comum" (ID 1) e superiores
    if ($tipoFuncionarioID >= 1) {
        $html .= '
        <li class="nav-item">
            <a href="./clientes.php" class="nav-link">
                <i class="ion ion-ios-people nav-icon"></i>
                <p>Clientes</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="./pets.php" class="nav-link">
                <i class="fas fa-dog nav-icon"></i>
                <p>Pets</p>
            </a>
        </li>';
    }

    // Item comum a todos os tipos
    $html .= '
        <li class="nav-item">
            <a href="./perfil.php" class="nav-link">
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
?>
