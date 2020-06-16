

function StartApp() {
//Função inicial de carregamento dos registros gravados
	
	Carregar_Registros();
	
}

$(document).ready(function(){
	
	$("#btnExemplo").on('click',function(){
		$("#txtCabecalho").val("Olá,\nMeu nome é Ben\nSou o bot da WhatsCompany\nComo posso lhe ajudar ?");
	})
	
	$("#btnLimparCabecalho").on('click',function(){
		$("#txtCabecalho").val("");
	})
	
	$("#btnRecarregarBot").on('click',function(){
		Carregar_Registros();
	})
	
	
	
	// INÍCIO DO CLICK NOS BOTÕES DE + OU - NÍVEL 1
	$("#btnMaisItem1Inicial").on('click',function(){
	
		
		if ($('#btnMaisItem1Inicial').text()=='+' ){
			$("#btnMaisItem1Inicial").text("-");
			
		}
		else {
			$("#btnMaisItem1Inicial").text("+");
			// FECHA RESPOSTA DO NÍVEL 2
			$("#btnMaisRespostaItem1Inicial").text("+");
			$("#txtRespostaItem1Nivel2").hide();
			// *************************
		}
		
		$("#txtRespostaItem1Inicial").toggle();
		$("#btnMaisRespostaItem1Inicial").toggle();
		
		
		
	})


	$("#btnMaisItem2Inicial").on('click',function(){
	
		
		if ($('#btnMaisItem2Inicial').text()=='+' ){
			$("#btnMaisItem2Inicial").text("-");
		}
		else {
			$("#btnMaisItem2Inicial").text("+");
			// FECHA RESPOSTA DO NÍVEL 2
			$("#btnMaisRespostaItem2Inicial").text("+");
			$("#txtRespostaItem2Nivel2").hide();
			// *************************
			
		}
		
		$("#txtRespostaItem2Inicial").toggle();
		$("#btnMaisRespostaItem2Inicial").toggle();
	})
	

	$("#btnMaisItem3Inicial").on('click',function(){
	
		
		if ($('#btnMaisItem3Inicial').text()=='+' ){
			$("#btnMaisItem3Inicial").text("-");
		}
		else {
			$("#btnMaisItem3Inicial").text("+");
			// FECHA RESPOSTA DO NÍVEL 2
			$("#btnMaisRespostaItem3Inicial").text("+");
			$("#txtRespostaItem3Nivel2").hide();
            // *************************			
		}
		
		$("#txtRespostaItem3Inicial").toggle();
		$("#btnMaisRespostaItem3Inicial").toggle();
	})
	
	$("#btnMaisItem4Inicial").on('click',function(){
	
		
		if ($('#btnMaisItem4Inicial').text()=='+' ){
			$("#btnMaisItem4Inicial").text("-");
		}
		else {
			$("#btnMaisItem4Inicial").text("+");
			// FECHA RESPOSTA DO NÍVEL 2
			$("#btnMaisRespostaItem4Inicial").text("+");
			$("#txtRespostaItem4Nivel2").hide();
            // *************************			
		}
		
		$("#txtRespostaItem4Inicial").toggle();
		$("#btnMaisRespostaItem4Inicial").toggle();
	})
	
	
	$("#btnMaisItem5Inicial").on('click',function(){
	
		
		if ($('#btnMaisItem5Inicial').text()=='+' ){
			$("#btnMaisItem5Inicial").text("-");
		}
		else {
			$("#btnMaisItem5Inicial").text("+");
			// FECHA RESPOSTA DO NÍVEL 2
			$("#btnMaisRespostaItem5Inicial").text("+");
			$("#txtRespostaItem5Nivel2").hide();
            // *************************            
		}
		
		$("#txtRespostaItem5Inicial").toggle();
		$("#btnMaisRespostaItem5Inicial").toggle();
	})
	
	$("#btnMaisItem6Inicial").on('click',function(){
	
		
		if ($('#btnMaisItem6Inicial').text()=='+' ){
			$("#btnMaisItem6Inicial").text("-");
		}
		else {
			$("#btnMaisItem6Inicial").text("+");
			// FECHA RESPOSTA DO NÍVEL 2
			$("#btnMaisRespostaItem6Inicial").text("+");
			$("#txtRespostaItem6Nivel2").hide();
            // *************************			
		}
		
		$("#txtRespostaItem6Inicial").toggle();
		$("#btnMaisRespostaItem6Inicial").toggle();
	})
	
	$("#btnMaisItem7Inicial").on('click',function(){
	
		
		if ($('#btnMaisItem7Inicial').text()=='+' ){
			$("#btnMaisItem7Inicial").text("-");
		}
		else {
			$("#btnMaisItem7Inicial").text("+");
			// FECHA RESPOSTA DO NÍVEL 2
			$("#btnMaisRespostaItem7Inicial").text("+");
			$("#txtRespostaItem7Nivel2").hide();
            // *************************            
		}
		
		$("#txtRespostaItem7Inicial").toggle();
		$("#btnMaisRespostaItem7Inicial").toggle();
	})
	
	$("#btnMaisItem8Inicial").on('click',function(){
	
		
		if ($('#btnMaisItem8Inicial').text()=='+' ){
			$("#btnMaisItem8Inicial").text("-");
		}
		else {
			$("#btnMaisItem8Inicial").text("+");
			// FECHA RESPOSTA DO NÍVEL 2
			$("#btnMaisRespostaItem8Inicial").text("+");
			$("#txtRespostaItem8Nivel2").hide();
            // *************************			
		}
		
		$("#txtRespostaItem8Inicial").toggle();
		$("#btnMaisRespostaItem8Inicial").toggle();
	})
	
	
	$("#btnMaisItem9Inicial").on('click',function(){
	
		
		if ($('#btnMaisItem9Inicial').text()=='+' ){
			$("#btnMaisItem9Inicial").text("-");
		}
		else {
			$("#btnMaisItem9Inicial").text("+");
			// FECHA RESPOSTA DO NÍVEL 2
			$("#btnMaisRespostaItem9Inicial").text("+");
			$("#txtRespostaItem9Nivel2").hide();
            // *************************			
		}
		
		$("#txtRespostaItem9Inicial").toggle();
		$("#btnMaisRespostaItem9Inicial").toggle();
	})
	
	$("#btnMaisItem10Inicial").on('click',function(){
	
		
		if ($('#btnMaisItem10Inicial').text()=='+' ){
			$("#btnMaisItem10Inicial").text("-");
		}
		else {
			$("#btnMaisItem10Inicial").text("+");
			// FECHA RESPOSTA DO NÍVEL 2
			$("#btnMaisRespostaItem10Inicial").text("+");
			$("#txtRespostaItem10Nivel2").hide();
            // *************************			
		}
		
		$("#txtRespostaItem10Inicial").toggle();
		$("#btnMaisRespostaItem10Inicial").toggle();
	})
	
	// FIM DO CLICK NOS BOTÕES DE + OU - NÍVEL 1
	// **********************************************
	
	// INÍCIO DO CLICK NOS BOTÕES DO NÍVEL 2
	$("#btnMaisRespostaItem1Inicial").on('click',function(){

		if ($('#btnMaisRespostaItem1Inicial').text()=='+' ){
			$("#btnMaisRespostaItem1Inicial").text("-");
		}
		else {
			$("#btnMaisRespostaItem1Inicial").text("+");
		}
		$("#txtRespostaItem1Nivel2").toggle();
	})
	
	$("#btnMaisRespostaItem2Inicial").on('click',function(){

		if ($('#btnMaisRespostaItem2Inicial').text()=='+' ){
			$("#btnMaisRespostaItem2Inicial").text("-");
		}
		else {
			$("#btnMaisRespostaItem2Inicial").text("+");
		}
		$("#txtRespostaItem2Nivel2").toggle();
	})
	
	$("#btnMaisRespostaItem3Inicial").on('click',function(){

		if ($('#btnMaisRespostaItem3Inicial').text()=='+' ){
			$("#btnMaisRespostaItem3Inicial").text("-");
		}
		else {
			$("#btnMaisRespostaItem3Inicial").text("+");
		}
		$("#txtRespostaItem3Nivel2").toggle();
	})
	
	$("#btnMaisRespostaItem4Inicial").on('click',function(){

		if ($('#btnMaisRespostaItem4Inicial').text()=='+' ){
			$("#btnMaisRespostaItem4Inicial").text("-");
		}
		else {
			$("#btnMaisRespostaItem4Inicial").text("+");
		}
		$("#txtRespostaItem4Nivel2").toggle();
	})
	
	$("#btnMaisRespostaItem5Inicial").on('click',function(){

		if ($('#btnMaisRespostaItem5Inicial').text()=='+' ){
			$("#btnMaisRespostaItem5Inicial").text("-");
		}
		else {
			$("#btnMaisRespostaItem5Inicial").text("+");
		}
		$("#txtRespostaItem5Nivel2").toggle();
	})
	
	$("#btnMaisRespostaItem6Inicial").on('click',function(){

		if ($('#btnMaisRespostaItem6Inicial').text()=='+' ){
			$("#btnMaisRespostaItem6Inicial").text("-");
		}
		else {
			$("#btnMaisRespostaItem6Inicial").text("+");
		}
		$("#txtRespostaItem6Nivel2").toggle();
	})
	
	$("#btnMaisRespostaItem7Inicial").on('click',function(){

		if ($('#btnMaisRespostaItem7Inicial').text()=='+' ){
			$("#btnMaisRespostaItem7Inicial").text("-");
		}
		else {
			$("#btnMaisRespostaItem7Inicial").text("+");
		}
		$("#txtRespostaItem7Nivel2").toggle();
	})
	
	$("#btnMaisRespostaItem8Inicial").on('click',function(){

		if ($('#btnMaisRespostaItem8Inicial').text()=='+' ){
			$("#btnMaisRespostaItem8Inicial").text("-");
		}
		else {
			$("#btnMaisRespostaItem8Inicial").text("+");
		}
		$("#txtRespostaItem8Nivel2").toggle();
	})
	
	$("#btnMaisRespostaItem9Inicial").on('click',function(){

		if ($('#btnMaisRespostaItem9Inicial').text()=='+' ){
			$("#btnMaisRespostaItem9Inicial").text("-");
		}
		else {
			$("#btnMaisRespostaItem9Inicial").text("+");
		}
		$("#txtRespostaItem9Nivel2").toggle();
	})

	$("#btnMaisRespostaItem10Inicial").on('click',function(){

		if ($('#btnMaisRespostaItem10Inicial').text()=='+' ){
			$("#btnMaisRespostaItem10Inicial").text("-");
		}
		else {
			$("#btnMaisRespostaItem10Inicial").text("+");
		}
		$("#txtRespostaItem10Nivel2").toggle();
	})
	
	// INÍCIO DO CLICK NOS BOTÕES DO NÍVEL 2
	// *****************************************************
	
	// SALVAR CHAT-BOT
	
	
	$("#btnSalvarChatBot").on('click',function(e){
			  
        $(this).prop("disabled",true);		
		if ( Verifica_Inconsistencias () ) {
			Grava_Bot ();
		}
		$(this).prop("disabled",false);		
	})
	
	
})

