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

$user_cli   	= $_SESSION['user_cli'];
$status_cli  	= $_SESSION['status'];
$status_n    	= $_SESSION['status_n'];
$limite_msg  	= $_SESSION['limite_msg'];
$code_cli    	= $_SESSION['code_cli'];
$user_adicional = $_SESSION['user_adicional'];
$user_master    = $_SESSION['user_master'];

$timeout = 86400; // Tempo da sessao em segundos
// Verifica se existe o parametro timeout
if(isset($_SESSION['timeout'])) {
// Calcula o tempo que ja se pass_admou desde a cricao da sessao
$duracao = time() - (int) $_SESSION['timeout'];
// Verifica se ja expirou o tempo da sessao
if($duracao > $timeout) {
// Destroi a sessao e cria uma nova
session_destroy();
session_start();
}
}
// Atualiza o timeout.
$_SESSION['timeout'] = time();

?>



<!DOCTYPE html>
<html lang="en">
    
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>        
        <title>Usuários</title>    
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="img/favicon.png" type="image/x-icon" />
        
        <link href="css/styles.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 10]><link rel="stylesheet" type="text/css" href="css/ie.css"/><![endif]-->
        
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>        
        
        <script type="text/javascript" src="js/plugins/sparkline/jquery.sparkline.min.js"></script>        
        <script type="text/javascript" src="js/plugins/fancybox/jquery.fancybox.pack.js"></script>                
        
        <script type='text/javascript' src='js/plugins/knob/jquery.knob.js'></script>
        
        <script type="text/javascript" src="js/plugins/daterangepicker/moment.min.js"></script>
        <script type="text/javascript" src="js/plugins/daterangepicker/daterangepicker.js"></script> 
        
        <script type='text/javascript' src='js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'></script>
        <script type='text/javascript' src='js/plugins/jvectormap/jquery-jvectormap-europe-mill-en.js'></script>
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/demo.js"></script>
        <script type="text/javascript" src="js/maps.js"></script>        
        <script type="text/javascript" src="js/charts.js"></script>
        <script type="text/javascript" src="js/actions.js"></script>        



<!-- rotina para bloquear o botão voltar do navegador. -->        
<script>
(function(window) { 
  'use strict'; 
 
var noback = { 
	 
	//globals 
	version: '0.0.1', 
	history_api : typeof history.pushState !== 'undefined', 
	 
	init:function(){ 
		window.location.hash = '#no-back'; 
		noback.configure(); 
	}, 
	 
	hasChanged:function(){ 
		if (window.location.hash == '#no-back' ){ 
			window.location.hash = '#seguro';
			//mostra mensagem que não pode usar o btn volta do browser
			if($( "#msgAviso" ).css('display') =='none'){
				$( "#msgAviso" ).slideToggle("slow");
			}
		} 
	}, 
	 
	checkCompat: function(){ 
		if(window.addEventListener) { 
			window.addEventListener("hashchange", noback.hasChanged, false); 
		}else if (window.attachEvent) { 
			window.attachEvent("onhashchange", noback.hasChanged); 
		}else{ 
			window.onhashchange = noback.hasChanged; 
		} 
	}, 
	 
	configure: function(){ 
		if ( window.location.hash == '#no-back' ) { 
			if ( this.history_api ){ 
				history.pushState(null, '', '#seguro'); 
			}else{  
				window.location.hash = '#seguro';
				//mostra mensagem que não pode usar o btn volta do browser
				if($( "#msgAviso" ).css('display') =='none'){
					$( "#msgAviso" ).slideToggle("slow");
				}
			} 
		} 
		noback.checkCompat(); 
		noback.hasChanged(); 
	} 
	 
	}; 
	 
	// AMD support 
	if (typeof define === 'function' && define.amd) { 
		define( function() { return noback; } ); 
	}  
	// For CommonJS and CommonJS-like 
	else if (typeof module === 'object' && module.exports) { 
		module.exports = noback; 
	}  
	else { 
		window.noback = noback; 
	} 
	noback.init();
}(window)); 
</script>

