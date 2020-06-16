<?php


    session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
    if ( !isset($_SESSION['user_master']) || $_SESSION['controle'] != '345067821133' ) {   
	   header("Location: index.php");
	}

	else {
		
		$novotelefone = $_POST['novotelefone'];
		$telefoneanterior = $_POST['telefoneanterior'];
		$user_cli = $_SESSION['user_cli'];
		
		$ddd = substr($novotelefone,0,2);
		
		if ($ddd > 28) {
			// Verifica se o $ddd é maior que 28 pois existe o ddd 28
			if ( strlen($novotelefone) == 11 ) {
			   //Somente retira o 9º dígito se o telefone tiver 11 dígitos
			  $ladodireito = substr($novotelefone,3,8);
			  $novotelefone =  $ddd.$ladodireito;
		    }
		}
		
	     include("dbcon/dbcon.php");
		 
		 
		 //Verifica se o número está duplicado
		$sql = "SELECT c.user_cli,u.nome_cli FROM contatos AS c ";
		$sql .= "INNER JOIN usuarios AS u ON(u.user_cli=c.user_cli ) ";	
		$sql .= "WHERE c.numero ='".$novotelefone."'";
		//************
		
		$result = mysqli_query($con,$sql);
		
		if(mysqli_num_rows($result))
			{ 
			  $row= mysqli_fetch_assoc($result);
			  
			  // Telefone em duplicidade
			  $response = array("success" => '-1' ,"nome_cli" => $row['nome_cli']);
			}			
		else 
		{
			
			 $sql  = "UPDATE contatos SET numero = '".$novotelefone."' WHERE user_cli = '".$user_cli."' ";
			 $sql .= "AND numero = '".$telefoneanterior."'";
			 
			 $result = mysqli_query($con,$sql);
			 
			 
			 if ($result){
				 
				 
				 $sql  = "UPDATE whats_chat SET numero_remetente = '".$novotelefone."',numero_destino='".$novotelefone."' ";
				 $sql .= "WHERE user_cli='".$user_cli."' AND numero_remetente = '".$telefoneanterior."' AND entrada_saida=0";
				 
				 $result = mysqli_query($con,$sql);      //Pode gerar resultado ou não
				 
				 
				 $sql  = "UPDATE whats_chat SET numero_destino = '".$novotelefone."' ";
				 $sql .= "WHERE user_cli='".$user_cli."' AND numero_destino = '".$telefoneanterior."' AND entrada_saida=1";
				 
				 $result = mysqli_query($con,$sql);     //Pode gerar resultado ou não
				 
				 
				 $response = array("success" => '1',"nome_cli" => '');
			 }
			 
			 else {
				 $response = array("success" => '0',"nome_cli" => '');
				 
			 }
		}
			
        echo json_encode($response);
		 
		mysqli_close($con);
	}

?>
