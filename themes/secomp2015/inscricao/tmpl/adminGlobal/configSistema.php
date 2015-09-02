<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" type="../../css/text/css" href="../../css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="../../css/style.css">
	<script language="javascript">
		$(document).ready(function(){ 
			//Verificar o estado do sistema.
			verificaStatusMonitores();
			verificaStatusSistema();	
			
		});
		
		/*Verifica se a incrição dos monitores está aberta*/
		function verificaStatusMonitores(){
			$.post("sistema.php?acao=site/verificaStatusInsricaoMonitor",{},function(data){
				//Incricoes encerradas
				if(data == 0){
					$("#monitoresFechadas").addClass("fechadas");
				}else {
					$("#monitoresAbertas").addClass("abertas");
				}	
			});
		}
		
		/*Verifica se as incriçoes estão abertas*/	
		function verificaStatusSistema(){
			$.post("sistema.php?acao=site/verificaStatusInscricaoAluno",{},function(data){
				//Incricoes encerradas
				if(data == 0){
					$("#sistemaFechadas").addClass("fechadas");
				}else {
					$("#sistemaAbertas").addClass("abertas");
				}
			});
		}		
	</script> 
</head>
<body>
	<div class="panel-group" id="accordion">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h4 class="panel-title">
				    	<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
					     	Alterar configurações do sistema
					    </a>
					   <a class="pull-right" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" ><span class="glyphicon glyphicon-chevron-down"></span></a>
					</h4>
				</div>
								
				<div id="collapseOne" class="panel-collapse collapse in">
					<div class="panel-body">
						<div class="form-group">
							<legend class="legendofinscricaoM">Inscrição de monitores</legend>
							<div class="inscricaom centro1">
								<div class="abertofechado">
									<span><button class='btn btn-default' id="monitoresAbertas" href='#'target=''>Abertas</button></span>
									<span><button class='btn btn-default' id="monitoresFechadas" href='#'target=''>Fechadas</button></span>
								</div>
							</div>
						</div>
		
						<div class="form-group">
							<br>
							<legend class="legendofinscricaoM">Inscrição de alunos</legend>
							<div class="inscricaom centro1">
								<div class="abertofechado">
									<span><button class='btn btn-default' id="sistemaAbertas" href='#'target=''>Abertas</button></span>
									<span><button class='btn btn-default' id="sistemaFechadas" href='#'target=''>Fechadas</button></span>
								</div>
							</div>
						</div>
		</div>
	</div>
</body>
</html>
