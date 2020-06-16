<?php

    session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
	include("dbcon/dbcon.php");
	
	$contato = $_POST['contato'];
			   
    if ( !isset($_SESSION['user_cli']) || $_SESSION['controle'] != '345067821133' ) {
	    header("Location: index.php");
  
	}

	else {
	

	      if (!empty($contato)) {
			  
			  if (is_numeric($contato)){
				  $sql = "SELECT id, numero, nome, tag, status FROM contatos WHERE numero NOT LIKE '%".$contato."%' ";
			  }
			  else {
				 $sql = "SELECT id, numero, nome, tag, status FROM contatos WHERE nome NOT LIKE '%".$contato."%'  OR tag NOT LIKE '%{$contato}%'";
			  }
			  $sql .= "AND user_cli='".$_SESSION['user_cli']."' order by posicao DESC,nome ";
			  
			  $result = mysqli_query($con,$sql);
			   
			  while($rows = mysqli_fetch_assoc($result)){
				 $vetor[] = array_map('utf8_encode', $rows); 
			  }		   
	      
		  }
		  		  

	      echo json_encode($vetor);
	
	
	 }

	
    mysqli_close($con);


?>