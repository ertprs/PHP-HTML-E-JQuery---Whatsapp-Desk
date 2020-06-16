<?php


    session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
	include("dbcon/dbcon.php");
	
    $opcao = $_POST['opcao'];
	

    if ( !isset($_SESSION['user_cli']) || $_SESSION['controle'] != '345067821133' ) {
	    header("Location: index.php");
  
	}

	else {
    
          $sql="UPDATE usuarios SET alerta_sonoro ='".$opcao."' WHERE user_cli='".$_SESSION['user_cli']."'";
		  
		  mysqli_query($con,$sql);
		  
		  if(mysqli_affected_rows($con) > 0 ) { // Para se saber se a atualização teve êxito
		     
              $response = array("success" => true);
			  //Altera a sessão
			  unset($_SESSION['alerta_sonoro']);
			  $_SESSION['alerta_sonoro']=$opcao;                
			  //
		  }
		  
		  else {
			   $response = array("success" => false);
		  }
		  echo json_encode($response);
		  
     }
	
	
	mysqli_close($con);
	

	
?>