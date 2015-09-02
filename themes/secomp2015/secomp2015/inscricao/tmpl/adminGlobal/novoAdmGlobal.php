<div class='box'>
	<div class='box-header'>
		<i class='fa  fa-warning'></i>
		<h3 class='box-title'>Alertas</h3>
	</div><!-- /.box-header -->
	<div class='box-body '> 
		<div class="alert alert-danger alert-dismissable">
		    <i class="fa fa-warning"></i>
		    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		    <b>Alerta!</b> Os campos com (*), são obrigatórios.
		</div>
	</div>
</div>	
<!-- Todo o Collpse fica dentro do formulário --> 
<form name="form" id="form1" class="form-horizontal" action="sistema.php?acao=adminGlobal/cadastrarAdmGlobal" method="POST">
	<div class='box'>
            <div class='box-header'>
                <i class='fa  fa-cogs'></i>
              <h3 class='box-title'>Cadastro de Administrador Global</h3>
          	</div><!-- /.box-header -->
            <div class='box-body no-padding'>
				<div class="panel-body">
					<div class="form-group">
						<label for="nome" class="col-sm-2 control-label">*Nome:</label>
						<div class="col-sm-4">
							<input type="text" id="nome" class="form-control texto-obrigatorio" name="nome" placeholder="Nome"> 	
						</div>
						<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite o nome do administrador</strong></p></div>
					</div>

					<div class="form-group">
						<label for="cpf" class="col-sm-2 control-label">*CPF:</label>
						<div class="col-sm-4">
							<input type="text" id="cpf" class="form-control texto-obrigatorio" data-mask="999.999.999-99" name="cpf" placeholder="CPF"> 	
						</div>
						<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite um cpf válido</strong></p></div>
					</div>

					<div class="form-group">
						<label for="senha" class="col-sm-2 control-label">*Senha:</label>
						<div class="col-sm-4">
							<input type="password" id="senha" class="form-control texto-obrigatorio" name="senha" placeholder="Senha"> 	
						</div>
						<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite a senha do administrador</strong></p></div>
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
	</div>
</form> 