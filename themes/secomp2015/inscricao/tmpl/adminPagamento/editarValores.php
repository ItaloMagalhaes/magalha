
	<form name="form" id="form" class="form-horizontal" method="POST" action="sistema.php?acao=adminPagamento/salvarValores" >
		<input type="hidden" name="codigoAtividade" value="<?php echo $GLOBALS['info']['id_oficina']; ?>" />
		<div class='box'>
    		<div class='box-header'>
        		<i class='fa  fa-money'></i>
				<h3 class='box-title'>Editar Valores</h3>
    		</div><!-- /.box-header -->
    		<div class='box-body '> 
				<div class="form-group">
					<label for="valorPadrao" class="col-sm-2 control-label">Valor Padrão:</label>
					<div class="col-sm-2">
						<input type="number" id="valorPadrao" class="form-control texto-obrigatorio campo-numerico" name="valorPadrao"  value="<?php echo $GLOBALS['info']['valorPadrao']; ?>" placeholder="Valor Padrao">						
					</div>
					<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">Digite somente números neste campo.</p></div>
				</div>

				<div class="form-group">
					<label for="acrescimo" class="col-sm-2 control-label">Acrescimo:</label>
					<div class="col-sm-2">
						<input type="number" id="acrescimo" class="form-control texto-obrigatorio campo-numerico" name="acrescimo"  value="<?php echo $GLOBALS['info']['acrescimo']; ?>" placeholder="Acréscimo">						
					</div>
					<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">Digite somente números neste campo.</p></div>
				</div>
			</div>
			<div class="box-footer">
				<div class="form-group">
					<div class="col-sm-offset-11	 col-sm-1 ">
						<button class="btn btn-grey1 pull-right" id="salvarAluno" type="submit">Salvar</button>
					</div>
				</div>
			</div>
		</div><!-- Fim do Panel-Body -->
		
    </form>         