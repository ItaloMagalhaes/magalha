/*--------------------------------------------------------
Método: carregarPaginaCentral
Descrição: Carrega a url desejada, na div central, exibe tambem uma loading.
Author: Antonio Marcos <amm.bernardes@gmail.com>
----------------------------------------------------------*/
function carregarPaginaCentral(url){ 
   //Firula de loading
   $('#central').html("<br><br><br><br><br><br><div align='center'><img src='img/loading.gif' ><br> Carregando... </div><br><br><br><br><br><br>");
	
   //É feito o carregamento por por ajax.	
   $('#central').load(url);

   // carregarDivAjax('mensagemTopo','sistema.php?acao=site/mensagemTopo');
   return false;
}

/*--------------------------------------------------------
Método: carregarDivAjax
Descrição: Carrega a url desejada, na div desejada.
Author: Antonio Marcos <amm.bernardes@gmail.com>
----------------------------------------------------------*/
function carregarDivAjax(div,url){ 
   //É feito o carregamento por por ajax.	
   $('#'+div).load(url);
	
   return false;
}


/*--------------------------------------------------------
Método: erro
Descrição: Exibe alerta de erro.
Author: Antonio Marcos <amm.bernardes@gmail.com>
----------------------------------------------------------*/
function erro(msg,erro){ 
	$('#modal-header').removeClass('alert-danger, alert-warning, alert-sucess').addClass('alert-danger');
	$('.modal-title').html('<span class="glyphicon glyphicon-thumbs-down"></span> Erro');
	$('.modal-body').html(msg);
	$('.modal-footer').html('<button type="button" class="btn btn-danger" id="sim" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span></button>');
	$('#ModalErro').modal({show:true});
    return false;
}


/*--------------------------------------------------------
Método: info
Descrição: Exibe alerta de informação.
Author: Antonio Marcos <amm.bernardes@gmail.com>
----------------------------------------------------------*/
function info(msg){ 

   	$('#modal-header1').addClass('alert-info');
	$('.modal-title').html('<span class="glyphicon glyphicon-warning-signe"></span> Informação');
	$('.modal-body').html(msg);
	$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span></button>');
	$('#myModal').modal({show:true});
   return false;
}


/*--------------------------------------------------------
Método: sucesso
Descrição: Exibe alerta de sucesso.
Author: Antonio Marcos <amm.bernardes@gmail.com>
----------------------------------------------------------*/
function sucesso(msg,url,titulo){ 
	$('.modal-title').html('<span class="glyphicon glyphicon-thumbs-up"></span> Sucesso');
	$('.modal-body').html(msg);
	$('.modal-footer').html('<button type="button" class="btn btn-default" id="sim" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span></button>');
	$('#ModalSucesso').modal({show:true});
    return false;
}

/*--------------------------------------------------------
Método: confirmacao
Descrição: Exibe alerta de confirm.
Author: Antonio Marcos <amm.bernardes@gmail.com>
----------------------------------------------------------*/

/*--------------------------------------------------------
Método: isDate
Descrição: Valida a data.
Author: Antonio Marcos <amm.bernardes@gmail.com>
----------------------------------------------------------*/
function isDate(dtStr){

      
   var daysInMonth = DaysArray(12)

   var pos1=dtStr.indexOf(dtCh)
   var pos2=dtStr.indexOf(dtCh,pos1+1)
   var strDay=dtStr.substring(0,pos1)
   var strMonth=dtStr.substring(pos1+1,pos2)

   var strYear=dtStr.substring(pos2+1)
   strYr=strYear
   if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
   if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
   for (var i = 1; i <= 3; i++) {
	   if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
   }
   month=parseInt(strMonth)
   day=parseInt(strDay)
   year=parseInt(strYr)
 
   
   if (pos1==-1 || pos2==-1){
	   erro("A data deve ser digitada no formato : dd/mm/yyyy")
	   return false
   }
   if (strMonth.length<1 || month<1 || month>12){
	   erro("Por favor digite um mês válido.")
	   return false
   }
   if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
	   erro("Por favor digite um dia válido.")
	   return false
   }
   if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
	   erro("Por favor, digite um ano válido.")
	   return false
   }
   if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
	   erro("Por favor, digite uma data válida")
	   return false
   }
   return true
}


/*--------------------------------------------------------
Método: validarData
Descrição: Valida a data.
Author: Monica Neli 
Otimizada por João Victor Magela (joao.dk16@gmail.com)
----------------------------------------------------------*/
function validarData(data) { 
	

	if(data.split('/').length != 3) return false;

	//pega o dia, mes e ano da data passada como parâmetro
	dia = (data.substring(0,2)); 
	mes = (data.substring(3,5));
	ano = (data.substring(6,10));  
	
	//pega o dia,mes e ano da data corrente
	var dataAtual = new Date();
	diaAtual = dataAtual.getDate();
	mesAtual = dataAtual.getMonth();
	anoAtual = dataAtual.getFullYear();

	situacao = true; 
	
	// verifica se o ano é maior que o atual
	if (ano > anoAtual || ano < 1930 ){
		situacao = false; 
	}
	
	// verifica o dia valido para cada mes 
	if ((parseInt(dia) < 1)||(parseInt(dia) > 30) && 
		(parseInt(mes) == 4 || parseInt(mes) == 6 || parseInt(mes) == 9 || parseInt(mes) == 11 ) 
		|| parseInt(dia) > 31) { 
		situacao = false; 
	} 

	// verifica se o mes e valido 
	if (parseInt(mes) < 1 || parseInt(mes) > 12 ) { 
		situacao = false; 
	} 

	// verifica se e ano bissexto 
	if (mes == 2 && ( dia < 1 || dia > 29 || ( dia > 28 && (parseInt(ano / 4) != ano / 4)))) { 
		situacao = false; 
	} 
	
	// verifica o ano 
	if (ano < 1930  && ( dia < 1 || dia > 29 || ( dia > 28 && (parseInt(ano / 4) != ano / 4)))) { 
		situacao = false; 
	}     
	if (data == "") { 
		situacao = false; 
	} 

	return situacao;
  }
 


