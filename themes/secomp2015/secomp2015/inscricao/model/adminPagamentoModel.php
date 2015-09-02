<?php

require ('model/model.php');

/**
 * adminPagamentoModel
 *
 * Metodos de acesso ao banco
 *
 **/

class adminPagamentoModel extends Model{
	 /**
     * alunoController::telaInicial()
     *
     * Exibe alguma tela dada como padrão.
     *
     */
    public function listarParticipantesPendentes(){
        
		/*
			Nesse caso, monta-se o menu a ser exibido.
		*/
		$sql = "SELECT c.id_congressista, c.nome, c.cpf
			    FROM congressista as c 			   
			   	WHERE c.pagamento = 0
			   	ORDER BY c.nome
			   	ASC LIMIT 10";
		$result = $this->query($sql);
		return ($result);
    }

    public function listarParticipantesPagos(){
        
		/*
			Nesse caso, monta-se o menu a ser exibido.
		*/
		$sql = "SELECT c.id_congressista, c.nome, c.cpf 
			    FROM congressista as c
			   	WHERE c.pagamento = 1
			   	ORDER BY c.nome
			   	ASC LIMIT 10";
		$result = $this->query($sql);
		return ($result);
    }

    public function setarPagamento($id){
    	$sql = "UPDATE pagamento
    	SET status = 1
    	WHERE fid_congressista = '".$id."'";
		$result = $this->query($sql);
		if ($result == 1) {
			$sql = "UPDATE congressista
	    	SET pagamento = 1
	    	WHERE id_congressista = '".$id."'";
			$result = $this->query($sql);
		}
		return ($result);
    }

    public function removerPagamento($id){
    	$sql = "UPDATE pagamento
    	SET status = 0
    	WHERE fid_congressista = '".$id."'";
		$result = $this->query($sql);
		if ($result == 1) {
			$sql = "UPDATE congressista
	    	SET pagamento = 0
	    	WHERE id_congressista = '".$id."'";
			$result = $this->query($sql);
		}
		return ($result);
    }

    public function listarParticipantesPendentesFiltro(){
		
		/* Verifica os filtros. */
		$cpf = $this->get('cpf');
		$congressista = $this->get('congressista');
		$limite = $this->get('limite');
		
			$sql = "SELECT c.id_congressista, c.nome, c.cpf 
			    FROM congressista as c
			   	WHERE c.pagamento = 0			   	
			   	AND c.cpf LIKE '%".$cpf."%'
			   	AND c.nome LIKE '%".$congressista."%'
			   	GROUP BY c.id_congressista
			   	ORDER BY c.nome ASC 
			   	LIMIT ".$limite;
			
		$result = $this->query($sql);
		
		return $result;		
	}

	public function listarParticipantesPagosFiltro(){
		
		/* Verifica os filtros. */
		$cpf = $this->get('cpf');
		$congressista = $this->get('congressista');
		$limite = $this->get('limite');
		
			$sql = "SELECT c.id_congressista, c.nome, c.cpf 
			    FROM congressista as c
			   	WHERE c.pagamento = 1
			   	AND c.cpf LIKE '%".$cpf."%'
			   	AND c.nome LIKE '%".$congressista."%'
			   	GROUP BY c.id_congressista
			   	ORDER BY c.nome ASC
			   	LIMIT ".$limite;
			
		$result = $this->query($sql);
		
		return $result;		
	}

	public function editarValores() {

		$valorPadrao = $this->post("valorPadrao");
		$acrescimo = $this->post("acrescimo");
		$sql = "UPDATE config_sistema
    	SET valor_padrao = '".$valorPadrao."',
    	acrescimo = '".$acrescimo."'";
		$result = $this->query($sql);
		return ($result);
	}

	public function buscarValoresAtuais() {

		$sql = "SELECT * FROM config_sistema";
		$result = $this->query($sql);
		return ($result);
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
	public function recuperaLinhasUsuarios(){
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
	public function recuperaLinhasPagamento(){
		$tabela ="admin_pagamento";
		$dados = "*";
		$condicao ="";
		$result = $this->select($tabela, $dados, $condicao);
		return mysql_num_rows($result);
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
	public function selecionarCongressista($id){
        
		/*
			Nesse caso, monta-se o menu a ser exibido.
		*/
		$sql = "SELECT c.nome, c.email
			    FROM congressista AS c 
			   	WHERE c.id_congressista = '".$id."'";
		$result = $this->query($sql);
		return ($result);
    }

    public function buscarValorPendente(){

       	$id = $this->get('id');
		$sql = "SELECT a.nome, a.preco
			    FROM atividades as a
			    INNER JOIN participante_atividade as pa
			    ON a.id_atividade = pa.fid_atividade
			   	WHERE ((pa.fid_congressista = '".$id."') AND (pa.fila_de_espera = 0))";
		$result = $this->query($sql);
		return ($result);
    }
}
?>