<style>
.badgebox
{
    opacity: 0;
}

.badgebox + .badge
{
    text-indent: -999999px;
	width: 27px;
}

.badgebox:focus + .badge
{
    box-shadow: inset 0px 0px 5px;
}

.badgebox:checked + .badge
{
	text-indent: 0;
}

</style>
        
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

<script>
function showDiv(Div) {
    var x = document.getElementById(Div);
    if(x.style.display=="none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>

<script>
function showDiv2(Div) {
    var x = document.getElementById(Div);
    if(x.style.display=="none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>


<script>
function showDiv3(Div) {
    var x = document.getElementById(Div);
    if(x.style.display=="none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>

<body oncontextmenu="return false">
 

<?php
if (isset($_POST['BTSalvar'])) {
   
include ('dbcon.php');

$con = mysqli_connect($server,$nomedeUsuario,$senha,$bancoUsado);

  $nome     = $_POST['nome'];
  $email    = $_POST['email']; 
  $senha    = $_POST['senha'];
  $user_master  	= $user_master;
  $user_adicional = "1";
  $status = "0";
  $code_cli = date("Ymdhis");
  $user_cli = date("Ymdhis");


	// Verificação do nome do link.
	$sql = "SELECT * FROM usuarios WHERE email_cli='".$email."'";
	$result = mysqli_query($con,$sql) or die(mysqli_error($con)); 
		$num_rows = mysqli_num_rows($result);
								   
	if($num_rows > 0 ) {
	
		while($linha = mysqli_fetch_array($result)) {
			$email_cli 		= $linha["email_cli"];
			

	} } // Fim da verificação do nome do link
	
	if ($email == $email_cli) {
		
		
//echo "<div style='width:100%; height:50px; background-color:#F00;'><div align='center' style='padding-top:15px; font-family:Verdana, Geneva, sans-serif; font-size:17px;'><font color='#FFFFFF'>Login já cadastrado. Tente novamente!</font></div></div>";

echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Login já cadastrado. Tente novamente!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";


	} else {
	
  $sql = "INSERT INTO usuarios (nome_cli, email_cli, pass, user_master, user_adicional, code_cli, status, user_cli) VALUES ('$nome', '$email', '$senha', '$user_master', '$user_adicional', '$code_cli', '$status', '$user_cli')"; mysqli_query($con,$sql ) or die(mysqli_error($con));

//echo "<div style='width:100%; height:50px; background-color:#096;'><div align='center' style='padding-top:15px; font-family:Verdana, Geneva, sans-serif; font-size:17px;'><font color='#FFFFFF'>Cadastrado com sucesso!</font></div></div>";

echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Cadastrado com sucesso!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";

	}
  

}
?>
 


<?
if (isset($_POST['desativar'])) {
   
include ('dbcon.php');
$con = mysqli_connect($server,$nomedeUsuario,$senha,$bancoUsado);
	


// CLIENTE DESEJADO
$user_master = $_POST['user_master_ativa'];
// *****************

// USUÁRIO COMUM DESEJADO
 $user_cli = $_POST['user_cli_ativa'];                         


		// VERIFICAÇÃO DA QUANTIDADE DE USUÁRIOS ATIVOS
		$sql = "SELECT * FROM usuarios WHERE user_cli='".$user_master."'";

		$result = mysqli_query($con,$sql) or die(mysqli_error($con)); 
		$num_rows = mysqli_num_rows($result);
								   
if($num_rows > 0 ) {

    while($linha = mysqli_fetch_array($result)) {
		$id 				= $linha["id"];
		$rota_max       	= $linha["rota_max"];
		
		
		if ($rota_max == "1") {


//echo "<div style='width:100%; height:50px; background-color:#F00;'><div align='center' style='padding-top:15px; font-family:Verdana, Geneva, sans-serif; font-size:17px;'><font color='#FFFFFF'>Ação negada, você precisa ter um usuário ativo!</font></div></div>";

echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Ação negada, você precisa ter um usuário ativo!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";

		} else {


$sql = "select id,user_cli,rota_max,rota,user_master from usuarios where user_master='".$user_master."'";

$resultado = mysqli_query($con,$sql);
$num_row = mysqli_num_rows($resultado);

		if( $num_row > 0 ) {
		//	echo 'Área de teste';
		//	echo '<br>'.'<br>';
			
			while($linha = mysqli_fetch_array($resultado)){ 
			//	echo $linha ['user_cli'].'    rota_max='.$linha ['rota_max'].'    rota='.$linha ['rota'].'<br>';
			} 
		//	echo '<br>';
		//	echo 'Fim da teste';
		//	echo '<br>';
		}
// Fim da verificação no teste

// Início da rotina para informar ZERO no campo rota do cliente que se deseja cancelar 
// ************************************************************************************


// 1- ZERANDO O CAMPO ROTA DO USUÁRIO DESEJADO

$sql = "UPDATE usuarios SET rota = 0 WHERE user_cli='".$user_cli."' AND user_master = '".$user_master."'";
// echo $sql;
// echo '<br>';
// echo '<br>';

mysqli_query($con,$sql);
// ************************************************************************************
// FIM DA ROTINA DE ZERAR CAMPO ROTA DO USUÁRIO DESEJADO


// 2 - ROTINA PARA VERIFICAR QUANTOS REGISTROS POSSUEM ROTA > ZERO

$sql = "SELECT rota FROM usuarios WHERE user_master = '".$user_master."' AND rota > 0 ";
// echo $sql;
// echo '<br>';
// echo '<br>';

$rota_max=0;        // Inicializa a variavel 

$resultado = mysqli_query($con,$sql);
$num_row = mysqli_num_rows($resultado);


		if( $num_row > 0 ) {
            // Guarda a variável para ser utilizada à frente
			$rota_max = $num_row;
			// *********************************************
			// echo "Qtd. rotas > ZERO : ".$rota_max ;
			// echo '<br>';
			// echo '<br>';
		}
		
if ($rota_max > 0 ) 

{
  //  echo "Rotina abaixo ira informar a ROTA_MAX";
  // echo '<br>';
  // echo '<br>';   
   
   // Indica a rota máxima
   // Nessa indicação user_cli TEM QUE SER IGUAL à user_master
   $rota_min = 1;
   $sql = "UPDATE usuarios SET rota_max=".$rota_max.", rota_min='".$rota_min."' WHERE user_cli='".$user_master."' AND user_master = '".$user_master."'";
   // echo $sql;
   
   mysqli_query($con,$sql);
 
   // echo '<br>';
   // echo '<br>';  
   // FIM da rotina que ATUALIZA A rota máxima

   //Início da rotina que atualiza as rotas
   
   //$sql="SELECT id,user_cli,rota FROM pagina_cli WHERE user_master = '".$user_master."' AND rota > 0 ORDER BY id";
   //Parece que se não informar o ID a query retorna na ordem de gravação
   $sql="SELECT id,user_cli,rota FROM usuarios WHERE user_master = '".$user_master."' AND rota > 0";
   // ***************************************************************************************************************
   
   $rota =1;
   $resultado = mysqli_query($con,$sql);
   $num_row = mysqli_num_rows($resultado);
   
		if( $num_row > 0 ) {
			
			while($linha = mysqli_fetch_array($resultado)){ 
				$usuario = $linha ['user_cli'];
				$sql = "UPDATE usuarios SET rota=".$rota." WHERE user_master='".$user_master."' AND user_cli='".$usuario."'";
				$rota = $rota+1;
				// echo $sql."<br>";
			    mysqli_query($con,$sql);
			} 

		}
		
   // ******************************************************* 
  
   
}


//echo "<div style='width:100%; height:50px; background-color:#096;'><div align='center' style='padding-top:15px; font-family:Verdana, Geneva, sans-serif; font-size:17px;'><font color='#FFFFFF'>Usuário desativado!</font></div></div>";	

echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Usuário desativado!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";			
		}
		

	
	} } // *******************************************
 

}
?> 


<?
if (isset($_POST['ativar'])) {
   
include ('dbcon.php');
$con = mysqli_connect($server,$nomedeUsuario,$senha,$bancoUsado);
	


// CLIENTE DESEJADO
$user_master = $_POST['user_master_ativa'];
// *****************

// USUÁRIO COMUM DESEJADO
 $user_cli = $_POST['user_cli_ativa'];                         

// *******************************************

if ($user_cli <> '' )

{
	

	$rota_max = 0;

	$sql = "SELECT MAX(rota_max)+1 AS rota_max FROM usuarios WHERE user_cli='".$user_master."' AND user_master = '".$user_master."'";
	$resultado = mysqli_query($con,$sql);
	$num_row = mysqli_num_rows($resultado);

			if( $num_row > 0 ) {
				$linha = mysqli_fetch_array($resultado);
				$rota_max = $linha ['rota_max'];
				// echo $rota_max;
				// echo "<br>";
			}
			
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
			 if ($rows > 0 )
			 {
				// echo "<br>";
				// echo "Registros alterados com sucesso ...";
			 }			 
		
			}

		
	}

}

//echo "<div style='width:100%; height:50px; background-color:#096;'><div align='center' style='padding-top:15px; font-family:Verdana, Geneva, sans-serif; font-size:17px;'><font color='#FFFFFF'>Usuário ativado!</font></div></div>";

echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Usuário ativado!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";
}
?>



<?php
if (isset($_POST['BTNotifica'])) {
   
include ('dbcon.php');

$con = mysqli_connect($server,$nomedeUsuario,$senha,$bancoUsado);

$id          	= $_POST['id'];

if(isset($_POST['info_atendente']))
{ $info_atendente=1; }
else
{ $info_atendente=0; }

if(isset($_POST['info_transferencia']))
{ $info_transferencia=1; }
else
{ $info_transferencia=0; }
	
mysqli_query($con,"UPDATE api SET info_atendente='".$info_atendente."', info_transferencia='".$info_transferencia."' WHERE id='".$id."'");

//echo "<div style='width:100%; height:50px; background-color:#096;'><div align='center' style='padding-top:15px; font-family:Verdana, Geneva, sans-serif; font-size:17px;'><font color='#FFFFFF'>Dados alterados com sucesso!</font></div></div>";

echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Dados alterados com sucesso!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";

}
?>
 

<?php
if (isset($_POST['BTDesativa'])) {
   
include ('dbcon.php');

$con = mysqli_connect($server,$nomedeUsuario,$senha,$bancoUsado);

$id            		= $_POST['id'];
$logado     		= "0";
$status     		= "0";

mysqli_query($con,"UPDATE usuarios SET logado='".$logado."', status='".$status."' WHERE id='".$id."' ");

echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Usuário desativado!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";

}
?>
 

        
        <div class="page-container">
            
			<?php include "topo.php"; ?>
            
            <div class="page-navigation">
                
                <div class="page-navigation-info" align="center">
                    <img style="margin-top:-5px;" src="img/logo.png" width="220" height="40">
                </div>
                       
                <div class="profile">                    
                    <img src="img/online.png"/>
                    <div class="profile-info">
                        <a href="#" class="profile-title"><?php echo "$user_cli"; ?></a>
                           <?php $ip = $_SERVER['REMOTE_ADDR']; ?>
                            <span class="profile-subtitle">Acessando do IP: <?php echo "$ip"; ?> </span>
                                          
                    </div>
                </div>
				
				<?php include "menu.php"; ?>
                
            </div>
            
            <div class="page-content">

                <div class="container">

					<!-- Complemento do bloqueio do botão voltar do navegador -->
                    <div id="msgAviso" style="display:none;">
                        <div class="alert alert-warning">
                            <font size="3" color="#000000"><strong>Ops...</strong> Essa opção foi desativada. Clique no <strong>MENU</strong> lateral para continuar navegando no painel.</font>
                        </div>
                    </div> 
                        
                        <div class="page-toolbar col-md-12">
                        
                            <div class="page-toolbar-block col-md-11">
                                <div class="page-toolbar-title">Atendentes</div>
                                

<button style="top:5px; right:0px; position:absolute; float:right;" type="button" name="answer" onClick="showDiv('welcomeDiv3')" class="btn btn-success"><i class="fa fa-plus"></i> Config Notificações</button>

<?php

    $sql = "SELECT * FROM api";
	$result = mysqli_query($con,$sql) or die(mysqli_error($con)); 
		$num_rows = mysqli_num_rows($result);
								   
	if($num_rows > 0 ) {
	
		while($linha = mysqli_fetch_array($result)) {
			$limite_at 		= $linha["limite_at"];
			
	} }

	$sql2 = "SELECT id FROM usuarios ";
	$result2 = mysqli_query($con,$sql2);
	$num_rows = mysqli_num_rows($result2);
	
	if ($limite_at == $num_rows) { } else {
?>	
<button style="top:5px; right:150px; position:absolute; float:right;" type="button" name="answer" onClick="showDiv('welcomeDiv')" class="btn btn-success"><i class="fa fa-plus"></i> Novo Atendente</button>
<?php } ?>

<div id="welcomeDiv" style="display:none;" class="answer_list">
<button style="top:5px; right:150px; position:absolute; float:right;" type="button" name="answer" onClick="showDiv('welcomeDiv')" class="btn btn-warning"><i class="fa fa-minus"></i> Novo Atendente</button>
                    <div class="row">
                    
                        <div class="col-md-12">
                            
                            <div class="block">
                                                               
                                <form action="<?php $PHP_SELF; ?>" method="post">
                                <div class="block-content">
                                    <div class="form-group">
                                        <label>Nome:</label>
                                        <div class="input-group file">
                                            <input type="text" name="nome" class="form-control" maxlength="30" autocomplete="off" placeholder="Nome" required/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" name="BTSalvar" type="submit">Salvar</button>
                                            </span>
                                        </div>                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <div class="input-group file col-md-12">
                                            <input type="email" name="email" class="form-control" value="<?php echo $linha['titulo']; ?>" maxlength="70" placeholder="Email" autocomplete="off" required/>
                                        </div>                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Senha:</label>
                                        <div class="input-group file col-md-12">
                                            <input type="text" name="senha" class="form-control" value="" maxlength="25" autocomplete="off" placeholder="Senha" required/>
                                        </div>                                        
                                    </div>
                                    
                                </div>
                                
                                </form> 
                                
                            </div>
                            
                        </div>
                    </div>
</div>




<div id="welcomeDiv3" style="display:none;" class="answer_list">
<button style="top:5px; right:0px; position:absolute; float:right;" type="button" name="answer" onClick="showDiv('welcomeDiv3')" class="btn btn-warning"><i class="fa fa-minus"></i> Config Notificações</button>
                    <div class="row">
                    
                        <div class="col-md-12">
                            
                            <div class="block">
                                                               
                                <form action="<?php $PHP_SELF; ?>" method="post">
                                <div class="block-content">
                                    <div class="form-group">
                                        <label>Alertas:</label>
                                        <div class="input-group file">
<?php
$resultado = mysqli_query($con,"SELECT id, info_atendente, info_transferencia FROM api ");
while($linha = mysqli_fetch_array($resultado))
{ 
?>                                             

 									<input type="hidden" name="id" value="<?php echo $linha['id']; ?>" />
                                    
                                   
                                    <div class="checkbox" style="margin-top:25px; height:30px;">
										<?php if ( $linha['info_atendente'] == 1) {    ?> 
                                            <label for="warning" class="btn btn-warning">Informar nome do atendente ao enviar mensagem:  
                                            	<input type="checkbox" id="warning" name="info_atendente" class="badgebox" checked><span class="badge">&check;</span>
                                            </label>      
                                        <?php } else {?>	
                                            <label for="warning" class="btn btn-warning">Informar nome do atendente ao enviar mensagem:  
                                            	<input type="checkbox" id="warning" name="info_atendente" class="badgebox"><span class="badge">&check;</span>
                                            </label>
                                        <?php } ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
										<?php if ( $linha['info_transferencia'] == 1) {    ?> 
                                            <label for="info" class="btn btn-info">Informar ao cliente que ele está sendo transferido:
                                            	<input type="checkbox" id="info" name="info_transferencia" class="badgebox" checked><span class="badge">&check;</span>
                                            </label>    
                                        <?php } else {?>	
                                            <label for="info" class="btn btn-info">Informar ao cliente que ele está sendo transferido:
                                            	<input type="checkbox" id="info" name="info_transferencia" class="badgebox"><span class="badge">&check;</span>
                                            </label>
                                        <?php } ?>
                                    </div>
                                  
<?php } ?>
                                    <div class="list-item-container" style="min-width:200px; top:50px; padding-top:20px;">
                                        <div align="right">                
                                            <button type="submit" name="BTNotifica" class="btn btn-success"><i class="fa fa-floppy-o"></i> Salvar</button>
                                        </div>
                                    </div>
                                    
                                        </div>                                        
                                    </div>
                                    
                                    
                                </div>
                                
                                </form> 
                                
                            </div>
                            
                        </div>
                    </div>
</div>

                                
                            </div>
                              
                        </div>
                        

                       <div class="col-md-12">
                            
                            <div class="block">
                                <div class="block-content list nbfc">                                    
                                   
                                    <div class="list-item">
                                        <div class="list-item-content">
                                            
<form action="<? $PHP_SELF; ?>" method="post"> 
                                           <div class="list-item-container">
                                                <h4>Desativar roleta:</h4>


                     
                    <input name="user_master_ativa" type="hidden" value="<? echo $user_master; ?>">
                    
                    <select name="user_cli_ativa" class="form-control">
						<?
                            $sql2 = "SELECT id, user_cli, nome_cli FROM usuarios WHERE user_master='".$user_master."' and rota!=0 order by user_cli ASC ";
                            
                            $limite = mysqli_query($con,$sql2); 
                            while ($sql2=mysqli_fetch_array($limite)) { 
                            $id 			= $sql2['id']; 
                            $user_cli2    	= $sql2['user_cli'];
							$nome_cli    	= $sql2['nome_cli'];
                        ?> 
                        <option value="<? echo "$user_cli2"; ?>"><? echo "$nome_cli"; ?></option> 
                        <? } ?>  
                    </select>
                                                               
                      


                                            </div>
                                            
                                            <div class="list-item-container" style="min-width:200px;">
                                                <div align="left" style="margin-top:20px;">                
                									<button type="submit" class="btn btn-danger btn-clean" name="desativar" onClick="return confirm('Desativar este usuário?')">Desativar</button>
            									</div>
                                            </div>
                                            
</form>                                            
                                            
                                            
<form action="<? $PHP_SELF; ?>" method="post"> 
                                           <div class="list-item-container">
                                                <h4>Ativar roleta:</h4>


                     
                    <input name="user_master_ativa" type="hidden" value="<? echo $user_master; ?>">
                    
                    <select name="user_cli_ativa" class="form-control">
						<?
                            $sql2 = "SELECT id, user_cli, nome_cli FROM usuarios WHERE user_master='".$user_master."' and rota=0 order by user_cli ASC ";
                            
                            $limite = mysqli_query($con,$sql2); 
                            while ($sql2=mysqli_fetch_array($limite)) { 
                            $id 			= $sql2['id']; 
                            $user_cli2    	= $sql2['user_cli'];
							$nome_cli    	= $sql2['nome_cli'];
                        ?> 
                        <option value="<? echo "$user_cli2"; ?>"><? echo "$nome_cli"; ?></option> 
                        <? } ?>  
                    </select>
                                                               
                      


                                            </div>
                                            
                                            <div class="list-item-container" style="min-width:200px;">
                                                <div align="left" style="margin-top:20px;">                
                <button type="submit" class="btn btn-success btn-clean" name="ativar" onClick="return confirm('Ativar este usuário?')">Ativar</button>
            									</div>
                                            </div>
                                            
</form>  
                          
                                        </div>

                                    </div>
                                    

                                </div>
                            </div>
                            
                        </div>                          
                        
                        
                        <div class="col-md-12">
                            
                            <div class="block">
                                <div class="block-head">
                                    <h2>Atendentes</h2>
                                    <ul class="buttons">
                                        <li><a href="usuarios"><span class="fa fa-refresh"></span></a></li>
                                    </ul>  
                                </div>
                                <div class="block-content list nbfc">                                    
                                    
                                    
                                    
<?php

		$sql = "SELECT * FROM usuarios ORDER BY id ASC";

		$result = mysqli_query($con,$sql) or die(mysqli_error($con)); 
		$num_rows = mysqli_num_rows($result);
								   
if($num_rows > 0 ) {

    while($linha = mysqli_fetch_array($result)) {
		$id 	       		= $linha["id"];
		$nome       		= $linha["nome_cli"];
		$usuario       		= $linha["usuario"];
		$logado       	    = $linha["logado"];
		$email_cli          = $linha["email_cli"];
		$pass               = $linha["pass"];
		$rota               = $linha["rota"];
		$user_cli           = $linha["user_cli"];
		$logado             = $linha["logado"];
		
	
	$sql2 = "SELECT id FROM contatos WHERE user_cli = '".$user_cli."' ";
	$result2 = mysqli_query($con,$sql2);
	$num_rows_2 = mysqli_num_rows($result2);		

?>                                    
                                
								
                                 
                                 
                                    <div class="list-item">
                                        <div class="list-item-content">
                                            
                                            <div  class="list-item-container">
                                                <h4>Status:</h4>
                                                <?php if ($logado == "0") { ?>
                                                    <button type="button" class="btn btn-danger" style="background:#FFF;" disabled><img src="img/user_off.png" width="20" height="20"></button>
                                                <?php } else { ?>
                                                
                                                <form action="<?php $PHP_SELF; ?>" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $linha['id']; ?>" />
                                                    <button type="submit" name="BTDesativa" class="btn btn-success" style="background:#FFF; "><img src="img/user_on.png" width="20" height="20"></button>
                                                </form>
                                                
                                                <?php } ?>
                                            </div>
                                            
                                            <div class="list-item-container" style="min-width:200px;">
                                                <h4>Atendente:</h4>
                                                <p class="text-muted"><?php echo "$nome"; ?></p>
                                            </div>
                                            
                                            <div class="list-item-container" style="min-width:200px;">
                                                <h4>Login:</h4>
                                                <p class="text-muted"><?php echo "$email_cli"; ?></p>
                                            </div>
                                            
                                            
                                            <div class="list-item-container">
                                                <h4>Roleta:</h4>
                                                <p class="text-muted"><?php echo "$rota"; ?></p>
                                            </div>
                                            
                                            <div class="list-item-container">
                                                <h4>Clientes:</h4>
                                                <p class="text-muted"><? echo $num_rows_2; ?></p>
                                            </div>
                                            
                                            
                                            <div align="right">
                                            	<div style="height:10px;"></div>
                                                <a href="usuario-editar?usuario=<?php echo "$user_cli"; ?>" class="btn btn-warning"><i class="fa fa-pencil-square-o"></i> Dados</a>
                                            &nbsp;
                                            
                                             <a href="../index?email=<?php echo "$email_cli"; ?>&senha=<?php echo "$pass"; ?>" target="_blank" class="btn btn-info"><i class="fa fa-pencil-square-o"></i> Hist. MSG</a>
                                            </div>
                                            
                                        </div>

                                    </div>


<?php   
  }
   
} else { }
?>  
                                   
                                   
                                </div>
                            </div>
                            
                        </div>
                        
                        
                        
                         
                        
                        
                    </div>
                    
                    
                    
                </div>
                
            </div>
            <div class="page-sidebar"></div>
        </div>


    </body>

</html>
<?php mysqli_close($con); ?>