 

$(document).on("click", ".verMais", function(){	
	var id = $(this).attr("id");
	lightbox("sistema.php?acao=oficina/verMais&id="+id);
	//new Messi($("#"+aux).html());
	
});	

$(document).on("click", ".selecionarOficina", function(){
	var id = $(this).val(); 
	var pagina = "sistema.php?acao=oficina/verificarDisponibilidade&id="+id;
	
	//Post que vai verificar disponibilidade
	$.post(pagina,{},function(data){
	
		var dado = data.split("|");
		if(dado[0] == 1){
			erro("Sua faixa etária não correponde com a faixa etária necessária para participar dessa oficina.", "Erro");
			$("#"+dado[1]).prop('checked', false);
		
		}else if (dado[0] == 2){
			
			info("Não há mais vagas para esta oficina, você está automaticamente na fila de espera.");
			$("#"+dado[1]).removeClass("selecionarOficina");
			$("#"+dado[1]).addClass("removerOficina");
		
		}else if (dado[0] == 3){
			
			//Cadastrou sem problemas. Gambiarra necessaria.
			$("#"+dado[1]).removeClass("selecionarOficina");
			$("#"+dado[1]).addClass("removerOficina");
		
		}else{
			
			erro(dado[0], " Erro");	 
			$("#"+dado[1]).prop('checked', false);
		}	
	});
});



$(document).on("click", ".removerOficina", function(){

	var id = $(this).val(); 
	var pagina = "sistema.php?acao=oficina/removerOficina&id="+id;
	
	confirmacao("Você realmente deseja sair dessa oficina?");
	
	$(document).on("click", "#btn-confirmar-sim", function(e){
		console.log(pagina);
		e.preventDefault();
		
		$.post(pagina,{},function(data){
			if(data > 0){
				
				//Não houve nenhum erro ao excluir, as classes são trocadas.
				$("#"+id).removeClass("removerOficina");
				$("#"+id).addClass("selecionarOficina");
			}else if (data == 0) {
				
				/*Não é possivel excluir uma oficina cujo pagamento ja foi efetuado. */
				$("#"+id).prop('checked', true);
				erro("Você já efetuou o pagamento dessa oficina. Não é possível excluí-la.", "Erro");	 
			}else{	
				$("#"+id).removeClass("removerOficina");
				$("#"+id).addClass("selecionarOficina");
			}	
		});
	});
	
	$(document).on("click", "#btn-confirmar-nao", function(e){
		
		e.preventDefault();
		
		$("#"+id).prop('checked', true);
	});
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
	
		$('#modal-header1').removeClass('alert-sucess, alert-warning, alert-info, alert-danger').addClass('alert-default');
		$('.modal-title').html('<span class="glyphicon glyphicon-book"></span> Oficina ');
		$('.modal-body').html(data);
		$('.modal-footer').html('<button type="button" class="btn btn-grey1" data-dismiss="modal"><span class=	"glyphicon glyphicon-ok"></span></button>');
		$('#myModal').modal({show:true});
	});
}


function carregarArea(){
	carregarDivAjax("area","sistema.php?acao=oficina/listaArea");
}

console.log($('#datepicker-horario-inicio').lenght);
if($('#datepicker-horario-inicio').lenght > 0){

	$('#datepicker-horario-inicio, #datepicker-horario-fim').datetimepicker({
		language: 'pt',
		pickDate: false,
		useSeconds: false,
		useCurrent: false
	})

	$('#datepicker-data-inicio, #datepicker-data-termino').datetimepicker({
		language: 'pt',
		pickTime: false,
	});
}
$(document).ready(function(){
	carregarArea();
})