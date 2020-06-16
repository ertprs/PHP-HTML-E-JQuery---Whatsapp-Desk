<?php

	header("Content-Type: application/json; charset=utf-8");


    date_default_timezone_set('America/Sao_Paulo');
	
	require_once('vcard.php');                               //BIBLIOTECA VCARD
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
		$raw_payload = file_get_contents('php://input');	
		$data = json_decode($raw_payload, true);
									   
		if (is_array($data)) {

                
				// MENSAGENS TEXTO OU HEADER ( CABEÇALHO ) DE ARQUIVO ENVIADO 
				// MENSAGEM OU STATUS OU PERFIL
				$tipo        = $data ['tipo'];
				// **********************************************************
				
				
				if ($tipo != 'status' && $tipo != 'perfil'   ) {
					
							// EXEMPLO DE RETORNO DE MENSAGEM 
							/* {"tipo":"mensagem",
							    "whatsapp"    :"5524988670795",
								"mensagem"    :"Outro",                      // MENSAGEM PROPRIAMENTE DITA
								"horario_unix":"1579271621",
							    "idmsg"       :"68A7317325F3C4FDDB55320094D3E602",
								"nome_cliente":"Henrique Ayres",
								"nome_agenda" :"Henrique Ayres",
								"midia"       :"chat"
							*/
							// *******************************
							
							
							include("dbcon/dbcon.php");
							                       
							
							$idchat      = $data ['idmsg'];                  // ID da mensagem
							$whatsapp    = $data ['whatsapp'];               // Número do Whatsapp
							$img_icone   = $data ['img_icone'];              // numero_inexistente OU sem_imagem OU falhou
							$horario     = $data ['horario_unix'];           // Horário UNIX
							
							// CONVERSÃO DO HORÁRIO UNIX PARA O DE BRASÍLIA
							// RETIRADO 1h (3600) PARA ACERTAR COM O FUSO HORÁRIO DE BRASÍLIA
							//$timestamp   = $data['horario_unix']- 3600;      
							$timestamp   = $data['horario_unix']- 0; 
							
							$dh =date('Y-m-d',$timestamp);                   // Data
							$dt= date('H:i:s',$timestamp);                   // Hora
							// *************************************

							// A LINHA ABAIXO É PARA ATENDER A ESTRUTURA DA COMPOSIÇÃO DOS
							// NÚMEROS DO TELEFONE NO BRASIL
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
	                        // *************************************************************

							
							$nome_cliente= $data ['nome_cliente'];           // NOME DO CLIENTE
							
							
							if (trim($nome_cliente)=="") {
								$nome_cliente= $whatsapp;
							}

							// NOME DO DESTINATÁRIO NA AGENDA TELEFÔNICA NO CELULAR DO CLIENTE
							$nome_agenda = $data ['nome_agenda'];            
							if (trim($nome_agenda) == '') {
								$nome_agenda = $whatsapp;
							}
							// ********************************************************
														
							$midia      = $data['midia'];
							$referencia = "";                              // CONTEÚDO INICIAL

							if ($midia == "revoked") {
								// QUANDO A MÍDIA É REVOKED, SIGNIFICA QUE O CONTATO ENVIOU A INSTRUÇÃO DE APAGAR
								// A MENSAGEM ENVIADA PARA O DESTINATÁRIO NOS DOIS CELULARES
								// O WEBHOOK DEVE SER CANCELADO 
								mysqli_close($con);
								die();
							}
							
							if ($midia=="image") {
								$tipo       = "arquivo";                        
								$mimetype   = $data['mimetype'];
								$width      = $data['width'];
								$height     = $data['height'];
								$size       = $data['size'];
								$referencia = $data['referencia'];
								$legenda    = $data['legenda'];
							}
							else if ($midia=="ptt") {
								    $tipo       = "arquivo"; 
									$referencia = $data['referencia'];
									$mimetype   = "audio/ogg";                   // FIXO - GAMBIARRA
							} 
							else if ($midia=="document") {
								     $tipo       = "arquivo";
									 $referencia = $data['referencia'];
									 $mimetype   = $data['mimetype'];
							}
							
							else if ($midia=="video") {
								    $tipo       = "arquivo"; 
									$referencia = $data['referencia'];
									$mimetype   = $data['mimetype'];
							}
							
							else if ($midia=="vcard") {

									/**
									 * https://github.com/nuovo/vCard-parser 
									 * Test function for vCard content output
									 * @param vCard vCard object
									 */	 
								
                                     $strVcard = $data['mensagem'];
									  
									 $vCard = new vCard(
									 	// SE FOR TRADUZIR ARQUIVO VCF, INFORMAR CAMINHO E O ARQUIVO VCF  
										//'Example3.0.vcf', 
										// false, 
										// *************************************************************
										
										// SE FOR UTILIZAR vCard EM STRING
										'',
										$strVcard,
										// *************************************************************
										
										array( // Option array
											//  This lets you get single values for elements that could contain multiple values but have only one value.
											//	This defaults to false so every value that could have multiple values is returned as array.
											'Collapse' => false
										)
									 );


									 if (count($vCard) == 0)
									 {
										// SE A STRING ESTIVER VAZIA OU NÃO EXISTIR ARQUIO *.VCF, GERA ERRO
									 	throw new Exception('vCard test: empty vCard!');
									 }
									 // SE O ARQUIVO OU STRING CONTEM SOMENTE UM vCard, ELE É ACESSADP DIRETAMENTE.
									 elseif (count($vCard) == 1)
									 {
											$retorno = OutputvCard($vCard);
										
											$nomeconvidado = $retorno['nomegeral'];
											$telconvidado = $retorno['telefone'];
											// echo $nomeconvidado."<br>";
											// echo $telconvidado."<br>";
										
                                           /*
                                           // TESTE GRAVANDO NO DISCO O NOME E TELEFONE DO CONTATO										   
										   $filetosave = "log1.txt";
				   
										   $file = fopen($filetosave, 'w');
										   
										   if ($file) {
											   fwrite($file, $nomeconvidado.PHP_EOL . $telconvidado);
											   fclose($file);
										   }
										   */
										   
									 }
									
									 else
									 {
										// SE O ARQUIVO OU STRING CONTÉM MULTIPLOS vCards, ELES PODEM SE ACESSADOS COMO ELEMENTOS DE UM ARRAY  
										// NÃO UTILIZADO NO WEBHOOK.
										foreach ($vCard as $Index => $vCardPart)
										{
											OutputvCard($vCardPart);
										}
									 }
	
 
							} // FINAL DE else if ($midia=="vcard") {
							
                            $user_cli = "";            // DEFAULT
							
							
							if (trim($referencia) != "" ) {
								// É UM ARQUIVO
								$extensao = mime2ext($mimetype);               // PARA SE SABER A EXTENSÃO CORRETA
								$referencia = extrai_extensao($referencia);    // EXTRAI A EXTENSÃO QUE FOI INFORMADA EM $referencia
                                $referencia = $referencia.$extensao;           // ANEXA A EXTENSÃO CORRETA, SE FOR O CASO
							}
							
							   // NESSA ETAPA ESSA VERIFICAÇÃO É FEITA SOMENTE PARA MENSAGENS
							   // OU SEJA, QUANDO A VARIÁVEL $referencia ESTIVER VAZIA
							   
							   // 14/02/2020 - MELHORIA - CAPTURA A MÁXIMA POSICAO + 5
							   $sql = "SELECT IFNULL(MAX(posicao),0) + 5 AS posicao FROM contatos LIMIT 1";
							   $result = mysqli_query($con,$sql );

							   if(mysqli_num_rows($result)) {
									$row=mysqli_fetch_assoc($result);
									$posicao = $row["posicao"];          // CAPTURA A MÁXIMA POSIÇÃO
									if(is_null($posicao) || empty($posicao) ) {
										// SE NÃO HOUVER CONTATOS REGISTRADOS, INICIALIZA A POSIÇÃO
										$posicao = "5";
									}
								}				  
					
							    // FIM DA MELHORIA **********************
								  
                                // ESSA ROTINA É PARA CAPTURAR O user_cli DO CONTATO	POIS NO WEBHOOK NÃO HÁ $_SESSION
                                // 							   
							    $sql = "SELECT user_cli FROM contatos WHERE numero ='".$whatsapp."'";
							    $result = mysqli_query($con, $sql);
	
								if(mysqli_num_rows($result)) {
								  // ROTINA PARA CONTATO JÁ CADASTRADO 
								  $row=mysqli_fetch_assoc($result);
								  $user_cli = $row["user_cli"];          // CAPTURA O user_cli
								  

								  
								  // ALTERA A POSIÇÃO, STATUS E DATA DE RETORNO DO CONTATO
								  //$sql="UPDATE contatos SET status='0', posicao=posicao+5, data_rt='".$dh."' WHERE numero='".$whatsapp."'";
								  // 14/02/2020 - MELHORIA
								  $sql="UPDATE contatos SET status='0', posicao='".$posicao."', data_rt='".$dh."' WHERE numero='".$whatsapp."'";
								  // FIM DA MELHORIA ******
								  
								  mysqli_query($con,$sql);
									
								  if(mysqli_affected_rows($con) > 0 ) {
                                    // TUDO OK
									$ok = "1";
								  }								  
							   }
							   
							   else 
							   {
								   // ROTINA SE O CONTATO NÃO EXISTIR
								   // ******

								   // CAPTURA O USER_MASTER
								   $sql = "SELECT user_master FROM usuarios LIMIT 1";
								   
								   $result = mysqli_query($con,$sql );
									 if(mysqli_num_rows($result)) {
											$row=mysqli_fetch_assoc($result);
											$user_master = $row["user_master"];
																			
											
									 }					   

									// ****************************************
						
									$user_cli_seq = $user_master;
					
									$resultado = mysqli_query($con,"SELECT rota_min,rota_max FROM usuarios WHERE user_cli = '".$user_cli_seq."'" );
									$num_row = mysqli_num_rows($resultado);
									
									if( $num_row > 0 ) {
											
											
											while($linha = mysqli_fetch_array($resultado)){ 
											
											$rota_min = $linha['rota_min'];
											$rota_max = $linha['rota_max'];}
											
											$sql2 = "SELECT user_cli FROM usuarios WHERE user_master = '".$user_cli_seq."' AND rota= $rota_min";
											$resultado = mysqli_query($con,$sql2 );
											$num_row = mysqli_num_rows($resultado);
											
											if( $num_row > 0 ) {
												while($linha = mysqli_fetch_array($resultado)){
													$user_cli = $linha ['user_cli'];										
												} if ($rota_min != $rota_max) {
													$rota_min = $rota_min + 1;
												}else{$rota_min = 1;}
											}
											
										} 
											
											
									$sql = "UPDATE usuarios SET rota_min = $rota_min WHERE user_cli = '".$user_cli_seq."'";
									mysqli_query($con,$sql) or die(mysqli_error($con));
											
									// ***********************************
				

										// ****** ACRESCENTA O NOVO CONTATO *********
										
										// PRIMEIRAMENTE, OBTEM-SE A MÁXIMA POSIÇÃO + 5 DA TABELA DE CONTATOS PARA QUE O NOVO CLIENTE
										// ASSUMA A PRIMEIRA ORDEM NA LISTA DE CONTATOS
										

										$sql = "SELECT IFNULL(MAX(posicao),0) + 5 AS posicao FROM contatos LIMIT 1";
										$result = mysqli_query($con,$sql );

										if(mysqli_num_rows($result)) {
											$row=mysqli_fetch_assoc($result);
											$posicao = $row["posicao"];          // CAPTURA A MÁXIMA POSIÇÃO
											if(is_null($posicao) || empty($posicao) ) {
												// SE NÃO HOUVER CONTATOS REGISTRADOS, INICIALIZA A POSIÇÃO
												$posicao = "5";
											}
										}
										
										$data_rg = date("Y-m-d");
										$sql = "INSERT INTO contatos (nome, numero, status,posicao, user_cli, data_rg) "; 
										$sql .= "VALUES ('$nome_cliente', '$whatsapp', '0','$posicao', '$user_cli', '$data_rg')";

										$result = mysqli_query($con,$sql);
				
										
										if(mysqli_affected_rows($con) > 0 ) { //     PARA SE SABER SE A INCLUSÃO DO REGISTRO OBTEVE ÊXITO
										   // TUDO OK
										   $ok='1';
										}
										
								   //  ****** FIM DE ACRESCENTA O NOVO CONTATO *********
										
		
							   } // FIM DA ROTINA SE O CONTATO NÃO EXISTIR
							   
							 
							
                            $sql = "";	
							
							if ($ok=='1'){
									// if (trim($referencia) == "" || (trim($referencia) != "" && $midia =="video" )) {
									   if (trim($referencia) == "" ) {
										
									   // MENSAGEM COMUM RECEBIDA OU VCARD 
									   // MONTA A INSTRUÇÃO MYSQL
									   
									   // if ($midia !="vcard" && $midia !="video" ) {
									   if ($midia !="vcard" ) {
										   // MENSAGEM COMUM
									       $mensagem    = $data ['mensagem'];			     // Mensagem
										   $sql = "INSERT INTO whats_chat (entrada_saida,user_cli,whatsapp,status_cli,data_msg,hora_msg,status,";
										   $sql .= "mensagem,tipo_mensagem) ";
										   $sql .= "VALUES (0,'{$user_cli}','{$whatsapp}','-1','{$dh}','{$dt}','0','{$mensagem}','chat'";
										   $sql .= ")"; 										   
									   }

									   
									   elseif ($midia == "vcard")  {
										   // NOME DO CONVIDADO QUE IRÁ NO CAMPO MENSAGEM DA TABELA whats_chat
										   
										   
										   $sql = "INSERT INTO whats_chat (entrada_saida,user_cli,whatsapp,status_cli,data_msg,hora_msg,status,";
										   $sql .= "mensagem,tipo_mensagem,referencia) ";
										   $sql .= "VALUES (0,'{$user_cli}','{$whatsapp}','-1','{$dh}','{$dt}','0','{$nomeconvidado}','vcard','{$telconvidado}'";
										   $sql .= ")"; 
									   
									       /* TESTE GRAVANDO NO DISCO A STRING $SQL 
										   $filetosave = "log2.txt";
				   
										   $file = fopen($filetosave, 'w');
										   
										   if ($file) {
											   fwrite($file, $sql);
											   fclose($file);
										   }
										   */
									   }
 
									}
									else {
									   // ARQUIVO RECEBIDO
									   // MONTA A INSTRUÇÃO MYSQL
									   $mensagem    = "";			     				 // Mensagem tem que ser vazia
									   $sql = "INSERT INTO whats_chat_tmp (entrada_saida,user_cli,whatsapp,status_cli,data_msg,hora_msg,status,";
									   $sql .= "mensagem,tipo_mensagem,referencia) ";
									   $sql .= "VALUES (0,'{$user_cli}','{$whatsapp}','-1','{$dh}','{$dt}','0','{$mensagem}','{$midia}','{$referencia}'";
									   $sql .= ")";  									   
									}								
							   }


                               if ($sql != "") {
								   // SE A INSTRUÇÃO MYSQL FOI CONSTRÍDA SIGNIFICA QUE ESTÁ TUDO OK
                                   // ENTÃO VAI GRAVAR O REGISTRO NA TABELA whats_chat	OU whats_chat_tmp							   
								   $result = mysqli_query($con,$sql); // GRAVA A MENSAGEM
							   }
							       
                               
							   verifica_offline($con,$whatsapp) ;

							
							mysqli_close($con);

					} // if ($tipo != 'status' && $tipo != 'perfil'   ) 
						
					elseif ($tipo == 'perfil' ) {
					     
							 // VERIFICAÇÃO SE O NÚMERO DO TELEFONE ESTÁ CADASTRADO OU NÃO NO WHATSAPP
							 
							 $whatsapp        = $data ['whatsapp'];
							 $img_icone       = $data ['img_icone'];
							 
							 // A LINHA ABAIXO É PARA ATENDER A ESTRUTURA DA COMPOSIÇÃO DOS
							 // NÚMEROS DO TELEFONE NO BRASIL
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
							 // *************************************************************
							
					     if ($img_icone != 'numero_inexistente' ) {
							 
						    $midia           = "perfil";
						 
						    include("dbcon/dbcon.php");

						    $sql = "INSERT INTO whats_chat (entrada_saida,whatsapp,tipo_mensagem)";
						    $sql .= "VALUES (3,'{$whatsapp}','perfil'";
						    $sql .= ")";
										   
							// GRAVA NA TABELA DE MENSAGENS ( whats_chat) PROVISORIAMENTE OS CAMPOS ACIMA
                            // PARA DEPOIS DE UM DETERMINADO PERÍODO DE SEGUNDOS SER EXCLUÍDA PELO PROGRAMA
                            // whatsapp_verification.php.
                            // A EXCLUSÃO SIGNIFICA QUE O TELEFONE ESTÁ CADASTRADO NO WHATSAPP E 
                            // GERA UM CALLBACK ( $response = array("success" => '1'); )PARA A FUNÇÃO 
							// Verifica_WhatsApp EXISTENTE NO ARQUIVO  main_chat.js
 							
						    $result = mysqli_query($con,$sql); 
							
							// **********************************************************************
							
							
							
					        mysqli_close($con);
						}
					}
				
			}		
		else {

			    //  COMPLEMENTO REFERENTE A ARQUIVO ASSOCIADO
			  			
				include("dbcon/dbcon.php");
				
				$referencia  = $_POST ['referencia']; 
				// EXTRAI A EXTENSÃO QUE FOI INFORMADA EM $referencia PARA SER PESQUISADA POR referencia LIKE $referencia%
				// E CAPTURAR A REFERENCIA COM A EXTENSÃO CORRETA ( SE FOR O CASO ) DO ARQUIVO
				
				$referencia = extrai_extensao($referencia);
				
				$sql = "SELECT referencia FROM whats_chat_tmp WHERE referencia LIKE '{$referencia}%'";
			    $result = mysqli_query($con, $sql);

				if(mysqli_num_rows($result)) {
				   $row=mysqli_fetch_assoc($result);
				   $referencia = $row["referencia"];          // CAPTURA A REFERÊNCIA CORRETA JÁ GRAVADA DO HEADER ( CABEÇALHO )
				}
				else {
					mysqli_close($con);
					die();
				}				
				// *******************************************************************************************************
				
				// $base64      = $_POST ['base64'];
				$midia       = $_POST ['midia'];
								
				// CAMINHO DO ARQUIVO PARA SE FAZER DOWNLOAD
				$file_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$file_link = str_replace("webhook.php","",$file_link);     // TEM QUE SE TIRAR O NOME DO ARQUIVO QUE PROCESSA O WEBHOOK
				$file_link = $file_link."file_upload/".$referencia;        // LINK PARA SER INFORMADO NA TABELA whats_chat COLUNA arquivo
	            // ***************************************
				
				
				
				
				$sql = "UPDATE whats_chat_tmp  SET base64 = 'OK',arquivo = '{$file_link}' WHERE referencia = '{$referencia}'";
						
				mysqli_query($con,$sql);
									
				if(mysqli_affected_rows($con) > 0 ) {
									  
				   // ACHOU A REFERÊNCIA NO ARQUIVO TEMPORÁRIO - TUDO OK
				   // SPLITA O POST EM DOIS ARRAYS
				   // $image_parts = explode(";base64,", $base64);

				   // INFORMA O CONTEÚDO DO $_POST DIRETO PARA SER MAIS RÁPIDO
				   $image_parts = explode(";base64,", $_POST ['base64']);
				   
				   // NO SEGUNDO ARRAY ESTÁ O ARQUIVO PROPRIAMENTE DITO NA BASE64
				   $data = base64_decode($image_parts[1]);
				   // *************************************************
				   
				   $filetosave = dirname(__FILE__).'/file_upload/'.$referencia;
				   
				   $file = fopen($filetosave, 'w');
				   
				   if ($file) {
	                   fwrite($file, $data);
	                   fclose($file);
					   
					   if (file_exists($filetosave)) {
						   $sql = "SELECT entrada_saida,user_cli,whatsapp,status_cli,data_msg,hora_msg,status,mensagem,arquivo,tipo_mensagem,referencia ";
						   $sql .= "FROM whats_chat_tmp WHERE referencia = '{$referencia}' AND base64 = 'OK'";
						   
						   $result = mysqli_query($con, $sql);
						   
						   if(mysqli_num_rows($result)) {
							   
                              $row=mysqli_fetch_assoc($result);
							  
							  $user_cli   = $row['user_cli'];
							  $whatsapp   = $row['whatsapp'];
							  $dh         = $row['data_msg'];
							  $dt         = $row['hora_msg'];
							  $mensagem   = "";			            // MENSAGEM DEVE SER VAZIA
							  $arquivo    = $row['arquivo'];
							  $midia      = $row['tipo_mensagem'];
							  $referencia = $row['referencia'];
							  
							  $sql = "INSERT INTO whats_chat (entrada_saida,user_cli,whatsapp,status_cli,data_msg,hora_msg,status,";
							  $sql .= "mensagem,arquivo,tipo_mensagem,referencia) ";
						      $sql .= "VALUES (0,'{$user_cli}','{$whatsapp}','-1','{$dh}','{$dt}','0','{$mensagem}','{$arquivo}','{$midia}','{$referencia}'";
							  $sql .= ")"; 							  
							  
							  $result = mysqli_query($con,$sql); 
							  
							  if(mysqli_affected_rows($con) > 0 ) { //     PARA SE SABER SE A INCLUSÃO DO REGISTRO OBTEVE ÊXITO
							  
							     $sql = "DELETE FROM whats_chat_tmp WHERE referencia = '{$referencia}'";
								 
								 $result = mysqli_query($con,$sql);
								 
							  }
							  
						   }									   
					   }
                   }
                   else {
					    // PARA SABER SE HOUVE ALGUM PROBLEMA NA GRAVAÇÃO DO ARQUIVO A SER GERADO
						// DESCOMENTAR AS LINHAS ABAIXO.
						// UM ARQUIVO LOG.TXT É GRAVADO
						/*
					    unlink("log.txt");
					
					    $fh = fopen("log.txt", "w");

						if ($fh) {

						   $registro = "ERRO NA ABERTURA DO ARQUIVO";					   
						   fwrite($fh,$registro );
						   fclose($fh);

						}
					    */
				   }				   
				   
				    // PARA SABER O LINK CHEIO QUE DEVERÁ SER GRAVADO NA TABELA whats_chat_tmp NA COLUNA arquivo
					// DESCOMENTAR AS LINHAS ABAIXO
					// UM ARQUIVO LOG2.TXT É GRAVADO
					
					/*
				    unlink("log2.txt");
					
					$fh = fopen("log2.txt", "w");

					if ($fh) {

					   $registro = "Arquivo : ".$file_link;					   
					   fwrite($fh,$registro );
					   fclose($fh);

					}
				    */
					
			    }
             	else {
				   // NÃO ACHOU A REFERÊNCIA DO ARQUIVO TEMPORÁRIO
				}			
			
                mysqli_close($con);
			
				
		  }
	}
	
    else {

          echo "Método incorreto";
		  
	       // TESTE PARA SE SABER QUANDO O MÉTODO UTILIZADO NÃO É POST
		   // COMENTAR QUANDO COLOCAR EM PRODUÇAO
		   /*
           $fh = fopen("log.txt", "a+");

           if ($fh) {
              $registro = "Método incorreto".PHP_EOL ;
			  fwrite($fh,$registro );
			  fclose($fh);

		   }
		   */
           // ***************************************************************		   
	}

