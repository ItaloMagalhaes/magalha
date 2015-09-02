<div class='box'>
	<div class='box-header'>
		<i class='fa  fa-warning'></i>
		<h3 class='box-title'>Alertas</h3>
	</div><!-- /.box-header -->
	<div class='box-body '> 
		<div class="alert alert-danger alert-dismissable">
		    <i class="fa fa-warning"></i>
		    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		    <b>Alerta!</b> Caso não tenha realizado o cadastro ainda, <a href="sistema.php?acao=congressista/exibirFormulario" target="">clique aqui</a>.
		</div>
	</div>
</div>
<div class='box'>
    <div class='box-header'>
        <i class='fa  fa-key'></i>
		<h3 class='box-title'>Login</h3>
    </div><!-- /.box-header -->
    <div class='box-body '> 
		<form name="form" id="form1" class="form-horizontal" action="" method="POST" role="form">
		<div class="form-group">
			<label for="cpf" class="col-sm-2 control-label">*CPF:</label>
			<div class="col-sm-2">
				<input type="text" id="cpf"  class="form-control texto-obrigatorio" placeholder="xxx.xxx.xxx-xx" data-mask="999.999.999-99"/>	
			</div>
			<div class="col-sm-4">
				<p class="bg-danger msg-erro text-center oculta">Insira um CPF válido.</p>
			</div>
		</div>
		<div class="form-group">
			<label for="senha" class="col-sm-2 control-label">*Senha:</label>
			<div class="col-sm-2">
				<input type="password" class="form-control texto-obrigatorio" id="senha" placeholder="Senha">	
			</div>
			<div class="col-sm-4">
				<p class="bg-danger msg-erro text-center oculta">Insira a senha.</p>
			</div>
		</div>	

	<div class="box-footer">
		<div class="form-group">
			<div class="col-sm-offset-11 col-sm-1 ">
				<button class="btn btn-grey1" id="logar" type="button">Entrar</button>	
			</div>
		</div>
	</div>
	</form>
	</div>
</div>

<script language="javascript">
	$(document).ready(function(){ 
		$("#logar").click(function(e){
			e.preventDefault();
			$.post("sistema.php?acao=login/logar",{"login": $("#cpf").val(),"senha":$("#senha").val()},function(data){
				if(data.trim().length == 0){
					erro("Login e/ou senha inválidos!", " Erro");
					$("#cpf").val('');
					$("#senha").val('');
				}else {
					window.location = "sistema.php?acao=site/telaInicial";	
				}		

			});	

		});

	});	
</script> 