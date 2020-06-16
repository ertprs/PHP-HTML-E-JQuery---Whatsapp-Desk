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
/*
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
*/

$urlend= "https://www.solutek.online/api/whatsapp/gateway/json/status";

$curl = curl_init($urlend);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER , false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);
$executa_api= curl_exec($curl);
curl_close($curl);
$ddsv= json_decode($executa_api);
$sucesso= $ddsv->sucesso;
$conectado= $ddsv->logado;
$nomecl= $ddsv->nome;
$telefone= $ddsv->telefone;
$bateria= $ddsv->bateria;



$urlend2= "https://www.solutek.online/api/whatsapp/gateway/json/qrcode_tentativas_emparelhar";

$curl2 = curl_init($urlend2);
curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER , false);
curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl2, CURLOPT_POST, true);
curl_setopt($curl2, CURLOPT_POSTFIELDS, $dados);
$executa_api2= curl_exec($curl2);
curl_close($curl2);
$ddsv2= json_decode($executa_api2);
$sucesso2= $ddsv2->sucesso;
$tentativas= $ddsv2->tentativas;
$auth1= $ddsv2->auth1;
$auth2= $ddsv2->auth2;


$tentativas2= $tentativas + 1;
if (!($auth=="")) {
	if ($tentativas=="1") {
		if ($auth1 == $auth) {
			$codauth= $auth1;
			$inia= "sim";
		} else {
			header('location: /sistema.php');	
		}
	}
	
	if ($tentativas=="2") {
		if ($auth2 == $auth) {
			$codauth= $auth2;
			$inia= "sim";
		} else {
			header('location: /sistema.php');
		}
	}
	
	if (($tentativas=="") or ($tentativas=="3") or ($tentativas=="0")) {
		header('location: /sistema.php');
	}
} else {
$tentativas2= 1;
}


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
        
        <script src='qrcode/jquery-3.3.1.min.js'></script>
		<link rel="stylesheet" type="text/css" href="qrcode/css_qrcode.css"/>
		<script type="text/javascript" src="qrcode/qrcode_javascript.js"></script>
        
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
                        
                        <div class="page-toolbar col-md-12">
                        
                            <div class="page-toolbar-block col-md-4">
                                <div class="page-toolbar-title">Dados do sistema</div>
                            </div>
                              
                        </div>
                        
                        
  
                        
                        
                        
                        <div class="col-md-12">
                            
                                                               
 
 
 
                    <div class="row">
                        <div class="col-md-3">
                            <div class="widget">
                                <div class="widget-container">
                                    <div class="window-block" align="center">
                                      <?php if ($conectado == "sim") { ?>  
                                        <img src="img/logado.png" width="43" height="54"/>
                                      <?php } else { ?>
                                        <img src="img/deslogado.png" width="49" height="54"/>
                                      <?php } ?>
                                    </div>
                                </div>
                                <div class="widget-content">
                                    <div class="widget-text" style="font-size:16px; text-align:center; margin-top:7px;"><strong>Logado</strong></div>
                                    <div class="widget-text" style="font-size:20px; text-align:center; margin-top:12px;"><strong>
									<?php if ($conectado == "sim") { ?>
                                    	Sim
									<?php } else { ?>
                                    	Não
                                    <?php } ?></strong></div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget widget-success">
                                <div class="widget-container">
                                    <div class="window-block" align="center">
                                        <img src="img/celular.png" width="32" height="52"/>
                                    </div>
                                </div>
                                <div class="widget-content">
                                    <div class="widget-text" style="font-size:16px; text-align:center; margin-top:7px;"><strong>Bateria</strong></div>
                                    <div class="widget-text" style="font-size:20px; text-align:center; margin-top:12px;"><strong><?php echo $bateria; ?>%</strong></div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget widget-warning">
                                <div class="widget-content" style="height:63px;">
                                    <div class="widget-text" style="font-size:16px; margin-top:7px;"><strong>WhatsApp</strong></div>
                                    <div class="widget-text" style="font-size:20px; margin-top:10px;"><strong><?php echo $telefone; ?></strong></div>                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget widget-info">
                                <div class="widget-content" style="height:63px;">
                                    <div class="widget-text" style="font-size:16px; margin-top:7px;"><strong>Nome</strong></div>
                                    <div class="widget-text" style="font-size:16px; margin-top:8px; min-width:200px;"><strong><?php echo $nomecl; ?></strong></div>                    
                                </div>
                            </div>
                        </div>
                        
                    </div>   
 
 
 
 
 
 
 
 
 
		<div class="fundo_en" style=""> <div class="td_popup"> <div class="msg_popup">  </div>  </div> </div>
		<div class="aln_login">
		
			
			<div class="lado2">
				<div class="ld2ent">
					
					<div class="divcont">
					
						<!--leitura do qrcode -->
						<input type="hidden" value="<?php echo($codauth); ?>" id="auth"/>
						<input type="hidden" id="lkauth"/>
						<div class="pttd" style="display: none;">
							<div class="pt1bs">
								<div class="enc_qr">
									<div class="enc_qr2">
										<div class="rdz" style="width: 120px; height: 120px; margin: 40px;">
											<img src="qrcode/carregando.gif" width="100%" height="100%" class="tkz" align="center"/>
										</div>
									</div>
								</div>
								
								
								<div id="timer">
					
								</div>
								<div class="ttv">
									<?php 
										if ($inia=="sim") {
											echo ("Tentativa ".$tentativas2."/3");
										} else {
											echo ("Tentativa 1/3");
										}
									?>
								</div>
							</div>
							<div class="pt2bs">
								<div class="prt1cm"> <b>Siga os passos abaixo para emparelhar seu número! </b> </div>	
								<div class="prt2cm"> 
									<b> 1° </b> Abra o WhatsApp em seu telefone <br/><br/>
									<b> 2° </b> Toque em menu ou configurações e selecione WhatsApp Web <br/><br/>
									<b> 3° </b> Aponte o telefone para o QRCODE ao lado e aguarde confirmar <br/><br/>
									<b> 4° </b> Após ler o QRCODE o sistema precisa de um intervalo para carregar as dependências. Geralmente em 2 Minutos constará como conectado. <br/><br/>
									<b> 5° </b> O QRCODE aparece em até 3 tentativas. Caso não apareça até a 3° tentativa entre em contato com nosso suporte <br/><br/>
									
									Após fazer isso você já poderá utilizar o Sistema! Lembre-se de deixar seu telefone sempre online para que o sistema funcione corretamente!
								</div>
							</div>
						
						</div>

						
						<div class="campotd" style="margin: 0px 0% 0% 0%;">
						
						

						<div class="campotd" id="ap2">
							<button class="bt_continuar" id="conn" style="margin-left:10px;"> <?php if ($conectado=="sim") { ?> Desconectar <?php } else { ?> Conectar <?php } ?>  </button>
							<?php 
								if ($revendedor=="true") {
							?>
							<button style="margin-left: 40px;" class="bt_continuar" id="migrar"> Migrar Base  </button>
							<?php } ?>
						</div>
						
							
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