function mime2ext($mime) {
        $mime_map = [
            'video/3gpp2'                                                               => '3g2',
            'video/3gp'                                                                 => '3gp',
            'video/3gpp'                                                                => '3gp',
            'application/x-compressed'                                                  => '7zip',
            'audio/x-acc'                                                               => 'aac',
            'audio/ac3'                                                                 => 'ac3',
            'application/postscript'                                                    => 'ai',
            'audio/x-aiff'                                                              => 'aif',
            'audio/aiff'                                                                => 'aif',
            'audio/x-au'                                                                => 'au',
            'video/x-msvideo'                                                           => 'avi',
            'video/msvideo'                                                             => 'avi',
            'video/avi'                                                                 => 'avi',
            'application/x-troff-msvideo'                                               => 'avi',
            'application/macbinary'                                                     => 'bin',
            'application/mac-binary'                                                    => 'bin',
            'application/x-binary'                                                      => 'bin',
            'application/x-macbinary'                                                   => 'bin',
            'image/bmp'                                                                 => 'bmp',
            'image/x-bmp'                                                               => 'bmp',
            'image/x-bitmap'                                                            => 'bmp',
            'image/x-xbitmap'                                                           => 'bmp',
            'image/x-win-bitmap'                                                        => 'bmp',
            'image/x-windows-bmp'                                                       => 'bmp',
            'image/ms-bmp'                                                              => 'bmp',
            'image/x-ms-bmp'                                                            => 'bmp',
            'application/bmp'                                                           => 'bmp',
            'application/x-bmp'                                                         => 'bmp',
            'application/x-win-bitmap'                                                  => 'bmp',
            'application/cdr'                                                           => 'cdr',
            'application/coreldraw'                                                     => 'cdr',
            'application/x-cdr'                                                         => 'cdr',
            'application/x-coreldraw'                                                   => 'cdr',
            'image/cdr'                                                                 => 'cdr',
            'image/x-cdr'                                                               => 'cdr',
            'zz-application/zz-winassoc-cdr'                                            => 'cdr',
            'application/mac-compactpro'                                                => 'cpt',
            'application/pkix-crl'                                                      => 'crl',
            'application/pkcs-crl'                                                      => 'crl',
            'application/x-x509-ca-cert'                                                => 'crt',
            'application/pkix-cert'                                                     => 'crt',
            'text/css'                                                                  => 'css',
            'text/x-comma-separated-values'                                             => 'csv',
            'text/comma-separated-values'                                               => 'csv',
            'application/vnd.msexcel'                                                   => 'csv',
            'application/x-director'                                                    => 'dcr',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
            'application/x-dvi'                                                         => 'dvi',
            'message/rfc822'                                                            => 'eml',
            'application/x-msdownload'                                                  => 'exe',
            'video/x-f4v'                                                               => 'f4v',
            'audio/x-flac'                                                              => 'flac',
            'video/x-flv'                                                               => 'flv',
            'image/gif'                                                                 => 'gif',
            'application/gpg-keys'                                                      => 'gpg',
            'application/x-gtar'                                                        => 'gtar',
            'application/x-gzip'                                                        => 'gzip',
            'application/mac-binhex40'                                                  => 'hqx',
            'application/mac-binhex'                                                    => 'hqx',
            'application/x-binhex40'                                                    => 'hqx',
            'application/x-mac-binhex40'                                                => 'hqx',
            'text/html'                                                                 => 'html',
            'image/x-icon'                                                              => 'ico',
            'image/x-ico'                                                               => 'ico',
            'image/vnd.microsoft.icon'                                                  => 'ico',
            'text/calendar'                                                             => 'ics',
            'application/java-archive'                                                  => 'jar',
            'application/x-java-application'                                            => 'jar',
            'application/x-jar'                                                         => 'jar',
            'image/jp2'                                                                 => 'jp2',
            'video/mj2'                                                                 => 'jp2',
            'image/jpx'                                                                 => 'jp2',
            'image/jpm'                                                                 => 'jp2',
			'image/jpg'                                                                 => 'jpg',
            'image/jpeg'                                                                => 'jpg',
            'image/pjpeg'                                                               => 'jpeg',
            'application/x-javascript'                                                  => 'js',
            'application/json'                                                          => 'json',
            'text/json'                                                                 => 'json',
            'application/vnd.google-earth.kml+xml'                                      => 'kml',
            'application/vnd.google-earth.kmz'                                          => 'kmz',
            'text/x-log'                                                                => 'log',
            'audio/x-m4a'                                                               => 'm4a',
            'application/vnd.mpegurl'                                                   => 'm4u',
            'audio/midi'                                                                => 'mid',
            'application/vnd.mif'                                                       => 'mif',
            'video/quicktime'                                                           => 'mov',
            'video/x-sgi-movie'                                                         => 'movie',
            'audio/mpeg'                                                                => 'mp3',
            'audio/mpg'                                                                 => 'mp3',
            'audio/mpeg3'                                                               => 'mp3',
            'audio/mp3'                                                                 => 'mp3',
            'video/mp4'                                                                 => 'mp4',
            'video/mpeg'                                                                => 'mpeg',
            'application/oda'                                                           => 'oda',
            'audio/ogg'                                                                 => 'ogg',
            'video/ogg'                                                                 => 'ogg',
            'application/ogg'                                                           => 'ogg',
            'application/x-pkcs10'                                                      => 'p10',
            'application/pkcs10'                                                        => 'p10',
            'application/x-pkcs12'                                                      => 'p12',
            'application/x-pkcs7-signature'                                             => 'p7a',
            'application/pkcs7-mime'                                                    => 'p7c',
            'application/x-pkcs7-mime'                                                  => 'p7c',
            'application/x-pkcs7-certreqresp'                                           => 'p7r',
            'application/pkcs7-signature'                                               => 'p7s',
            'application/pdf'                                                           => 'pdf',
            'application/octet-stream'                                                  => 'pdf',
            'application/x-x509-user-cert'                                              => 'pem',
            'application/x-pem-file'                                                    => 'pem',
            'application/pgp'                                                           => 'pgp',
            'application/x-httpd-php'                                                   => 'php',
            'application/php'                                                           => 'php',
            'application/x-php'                                                         => 'php',
            'text/php'                                                                  => 'php',
            'text/x-php'                                                                => 'php',
            'application/x-httpd-php-source'                                            => 'php',
            'image/png'                                                                 => 'png',
            'image/x-png'                                                               => 'png',
            'application/powerpoint'                                                    => 'ppt',
            'application/vnd.ms-powerpoint'                                             => 'ppt',
            'application/vnd.ms-office'                                                 => 'ppt',
            'application/msword'                                                        => 'doc',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/x-photoshop'                                                   => 'psd',
            'image/vnd.adobe.photoshop'                                                 => 'psd',
            'audio/x-realaudio'                                                         => 'ra',
            'audio/x-pn-realaudio'                                                      => 'ram',
            'application/x-rar'                                                         => 'rar',
            'application/rar'                                                           => 'rar',
            'application/x-rar-compressed'                                              => 'rar',
            'audio/x-pn-realaudio-plugin'                                               => 'rpm',
            'application/x-pkcs7'                                                       => 'rsa',
            'text/rtf'                                                                  => 'rtf',
            'text/richtext'                                                             => 'rtx',
            'video/vnd.rn-realvideo'                                                    => 'rv',
            'application/x-stuffit'                                                     => 'sit',
            'application/smil'                                                          => 'smil',
            'text/srt'                                                                  => 'srt',
            'image/svg+xml'                                                             => 'svg',
            'application/x-shockwave-flash'                                             => 'swf',
            'application/x-tar'                                                         => 'tar',
            'application/x-gzip-compressed'                                             => 'tgz',
            'image/tiff'                                                                => 'tiff',
            'text/plain'                                                                => 'txt',
            'text/x-vcard'                                                              => 'vcf',
            'application/videolan'                                                      => 'vlc',
            'text/vtt'                                                                  => 'vtt',
            'audio/x-wav'                                                               => 'wav',
            'audio/wave'                                                                => 'wav',
            'audio/wav'                                                                 => 'wav',
            'application/wbxml'                                                         => 'wbxml',
            'video/webm'                                                                => 'webm',
            'audio/x-ms-wma'                                                            => 'wma',
            'application/wmlc'                                                          => 'wmlc',
            'video/x-ms-wmv'                                                            => 'wmv',
            'video/x-ms-asf'                                                            => 'wmv',
            'application/xhtml+xml'                                                     => 'xhtml',
            'application/excel'                                                         => 'xl',
            'application/msexcel'                                                       => 'xls',
            'application/x-msexcel'                                                     => 'xls',
            'application/x-ms-excel'                                                    => 'xls',
            'application/x-excel'                                                       => 'xls',
            'application/x-dos_ms_excel'                                                => 'xls',
            'application/xls'                                                           => 'xls',
            'application/x-xls'                                                         => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
            'application/vnd.ms-excel'                                                  => 'xls',
            'application/xml'                                                           => 'xml',
            'text/xml'                                                                  => 'xml',
            'text/xsl'                                                                  => 'xsl',
            'application/xspf+xml'                                                      => 'xspf',
            'application/x-compress'                                                    => 'z',
            'application/x-zip'                                                         => 'zip',
            'application/zip'                                                           => 'zip',
            'application/x-zip-compressed'                                              => 'zip',
            'application/s-compressed'                                                  => 'zip',
            'multipart/x-zip'                                                           => 'zip',
            'text/x-scriptzsh'                                                          => 'zsh',
        ];

        return isset($mime_map[$mime]) === true ? $mime_map[$mime] : false;
    }

    /*
	
	ATENÇÃO : 
	     'image/jpg'                                                                 => 'jpg', 
    NÃO EXISTE , MAS ÀS VEZES ESSE MIME TYPE É INFORMADO. POR ISSO ESTÁ NO ARRAY
	
	ATENÇÃO : 
         'image/jpeg'                                                                => 'jpg',
	FOI TRADUZIDO PARA A EXTENSÃO .JPG ( QUE É MAIS COMUM E MAIS CONHECIDA ) AO INVÉS DE JPEG
	
	
	*/

