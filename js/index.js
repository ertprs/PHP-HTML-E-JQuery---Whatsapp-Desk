$(document).ready(function() {

        $('#entrar').click(function() {

           $(this).prop("disabled",true);
		   
		   var email = $("#email").val();
		   var senha = $("#senha").val();		   

		   email = email.trim();
		   senha = senha.trim();
		   
	       if ($.trim(email) != '' && $.trim(senha) != '' ) {
		 
              var data = $("#formLogin").serialize();
			  // alert(data);
				$.ajax({
					type : 'POST',
					url  : 'login.php',
					data : data,
					// data : {email:email,senha:senha,controle:'345067821133'},
					dataType: 'json',
					async: false,
					success :  function(response){	
					
						if(response.success == 1){							
						  $(location).attr('href', 'chat.php');
						}
						else{
							
							switch(response.success) {
								  case 0:
								        // Quando não há salto de linha  utilizar .text
										$("#myAlert .modal-body").text('Usuário e/ou senha incorretos');
										$('#myAlert').modal('show');
									    break;
								  case 2:
								        // Quando não há salto de linha  utilizar .text
										$("#myAlert .modal-body").text('Usuário já logado no sistema');
										$('#myAlert').modal('show');
										break;
								  case 3:
								        // Quando há salto de linha utilizar .html
										$("#myAlert .modal-body").html('API não registrada.<br>Por favor contate o suporte');    
										$('#myAlert').modal('show');
										break;
								  case 4:
								        // Quando há salto de linha utilizar .html
										$("#myAlert .modal-body").html('O token da api está em branco.<br>Por favor contate o suporte');
										$('#myAlert').modal('show');
										break;
								  case 5:
								        // Quando há salto de linha utilizar .html
										$("#myAlert .modal-body").html('O email da api está em branco.<br>Por favor contate o suporte');
										$('#myAlert').modal('show');
										break;
								  case 6:
								        // Quando há salto de linha utilizar .html
										$("#myAlert .modal-body").html('O idapp da api está em branco.<br>Por favor contate o suporte');
										$('#myAlert').modal('show');
										break;
								  case 7:
								        // Quando há salto de linha utilizar .html
										$("#myAlert .modal-body").html('O campo checkphone da api está em branco.<br>Por favor contate o suporte');
										$('#myAlert').modal('show');
										break;
								  case 8:
								        // Quando há salto de linha utilizar .html
										$("#myAlert .modal-body").html('O campo timezone_gmt da api está em branco.<br>Por favor contate o suporte');
										$('#myAlert').modal('show');
										break;											
								  default:
									// code block
								}

				            $("#email").focus();
						}
					}
				})
				
           }
		   else {
			   
			   $("#email").focus();

			   $("#myAlert .modal-body").text('O email e a senha devem ser informados');
			   $('#myAlert').modal('show');
		
		   }
		
           $(this).prop("disabled",false);
		   
        });

       //********************************************************************
	   $('#email').keypress(function(e){
        if(e.which == 13){       // Se pressionar a tecla ENTER no campo email
            $('#senha').focus();// vai para o campo senha
        }
        });
	  //*********************************************************************
	  
       //********************************************************************
	   $('#senha').keypress(function(e){
        if(e.which == 13){       // Se pressionar a tecla ENTER no campo senha
            $('#entrar').click();// Aciona o botão de entrar 	
        }
        });
	  //*********************************************************************

	  
})
