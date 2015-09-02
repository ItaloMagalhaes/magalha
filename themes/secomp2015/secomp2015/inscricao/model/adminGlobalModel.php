<?php

require ('model/model.php');

/**
 * adminGlobalModel
 *
 * Metodos de acesso ao banco
 *
 **/

class adminGlobalModel extends Model{

	public function salvar(){
		$nome = $this->post("nome");
		$campos = "(nome)";		
		$valores = "('".$nome."')";		
		$tabela = "areas_artigos";
		
		if($this->insert( $tabela, $campos, $valores )){
			return 1;
		}else{
			return 0;
		}
	}

	public function salvarAdmPagamento() {

		$nome = $this->post("nome");
		$cpf = $this->post("cpf");
		$senha = md5($this->post("senha"));
		$retorno = $this->verificarCPF($cpf);
		if ($retorno == 4) {
			return 2;
			exit;
		}
		$sql = "INSERT INTO usuarios
    	(login, senha, tipo)
    	VALUES ('".$cpf."', '".$senha."', 2)";
		$result = $this->query($sql);
		if ($result == 1) {
			$dados = "id_usuario";
			$condicao = "login = '".$cpf."'";
			$result = $this->select('usuarios', $dados, $condicao);		
			$result = mysql_fetch_array($result);
			$fidUsuario = $result['id_usuario'];
			$sql = "INSERT INTO admin_pagamento
    			(nome, cpf, fid_usuario)
    			VALUES ('".$nome."', '".$cpf."', '".$fidUsuario."')";
	    	$result = $this->query($sql);
	    }
		return ($result);
	}

	public function verificarCPF($cpf) {

		$tabela = "admin_pagamento";
		$dados = "cpf";
		$condicao = "cpf = '".$cpf."'";
		
		$result = $this->select($tabela, $dados, $condicao);
		
		/*
		    Verifica se encontrou algum resultado com esse cpf
		    0 -> não cadastrado
		    1 -> já cadastrado
		*/
		
		if(mysql_num_rows($result) == 0){
			return 5;
		}else {
			return 4;
		}
	}

	public function recuperaStatus(){
		$tabela ="config_sistema";
		$dados = "*";
		$condicao ="";
		$result = $this->select($tabela, $dados, $condicao);
		$linha = mysql_fetch_array($result);
		$retorno = $linha['status_aluno'];
		return $retorno;
	}

	public function recuperaValorPadrao(){
		$tabela ="config_sistema";
		$dados = "*";
		$condicao ="";
		$result = $this->select($tabela, $dados, $condicao);
		$linha = mysql_fetch_array($result);
		$retorno = $linha['valor_padrao'];
		return $retorno;
	}
	
	public function recuperaLinhasUsuarios() {
		$tabela ="usuarios";
		$dados = "*";
		$condicao ="";
		$result = $this->select($tabela, $dados, $condicao);
		return mysql_num_rows($result);
	}
	
	public function recuperaQtdPagamentoTotais($valorPadrao) {
		$sql = "SELECT c.id_congressista, c.nome 
			    FROM congressista as c";
		$resultado = $this->query($sql);
		$total = $valorPadrao * mysql_num_rows($resultado);
		while($linha = mysql_fetch_array($resultado)){
			$sql2 = "SELECT p.preco FROM pagamento AS p
					INNER JOIN participante_atividade AS pa
					ON pa.id_relacao_inscrito_atividade = p.fid_participante_atividade
					WHERE ((pa.fid_congressista = '".$linha['id_congressista']."') AND (pa.fila_de_espera = 0))";
			$resultado2 = $this->query($sql2);
			$flag = false;
			while($linha2 = mysql_fetch_array($resultado2)){
				if ($flag == true) {
					$total += $linha2['preco'];
				} else {
					$flag = true;
				}
			}
		}
		return $total;
	}

	public function recuperaLinhasPagamento() {
		$tabela ="admin_pagamento";
		$dados = "*";
		$condicao ="";
		$result = $this->select($tabela, $dados, $condicao);
		return mysql_num_rows($result);
	}
	
