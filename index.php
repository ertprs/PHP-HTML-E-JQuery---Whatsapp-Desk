<?php  

	session_start();
  
    error_reporting(E_ERROR | E_PARSE);
	
    // Se o usuário após o login pressionar o botão de retorno do navegador, a sessão é destruída.
	//if (isset($_SESSION)) {	
	 //  session_destroy();
	//}
    //*******************************************************************************************

$email = $_GET['email'];
$senha = $_GET['senha'];

?>  


<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Login Multi-Atendimento</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/favicon.ico"/>
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"> 
	<link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	
<style>
	p.ex1 {
	  font-family: Poppins-Regular, sans-serif;
	  font-size:20px;
	  font-weight: bold;
      color:white;	  
	  padding: 10px;
	}
</style>

</head>
<body oncontextmenu="return false">

	    <div style="width:100%; height:50px; background:#333333;overflow:hidden;text-align:center">
			<p class="ex1">WhatsCompany</p>
		</div>

	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">   <!-- p-t-55 p-b-20 -->
			
				<form class="login100-form validate-form" id="formLogin" name="formLogin" role="form" method="post" action="">
					<span class="login100-form-title">
						Bem-vindo ao Sistema Multi-Atendimento
					</span>
					<span class="login100-form-avatar">
						<img src="images/avatar-01.jpg" alt="AVATAR">
					</span>

                   
					<div  class="wrap-input100 validate-input">
						<input class="input100" type="username" name="email" id="email" value="<?php echo $email; ?>" placeholder="e-mail">
					</div>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="password" name="senha" id="senha" value="<?php echo $senha; ?>" placeholder="senha">
						<input class="form-control"  name="controle" id="controle" type="hidden" value="345067821133">
					</div>

                    <br>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="button" name="entrar" id="entrar">
							Login
						</button>
					</div>
				</form>
				
			</div>
		</div>
		

			<!-- Modal Alert -->
			<div class="modal fade in" id="myAlert" data-keyboard="false" data-backdrop="static">
			  <div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Atenção</h4>
				  </div>
				  <div class="modal-body">
					<p>Texto</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
				  </div>
				</div>
			  
			  </div>
			</div>
			<!-- Fim Modal Alert -->
	
	</div>


		  

	<script src='js/index.js'></script>
	<!--<script src='js/index-min.js'></script>-->

</body>
</html>