<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }   

    //Funções e conexão por PDO
    include('funcoes.php');
    require_once('conexaoPDO.php');

    //Pega o id enviado por GET na URL
    $tipoPet = isset($_GET['tipo']) ? $_GET['tipo'] : '';
    
    if (! empty($tipoPet)){
        //Monta a lista no banco
        echo getRaca($tipoPet);
    }

    //Função para montar a lista filtrada
    function getRaca($tipoPet){
        //Conexão PDO
        $pdo = Conectar();

        //Consulta SQL
        $sql = "SELECT id_raca, "
					." nome "
			." FROM raca "
			." WHERE tipo_pet = '".$tipoPet."'"
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