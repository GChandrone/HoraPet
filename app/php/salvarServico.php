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
        //UPDATE
        if($senha == ''){ 
            $setSenha = ''; 
        }else{ 
            $setSenha = " Senha = md5('".$senha."'), ";
        }

        $sql = "UPDATE usuarios "
                ." SET idTipoUsuario = $tipoUsuario, "
                    ." Nome = '$nome', "
                    ." Login = '$login', "
                    .$setSenha 
                    ." FlgAtivo = '$ativo' "
                ." WHERE idServico = $idServico;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM usuarios "
                ." WHERE idServico = $idServico;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../servicos.php");

?>