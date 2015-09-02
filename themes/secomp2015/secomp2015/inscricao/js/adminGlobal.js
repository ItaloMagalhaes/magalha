$('#sub-artigo').click(function(){
		$('.listaArea').removeClass('oculta');
		
	});

$(document).on("click", ".novaArea", function(){ 
	
	var pagina = "sistema.php?acao=adminGlobal/exibirFormularioSubmissao";
	carregarPaginaCentral(pagina);
	
});

$(document).on("click", ".excluirArea", function(){ 
	
	var id = $(this).attr("id");

	bootbox.confirm("Deseja realmente excluir essa área?", function(result) {
		var confirma = result;
		if(confirma == true){

			var pagina = "sistema.php?acao=adminGlobal/excluirArea&id="+id;
		
			$.post(pagina, {} ,function(data){
				carregarPaginaCentral("sistema.php?acao=adminGlobal/salvarArea");
						
			});
		}
	});
});

$(document).on("click", ".novoAdm", function(){ 
	
	var pagina = "sistema.php?acao=adminGlobal/novoAdmPagamento";
	carregarPaginaCentral(pagina);
	
});

$(document).on("keyup", ".buscarAdmPagamento", function(){ 

	var id = $("#id").val();
	var nome = $("#nome").val();
	var cpf = $("#cpf").val();
	var limite = $("#limite").val();
	var pagina = "sistema.php?acao=adminGlobal/listagemAdmPagamentoFiltro&id="+id+"&id="+id+"&nome="+nome+"&cpf="+cpf+"&limite="+limite;	
	carregarDivAjax("listagem",pagina);
});

$(document).on("change", ".atualizarInfo", function(){ 
	var pagina = "sistema.php?acao=adminGlobal/telaIncial.php";	
	carregarDivAjax("graph",pagina);
});

$(document).on("mousemove", ".atualizarInfo", function(){ 
	var pagina = "sistema.php?acao=adminGlobal/telaIncial.php";	
	carregarDivAjax("graph",pagina);
});

$(document).on("change", ".buscarAdmPagamento", function(){ 
	
	var id = $("#id").val();
	var nome = $("#nome").val();
	var cpf = $("#cpf").val();
	var limite = $("#limite").val();
	var pagina = "sistema.php?acao=adminGlobal/listagemAdmPagamentoFiltro&id="+id+"&id="+id+"&nome="+nome+"&cpf="+cpf+"&limite="+limite;	
	carregarDivAjax("listagem",pagina);
});


$(document).on("click", ".editarAdmPagamento", function(){ 
	var id = $(this).attr("id");
	carregarPaginaCentral("sistema.php?acao=adminGlobal/editarAdmPagamento&id="+id);
});

$(document).on("click", ".excluirAdmPagamento", function(){

	var id = $(this).attr("id");

	bootbox.confirm("Deseja realmente excluir esse administrador?", function(result) {
		var confirma = result;
		if(confirma == true){
		
			var pagina = "sistema.php?acao=adminGlobal/excluirAdmPagamento&id="+id;
		
			$.post(pagina, {} ,function(data){
				carregarPaginaCentral("sistema.php?acao=adminGlobal/listagemAdmPagamento");
				
			});
		}
	});
}); 
$(document).on("click", "#rodarFilaEspera", function(){ 

	var pagina = "sistema.php?acao=adminGlobal/rodarFilaEspera";
	
	$.post(pagina, {} ,function(data){
			
		var dado = $.parseJSON(data);
		
		if(dado.retorno == 1){
			
			$("#tabela").html(dado.tabela);

		}else {

			$("#aviso").show();

		}
		
	});
});

$(document).on("click", ".novoAdmCredenciamento", function(){ 
	
	var pagina = "sistema.php?acao=adminGlobal/novoAdmCredenciamento";
	carregarPaginaCentral(pagina);
});

$(document).on("click", ".editarAdmCredenciamento", function(){ 
	var id = $(this).attr("id");
	carregarPaginaCentral("sistema.php?acao=adminGlobal/editarAdmCredenciamento&id="+id);
});

$(document).on("click", ".excluirAdmCredenciamento", function(){

	var id = $(this).attr("id");

	bootbox.confirm("Deseja realmente excluir esse administrador?", function(result) {
		var confirma = result;
		if(confirma == true){
		
			var pagina = "sistema.php?acao=adminGlobal/excluirAdmCredenciamento&id="+id;
		
			$.post(pagina, {} ,function(data){
				
				carregarPaginaCentral("sistema.php?acao=adminGlobal/listagemAdmCredenciamento");
				
			});
		}
	});
});

$(document).on("keyup", ".buscarAdmCredenciamento", function(){ 

	var id = $("#id").val();
	var nome = $("#nome").val();
	var cpf = $("#cpf").val();
	var limite = $("#limite").val();
	var pagina = "sistema.php?acao=adminGlobal/listagemAdmCredenciamentoFiltro&id="+id+"&id="+id+"&nome="+nome+"&cpf="+cpf+"&limite="+limite;	
	carregarDivAjax("listagem",pagina);
});

