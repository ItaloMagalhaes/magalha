
	<form name="form" id="form" class="form-horizontal" method="POST" action="sistema.php?acao=adminGlobal/salvarValoresAdmGlobal" >
		<input type="hidden" name="idAdmGlobal" value="<?php echo $GLOBALS['info']['id_usuario']; ?>" />
		<div class='box'>
            <div class='box-header'>
                <i class='fa  fa-tasks'></i>
              <h3 class='box-title'>Editar Administrador Global</h3>
          	</div><!-- /.box-header -->
            <div class='box-body no-padding'>
				<div class="panel-body">
					
					<div class="form-group">
						<label for="nome" class="col-sm-2 control-label">Nome:</label>
						<div class="col-sm-3">
							<input type="text" id="nome" class="form-control texto-obrigatorio" name="nome"  value="<?php echo $GLOBALS['info']['nome']; ?>" placeholder="Nome">
						</div>
					</div>

					<div class="form-group">
						<label for="cpf" class="col-sm-2 control-label">Senha:</label>
						<div class="col-sm-2">
							<input type="password" id="senha" class="form-control texto-obrigatorio" name="senha"  value="<?php echo $GLOBALS['info']['senha']; ?>" placeholder="Senha">
						</div>
					</div>						
						
				</div><!-- Fim do Panel-Body -->

				<div class='box-footer no-padding'>
					<div class="panel-body">
						<div class="form-group">
							<div class="col-sm-offset-2	 col-sm-10 ">
								<button class="btn btn-grey1 pull-right" id="salvarAdmGlobal" type="submit">Salvar</button>
							</div>
						</div>
					</div>
				</div>
			</div><!-- Fim do Panel-Body -->
		</div><!-- Fim do Panel-Primary -->
		
    </form>         