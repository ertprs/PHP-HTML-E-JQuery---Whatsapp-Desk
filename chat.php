<?php

	session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: 0"); // Proxies.

  // ATIVAR DEPOIS 
	//session_cache_limiter("nocache"); 

	if ( empty($_SESSION['user_cli']) || $_SESSION['controle'] !='345067821133') {
		 header("Location: index.php");
		 die();
	} 
	
?>



<!DOCTYPE html>
<html class=''>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CLEAR CACHE -->
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>
<!-- *********** -->

<title>Painel Multi-Atendimento</title>
<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<script src='js/jquery-3.3.1.min.js'></script> 
<script src="js/bootstrap.min.js"></script>
<script src="js/summernote.min.js"></script>

<link rel='stylesheet prefetch' href='css/reset.min.css'>
<link rel='stylesheet prefetch' href='css/font-awesome.min.css'>
<link rel='stylesheet' href='css/material-design-iconic-font.min.css'>
<link rel='stylesheet' href='css/summernote.min.css'>


<link rel="stylesheet" type="text/css" href="css/theme.css">
<link rel="stylesheet" type="text/css" href="css/menu.css">
<link rel="stylesheet" type="text/css" href="css/menu_excluir.css">

<!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->

<script src='js/menu_excluir.js'></script>
 
<style class="cp-pen-styles">body {

  display: flex;
  align-items: center; 
  justify-content: center;
  font-family: "proxima-nova", "Source Sans Pro", sans-serif;
  font-size: 1em;
  letter-spacing: 0.1px;
  color: #32465a;
  text-rendering: optimizeLegibility;
  text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.004);
  -webkit-font-smoothing: antialiased;
  
  height: 100%;
  width: 100%;
  overflow: hidden;
  padding: 0;
  margin: 0;
  /*margin-top:35px; */
}
    .tag-select{border:1px solid #ccc; margin-top:15px; height: 32px;  background: #3276B1; color:#FFF; border-radius: 5px;}

    #notepadBtn{
        background-image: url("./images/notes.svg");
        background-repeat: no-repeat;
        width: 32px;
        height: 32px;
        float: left;
        cursor: pointer;
		position: relative;
		margin-top: 15px;
		margin-right: 15px;
    }

    .note-insert, .note-view, .note-table {
        display: none;
    }
    .note-editable{
        height: 80vh;
    }
</style>

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
 	
</head>

<body onLoad="StartApp ();">

<!--oncontextmenu="return false"-->

