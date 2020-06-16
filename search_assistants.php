<?php


    session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
	include("dbcon/dbcon.php");
				   
    if ( !isset($_SESSION['user_cli']) || $_SESSION['controle'] != '345067821133' ) {
	    header("Location: index.php");
  
	}

	else {
	
	     /*
         $sql = "SELECT user_cli, nome_cli FROM usuarios WHERE user_master='".$_SESSION['user_master']."' ";
		 $sql .= "AND user_cli <> '".$_SESSION['user_cli']."' AND status = -1 ORDER BY nome_cli ASC ";
         */
		 
		 //19/02/2020
         $sql = "SELECT user_cli, nome_cli FROM usuarios ";
		 $sql .= "WHERE user_cli <> '".$_SESSION['user_cli']."' AND status = -1 ORDER BY nome_cli ASC ";
		 // *********
		 
         $result = mysqli_query($con,$sql);
		   
	     while($rows = mysqli_fetch_assoc($result)){
		  	  $vetor[] = array_map('utf8_encode', $rows); 
	    }
	
	      echo json_encode($vetor);
	
	 }

    mysqli_close($con);
	

?>