	public function verificaEstadoSistema() {
		
		$dados = "status_aluno";
		$tabela = "config_sistema";
		$result = $this->select($tabela, $dados);
		return $result;	
	}

	public function abrirInscricoes() {
		$set = "status_aluno = 1";
		$tabela = "config_sistema";
		$condicao = "1";

		if ($this->update($tabela,$set,$condicao)){
			return 1;
		}else{
			return 0;
		}
	}

	public function fecharInscricoes(){
		$set = "status_aluno = 0";
		$tabela = "config_sistema";
		$condicao = "1";
		if ($this->update($tabela,$set,$condicao)){
			return 1;
		}else{
			return 0;
		}
	}

	public function listagemAdmPagamento(){
		$sql = "SELECT u.id_usuario, a.nome, u.login, u.senha, a.cpf
		FROM usuarios as u INNER JOIN admin_pagamento as a
		ON u.id_usuario = a.fid_usuario
		WHERE tipo = 2 ORDER BY id_usuario ASC LIMIT 10";
		$result = $this->query($sql);
		return ($result);
	}

	public function recurperaQtdCong(){
		$sql = "SELECT * FROM congressista";
		$result = $this->query($sql);
		return mysql_num_rows($result);
	}
	
	public function recurperaQtdAtividades(){
		$sql = "SELECT * FROM atividades";
		$result = $this->query($sql);
		return mysql_num_rows($result);
	}

	public function recuperaQtdPagamentoEfetuados($valorPadrao){
		$sql = "SELECT c.id_congressista, c.nome 
			    FROM congressista as c
			   	WHERE c.pagamento = 1";
		$resultado = $this->query($sql);
		$total = $valorPadrao * mysql_num_rows($resultado);
		while($linha = mysql_fetch_array($resultado)){
			$sql2 = "SELECT p.preco FROM pagamento AS p
					INNER JOIN participante_atividade AS pa
					ON pa.id_relacao_inscrito_atividade = p.fid_participante_atividade
					WHERE ((pa.fid_congressista = '".$linha['id_congressista']."') AND (pa.fila_de_espera = 0))";
			$resultado2 = $this->query($sql2);
			$flag = false;
			while($linha2 = mysql_fetch_array($resultado2)){
				if ($flag == true) {
					$total += $linha2['preco'];
				} else {
					$flag = true;
				}
			}
		}
		return $total;
	}

	public function selecionarAdmPagamento($id){
		$sql = "SELECT a.nome, u.senha, u.id_usuario, u.login
		FROM usuarios as u INNER JOIN admin_pagamento as a
		ON u.id_usuario = a.fid_usuario
		WHERE tipo = 2 AND a.fid_usuario = '".$id."' 
		ORDER BY id_usuario ASC";
		$result = $this->query($sql);
		return ($result);
	}

	public function listagemAdmPagamentoFiltro(){

		$cpf = $this->get('cpf');
		$nome = $this->get('nome');
		$limite = $this->get('limite');
		$sql = "SELECT a.nome, u.id_usuario, a.cpf
		FROM usuarios as u INNER JOIN admin_pagamento as a
		ON u.id_usuario = a.fid_usuario
		WHERE tipo = 2
		AND a.cpf LIKE '%".$cpf."%'
	   	AND a.nome LIKE '%".$nome."%'
	   	ORDER BY a.nome ASC LIMIT ".$limite;
		$result = $this->query($sql);
		return ($result);
	}

	public function editarValoresAdmPagamento() {

		$nome = $this->post("nome");
		$senha = md5($this->post("senha"));
		$id = $this->post("idAdmPagamento");
		$sql = "UPDATE usuarios
    	SET senha = '".$senha."'
    	WHERE id_usuario = '".$id."'
    	";
		$result = $this->query($sql);
		if ($result == 1) {
			$sql = "UPDATE admin_pagamento
	    		SET nome = '".$nome."'
	    		WHERE fid_usuario = '".$id."'";
	    	$result = $this->query($sql);
	    }
		return ($result);
	}

