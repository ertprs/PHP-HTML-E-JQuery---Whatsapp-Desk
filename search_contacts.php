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
				 // PROCURA POR TELEFONE OU PARTE DO TELEFONE  
			     $sql = "SELECT id, numero, nome, tag, status FROM contatos WHERE numero LIKE '%".$contato."%' ";
			  }
			  else {
				 // PROCURA POR NOME OU PARTE DO NOME  
				 $sql = "SELECT id, numero, nome, tag, status FROM contatos WHERE nome LIKE '%".$contato."%' ";
			  }
			  $sql .= "AND user_cli='".$_SESSION['user_cli']."' order by posicao DESC,nome ";
	      }
		  else {
			  $sql = "SELECT id, numero, nome, tag, status FROM contatos WHERE ";
			  $sql .= "user_cli='".$_SESSION['user_cli']."' order by posicao DESC ";			  
			  
		  }
		  
		  
           $result = mysqli_query($con,$sql);
		   
           while($rows = mysqli_fetch_assoc($result)){
                 $vetor[] = array_map('utf8_encode', $rows); 
           }
	
	
	      echo json_encode($vetor);
	
	
	 }

	


    mysqli_close($con);


?>