$(document).on("change", ".buscarAdmCredenciamento", function(){ 
	
	var id = $("#id").val();
	var nome = $("#nome").val();
	var cpf = $("#cpf").val();
	var limite = $("#limite").val();
	var pagina = "sistema.php?acao=adminGlobal/listagemAdmCredenciamentoFiltro&id="+id+"&id="+id+"&nome="+nome+"&cpf="+cpf+"&limite="+limite;	
	carregarDivAjax("listagem",pagina);
});

$(document).on("click", ".novoAviso", function(){ 
	
	var pagina = "sistema.php?acao=adminGlobal/cadastraAvisos";
	carregarPaginaCentral(pagina);
	
});

$(document).on("click", ".editarAviso", function(){ 
	var id = $(this).attr("id");
	carregarPaginaCentral("sistema.php?acao=adminGlobal/editarAviso&id="+id);
});

$(document).on("click", ".excluirAviso", function(){

	var id = $(this).attr("id");

	bootbox.confirm("Deseja realmente excluir esse aviso?", function(result) {
		var confirma = result;
		if(confirma == true){
		
			var pagina = "sistema.php?acao=adminGlobal/excluirAviso&id="+id;
		
			$.post(pagina, {} ,function(data){
				
				carregarPaginaCentral("sistema.php?acao=adminGlobal/listagemAvisos");
				
			});
		}
	});
});

$(document).on("keyup", ".buscarAviso", function(){ 

	var id = $("#id").val();
	var titulo = $("#titulo").val();
	var limite = $("#limite").val();
	var pagina = "sistema.php?acao=adminGlobal/listagemAvisosFiltro&id="+id+"&titulo="+titulo+"&limite="+limite;	
	carregarDivAjax("listagem",pagina);
});

$(document).on("change", ".buscarAviso", function(){ 
	
	var id = $("#id").val();
	var titulo = $("#titulo").val();
	var limite = $("#limite").val();
	var pagina = "sistema.php?acao=adminGlobal/listagemAvisosFiltro&id="+id+"&titulo="+titulo+"&limite="+limite;
	carregarDivAjax("listagem",pagina);
});

$(document).on("click", ".novoAdmGlobal", function(){ 
	
	var pagina = "sistema.php?acao=adminGlobal/novoAdmGlobal";
	carregarPaginaCentral(pagina);
});

$(document).on("click", ".editarAdmGlobal", function(){ 
	var id = $(this).attr("id");
	carregarPaginaCentral("sistema.php?acao=adminGlobal/editarAdmGlobal&id="+id);
});

$(document).on("click", ".excluirAdmGlobal", function(){

	var id = $(this).attr("id");

	bootbox.confirm("Deseja realmente excluir esse administrador?", function(result) {
		var confirma = result;
		if(confirma == true){
		
			var pagina = "sistema.php?acao=adminGlobal/excluirAdmGlobal&id="+id;
		
			$.post(pagina, {} ,function(data){
				
				carregarPaginaCentral("sistema.php?acao=adminGlobal/listagemAdmGlobal");
				
			});
		}
	});
});

$(document).on("keyup", ".buscarAdmGlobal", function(){ 

	var id = $("#id").val();
	var nome = $("#nome").val();
	var cpf = $("#cpf").val();
	var limite = $("#limite").val();
	var pagina = "sistema.php?acao=adminGlobal/listagemAdmGlobalFiltro&id="+id+"&id="+id+"&nome="+nome+"&cpf="+cpf+"&limite="+limite;	
	carregarDivAjax("listagem",pagina);
});

$(document).on("change", ".buscarAdmGlobal", function(){ 
	
	var id = $("#id").val();
	var nome = $("#nome").val();
	var cpf = $("#cpf").val();
	var limite = $("#limite").val();
	var pagina = "sistema.php?acao=adminGlobal/listagemAdmGlobalFiltro&id="+id+"&id="+id+"&nome="+nome+"&cpf="+cpf+"&limite="+limite;	
	carregarDivAjax("listagem",pagina);
});

$(document).on("keyup", '.buscarAtividades', function(){
	var nome = $("#nome").val();
	var preponente = $("#preponente").val();
	var limite = $("#limite").val();
	var pagina = "sistema.php?acao=adminGlobal/listagemAtividadesFiltro&nome="+nome+"&preponente="+preponente+"&limite="+limite;
	carregarDivAjax("listagem",pagina);
});

$(document).on("change", '.buscarAtividades', function(){
	var nome = $("#nome").val();
	var preponente = $("#preponente").val();
	var limite = $("#limite").val();
	var pagina = "sistema.php?acao=adminGlobal/listagemAtividadesFiltro&nome="+nome+"&preponente="+preponente+"&limite="+limite;
	carregarDivAjax("listagem",pagina);
});