<?php
	$server         = "localhost";
	$nomedeUsuario  = "root";    
	$senha          = "";
	$bancoUsado     = "whatsdesk";
	$con = mysqli_connect($server, $nomedeUsuario, $senha,$bancoUsado)  or die(mysqli_error());	
?>

