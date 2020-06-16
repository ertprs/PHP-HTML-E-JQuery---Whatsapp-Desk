jQuery(document).ready(function() {

	/* geracao do qrcode */
	parar= "false";
	$('#conn').on('click',function(e) {
		e.stopPropagation();
		var $this= $(this);
		var auth= $('#auth').val();
		$this.attr('disabled','disabled');
		$('.msg_popup').text('Processando...Aguarde...');
		$('.fundo_en').fadeIn(600);
		$.ajax({
			type: 'POST',
			url: 'processa_qrcode.php',
			cache: false,
			dataType: 'json',
			data: {
			}
		}).done(function(rtk) {
			if (rtk.sucesso=="sim") {
				$('#lkauth').val(''+rtk.auth+'');
				$('.msg_popup').html('<font color="green"> Sucesso... </font>');
				$('.fundo_en').fadeOut(600);
				var sett= setInterval(function() {
				var token= $('#token').val();
				$.ajax({
					type: 'POST',
					url: 'busca_qrcode.php',
					cache: false,
					dataType: 'json',
					data: {
						
					}
				}).done(function(rdt) {
					$this.removeAttr('disabled','disabled');
					if (rdt.sucesso=="sim") {
						if (rdt.qrcode != "") {
							parar="true";
							$('#timer').fadeOut(800);
							$('.tkz').attr('src',''+rdt.qrcode+'');
							$('.rdz').css({'width':'200px','height':'200px','margin':'0px'});
						} else {
							if (rdt.conectado=="nao") {
								$('.rdz').css({'width':'120px','height':'120px','margin':'40px 40px 40px 40px'});
								$('.tkz').attr('src','qrcode/carregando.gif');
							}
							
							if (rdt.conectado=="sim") {
								clearInterval(sett);
								$('.rdz').css({'width':'50px','height':'50px','margin':'75px'});
								$('.tkz').attr('src','qrcode/aprovado.png');
								
								$('.rdz').animate({
									width:'150px',
									height:'150px',
									marginLeft:'25px',
									marginTop:'25px',
									marginRight:'25px',
									marginBottom:'25px'
								},1000 ,"linear",function() {
									$('#conn').text('Desconectar');
									$('.pttd').fadeOut(1000 , function() {
										$('.rdz').css({'width':'120px','height':'120px','margin':'40px 40px 40px 40px'});
										$('.tkz').attr('src','qrcode/carregando.gif');
										$('#ap1').html('');
										$('#ap1').prepend(''+rdt.htmladd+'');
										$('#ap1 , #ap2').fadeIn(1000);
									});
								});
							}
						}
					} else {
						$('.rdz').css({'width':'120px','height':'120px','margin':'40px 40px 40px 40px'});
						$('.tkz').attr('src','qrcode/carregando.gif');
					}
				});
			},5000);
	
	
				$('#ap1 , #ap2').fadeOut(1000,function() {
					$('.pttd').fadeIn(1000);
				});
				
				
				startCountdown();
			}
			
			if (rtk.sucesso=="nao") {
				$('.msg_popup').html('<font color="green"> Houve um erro ao gerar o QRcode entre em contato com nosso suporte </font>');
				$('.fundo_en').fadeIn(1200);
			}
		});
	});
	
	/* fim da geracao do qrcode */
	
});

/*geracao do qrcode */

tempo = 30;	
function startCountdown(){
	if (parar=="false") {
	// Se o tempo não for zerado
	if((tempo - 1) >= 0){

		// Pega a parte inteira dos minutos
		var min = parseInt(tempo/60);
		// Calcula os segundos restantes
		var seg = tempo%60;

		// Formata o número menor que dez, ex: 08, 07, ...
		if(min < 10){
			min = "0"+min;
			min = min.substr(0, 2);
		}
		if(seg <=9){
			seg = "0"+seg;
		}

		// Cria a variável para formatar no estilo hora/cronômetro
		horaImprimivel = min + ':' + seg;
		//JQuery pra setar o valor
		$("#timer").html(horaImprimivel);

		// Define que a função será executada novamente em 1000ms = 1 segundo
		setTimeout('startCountdown()',1000);

		// diminui o tempo
		tempo--;

	// Quando o contador chegar a zero faz esta ação
	} else {
		var lka= $('#lkauth').val();
		//window.location.href= ""+lka+"";
		window.location.href= "sistema.php";
	}
	} else {
	}
}

/* geracao do qrcode */