function extrai_extensao($filename) {
	
	$filename = strrev($filename);                     // INVERTE A STRING PARA CAPTURAR O VERDADEIRO PONTO DA EXTENSÃO
	$firstdotpos = strpos($filename, '.');             // CALCULA EM QUE POSIÇÃO ESSE PONTO (.) ESTÁ
	
	// REMONTA O NOME DO ARQUIVO SEM A EXTENSÃO MAS COM O PONTO
	$filename2 = substr($filename,($firstdotpos),strlen($filename));
	$filename2 = strrev($filename2);  
    // ****************************************
	
    return $filename2;
	
}	

// LINHAS ABAIXO COM FUNÇÕES PARA EXTRAIR DADOS CORRETAMENTE DO VCARD 

function OutputvCard(vCard $vCard)
	{
		// echo '<h2>'.$vCard -> FN[0].'</h2>';   // CABEÇALHO DO VCARD

		if ($vCard -> PHOTO)
		{
			foreach ($vCard -> PHOTO as $Photo)
			{
				// FOTO 
				if ($Photo['Encoding'] == 'b')
				{
					// echo '<img src="data:image/'.$Photo['Type'][0].';base64,'.$Photo['Value'].'" /><br />';
				}
				else
				{
					// echo '<img src="'.$Photo['Value'].'" /><br />';
				}

				/*
				// It can also be saved to a file
				try
				{
					$vCard -> SaveFile('photo', 0, 'test_image.jpg');
					// The parameters are:
					//	- name of the file we want to save (photo, logo or sound)
					//	- index of the file in case of multiple files (defaults to 0)
					//	- target path to save to, including the filenam
				}
				catch (Exception $E)
				{
					// Target path not writable
				}
				*/
			}
		}

		foreach ($vCard -> N as $Name)
		{
			// NOME
			$nomegeral = $Name['FirstName'].' '.$Name['LastName'];
			
		}

		foreach ($vCard -> ORG as $Organization)
		{
			// ORGANIZAÇÃO
			/*
			echo '<h3>Organização: '.$Organization['Name'].
				($Organization['Unit1'] || $Organization['Unit2'] ?
					' ('.implode(', ', array($Organization['Unit1'], $Organization['Unit2'])).')' :
					''
				).'</h3>';
		    */
		}

		if ($vCard -> TEL)
		{
			// TELEFONE
			foreach ($vCard -> TEL as $Tel)
			{
				if (is_scalar($Tel))
				{
					
					$telefone = $Tel;
				}
				else
				{
					$telefone = $Tel['Value'];
				}
			}
			    
		}

		if ($vCard -> EMAIL)
		{
			// EMAIL
			foreach ($vCard -> EMAIL as $Email)
			{
				if (is_scalar($Email))
				{
					// echo $Email;
				}
				else
				{
					// echo $Email['Value'].' ('.implode(', ', $Email['Type']).')<br />';
				}
			}
			
			
		}

		if ($vCard -> URL)
		{
			foreach ($vCard -> URL as $URL)
			{
				if (is_scalar($URL))
				{
					// echo $URL.'<br />';
				}
				else
				{
					// echo $URL['Value'].'<br />';
				}
			}	
		}

		if ($vCard -> IMPP)
		{
			// MENSAGEM INSTANTÂNEA
			foreach ($vCard -> IMPP as $IMPP)
			{
				if (is_scalar($IMPP))
				{
					// echo $IMPP.'<br />';
				}
				else
				{
					// echo $IMPP['Value'].'<br/ >';
				}
			}
			
		}

		if ($vCard -> ADR)
		{
			// ENDEREÇO
			/*
			foreach ($vCard -> ADR as $Address)
			{
				echo '<p><h4>Address ('.implode(', ', $Address['Type']).')</h4>';
				echo 'Street address: <strong>'.($Address['StreetAddress'] ? $Address['StreetAddress'] : '-').'</strong><br />'.
					'PO Box: <strong>'.($Address['POBox'] ? $Address['POBox'] : '-').'</strong><br />'.
					'Extended address: <strong>'.($Address['ExtendedAddress'] ? $Address['ExtendedAddress'] : '-').'</strong><br />'.
					'Locality: <strong>'.($Address['Locality'] ? $Address['Locality'] : '-').'</strong><br />'.
					'Region: <strong>'.($Address['Region'] ? $Address['Region'] : '-').'</strong><br />'.
					'ZIP/Post code: <strong>'.($Address['PostalCode'] ? $Address['PostalCode'] : '-').'</strong><br />'.
					'Country: <strong>'.($Address['Country'] ? $Address['Country'] : '-').'</strong>';
			}
			echo '</p>';
			*/
		}

		if ($vCard -> AGENT)
		{
			// AGENTE
			/*
			
			foreach ($vCard -> AGENT as $Agent)
			{
				if (is_scalar($Agent))
				{
					echo '<div class="Agent">'.$Agent.'</div>';
				}
				elseif (is_a($Agent, 'vCard'))
				{
					echo '<div class="Agent">';
					OutputvCard($Agent);
					
				}
			}
		  */
		}
		
		$retorno = recebe_vcard ($nomegeral,$telefone);
		
	    $array = array("nomegeral" => $retorno['nomegeral'],"telefone" => $retorno['telefone']);
	
	    return $array;
	
} // FINAL DE function OutputvCard(vCard $vCard)
	
