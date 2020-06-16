<?php

include ('dbcon.php');

?>



<!DOCTYPE html>
<html lang="pt-br">
    
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>        
        <title>Painel De Controle</title>    

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="img/favicon.png" type="image/x-icon" />

        <link href="css/styles.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 10]><link rel="stylesheet" type="text/css" href="css/ie.css"/><![endif]-->

<style>
body {
  font-size: 12px;
  padding: 0px;
  margin: 0px;
  height: 100%;
  min-height: 100%;
  /*background: #000000;*/
  background-repeat: no-repeat;
  background-size: 100% 100%;
  background-image:url(img/login.jpg);
  font-family: 'Open Sans', sans-serif;
}
</style>
        
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
                
        <script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>

        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/demo.js"></script>
        <script type="text/javascript" src="js/actions.js"></script>        

    </head>
<script>
      document.onkeypress = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
          return false;
        }
      }
      document.onmousedown = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
          return false;
        }
      }
      document.onkeydown = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
          return false;
        }
      }
	  
 $(window).load(function(){        
   $('#myModal').modal('show');
    }); 
 
 </script>

<body oncontextmenu="return false">
 

<?php
if (isset($_POST['BTEmail'])) {
   
//include ('dbcon/dbcon.php');

$con = mysqli_connect($server,$nomedeUsuario,$senha,$bancoUsado);

$email_info = mysqli_real_escape_string($con,$_POST['email']);


	$sql = "SELECT email_adm, whatsapp, pass_adm FROM adm WHERE email_adm='".$email_info."'";
	$result = mysqli_query($con,$sql) or die(mysqli_error($con)); 
		$num_rows = mysqli_num_rows($result);
								   
	if($num_rows > 0 ) {
	
		while($linha = mysqli_fetch_array($result)) {
			$email_adm_atual = $linha["email_adm"];
			$whatsapp	     = $linha["whatsapp"];
			$senha  	     = $linha["pass_adm"];

	} }
	
			if ($email_info == $email_adm_atual) {

		
		$mensagem 		= "Dados de acesso:" . "\n" . "Email: ".$email_adm_atual."" . "\n" . "Senha: ".$senha . "\n\n" . "_Mensagem automática, favor não responder!_";
				
$idmsg=  date("YmdHis");
$emoji= "nao"; //"sim" ou "nao"


$dados['email']= "api2@grupoconnectti.com.br";
//$dados['email']= "matthewangels@icloud.com";
$dados['token']= "14a30fccaf04ebb07ca13ec012b8221b714995";
$dados['idapp']= "4457";
$dados['idmsg']= $idmsg;

if ($agencia == "WhatsCompany") {

$dados['midia']= "imagem"; //"texto" , "imagem" ou "arquivo"
$dados['url_anexo']= "https://www.whatscompany.com.br/imgstatus/dadosdeacesso.jpg"; //opcional. necessÃ¡rio se midia="imagem" ou midia="arquivo";

} else {
	$dados['midia']= "texto"; //"texto" , "imagem" ou "arquivo"
	$dados['url_anexo']= ""; //opcional. necessÃ¡rio se midia="imagem" ou midia="arquivo";
}
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
$retorno= json_decode($executa_api);
//Retorno da API
$erro= $retorno->erro;
$sobre_o_erro= $retorno->sobre_o_erro;
$whatsapp_retorno= $retorno->whatsapp;
$mensagem_retorno= $retorno->mensagem;
$status= $retorno->status;
$idlog= $retorno->idlog;

				
				echo "<META HTTP-EQUIV='REFRESH' CONTENT='4; URL=index'>";
				echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Dados enviados via WhatsApp cadastrado.<br> Registramos seu IP: '". $ip = $_SERVER['REMOTE_ADDR']."'</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";
				
			} else {
				
				echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Email não encontrado. Tente novamente!<br> Registramos seu IP: '". $ip = $_SERVER['REMOTE_ADDR']."'</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";
			
			}

		

}
?>

 
      
        <div class="page-container">
            
            <div style="margin-top:15%;">

                <div class="block-login">
                    <div class="block-login-content">
                        <h1>Esqueceu sua senha?</h1>
                        
                        <form method="post" action="<?php $PHP_SELF; ?>">
                            
                        <div class="form-group">                        
                            <input type="email" name="email" autocomplete="off" autofocus class="form-control" placeholder="Digite seu email" value="" required/>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit" name="BTEmail">Receber senha</button>                                        
                        
                        </form>
                        <div class="sp"></div>


                        <div class="sp"></div>
                        
                        <div class="pull-left">
                            <a href="index">Voltar</a>
                        </div>
                    </div>

                </div>
                
            </div>
        </div>
        
        <script type="text/javascript">
        $("#signinForm").validate({
		rules: {
			login: "required",
			pass_admword: "required"
		},
		messages: {
			firstname: "Informe seu usuário",
			lastname: "Informe sua senha"			
		}
	});            
        </script>
        
    </body>

</html>