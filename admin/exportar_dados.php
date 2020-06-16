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

$user_cli    = $_SESSION['user_cli'];
$status_cli  = $_SESSION['status'];
$status_n    = $_SESSION['status_n'];
$limite_msg  = $_SESSION['limite_msg'];
$code_cli    = $_SESSION['code_cli'];
$agencia     = $_SESSION['agencia'];
$user_master    = $_SESSION['user_master'];
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
        <title>Exportar Dados</title>    

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
        
        <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/plugins/tableexport/tableExport.js"></script>
		<script type="text/javascript" src="js/plugins/tableexport/jquery.base64.js"></script>
        <script type="text/javascript" src="js/plugins/tableexport/html2canvas.js"></script>
        <script type="text/javascript" src="js/plugins/tableexport/jspdf/libs/sprintf.js"></script>
        <script type="text/javascript" src="js/plugins/tableexport/jspdf/jspdf.js"></script>
        <script type="text/javascript" src="js/plugins/tableexport/jspdf/libs/base64.js"></script>        
        
        <script type="text/javascript" src="js/plugins.js"></script>
        <script type="text/javascript" src="js/demo.js"></script>
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
                        
                            <div class="page-toolbar-block col-md-3">
                                <div class="page-toolbar-title">Relatório</div>
                                <div class="page-toolbar-subtitle">Selecione as datas para buscar.</div>
                            </div>
                            <form action="exportar_dados" method="get">
<?
$data_inicio = $_GET["data_inicio"];
$data_final = $_GET["data_final"];

if (trim($data_inicio) === "" && trim($data_final) === "") {
	$data_inicio = date('Y-m-d');
	$data_final = date('Y-m-d');
}

?>                            
                            <div class="page-toolbar-block col-md-3">
                                <div class="page-toolbar-subtitle">Data Inicial</div>
                                <input type="text" class="form-control datepicker" name="data_inicio" value="<? echo "$data_inicio"; ?>" autocomplete="off" style="color:#F00;"/>
                            </div>
                            
                            <div class="page-toolbar-block col-md-3">
                                <div class="page-toolbar-subtitle">Data Final</div>
                                <input type="text" class="form-control datepicker" name="data_final" value="<? echo "$data_final"; ?>" autocomplete="off" style="color:#F00;"/>
                            </div>                                                
                            
                            <div class="page-toolbar-block col-md-2">
                                <div class="page-toolbar-subtitle">Concluir</div>
                                    <button class="btn btn-success sc-set-default" type="submit">Buscar</button>
                            </div>
                            </form>       
                        </div>                    
                     
                    <div class="row">
                        <div class="col-md-12">
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="block">
                                <div class="block-content">
                                    <h3 class="pull-left" style="margin: 5px 0px; line-height: 20px;">Exportação de Dados</h3>
                                    <div class="btn-group pull-right">
                                       
 
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Exportar Dados</button>
                                        <ul class="dropdown-menu">
                                            
                                            <li><a href="xls?data_inicio=<? echo "$data_inicio"; ?>&data_final=<? echo "$data_final"; ?>"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                            
                                        </ul>

                                       
                                    </div>
                                </div>
                                <div class="block-content np">
                                    
                                    <table id="customers2" class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>WhatsApp</th>
                                                <th>Data de registro</th>
                                                <th>Data de retorno</th>
                                            </tr>
                                        </thead>
                                        <tbody>

<?php
$data_inicio = $_GET["data_inicio"];
$data_final = $_GET["data_final"];

if (trim($data_inicio) === "" && trim($data_final) === "") {
	$data_inicio = date('Ymd');
	$data_final = date('Ymd');
}


		$sql = "SELECT * FROM contatos WHERE data_rg >= '".$data_inicio."' AND data_rg <= '".$data_final."' ORDER BY data_rg DESC";
	
	
		$result = mysqli_query($con,$sql) or die(mysqli_error($con)); 
		$num_rows = mysqli_num_rows($result);
								   
if($num_rows > 0 ) {

    while($linha = mysqli_fetch_array($result)) {
		$id 			= $linha["id"];
		$nome       	= $linha["nome"];
		$numero		    = $linha["numero"];
		$data_rg		= $linha["data_rg"];
		$data_rt 		= $linha["data_rt"];



?>                                        

                                            
                                            <tr>
                                                <td><? echo $nome; ?></td>
                                                <td><? echo $numero; ?></td>
                                                <td><? echo $data_rg; ?></td>
                                                <td><? echo $data_rt; ?></td>
                                            </tr>
                                      
<?   
  }
   
} else {
    echo "
	
	<div class='alert alert-info'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		<font color='#000000' size='2'><strong>Ops...</strong> Você não possui leads na data de hoje!</font>
	</div>
	
	";
}
?>
                                            
                                    	</tbody>    
                                    </table>
                                    
                                </div>
                            </div>                            
                            <!-- END DATATABLE EXPORT -->                            

                        </div>
                    </div>                    
                    
                </div>
            </div>
            <div class="page-sidebar">
                                
            </div>
            
        </div>
        
        
    </body>

</html>
<? mysqli_close($con); ?>