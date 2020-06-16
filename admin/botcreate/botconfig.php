<?php

	session_start();
	
    header("Content-type: text/html; charset=utf-8");
	
	// PROVISÓRIO
	// SERÁ A $_SESSION QUE VIRÁ DO LOGIN
    if ( !isset($_SESSION['email_cli'])) {
	 //   header("Location: index.php");
	}
	// ***********************************
	
	else {
		

			include("../dbcon.php");
			
			/*
			// Teste EXEMPLO para se saber se os dados estão sendo enviados no POST
			// São gravados no disco
			$fh = fopen("dados.txt", "a+");

					if ($fh) {
						
						 fwrite($fh, $_POST['chkImagem'].PHP_EOL);
						 fwrite($fh, $_POST['txtCabecalho'].PHP_EOL);
						 fwrite($fh, $_POST['txtItem1Inicial'].PHP_EOL);
						 fwrite($fh, $_POST['txtItem2Inicial'].PHP_EOL);
						 fclose($fh);
					}
			*/

			$imagem = trim($_POST['chkImagem']);
			if (trim($imagem)== "") {
				$imagem = 0;
			}
			
			$cabecalho = trim($_POST['txtCabecalho']);
			$item1inicial = $_POST['txtItem1Inicial'];
			$item2inicial = $_POST['txtItem2Inicial'];
			$item3inicial = $_POST['txtItem3Inicial'];
			$item4inicial = $_POST['txtItem4Inicial'];
			$item5inicial = $_POST['txtItem5Inicial'];
			$item6inicial = $_POST['txtItem6Inicial'];
			$item7inicial = $_POST['txtItem7Inicial'];
			$item8inicial = $_POST['txtItem8Inicial'];
			$item9inicial = $_POST['txtItem9Inicial'];
			$item10inicial = $_POST['txtItem10Inicial'];
			
			$respostaitem1inicial = $_POST['txtRespostaItem1Inicial'];
			$respostaitem2inicial = $_POST['txtRespostaItem2Inicial'];
			$respostaitem3inicial = $_POST['txtRespostaItem3Inicial'];
			$respostaitem4inicial = $_POST['txtRespostaItem4Inicial'];
			$respostaitem5inicial = $_POST['txtRespostaItem5Inicial'];
			$respostaitem6inicial = $_POST['txtRespostaItem6Inicial'];
			$respostaitem7inicial = $_POST['txtRespostaItem7Inicial'];
			$respostaitem8inicial = $_POST['txtRespostaItem8Inicial'];
			$respostaitem9inicial = $_POST['txtRespostaItem9Inicial'];
			$respostaitem10inicial = $_POST['txtRespostaItem10Inicial'];
			
			$respostaitem1nivel2 = $_POST['txtRespostaItem1Nivel2'];
			$respostaitem2nivel2 = $_POST['txtRespostaItem2Nivel2'];
			$respostaitem3nivel2 = $_POST['txtRespostaItem3Nivel2'];
			$respostaitem4nivel2 = $_POST['txtRespostaItem4Nivel2'];
			$respostaitem5nivel2 = $_POST['txtRespostaItem5Nivel2'];
			$respostaitem6nivel2 = $_POST['txtRespostaItem6Nivel2'];
			$respostaitem7nivel2 = $_POST['txtRespostaItem7Nivel2'];
			$respostaitem8nivel2 = $_POST['txtRespostaItem8Nivel2'];
			$respostaitem9nivel2 = $_POST['txtRespostaItem9Nivel2'];
			$respostaitem10nivel2 = $_POST['txtRespostaItem10Nivel2'];
	
	        $id = 0;                                     // Default
			$pivot = "";                                 // DEFAULT BY-PASS para quando o registro está duplicado

	        $sql = "SELECT id FROM botconfig LIMIT 1";
			
			$result = mysqli_query($con,$sql);           // Verifica se já há registro
			
			if(mysqli_num_rows($result)) {
				
			   $rows = mysqli_fetch_assoc($result);
			   $id = $rows['id'];
			}   

			if ($id == 0 )
			   {	
                    		   
					$query = sprintf("INSERT INTO botconfig (id,imagem,cabecalho,
									 item1inicial,item2inicial,item3inicial,item4inicial,item5inicial,
									 item6inicial,item7inicial,item8inicial,item9inicial,item10inicial,
									 respostaitem1inicial,respostaitem2inicial,respostaitem3inicial,respostaitem4inicial,respostaitem5inicial,
									 respostaitem6inicial,respostaitem7inicial,respostaitem8inicial,respostaitem9inicial,respostaitem10inicial,
									 respostaitem1nivel2,respostaitem2nivel2,respostaitem3nivel2,respostaitem4nivel2,respostaitem5nivel2,
									 respostaitem6nivel2,respostaitem7nivel2,respostaitem8nivel2,respostaitem9nivel2,respostaitem10nivel2) 
									 VALUES ('%u','%u','%s',
											 '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',
											 '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',
											 '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", 
									
									 
									 mysqli_real_escape_string($con,1),
									 mysqli_real_escape_string($con,$imagem),
									 mysqli_real_escape_string($con,$cabecalho),
									 
									 mysqli_real_escape_string($con,$item1inicial),
									 mysqli_real_escape_string($con,$item2inicial),
									 mysqli_real_escape_string($con,$item3inicial),
									 mysqli_real_escape_string($con,$item4inicial),
									 mysqli_real_escape_string($con,$item5inicial),
									 mysqli_real_escape_string($con,$item6inicial),
									 mysqli_real_escape_string($con,$item7inicial),
									 mysqli_real_escape_string($con,$item8inicial),
									 mysqli_real_escape_string($con,$item9inicial),
									 mysqli_real_escape_string($con,$item10inicial),

									 mysqli_real_escape_string($con,$respostaitem1inicial),
									 mysqli_real_escape_string($con,$respostaitem2inicial),
									 mysqli_real_escape_string($con,$respostaitem3inicial),
									 mysqli_real_escape_string($con,$respostaitem4inicial),
									 mysqli_real_escape_string($con,$respostaitem5inicial),
									 mysqli_real_escape_string($con,$respostaitem6inicial),
									 mysqli_real_escape_string($con,$respostaitem7inicial),
									 mysqli_real_escape_string($con,$respostaitem8inicial),
									 mysqli_real_escape_string($con,$respostaitem9inicial),
									 mysqli_real_escape_string($con,$respostaitem10inicial),
									 
									 mysqli_real_escape_string($con,$respostaitem1nivel2),
									 mysqli_real_escape_string($con,$respostaitem2nivel2),
									 mysqli_real_escape_string($con,$respostaitem3nivel2),
									 mysqli_real_escape_string($con,$respostaitem4nivel2),
									 mysqli_real_escape_string($con,$respostaitem5nivel2),
									 mysqli_real_escape_string($con,$respostaitem6nivel2),
									 mysqli_real_escape_string($con,$respostaitem7nivel2),
									 mysqli_real_escape_string($con,$respostaitem8nivel2),
									 mysqli_real_escape_string($con,$respostaitem9nivel2),
									 mysqli_real_escape_string($con,$respostaitem10nivel2)
									 );

							 
			   }
			   else {

				   $query = sprintf("UPDATE botconfig SET imagem = '%u',cabecalho = '%s',
                                    item1inicial = '%s',item2inicial = '%s',item3inicial = '%s',item4inicial = '%s',item5inicial = '%s',
                                    item6inicial = '%s',item7inicial = '%s',item8inicial = '%s',item9inicial = '%s',item10inicial = '%s',
                                    respostaitem1inicial = '%s',respostaitem2inicial = '%s',respostaitem3inicial = '%s',respostaitem4inicial = '%s',
									respostaitem5inicial = '%s',									
                                    respostaitem6inicial = '%s',respostaitem7inicial = '%s',respostaitem8inicial = '%s',respostaitem9inicial = '%s',
									respostaitem10inicial = '%s', 

                                    respostaitem1nivel2 = '%s',respostaitem2nivel2 = '%s',respostaitem3nivel2 = '%s',respostaitem4nivel2 = '%s',
									respostaitem5nivel2 = '%s',									
                                    respostaitem6nivel2 = '%s',respostaitem7nivel2 = '%s',respostaitem8nivel2 = '%s',respostaitem9nivel2 = '%s',
									respostaitem10nivel2 = '%s' 
									
                                    WHERE id = {$id}",
								    mysqli_real_escape_string($con,$imagem),
									mysqli_real_escape_string($con,$cabecalho),
									
									mysqli_real_escape_string($con,$item1inicial),
									

									mysqli_real_escape_string($con,$item2inicial),
									mysqli_real_escape_string($con,$item3inicial),
									mysqli_real_escape_string($con,$item4inicial),
									mysqli_real_escape_string($con,$item5inicial),
									mysqli_real_escape_string($con,$item6inicial),
									mysqli_real_escape_string($con,$item7inicial),
									mysqli_real_escape_string($con,$item8inicial),
									mysqli_real_escape_string($con,$item9inicial),
									mysqli_real_escape_string($con,$item10inicial),
									
									mysqli_real_escape_string($con,$respostaitem1inicial),
									mysqli_real_escape_string($con,$respostaitem2inicial),
									mysqli_real_escape_string($con,$respostaitem3inicial),
									mysqli_real_escape_string($con,$respostaitem4inicial),
									mysqli_real_escape_string($con,$respostaitem5inicial),
									mysqli_real_escape_string($con,$respostaitem6inicial),
									mysqli_real_escape_string($con,$respostaitem7inicial),
									mysqli_real_escape_string($con,$respostaitem8inicial),
									mysqli_real_escape_string($con,$respostaitem9inicial),
									mysqli_real_escape_string($con,$respostaitem10inicial),
									

								    mysqli_real_escape_string($con,$respostaitem1nivel2),
									mysqli_real_escape_string($con,$respostaitem2nivel2),
									mysqli_real_escape_string($con,$respostaitem3nivel2),
									mysqli_real_escape_string($con,$respostaitem4nivel2),
									mysqli_real_escape_string($con,$respostaitem5nivel2),
									mysqli_real_escape_string($con,$respostaitem6nivel2),
									mysqli_real_escape_string($con,$respostaitem7nivel2),
									mysqli_real_escape_string($con,$respostaitem8nivel2),
									mysqli_real_escape_string($con,$respostaitem9nivel2),
									mysqli_real_escape_string($con,$respostaitem10nivel2)
									);									
			   }
			   
			   $result = mysqli_query($con,$query);
			   
			    if(mysqli_affected_rows($con) > 0 ) { //     Para se saber se a inclusão teve êxito		
					   if ($id==0) {
						   $response = array("success" => true,"situacao" => 'Ítens do Bot incluídos com sucesso');
					   }
					   else {
						   $response = array("success" => true,"situacao" => 'Ítens do Bot alterados com sucesso');
					   }				   
				 }
				else {
					  if ($id==0) { 
						$response = array("success" => false,"situacao" => 'Não foi possível incluir ítens do Bot'); 
					  }
					  else {
						  $response = array("success" => false,"situacao" => 'Não foi necessário alterar os ítens Bot'); 
					  }   
			     }
				
                echo json_encode($response);
				
							 
	        mysqli_close($con);
			
			
		}
	
?>
