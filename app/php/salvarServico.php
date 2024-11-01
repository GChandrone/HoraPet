<?php

    include('funcoes.php');

    $nome        = $_POST["nTitulo"   ];
    $valor       = $_POST["nValor"    ];
    $duracao     = $_POST["nDuracao"  ];
    $descricao   = $_POST["nDescricao"];
    $funcao      = $_GET ["funcao"    ];
    $idServico   = $_GET ["codigo"    ];

    $valor = desformatarMoeda($valor);

    if($_POST["nAtivoServico"] == "on") $ativo = "1"; else $ativo = "0";

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //INSERT
        $sql = "INSERT INTO servico (nome,valor,duracao,descricao,ativo) "
             ." VALUES ("."'$nome',$valor,'$duracao','$descricao',$ativo);";

    }elseif($funcao == "A"){
        
        $sql = "UPDATE servico "
                ." SET nome         = '$nome', "
                    ." valor        = $valor, "
                    ." duracao      = '$duracao', "
                    ." descricao    = '$descricao', "
                    ." ativo        = $ativo "
                ." WHERE id_servico = $idServico;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM servico "
                ." WHERE id_servico = $idServico;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../servicos.php");

?>