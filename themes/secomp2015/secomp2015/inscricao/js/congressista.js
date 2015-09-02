carregarAreas(); //carrega as áreas como radio buttons

function carregarAreas(){
	carregarDivAjax("areas","sistema.php?acao=congressista/listarAreas");
}
/* Funções referentes ao aluno. */
	
$(document).on("click", ".editarAluno", function(){ 
	carregarPaginaCentral("sistema.php?acao=aluno/exibirDadoAluno");
});

$(document).on("click", ".excluirDependente", function(){ 
	var id = $(this).attr("id");

	confirmacao('Deseja realmente excluir esse dependente?', ' Alerta');
	
	//quando abre o modal de confirmar, terá um botão com esse id
	$(document).on('click', '#btn-confirmar-sim', function(e){
		e.preventDefault();
		carregarPaginaCentral("sistema.php?acao=aluno/excluirDependente&id="+id);
	});
})

$("#logar").click(function(e){
	e.preventDefault();
	$.post("sistema.php?acao=login/logar",{"login": $("#cpf").val(),"senha":$("#senha").val()},function(data){
		if(data.trim().length == 0){
			erro("Login e/ou senha inválidos!", " Erro");
		}else {
			window.location = "sistema.php?acao=site/telaInicial";	
		}		
	});	
});

/*
//$(".excluirDependente").live("click", function(){
	var id = $(this).attr("id");
	
	
	//new Messi("Você realmente deseja excluir esse aluno?", {title: 'Confirmação', 
	//	buttons: [{id: 0, label: 'Sim', val: '1'}, 
	//	{id: 1, label: 'Não', val: '0'}], 
	//	callback: function(val) {
	//		if(val == 1){
	//			carregarPaginaCentral("sistema.php?acao=aluno/excluirDependente&id="+id);		
	//		}
	//	}
	//});
	
	
	
	
	carregarPaginaCentral("sistema.php?acao=aluno/excluirDependente&id="+id);		
	
});*/


$(document).on("click", ".editarDependente", function(){ 
//$(".editarDependente").live("click", function(){
	var id = $(this).attr("id");
	carregarPaginaCentral("sistema.php?acao=aluno/exibirDadoDependente&id="+id);
});


$(document).on("click", "#buscarAluno", function(){ 
	var nome = $("#palavra").val();
	carregarPaginaCentral("sistema.php?acao=aluno/telaSituacao&palavra="+nome);
});

$(document).on("click", ".visualizarAluno", function(){ 
	var id = $(this).attr("id");
	//lightbox("sistema.php?acao=aluno/exibirSituacao&id="+id);
	carregarPaginaCentral("sistema.php?acao=aluno/exibirSituacao&id="+id);
});

$(document).on("click", ".gerarBoleto", function(){ 
	var id = $(this).attr("id");
	url = "sistema.php?acao=aluno/selecionarDadosBoleto";
	$.post(url, {codigo_boleto:id}, function(data){
		//window.open("boleto_bb.php",'_blank');
		window.location = "boleto_bb.php";
	});
});

	
$(document).on("click","#sub-artigo" ,function(){
	$('.areaslist').removeClass('oculta');
	$('.autorArtigo').removeClass('oculta');
	$('#nomeArtigo').addClass('texto-obrigatorio');
	$('#autor').addClass('texto-obrigatorio');
});
$(document).on("click","#sub-artigoN" ,function(){

	$('.areaslist').addClass('oculta');
	$('.autorArtigo').addClass('oculta');
	$('#nomeArtigo').removeClass('texto-obrigatorio');
	$('#autor').removeClass('texto-obrigatorio');
	i=0; 

	$(".coAutor").each(function () { 

		i++; 
	}); 
	while(i != 0 ){
		if (i>1) { 
			$("#CoautorArtigo").remove();
		}
		if (i == 1){
			$("#CoautorArtigo").addClass('oculta');
			$(".adicionarCampo").removeClass('btn-disabled');
			$(".adicionarCampo").addClass('btn-grey1');
		} 
		i--;
	}
});

$(document).on("click",".removerCampo",function  () {
	$(".adicionarCampo").removeClass('btn-disabled');
	$(".adicionarCampo").addClass('btn-grey1');
	var i=0; 
	$("#coAutor").each(function () { 

		i++; 
	}); 
	if (i>1) { 
		$("#CoautorArtigo").remove(); 
	}else{
		$("#CoautorArtigo").addClass('oculta');
	} 
}); 
$(document).on("click",".adicionarCampo",function  () {
	var i=0; 
	$("#coAutor").each(function () { 
		i++; 
	}); 
	if(i < 6){
		$(".adicionarCampo").removeClass('btn-disabled');
		if (i == 1) { 
			$("#CoautorArtigo").removeClass('oculta');
		}
		novoCampo = $("#CoautorArtigo:first").clone(); 
		novoCampo.insertAfter("#CoautorArtigo:last"); 
	}else{
		$(".adicionarCampo").removeClass('btn-grey1');
		$(".adicionarCampo").removeClass('btn-disabled');
	}
}); 
$(document).on("click", ".alterarAtividades", function(){ 
	var id = $(this).attr("id");
	carregarPaginaCentral("sistema.php?acao=congressista/listagemAtividadeEditar&id="+id);
});