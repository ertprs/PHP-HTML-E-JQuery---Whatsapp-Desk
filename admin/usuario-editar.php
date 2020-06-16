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

$user_cli    			= $_SESSION['user_cli'];
$user_cli_comparacao    = $_SESSION['user_cli'];
$status      			= $_SESSION['status'];
$status_n    			= $_SESSION['status_n'];
$limite_msg  			= $_SESSION['limite_msg'];
$identificar_url  		= $_SESSION['identificar_url'];
$code_cli  				= $_SESSION['code_cli'];
$user_master    		= $_SESSION['user_master'];


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
        <title>Editar Usuário</title>    

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
        
        <script type="text/javascript" src="js/plugins/validation/languages/jquery.validationEngine-en.js"></script>
        <script type="text/javascript" src="js/plugins/validation/jquery.validationEngine.js"></script>        
        
        <script type='text/javascript' src='js/plugins/maskedinput/jquery.maskedinput.min.js'></script>
        
        <script type="text/javascript" src="js/plugins/select2/select2.min.js"></script>        
        <script type="text/javascript" src="js/plugins/icheck/jquery.icheck.min.js"></script>
                
        <script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery-validation/additional-methods.min.js"></script>
        
        <script type="text/javascript" src="js/plugins.js"></script>
        <script type="text/javascript" src="js/demo.js"></script>
        <script type="text/javascript" src="js/actions.js"></script>
        
        <script type="text/javascript" src="js/plugins/bootstrap/jscolor.js"></script>  
        
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui-timepicker-addon.js"></script>  
        
        <script type="text/javascript" src="js/jquery.maskedinput-1.1.4.pack.js"/></script>
		


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

 $(window).load(function(){        
   $('#myModal').modal('show');
    }); 
 
</script>


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
 </script>

		<script type="text/javascript">
        function mascara(o,f){
        v_obj=o
        v_fun=f
        setTimeout("execmascara()",1)
        }
        function execmascara(){
        v_obj.value=v_fun(v_obj.value)
        }
        function mtel(v){
        v=v.replace(/\D/g,"");
        v=v.replace(/^(\d{2})(\d)/g,"($1) $2");
        v=v.replace(/(\d)(\d{4})$/,"$1-$2");
        return v;
        }
        function id( el ){
        return document.getElementById( el );
        }
        window.onload = function(){
        id('telefone_info').onkeyup = function(){
            mascara( this, mtel );
        }
        id('tel_fixo').onkeyup = function(){
            mascara( this, mtel );
        }	
        }
        </script>
        
<body oncontextmenu="return false">

<?php
if (isset($_POST['BTAtualizar'])) {
   
include ('dbcon.php');

$con = mysqli_connect($server,$nomedeUsuario,$senha,$bancoUsado);

$id          	= $_POST['id'];
$usuario      	= $_POST['usuario'];
$nome          	= $_POST['nome'];
$senha      	= $_POST['senha'];

	
mysqli_query($con,"UPDATE usuarios SET nome_cli='".$nome."', pass='".$senha."' WHERE id='".$id."'");

echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Dados alterados com sucesso!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";


}
?>

<?php
if (isset($_POST['BTEmail'])) {
   
include ('dbcon.php');

$con = mysqli_connect($server,$nomedeUsuario,$senha,$bancoUsado);

$id          	= $_POST['id'];
$atual      	= $_POST['email_atual'];
$email_novo     = $_POST['email_novo'];



	// Verificação do nome do link.
	$sql = "SELECT * FROM usuarios WHERE email_cli='".$email_novo."'";
	$result = mysqli_query($con,$sql) or die(mysqli_error($con)); 
		$num_rows = mysqli_num_rows($result);
								   
	if($num_rows > 0 ) {
	
		while($linha = mysqli_fetch_array($result)) {
			$email_cli 		= $linha["email_cli"];
			

	} } // Fim da verificação do nome do link
	
	if ($email_novo == $email_cli) {
		
		
echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Login já cadastrado. Tente novamente!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";

	} else {
	
mysqli_query($con,"UPDATE usuarios SET email_cli='".$email_novo."' WHERE id='".$id."'");

echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Login alterados com sucesso!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";

	}

}
?>


<?
if (isset($_POST['BTDeletar'])) {
   
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

mysqli_query($con,"DELETE FROM usuarios WHERE user_cli='".$user_cli."' ");	

echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Usuário desativado!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";
			
		}
		

	
	} } // *******************************************
 

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
  
                    <div class="page-toolbar">
                        
                        <div class="page-toolbar-block">
                            <div class="page-toolbar-title">Editar Atendente</div>
                            <div class="page-toolbar-subtitle">Tela de Atualização</div>
                        </div>                
                        
                    </div>                    
                                       
                    
