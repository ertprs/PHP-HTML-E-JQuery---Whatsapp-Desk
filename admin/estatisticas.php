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

$user_cli    		= $_SESSION['user_cli'];
$status_cli  		= $_SESSION['status'];
$status_n    		= $_SESSION['status_n'];
$limite_msg  		= $_SESSION['limite_msg'];
$code_cli    		= $_SESSION['code_cli'];
$agencia     		= $_SESSION['agencia'];
$user_master    	= $_SESSION['user_master'];
$user_adicional		= $_SESSION['user_adicional'];
$tipo_plano     = $_SESSION['tipo_plano'];

	
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
        <title>Estatísticas</title>    

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="img/favicon.png" type="image/x-icon" />
                
        <link href="css/styles.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 10]><link rel="stylesheet" type="text/css" href="css/ie.css"/><![endif]-->
        
        <link rel="stylesheet" type="text/css" href="css/ch-normalize.min.css">
        <link rel="stylesheet" type="text/css" href="css/ch.css"> 
        
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>                
        
        <script type="text/javascript" src="js/plugins/select2/select2.min.js"></script>
        
        <script type="text/javascript" src="js/plugins/bootstrap-editable/bootstrap-editable.min.js"></script>  
        <script type="text/javascript" src="js/plugins/bootstrap-editable/inputs-ext/address/address.js"></script>
        
        <script type="text/javascript" src="js/plugins/daterangepicker/moment.min.js"></script>        
        <script type="text/javascript" src="js/plugins/mockjax/jquery.mockjax.js"></script>
        
        <script type="text/javascript" src="js/plugins.js"></script>
        <script type="text/javascript" src="js/demo.js"></script>
        <script type="text/javascript" src="js/demo-editable.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>   
        
        <script src="amcharts/amcharts.js" type="text/javascript"></script>
        <script src="amcharts/serial.js" type="text/javascript"></script>

        <!-- scripts for exporting chart as an image -->
        <!-- Exporting to image works on all modern browsers except IE9 (IE10 works fine) -->
        <!-- Note, the exporting will work only if you view the file from web server -->
        <!--[if (!IE) | (gte IE 10)]> -->
        <script type="text/javascript" src="amcharts/plugins/export/export.js"></script>
        <link  type="text/css" href="amcharts/plugins/export/export.css" rel="stylesheet">     
 
