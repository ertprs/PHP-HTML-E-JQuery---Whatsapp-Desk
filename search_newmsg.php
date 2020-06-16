<?php

    //Essa php carrega as mensagens após o click no contato da lista
	
    session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
	include("dbcon/dbcon.php");
	
	$telefone = $_POST['telefone'];
	$ultimoid = $_POST['ultimoid'];

	// TESTE
	// COMENTAR ANTES DE COLOCAR NA PRODUÇÃO
    // $telefone =  "5524988670795";
	// $ultimoid = "1";
	// $_SESSION['controle'] = '345067821133';
	// $_SESSION['user_cli'] = "WhatsC";
	
    // *************************************	
	
    if ( !isset($_SESSION['user_cli']) || $_SESSION['controle'] != '345067821133' ) {
	    header("Location: index.php");
  
	}

	else {
	
           $sql = "SELECT id,entrada_saida,mensagem, tipo_mensagem, hora_msg,arquivo,referencia, tag_id FROM whats_chat ";
		   $sql .= "WHERE whatsapp='".$telefone."' ";
	       $sql .= "AND user_cli='".$_SESSION['user_cli']."' AND id > ".$ultimoid ;
		  
		   
           $result = mysqli_query($con,$sql);
		  		   
           while($rows = mysqli_fetch_assoc($result)){
                 $vetor[] = array_map('utf8_encode', $rows);
				 
		 
           }
	
	      echo json_encode($vetor);
	
	
	 }

	


    mysqli_close($con);

?>

