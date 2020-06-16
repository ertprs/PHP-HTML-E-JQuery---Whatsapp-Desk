<?php

header("Content-Type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$token_interno = "f575b5d73f51f5fc86beb8800e1b506c125986";    // TOKEN DA WHATSCOMPANY PERANTE A SOLUTEK
	
    $raw_payload = file_get_contents('php://input');
    $data = json_decode($raw_payload, true);
	
	
	if (is_array($data))

	   {
	   date_default_timezone_set('America/Sao_Paulo');
	
       // VARIÁVEIS FIXAS 
	   $idapp= "4519";
	   $email= "api3@grupoconnectti.com.br";
	   //$email= "matthewangels@icloud.com";
	   
       $idmsg= date("YmdHis");
       $emoji= "nao";                                             // DEFAULT = NAO //"sim" ou "nao"

       // ***************
	   
	   $token_externo = $data['token'];                           //Token informado pelo cliente WhatsCompany
	   
	   
	   if ($token_interno == $token_externo) {
		   	   
		   // VARIÁVEIS RECEBIDAS DE FORA
		   $whatsapp = $data['whatsapp'];		   
		   $mensagem = $data['mensagem'];
		   $midia    = trim($data['midia']);                     //"texto" , "imagem" ou "arquivo"
		   $url_anexo      = $data['url_anexo'];                 //opcional. necessário se midia="imagem" ou midia="arquivo";
           // ****************************
		   
		   // VERIFICAÇÃO DO NONO DÍGITO
			if (substr($whatsapp, 0, 2) ==  55 ) {	
			
				$ddd = substr($whatsapp,2,2);
				
				if ($ddd > 29) {
					// Verifica se o $ddd é maior que 28 pois existe o ddd 28
					if ( strlen($whatsapp) == 13 ) {
						//Somente retira o 9º dígito se o whatsapp tiver 11 dígitos
					  $ladodireito = substr($whatsapp,5,8);
						  $whatsapp =  "55".$ddd.$ladodireito;
					 }
				   }
			
			}
	       // **********************
		   
           // TESTES DE INCONSISTÊNCIA
           if ( ($midia == 'imagem' || $midia == 'arquivo' ) && trim($url)=='') {
				//SE A MÍDIA FOR DIFERENTE DE TEXTO E A URL ESTIVER EM BRANCO, A OPERAÇÃO É ABORTADA
				$response = array("status" => "Falta informar a url");
				echo json_encode($response);
			    die();	
		   }

           if ($midia != 'texto' && $midia != 'imagem' && $midia != 'arquivo') {
				//SE A MÍDIA FOR DIFERENTE DE TEXTO, IMAGEM OU ARQUIVO, A OPERAÇÃO É ABORTADA
				$response = array("status" => "Mídia incorreta");
				echo json_encode($response);
			    die();	
		   }
		   
		   // ***************************
		   
		   
		   // TESTE PARA SE SABER SE AS VARIÁVEIS FORAM RECEBIDAS PELO POST
		   // GRAVA NO DISCO O ARQUIVO LOG.TXT
		   // COMENTAR ANTES DE COLOCAR EM PRODUÇÃO
 
           /*
           $fh = fopen("log.txt", "a+");

           if ($fh) {
              $registro = $data['token']. PHP_EOL .$whatsapp.PHP_EOL .$data['midia'] .PHP_EOL .$data['mensagem'] .PHP_EOL ." ".PHP_EOL;
			  fwrite($fh,$registro );
			  fclose($fh);
			  $response = array("status" => "OK - Log gravado com sucesso");
			  echo json_encode($response);

		   }
		   */
		   // FIM DA ÁREA DE TESTE
		   
		   // 
		   //
		   
		   // ÁREA DE PRODUÇÃO - ENVIO
           // DESCOMENTAR ANTES DE COLOCAR EM PRODUÇÃO
		  
			// Verificação de conexão - Julio 23/01/2020
			$dados['email']= $email;
			$dados['token']= $token_interno;
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
			//Retorno da API
			$logado= $retorno->logado;
			
			//************************
			
			$dados['email']= $email;
			$dados['token']= $token_interno ;
			$dados['idapp']= $idapp;
			$dados['idmsg']= date("YmdHis");
			$dados['midia']= $midia ; 
			$dados['url_anexo']= ""; 
			$dados['whatsapp']= $whatsapp;
			$dados['mensagem']= $mensagem;
			$dados['emoji']= $emoji;
			$endpoint="https://www.solutek.online/api/whatsapp/gateway/json/enviar";
			$curl = curl_init($endpoint);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER , false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);
			$executa_api= curl_exec($curl);
			curl_close($curl);
			
			// Status do envio da Solutek (Retorno da API)
			$retorno= json_decode($executa_api);
			$erro= $retorno->erro;
			$sobre_o_erro= $retorno->sobre_o_erro;
			$whatsapp_retorno= $retorno->whatsapp;
			$mensagem_retorno= $retorno->mensagem;
			$status= $retorno->status;
			$idlog= $retorno->idlog;
            // **************************************
			
			// Status do envio ( adaptação WhatsCompany )
			
			// Verificação de conexão - Julio 23/01/2020
			
			if ($logado == "sim") {
				
				if ($erro="nao"){
			   $response = array("status" => "mensagem enviada");
	           echo json_encode($response);					
				}
				else {
				   $response = array("status" => $sobre_o_erro);
				   echo json_encode($response);					
				}
				
			} else if ($logado == "nao") {
			   $response = array("status" => "whatsapp desconectado"."\n"."mensagem aguardando envio");
	           echo json_encode($response);					
			}
			
			
			
						
			// ***************************************
			
		   // ********************
	   }   // FIM DO IF DO TOKEN INTERNO
       else {
		 $response = array("status" => "Token incorreto");
		 echo json_encode($response);		   
	   }
	   
	 }     // FIM DO if (is_array($data))
	 else {
         //   SE OS DADOS NÃO FOREM ENVIADOS ATRAVÉS DE ARRAY JSON
		 $response = array("status" => "Formato incorreto de envio de dados");
		 echo json_encode($response);
		 
	 }	
		
		
} // FIM DO if ($_SERVER['REQUEST_METHOD'] === 'POST')  	
else {
		 echo "Método incorreto";

}		


?>
