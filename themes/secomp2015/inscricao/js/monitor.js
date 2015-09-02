function carregarAreas(){
	carregarDivAjax("areas","sistema.php?acao=monitor/listarAreas");
}

function toggle(obj) {
	el = document.getElementById(obj);		
	if ( el.style.display != "none" ) {			
		el.style.display = "none";			
	}else {
		el.style.display = "";
	}
}	
		
$(document).ready(function(){ 

	carregarAreas(); //carrega as áreas como radio buttons

	/*
	$('#areas input[type="radio"]').each(function(i,e){
		var radio = $(this);

		if(radio.text().indexOf('Oficina') > -1) radio.remove();
	})*/

	//ocultação ou exibição de dados

	//quando clicar em deposito bancário, exibe os os campos conta e agência
	$('#deposito-bancario').click(function(){
		$('.group-deposito').removeClass('oculta');
		$('.group-pagamento-pessoal').addClass('oculta');
		$('.group-conta-corrente').addClass('oculta');
		$('.group-conta-poupanca').addClass('oculta');
		$('.group-banco-caixa').addClass('oculta');
		
		//desmarca os radios
		$('#conta-corrente').prop('cheked', false);
		$('#conta-poupanca').prop('cheked', false);
		
		$('#nomeBanco').val();
		$('#select-banco').val('');
		
		$('#operacaoBanco').val();
	});

	$('#pagamento-pessoal').click(function(){
		$('.group-deposito').addClass('oculta');
		$('.group-pagamento-pessoal').removeClass('oculta');
		$('.group-conta-corrente').addClass('oculta');
		$('.group-conta-poupanca').addClass('oculta');
		$('.group-banco-caixa').addClass('oculta');
		
		//limpa os campos ocultos
		$('#conta').val('');
		$('#agencia').val('');
	});

	$('#conta-corrente').click(function(){
		$('.group-conta-corrente').removeClass('oculta');
		$('.group-conta-poupanca').addClass('oculta');
		$('.group-banco-caixa').addClass('oculta');
		
		$('#select-banco').val('');
		$('#operacaoBanco').val('');
		
	});

	$('#conta-poupanca').click(function(){
		$('.group-conta-corrente').addClass('oculta');
		$('.group-conta-poupanca').removeClass('oculta');
		$('.group-banco-caixa').removeClass('oculta');
		
		$('#nomeBanco').val('');
	});

	/*
	$('#banco').change(function(){
		if($(this).val() == 'Caixa Econômica Federal') $('.group-banco-caixa').removeClass('oculta');
		else $('.group-banco-caixa').addClass('oculta');
		$('#operacaoBanco').val('');
	});*/

	//exibe ou não o campo para inserir a forma como participou do inverno cultural
	$('#participou-sim').click(function(){
		$('.group-participou').removeClass('oculta');
	})

	$('#participou-nao').click(function(){
		$('.group-participou').addClass('oculta');
		$('#participou').val('');
	})

	//exibe ou não o campo para inserir a as experiências com arte cultural
	$('#experiencia-sim').click(function(){
		$('.group-experiencia').removeClass('oculta');
	})

	$('#experiencia-nao').click(function(){
		$('.group-experiencia').addClass('oculta');
		$('#experiencia').val('');
	})

	$("#lugar").change(function(){
		var valor = $(this).val();
		if(valor != 'São João del Rei'){
		//	$('#areas').parents('.form-group').addClass('oculta');
		}else{
		//	$('#areas').parents('.form-group').removeClass('oculta');
		}
	})
	
	$('#upload-arquivo').change(function(){
		$(this).parents('.form-group').find('.msg-erro').addClass('oculta');
	})

	$(".SelecionarMonitor").click(function(){		
		var r = confirm("Selecionar Monitor?");
		if (r == true) {
			var str = $(this).attr('id');
			var id_monitor = str.substring(3)	   
			$('#rmm'+id_monitor).removeClass('oculta');
			$('#add'+id_monitor).addClass('oculta')
			url = "sistema.php?acao=monitor/selecionarMonitor";
			$.post(url, {id_monitor:id_monitor}, function(data){});
		} else {
		    
		}		
	})

	$(".RemoverMonitor").click(function(){		
		var r = confirm("Remover Monitor?");
		if (r == true) {
			var str = $(this).attr('id');
			var id_monitor = str.substring(3)	  
			$('#add'+id_monitor).removeClass('oculta');
			$('#rmm'+id_monitor).addClass('oculta')
			url = "sistema.php?acao=monitor/reprovarMonitor";
			$.post(url, {id_monitor:id_monitor}, function(data){});
		}
		else {

		}
		
	});

});