	public function excluirAdmPagamento($id) {

		$id = $this->get("id");
		$sql = "DELETE FROM usuarios
    	WHERE id_usuario = '".$id."'
    	";
		$result = $this->query($sql);
		if ($result == 1) {
			$sql = "DELETE FROM admin_pagamento
    			WHERE fid_usuario = '".$id."'";
	    	$result = $this->query($sql);
	    }
		return ($result);
	}

	public function rodarFilaDeEspera(){

		// Setando a ultima data que foi rodada a fila de espera
		$data = date("Y-m-d");
		$tabela = "config_sistema";
		$set = "ultima_data_fila = '".$data."'";
		$condicao = "";
		$this->update($tabela, $set, $condicao);
						
		$tabela = "atividades";
		$dados = "*";
		
		$tabelaResult = "<TABLE BORDER='1' class=\"table table-striped table-borded\">
							<CENTER>
							<TR>
								<TD><div class=\"tituloFiladeEspera\" align=\"left\">OFICINAS</div></TD>
								<TD><div class=\"tituloFiladeEspera\" align=\"left\">Nº DE PARTICIPANTES NA FILA DE ESPERA ATUALMENTE</div></TD>
								<TD><div class=\"tituloFiladeEspera\" align=\"left\">Nº DE PARTICIPANTES CHAMADOS</div></TD>
							</TR>";

		$resultadoSql = $this->select($tabela, $dados);
		
		while($linha = mysql_fetch_object($resultadoSql)){
			$tabela = "pagamento";
			$dados = "*";
			$condicao = "fid_atividade = ".$linha->id_atividade." and status = 1";
			$participantesConfirmados = mysql_num_rows($this->select($tabela, $dados, $condicao));
			
			$numeroDeVagasOciosas = $linha->n_vagas - $participantesConfirmados;
			$cont = 0;
			$tabela = "participante_atividade";
			$dados = "*";
			$condicao = "fid_atividade = ".$linha->id_atividade." and fila_de_espera = 1";
			$order = "id_relacao_inscrito_atividade ASC";
			$group = "";
			$participantesFila = $this->select($tabela, $dados, $condicao, $group, $order);
			$qntdeNaFila = mysql_num_rows($participantesFila);
	
			
			while (($linha1 = mysql_fetch_array($participantesFila)) && ($cont < $numeroDeVagasOciosas)){
				
				$data = date("Y-m-d");
				$tabela = "participante_atividade";
				$set = "fila_de_espera = '0', data_chamada_fila = '".$data."'";
				$condicao = "id_relacao_inscrito_atividade = ".$linha1["id_relacao_inscrito_atividade"];
				$this->update($tabela, $set, $condicao);

				$tabela = "congressista";
				$dados = "nome, email, cidade, estado";
				$condicao = "id_congressista = ".$linha1["fid_congressista"];
				$result = $this->select($tabela, $dados, $condicao);
				$aluno = mysql_fetch_object($result);
				
				//enviarenviarEmail
				$this->gerarBoletoDaFila($linha1["id_relacao_inscrito_atividade"]);
				
				$cont = $cont + 1;		
			}
			
			
			if ($cont > 1){
				$cont = $cont - 1;
			}
			
			
			$qntdeNaFila = $qntdeNaFila - $cont;

			
			$tabelaResult = $tabelaResult."<TR>
												<TD>".$linha->nome."</TD>
												<TD>".$qntdeNaFila."</TD>
												<TD>".$cont."</TD>
											</TR>
										</CENTER>";
		}
		$tabelaResult = $tabelaResult."</TABLE>";		
		return $tabelaResult;
	}


	/**
     * adminGlobalModel::verificarSeRodaFila()
     *
     * Verifica se pode rodar a fila ou não
     * 
     * Autoras: Isabella Vieira e Mônica Neli
     *
     */
    public function verificarSeRodaFila() {
		
		date_default_timezone_set("Brazil/East");
        
        $tabela = "config_sistema";
        $dados = "ultima_data_fila";
        $dataFila = $this->select($tabela, $dados);
        $data = mysql_fetch_object($dataFila);          // Data da ultima vez que a fila foi rodada
        $dataAtual = date("Y-m-d");                     // data do servidor

        if ($dataAtual == $data->ultima_data_fila)  return 1;           // nao pode rodar a fila
        else return 0;                                  // pode rodar a fila
    }

