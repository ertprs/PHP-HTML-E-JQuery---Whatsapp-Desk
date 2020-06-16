<?php

    //ESSE PHP VERIFICA SE O CONTATO POSSUI NOVA MENSAGEM BASEAMDO-SE NA COLUNA STATUS DA TABELA CONTATOS
	//SE O STATUS = 0 ( ZERO ) HÁ NOVAS MENSAGENS NÃO LIDAS PARA CADA CONTATO
	
    session_start();
		
	header("Content-type: text/html; charset=utf-8");
	
	include("dbcon/dbcon.php");
	

    if ( !isset($_SESSION['user_cli']) || $_SESSION['controle'] != '345067821133' ) {
	    header("Location: index.php");
  
	}

	else {


	       // PELO FORMATO DA COLUNA DE CONTATOS INDICANDO SE EXISTE OU NÃO UMA MENSAGEM NOVA PARA CADA CONTATO,
		   // TENHO QUE UTILIZAR ESSA LÓGICA PARA EVITAR CARREGAMENTO OU REFRESH DESNECESSÁRIOS
		   
           $sql = "SELECT numero FROM contatos WHERE user_cli='".$_SESSION['user_cli']."' ";
		   $sql .= "AND status = '0' LIMIT 1";
		 
		   
           $result = mysqli_query($con,$sql);
		  
           if (mysqli_num_rows($result) > 0) 
		   
		      {
				   
				   $sql = "SELECT numero, status FROM contatos WHERE user_cli='".$_SESSION['user_cli']."' ORDER BY posicao DESC";
		   
		           $result = mysqli_query($con,$sql);
				   
				   while($rows = mysqli_fetch_assoc($result)){
						 $vetor[] = array_map('utf8_encode', $rows);
				   }
			  
			  }
			   
	      echo json_encode($vetor);
	
	
      }

    mysqli_close($con);

?>