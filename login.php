<?php

    session_start();
	
	
	header("Content-type: text/html; charset=utf-8");
	
	include("dbcon/dbcon.php");
	
	$email = $_POST['email'];
    $senha = $_POST['senha'];
	
	// 19/02/2020 - EVITAR SQL INJECTION
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $response = array("success" => 0);
	   echo json_encode($response);
	   die();
	}
	else {
	   // E EVITA OS COMANDOS DE SQL ABAIXO 	
       $email = preg_replace( '/(from|select|insert|delete|where|drop|union|order|update|database)/i', '', $email );
       $email = preg_replace( '/(&lt;|<)?script(\/?(&gt;|>(.*))?)/i', '', $email );
       // **********************************
	   
	   // NA SENHA SÃO SOMENTE PERMITIDOS TRAÇOS(-),LETRAS, NÚMEROS,ESPAÇOS E _ ( UNDERSCORE)
	   $senha = preg_replace('/[^ \w-]/', '', $senha); 
	   // ******************************************************
	   // E EVITA OS COMANDOS DE SQL ABAIXO 
       $senha = preg_replace( '/(from|select|insert|delete|where|drop|union|order|update|database)/i', '', $senha );
       $senha = preg_replace( '/(&lt;|<)?script(\/?(&gt;|>(.*))?)/i', '', $senha );
	   // *********************************
    }
	
	// **********
	
    $controle = $_POST['controle'];
	
	// TESTE - COMENTAR AS LINHAS ABAIXO ANTES DE COLOCAR EM PRODUÇÃO
	// $email = 'suporte@primemas.com.br';
	// $email = 'email@email.com';
    // $senha = '1234';
    // $controle = '345067821133';	
	//***************************************************************
	
	if ($controle != '345067821133') {	   
	   header("Location: index.php");
	}

	else {
		
		 
		 
		 if (!empty($email) && !empty($senha) ) {
		
			    //CARREGA AS API'S
		
				$api_token = "";
				$api_email = "";
				$api_idapp = "";
				$api_checkphone = "";                                        // 22/08/2019
				$api_timezone_gmt = "";
				
				//ATENÇÃO : ID TEM QUE SER SEMPRE 1 E NÃO PODERÁ HAVER MAIS DE UMA LINHA NA TABELA
				$sql = "SELECT * FROM api WHERE id = 1";    
				$result=mysqli_query($con,$sql); 
				if(mysqli_num_rows($result))
					
					{  
						$row=mysqli_fetch_assoc($result);
				
						$api_token = $row["api_token"];
						$api_email = $row["api_email"];
						$api_idapp = $row["api_idapp"];
				        $api_checkphone = $row["api_checkphone"];
						$api_timezone_gmt = $row["api_timezone_gmt"];
						// 19/02/2020
						$info_atendente = $row["info_atendente"];           // Informa nome da atendente na mensagem
						$info_transferencia = $row["info_transferencia"];   // Informa nome da atendente nas transferências
						// **********************************************
						
						$api_token = trim($api_token);
						$api_email = trim ($api_email);
						$api_idapp = trim($api_idapp);
						$api_checkphone = trim($api_checkphone);
						$api_timezone_gmt = trim($api_timezone_gmt);
						
						if ( empty($api_token) || empty($api_email) || empty($api_idapp) || empty($api_checkphone) || empty($api_timezone_gmt) ) {
						
							mysqli_close($con);
							
							if (empty($api_token) ){
							   $response = array("success" => 4);
							}
							elseif (empty($api_email) ){
								   $response = array("success" => 5);
								}
							elseif (empty($api_idapp) ){
								   $response = array("success" => 6);
								}								
							elseif (empty($api_checkphone) ){
								   $response = array("success" => 7);
								}	
							elseif (empty($api_timezone_gmt) ){
								   $response = array("success" => 8);
								}	
								
							echo json_encode($response);
							
							die();						
						}
					}
					
				else {
					
						mysqli_close($con);
						
						$response = array("success" => 3);
						
						echo json_encode($response);
						
						die();
				}	
			
            // ** FIM DO CARREGAMENTO DAS API'S **
			//******************************************************************************************************
			
			
			$sql="SELECT user_cli,nome_cli,code_cli,email_cli,user_master,alerta_sonoro,logado FROM usuarios WHERE email_cli='$email' AND pass='$senha'";  
				
			$result=mysqli_query($con,$sql);  
		  
			if(mysqli_num_rows($result))
				
				{  
			        $row=mysqli_fetch_assoc($result);
					
					 //Sessions iniciadas
					$_SESSION['controle']=$controle;
					
					$_SESSION['user_cli']=$row["user_cli"]; 
					$_SESSION['nome_cli']=$row["nome_cli"];
					$_SESSION['user_master']=$row["user_master"];
					
					/*
					$_SESSION['status']      ??
					$_SESSION['status_n']    ??
					$_SESSION['limite_msg']  ??
					*/

					$_SESSION['code_cli']=$row["code_cli"];
					$_SESSION['email_cli']=$row["email_cli"];
					$_SESSION['user_master']=$row["user_master"];
					$_SESSION['alerta_sonoro']=$row["alerta_sonoro"];
					 //****************
					 
					
					 $_SESSION['api_token']= $api_token;
					 $_SESSION['api_email']= $api_email ;
					 $_SESSION['api_idapp']= $api_idapp ;
					 $_SESSION['api_checkphone']= $api_checkphone;       
                     
					 // GUARDA A ÁREA DE HORÁRIO NUMA SESSÃO
                     // $_SESSION['time_zone'] = "America/Sao Paulo";   // NÃO UTILIZADO
					 $_SESSION['h']= $api_timezone_gmt;                 // UTILIZADO NA INFORMAÇÃO DA DATE E HORA UTILIZANDO-SE
					                                                    // O HORÁRIO GMT - GREENWISH MEAN TIME 
																		// https://time.is/pt_br/GMT 
					 // ******************************************
					 
					 // 19/02/2020
					 $_SESSION['info_atendente'] = $info_atendente;
					 $_SESSION['info_transferencia'] = $info_transferencia;
					 // **********
					 
					 //TESTE - COMENTAR AS LINHAS ABAIXO ANTES DE COLOCAR EM PRODUÇÃO
					 // echo $_SESSION['api_idapp'];
					 // die();
					 //***************************************************************
					
					
					// Alterado por Julio 19/07/2019 status='-1'
					// if ($row["logado"] == 0 )  { 
					// 19/03/2020
					// ALTERADO POR HENRIQUE AYRES
					if ($row["logado"] == 0 || $row["logado"] == 1  )  { 
					   $response = array("success" => 1);
					   $sql="UPDATE usuarios SET logado = 1, status='-1' WHERE email_cli='$email' AND pass='$senha'";
					   $result=mysqli_query($con,$sql);
					}
					
					// 19/03/2020
					// RETIRADO POR SOLICITAÇÃO DE JULIO
					/*
					
					else {
					    
						mysqli_close($con);
						$response = array("success" => 2);
						
						echo json_encode($response);
						
						die();
					}
                    */
					// **************************************
					
					
					// ATIVAR USUÁRIO
					// CLIENTE DESEJADO
					$user_master = $_SESSION['user_master'];
					// *****************

					// USUÁRIO COMUM DESEJADO
					 $user_cli = $_SESSION['user_cli'];                         
					// *******************************************


					 
					if ($user_cli <> '' )

					{
						

						$rota_max = 0;

                        /* 
						$sql = "SELECT MAX(rota_max)+1 AS rota_max FROM usuarios WHERE user_cli='".$user_master."' AND user_master = '".$user_master."'";
						$resultado = mysqli_query($con,$sql);
						$num_row = mysqli_num_rows($resultado);

								if( $num_row > 0 ) {
									$linha = mysqli_fetch_array($resultado);
									$rota_max = $linha ['rota_max'];
									// echo $rota_max;
									// echo "<br>";
								}
						*/


                        // NOVA ABORDAGEM - 12/02/2020
						// MONTA, SEMPRE, A ROTA_MAX AO EFETUAR O LOGIN
						$sql = "SELECT COUNT(id) AS qtreg FROM usuarios WHERE rota > 0 ";
						 
						$result = mysqli_query($con,$sql );
						if(mysqli_num_rows($result)) {
								$row=mysqli_fetch_assoc($result);
								$rota_max = $row["qtreg"];                
							   
						}
			 
			            // ****************************
						
						
						if ($rota_max > 0 ) 
						{
							// Altera a rota máxima indicada no user_master
							
							$sql="UPDATE usuarios SET rota_max = ".$rota_max." WHERE user_cli='".$user_master."' AND user_master = '".$user_master."'";
							mysqli_query($con,$sql);
							$rows = mysqli_affected_rows($con);      // Para se saber se o UPDATE foi um sucesso
							
							if ($rows > 0 )
								// Tendo havido sucesso, altera a rota do usuário desejado
								// echo $rows;
								// echo "<br>";
								{
								 $sql="UPDATE usuarios SET rota = ".$rota_max." WHERE user_cli='".$user_cli."' AND user_master = '".$user_master."' AND rota = 0";
								 mysqli_query($con,$sql);
								 $rows = mysqli_affected_rows($con);      // Para se saber se o UPDATE foi um sucesso
								 
								 $sql="UPDATE usuarios SET status='-1' WHERE user_cli='".$user_cli."'";
								 mysqli_query($con,$sql);
								 $rows = mysqli_affected_rows($con);      // Para se saber se o UPDATE foi um sucesso
								 if ($rows > 0 )
								 {
									// echo "<br>";
									// echo "Registros alterados com sucesso ...";
								 }			 
							
								}	
						}

					}
					// ATIVAR USUÁRIO




				}  
			else  
				{
					$response = array("success" => 0);
				} 
			echo json_encode($response);
			
			
			
	     }  // if (!empty($email) && !empty($senha) ) {
		
 		 else {
			  header("Location: index.php");
		     }
	
	}
	
	mysqli_close($con);
	
?>

