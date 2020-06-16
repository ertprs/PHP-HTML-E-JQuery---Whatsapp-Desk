<?php
	
session_start();
//========================//=========================//
function startNewSession($con,$email_adm, $pass_adm)
{
	$tabela        = "adm";
																													//
	$select        = "SELECT * FROM `" . $tabela . "` WHERE `email_adm` = '" . $email_adm . "' AND `pass_adm` = '" . $pass_adm . "'";

	$resultado     = mysqli_query($con,$select) or die(mysqli_error($con));
	
    $contagem = mysqli_num_rows($resultado);
	
	if($contagem == 0) 
    { 
       $mensagem     = "Acesso negado !";

		kickInvasor($mensagem);
		
	}

	else
	{
	
	while ($row = mysqli_fetch_assoc($resultado)) {

	    $_SESSION['id']           	 	  = $row["id"];
        $_SESSION['pass_adm']         	  = $row["pass_adm"];
		$_SESSION['user_cli']     	 	  = $row["user_cli"];
		$_SESSION['user_master']   	 	  = $row["user_master"];
		$_SESSION['nome_cli']     	 	  = $row["nome_cli"];
		$_SESSION['email_adm']     	 	  = $row["email_adm"];
		
}

	}

}
function testSessionData($con)
{
	if(!isset($_SESSION['email_adm']) OR !isset($_SESSION['pass_adm'])){
		$mensagem = "Faça Login Novamente";
		kickInvasor($mensagem);
	}
	else
	{
		startNewSession($con,$_SESSION['email_adm'], $_SESSION['pass_adm']); // Se os dados estiverem corretos, eu pass_admo por aqui

	}
	
}
function kickInvasor($mensagem)
{
	unset($_SESSION['username'],$_SESSION['pass_admword']); // Se os dados estiverem errados, eu pass_admo por aqui

	$paginadelogin = "index";	

	header("Location: " . $paginadelogin ."?mensagem=".$mensagem);

}
function dateConverter($_date = null) {
	$format = '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/';
	if ($_date != null && preg_match($format, $_date, $partes)) {
		return $partes[3].'-'.$partes[2].'-'.$partes[1];
	}
	return false;
}