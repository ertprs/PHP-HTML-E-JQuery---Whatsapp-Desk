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
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="block" style="background:#006; color:#FFF; padding:10px;">
                                        Vídeo Painel Admin
                                    </div>                            
                                </div>
                            </div>
                            
                            <div class="block" align="center">

								<video width="1000" height="480" controls>
									<source src="https://www.whatscompany.com.br/apresentacao/multi-atendimento-admin.mp4" type="video/mp4">
										<object data="" width="320" height="240">
											<embed width="320" height="240" src="https://www.whatscompany.com.br/apresentacao/multi-atendimento-admin.mp4">
										</object>
								</video>

							</div>
                            
                            
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="block" style="background:#006; color:#FFF; padding:10px;">
                                        Vídeo Tela de Atendimento
                                    </div>                            
                                </div>
                            </div>
                            
                            <div class="block" align="center">

								<video width="1000" height="480" controls>
									<source src="https://www.whatscompany.com.br/apresentacao/multi-atendimento-atendente.mp4" type="video/mp4">
										<object data="" width="320" height="240">
											<embed width="320" height="240" src="https://www.whatscompany.com.br/apresentacao/multi-atendimento-atendente.mp4">
										</object>
								</video>

							</div>
                            
                        </div>

                    
                    
                </div>
            </div>
            <div class="page-sidebar">
                                
            </div>
            
        </div> 
        
    </body>

</html>