<?php
$usuario = $_GET['usuario'];

$resultado = mysqli_query($con,"SELECT * FROM usuarios WHERE user_cli = '".$usuario."'");
while($linha = mysqli_fetch_array($resultado))
{ 
?>                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block">               
                                
                                <form  action="<?php $PHP_SELF; ?>" method="post">
                                <div class="block-content">
                                   
                                    <input type="hidden" name="id" value="<?php echo $linha['id']; ?>" />
                                   
                                    <input type="hidden" name="usuario" value="<?php echo $linha['user_cli']; ?>"/>
                                    
                                    <div class="col-md-6">                                    
                                        <div class="form-group">
                                            <label>Nome de Usuário:</label>
                                            <input type="text" name="nome" value="<?php echo $linha['nome_cli']; ?>" class="form-control" />
                                        </div>
                                        
                                    
                                        <div class="form-group">
                                            <label>Senha:</label>
                                            <input name="senha" type="text" value="<?php echo $linha['pass']; ?>" required autocomplete="off" class="form-control">
                                        </div>
                                      
                                                                                
                                    </div>
                                    <div class="col-md-6">                                        
                                        
                                       
                                        <div class="page-toolbar-block pull-right">
                                            <div class="widget-info widget-from">
                                                <button type="submit" name="BTAtualizar" class="btn btn-success" onClick="return confirm('Concluir edição?')"><i class="fa fa-floppy-o"></i> Salvar</button>
                                            </div>
                                        </div>                                                                                                            
                                    </div>
                                    
                                </div>
                                </form>
                                
                            </div>                            
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block">
                    			<form  action="<?php $PHP_SELF; ?>" method="post">
                                <div class="block-content">
                                   
                                    <input type="hidden" name="id" value="<?php echo $linha['id']; ?>" />
                                   
                                    <input type="hidden" name="usuario" value="<?php echo $linha['user_cli']; ?>"/>
                                    
                                    <div class="col-md-6">                      
                                        <div class="form-group">
                                            <label>Atual Login:</label>
                                            <input type="text" value="<?php echo $linha['email_cli']; ?>" style="color:#000;" disabled class="form-control">
                                            <input type="hidden" name="email_atual" value="<?php echo $linha['email_cli']; ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label>Novo Login:</label>
                                            <input type="email" class="form-control" name="email_novo" autocomplete="off" />
                                        </div>
                                                                           
                                    </div>
                                    <div class="col-md-6">  
                                        <div class="page-toolbar-block pull-right">
                                            <div class="widget-info widget-from">
                                                <button type="submit" name="BTEmail" class="btn btn-success" onClick="return confirm('Concluir edição?')"><i class="fa fa-floppy-o"></i> Trocar Email</button>
                                                <a href="usuarios" class="btn btn-warning"> <i class="fa fa-reply"></i> Voltar</a>
                                            </div>
                                        </div>                                                                                                            
                                    </div>
                                    
                                </div>
                                </form>
                            </div>                            
                        </div>
                    </div>
                    
                    <?php if ($linha['user_adicional'] == "0") { } else { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block">
                    			<form  action="<?php $PHP_SELF; ?>" method="post">
                                <div class="block-content">
                                   
                                    <input type="hidden" name="id" value="<?php echo $linha['id']; ?>" />
                                    <input type="hidden" name="user_cli_ativa" value="<?php echo $linha['user_cli']; ?>"/>
                                    <input type="hidden" name="user_master_ativa" value="<?php echo $linha['user_master']; ?>"/>
                                    
                                    <div class="col-md-12">  
                                        <div class="page-toolbar-block pull-right">
                                            <div class="widget-info widget-from">
                                                <button type="submit" name="BTDeletar" class="btn btn-danger" onClick="return confirm('Excluir atendente?')"><i class="fa fa-trash-o"></i> Excluir Atendente</button>
                                            </div>
                                        </div>                                                                                                            
                                    </div>
                                    
                                    
                                </div>
                                </form>
                            </div>                            
                        </div>
                    </div>
                    <?php } ?>
                    
<?php } ?>     
                   
                </div>
            </div>
            <div class="page-sidebar">
                                
            </div>
            
        </div>         
    </body>

</html>
<?php mysqli_close($con); ?>