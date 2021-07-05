window.onscroll = function(){
	scroll();
}

/* Função exibir botão quando usar o scroll */
function scroll(){
	var btn = document.getElementById("btnTop");
	if(document.documentElement.scrollTop > 200){
		btn.style.display = "block";
	} else {
		btn.style.display = "none";
	}
}

/* Função ir para o topo */
$(document).ready(function() {
	$('#btnTop').click(function(){
		$('html, body').animate({scrollTop:0}, 2000);
		return false;
	});
});