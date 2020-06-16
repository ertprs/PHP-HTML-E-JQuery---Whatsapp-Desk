<?php


    session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
	include("dbcon/dbcon.php");
	
	$telefone = $_POST['telefone'];
	
	
    if ( !isset($_SESSION['user_cli']) || $_SESSION['controle'] != '345067821133' ) {
	    header("Location: index.php");
  
	}

	else {
	

           $sql = "UPDATE  contatos SET status = '1' WHERE numero ='".$telefone."' ";
	       $sql .= "AND user_cli='".$_SESSION['user_cli']."'";
		  
           $result = mysqli_query($con,$sql);
		  		   
           $response = array("success" => true);
		   
	       echo json_encode($response);
	
	 }
	 

     

    mysqli_close($con);
		

?>



