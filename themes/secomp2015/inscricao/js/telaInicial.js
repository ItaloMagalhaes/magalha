/*
	O menu será feito com uma lista de links. Portanto
	esse metodo faz com que todos os links que não tenham alvo definido
	abram na div central.
*/
	
$(document).on("click", "a", function(){ 
	if ($(this).attr("target")=='')
		return carregarPaginaCentral($(this).attr("href"));
});

$(document).on("click", ".sub-link", function(){ 
	
	$( ".link" ).each(function( index ) {
  		$(this).removeClass('active');	
	});
	
	//removeClass('active');
	$("#cadastro").removeClass('open');
	$("#cadastro").addClass('active');

});

//validações desenvolvidas por João Victor Magela em conjunto com Antônio Marcos Bernardes.

//Verifica sem um campo com texto obrigatório está preenchido
function validarTextoObrigatorio(elemento){
	
	if(elemento.val().trim().length == 0) {
		
		exibirErroTextoObrigatorio(elemento);
		return false;
	
	}

	return true;
}

//Verifica se contem algo diferente de número em um determinado campo do tipo númérico
function validarInputNumerico(elemento){
	if(!validarCampoNumerico(elemento.val())) {
		exibirErroTextoObrigatorio(elemento);
		return false; //return false sai apenas do each
	}

	return true;
}

function validarInputData(elemento){
	if(!validarData(elemento.val())){
		exibirErroTextoObrigatorio(elemento);
		return false;
	}

	return true;
}

function validarInputHora (elemento) {
	if(!validarHora(elemento.val() )){
		exibirErroTextoObrigatorio(elemento);
		return false;
	}

	return true;
}

/*
	Pega um grupo de radio (pelo atributo name) e verifica se algum item está marcado. Caso não, retorna false.
	Autor: João Victor Magela (joao.dk16@gmail.com)
*/
function validarGrupoRadioButton(form, name){
	var grupo = form.find('input[name="'+name+'"]:checked');

	if(typeof(grupo) == 'undefined' || grupo.length == 0) return false;
	return true;
}

function validarCampoRadio(el, name, form){
	if(!validarGrupoRadioButton(form, name)){
		exibirErroTextoObrigatorio(el);
		return false;
	}

	return true;
}

function validarInputCPF(elemento){
	if(!validarCPF(elemento.val())){
		exibirErroTextoObrigatorio(elemento);
		return false;
	}

	return true;
}

function validarInputEmail(elemento){
	if(!validarEmail(elemento.val())){
		exibirErroTextoObrigatorio(email);
		//mensagem de erro para email
		return false;
	}

	return true;
}

function validarInputConfirmacaoEmail(elemento, form){
	var textoEmail = form.find('#email').val();
	

	if(textoEmail != elemento.val()){
		exibirErroTextoObrigatorio(elemento);
		return false;
	}

	return true;
	
}

function validarInputTel(elemento){
	return true;
	var texto = elemento.val().replace(/^\D+/g, '');
	
	if(elemento.length < 10 || elemento.length > 11){
		exibirErroTextoObrigatorio(elemento);
		return false;
	}	

	return true;
}

function validarInputConfirmacaoSenha(elemento, form){
	var senha = form.find('#senha').val().trim();
	
	var senhaConfirmacao = elemento.val().trim();
	
	if(senha != senhaConfirmacao){
		exibirErroTextoObrigatorio(elemento);
		return false;
	}
	return true;
}