function limitTextarea(textarea, maxLines, maxChar) {
	
        var lines = textarea.value.replace(/\r/g, '').split('\n'), lines_removed, char_removed, i;
        if (maxLines && lines.length > maxLines) {
            lines = lines.slice(0, maxLines);
            lines_removed = 1
        }
        if (maxChar) {
            i = lines.length;
            while (i-- > 0) if (lines[i].length > maxChar) {
                lines[i] = lines[i].slice(0, maxChar);
                char_removed = 1
            }
            if (char_removed || lines_removed) {
                textarea.value = lines.join('\n')
            }
        }
}

function Verifica_Inconsistencias () {
	
	  if ($("#txtCabecalho").val().trim() == '') {

		  $("#myAlert .modal-body").text('Pelo menos, o cabeçalho deve ser informado.');
		  $('#myAlert').modal('show');
		  
		  return false;
	  }
	  else {
		  return true;
	  }
}

function Grava_Bot () {
	
	
	if($('#chkImagem').prop('checked') == true){
	   $('#chkImagem').val('1');
	}
	else {
	   $('#chkImagem').val('2');	
	}
	
	
	// Para que se possa serializar um form, em cada campo além do id deve existir o name
	var data = $("#frmMain").serialize();
	// **********************************************************************************
	
	$.ajax({
		type : 'POST',
		url  : 'botconfig.php',
		data : data,
		dataType: 'json',
		async: false,
		success :  function(response){	

		$("#myAlert .modal-body").text(response.situacao);
		$('#myAlert').modal('show');
				
			if(response.success == 1){
                $('#btnRecarregarBot').prop('disabled', false);	
				
			    $("#myAlert .modal-body").text(response.situacao);
	            $('#myAlert').modal('show');
			}
			else{
			    $("#myAlert .modal-body").text(response.situacao);
	            $('#myAlert').modal('show');				
				
				$("#txtCabecalho").focus();
			}

		
		}
	})

	
}

