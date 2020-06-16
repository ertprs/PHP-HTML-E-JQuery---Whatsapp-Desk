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
        <title>Status de Tag</title>    

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


<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
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
                        
                            <div class="page-toolbar-block col-md-2">
                                <div class="page-toolbar-title">Relatório</div>
                                <p>Busque por atendentes, tags ou datas.</p>
                            </div>
                            
                            <div class="page-toolbar-block col-md-2" style="background:#D3FCFE; border-radius:5px;">
                            	<div class="page-toolbar-subtitle" style="color:#000;">Atendentes</div>
                                <select name="user_cli_ativa" class="form-control" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
                                    <option value="#">Selecionar atendente</option>
                                    <?
                                        $sql4 = "SELECT nome_cli, user_cli FROM usuarios order by nome_cli ASC ";
                                        
                                        $limite = mysqli_query($con,$sql4); 
                                        while ($sql4=mysqli_fetch_array($limite)) {  
                                        $user_cli    	= $sql4['user_cli'];
										$nome_cli    	= $sql4['nome_cli'];
                                    ?> 
                                    <option value="status_tag?at=<? echo "$user_cli"; ?>"><? echo "$nome_cli"; ?></option> 
                                    <? } ?>  
                                </select>
                                <p></p>
                            </div>
                            
                            <div class="page-toolbar-block col-md-2" style="background:#B3FDAA; border-radius:5px;">
                            	<div class="page-toolbar-subtitle" style="color:#000;">Tags</div>
                                <select name="user_cli_ativa" class="form-control" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
                                    <option value="#">Selecionar tag</option>
                                    <?
                                        $sql2 = "SELECT name FROM tags order by name ASC ";
                                        
                                        $limite = mysqli_query($con,$sql2); 
                                        while ($sql2=mysqli_fetch_array($limite)) {  
                                        $name    	= $sql2['name'];
                                    ?> 
                                    <option value="status_tag?tag=<? echo "$name"; ?>"><? echo "$name"; ?></option> 
                                    <? } ?>  
                                </select>
                                <p></p>
                            </div>
                            
                            
                            
                            <form action="status_tag" method="get">
<?
$data_inicio = $_GET["data_inicio"];
$data_final = $_GET["data_final"];

if (trim($data_inicio) === "" && trim($data_final) === "") {
	$data_inicio = date('Y-m-d');
	$data_final = date('Y-m-d');
}

?>                            
                            
                            <div class="page-toolbar-block col-md-4" style="background:#FFBD9D; border-radius:5px; height:65px;">
                                <div class="page-toolbar-subtitle" style="color:#000;">Início</div>
                                <input type="text" class="form-control datepicker" name="data_inicio" value="<? echo "$data_inicio"; ?>" autocomplete="off" style="color:#F00; width:100px;"/>
                                
                              
                                <div class="page-toolbar-subtitle" style="margin-left:150px; margin-top:-55px; color:#000;">Final</div>
                                <input type="text" class="form-control datepicker" name="data_final" value="<? echo "$data_final"; ?>" autocomplete="off" style="color:#F00; width:100px; margin-left:130px;"/>
                            	
                               <button class="btn btn-success sc-set-default" type="submit" style="margin-left:250px; margin-top:-47px;">Buscar</button>
                                   
                            </div>
                           
                            </form>       
                        </div>                    
                     
                    <div class="row">
                        <div class="col-md-12">
                            
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="block">
                                
                                <div class="block-content np">
                                    
                                    <table id="customers2" class="table datatable">
                                        
                                        <tbody>

<?php

		$at = $_GET['at'];
		$sql = "SELECT * FROM contatos WHERE user_cli='".$at."' ORDER BY data_rt ASC";
	
	
		$result = mysqli_query($con,$sql) or die(mysqli_error($con)); 
		$num_rows = mysqli_num_rows($result);
								   