	public function listagemAdmGlobal(){
		$sql = "SELECT u.id_usuario, a.nome, u.login, u.senha, a.cpf
		FROM usuarios as u INNER JOIN admin_global as a
		ON u.id_usuario = a.fid_usuario
		WHERE tipo = 1 ORDER BY id_usuario ASC LIMIT 10";
		$result = $this->query($sql);
		return ($result);
	}

	public function listagemAdmGlobalFiltro(){

		$cpf = $this->get('cpf');
		$nome = $this->get('nome');
		$limite = $this->get('limite');
		$sql = "SELECT a.nome, u.id_usuario, a.cpf
		FROM usuarios as u INNER JOIN admin_global as a
		ON u.id_usuario = a.fid_usuario
		WHERE tipo = 1
		AND a.cpf LIKE '%".$cpf."%'
	   	AND a.nome LIKE '%".$nome."%'
	   	ORDER BY a.nome ASC LIMIT ".$limite;
		$result = $this->query($sql);
		return ($result);
	}

	public function salvarAdmGlobal() {

		$nome = $this->post("nome");
		$cpf = $this->post("cpf");
		$senha = md5($this->post("senha"));
		$retorno = $this->verificarCPF($cpf);
		if ($retorno == 4) {
			return 2;
			exit;
		}
		$sql = "INSERT INTO usuarios
    	(login, senha, tipo)
    	VALUES ('".$cpf."', '".$senha."', 1)";
		$result = $this->query($sql);
		if ($result == 1) {
			$dados = "id_usuario";
			$condicao = "login = '".$cpf."'";
			$result = $this->select('usuarios', $dados, $condicao);		
			$result = mysql_fetch_array($result);
			$fidUsuario = $result['id_usuario'];
			$sql = "INSERT INTO admin_global
    			(nome, cpf, fid_usuario)
    			VALUES ('".$nome."', '".$cpf."', '".$fidUsuario."')";
	    	$result = $this->query($sql);
	    }
		return ($result);
	}

	public function selecionarAdmGlobal($id){
		$sql = "SELECT a.nome, u.senha, u.id_usuario, u.login
		FROM usuarios as u INNER JOIN admin_global as a
		ON u.id_usuario = a.fid_usuario
		WHERE tipo = 1 AND a.fid_usuario = '".$id."'";
		$result = $this->query($sql);
		return ($result);
	}

	public function excluirAdmGlobal($id) {

		$id = $this->get("id");
		$sql = "DELETE FROM usuarios
    	WHERE id_usuario = '".$id."'
    	";
		$result = $this->query($sql);
		if ($result == 1) {
			$sql = "DELETE FROM admin_global
    			WHERE fid_usuario = '".$id."'";
	    	$result = $this->query($sql);
	    }
		return ($result);
	}

	public function editarValoresAdmGlobal() {

		$nome = $this->post("nome");
		$senha = md5($this->post("senha"));
		$id = $this->post("idAdmGlobal");
		$sql = "UPDATE usuarios
    	SET senha = '".$senha."'
    	WHERE id_usuario = '".$id."'
    	";
		$result = $this->query($sql);
		if ($result == 1) {
			$sql = "UPDATE admin_global
	    		SET nome = '".$nome."'
	    		WHERE fid_usuario = '".$id."'";
	    	$result = $this->query($sql);
	    }
		return ($result);
	}

	public function listagemAtividades(){
		$sql = "SELECT id_atividade, nome, nome_preponente, local
		FROM atividades ORDER BY nome ASC LIMIT 10";
		$result = $this->query($sql);
		return ($result);
	}

	public function listagemAtividadesFiltro(){
		$nome = $this->get('nome');
		$preponente = $this->get('preponente');
		$limite = $this->get('limite');
		$sql = "SELECT id_atividade, nome, nome_preponente, local
		FROM atividades
		WHERE nome LIKE '%".$nome."%'	
	   	AND nome_preponente LIKE '%".$preponente."%'
	   	ORDER BY nome ASC LIMIT ".$limite;
		$result = $this->query($sql);
		return ($result);
	}
}
?>