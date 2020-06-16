<?php

	//session_start();

	
	
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>Montagem Bot Multi-Atendimento</title>
	<meta charset="UTF-8">
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body onload="StartApp ();">

	<div class="container" id="divMain" style="width:100%; margin-left:0px;">
 
        
		<form id="frmMain" name="frmMain" role="form" method="post" action="" > 
		
			<div class="alert alert-dark" role="alert" style="width:100%">
				  <input type="checkbox" name="chkImagem" id="chkImagem" value="0">
				  <label for="chkImagem" id="lblImagem">Acrescentar imagem ao cabeçalho</label>
				<br>
				<div class="input-group">	  
				  <div class="input-group-prepend">
					<textarea class="form-control"  name="txtCabecalho" id="txtCabecalho" style="resize: none" onkeyup="limitTextarea(this,6,300)" rows="6" cols="60" placeholder="Digite nessa Caixa de Texto o cabeçalho do Menu Inicial"></textarea>
					<button type="button"  id="btnExemplo">Mostrar Exemplo Cabeçalho</button>
					<button type="button" id="btnLimparCabecalho">Limpar Cabeçalho </button>
					<button type="button" id="btnRecarregarBot" disabled="disabled">Recarregar Chat Bot </button>
					<button type="button"id="btnSalvarChatBot">Salvar Chat Bot </button>
				   </div>
				</div>
			</div>
			
		
			<div class="ItemInicial" role="alert" style="width:100%;">
				<div class="input-group">	  
				  <div class="input-group-prepend">
			 <textarea class="form-control"  name="txtItem1Inicial" id="txtItem1Inicial" style="resize: none"  rows="2" cols="52" placeholder="Campo do Ítem 1 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisItem1Inicial" title="Acrescenta resposta a esse ítem">+</button>
			 <textarea class="form-control"  name="txtRespostaItem1Inicial" id="txtRespostaItem1Inicial" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao Ítem 1 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisRespostaItem1Inicial" style="display:none" title="Acrescenta ítem ao ítem 1 da Resposta">+</button>
			 <textarea class="form-control"  name="txtRespostaItem1Nivel2" id="txtRespostaItem1Nivel2" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao ítem anterior"></textarea>
			  </div>
			  </div>
			</div>

			<div class="ItemInicial" role="alert" style="width:100%">
				<div class="input-group">	  
				  <div class="input-group-prepend">
			 <textarea class="form-control"  name="txtItem2Inicial" id="txtItem2Inicial" style="resize: none"  rows="2" cols="52" placeholder="Campo do Ítem 2 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisItem2Inicial" title="Acrescenta resposta a esse ítem">+</button>
			 <textarea class="form-control"  name="txtRespostaItem2Inicial" id="txtRespostaItem2Inicial" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao Ítem 2 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisRespostaItem2Inicial" style="display:none" title="Acrescenta ítem ao ítem 2 da Resposta">+</button>
			 <textarea class="form-control"  name="txtRespostaItem2Nivel2" id="txtRespostaItem2Nivel2" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao ítem anterior"></textarea>
			 
			   </div>
			  </div>
			</div>

			<div class="ItemInicial" role="alert" style="width:100%">
				<div class="input-group">	  
				  <div class="input-group-prepend">
			 <textarea class="form-control"  name="txtItem3Inicial" id="txtItem3Inicial" style="resize: none"  rows="2" cols="52" placeholder="Campo do Ítem 3 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisItem3Inicial"  title="Acrescenta resposta a esse ítem">+</button>
			 <textarea class="form-control"  name="txtRespostaItem3Inicial" id="txtRespostaItem3Inicial" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao Ítem 3 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisRespostaItem3Inicial" style="display:none" title="Acrescenta ítem ao ítem 3 da Resposta">+</button>
			 <textarea class="form-control"  name="txtRespostaItem3Nivel2" id="txtRespostaItem3Nivel2" id="txtRespostaItem3Nivel2" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao ítem anterior"></textarea>
			   </div>
			  </div>
			</div>

			<div class="ItemInicial" role="alert" style="width:100%">
				<div class="input-group">	  
				  <div class="input-group-prepend">
			 <textarea class="form-control"  name="txtItem4Inicial" id="txtItem4Inicial" style="resize: none"  rows="2" cols="52" placeholder="Campo do Ítem 4 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisItem4Inicial"  title="Acrescenta resposta a esse ítem">+</button>
			 <textarea class="form-control"  name="txtRespostaItem4Inicial" id="txtRespostaItem4Inicial" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao Ítem 4 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisRespostaItem4Inicial" style="display:none" title="Acrescenta ítem ao ítem 4 da Resposta">+</button>
			 <textarea class="form-control"  name="txtRespostaItem4Nivel2" id="txtRespostaItem4Nivel2" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao ítem anterior"></textarea>
			   </div>
			  </div>
			</div>

			<div class="ItemInicial" role="alert" style="width:100%">
				<div class="input-group">	  
				  <div class="input-group-prepend">
			 <textarea class="form-control"  name="txtItem5Inicial"id="txtItem5Inicial" style="resize: none"  rows="2" cols="52" placeholder="Campo do Ítem 5 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisItem5Inicial"  title="Acrescenta resposta a esse ítem">+</button>
			 <textarea class="form-control"  name="txtRespostaItem5Inicial" id="txtRespostaItem5Inicial" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao Ítem 5 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisRespostaItem5Inicial" style="display:none" title="Acrescenta ítem ao ítem 5 da Resposta">+</button>
			 <textarea class="form-control"  name="txtRespostaItem5Nivel2" id="txtRespostaItem5Nivel2" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao ítem anterior"></textarea>
			   </div>
			  </div>
			</div>

			<div class="ItemInicial" role="alert" style="width:100%">
				<div class="input-group">	  
				  <div class="input-group-prepend">
			 <textarea class="form-control"  name="txtItem6Inicial"id="txtItem6Inicial" style="resize: none"  rows="2" cols="52" placeholder="Campo do Ítem 6 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisItem6Inicial"  title="Acrescenta resposta a esse ítem">+</button>
			 <textarea class="form-control"  name="txtRespostaItem6Inicial" id="txtRespostaItem6Inicial" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao Ítem 6 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisRespostaItem6Inicial" style="display:none" title="Acrescenta ítem ao ítem 6 da Resposta">+</button>
			 <textarea class="form-control"  name="txtRespostaItem6Nivel2" id="txtRespostaItem6Nivel2" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao ítem anterior"></textarea>
			   </div>
			  </div>
			</div>

			<div class="ItemInicial" role="alert" style="width:100%">
				<div class="input-group">	  
				  <div class="input-group-prepend">
			 <textarea class="form-control"  name="txtItem7Inicial" id="txtItem7Inicial" style="resize: none"  rows="2" cols="52" placeholder="Campo do Ítem 7 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisItem7Inicial"  title="Acrescenta resposta a esse ítem">+</button>
			 <textarea class="form-control"  name="txtRespostaItem7Inicial" id="txtRespostaItem7Inicial" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao Ítem 7 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisRespostaItem7Inicial" style="display:none" title="Acrescenta ítem ao ítem 7 da Resposta">+</button>
			 <textarea class="form-control"  name="txtRespostaItem7Nivel2" id="txtRespostaItem7Nivel2" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao ítem anterior"></textarea>
			   </div>
			  </div>
			</div>

			<div class="ItemInicial" role="alert" style="width:100%">
				<div class="input-group">	  
				  <div class="input-group-prepend">
			 <textarea class="form-control"  name="txtItem8Inicial" id="txtItem8Inicial" style="resize: none"  rows="2" cols="52" placeholder="Campo do Ítem 8 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisItem8Inicial"  title="Acrescenta resposta a esse ítem">+</button>
			 <textarea class="form-control"  name="txtRespostaItem8Inicial" id="txtRespostaItem8Inicial" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao Ítem 8 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisRespostaItem8Inicial" style="display:none" title="Acrescenta ítem ao ítem 8 da Resposta">+</button>
			 <textarea class="form-control"  name="txtRespostaItem8Nivel2" id="txtRespostaItem8Nivel2" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao ítem anterior"></textarea>
			   </div>
			  </div>
			</div>
			<div class="ItemInicial" role="alert" style="width:100%">
				<div class="input-group">	  
				  <div class="input-group-prepend">
			 <textarea class="form-control"  name="txtItem9Inicial"id="txtItem9Inicial" style="resize: none"  rows="2" cols="52" placeholder="Campo do Ítem 9 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisItem9Inicial"  title="Acrescenta resposta a esse ítem">+</button>
			 <textarea class="form-control"  name="txtRespostaItem9Inicial" id="txtRespostaItem9Inicial" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao Ítem 9 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisRespostaItem9Inicial" style="display:none" title="Acrescenta ítem ao ítem 9 da Resposta">+</button>
			 <textarea class="form-control"  name="txtRespostaItem9Nivel2" id="txtRespostaItem9Nivel2" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao ítem anterior"></textarea>
			   </div>
			  </div>
			</div>

			<div class="ItemInicial" role="alert" style="width:100%">
				<div class="input-group">	  
				  <div class="input-group-prepend">
			 <textarea class="form-control"  name="txtItem10Inicial"id="txtItem10Inicial" style="resize: none"  rows="2" cols="52" placeholder="Campo do Ítem 10 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisItem10Inicial"  title="Acrescenta resposta a esse ítem">+</button>
			 <textarea class="form-control"  name="txtRespostaItem10Inicial" id="txtRespostaItem10Inicial" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao Ítem 10 do Menu Inicial"></textarea>
			 <button type="button" class="btn btn-secondary" id="btnMaisRespostaItem10Inicial" style="display:none" title="Acrescenta ítem ao ítem 10 da Resposta">+</button>
			 <textarea class="form-control"  name="txtRespostaItem10Nivel2" id="txtRespostaItem10Nivel2" style="resize: none;display:none"  rows="2" cols="52" placeholder="Campo da Resposta ao ítem anterior"></textarea>
			   </div>
			  </div>
			</div>

	      </form> 
	</div>
	  
    <!-- Modal Alert -->
    <div class="modal" id="myAlert">
		<div class="modal-dialog">
		  <div class="modal-content">
		  
			<!-- Modal Header -->
			<div class="modal-header">
			  <h4 class="modal-title">Atenção</h4>
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Corpo do Modal  -->
			<div class="modal-body">
			  Corpo do Modal 
			</div>
			
			<!-- Rodapé do Modal -->
			<div class="modal-footer">
			  <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
			</div>
			
		  </div>
		</div>
    </div>
    <!-- Fim Modal Alert -->	
 

	  
</body>

</html>
