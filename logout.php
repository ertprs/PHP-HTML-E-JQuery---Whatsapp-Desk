<?php

session_start();

include("dbcon/dbcon.php");

$user_master = $_SESSION['user_master'];
$user_cli    = $_SESSION['user_cli'];                         
$email_cli   = $_SESSION['email_cli'];


$sql = "UPDATE usuarios SET logado=0 WHERE email_cli = '".$email_cli."' AND user_cli='".$user_cli."' AND user_master = '".$user_master."'";
mysqli_query($con,$sql);
// ************************************************************************

$sql = "UPDATE usuarios SET status=0 WHERE email_cli = '".$email_cli."' AND user_cli='".$user_cli."' AND user_master = '".$user_master."'";
mysqli_query($con,$sql);
// ************************************************************************


$sql = "SELECT id,user_cli,rota_max,rota,user_master FROM usuarios WHERE user_master='".$user_master."'";
$resultado = mysqli_query($con,$sql);
$num_row = mysqli_num_rows($resultado);

		if( $num_row > 0 ) {
			
			while($linha = mysqli_fetch_array($resultado)){ 
			} 
		}

/* RETIRADO - 12/02/2020
$sql = "UPDATE usuarios SET rota = 0 WHERE user_cli='".$user_cli."' AND user_master = '".$user_master."'";

mysqli_query($con,$sql);
*/


$sql = "SELECT rota FROM usuarios WHERE user_master = '".$user_master."' AND rota > 0 ";
$rota_max=0;   
$resultado = mysqli_query($con,$sql);
$num_row = mysqli_num_rows($resultado);

		if( $num_row > 0 ) {

			$rota_max = $num_row;
		}
		
if ($rota_max > -1 ) 

{
   $rota_min = 1;

   $sql = "UPDATE usuarios SET rota_max=".$rota_max.", rota_min='".$rota_min."' WHERE user_cli='".$user_master."' AND user_master = '".$user_master."'";
   
   mysqli_query($con,$sql);
 
   $sql="SELECT id,user_cli,rota FROM usuarios WHERE user_master = '".$user_master."' AND rota > 0";
  
   $rota =1;
   $resultado = mysqli_query($con,$sql);
   $num_row = mysqli_num_rows($resultado);
   
		if( $num_row > 0 ) {
			
			while($linha = mysqli_fetch_array($resultado)){ 
				$usuario = $linha ['user_cli'];
				$sql = "UPDATE usuarios SET rota=".$rota." WHERE user_master='".$user_master."' AND user_cli='".$usuario."'";
				$rota = $rota+1;
				
			    mysqli_query($con,$sql);
			} 

		}
		
   
}


	$_SESSION = array();
	unset($_SESSION);
	session_destroy(); 


	mysqli_close($con);
	
    header("location:index.php");
	
?>
