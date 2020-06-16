<?php
include ('dbcon.php');

include('functions.php');

if(isset($_POST['email_adm']))
{
	$email_adm  = mysqli_real_escape_string($con,$_POST['email_adm']);
	$pass_adm = mysqli_real_escape_string($con,$_POST['pass_adm']);
	
	startNewSession($con,$email_adm, $pass_adm);
}
else
{
	testSessionData($con,$_SESSION['email_adm'], $_SESSION['pass_adm']);	
	}


$user_master    = $_SESSION['user_master'];
$user_cli    = $_SESSION['user_cli'];


$data_inicio = $_GET["data_inicio"];
$data_final = $_GET["data_final"];


$arquivo = "Leads.xls";               //Nome default do arquivo.xls

$xls_terminated = "\n";
$xls_row = "<tr>";
$xls_rowc = "</tr>";

$xls_td = '<td>';
$xls_tdc = '</td>';


	// USUÁRIO ADICIONAL
	// FAZ UMA QUERY DIRETA
	$query = "SELECT nome, numero, data_rg FROM contatos WHERE data_rg >= '".$data_inicio."' AND data_rg <= '".$data_final."' ORDER BY data_rg";


if ($result=mysqli_query($con,$query))
	
  {
    
       $xls = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns='http://www.w3.org/TR/REC-html40'>\n";
	   $xls .= "<head>\n";
	   $xls .= "<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->\n";
       $xls .= "</head>\n";
  
       $xls .="<body>\n";
	   $xls .="<table>\n";


          $xls .="<tr><td>Nome</td><td>Numero</td><td>Data de registro</td></tr>\n"; 
	   
		   while($reg = mysqli_fetch_object($result)){

				   $nome =  mb_convert_encoding($reg->nome, 'iso-8859-1','utf-8');          //Codifica para ISO-8859-1 ( ANSI)
				   $xls .= $xls_row.$xls_td.$nome.$xls_tdc;
				   $xls .= $xls_td.$reg->numero.$xls_tdc;
				   $xls .= $xls_td.$reg->data_rg.$xls_tdc.$xls_terminated;	
				  
  
		   }   // Primeiro while
		   
	   
	   $xls .="</table>"."\n";
       $xls .="</body>\n";
 	   $xls .="</html>\n";	 
       $xls .= "";

  } 

    //Aqui pergunta o nome do arquivo antes de gravar
 	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Length: " . strlen($xls));

	header("Content-type: application/txt ; charset=UTF-8",true);
	header("Content-Disposition: attachment; filename=$arquivo");
	
	echo $xls;
	
	mysqli_close($con);
	
	exit;
    //*************************************************
	
  
?>
