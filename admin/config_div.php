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
?>
<!DOCTYPE html>
<html lang="en">
    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style><head>        
        <title>Configurações</title>    

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
id('telefone').onkeyup = function(){
	mascara( this, mtel );
}
id('tel_fixo').onkeyup = function(){
	mascara( this, mtel );
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

<body oncontextmenu="return false">

<?php
if (isset($_POST['BTAtualiza'])) {
   
include ('dbcon.php');

$con = mysqli_connect($server,$nomedeUsuario,$senha,$bancoUsado);

$id      	 	= $_POST['id'];
$pass_adm      	 	= $_POST['pass_adm'];
$email_adm 	 	= $_POST['email_adm'];
$whatsapp       = $_POST['whatsapp'];


mysqli_query($con,"UPDATE adm SET pass_adm='".$pass_adm."', email_adm='".$email_adm."', whatsapp='".$whatsapp."' WHERE id='".$id."'");

echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Dados Editados Com Sucesso!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";

}
?>


<?php
if (isset($_POST['BTAtualizar'])) {
   
include ('dbcon.php');

$con = mysqli_connect($server,$nomedeUsuario,$senha,$bancoUsado);

$id          	= $_POST['id'];
$msg_off      	= $_POST['msg_off'];

	
mysqli_query($con,"UPDATE api SET msg_off='".$msg_off."' WHERE id='".$id."'");

//echo "<div style='width:100%; height:50px; background-color:#096;'><div align='center' style='padding-top:15px; font-family:Verdana, Geneva, sans-serif; font-size:17px;'><font color='#FFFFFF'>Dados alterados com sucesso!</font></div></div>";

echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Dados alterados com sucesso!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";

}
?>


<?php
if (isset($_POST['BTNotifica'])) {
   
include ('dbcon.php');

$con = mysqli_connect($server,$nomedeUsuario,$senha,$bancoUsado);

$id          	= $_POST['id'];

if(isset($_POST['alerta']))
{ $alerta=1; }
else
{ $alerta=0; }
	
mysqli_query($con,"UPDATE adm SET alerta='".$alerta."' WHERE id='".$id."'");

//echo "<div style='width:100%; height:50px; background-color:#096;'><div align='center' style='padding-top:15px; font-family:Verdana, Geneva, sans-serif; font-size:17px;'><font color='#FFFFFF'>Dados alterados com sucesso!</font></div></div>";

echo "<div id='myModal' class='modal fade' role='dialog'> <div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'> <h4 class='modal-title'>Alerta!</h4> </div> <div class='modal-body'> <h5>Alterado com sucesso!</h5> </div> <div class='modal-footer'> <button type='button' class='btn btn-default' data-dismiss='modal'>Fechar</button> </div> </div> </div> </div> ";

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
  


						<div class="col-md-12">
                            
                            <div class="block">


<button style="top:5px; right:0px; float:right;" type="button" name="answer" onClick="showDiv('welcomeDiv3')" class="btn btn-success"><i class="fa fa-plus"></i> Msg de Ausência</button>


<button style="top:0px; right:140px; position:absolute; float:right;" type="button" name="answer" onClick="showDiv('welcomeDiv2')" class="btn btn-success"><i class="fa fa-plus"></i> Meus Dados</button>


<button style="top:0px; right:255px; position:absolute; float:right;" type="button" name="answer" onClick="showDiv('welcomeDiv1')" class="btn btn-success"><i class="fa fa-plus"></i> Alerta de Conectividade</button>

							</div>
                            
                        </div>




<div id="welcomeDiv3" style="display:none;" class="answer_list">
<button style="top:61px; z-index:999; right:11px; position:absolute; float:right;" type="button" name="answer" onClick="showDiv('welcomeDiv3')" class="btn btn-warning"><i class="fa fa-minus"></i> Msg de Ausência</button>
                    <div class="row">
                    
                        <div class="col-md-12">
                            
                            <div class="block">
                                                               
                                <form action="<?php $PHP_SELF; ?>" method="post">
                                <div class="block-content">
                                    <div class="form-group">
                                        <label>Mensagem de ausência:</label>
                                        <div class="input-group file">
<?php
$resultado = mysqli_query($con,"SELECT id, msg_off FROM api ");
while($linha = mysqli_fetch_array($resultado))
{ 
?>                                             
 
 									<input type="hidden" name="id" value="<?php echo $linha['id']; ?>" />
                                    
                                    <textarea style="height:100px; resize: none;" name="msg_off" class="form-control" maxlength="255" autocomplete="off"><?php echo $linha['msg_off']; ?></textarea>
<?php } ?>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" name="BTAtualizar" type="submit" style="top:-35px;">Salvar</button>
                                            </span>
                                        </div>                                        
                                    </div>
                                    
                                    
                                </div>
                                
                                </form> 
                                
                            </div>
                            
                        </div>
                    </div>
</div>



<div id="welcomeDiv2" style="display:none;" class="answer_list">
<button style="top:61px; z-index:999; right:151px; position:absolute; float:right;" type="button" name="answer" onClick="showDiv('welcomeDiv2')" class="btn btn-warning"><i class="fa fa-minus"></i> Maus Dados</button>
                    <div class="row">
                    
<?php
$resultado = mysqli_query($con,"SELECT * FROM adm WHERE user_cli='".$user_cli."'");
while($linha = mysqli_fetch_array($resultado))
{ 
?> 
                                      
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block">               
                                
                                <form action="<?php $PHP_SELF; ?>" method="post">
                                <div class="block-content">
                                   
                                    <input type="hidden" name="id" value="<?php echo $linha['id']; ?>" />
                                    <input type="hidden" name="code_cli" value="<?php echo $linha['code_cli']; ?>" />
                                    
                                    <div class="col-md-6">
                                                        
                                        <div class="form-group">
                                            <label>Email de Login:</label>
                                            <input name="email_adm" type="text" value="<?php echo $linha['email_adm']; ?>" required autocomplete="off" class="form-control"> 
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>WhatsApp: EX: 55DDDnúmero</label>
                                            <input name="whatsapp" type="text" value="<?php echo $linha['whatsapp']; ?>" maxlength="13" required autocomplete="off" class="form-control"> 
                                        </div>
                                                                             
                                    </div>
                                    <div class="col-md-6">
                                    
                                        <div class="form-group">
                                            <label>Senha:</label>
                                            <input name="pass_adm" type="text" value="<?php echo $linha['pass_adm']; ?>" required autocomplete="off" class="form-control">
                                        </div>
                                        
                                        
                                        <div class="page-toolbar-block pull-right">
                                            <div class="widget-info widget-from">
                                                <button type="submit" name="BTAtualiza" class="btn btn-success" onClick="return confirm('Concluir edição?')"><i class="fa fa-floppy-o"></i> Salvar</button>
                                               
                                            </div>
                                        </div>                                                                                                            
                                    </div>
                                    
                                </div>
                                </form>
                            </div>                            
                        </div>
                    </div>
                    
<?php } ?>

                    </div>
</div>




<div id="welcomeDiv1" style="display:none;" class="answer_list">
<button style="top:61px; z-index:999; right:266px; position:absolute; float:right;" type="button" name="answer" onClick="showDiv('welcomeDiv1')" class="btn btn-warning"><i class="fa fa-minus"></i> Alerta de Conectividade</button>
                    <div class="row">
                    
                        <div class="col-md-12">
                            
                            <div class="block">
                                                               
                                <form action="<?php $PHP_SELF; ?>" method="post">
                                <div class="block-content">
                                    <div class="form-group">
                                        <label>Alerta de notificação a cada 30 minutos:</label>
                                        <div class="input-group file">
<?php
$resultado = mysqli_query($con,"SELECT id, alerta FROM adm ");
while($linha = mysqli_fetch_array($resultado))
{ 
?>                                             

 									<input type="hidden" name="id" value="<?php echo $linha['id']; ?>" />
                                    
                                   
                                    <div class="checkbox" style="margin-top:25px; height:30px;">
										<?php if ( $linha['alerta'] == 1) { ?> 
                                            <label for="info" class="btn btn-info">Receber notificação no WhatsApp quando desconectado do servidor:
                                            	<input type="checkbox" id="info" name="alerta" class="badgebox" checked><span class="badge">&check;</span>
                                            </label>    
                                        <?php } else { ?>	
                                            <label for="info" class="btn btn-info">Receber notificação no WhatsApp quando desconectado do servidor
                                            	<input type="checkbox" id="info" name="alerta" class="badgebox"><span class="badge">&check;</span>
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
            <div class="page-sidebar">
                                
            </div>
            
        </div> 
        
    </body>

</html>