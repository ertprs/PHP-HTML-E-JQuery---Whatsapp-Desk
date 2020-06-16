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

		$sql = "SELECT * FROM api";

		$result = mysqli_query($con,$sql) or die(mysqli_error($con)); 
		$num_rows = mysqli_num_rows($result);
								   
if($num_rows > 0 ) {

    while($linha = mysqli_fetch_array($result)) {
		$api_token	  = $linha["api_token"];
		$api_email    = $linha["api_email"];
		$api_idapp    = $linha["api_idapp"];
 

// conexão com a api

$dados['email']= $api_email;
$dados['token']= $api_token;
$dados['idapp']= $api_idapp;

	}
}

$endpoint="https://www.solutek.online/api/whatsapp/gateway/json/status";

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
$logado= $retorno->logado;
$pronto= $retorno->pronto;
$nome= $retorno->nome;
$telefone= $retorno->telefone;
$bateria= $retorno->bateria;

?>
<!DOCTYPE html>
<html lang="en">
    

<head>        
        <title>Botão para site</title>    
      
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
        
        <script type="text/javascript" src="js/plugins/codemirror/codemirror.js"></script>
        <script type='text/javascript' src="js/plugins/codemirror/addon/edit/matchbrackets.js"></script>
        <script type='text/javascript' src="js/plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
        <script type='text/javascript' src="js/plugins/codemirror/mode/xml/xml.js"></script>
        <script type='text/javascript' src="js/plugins/codemirror/mode/javascript/javascript.js"></script>
        <script type='text/javascript' src="js/plugins/codemirror/mode/css/css.js"></script>
        <script type='text/javascript' src="js/plugins/codemirror/mode/clike/clike.js"></script>
        <script type='text/javascript' src="js/plugins/codemirror/mode/php/php.js"></script>        


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
                            <font size="3" color="#000000"><strong>Ops...</strong> Essa op&ccedil;&atilde;o foi desativada. Clique no <strong>MENU</strong> lateral para continuar navegando no painel.</font>
                        </div>
                    </div> 
                        
                      
                        
                        
                     
                      
                        
                        <div class="page-toolbar  col-md-12">
                            
                            <div class="block">
                                
                                <div class="block-content list nbfc">                                    
                                    
                                    
                                    

<?php
$url = $_SERVER['HTTP_REFERER']; 
$partes = parse_url($url);
//echo $partes['host'] . PHP_EOL; 
?>								
                                 
                                 
<div class="block">
                                <div class="block-content">
                                    <h2>Tag - Botão para abrir o WhatsApp</h2>
                                    <p>Copie e cole o código em seu script HTML. Veja o exemplo abaixo!</p>
                                    
<textarea id="codeEditor">

<style>
	.open-whats {
	  background-image:url(http://<? echo $partes['host']; ?>/images/whatsapp.png);
	  cursor: pointer;
	  position: fixed;
	  bottom: 10px;
	  right: 16px;
	  width: 50px;
	  height: 50px;
	}
</style>

<a class="open-whats" href="https://wa.me/<?php echo $telefone; ?>" target="_blank"></a>

</textarea>
                                    <script>
                                        var editor = CodeMirror.fromTextArea(document.getElementById("codeEditor"), {
                                            lineNumbers: true,
                                            matchBrackets: true,
                                            mode: "application/x-httpd-php",
                                            indentUnit: 4,
                                            indentWithTabs: true,
                                            enterMode: "keep",
                                            tabMode: "shift"                                                
                                        });
                                        editor.setSize('100%','420px');
                                    </script>                                    
                                    
                                    
                                </div>
                            </div>


                                   
                                   
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