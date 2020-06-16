<?php
	
	//https://stackoverflow.com/questions/18705639/how-to-rename-uploaded-file-before-saving-it-into-a-directory
	
    session_start(); 
	
    header("Content-type: text/html; charset=utf-8");
	
	include("dbcon/dbcon.php");
	
	//SOMENTE É NECESSÁRIA ESSA API NESSE MÓDULO
	$api_token       = $_SESSION['api_token'];
	$user_cli        = $_SESSION['user_cli'];
	
    // VARIÁVEIS FIXAS 
    $idapp= $_SESSION['api_idapp'];
    $email= $_SESSION['api_email'];
    $emoji= "nao";                    // DEFAULT = NAO //"sim" ou "nao"
    // ***************
	
	$mensagem = "";
	$whatsapp = $_POST['telefone'];
	$extensao = $_POST['extensao'];       // EXTENSÃO DO ARQUIVO
	
	switch ($extensao) {
			case 'jpg':
			case 'jpeg':
			case 'bmp':
			case 'png':
			case 'gif':
				 $tipo_mensagem="image";
				 $midia="imagem";
				 break;
			case 'pdf':
			case 'txt':
			case 'zip':
			case 'rar':
			case 'rtf':
			case 'doc':
			case 'docx':
			case 'xls':
			case 'xlsx':
				 $tipo_mensagem="document";
				 $midia="arquivo";
				 break;					
			case 'mp4':
			case 'avi':
				 $tipo_mensagem="video";
				 $midia="arquivo";
				 break;
			case 'mp3':                     
			case 'ogg':           
			case 'oga':           
				 $tipo_mensagem="audio";
				 $midia="arquivo";
				 break;												
		default:
			
	}
	
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
		
    if ( !isset($_SESSION['user_cli']) || $_SESSION['controle'] != '345067821133'  ) {

	    header("Location: index.php");
	
	  }
	else 
   	  {

			if (empty($whatsapp)) {
			   // UM MEIO DE SE SABER SE OS ÍTENS ESTÃO SENDO PASSADOS	
			   $response = array("proximasequencia" => '-1');
			   echo json_encode($response);
			}
			else
				
			{
					if ( isset($_FILES['file']) && !empty($_FILES['file']['name']) )
					{
						$file_name = $_FILES['file']['name'];
						$file_type = $_FILES['file']['type'];
						$file_size = $_FILES['file']['size'];
						$file_tmp_name = $_FILES['file']['tmp_name'];       

						    // TESTE - COMENTAR ANTES DE POR EM PRODUÇÃO
							// GRAVA UM LOG NO DISCO
							/*
							$fh = fopen("log.txt", "a+");

							if ($fh) {
                               $registro = "Tipo : ".$file_type.PHP_EOL . "EXTENSÃO : ".$extensao.PHP_EOL ;
							   fwrite($fh,$registro );
							   fclose($fh);
                            }
							*/
							// ******************************************
							
							
						$destino = 'file_upload/';                                // DIRETÓRIO DOS ARQUIVOS 
						
						
						// REMOVE ACENTOS E/OU CARACTERES ESPECIAIS DO NOME DO ARQUIVO
						$file_name = strtolower( preg_replace("/[^a-zA-Z0-9-.]/", "", strtr(utf8_decode(trim($file_name)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
						// RENOMEIA O ARQUIVO A SER CARREGADO ( UPLOAD)
                        $file_name = date(YmdHis).$_SESSION['user_cli'].$file_name;
						// *****************************************************************************************************************************
						
						
						
						//CAPTURA A URL COMPLETA PARA ONDE O ARQUIVO ESTÁ SENDO COPIADO
						$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
						$actual_link = str_replace("file_upload.php","",$actual_link);  // COMO É CAPTURADO O ARQUIVO QUE ESTÁ FAZENDI UPLOAD O RETIRA DA STRING
						$actual_link = $actual_link.$destino.$file_name;                // CAMINHO COMPLETO PARA ONDE O ARQUIVO ESTÁ SENDO COPIADO
						//
						// ****************************************************************************************************************************************
						

						if ( move_uploaded_file($file_tmp_name,$destino.$file_name)) {


							// GUARDA DATA E HORA DA MENSAGEM PARA SER UTILIZADO POSTERIORMENTE
							// ESSE MÉTODO NÃO INFORMA CORRETAMENTE A HORA CASO HAVIA HORÁRIO DE VERÃO E AGORA NÃO HÁ
							/*
							$data_hora = date("Y-m-d H:i:s");
							
							$dh = strtotime($data_hora);
							$dh = date('Y-m-d',$dh);	
							
							$dt = strtotime($data_hora);
							$dt = date('H:i',$dt);
							*/
							// ****************************************************************
						
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
							
							// CONVERTE DATA E HORA GUARDADOS PARA ENVIO DA MENSAGEM NO FORMATO INDICADO COMO ID DA MENSAGEM
							$dados['idmsg']= date('YmdHis',$data_hora);
							// *************************************************************************
						
							$dados['email']= $email;
							$dados['token']= $api_token ;
							$dados['idapp']= $idapp;
		
                            $url = $actual_link;
													

									
						    // COMENTAR A LINHA ABAIXO ANTES DE COLOCAR EM PRODUÇÃO
							// A LINHA ABAIXO É PARA TESTAR EM LOCALHOST
							// $erro="nao";
							// ****************************************************
							
							// PARA TESTAR EM LOCALHOST COMENTAR AS LINHAS ABAIXO
                            // ---> ANTES DE COLOCAR EM PRODUÇÃO, DESCOMENTAR AS LINHAS ABAIXP
							
							$dados['midia']= $midia ; 
							$dados['url_anexo']= $url; 
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
								
							
									
							// STATUS DO ENVIO DA SOLUTEK (RETORNO DA API)
							$retorno= json_decode($executa_api);
							$erro= $retorno->erro;
							$sobre_o_erro= $retorno->sobre_o_erro;
							$whatsapp_retorno= $retorno->whatsapp;
							$mensagem_retorno= $retorno->mensagem;
							$status= $retorno->status;
							$idlog= $retorno->idlog;
		
                            // **************************************************

							
							if ($erro="nao"){
								
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
		   
								
								$sql = "UPDATE contatos SET posicao='".$posicao."', status='"."1"."' WHERE numero='".$whatsapp."'";
								
								$result = mysqli_query($con,$sql);
							
									if ($result) {

									// SE O UPDATE NA TABELA contatos FOI BEM SUCEDIDO, VAI TENTAR GRAVAR NA TABELA whats_chat DO BANCO MYSQL
									$sql = "INSERT INTO whats_chat (entrada_saida,user_cli,whatsapp,status_cli,data_msg,hora_msg,status,";
									$sql .= "mensagem,tipo_mensagem,arquivo,referencia) ";
									$sql .= "VALUES (1,'{$user_cli}','{$whatsapp}','-1','{$dh}','{$dt}','0','{$mensagem}','{$tipo_mensagem}',";
									$sql .= "'{$actual_link}','{$file_name}')";

									// TESTE - COMENTAR ANTES DE POR EM PRODUÇÃO
									// GRAVA UM LOG NO DISCO

									/*
									$fh = fopen("log.txt", "a+");

									if ($fh) {
									   $registro = $sql.PHP_EOL ;
									   fwrite($fh,$registro );
									   fclose($fh);
									}
                                    */
									// ******************************************
							
									$result = mysqli_query($con,$sql);
				
									if ($result) {
									   // MENSAGEM/ARQUIVO ENVIADO 	
									   $response = array("proximasequencia" => $posicao, "link" => "");	
									}
									
									else 
									{
										
									}
								}   // if ($result) { DO UPDATE contatos
								
								
								else // ELSE if ($result) { DO UPDATE contatos
								   {
									
								   }
							    
								// **********************************************************************************
							    // Se tudo estiver correndo bem, exclui o arquivo que foi feito upload
								// Isso porque o nome do arquivo que está gravado no firebase é diferente
								// unlink($destino.$file_name);
								// ************************************************************************
								
							}   // ... De  if ($erro="nao"){
							
							else {
								 // PROBLEMA NO ENVIO DA MENSAGEM NO SERVIDOR
								 $response = array("proximasequencia" => '-3', "link" => '' );
							} 
		                     
						  
						  }      // ... De if ( move_uploaded_file($file_tmp_name,$destino.$file_name)) {
							  
						else {
							// ARQUIVO NÃO PODE SER CARREGADO PELO UPLOAD
							$response = array("proximasequencia" => '-2', "link" => '');
						}
						
						echo json_encode($response);
						 
					}
			}
	  }
	
	mysqli_close($con);
	
function getEncodedString($type, $file,$file_name) {
	//ATENÇÃO ATENÇÃO ATENÇÃO ATENÇÃO ATENÇÃO ATENÇÃO:
	//ESSA ROTINA FOI DESABILITADA.
	// DEIXADA PARA POSSÍVEL USO FUTURO
    //Codifica para Base64
	error_reporting(E_ERROR | E_PARSE);
	
	// $body= 'data:' . $type . ';base64,' . base64_encode(file_get_contents($file));
	
	
	if (substr($type,0,5) != "image") {
	   // Se não for imagem, acrescenta o nome do arquivo à Base64
	   $body= 'data:' . $type . ';base64,{'.$file_name.'}' . base64_encode(file_get_contents($file));
	}
	else {
		// Caso contrário, encodifica normal
		
		$body= 'data:' . $type . ';base64,'. base64_encode(file_get_contents($file));
	}
	
	
    if ( strlen($body) > 22 ){		
		return $body;
    }
	
    else{
		
		$body = "0";
		return $body;
	}

}
  
?>