function recebe_vcard ($nomegeral,$telefone) {
	
	$telefone = str_replace('+','',$telefone);
	$telefone = str_replace(' ','',$telefone);
	$telefone = str_replace('-','',$telefone);
	
	
	$array = array("nomegeral" => $nomegeral,"telefone" => $telefone);
	
	return $array;
	
}

// FINAL DAS FUNÇÕES PARA EXTRAIR DADOS CORRETAMENTE DO VCARD 

function verifica_offline ($con,$whatsapp) {
	
	// FUNÇÃO PARA ENVIAR MENSAGEM AO CLIENTE CASO NÃO EXISTIR ATENDENTE ONLINE

	//ATENÇÃO : ID TEM QUE SER SEMPRE 1 E NÃO PODERÁ HAVER MAIS DE UMA LINHA NA TABELA
	$sql = "SELECT * FROM api WHERE id = 1";    
	$result=mysqli_query($con,$sql); 
	if(mysqli_num_rows($result))
		
		{  
			$row=mysqli_fetch_assoc($result);
	
			$api_token = $row["api_token"];
			$api_email = $row["api_email"];
			$api_idapp = $row["api_idapp"];
			$api_timezone_gmt = $row["api_timezone_gmt"];
			
			$sql = "SELECT logado FROM usuarios WHERE logado = 1 AND status='-1' LIMIT 1";
			$result=mysqli_query($con,$sql); 
			
			if(mysqli_num_rows($result) ) {
			  // HÁ ATENDENTE ONLINE		
			}
			else {
			  // NÃO HÁ ATENDENTE ONLINE

				$h = $api_timezone_gmt;   // ESSE VALOR É INFORMADO no campo api_timezone_gmt E CORRESPONDE
				                          // AO FUSO HORÁRIO EM RELAÇÃO A GREENWICH
				//******************************************************************************************
				
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
			
			    $dados['token']= $api_token;
				$dados['email']= $api_email;
				$dados['idapp']= $api_idapp;
				
				// GUARDA DATA E HORA DA MENSAGEM PARA SER UTILIZADO POSTERIORMENTE
				// $idmsg= $dados['idmsg'];    // NÃO MAIS UTILIZADO                        
				// *****************************************************************
				
				$sql = "SELECT * FROM api WHERE id = 1";    
				$result=mysqli_query($con,$sql); 
				if(mysqli_num_rows($result))
				
				{  
				$row=mysqli_fetch_assoc($result);
				
				$msg_off = $row["msg_off"];
				
					$mensagem = $msg_off;
				
				}
				
				$dados['midia']= "texto" ; 
				$dados['url_anexo']= ""; 
				$dados['whatsapp']= $whatsapp;
				$dados['mensagem']= $mensagem;
				$dados['emoji']= "nao";
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


			
		    }
		}
					
	
}
?>
