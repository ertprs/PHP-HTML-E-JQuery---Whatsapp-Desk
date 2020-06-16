<?php

    //Essa php carrega as mensagens após o click no contato da lista
	
    session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
	include("dbcon/dbcon.php");
	
	$telefone = $_POST['telefone'];
	//TESTE
	// $telefone = "5524988670795";
	// $_SESSION['user_master'] = "WhatsC";
	// $_SESSION['controle'] = '345067821133'; 
	//**********************************
					
    if ( !isset($_SESSION['user_master']) || $_SESSION['controle'] != '345067821133' ) {
	    header("Location: index.php");
  
	}

	else {
	
           // QUERY ANTERIOR QUE CARREGA TODAS AS MENSAGENS
           /*   
           $sql = "SELECT id,mensagem, entrada_saida, tipo_mensagem, data_msg,hora_msg,arquivo,referencia ";
		   $sql .= "FROM whats_chat WHERE whatsapp='".$telefone."' ";
		   $sql .= "AND user_cli='".$_SESSION['user_cli']."'";
		   */
		   // *********************************************
		  
		   // QUERY QUE CARREGA SOMENTE AS ÚLTIMAS 60 MENSAGENS - 09/02/2020
		  
           $sql = "SELECT * FROM ( ";
           $sql .= "SELECT id,mensagem, entrada_saida, tipo_mensagem, data_msg,hora_msg,arquivo,referencia, tag_id ";
		   $sql .= "FROM whats_chat WHERE whatsapp='".$telefone."' ";
		   $sql .= "AND user_cli='".$_SESSION['user_cli']."' ORDER BY id DESC LIMIT 60 ";
		   // $sql .= " ORDER BY id DESC LIMIT 60 ";
           $sql .= ") sub ";
           $sql .= "ORDER BY id ASC";
		   
		   // *************************************************
		   
		   
           $result = mysqli_query($con,$sql);
		  
		   
           while($rows = mysqli_fetch_assoc($result)){
                 $vetor[] = array_map('utf8_encode', $rows);
		 
           }
	
	
	      echo json_encode($vetor);
	
	
	 }

	


    mysqli_close($con);

	





?>