function Carregar_Registros() {
	
		$.ajax({
			type : 'POST',
			url  : 'carregar_registros.php',
			dataType: 'json',
			async: false,               
			success :  function(response){	
			
				if (response) {
							
					$('#btnRecarregarBot').prop('disabled', false);
					
					for(var i=0;response.length>i;i++){
						
						if (response[i].imagem == 1) {
							$('#chkImagem').prop('checked',true );
						}
						
					    $('#txtCabecalho').val(response[i].cabecalho);
						
						if (response[i].emproducao == 1) {
							$('#btnSalvarChatBot').prop('disabled', true);
						}
						// PRIMEIRA COLUNA
						$('#txtItem1Inicial').val(response[i].item1inicial);
						$('#txtItem2Inicial').val(response[i].item2inicial);
						$('#txtItem3Inicial').val(response[i].item3inicial);
						$('#txtItem4Inicial').val(response[i].item4inicial);
						$('#txtItem5Inicial').val(response[i].item5inicial);
						$('#txtItem6Inicial').val(response[i].item6inicial);
						$('#txtItem7Inicial').val(response[i].item7inicial);
						$('#txtItem8Inicial').val(response[i].item8inicial);
						$('#txtItem9Inicial').val(response[i].item9inicial);
						$('#txtItem10Inicial').val(response[i].item10inicial);
						// ***************
						
						// SEGUNDA COLUNA
						$('#txtRespostaItem1Inicial').val(response[i].respostaitem1inicial);
						$('#txtRespostaItem2Inicial').val(response[i].respostaitem2inicial);
						$('#txtRespostaItem3Inicial').val(response[i].respostaitem3inicial);
						$('#txtRespostaItem4Inicial').val(response[i].respostaitem4inicial);
						$('#txtRespostaItem5Inicial').val(response[i].respostaitem5inicial);
						$('#txtRespostaItem6Inicial').val(response[i].respostaitem6inicial);
						$('#txtRespostaItem7Inicial').val(response[i].respostaitem7inicial);
						$('#txtRespostaItem8Inicial').val(response[i].respostaitem8inicial);
						$('#txtRespostaItem9Inicial').val(response[i].respostaitem9inicial);
						$('#txtRespostaItem10Inicial').val(response[i].respostaitem10inicial);
						// ***************

						// TERCEIRA COLUNA
						$('#txtRespostaItem1Nivel2').val(response[i].respostaitem1nivel2);
						$('#txtRespostaItem2Nivel2').val(response[i].respostaitem2nivel2);
						$('#txtRespostaItem3Nivel2').val(response[i].respostaitem3nivel2);
						$('#txtRespostaItem4Nivel2').val(response[i].respostaitem4nivel2);
						$('#txtRespostaItem5Nivel2').val(response[i].respostaitem5nivel2);
						$('#txtRespostaItem6Nivel2').val(response[i].respostaitem6nivel2);
						$('#txtRespostaItem7Nivel2').val(response[i].respostaitem7nivel2);
						$('#txtRespostaItem8Nivel2').val(response[i].respostaitem8nivel2);
						$('#txtRespostaItem9Nivel2').val(response[i].respostaitem9nivel2);
						$('#txtRespostaItem10Nivel2').val(response[i].respostaitem10nivel2);
						// ***************
						
					}					 				 
				}
				else 
				{
					$('#btnRecarregarBot').prop('disabled', true);
					
					$("#myAlert .modal-title").text('Atenção');
					$("#myAlert .modal-body").text('Não foram encontrados registros de configuração do Bot.');
					$('#myAlert').modal('show');
	
				}								
			}
			
		})
		
}
