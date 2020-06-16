<?php

    session_start(); 
		

	header("Content-type: text/html; charset=utf-8");
	
	include("dbcon/dbcon.php");
	
	$api_token       = $_SESSION['api_token'];  
    
	// VARIÁVEIS FIXAS 
    $idapp= $_SESSION['api_idapp'];
    $email= $_SESSION['api_email'];
    $emoji= "nao";                    // DEFAULT = NAO //"sim" ou "nao"
	// ***************
	
	
	$whatsapp = $_POST['telefone'];
	$posicao  = $_POST['posicao'];           // NÃO MAIS UTILIZADO NESSE SENTIDO
	$user_cli = $_POST['user_cli'];          // user_cli DO NOVO ATENDENTE

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
	

    if ( !isset($_SESSION['user_cli']) || $_SESSION['controle'] != '345067821133' ) {
	    header("Location: index.php");
  
	}

	else {

           $nome_cli = "";   // PADRÃO INICIAL
		   
		   // CAPTURA A MÁXIMA POSIÇÃO DOS CONTATOS E SOMA 5	
		   $sql = "SELECT IFNULL(MAX(posicao),0) + 5 AS posicao FROM contatos";
		   //******************************************************************
		   
		   $result=mysqli_query($con,$sql);
		   
		   
		   if(mysqli_num_rows($result)) {
			  $row= mysqli_fetch_assoc($result);
			  $posicao = $row["posicao"]; 
		   }
		   else {
			   
			  $posicao = 5; 
		   }
		   
           $sql = "UPDATE contatos SET status='0', user_cli='".$user_cli."', posicao='".$posicao."' WHERE numero='".$whatsapp."'";
		  
           $result = mysqli_query($con,$sql);
		   
           if(mysqli_affected_rows($con) > 0 ) { // Para se saber se a atualização teve êxito	
		   
		        // CAPTURA nome_cli DO NOVO ATENDENTE 
		        $sql = "SELECT nome_cli FROM usuarios WHERE user_cli = '".$user_cli."'";
				$result = mysqli_query($con,$sql);
				
				if(mysqli_num_rows($result)) {
                   $row= mysqli_fetch_assoc($result);
				   $nome_cli = $row["nome_cli"];
				}
                // **********************************
				
				// ALTERA user_cli DA TABELA whats_chat PARA user_cli DO NOVO ATENDENTE
                $sql = "UPDATE whats_chat SET user_cli = '".$user_cli."' WHERE user_cli = '".$_SESSION['user_cli']."' AND whatsapp='".$whatsapp."'"; 		      
			    $result = mysqli_query($con,$sql);										   
		        // ********************************************************************

				
					  $response = array("success" => true);
					  
					  // 19/02/2020
					  // SE NÃO É PARA INFORMAR AO CLIENTE QUE O ATENDIMENTO FOI TRANSFERIDO PARA OUTRO ATENDENTE
					  // TERMINA A SESSÃO E NÃO VAI ADIANTE NA TRATIVA
					  //
					  if ($_SESSION['info_transferencia'] == 0) {
						 echo json_encode($response);
						 mysqli_close($con);
						 die();				 
					  }
					  // *****************************************************************************************
					  
					  
					  // TRATATIVA DE ENVIO DE MENSAGEM AO CLIENTE DE QUE ELE FOI TRANSFERIDO PARA OUTRO ATENDENTE.

						// ROTINA DE INFORMAR A DATA CORRETA QUE ATENDE LOCALHOST E SERVIDOR DE HOSPEDAGEM
						// HORAS DO FUSO ((BRASÍLIA = -3) COLOCA-SE SEM O SINAL -).	
						// $h = "3";
						$h = $_SESSION['h']; 		                // ESSE VALOR É INFORMADO QUANDO O USUÁRIO ENTRA NO SISTEMA - LOGIN.PHP
						//********************************************************
						
						$hm = $h * 60;
						$ms = $hm * 60;
						//COLOCA-SE O SINAL DO FUSO ((BRASÍLIA = -3) SINAL -) ANTES DO ($ms). DATA
						$dh = gmdate("Y-m-d", time()-($ms));                                          // Data para ser gravada no banco de dados
						//COLOCA-SE O SINAL DO FUSO ((BRASÍLIA = -3) SINAL -) ANTES DO ($ms). HORA
						$dt = gmdate("H:i:s", time()-($ms));                                          // Hora:Min:Seg para ser gravada no banco de dados 
						
						$data_hora = $dh.$dt;
						$data_hora = strtotime($data_hora);

						//*************************************************************************************************************************


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

						//************************
			
						// CONVERTE DATA E HORA GUARDADOS PARA ENVIO DA MENSAGEM NO FORMATO INDICADO COMO ID DA MENSAGEM
						$dados['idmsg']= date('YmdHis',$data_hora);
						// *************************************************************************
					
						// ENVIO DE MENSAGEM PARA O CONTATO 
						// 19/02/2020
						
						$mensagem 	   = "Você foi transferido para falar com o(a) atendente " ."*".$nome_cli."*.";

						$dados['email']= $email;
						$dados['token']= $api_token ;
						$dados['idapp']= $idapp;
						
						// GUARDA DATA E HORA DA MENSAGEM PARA SER UTILIZADO POSTERIORMENTE
						// $idmsg= $dados['idmsg'];    // NÃO MAIS UTILIZADO                        
						// *****************************************************************
						
						$dados['midia']= "texto"; 
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
				
					  // FIM DA TRATATIVA DE ENVIO DE MENSAGEM AO CLIENTE DE QUE ELE FOI TRANSFERIDO PARA OUTRO ATENDENTE.
			  

									
			  
		   }
		   else {
			  $response = array("success" => false); 
			   
		   }
		   
	       echo json_encode($response);
	
	 }
	 

     

    mysqli_close($con);
	
	




?>

