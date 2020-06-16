<?php

    session_start(); 
	
	header("Content-type: text/html; charset=utf-8");
		
	include("dbcon/dbcon.php");
	
    // EVITA INFORMAÇÃO DE ERRO DE LINHA
	error_reporting(E_ERROR | E_PARSE);
	// *********************************************************************************************
	
	$api_token = $_SESSION['api_token']; 
	$user_cli  = $_SESSION['user_cli'];
	
    // VARIÁVEIS FIXAS 
    $idapp= $_SESSION['api_idapp'];
    $email= $_SESSION['api_email'];
    $emoji= "nao";                    // DEFAULT = NAO //"sim" ou "nao"
    // ***************
	
	
	$mensagem = $_POST['mensagem'];
    $whatsapp = $_POST['telefone'];
    $tag_id = $_POST['tag_id'];

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

	else if ( empty($mensagem) || empty($whatsapp)  ) {
		
		$response = array("proximasequencia" => '-1',"status" => "");
	    echo json_encode($response);
	}
	else {

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
		
		// GUARDA DATA E HORA DA MENSAGEM PARA SER UTILIZADO POSTERIORMENTE
		// $idmsg= $dados['idmsg'];    // NÃO MAIS UTILIZADO                        
		// *****************************************************************
		
		$dados['midia']= "texto" ; 
		$dados['url_anexo']= ""; 
		$dados['whatsapp']= $whatsapp;
		
		// 19/02/2020
		if ($_SESSION['info_atendente'] == 0 ) {
		   $dados['mensagem']= $mensagem;
		}
		else {
		   $dados['mensagem']= $_SESSION['nome_cli']." diz: \n".$mensagem;		
		}
		// **********
		
		
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
		
			
		if ($erro="nao"){
		   // MENSAGEM ENVIADA
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
				   
			// ALTERA POSICAO DO CONTATO NA TABELA CONTATOS
			$sql = "UPDATE contatos SET posicao='".$posicao."', status='"."1"."' WHERE numero='".$whatsapp."'";
			
			$result = mysqli_query($con,$sql);
		    // ********************************************
			
			if ($result) {
				// SE O UPDATE NA TABELA contatos FOI BEM SUCEDIDO, VAI TENTAR GRAVAR NA TABELA whats_chat DO BANCO MYSQL
				$sql = "INSERT INTO whats_chat (entrada_saida,user_cli,whatsapp,status_cli,data_msg,hora_msg,status,";
				$sql .= "mensagem,tipo_mensagem, tag_id) ";
				$sql .= "VALUES (1,'{$user_cli}','{$whatsapp}','-1','{$dh}','{$dt}','0','{$mensagem}','chat', {$tag_id}";
				$sql .= ")";

				$result = mysqli_query($con,$sql);
				
				if($result) {
				   // SE O INSERT NA TABELA whats_chats FOI BEM SUCEDIDO, A MENSAGEM É GRAVADA NO MYSQL	
				   $response = array("proximasequencia" => $posicao,"status" => "");
				}
				else {
					$response = array("proximasequencia" => '-5',"status" => "");
				}
		    }
		    else
			{
				// SE O UPDATE NA TABELA CONTATOS NÃO FOI BEM SUCEDIDO, INFORMA QUE HOUVE ERRO
				$response = array("proximasequencia" => '-4',"status" => "");
			}	
			
			

		 
		} 
		else {
			 // PROBLEMA NO ENVIO DA MENSAGEM 
			 
			 $response = array("proximasequencia" => '-3',"status" => $sobre_o_erro );

		} 
		
	    echo json_encode($response);

	}

    mysqli_close($con);


?>