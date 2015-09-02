$(document).on("click", ".verMais", function(){	
	var id = $(this).attr("id");
	lightbox("sistema.php?acao=atividade/verMais&id="+id);
});

$(document).on("click", ".novaAtividade", function(){ 
	var pagina = "sistema.php?acao=atividade/exibirFormularioAtividade";
	carregarPaginaCentral(pagina);	
});

$(document).on("click", ".selecionarAtividade", function(){
	var id = $(this).val(); 
	var pagina = "sistema.php?acao=atividade/verificarDisponibilidade&id="+id;
	
	//Post que vai verificar disponibilidade
	$.post(pagina,{},function(data){
	
		var dado = data.split("|");
		if(dado[0] == 1){
			erro("Sua faixa etária não correponde com a faixa etária necessária para participar dessa oficina.", "Erro");
			$("#"+dado[1]).prop('checked', false);
		
		}else if (dado[0] == 2){
			
			info("Não há mais vagas para esta oficina, você está automaticamente na fila de espera.");
			$("#"+dado[1]).removeClass("selecionarAtividade");
			$("#"+dado[1]).addClass("removerAtividade");
		
		}else if (dado[0] == 3){
			
			//Cadastrou sem problemas. Gambiarra necessaria.
			$("#"+dado[1]).removeClass("selecionarAtividade");
			$("#"+dado[1]).addClass("removerAtividade");
		
		}else{
			
			erro(dado[0], " Erro");	 
			$("#"+dado[1]).prop('checked', false);
		}	
	});
});

$(document).on("click", ".removerAtividade", function(){

	var id = $(this).val(); 
	var pagina = "sistema.php?acao=atividade/removerAtividade&id="+id;
	
	bootbox.confirm("Deseja realmente remover essa atividade?", function(result) {
		var confirma = result;
		if(confirma == true){
		
			$.post(pagina,{},function(data){
				if(data > 0){
					
					//Não houve nenhum erro ao excluir, as classes são trocadas.
					$("#"+id).removeClass("removerAtividade");
					$("#"+id).addClass("selecionarAtividade");

				}else if (data == 0) {
					
					/*Não é possivel excluir uma Atividade cujo pagamento ja foi efetuado. */
					$("#"+id).prop('checked', true);
					erro("Você já efetuou o pagamento dessa Atividade. Não é possível excluí-la.", "");	 
				}else{
					$("#"+id).removeClass("removerAtividade");
					$("#"+id).addClass("selecionarAtividade");
				}	
			});
		}else{
			$("#"+id).prop('checked', true);
		}
	});
});

$(document).on("click", ".removerAtividadeEditar", function(){

	var id = $(this).val(); 
	var pagina = "sistema.php?acao=atividade/removerAtividadeEditar&id="+id;
	
	
	bootbox.confirm("Você realmente deseja sair dessa atividade?", function(result) {
		var confirma = result;
		if(confirma == true){
			$.post(pagina,{},function(data){
				if(data > 0){
					
					//Não houve nenhum erro ao excluir, as classes são trocadas.
					$("#"+id).removeClass("removerAtividadeEditar");
					$("#"+id).addClass("selecionarAtividade");

				}else if (data == 0) {
					
					/*Não é possivel excluir uma Atividade cujo pagamento ja foi efetuado. */
					$("#"+id).prop('checked', true);
					erro("Você já efetuou o pagamento dessa Atividade. Não é possível excluí-la.", "");	 
				}else{
					$("#"+id).removeClass("removerAtividadeEditar");
					$("#"+id).addClass("selecionarAtividade");
				}	
			});
		}else{
			$("#"+id).prop('checked', true);
		}
	});
});

$(document).on("click", ".editarAtividade", function(){ 
	var id = $(this).attr("id");
	carregarPaginaCentral("sistema.php?acao=atividade/exibirDadoAtividade&id="+id);
}); 

/*--------------------------------------------------------
Método: filaDeEspera
Descrição: Faz a matricula do aluno na fila de espera.
Author: Antonio Marcos <amm.bernardes@gmail.com>
----------------------------------------------------------*/
function filaDeEspera(msg,oficina){ 
    new Messi(msg, {title: 'Confirmação', 
    buttons: [{id: 0, label: 'Sim', val: '1'}, 
		  {id: 1, label: 'Não', val: '0'}], 
		  callback: function(val) {
			    if(val == 1){
					var url = "sistema.php?acao=oficina/matricularFilaEspera";
					$.post(url,{},function(data){
					
					});
			    }
		  	}
	});
}

/*--------------------------------------------------------
Método: lightbox
Descrição: Exibe um conteudo em um lightbox.
Author: Antonio Marcos
----------------------------------------------------------*/  
function lightbox(pagina){	
	
	$.post(pagina,{},function(data){
		$('#modal-header2').removeClass('alert');
		$('#modal-header2').removeClass('alert-success');
		$('#modal-header2').removeClass('alert-warning');
		$('#modal-header2').removeClass('alert-info');
		$('#modal-header2').removeClass('alert-danger');
		$('.modal-title').html('<i class="fa fa-tasks"></i> Atividade ');
		$('.modal-body').html(data);
		$('.modal-footer').html('<button type="button" class="btn btn-grey1" data-dismiss="modal"><i class="fa fa-check"></i></button>');
		$('#myModal1').modal({show:true});
	});
}


function carregarArea(){
	carregarDivAjax("area","sistema.php?acao=oficina/listaArea");
}

$(document).on("keyup", ".buscarAtividade", function(){ 

	var nome = $("#nome").val();
	var preponente =   $("#preponente").val();
	var local =  	   $("#local").val();
	var limite = $("#limite").val();
	var tipo = $("#tipo").val();
	var pagina = "sistema.php?acao=atividade/selecionarAtividadeFiltro&nome="+nome+"&tipo="+tipo+"&local="+local+"&limite="+limite;	
	carregarDivAjax("listagem",pagina);
	
});

$(document).on("change", ".buscarAtividade", function(){ 
	
	var nome = $("#nome").val();
	var tipo =  $("#tipo").val();
	var local =  $("#local").val();
	var limite = $("#limite").val();
	var pagina = "sistema.php?acao=atividade/selecionarAtividadeFiltro&nome="+nome+"&tipo="+tipo+"&local="+local+"&limite="+limite;	
	carregarDivAjax("listagem",pagina);
	
});

$(document).ready(function(){
	carregarArea();
});