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
        <title>Tags</title>    
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

  $name     = $_POST['name'];

  $sql = "INSERT INTO tags (name) VALUES ('$name')"; mysqli_query($con,$sql ) or die(mysqli_error($con));

echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Cadastrado com sucesso!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";

}
?>

<?php
if (isset($_POST['BTExcluir'])) {
   
include ('dbcon.php');
$con = mysqli_connect($server,$nomedeUsuario,$senha,$bancoUsado);

$id       		= $_POST['id'];

mysqli_query($con,"DELETE FROM tags WHERE id='".$id."'");


echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Excluído com sucesso!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";}
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
                                <div class="page-toolbar-title">Tags de atendimento</div>
                                

<button style="top:5px; right:0px; position:absolute; float:right;" type="button" name="answer" onClick="showDiv('welcomeDiv')" class="btn btn-success"><i class="fa fa-plus"></i> Nova Tag</button>

<div id="welcomeDiv" style="display:none;" class="answer_list">
<button style="top:5px; right:0px; position:absolute; float:right;" type="button" name="answer" onClick="showDiv('welcomeDiv')" class="btn btn-warning"><i class="fa fa-minus"></i> Nova Tag</button>
                    <div class="row">
                    
                        <div class="col-md-12">
                            
                            <div class="block">
                                                               
                                <form action="<?php $PHP_SELF; ?>" method="post">
                                <div class="block-content">
                                    <div class="form-group">
                                        <label>Tag:</label>
                                        <div class="input-group file">
                                            <input type="text" name="name" class="form-control" maxlength="30" autocomplete="off" placeholder="Nome da tag" required/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" name="BTSalvar" type="submit">Salvar</button>
                                            </span>
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
                                <div class="block-head">
                                    <h2>Tags</h2>
                                    <ul class="buttons">
                                        <li><a href="usuarios"><span class="fa fa-refresh"></span></a></li>
                                    </ul>  
                                </div>
                                <div class="block-content list nbfc">                                    
                                    
                                    
                                    
<?php

		$sql = "SELECT * FROM tags ORDER BY id ASC";

		$result = mysqli_query($con,$sql) or die(mysqli_error($con)); 
		$num_rows = mysqli_num_rows($result);
								   
if($num_rows > 0 ) {

    while($linha = mysqli_fetch_array($result)) {
		$id 	       		= $linha["id"];
		$name       		= $linha["name"];

?>                                    
                                
								
                                 
                                 
                                    <div class="list-item">
                                        <div class="list-item-content">
                                            
                                            <div class="list-item-container" style="min-width:200px;">
                                                <p class="text-muted" style="font-size:14px; margin-top:10px; margin-left:20px;"><?php echo "$name"; ?></p>
                                            </div>
                                            
                                            <div align="right">
                                            	<div style="height:7px;"></div>
                                                <form action="<?php $PHP_SELF; ?>" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $linha['id']; ?>" />
                                                    <button type="submit" name="BTExcluir" class="btn btn-danger"><i class="fa fa-trash-o"></i> Excluir</button>
                                                </form>
                                                
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