function validarDisponibilidade(form){
	//verifica os campos de disponiblidade. Se todos estiverem vazios, exibe a mensagem de erro
	var disponibilidade = form.find('.disponibilidade');

	if(disponibilidade.length == 0){
		return true;
	}

	var vazio = false;
	
	//pega os dados dos turnos e faz a validação. Validação da manhã
	var manhaInicio = $(disponibilidade[0]), manhaFim = $(disponibilidade[1]);
	if(manhaInicio.val().length == 0 && manhaFim.val().length == 0) vazio = true; //se ambos forem vazio, verifica a proxima dupla
	else if(manhaInicio.val().length == 0 || manhaFim.val().length == 0) {
		//caso apenas um esteja vazio, gera um erro
		exibirErroTextoObrigatorioDisponibilidade(manhaInicio);
		return false;
	}else{
		//se ambos estiverem preenchidos, verifica se as datas são válidas
		if(!validarCampoHora(manhaInicio.val(), manhaFim.val(), 'manha')){
			exibirErroTextoObrigatorioDisponibilidade(manhaInicio);
			return false;	
		}else{
			vazio = false;
		}
	}

	//validação da tarde
	var tardeInicio = $(disponibilidade[2]), tardeFim = $(disponibilidade[3]);
	if(tardeInicio.val().length == 0 && tardeFim.val().length == 0) {
		if(vazio) vazio = true; //se ambos forem vazio, verifica a proxima dupla
	}
		
	else if(tardeInicio.val().length == 0 || tardeFim.val().length == 0) {
		//caso apenas um esteja vazio, gera um erro
		exibirErroTextoObrigatorioDisponibilidade(tardeInicio);
		return false;
	}else{
		//se ambos estiverem preenchidos, verifica se as datas são válidas
		if(!validarCampoHora(tardeInicio.val(), tardeFim.val(), 'tarde')){
			exibirErroTextoObrigatorioDisponibilidade(tardeInicio);
			return false;	
		}else{
			vazio = false;
		}
	}

	//validação da noite
	var noiteInicio = $(disponibilidade[4]), noiteFim = $(disponibilidade[5]);
	if(noiteInicio.val().length == 0 && noiteFim.val().length == 0) {
		if(vazio) vazio = true; //se ambos forem vazio, verifica a proxima dupla
	}
	else if(noiteInicio.val().length == 0 || noiteFim.val().length == 0) {
		//caso apenas um esteja vazio, gera um erro
		exibirErroTextoObrigatorioDisponibilidade(noiteInicio);
		return false;
	}else{
		//se ambos estiverem preenchidos, verifica se as datas são válidas
		if(!validarCampoHora(noiteInicio.val(), noiteFim.val(), 'noite')){
			exibirErroTextoObrigatorioDisponibilidade(noiteInicio);
			return false;	
		}else{
			vazio = false;
		}
	}

	//se vazio for true, indica que todos os campos estão vazio.
	if(vazio){
		exibirErroTextoObrigatorioDisponibilidade(manhaInicio);
		return false;
	}
	
	return true;
}

/*
	Todos os posts serão feitos por ajax
*/


/*
	Faz com que a mensagem de erro de um determinado elemento seja exibida. O parâmetro isCampoData é necessário para casos hoje tenha um campo de
	data ou Radio, pois a hierarquia dos elementos é diferente dos outros campos texto comum.
	Autor: João Victor Magela (joao.dk16@gmail.com)
*/
function exibirErroTextoObrigatorio(elemento){
	/*
		o esqueleto de cada form-group é:
		form-group
			label
			div
				input
			/div
			div
				msg-erro
			/div
		/form-group

		Com isso, para exibir a mensagem de erro, basta acessar msg-erro do form-group corrente, que é feito da seguinte maneira:
			elemento.parent().parent() acessa a raiz do form-group. '.find(.msg-erro)' pesquisa por elemento com essa classe.
	*/
	//$('#accordion').collapse('hide');
	//caso seja um campo data, tem que subir mais um nível

	//existe o método parents() que faz a busca por um parente mais acima, mas assim está funcionando.
	
	elemento.parents('.form-group').find('.msg-erro').removeClass('oculta') //exibe a mensagem de erro. o metodo show() não funciona nesse caso (creio eu)
	//elemento.parents('.form-group').addClass('has-error has-feedback'); //adiciona as classes que deixam as bordas vermelhas. 
	//insere um x vermelho no campo, indicando erro
	
	if(elemento.is('input[type="text"], textarea') || elemento.hasClass('data') || elemento.hasClass('hora')){
		elemento.parent().append('<span class="form-control-feedback"></span>');
		//faz com que, ao começar a digitar ou selecionar algum radio, a mensagem de erro suma
		removerMensagemErro(elemento, false);
	
	}else if(elemento.is('input[type="radio"]')){
		removerMensagemErro(elemento, true);
	
	}else if(elemento.is('select')){
		removerMensagemErro(elemento, false);
	}

	elemento.focus(); //faz com o que o foco seja no elemento do erro
	//$('#accordion').collapse('show').height('auto');
	//elemento.parents('.panel-collapse').collapse('show').height('auto'); //esse monte de parent() faz chegar no collapse do elemento que deu erro. Então o abre.
	
}

//função semelhante a acima. Por conta da mensagem de erro estar em uma posição diferente da comum, essa função foi necessária.
function exibirErroTextoObrigatorioDisponibilidade(elemento){
	$('.msg-erro-disponibilidade').removeClass('oculta') //exibe a mensagem de erro. o metodo show() não funciona nesse caso (creio eu)
	elemento.parents('.form-group').addClass('has-error has-feedback'); //adiciona as classes que deixam as bordas vermelhas. 
	
	elemento.focus(); //faz com o que o foco seja no elemento do erro
}


