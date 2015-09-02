$(document).ready(function(){
	$(document).on("click","#recuperar",function(e){
		e.preventDefault();
		var url = $('#formRecuparaSenha').attr('action');
		var parametros = {cpf: $('#cpf').val(), acao: 'recuperar'};
		$.post(url,parametros,function(data){
				sucesso('Para redifinir a sua senha, acesse seu e-mail e clique em "Recuperar Senha".','',' E-mail enviado com sucesso');
				document.getElementById('cpf').value="";
		});
			carregarPaginaCentral("sistema.php?acao=home/telaInicial");

	});

});

