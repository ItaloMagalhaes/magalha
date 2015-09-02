<div class='box'>
	<div class='box-header'>
		<i class='fa  fa-warning'></i>
		<h3 class='box-title'>Alertas</h3>
	</div><!-- /.box-header -->
	<div class='box-body '> 
		<div class="alert alert-danger alert-dismissable">
		    <i class="fa fa-warning"></i>
		    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		    <b>Alerta!</b> Os campos com * são obrigatórios.
		</div>
	</div>
</div>
<!-- Todo o Collpse fica dentro do formulário --> 
<form name="form" id="form1" class="form-horizontal" action="sistema.php?acao=atividade/cadastrarAtividade" method="POST">
	<div class='box'>
            <div class='box-header'>
                <i class='fa fa-tasks'></i>
              <h3 class='box-title'>Cadastro de Atividade</h3>
          	</div><!-- /.box-header -->
            <div class='box-body no-padding'>
				<div class="panel-body">
					<div class="form-group">
						<label for="nome" class="col-sm-2 control-label ">*Nome:</label>
						<div class="col-sm-4">
							<input type="text" id="nomeAluno" class="form-control texto-obrigatorio" name="nome" placeholder="Nome da Atividade"> 	
						</div>
						<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite o nome da atividade</strong></p></div>
					</div>
						
					<div class="form-group">
						<label for="horario" class="col-sm-2 control-label ">*Horário de início:</label>
						<div class="col-sm-2">
							<div class="input-group date" id="datepicker-horario-inicio">
								<input type="text" data-format="hh:mm" id="horarioInicio" class="form-control texto-obrigatorio hora" name="horarioInicio" class="form-control" data-mask="99:99" />
								<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
							</div>
						</div>
						<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite uma hora válida</strong></p></div>
					</div>
					
					<div class="form-group">
						<label for="horario" class="col-sm-2 control-label ">*Horário de término:</label>
						<div class="col-sm-2">
							<div class="input-group date" id="datepicker-horario-fim">
								<input type="text" data-format="hh:mm" id="horarioTermino" class="form-control texto-obrigatorio hora" name="horarioTermino" class="form-control" data-mask="99:99" />
								<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
							</div>
						</div>
						<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite uma hora válida</strong></p></div>
					</div>
					
					<div class="form-group">
						<label for="horario" class="col-sm-2 control-label ">*Carga horária:</label>
						<div class="col-sm-2">
							<input type="text" id="carga" class="form-control texto-obrigatorio campo-numerico" name="cargaHoraria" placeholder="carga"   > 
						</div>
						<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite a carga horária da atividade</strong></p></div>
					</div>
					
					<div class="form-group">
						<label for="data" class="col-sm-2 control-label ">*Data de Início:</label>
						<div class="col-sm-2">
							<div class="input-group date" id="datepicker-data-inicio">
								<input type="text" data-format="DD/MM/YYYY" id="dataInicio" name="dataInicio" class="form-control texto-obrigatorio data" data-mask="99/99/9999" />
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite uma data válida</strong></p></div>
					</div>
					
					<div class="form-group">
						<label for="data" class="col-sm-2 control-label ">*Data de Término:</label>
						<div class="col-sm-2">
							<div class="input-group date" id="datepicker-data-termino">
								<input type="text" data-format="DD/MM/YYYY" id="dataTermino" name="dataTermino" class="form-control texto-obrigatorio data" data-mask="99/99/9999" />
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite uma data válida</strong></p></div>
					</div>

					<div class="form-group">
						<label for="professor" class="col-sm-2 control-label ">*Proponente:</label>
						<div class="col-sm-4">
							<input type="text" id="preponente" class="form-control texto-obrigatorio" name="preponente" placeholder="Nome preponente"> 	
						</div>
						<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite o nome do preponente</strong></p></div>
					</div>
	
					<div class="form-group">
						<label for="local" class="col-sm-2 control-label ">*Local:</label>
						<div class="col-sm-4">
							<input type="text" id="local" class="form-control texto-obrigatorio" name="local" placeholder="Local"> 	
						</div>
						<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite o local da atividade</strong></p></div>
					</div>
										
					<div class="form-group">
						<label for="vagas" class="col-sm-2 control-label ">*Numero de vagas:</label>
						<div class="col-sm-1">
							<input type="text" id="vagas" class="form-control texto-obrigatorio campo-numerico" name="vagas" placeholder=""> 
						</div>
						<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite um número de vagas válido</strong></p></div>
					</div>
					
					<div class="form-group">
						<label for="descricao" class="col-sm-2 control-label ">*Descrição:</label>
						<div class="col-sm-6">
							<textarea  id="descricao" name="descricao" class="form-control texto-obrigatorio"></textarea>
						</div>
						<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite a descrição da atividade</strong></p></div>
					</div>

					<div class="form-group">
						<!-- <label for="tipo" class="col-sm-2 control-label">*Tipo:</label> -->
						<div class="col-sm-6">
							<input type="hidden" value="1" id="tipo" name="tipo">
						</div>
					</div>	
				</div><!-- Fim do Panel-Body -->
				<div class='box-footer no-padding'>
					<div class="panel-body">
						<div class="form-group">
							<div class="col-sm-offset-2	 col-sm-10 ">
								<button class="btn btn-grey1 pull-right" id="salvarAluno" type="submit">Salvar</button>
							</div>
						</div>
					</div>
				</div>
			</div><!-- Fim do Panel-Collapse -->
		</div><!-- Fim do Panel-Info -->

	</form>