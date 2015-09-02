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
<form name="form" id="form1" class="form-horizontal" action="sistema.php?acao=congressista/cadastrar" method="POST">
	<div class='box'>
        	<div class='box-header'>
            	<i class='fa  fa-user'></i>
          		<h3 class='box-title'>Cadastro Pessoal</h3>
     		</div><!-- /.box-header -->
        	<div class='box-body '> 
				<div class="form-group">
					<label for="nome" class="col-sm-2 control-label">*Nome:</label>
					<div class="col-sm-4">
						<input type="text" id="nome" class="form-control texto-obrigatorio" name="nome" placeholder="Seu nome"> 	
					</div>
					<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta"><strong>Digite seu nome</strong></p></div>
				</div>
				
				<div class="form-group">
					<label for="data" class="col-sm-2 control-label  ">*Data de Nascimento:</label>
					<div class="col-sm-2">
						<div class="input-group date" id="datepicker-data-nascimento">
							<input type="text" data-format="DD/MM/YYYY" id="data_nascimento" name="data_nascimento" class="form-control data texto-obrigatorio" data-mask="99/99/9999" />
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</div>
					<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">Data de nascimento inválida</p></div>
				</div>
				
				<div class="form-group"> 
					<label for="sexo"  class="col-sm-2 control-label ">*Sexo:</label>	
					<div class="col-sm-4">
						<label class="radio-inline">
							<input type="radio" name="sexo" id="sexo" value="Masculino">Masculino
						</label>
						<label class="radio-inline" >
							<input type="radio" name="sexo"  id="sexo" value="Feminino">Feminino
						</label>	
					</div>
					<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">Selecione um sexo</p></div>
				</div>

				<div class="form-group">
					<label for="CPF" class="col-sm-2 control-label ">*CPF:</label>
					<div class="col-sm-2">
						<input type="text" id="cpf" name="cpf" class="form-control texto-obrigatorio" placeholder="xxx.xxx.xxx-xx" data-mask="999.999.999-99" />
					</div>
					<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">Insira um CPF válido.</p></div>
				</div>	
			
				<!-- Select Basic -->
				<div class="form-group">
				  <label class="col-md-2 control-label " for="escolaridades">*Escolaridade</label>
				  <div class="col-sm-4">
					<select id="escolaridade" name="escolaridade" class="form-control texto-obrigatorio">
					  <option value="">Selecione a escolaridade</option>	
					  <option value="Primário incompleto">Primário incompleto</option>
					  <option value="Primário completo">Primário completo</option>
					  <option value="Fundamental incompleto">Fundamental incompleto</option>
					  <option value="Fundamental completo"> Fundamental completo</option>
					  <option value="Médio incompleto">Médio incompleto</option>
					  <option value="Médio completo">Médio completo</option>
					  <option value="Superior incompleto">Superior incompleto</option>
					  <option value="Superior completo">Superior completo</option>
					</select>
				  </div>
				</div>
				<div class="form-group">
				  <label class="control-label col-xs-2" for="uf" >*Camisa</label>
			      <div class="col-xs-2">
				  	<select id="camisa" name="camisa" class="form-control" >
				      <option selected></option>
				      <option value="blP">  Baby Look P </option>
				      <option value="blM"> Baby Look M</option>
				      <option value="blG"> Baby Look G</option>
	   			      <option value="blGG"> Baby Look GG</option>
					  <option value="cmP">  Camisa P </option>
				      <option value="cmM"> Camisa M</option>
				      <option value="cmG"> Camisa G</option>
	   			      <option value="cmGG"> Camisa GG</option>
			    	</select>
			  </div>
		</div>

				
				</div><!-- Fim do Panel-Body -->
		</div><!-- Fim do Panel-Collapse -->
	</div><!-- Fim do Panel-Info -->
		<div class='box'>
        	<div class='box-header'>
            	<i class='fa  fa-road'></i>
          		<h3 class='box-title'>Cadastro de endereço</h3>
     		</div><!-- /.box-header -->
        	<div class='box-body '> 
				<div class="form-group" >
					<label  for="logradouro" class=" col-sm-2 control-label ">*Logradouro:</label>
					<div class="col-sm-4">
						<input type="text" id="rua" name="rua" class="form-control texto-obrigatorio" placeholder="Insira o endereço" />	
					</div>
					<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">Insira o seu logradouro</p></div>
				</div>

				<div class="form-group">
					<label for="numero" class="col-sm-2 control-label ">*Numero:</label>
					<div class="col-sm-1">
						<input type="text"  id="numero" name="numero" class="form-control texto-obrigatorio campo-numerico" maxlength="6"/>	
					</div>
					<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">Insira o número da sua residência.</p></div>
				</div>
				
				<div class="form-group">
					<label for="complemento" class="col-sm-2 control-label ">Complemento :</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="complemento" name="complemento" maxlength="10" />	
					</div>
				</div>
				
				<div class="form-group">
					<label for="bairro" class="col-sm-2 control-label ">*Bairro:</label>
					<div class="col-sm-4">
						<input type="text" id="bairro" name="bairro" placeholder="Seu bairro" class="form-control texto-obrigatorio" />	
					</div>
					<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">Insira o bairro da sua residência</p></div>
				</div>

				<div class="form-group">
					<label for="cidade" class="col-sm-2 control-label ">*Cidade:</label>
					<div class="col-sm-4">
						<input type="text" id="cidade" name="cidade" placeholder="Sua cidade"  class="form-control texto-obrigatorio"/>	
					</div>
					<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">Insira a cidade da sua residência.</p></div>
				</div>
				
				<div class="form-group">
					<label for="estado" class="col-sm-2 control-label ">*Estado:</label>
					<div class="col-sm-4">
						<select id="estado"  name="estado" class="form-control texto-obrigatorio">
							<option value="">Selecione um Estado</option>
							<option value="AC">AC</option>
							<option value="AL">AL</option>
							<option value="AP">AP</option>
							<option value="AM">AM</option>
							<option value="BA">BA</option>
							<option value="CE">CE</option>
							<option value="ES">ES</option>
							<option value="DF">DF</option>
							<option value="MA">MA</option>
							<option value="MT">MT</option>
							<option value="MS">MS</option>
							<option value="MG">MG</option>
							<option value="PA">PA</option>
							<option value="PB">PB</option>
							<option value="PR">PR</option>
							<option value="PE">PE</option>
							<option value="PI">PI</option>
							<option value="RJ">RJ</option>
							<option value="RN">RN</option>
							<option value="RS">RS</option>
							<option value="RO">RO</option>
							<option value="RR">RR</option>
							<option value="SC">SC</option>
							<option value="SP">SP</option>
							<option value="SE">SE</option>
							<option value="TO">TO</option>
						</select>
					</div>
					<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">Selecione o estado onde você nasceu</p></div>
				</div>
				
				<div class="form-group">
					<label for="cep" class="col-sm-2 control-label ">*CEP:</label>
					<div class="col-sm-2">
						<input type="text"  id="cep" class="form-control cep texto-obrigatorio" name="cep" placeholder="Insira seu CEP" data-mask="99.999-999"/>	
					</div>
					<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">Insira o CEP da sua residência</p></div>
				</div>
				
				<div class="form-group">
					<label for="telefone" class="col-sm-2 control-label ">*Telefone:</label>
					<div class="col-sm-2">
						<input type="text" id="telefone" class="form-control tel texto-obrigatorio" name="telefone" placeholder="(00)0000-0000" data-mask="(99)9999-9999"/>
					</div>
					<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">Insira um telefone para contato</p></div>
				</div>	
			</div><!-- Fim Panel-Body -->
		</div><!-- Fim Panel-Collpse -->
	</div><!-- Fim Panel-default -->
	<div class='box'>
        <div class='box-header'>
            <i class='fa  fa-key'></i>
			<h3 class='box-title'>Cadastro de Acesso</h3>
		</div><!-- /.box-header -->
    	<div class='box-body '> 
			<div class="form-group">
				<label for="confirmacao" class="col-sm-2 control-label ">*E-mail:</label>
				<div class="col-sm-4">
					<input type="email"  id="email" class="form-control texto-obrigatorio" name="email" placeholder="email@exemplo.com.br"/>	
				</div>
				<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">Insira um e-mail válido</p></div>
			</div>
				
			<div class="form-group">
				<label for="confirmacao" class="col-sm-2 control-label ">*Confirmação E-mail:</label>
				<div class="col-sm-4">
					<input type="email"  id="confirmacao-email" class="form-control texto-obrigatorio" name="confirmacao-email" placeholder="email@exemplo.com.br" />	
				</div>
				<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">O E-mail de confirmação deve ser igual ao E-mail informado anteriormente.</p></div>
			</div>
			<div class="form-group">
				<label for="senha" class="col-sm-2 control-label ">*Senha</label>
				<div class="col-sm-2">
					<input type="password" class="form-control texto-obrigatorio" id="senha" name="senha" placeholder="Senha">
				</div>	
				<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">Insira uma senha.</p></div>					 
			</div>	
			<div class="form-group">
				<label for="confirmasenha" class="col-sm-2 control-label ">*Confirmação de Senha</label>
				<div class="col-sm-2">
					<input type="password" class="form-control texto-obrigatorio" id="confirmacao-senha" name="confirmacao-senha" placeholder="Confirmação Senha">
				</div>							 
				<div class="col-sm-4"><p class="bg-danger msg-erro text-center oculta">A confirmação de senha deve ser igual a senha.</p></div>					 
			</div>	
		</div>	
	</div><!-- Fim Panel-Body -->
	<div class='box-footer'>	
	<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10 ">
			<button class="btn btn-grey1 pull-right" id="salvarAluno" type="submit">Salvar</button>	
			</div>
		</div>
	</div>	
</form>  