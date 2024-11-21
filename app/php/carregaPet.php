<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }   

    //Funções e conexão por PDO
    include('funcoes.php');
    require_once('conexaoPDO.php');

    //Pega o id enviado por GET na URL
    $idCliente = isset($_GET['idCliente']) ? $_GET['idCliente'] : '';
    
    if (! empty($idCliente)){
        //Monta a lista no banco
        echo getPet($idCliente);
    }

    //Função para montar a lista filtrada
    function getPet($idCliente){
        //Conexão PDO
        $pdo = Conectar();

        //Consulta SQL
        $sql = "SELECT id_pet, "
					." nome "
			." FROM pet "
			." WHERE id_cliente = '".$idCliente."'"
			." ORDER BY nome;";

        //Executar por PDO
        $stm = $pdo->prepare($sql);
        $stm->execute();

        //sleep(1);
        //Converte o resultado em JSON antes de retornar para a página
        echo json_encode($stm->fetchAll(PDO::FETCH_ASSOC));        
        
        //Encerra a conexão PDO
        $pdo = null;
    }

?>