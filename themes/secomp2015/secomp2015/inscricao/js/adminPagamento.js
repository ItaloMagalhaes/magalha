$(document).on("click", ".efetuarPagamento", function(){ 
	
	var id = $(this).attr("id");
	bootbox.confirm("Deseja realmente setar esse pagamento?", function(result) {
		var confirma = result;
		if (confirma == true) {
			var pagina = "sistema.php?acao=adminPagamento/efetuarPagamento&id="+id;
			$.post(pagina, {} ,function(data){
				carregarPaginaCentral("sistema.php?acao=adminPagamento/listarParticipantes");
			});
		}
	});
});

$(document).on("click", ".removerPagamento", function(){ 
	
	var id = $(this).attr("id");
	bootbox.confirm("Deseja realmente remover esse pagamento?", function(result) {
		var confirma = result;
		if(confirma == true){
			var pagina = "sistema.php?acao=adminPagamento/removerPagamento&id="+id;
			$.post(pagina, {} ,function(data) {
				carregarPaginaCentral("sistema.php?acao=adminPagamento/listarParticipantes");
				var dado = $.parseJSON(data);
				if (dado.tipo == 1) {
					sucesso(dado.mensagem,' Sucesso');
					carregarPaginaCentral("sistema.php?acao=site/home");				
				} else {
					erro(dado.mensagem, " Erro");
				}
			});
		}
	});
});

$(document).on("click", ".verMaisPagamento", function(){	
	var id = $(this).attr("id");
	lightbox("sistema.php?acao=adminPagamento/verMaisPagamento&id="+id);
});


$(document).on("keyup", ".buscarPagamentoPendente", function(){ 

	var cpf = $("#cpf0").val();
	var congressista = $("#congressista0").val();
	var limite = $("#limite0").val();
	var pagina = "sistema.php?acao=adminPagamento/listarParticipantesPendentesFiltro&cpf="+cpf+"&congressista="+congressista+"&limite="+limite;	
	carregarDivAjax("listagem0",pagina);
	
});

$(document).on("change", ".buscarPagamentoPendente", function(){ 
	
	var cpf = $("#cpf0").val();
	var congressista = $("#congressista0").val();
	var limite = $("#limite0").val();
	var pagina = "sistema.php?acao=adminPagamento/listarParticipantesPendentesFiltro&cpf="+cpf+"&congressista="+congressista+"&limite="+limite;	
	carregarDivAjax("listagem0",pagina);
	
});

$(document).on("keyup", ".buscarPagamentoConfirmado", function(){ 

	var cpf = $("#cpf1").val();
	var congressista = $("#congressista1").val();
	var limite = $("#limite1").val();
	var pagina = "sistema.php?acao=adminPagamento/listarParticipantesPagosFiltro&cpf="+cpf+"&congressista="+congressista+"&limite="+limite;	
	carregarDivAjax("listagem1",pagina);
	
});

$(document).on("change", ".buscarPagamentoConfirmado", function(){ 
	
	var cpf = $("#cpf1").val();
	var congressista = $("#congressista1").val();
	var limite = $("#limite1").val();
	var pagina = "sistema.php?acao=adminPagamento/listarParticipantesPagosFiltro&cpf="+cpf+"&congressista="+congressista+"&limite="+limite;	
	carregarDivAjax("listagem1",pagina);
	
});