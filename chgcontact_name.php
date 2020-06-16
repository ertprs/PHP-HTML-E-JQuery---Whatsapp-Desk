<?php

    //Toda rotina escrita em 31/05/2019
	
    session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
	include("dbcon/dbcon.php");
	
	$telefone = $_POST['telefone'];
	$nome  = $_POST['nome'];

	
    if ( !isset($_SESSION['user_master']) || $_SESSION['controle'] != '345067821133' ) {
	    header("Location: index.php");
  
	}

	else {


           $sql = "UPDATE contatos SET nome='".$nome."' WHERE numero='".$telefone."'";
		   
		  
           $result = mysqli_query($con,$sql);
		   
           if(mysqli_affected_rows($con) > 0 ) { // Para se saber se a atualização teve êxito		   
              $response = array("success" => true);
		   }
		   else {
			  $response = array("success" => false); 
			   
		   }
		   
	       echo json_encode($response);
	
	 }
	 

     

    mysqli_close($con);
	
	




?>