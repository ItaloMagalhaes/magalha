<?php

require ('model/model.php');

/**
 * homeModel
 *
 * Metodos de acesso ao banco
 *
 **/

class homeModel extends Model{
	
	/**
     * homeModel::selecionar()
     *
     * Seleciona os dados de adminComum do banco de dados.
     *
     */
    public function selecionar(){
        
		session_start();
		
		/*
			Nesse caso, monta-se o menu a ser exibido.
		*/
	}
	public function retornoQtdAtividadesTotais(){
		$dados = "*";
		$condicao = "";
		$tabela = "atividades";
		$resultado = $this->select($tabela,$dados,$condicao);
		return mysql_num_rows($resultado);
	}
	public function recuperaQtdAtividadesCadastradas($id){
		$tabela ="pagamento";
		$dados = "*";
		$condicao ="fid_congressista = '".$id."'";
		$result = $this->select($tabela, $dados, $condicao);
		return mysql_num_rows($result);
	}

	public function recuperaAtividades($id){
		$sql = "SELECT a.nome, p.status
			    FROM atividades as a 
			   	INNER JOIN pagamento as p
			   		ON a.id_atividade = p.fid_atividade
			   	WHERE p.fid_congressista = '".$id."'";
		
		$result = $this->query($sql);
		return ($result);
	}

	public function recuperaStatus1($id){
		$sql = "SELECT pagamento
			    FROM congressista
			   	WHERE id_congressista = '".$id."'";
		
		$result = $this->query($sql);
		return ($result);
	}
	
	/**
     * homeModel::salvar()
     *
     * Salva os dados de adminComum no banco de dados.
     *
     */
    public function salvar(){
        
		/*
			Receber dados vindos do formulario.
		*/

		$login = $this->post("login");
		$senha = $this->post("senha");
		$senha = md5($senha);
		$tipo = 2;

		/*
			Inserindo dados na tabela usuário.
		*/
		$campos = "(login,senha,tipo)";		
		$valores = "('".$login."','".$senha."','".$tipo."')";		
		$tabela = "usuarios";
		
		$this->insert( $tabela, $campos, $valores );	
		
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
	public function verificaEstadoSistema()
	{
		
		$dados = "status_aluno";
		$tabela = "config_sistema";
		

		$result = $this->select($tabela, $dados);
		
		return $result;	
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
	public function buscarValorPendente($id){

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
