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
<form name="form" id="form1" class="form-horizontal" action="sistema.php?acao=adminGlobal/cadastrarTipoArtigo" method="POST">
	<div class='box'>
        <div class='box-header'>
            <i class='fa fa-file-text-o'></i>
          <h3 class='box-title'>Área do Artigo  </h3>
      	</div><!-- /.box-header -->
        <div class='box-body '>                
			<div class="form-group">
				<label for="nome" class="col-sm-2 control-label">*Área do artigo:</label>
				<div class="col-sm-4">
					<input type="text" id="nomeAluno" class="form-control texto-obrigatorio" name="nome" placeholder="Nome da área do artigo"> 	
				</div>
					<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite o nome do tipo do artigo!</strong></p></div>
			</div>
		</div><!-- Fim do Panel-Collapse -->
		<div class="box-footer">
		<div class="form-group">
			<div class="col-sm-offset-11 col-sm-1">
				<button class="btn btn-grey1 pull-right" id="salvarAluno" type="submit">Salvar</button>
			</div>		
		</div>
	</div>
</form>         