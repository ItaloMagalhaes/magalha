<div class='box'>
    <div class='box-header'>
        <i class='fa  fa-key'></i>
		<h3 class='box-title'>Recuperar Senha</h3>
    </div><!-- /.box-header -->
    <div class='box-body'> 
		<form name="formRecuparaSenha" id="formRecuparaSenha" class="form-horizontal" action="sistema.php?acao=login/recSenha" method="POST" role="form">	
		<div class="form-group">
			<label for="cpf" class="col-sm-2 control-label">*CPF:</label>
			<div class="col-sm-2">
				<input type="text" id="cpf"  class="form-control texto-obrigatorio" placeholder="xxx.xxx.xxx-xx" data-mask="999.999.999-99"/>	
										</form>

			</div>
			<div class="col-sm-4">
				<p class="bg-danger msg-erro text-center oculta">Insira um CPF válido.</p>
			</div>
		</div>
	</div>
	<div class="box-footer">
		<div class="form-group">
			<div class="col-sm-offset-11 col-sm-1 ">
				<button class="btn btn-grey1" id="recuperar" type="button">Enviar</button>	

			</div>
		</div>
	</div>
</div>


