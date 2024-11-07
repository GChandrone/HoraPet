<?php

    include('funcoes.php');

    $nome           = $_POST["nTitulo"        ];
    $valorPequeno   = $_POST["nValorPequeno"  ];
    $duracaoPequeno = $_POST["nDuracaoPequeno"];
    $valorMedio     = $_POST["nValorMedio"    ];
    $duracaoMedio   = $_POST["nDuracaoMedio"  ];
    $valorGrande    = $_POST["nValorGrande"   ];
    $duracaoGrande  = $_POST["nDuracaoGrande" ];
    $descricao      = $_POST["nDescricao"     ];
    $funcao         = $_GET ["funcao"         ];
    $idServico      = $_GET ["codigo"         ];

    $valorPequeno = desformatarMoeda($valorPequeno);
    $valorMedio   = desformatarMoeda($valorMedio);
    $valorGrande  = desformatarMoeda($valorGrande);

    if($_POST["nAtivoServico"] == "on") $ativo = "1"; else $ativo = "0";

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //INSERT
        $sql = "INSERT INTO servico (nome,valor_pequeno,valor_medio,valor_grande,duracao_pequeno,duracao_medio,duracao_grande,descricao,ativo) "
             ." VALUES ("."'$nome',$valorPequeno,$valorMedio,$valorGrande,'$duracaoPequeno','$duracaoMedio','$duracaoGrande','$descricao',$ativo);";

    }elseif($funcao == "A"){
        
        $sql = "UPDATE servico "
                ." SET nome            = '$nome', "
                    ." valor_pequeno   = $valorPequeno, " 
                    ." valor_medio     = $valorMedio, " 
                    ." valor_grande    = $valorGrande, " 
                    ." duracao_pequeno = '$duracaoPequeno', "
                    ." duracao_medio   = '$duracaoMedio', "
                    ." duracao_grande  = '$duracaoGrande', "
                    ." descricao       = '$descricao', "
                    ." ativo           = $ativo "
                ." WHERE id_servico    = $idServico;";

    }elseif($funcao == "D"){
        //DELETE
        $sql = "DELETE FROM servico "
                ." WHERE id_servico = $idServico;";
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../servicos.php");

?>