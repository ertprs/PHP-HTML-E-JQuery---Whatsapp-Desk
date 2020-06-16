<?php

    session_start();
	
	header("Content-type: text/html; charset=utf-8");

	// EVITA INFORMAÇÃO DE ERRO NA LINHA --> $jsondata = file_get_contents($json_string);
	error_reporting(E_ERROR | E_PARSE);
		    
	
    // PRODUÇÃO - DESCOMENTAR AS LINHAS ABAIXO ANTES DE COLOCAR EM PRODUÇÃO

    
	if ( !isset($_SESSION['user_master']) || $_SESSION['controle'] != '345067821133' ) {	   
	   header("Location: index.php");
	   die();
	}
	
	$api_token       = $_SESSION['api_token']; 
	$api_checkphone  = $_SESSION['api_checkphone'];
	
    // VARIÁVEIS FIXAS 
    $idapp= $_SESSION['api_idapp'];
    $email= $_SESSION['api_email'];
    $emoji= "nao";                    // DEFAULT = NAO //"sim" ou "nao"
    // ***************
	
	$whatsapp = $_POST['telefone'];
	
	
	if (substr($whatsapp, 0, 2) ==  55 ) {		
      	$ddd = substr($whatsapp,2,2);
			
		if ($ddd > 29) {
			// VERIFICA SE O $DDD É MAIOR QUE 29 POIS EXISTE O DDD 29 CATALOGADO
			if ( strlen($whatsapp) == 13 ) {
			   //SOMENTE RETIRA O 9º DÍGITO SE O TELEFONE TIVER 13 dígitos
			  $ladodireito = substr($whatsapp,5,8);
				  $whatsapp =  "55".$ddd.$ladodireito;
			 }
		   }
	}

	// ************************************
	
	// VERIFICAÇÃO DE CONEXÃO - JULIO 23/01/2020
	$dados['email']= $email;
	$dados['token']= $api_token;
	$dados['idapp']= $idapp;
	
	$endpoint="https://www.solutek.online/api/whatsapp/gateway/json/status";
	$curl = curl_init($endpoint);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER , false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);
	$executa_api= curl_exec($curl);
	curl_close($curl);
	$retorno= json_decode($executa_api);
	//RETORNO DA API
	$logado= $retorno->logado;
	
	// echo $logado."<br><br>";
	
	//************************
									
	if ($logado == "nao") { 

        $response = array("success" => '3');
    }

    else {

			
			$dados['email']   = $email;
			$dados['token']   = $api_token ;
			$dados['idapp']   = $idapp;
			$dados['whatsapp']= $whatsapp;
			
			
			$endpoint="https://www.solutek.online/api/whatsapp/gateway/json/foto_perfil";

			$curl = curl_init($endpoint);

			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER , false);

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			curl_setopt($curl, CURLOPT_POST, true);

			curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);

			$executa_api= curl_exec($curl);

			curl_close($curl);

            // AGUARDA N SEGUNDOS PARA QUE O WEBHOOK GRAVE OU NÃO NA TABELA whats_chat
			// A EXISTÊNCIA DO TELEFONE NO WHATSAPP
			// A QUANTIDADE DE SEGUNDOS ESTÁ INDICADA NO CAMPO api_checkphone DA TABELA api
            sleep(intval($api_checkphone));
			
			include("dbcon/dbcon.php");
			
			// TENTA EXCLUIR O REGISTRO NA TABELA whats_chat
			// SE CONSEGUIR EXCLUIR O REGISTRO , SIGNIFICA QUE O NÚMERO ESTÁ CADASTRADO NO WHATSAPP
			
		    $sql = "DELETE FROM whats_chat WHERE entrada_saida = 3 AND whatsapp = '{$whatsapp}' AND tipo_mensagem = 'perfil' ";	
			 
		    $result = mysqli_query($con,$sql);
			   
		    if(mysqli_affected_rows($con) > 0 ) { //     Para se saber se a inclusão teve êxito	
				// CELULAR CADASTRADO NO WHATSAPP;
				$response = array("success" => '1');			 
			}
			else {
			    // CELULAR NÃO CADASTRADO NO WHATSAPP; 
			   $response = array("success" => '0');				
			}
			
			mysqli_close($con);
			
	}	
	

    echo json_encode($response);
	

    /*
	// CÓDIGO ANTERIOR DO CHAT-API
    $jsondata = file_get_contents($json_string);
    $items = json_decode($jsondata,true);

    $items = str_replace(array("\n","\r"),"",$items); 

	if(!empty($items))
	   {	
		foreach($items as $campo){
			if ($campo == "exists") {
				// CELULAR CADASTRADO NO WHATSAPP;
				$response = array("success" => '1');
			} else {
			    // CELULAR NÃO CADASTRADO NO WHATSAPP; 
			   $response = array("success" => '0');
			}
		  }
       }
	else {
		//NÃO FOI POSSÍVEL VERIFICAR O CADASTRO DO CELULAR NO WHATSAPP 
		$response = array("success" => '2');
	}   
	echo json_encode($response);
	*/
	
	
?>