<?php $ano = date("Y"); ?>
        
        <!-- PRIMEIRO CONTATO -->
        <script>
            var chart;

            var chartData = [{
                "country": "Janeiro",
                "visits": 
				<?php
					$sql = "select  count(*) as qtd from contatos WHERE data_rg >= '$ano-01-01' AND data_rg <= '$ano-01-31' ";
					$result = mysqli_query($con,$sql);
					$data=mysqli_fetch_assoc($result);
					if($result>=1) { 
				?> 			   
							   <?php  echo $data['qtd']; ?>
				<?php } ?>,
                "color": "#FF0F00"
            }, {
                "country": "Fevereiro",
                "visits": 
				<?php
					$sql = "select  count(*) as qtd from contatos WHERE data_rg >= '$ano-02-01' AND data_rg <= '$ano-02-28' ";
					$result = mysqli_query($con,$sql);
					$data=mysqli_fetch_assoc($result);
					if($result>=1) { 
				?> 			   
							   <?php  echo $data['qtd']; ?>
				<?php } ?>,
                "color": "#FF6600"
            }, {
                "country": "Março",
                "visits": 
				<?php
					$sql = "select  count(*) as qtd from contatos WHERE data_rg >= '$ano-03-01' AND data_rg <= '$ano-03-31' ";
					$result = mysqli_query($con,$sql);
					$data=mysqli_fetch_assoc($result);
					if($result>=1) { 
				?> 			   
							   <?php  echo $data['qtd']; ?>
				<?php } ?>,
                "color": "#FF9E01"
            }, {
                "country": "Abril",
                "visits": 
				<?php
					$sql = "select  count(*) as qtd from contatos WHERE data_rg >= '$ano-04-01' AND data_rg <= '$ano-04-30' ";
					$result = mysqli_query($con,$sql);
					$data=mysqli_fetch_assoc($result);
					if($result>=1) { 
				?> 			   
							   <?php  echo $data['qtd']; ?>
				<?php } ?>,
                "color": "#FCD202"
            }, {
                "country": "Maio",
                "visits": 
				<?php
					$sql = "select  count(*) as qtd from contatos WHERE data_rg >= '$ano-05-01' AND data_rg <= '$ano-05-31' ";
					$result = mysqli_query($con,$sql);
					$data=mysqli_fetch_assoc($result);
					if($result>=1) { 
				?> 			   
							   <?php  echo $data['qtd']; ?>
				<?php } ?>,
                "color": "#F8FF01"
            }, {
                "country": "Junho",
                "visits": 
				<?php
					$sql = "select  count(*) as qtd from contatos WHERE data_rg >= '$ano-06-01' AND data_rg <= '$ano-06-30' ";
					$result = mysqli_query($con,$sql);
					$data=mysqli_fetch_assoc($result);
					if($result>=1) { 
				?> 			   
							   <?php  echo $data['qtd']; ?>
				<?php } ?>,
                "color": "#B0DE09"
            }, {
                "country": "Julho",
                "visits": 
				<?php
					$sql = "select  count(*) as qtd from contatos WHERE data_rg >= '$ano-07-01' AND data_rg <= '$ano-07-31' ";
					$result = mysqli_query($con,$sql);
					$data=mysqli_fetch_assoc($result);
					if($result>=1) { 
				?> 			   
							   <?php  echo $data['qtd']; ?>
				<?php } ?>,
                "color": "#04D215"
            }, {
                "country": "Agosto",
                "visits": 
				<?php
					$sql = "select  count(*) as qtd from contatos WHERE data_rg >= '$ano-08-01' AND data_rg <= '$ano-08-31' ";
					$result = mysqli_query($con,$sql);
					$data=mysqli_fetch_assoc($result);
					if($result>=1) { 
				?> 			   
							   <?php  echo $data['qtd']; ?>
				<?php } ?>,
                "color": "#0D8ECF"
            }, {
                "country": "Setembro",
                "visits": 
				<?php
					$sql = "select  count(*) as qtd from contatos WHERE data_rg >= '$ano-09-01' AND data_rg <= '$ano-09-30' ";
					$result = mysqli_query($con,$sql);
					$data=mysqli_fetch_assoc($result);
					if($result>=1) { 
				?> 			   
							   <?php  echo $data['qtd']; ?>
				<?php } ?>,
                "color": "#0D52D1"
            }, {
                "country": "Outubro",
                "visits": 
				<?php
					$sql = "select  count(*) as qtd from contatos WHERE data_rg >= '$ano-10-01' AND data_rg <= '$ano-10-31' ";
					$result = mysqli_query($con,$sql);
					$data=mysqli_fetch_assoc($result);
					if($result>=1) { 
				?> 			   
							   <?php  echo $data['qtd']; ?>
				<?php } ?>,
                "color": "#2A0CD0"
            }, {
                "country": "Novembro",
                "visits":
				<?php
					$sql = "select  count(*) as qtd from contatos WHERE data_rg >= '$ano-11-01' AND data_rg <= '$ano-11-30' ";
					$result = mysqli_query($con,$sql);
					$data=mysqli_fetch_assoc($result);
					if($result>=1) { 
				?> 			   
							   <?php  echo $data['qtd']; ?>
				<?php } ?>,
                "color": "#8A0CCF"
            }, {
                "country": "Dezembro",
                "visits": 
				<?php				
					$sql = "select  count(*) as qtd from contatos WHERE data_rg >= '$ano-12-01' AND data_rg <= '$ano-12-31' ";
					$result = mysqli_query($con,$sql);
					$data=mysqli_fetch_assoc($result);
					if($result>=1) { 
				?> 			   
							   <?php  echo $data['qtd']; ?>
				<?php } ?>,
                "color": "#CD0D74"
            
            }];


            var chart = AmCharts.makeChart("chartdiv", {
                type: "serial",
                dataProvider: chartData,
                categoryField: "country",
                depth3D: 20,
                angle: 30,

                categoryAxis: {
                    labelRotation: 90,
                    gridPosition: "start"
                },

                valueAxes: [{
                    title: "Contatos"
                }],

                graphs: [{

                    valueField: "visits",
                    colorField: "color",
                    type: "column",
                    lineAlpha: 0,
                    fillAlphas: 1
                }],

                chartCursor: {
                    cursorAlpha: 0,
                    zoomable: false,
                    categoryBalloonEnabled: false
                },
                "export": {
                    "enabled": true
                }

            });
        </script> 
        
        <!-- FIM DOS CONTATOS -->
        
        

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
                      
                    <div class="page-toolbar">
                        
                        <div class="page-toolbar-block">
                            <div class="page-toolbar-title">Estatísticas</div>
                            <p>Acompanhe o recebimento de mensagens mês a mês.</p>
                        </div>
                        
                    </div>
                                  
                       <div class="col-md-12">
                            
                            <div class="block">
                                <div class="block-content list nbfc">                                    
                                   
                                    <div class="list-item">
                                        <div class="list-item-content">
                                        	<h4>Novos contatos:</h4>
                        
                                            <div align="center" class="col-md-11">          
                                                <div id="chartdiv" style="width: 100%; height: 400px;"></div>
                                            </div>
                                            
                                         </div>
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
<?php mysqli_close($con); ?>