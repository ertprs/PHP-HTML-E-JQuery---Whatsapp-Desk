function TheMenuExcluir() {

  document.getElementById("myDropdownExcluir").classList.toggle("show");
}


//Fecha o dropdown (Menu) se o usuário clicar fora dele
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn-excluir')) {
    var dropdowns = document.getElementsByClassName("dropdown-excluir-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

/*
$(document).ready(function(){
	$(".dropdown-excluir-content a").click(function(){
	// var selText = $(this).text();        // Texto
	var selText = $(this).attr('href');     // Atributo de href
	alert(selText);
	alert('Fazer rotina de ' + selText);
	});
});
*/