/*--------------------------------------------------------
Método: validarHora
Descrição: Verifica se uma hora é válida.
Author: Arthur Eduardo Moura
----------------------------------------------------------*/ 



function validarHora(argHora) {

	if(argHora.split(':').length != 2) return false;

	horas = (argHora.substring(0,2));
	minutos = (argHora.substring(3,5));

	if (parseInt(horas) > 23) return false;
	if (parseInt(minutos) > 60) return false;



	return true;
}
 






/*--------------------------------------------------------
Método: validarCPF
Descrição: Verifica se um cpf é válido. Não verifica se um cpf existe ou não. 
Author: João Victor Magela
----------------------------------------------------------*/  
function validarCPF(cpf){  
	var add;
	cpf = cpf.replace(/[^\d]+/g,'');    
	if(cpf == '') return false; // Elimina CPFs invalidos conhecidos    
	if (cpf.length != 11 || cpf == "00000000000" || 
		cpf == "11111111111" ||	cpf == "22222222222" ||         
		cpf == "33333333333" ||	cpf == "44444444444" ||         
		cpf == "55555555555" ||	cpf == "66666666666" ||         
		cpf == "77777777777" ||	cpf == "88888888888" ||
		cpf == "99999999999") return false;       
	// Valida 1o digito 
	add = 0;    
	for (i=0; i < 9; i ++) add += parseInt(cpf.charAt(i)) * (10 - i);  
			
	rev = 11 - (add % 11);  
	if (rev == 10 || rev == 11) rev = 0;    
	if (rev != parseInt(cpf.charAt(9))) return false;
	// Valida 2o digito 

	add = 0;    
	for (i = 0; i < 10; i ++) add += parseInt(cpf.charAt(i)) * (11 - i);  rev = 11 - (add % 11);  
	if (rev == 10 || rev == 11) rev = 0;
	if (rev != parseInt(cpf.charAt(10))) return false;
	
	return true;
}


/*--------------------------------------------------------
Método: validarEmail
Descrição: Verifica se um e-mail é válido. Um e-mail será válido se conter apenas um @
Author: João Victor Magela
----------------------------------------------------------*/ 
function validarEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}


/*--------------------------------------------------------
Método: validarCampoHora
Descrição: De acordo com o turno informado, verifica se os horarios passados estão de acordo com o limite previamente configurado
Author: João Victor Magela
----------------------------------------------------------*/ 
function validarCampoHora(inicio,fim, limite){
	
	if(inicio == fim) return false; //se as horas forem iguais, está errado
	var limiteSuperior = '', limiteInferior = '';
	switch(limite){
		case 'manha':
			limiteInferior = '00:00'; limiteSuperior = '12:00'; break;

		case 'tarde':
			limiteInferior = '12:01'; limiteSuperior = '18:00'; break;

		case 'noite':
			limiteInferior = '18:01'; limiteSuperior = '23:59'; break;

		default: return false;
	}

	var d1 = inicio.split(':'), l1 = limiteInferior.split(':'), d2 = fim.split(':'), l2 = limiteSuperior.split(':');

	//verifica se as horas do inicio são menores que o limite inferior, ou maior que limite superior
	if(parseInt(d1[0]) < parseInt(l1[0]) || parseInt(d1[0]) > parseInt(l2[0])) return false;
	//verifica se a hora do inicio é maior que a do fim
	else if(parseInt(d1[0]) > parseInt(d2[0])) return false;
	//se as horas forem iguais, deve-se verificar os minutos
	else if(parseInt(d1[0]) == parseInt(d2[0]) && parseInt(d1[1]) > parseInt(d2[1])) return false;

	//verifica se as horas do fim são menores que o limite inferior, ou maior que limite superior
	if(parseInt(d2[0]) < parseInt(l1[0]) || parseInt(d2[0]) > parseInt(l2[0])) return false;
	//verifica se a hora do inicio é maior que a do fim

	return true;



}

/*--------------------------------------------------------
Método: validarCampoNumerico
Descrição: Verifica se tem alguma coisa diferente de número na string
Author: João Victor Magela
----------------------------------------------------------*/ 

function validarCampoNumerico(valor){
	var temp = valor.replace(/[^\d]+/g,'');	//remove tudo que não é número

	if(temp.length < valor.length) return false; //se removeu alguma coisa, essa coisa foi alguma letra. Portanto, existe letra na string.
	return true;
}
