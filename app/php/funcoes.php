<?PHP

include("funcaoMenu.php");
include("funcaoTipoPet.php");
include("funcaoRaca.php");
include("funcaoServico.php");
include("funcaoFuncionario.php");
include("funcaoTipoFuncionario.php");
include("funcaoCliente.php");
include("funcaoDonoPet.php");
include("funcaoPet.php");
include("funcaoAgendamento.php");
include("funcaoExecucao.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//Função que envia o e-mail com a nova senha para o usuário
function enviarEmail($email,$msg,$assunto,$nome){

    require '../PHPMailer/vendor/autoload.php';
	$mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            // Set mailer to use SMTP
        //$mail->SMTPDebug  = 3;                                    // Enable verbose debug output
        $mail->Host       = 'smtp.hostinger.com.br';                // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'sa@alphatechsolucoes.com.br';          // SMTP username
        $mail->Password   = 'Senai@2024';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 465;                                    // TCP port to connect to    
        $mail->CharSet    = 'UTF-8';
        
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ));

        //Recipients
        $mail->setFrom('sa@alphatechsolucoes.com.br', 'SA - SENAI');
        $mail->addAddress($email, $nome);                   

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = $assunto;
        $mail->Body    = $msg;
        $mail->AltBody = 'SA';

        //$mail->send();
        if ($mail->send()){
            header('location:../');
        }
        

    } catch (Exception $e) {

        //$_SESSION['msg-senha'] = $mail->ErrorInfo;
        $_SESSION['msg-senha'] = 'Houve uma falha no envio da nova senha. Verifique com seu administrador.';
        header('location: '.$_SERVER['HTTP_REFERER']);
    }
}

function desformatarMoeda($valorFormatado) {
    // Remove o "R$", pontos e espaços extras do valor
    $valorSemSimbolo = str_replace(['R$', '.', ' '], '', $valorFormatado);
    
    // Substitui a vírgula decimal por um ponto decimal
    $valorDecimal = str_replace(',', '.', $valorSemSimbolo);

    // Converte para float para garantir o formato decimal
    return number_format((float)$valorDecimal, 2, '.', '');
}

function formatarMoeda($valorDesformatado) {
    // Formata o valor como moeda brasileira (R$)
    return 'R$ ' . number_format($valorDesformatado, 2, ',', '.');
}

function formatarData($data) {
    // Converte a data para o formato desejado
    return date("d/m/Y", strtotime($data));
}

function formatarHora($hora, $formato = 'H:i') {
    // Valida se a hora está no formato esperado
    if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $hora)) {
        // Converte para um objeto DateTime
        $horaFormatada = DateTime::createFromFormat('H:i:s', $hora);
        if ($horaFormatada) {
            // Retorna a hora no formato solicitado
            return $horaFormatada->format($formato);
        }
    }
    // Retorna a hora original caso não esteja no formato esperado
    return $hora;
}

function verificarAcesso($tiposPermitidos = []) {

    // Verificar se o usuário está logado
    if (!isset($_SESSION['descTipoFuncionario'])) {
        prepararMensagem("Você precisa estar logado para acessar esta página.", "nao_logado", "index.php");
    }

    // Verificar se o tipo de usuário está na lista de permitidos
    if (!empty($tiposPermitidos) && !in_array($_SESSION['descTipoFuncionario'], $tiposPermitidos)) {
        prepararMensagem("Você não tem permissão para acessar esta página.", "acesso_negado", "calendario.php");
    }
}

function prepararMensagem($mensagem, $tipoErro, $defaultRedirect) {
    // Salvar mensagem e tipo de erro na sessão
    $_SESSION['erro_mensagem'] = $mensagem;
    $_SESSION['erro_tipo'] = $tipoErro;

    // Determinar a URL de redirecionamento
    $referer = $defaultRedirect; // Pega a página anterior ou a URL padrão
    $_SESSION['redirect_url'] = $referer;

    // Redirecionar para a página de mensagem
    header('Location: mensagem.php');
    exit();
}

function encodeId($id) {
    return base64_encode($id);
}

function decodeId($encodedId) {
    return base64_decode($encodedId);
}

?>