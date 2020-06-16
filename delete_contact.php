<?php

    session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
	$telefone = $_POST['telefone'];
	$user_cli = $_SESSION['user_cli'];
	
    if ( !isset($_SESSION['user_master']) || $_SESSION['controle'] != '345067821133' ) {   
	   header("Location: index.php");
	}

	else 
	{


		 if (!empty($telefone) ) {
			
            include("dbcon/dbcon.php");
			
			$sql = "DELETE FROM contatos WHERE user_cli = '".$user_cli."' AND numero = '".$telefone."'";
			
			$result = mysqli_query($con,$sql);
			
			if ($result){
				
			   $sql = "DELETE FROM whats_chat WHERE user_cli = '".$user_cli."' AND numero_destino = '".$telefone."'";
			   
			   $result = mysqli_query($con,$sql);
			   
			   $response = array("success" => true);
			}
			else
			   {
			    $response = array("success" => false);	
			   }
			
			echo json_encode($response);
			
			
			mysqli_close($con);
			
		   }
		   
		   
		 
	}
			 
			 



?>