<div id="frame">

	<div id="sidepanel">
		<div id="divStatus" style="text-align:center;width:100%;height:20px;background-color:#FFE500;color:#000000;font-weight: bold; font-size:16px; padding:3px; top:0px;">VERIFICANDO CONEXÃO</div>
		<div id="profile">
		    
			<div class="wrap" id="block_container">
				<img id="profile-img" src="images/2.png" class="online" alt="" />
				<table>
					<tr>
						<td>
							<div id="bloc1"> <?=$_SESSION['nome_cli']?></div> 
						</td>
						<td>
							<!--<div id="bloc2" class="dropbtn" onclick="TheMenu();" style="background-image: url('images/menu.jpg');"></div> -->
						</td>
					</tr>
				</table>
			</div>
			<br>
				
			
		</div>
		
		
			<div id="search">

				<label for=""><img src="images/search-icon.png" width="20" height="20"></label>
				<input type="text" class="form-control"  name="txtPesquisa" id="txtPesquisa" autocomplete="off" value="" placeholder="Procura Nome ou Número para iniciar conversa" />
				<input type="hidden" class="form-control"  name="controle" id="controle"  value="345067821133">

			</div>
		
		
		<div id="contacts">
			<ul id="myContacts">
			
			    <!--
				<li class="contact">
					<div class="wrap">
						<!-- <span class="contact-status novamensagem"></span> -->
				<!--
						<img src="" alt="" />
						<div class="meta">
							<p class="name">Nome</p>
							<p class="preview">Telefone>
						</div>
					</div>
				</li>
			   
				
 			    <li class="contact">
					<div class="wrap">
						
						<img src="" alt="" />
						<div class="meta">
							<p class="name">Fulano</p>
							<p class="preview">Telefone</p>
						</div>
					</div>
				</li>
                -->
				
			</ul>
			
		</div>
	

		<div id="bottom-bar" style="background:#DDDDDD; height:30px;">
			<button id="btnAddContact" style="background:#DDDDDD; background-image: url('images/add.jpg'); background-repeat: no-repeat; margin-left:50px; margin-top:2px;"></button>
			
			<button id="settings" class="dropbtn" onClick="TheMenu();" style="background:#DDDDDD; background-image: url('images/config.jpg'); background-repeat: no-repeat; margin-left:-30px; margin-top:2px;"></button>
			
		</div>

		
	</div>
	



		
	<div class="content">

		<div class="contact-profile" id="contact-profile">
			<img src="images/active_contact.png" alt="" />
			<span id="texto"></span>

			 <div id="divBtnAcessarTransferencia">
                 <div id="notepadBtn" data-toggle="modal" href="#notepadModal" class="btn btn-clean"></div>
                 
                 <select class="btn btn-primary btn-clean" id="tag" style="margin-right:10px; height:30px; padding-top:4px;" disabled='disabled'></select>
                 
             <!-- Botão de acesso ao modal de transferência de clientes --> 
		         <button type="button" id="btnAcessarTransferencia" class="btn btn-success btn-clean" data-toggle="modal"  style="margin-right:10px; height:30px; padding-top:4px;" disabled='disabled'>Transferir Cliente</button>
			 <!-- Botão e acesso ao modal de alteração de contato 
                 <button type="button" id="btnAcessarAlterarTelefone" class="btn btn-primary btn-clean" data-toggle="modal"  style="margin-right:10px; height:30px; padding-top:4px;" disabled='disabled'>Alterar Telefone</button>	-->
			 <!-- Botão e acesso ao modal de transferência de todos os contato -->
                 <button type="button" id="btnAcessarTransferirTContatos" class="btn btn-warning btn-clean" data-toggle="modal"  style="margin-right:10px; height:30px; padding-top:4px;" disabled='disabled'>Transferir Todos Contatos</button>	 
			 <!-- Botão e acesso ao modal de exclusão de contato -->
			     <!--
                 <button type="button" id="btnAcessarExclusaoContato" class="btn btn-danger btn-clean" data-toggle="modal"  style="margin-right:10px; height:30px; padding-top:4px;" disabled='disabled'>Excluir Contato</button>			 
				 --> 
			 </div> 
			 
		</div>		
		
            <div class="conversation">
			
              <div class="conversation-container" id="bulk">
			  
               
				
			  </div>
              			  
            </div>
			
		    
            <div class="conversation-compose">
                	
					
					<textarea class="input-msg" id="txtNewMessage" placeholder="Digite uma mensagem" autocomplete="off" autofocus style="padding: 15px; padding-left:10px;overflow:hidden;"></textarea>
                    
                    				
                    <!--Upload -->
                    <form id="formUpload" name="formUpload" method="post" enctype="multipart/form-data">               			    
						<div class="photo"><p style="color:#FFF; font-size:11px;">.</p>
						  <label for='selecao-arquivo' id="lbl-selecao-arquivo" style="margin-top:20px;" title="Seleciona arquivo" disabled><i id= "icon-attachment" class="zmdi zmdi-attachment-alt" disabled></i></label>
						  <input name='selecao-arquivo' id='selecao-arquivo' type='file' title="Seleciona arquivo" disabled>

						  <label id='lbl-enviar-arquivo' style="padding:10px; margin-top:5px;display:none" title="Envia arquivo" style="margin-top:20px;"><i class="zmdi zmdi-upload"></i></label>
                     
						</div>
                    </form>
                    
					
					<button class="send">
						<div class="circle">
						  <i class="zmdi zmdi-mail-send"></i>
						</div>
					</button>
					 
                     					 
            </div>

			
		
	</div>

	<div id="myDropdown" class="dropdown-content">
	    
         <? if ($_SESSION['alerta_sonoro']==0 ) { ?>
	        <a href="#notificacao" id="notificacao">Ativar Alerta Sonoro</a>
		 <? } else { ?>
		    <a href="#notificacao" id="notificacao">Desativar Alerta Sonoro</a>
		 <? } ?>
		<!--
		<a href="#transferir">Transferir</a> -->
    	<a href="#logout">Sair</a>
        
	</div>
	
	<div id="myDropdownExcluir" class="dropdown-excluir-content">
	    <a href="#excluir">Excluir</a>
	</div>
	
	
    <!-- <div id="ContatoAtivodiv" > -->
	
	<div id="ContatoAtivodiv" hidden="">
		<label class="checkbox-inline" style="font-size: 14px; line-height: 1.25">
			<input style="margin-top: 0.125em; width: 1em; height: 1em;"
				type="checkbox"
				id="sentbeep"
				value=""
				 /> <!-- checked -->
				Beep ao enviar mensagem
		</label>
			 
	     <input type="hidden" id="txtTelefoneAtivo"    value="" >		 
	     <input type="hidden" id="txtContatoAtivo"     value="" maxlength="50">
		 <input type="hidden" id="txtNotificacao"      value="<?=$_SESSION['alerta_sonoro']?>">
		 <input type="hidden" id="txtProximaSequencia" value="0">
		 <input type="hidden" id="txtQtdMsg" value="0">
         <input type="hidden" id="txtUltimoId" value="0">
		 
	</div>
	
	<div id="AudioSound">
		 <audio id="alertSound">
         <source src="sound/toque.mp3" type="audio/mpeg">
         Esse navegador não suporta o elemento audio 
         </audio>	
	</div>
	

	<div id="NewSound">
		 <audio id="beepSound">
         <source src="sound/beep.mp3" type="audio/mpeg">
         Esse navegador não suporta o elemento audio 
         </audio>	
	</div>

	
  <!-- Modal Transferir -->
  
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Selecione um atendente:</h4>
        </div>
        <div class="modal-body">
        
                    <input name="cel" type="hidden" value="<? // echo $cel; ?>">
					
                    <select id="cmbUserCli" name="cmbUserCli" class="form-control" > 
	
                        <option value=""></option> 
 
                    </select>
                    
            <div class="modal-footer">                
                <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Fechar</button>
				<!--id anterior do botão btnTransfereMSG -->
                <button type="submit" id="btnTransfereClientes" name="btnTransfereClientes" class="btn btn-success btn-clean" >Transferir</button>
            </div>
                            

            <input name="posicao" type="hidden" value="<? // echo $proxima_sequencia; ?>">
                                
 
        </div>

      </div>
    <!-- Fim ET 4 -->
     
    </div>
  </div> 
  <!-- Fim Modal Transferir -->
  
   <!-- Modal Alert -->
  <div class="modal fade" id="myAlert" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Atenção</h4>
        </div>
        <div class="modal-body">
          <p>Texto</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- Fim Modal Alert -->
  
  <!-- Modal Confirm -->
  
  <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="myConfirm">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Atenção</h4>
		  </div>
			<div class="modal-body">
			  <p>Texto</p>
			</div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" id="modal-btn-si">Sim</button>
			<button type="button" class="btn btn-primary" id="modal-btn-no">Não</button>
		  </div>
		</div>
	  </div>
  </div>

  <!-- Fim Modal Confirm -->
  
  <!-- Modal(s) de imagem -->
  
  <div id="myModalImg" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img class="img-responsive" src="" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
   </div>

   <!-- Fim Modal de Imagem(s) -->


  <!-- Modal Alteração de Nome -->
  <!-- 31/05/2019 -->
  <div class="modal fade" id="myModalAlterarNome" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Alteração de Nome:</h4>
        </div>
        <div class="modal-body">
       		 
			 <p>
             <label for="txtTelefoneNomeAlterado"> Telefone: </i> </label>			 
             <input type="text" id="txtTelefoneNomeAlterado" disabled   value="" style="margin-left:25px; padding: 5px 10px; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
             </p>
             <br>
			 <p>
             <label for="txtNovoNome"> Novo Nome: </i> </label>	 			 
			 <input type="text" id="txtNovoNome"  maxlength="40"  required value="" style="margin-left:6px; padding: 5px 10px; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
			 </p>
			 <br>
			 <!--Tem que ser &nbsp para não esconder a linha <!--font-weight:bold --> 
			 <span id="spanAlteraNome" style="color:red;">&nbsp</span>
			 
            <div class="modal-footer">                
                <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Fechar</button>
                <button type="submit" id="btnAlteraNome" name="btnAlteraNome" class="btn btn-success btn-clean" >Alterar Nome</button>
            </div>
                            
        </div>

      </div>
    
     
    </div>
  </div> 
  <!-- Fim Modal Alteração de Nome -->
  
  <!-- Modal Adicionar Contato  -->
  <!-- 31/05/2019-B-->	

  <div class="modal fade" id="myModalAdicionarContato" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Adicionar Contato:</h4>
        </div>
        <div class="modal-body">
       		 
			 <p>
             <label for="txtAdicionarContatoTelefone"> Telefone: </i> </label>			 
             <input type="text" id="txtAdicionarContatoTelefone" maxlength="13" value="" style="margin-left:10px; padding: 5px 10px; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" placeholder="Exemplo: 55DDDTelefone">
             </p>
             <br>
			 <p>
             <label for="txtAdicionarContatoNome"> Nome: </i> </label>	 			 
			 <input type="text" id="txtAdicionarContatoNome"  maxlength="40"  required value="" style="margin-left:25px; padding: 5px 10px; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
			 </p>
			 <br>
			 <p>
             <label for="txtAdicionarContatoMsg"> Msg : </i> </label>
			 <textarea id="txtAdicionarContatoMsg" rows="3" cols="50" maxlength="50" placeholder="Digite sua mensagem aqui" required style="margin-left:30px; padding: 5px 10px; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"></textarea>
			 </p>
			 
			 <br>
			 <!--Tem que ser &nbsp para não esconder a linha <!--font-weight:bold --> 
			 <span id="spanAdicionarContato" style="color:red;">&nbsp</span>
			 
            <div class="modal-footer">                
                <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Fechar</button>
                <button type="submit" id="btnAdicionaContato" name="btnAdicionaContato" class="btn btn-success btn-clean" >Adicionar Contato</button>
            </div>
                            
        </div>

      </div>
    
     
    </div>
  </div> 
  
  <!-- Fim Modal Adicionar Contato-->
  
   <!-- Modal Alteração Telefone Contato -->
  <!-- 31/05/2019 -->
  <div class="modal fade" id="myModalAlterarTelefone" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Alteração de Telefone do Contato:</h4>
        </div>
        <div class="modal-body">
       		 
			 <p>
             <label for="txtTelefoneAnterior"> Telefone: </i> </label>			 
             <input type="text" id="txtTelefoneAnterior" disabled   value="" style="margin-left:25px; padding: 5px 10px; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
             </p>
             <br>
			 <p>
             <label for="txtNovoTelefone"> Novo Tel: </i> </label>	 			 
			 <input type="text" id="txtNovoTelefone"  maxlength="13"  required value="" style="margin-left:25px; padding: 5px 10px; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" placeholder="Exemplo: 55DDDTelefone">
			 </p>
			 <br>
			 <!--Tem que ser &nbsp para não esconder a linha <!--font-weight:bold --> 
			 <span id="spanAlteraTelefone" style="color:red;">&nbsp</span>
			 
            <div class="modal-footer">                
                <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Fechar</button>
                <button type="submit" id="btnAlteraTelefone" name="btnAlteraTelefone" class="btn btn-primary btn-clean" >Alterar Telefone</button>
            </div>
                            
        </div>

      </div>
    
     
    </div>
  </div> 
  <!-- Fim Modal  Alteração Telefone Contato -->
  
  
  <!-- Modal Exclusão de  Contato  -->
  <!-- 24/06/2019 -->	

  <div class="modal fade" id="myModalExcluirContato" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Exclusão de Contato:</h4>
        </div>
        <div class="modal-body">
       		 
			 <p>
             <label for="txtTelefoneExcluir"> Telefone: </i> </label>			 
             <input type="text" id="txtTelefoneExcluir" disabled   value="" style="margin-left:25px; padding: 5px 10px; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
             </p>
             <br>
			 <p>
             <label for="txtNomeExcluir"> Nome: </i> </label>	 			 
			 <input type="text" id="txtNomeExcluir"  maxlength="40"  disabled value="" style="margin-left:40px; padding: 5px 40px; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
			 </p>
			 <br>
			 <!--Tem que ser &nbsp para não esconder a linha <!--font-weight:bold --> 
			 <span id="spanExcluirContato" style="color:red;">&nbsp</span>
			 
            <div class="modal-footer">                
                <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Fechar</button>
                <button type="submit" id="btnConfirmaExclusao" name="btnConfirmaExclusao" class="btn btn-danger btn-clean" >Excluir Contato</button>
            </div>
                            
        </div>

      </div>
    
     
    </div>
  </div> 
  
  <!-- Fim Modal Exclusão de Contato-->
  
  <!-- Modal Aguarde -->
  <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="myModalWait">
	  <div class="modal-dialog modal-sm">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" ><span aria-hidden="true"></span></button>
			<h4 class="modal-title"></h4>
		  </div>
			<div class="modal-body">
			  <p>Por favor, aguarde ...</p>
			</div>
		  <div class="modal-footer">
		  </div>
		</div>
	  </div>
  </div>

  <!-- Fim Modal Aguarde -->
 

  <!-- Modal Transferir Todos Contatos--> 

  <div class="modal fade" id="myModalTransfereTContatos" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Transferir todos contatos:</h4>
        </div>
        <div class="modal-body">
                    <label for="cmbUsuarios"> Selecione um atendente/departamento: </label>
                    <br><br>					
                    <select id="cmbUsuarios" name="cmbUsuarios" class="form-control" > 
	
                        <option value=""></option> 
 
                    </select>
            
			<br>
			
			<span id="spanTransferirTContatos" style="color:red;">&nbsp</span>
			
            <div class="modal-footer">                
                <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Fechar</button>
				
                <button type="submit" id="btnTransfereTodosContatos" name="btnTransfereTodosContatos" class="btn btn-success btn-clean" >Transferir Todos Contatos</button>
            </div>
                            
        </div>

      </div>
    
     
    </div>
  </div> 
  
  <!-- Fim Modal Transferir Todos Contatos-->    
    
<!--    Modal bloco de notas-->
    <div class="modal fade" id="notepadModal" aria-hidden="true" aria-labelledby="notepadLabel" tabindex="-1" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <textarea name="summernote" id="summernote"></textarea>
                </div>

            </div>


        </div>
    </div>
<!--    Fim modal bloco de notas-->
</div>

  
<!-- </div> -->
		 
<script>

$(".messages").animate({ scrollTop: $(document).height() }, "fast");
  
</script>

<script src='js/moment.js'></script>
<script src='js/ws-chat.js?version=1.0.0'></script>
<script src='js/main_chat.js?version=1.0.1'></script>

<!--
<script src='js/main_chat_min.js'></script> -->
	
</body>

</html>