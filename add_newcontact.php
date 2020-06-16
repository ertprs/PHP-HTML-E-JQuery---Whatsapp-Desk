<?php

    session_start(); 
	
	header("Content-type: text/html; charset=utf-8");
	
	include("dbcon/dbcon.php");
	
	
	$api_token       = $_SESSION['api_token']; 
	        //TOKEN PARA ENVIO DA MENSAGEM DE BOAS VINDAS
	// ***************************************
    // VARIÁVEIS FIXAS 
    $idapp= $_SESSION['api_idapp'];
    $email= $_SESSION['api_email'];
    $emoji= "nao";                                    // DEFAULT = NAO //"sim" ou "nao"
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
	   

	$nome            = $_POST['nome'];
	$mensagem        = $_POST['mensagem'];
    $user_cli        = $_SESSION['user_cli'];

	 
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
	
	$data_hora = $dh.$dt;                          // MONTA PARA ENVIAR PARA API
	$data_hora = strtotime($data_hora);            // RESULTADO PARA ENVIAR PARA API

	//*************************************************************************************************************************

		
    $data_rg = $dh;                               //  PARA INFORMAR NA TABELA contatos
	$data_rt = $dh;                               //  PARA INFORMAR NA TABELA contatos
	
	 
    if ( !isset($_SESSION['user_master']) || $_SESSION['controle'] != '345067821133' ) {   
	   header("Location: index.php");
	}

	else {

 	 
		 if (!empty($whatsapp) && !empty($nome) && !empty($mensagem)  ) {

			 //Verifica se o número está duplicado
			 
			$sql = "SELECT c.user_cli,u.nome_cli FROM contatos AS c ";
			$sql .= "INNER JOIN usuarios AS u ON(u.user_cli=c.user_cli ) ";
			$sql .= "WHERE c.numero ='".$whatsapp."'";
			//************
			
			$result=mysqli_query($con,$sql);  
		  
			if(mysqli_num_rows($result))
				{ 
			      $row= mysqli_fetch_assoc($result);
			      
				  
			      // TELEFONE JÁ VINCULADO A ATENDENTE
			      $response = array("success" => '-1' ,"nome_cli" => $row['nome_cli']);
                }			
			else 
			{
				  
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

						   if ($posicao > 0 )
						   {
								 $sql = "INSERT INTO contatos (numero,nome,status,posicao,user_cli,data_rg,data_rt) ";
								 $sql .= "VALUES ('".$whatsapp."','".$nome."',"."0".",".$posicao.",'".$user_cli."','".$data_rg."','".$data_rt."')"; 	
								 
								 $result = mysqli_query($con,$sql);
								   
								 if(mysqli_affected_rows($con) > 0 ) { //     PARA SE SABER SE A INCLUSÃO TEVE ÊXITO
								 

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
								
									$dados['email']= $email;
									$dados['token']= $api_token ;
									$dados['idapp']= $idapp;
									
									// GUARDA DATA E HORA DA MENSAGEM PARA SER UTILIZADO POSTERIORMENTE
									// $idmsg= $dados['idmsg'];    // NÃO MAIS UTILIZADO                        
									// *****************************************************************
									
									$dados['midia']= "texto" ; 
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
									
									if ($logado == "sim") {
										
										if ($erro="nao"){
											$sucesso = 1;
											$response = array("success" => '1',"nome_cli" => '');											
										}
										else {
										     echo json_encode($response);
											 $response = array("success" => '-3',"nome_cli" => $sobre_o_erro);											 
										}
										
									} 
									else if ($logado == "nao") {
										     // O QR CODE NÃO ESTÁ CONECTADO E A MENSAGEM AGUARDA ENVIO NA FILA
											  $sucesso = 1;
                                              $response = array("success" => '2',"nome_cli" => '');											  
									}
			
			                        if ($sucesso == 1) {
										// GRAVA A MENSAGEM ENVIADA PARA O NOVO CONTATO NO BANCO DE DADOS

										$sql = "INSERT INTO whats_chat (entrada_saida,user_cli,whatsapp,status_cli,data_msg,hora_msg,status,";
										$sql .= "mensagem,tipo_mensagem) ";
										$sql .= "VALUES (1,'{$user_cli}','{$whatsapp}','-1','{$dh}','{$dt}','0','{$mensagem}','chat'";
										$sql .= ")";

										$result = mysqli_query($con,$sql);
				
										
									}
								 }
								 else {
								    $response = array("success" => '-2',"nome_cli" => ''); 
									   
								 }
				   
						   } // ... if ($posicao > 0 )
							   
						   else
						   {
							   $response = array("success" => '0',"nome_cli" => '');
						   }
				  
				  

		     }

             echo json_encode($response);
			 
		 }  // if (!empty($whatsapp) && !empty($nome) ) {
    }		 

	mysqli_close($con);
	
?>
