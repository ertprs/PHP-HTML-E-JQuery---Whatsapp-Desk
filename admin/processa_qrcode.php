<?php
include ('dbcon.php');
include('functions.php');

if(isset($_POST['email_adm']))
{
	
	$email_adm  = mysqli_real_escape_string($con,$_POST['email_adm']);
	$pass_adm = mysqli_real_escape_string($con,$_POST['pass_adm']);
	
	startNewSession($con,$email_adm, $pass_adm);
}
else
{
	testSessionData($con,$_SESSION['email_adm'], $_SESSION['pass_adm']);	
	}

$user_cli   	= $_SESSION['user_cli'];
$status_cli  	= $_SESSION['status'];
$status_n    	= $_SESSION['status_n'];
$limite_msg  	= $_SESSION['limite_msg'];
$code_cli    	= $_SESSION['code_cli'];
$user_adicional = $_SESSION['user_adicional'];
$user_master    = $_SESSION['user_master'];

$timeout = 86400; // Tempo da sessao em segundos
// Verifica se existe o parametro timeout
if(isset($_SESSION['timeout'])) {
// Calcula o tempo que ja se pass_admou desde a cricao da sessao
$duracao = time() - (int) $_SESSION['timeout'];
// Verifica se ja expirou o tempo da sessao
if($duracao > $timeout) {
// Destroi a sessao e cria uma nova
session_destroy();
session_start();
}
}
// Atualiza o timeout.
$_SESSION['timeout'] = time();



		$sql = "SELECT * FROM api";

		$result = mysqli_query($con,$sql) or die(mysqli_error($con)); 
		$num_rows = mysqli_num_rows($result);
								   
if($num_rows > 0 ) {

    while($linha = mysqli_fetch_array($result)) {
		$api_token	  = $linha["api_token"];
		$api_email    = $linha["api_email"];
		$api_idapp    = $linha["api_idapp"];
 

// conexão com a api

$dados['email']= $api_email;
$dados['token']= $api_token;
$dados['idapp']= $api_idapp;

	}
}

$urlend= "https://www.solutek.online/api/whatsapp/gateway/json/qrcode_licenciado";

$curl = curl_init($urlend);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER , false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);
$executa_api= curl_exec($curl);
curl_close($curl);

$debug= json_decode($executa_api);

$sucesso= $debug->sucesso;
$auth= $debug->auth;

$authlk= JS_URL.$auth;

$rt['sucesso']= $sucesso;
$rt['auth']= $authlk;
echo json_encode($rt);