/* Logout */
$(document).on("click", ".sair", function(){
	var pagina = "sistema.php?acao=login/sair";
	$.post(pagina,{},function(){
		window.location = "sistema.php?acao=site/telaInicial";		
	});
});