if($num_rows > 0 ) {

    while($linha = mysqli_fetch_array($result)) {
		$id 			= $linha["id"];
		$nome       	= $linha["nome"];
		$numero		    = $linha["numero"];
		$tag    		= $linha["tag"];
		$data_rg 		= $linha["data_rg"];
		$data_rt 		= $linha["data_rt"];
		$user           = $linha["user_cli"];


	$sql3 = "SELECT nome_cli FROM usuarios WHERE user_cli='".$user."' ";
	
	$limite = mysqli_query($con,$sql3); 
	while ($sql3=mysqli_fetch_array($limite)) {  
	$nome_cli    	= $sql3['nome_cli'];
	
	//echo $nome_cli;
	}
?> 
                                            
                                            <tr>
                                                <td><strong>Cliente:</strong> <? echo $nome; ?></td>
                                                <td><strong>WhatsApp:</strong> <? echo $numero; ?></td>
                                                <td><strong>1º Contato:</strong> <? echo $data_rg; ?></td>
                                                <td><strong>Retorno:</strong> <? echo $data_rt; ?></td>
                                                <td><strong>Atendente:</strong> <? echo $nome_cli; ?></td>
                                                <td><strong>Tag:</strong> <? echo $tag; ?></td>
                                            </tr>
                                      
<?   
  }
   
} else { }
?>
                                            
                                    	</tbody>    
                                    </table>
                                    
                                </div>
                            </div>                            
                            <!-- END DATATABLE EXPORT --> 
                            
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="block">
                                
                                <div class="block-content np">
                                    
                                    <table id="customers2" class="table datatable">
                                        
                                        <tbody>

<?php

		$tag = $_GET['tag'];
		$sql = "SELECT * FROM contatos WHERE tag='".$tag."' ORDER BY data_rt ASC";
	
	
		$result = mysqli_query($con,$sql) or die(mysqli_error($con)); 
		$num_rows = mysqli_num_rows($result);
								   
if($num_rows > 0 ) {

    while($linha = mysqli_fetch_array($result)) {
		$id 			= $linha["id"];
		$nome       	= $linha["nome"];
		$numero		    = $linha["numero"];
		$tag    		= $linha["tag"];
		$data_rg 		= $linha["data_rg"];
		$data_rt 		= $linha["data_rt"];
		$user           = $linha["user_cli"];


	$sql3 = "SELECT nome_cli FROM usuarios WHERE user_cli='".$user."' ";
	
	$limite = mysqli_query($con,$sql3); 
	while ($sql3=mysqli_fetch_array($limite)) {  
	$nome_cli    	= $sql3['nome_cli'];
	
	//echo $nome_cli;
	}
?> 
                                            
                                            <tr>
                                                <td><strong>Cliente:</strong> <? echo $nome; ?></td>
                                                <td><strong>WhatsApp:</strong> <? echo $numero; ?></td>
                                                <td><strong>1º Contato:</strong> <? echo $data_rg; ?></td>
                                                <td><strong>Retorno:</strong> <? echo $data_rt; ?></td>
                                                <td><strong>Atendente:</strong> <? echo $nome_cli; ?></td>
                                                <td><strong>Tag:</strong> <? echo $tag; ?></td>
                                            </tr>
                                      
<?   
  }
   
} else { }
?>
                                            
                                    	</tbody>    
                                    </table>
                                    
                                </div>
                            </div>                            
                            <!-- END DATATABLE EXPORT --> 
                            
                            
                            
                            <!-- START DATATABLE EXPORT -->
                            <div class="block">
                                
                                <div class="block-content np">
                                    
                                    <table id="customers2" class="table datatable">
                                        
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
		$tag    		= $linha["tag"];
		$data_rg 		= $linha["data_rg"];
		$data_rt 		= $linha["data_rt"];
		$user           = $linha["user_cli"];


	$sql3 = "SELECT nome_cli FROM usuarios WHERE user_cli='".$user."' ";
	
	$limite = mysqli_query($con,$sql3); 
	while ($sql3=mysqli_fetch_array($limite)) {  
	$nome_cli    	= $sql3['nome_cli'];
	
	//echo $nome_cli;
	}
?>                                         

                                            
                                            <tr>
                                                <td><strong>Cliente:</strong> <? echo $nome; ?></td>
                                                <td><strong>WhatsApp:</strong> <? echo $numero; ?></td>
                                                <td><strong>1º Contato:</strong> <? echo $data_rg; ?></td>
                                                <td><strong>Retorno:</strong> <? echo $data_rt; ?></td>
                                                <td><strong>Atendente:</strong> <? echo $nome_cli; ?></td>
                                                <td><strong>Tag:</strong> <? echo $tag; ?></td>
                                            </tr>
                                      
<?   
  }
   
} else { }
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