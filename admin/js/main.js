

function StartApp() {
	
	QRCode();
	
}


$(document).ready(function(){
   
	setInterval(QRCode, 5000); //10000 MS == 10 segundos

	});

function QRCode () {
	
	$.ajax({
		type : 'POST',
		url  : 'qrcode.php',
		data : '' ,
		dataType: 'json',
		async: false,                     // Para aguardar
		success :  function(response){
			
			if(response.success == '1'){
				
               // ACHOU QRCODE
			  
			   var img = response.imagem;
			   
			   if (img.length != 0) {
				  // EXISTE QRCODE  
			      $("#qrcode").attr("src",img);
			   }
			   else {
			      // QRCODE VAZIO
			      $("#qrcode").attr("src","vazio.png");
			   }
			}
			else
				
			{
			  // NÃO ENCONTROU QRCODE 

			  $("#qrcode").attr("src","vazio.png");
			  }
				
        }
		
		
	})
	
}

