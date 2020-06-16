<?php

    session_start();
	

    if ( !isset($_SESSION['user_cli']) || $_SESSION['controle'] != '345067821133'  ) {

	    header("Location: index.php");
	    die();
	  }

	else 
		
		{
	
			
			// ***********************************************
			
			$dados['email'] = $_SESSION['api_email'];	
			$dados['token'] = $_SESSION['api_token']; 
			$dados['idapp'] = $_SESSION['api_idapp'];
   			
			//Limite
			$endpoint="https://www.solutek.online/api/whatsapp/gateway/json/status";
			$curl = curl_init($endpoint);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER , false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);
			$executa_api= curl_exec($curl);
			curl_close($curl);
			$retorno= json_decode($executa_api);	
			$logado= $retorno->logado;
			
			
			if ( $logado == "sim") {
				$response = array("success" => true);
			}
			else {
				$response = array("success" => false);
			}
			
			echo json_encode($response);
	
		}

?>