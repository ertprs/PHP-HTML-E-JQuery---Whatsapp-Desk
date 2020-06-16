<?php
	include ('dbcon.php');
	$con = mysqli_connect($server, $nomedeUsuario, $senha,$bancoUsado)  or die(mysqli_error());
	
	
	
	$sql = "SELECT id, api_token, api_email, api_idapp FROM api ORDER BY id LIMIT 1";
	
		$result = mysqli_query($con,$sql) or die(mysqli_error($con)); 
		$num_rows = mysqli_num_rows($result);
							   
	if($num_rows > 0 ) {

	while($linha = mysqli_fetch_array($result)) {
		$api_token 		= $linha["api_token"];
		$api_email   	= $linha["api_email"];
		$api_idapp   	= $linha["api_idapp"];
		
		
			$dados['email']= $api_email;
			$dados['token']= $api_token;
			$dados['idapp']= $api_idapp;
			
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
			$logado = $retorno->logado;
			
				if ($logado == "sim") {
					//echo " - <font color='#00CC33'>Sim</font>";
					
				} else {
					
					
					
					$sql = "SELECT id, alerta, whatsapp FROM adm ORDER BY id LIMIT 1";
	

					$result = mysqli_query($con,$sql) or die(mysqli_error($con)); 
					$num_rows = mysqli_num_rows($result);
											   
				if($num_rows > 0 ) {
				
				while($linha = mysqli_fetch_array($result)) {
					$id 			= $linha["id"];
					$whatsapp   	= $linha["whatsapp"];
					$alerta         = $linha["alerta"];
					$msg        	= "Olá!
Estou passando para informar que seu *smartphone está desconectado* do sistema de atendimento.
*Faça a leitura do QrCode o mais breve possível!*
Lembrando que no período em que permanecer desconectado, as conversas não serão salvas no sistema.";
				
				
				
				
					if ($alerta == 1) {
						
							$emoji= "nao"; //"sim" ou "nao"
							$dados['email']= "api2@grupoconnectti.com.br";
							//$dados['email']= "matthewangels@icloud.com";
							$dados['token']= "14a30fccaf04ebb07ca13ec012b8221b714995";
							$dados['idapp']= "4457";
							$dados['idmsg']= date("YmdHis");
							
							$dados['midia']= "texto"; //"texto" , "imagem" ou "arquivo"
							$dados['url_anexo']= ""; //opcional. necessÃ¡rio se midia="imagem" ou midia="arquivo";
							$dados['whatsapp']= $whatsapp;
							$dados['mensagem']= $msg;
							$dados['emoji']= $emoji;
							$endpoint="https://www.solutek.online/api/whatsapp/gateway/json/enviar";
							$curl = curl_init($endpoint);
							curl_setopt($curl, CURLOPT_SSL_VERIFYPEER , false);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($curl, CURLOPT_POST, true);
							curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);
							$executa_api= curl_exec($curl);
							curl_close($curl);
							$retorno= json_decode($executa_api);
							//Retorno da API
							$erro= $retorno->erro;
							$sobre_o_erro= $retorno->sobre_o_erro;
							$whatsapp_retorno= $retorno->whatsapp;
							$mensagem_retorno= $retorno->mensagem;
							$status= $retorno->status;
							$idlog= $retorno->idlog;
					
					} else { 
					
						//echo "Não envia alerta.";
					
					}

					
				}
				}
					
					
				}
	
	
			}
		}
	
?>