//função que remove a mensagem de erro para campos com a classe .texto-obrigatorio. Faz o processo contrário ao de exibir a mensagem de erro
function removerMensagemErro(elemento, isRadio){
	if(isRadio){
		$('input[type="radio"][name="'+elemento.attr('name')+'"]').change(function(){
			var radio = $(this);
			radio.parents('.form-group').find('.msg-erro').addClass('oculta');
			radio.parents('.form-group').removeClass('has-error has-feedback');
			radio.parents('.form-group').find('.form-control-feedback').remove();
		})
	}else{
		/*
			change = quando algo mudar no campo
			paste = quando alguem colar algo no campo
			keyup = quando alguem digitar algo no campo
		*/
		elemento.bind('change paste keyup',  function(){
			

			elemento.parents('.form-group').find('.msg-erro').addClass('oculta');
			elemento.parents('.form-group').removeClass('has-error has-feedback');
			elemento.parents('.form-group').find('.form-control-feedback').remove();
		})	
	}
}


$(document).on('submit','form', function(e){
	e.preventDefault();
	var form = $(this);
	if(form.attr("action")!=""){
		var validacao = true; //flag de validação. Se chegar ao fim do processo como true, indica que não teve erro nas validações

		/* String com todos os elementos que devem ser verificados no formulário 
			Isso é necessário para que a validação possa ser feita na ordem em que os itens estão no formulário.
			Os elementos são separados por ','.
			String com mais de uma linha em javascript deve ter no final de cada linha o caracter '\''

		*/
		var elementosForm = '.form-group:not(.oculta) .texto-obrigatorio, \ .form group:not(.oculta) input[type="radio"][name="sexo"], .form group:not(.oculta) input[type="radio"][name="pagamento"], \ .form group:not(.oculta) input[type="radio"][name="tipoConta"], .form group:not(.oculta) input[type="radio"][name="area_interesse"]';
		
		var el = '';
		form.find(elementosForm).each(function(i,e){
			el = $(this);
			
			if(el.hasClass('texto-obrigatorio')) {
				
				validacao = validarTextoObrigatorio(el);
				
				if(!validacao) return false;
				
				if(el.hasClass('campo-numerico')) validacao = validarInputNumerico(el); 
				
				if(!validacao) return false;
				
				if(el.prop('id') == 'cpf') validacao = validarInputCPF(el);
				
				if(!validacao) return false;
				
				if(el.hasClass('data')) validacao = validarInputData(el);

				if(el.hasClass('hora')) validacao = validarInputHora(el);

				//if(el.hasClass('data')) validacao = validarData(el);
				
				if(!validacao) return false;				
				
				if(el.prop('id') == 'email') validacao = validarInputEmail(el);
				
				if(!validacao) return false;
				
				if(el.prop('id') == 'confirmacao-email') validacao = validarInputConfirmacaoEmail(el, form);
				
				if(!validacao) return false;				
				
				//if(el.hasClass('tel')) validacao = validarInputTel(el);
				//console.log("Opa8");
				//if(!validacao) return false;
				
				if(el.prop('id') == 'confirmacao-senha') validacao = validarInputConfirmacaoSenha(el, form);
				
				if(!validacao) return false;				
				
			}

			//se for um campo do tipo radio, basta pegar a name dele e verificar se tem algum radio do grupo selecionado
			else if(el.is('input[type="radio"]')){
				var name = el.attr('name');
				validacao = validarCampoRadio(el, name, form);
				
				if(!validacao) return false;
			}
				
		})
		if(!validacao) return false;
		
		//validacao = validarDisponibilidade(form);
		//if(!validacao) return false;
		
		var campo = form.find('#upload-arquivo');
		var dados;
		
		var url = $(this).attr('action');
		
		
		//se tiver o campo de input, faz um form data, caso contrario, vai de de serialize mesmo
		if(campo.length > 0){
			dados = new FormData(form[0]);
			$.ajax({
				url: url,
				data: dados,
				type: 'POST',
				cache: false,
			        contentType: false,
			        processData: false,
			
	
				success: function(data){
					
					var dado = $.parseJSON(data);
					
					if(dado.tipo == 1){
						sucesso(dado.mensagem,' Sucesso');
						carregarPaginaCentral(dado.redirecionar);
					}else{
						erro(dado.mensagem, " Erro");
					}	
				}
			});
			
		}else {
			dados = form.serialize();
			
			$.post(url, dados,function(data){
				try{	
					var dado = $.parseJSON(data);
					
					if(dado.tipo == 1){
						
						sucesso(dado.mensagem,' Sucesso!');
						carregarPaginaCentral(dado.redirecionar);
					}else{
						erro(dado.mensagem, " Erro!");
					}
				}catch(e){
					
					console.log(data);
				}	
				
			}); 
		}
		
		/* Impede da pagina ser recarregada. */
		return false;
	}

	return false;
});
$(document).ready(function(){
	/*	Essa pagina inicial será a primeira pagina que aparecerá na div central
		no caso, tem que ser passada no seguinte formato:
		pacote.php?acao=metodoDesejado&parametro=valor
	*/	
	carregarPaginaCentral("sistema.php?acao=home/telaInicial");
	
}); 