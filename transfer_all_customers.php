<?php

    session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
	include("dbcon/dbcon.php");
	
    $user_cli = $_POST['user_cli'];       // user_cli DO NOVO ATENDENTE
	
    if ( !isset($_SESSION['user_master']) || $_SESSION['controle'] != '345067821133' ) {
	    header("Location: index.php");
        
	}

	else {
	
	    // CAPTURA A MÁXIMA POSIÇÃO DOS CONTATOS E SOMA 5	
	    $sql = "SELECT IFNULL(MAX(posicao),0) + 5 AS posicao FROM contatos";
	    //******************************************************************
	   
	    $result=mysqli_query($con,$sql);
	   
	   
	    if(mysqli_num_rows($result)) {
		   $row= mysqli_fetch_assoc($result);
		   $posicao = $row["posicao"]; 
	    }
	    else {
		   
		   $posicao = 5; 
	    }
		
		
	    $sql = "UPDATE contatos SET status='0', user_cli='".$user_cli."', posicao='".$posicao."' WHERE user_cli='".$_SESSION['user_cli']."'";

        $result = mysqli_query($con,$sql);
		   
        if(mysqli_affected_rows($con) > 0 ) { // Para se saber se a atualização teve êxito	

			  // ALTERA user_cli DA TABELA whats_chat PARA user_cli DO NOVO ATENDENTE
			  $sql = "UPDATE whats_chat SET user_cli = '".$user_cli."' WHERE user_cli = '".$_SESSION['user_cli']."'"; 		      
			  $result = mysqli_query($con,$sql);										   
			  // ********************************************************************
				
              $response = array("success" => true);
		}
        else 
		 {
			$response = array("success" => false);
		 }
		
		echo json_encode($response);
		
	}
	
	mysqli_close($con);
	
?>