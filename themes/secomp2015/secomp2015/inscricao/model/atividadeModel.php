<?php

require ('model/model.php');

/**
 * atividadeModel
 *
 * Metodos de acesso ao banco
 *
 **/

class atividadeModel extends Model{
	
	/**
     * atividadeModel::selecionar()
     *
     * Seleciona os dados de atividade do banco de dados.
     *
     */
    public function selecionar(){
        
		session_start();
		
		/*
			Nesse caso, monta-se o menu a ser exibido.
		*/
	}
	
	public function recuperaId($id){
		$dados = "*";
		$condicao = "fid_usuario ='".$id."'";
		$tabela = "congressista";
		$resultado = $this->select($tabela,$dados,$condicao);
		$dado = mysql_fetch_array($resultado);
		$id = $dado['id_congressista'];
		return $id;
	}
	
	/**
     * atividadeModel::salvar()
     *
     * Salva os dados de atividade no banco de dados.
     *
     */
    public function salvar(){
        
		/*
			Receber dados vindos do formulario.
		*/

		$nome = $this->post("nome");
		$descricao = $this->post("descricao");
		$cargaHoraria = $this->post("cargaHoraria");
		$vagas = $this->post("vagas");
		$preponente = $this->post("preponente");
		$tipo = $this->post("tipo");
		$local = $this->post("local");
		$dataInicio = $this->post("dataInicio");
		$dataTermino = $this->post("dataTermino");
		$horarioInicio = $this->post("horarioInicio");
		$horarioTermino = $this->post("horarioTermino");
		
		$dataNova = explode("/", $dataInicio);
		$dataInicio = $dataNova[2]."-".$dataNova[1]."-".$dataNova[0];	//Data yyyy-mm-dd
		$dataNova = explode("/",$dataTermino);
		$dataTermino = $dataNova[2]."-".$dataNova[1]."-".$dataNova[0];	//Data yyyy-mm-dd
		/*
			Inserindo atividade.
		*/
		$campos = "(nome, n_vagas, nome_preponente, tipo, descricao, preco, local, data_inicio, data_termino, horario_inicio, horario_termino, carga_horaria)";		
		$valores = "('".$nome."','".$vagas."','".$preponente."','".$tipo."','".$descricao."', 15, '".$local."','".$dataInicio."','".$dataTermino."','".$horarioInicio."','".$horarioTermino."','".$cargaHoraria."')";	
		$tabela = "atividades";
		
		if ($this->insert( $tabela, $campos, $valores )){
			return 1;
		}else{
			return 0;
		} 
	}

	public function selecionarAtividadeFiltro(){
		
		/* Verifica os filtros. */
		$nome = $this->get('nome');
		$tipo = $this->get('tipo');
			
		$sql = "SELECT * from atividades WHERE nome LIKE '%".$nome."%' AND tipo LIKE '%".$tipo."%' ORDER BY data_inicio";


		$result = $this->query($sql);
		
		return $result;	
	}

	/**
     * atividadeModel::selecionarDadosAtividade()
     *
     * Recupera informaçoes sobre uma determinada atividade
     *
     */
    public function selecionarDadosAtividade($codigo_atividade){
        
		$sql = "SELECT a.* FROM atividades AS a
				WHERE a.id_atividade =".$codigo_atividade;
			   
		$resultado = $this->query($sql);
		return $resultado;
	}

	public function selecionarQuantPagamentos($codigo_atividade) {
		$sql = "SELECT * FROM participante_atividade
				WHERE fila_de_espera = 0 AND fid_atividade=".$codigo_atividade;
			   
		$resultado = $this->query($sql);	   
		return $resultado;
	}

	/**
     * atividadeModel::recuperaArea()
     *
     * Busca no banco todos as areas cadastradas no banco.
     *
     */
    public function recuperaArea(){
        
		$tabela = "areas";
		$dados = "nome, id_area";
		$order = "nome ASC";
		$condicao = "";
		$group = "";

		$resultadoSql = $this->select($tabela, $dados, $condicao, $group, $order);
		return $resultadoSql;
	}

	/**
     * atividadeModel::recuperaLocal()
     *
     * Busca no banco todos os locais cadastrados no banco.
     *
     */
    public function recuperaLocal(){
        
		$tabela = "local_atividade";
		$dados = "nome, id_data_local_atividade";
		$order = "nome ASC";
		$condicao = "";
		$group = "";

		$resultadoSql = $this->select($tabela, $dados, $condicao, $group, $order);
		return $resultadoSql;
	}
	
	
	/**
     * atividadeModel::obterDadosAtividade()
     *
     * Recupera informaçoes sobre uma determinada oficina
     *
     */
    public function obterDadosAtividade($codigo_atividade){
        
		$sql = "SELECT  o.n_vagas,o.data_termino, o.data_inicio, o.horario_inicio, o.horario_termino , COUNT(po.fid_atividade) AS total FROM atividades AS o
			   INNER JOIN participante_atividade AS po
					   ON o.id_atividade = po.fid_atividade
			   WHERE o.id_atividade =".$codigo_atividade;
			   
		$resultado = $this->query($sql);	   
		return $resultado;
	}
		
	/**
     * atividadeModel::listagematividades()
     *
     * Lista as atividades cadastradas com suas respectivas informações.
     *
     */
    public function listagematividades (){
		$tabela = "atividades";
		$dados = "*";
		$order = "nome ASC";
		$condicao = "";
		$group = "";

		$listaDeatividades = $this->select($tabela, $dados, $condicao, $group, $order);
		return $listaDeatividades;		
	}
	
	/**
     * atividadeController::listaratividades()
     *
     * Lista as atividades cadastradas de uma respectiva cidade.
     *
     */
    public function listarAtividade(){
		
		$result ="";	
		$query = "SELECT * FROM atividades ORDER BY data_inicio";
		
		$result = $this->query($query);
		return $result;
	}
	
	/**
     * atividadeModel::verificarHorario()
     *
     * Verifica se alguma atividade na sessão, bate horario com a atividade desejada.
     *
     */
    public function verificarHorario($codigo_atividade,$inicio,$termino,$data_inicio,$data_termino){
        
		$sql = "SELECT id_atividade, nome FROM atividades
				WHERE ('".$inicio."' BETWEEN horario_inicio AND horario_termino
				OR '".$termino."' BETWEEN horario_inicio AND horario_termino
				OR horario_inicio BETWEEN '".$inicio."' AND '".$termino ."'
				OR horario_termino BETWEEN '".$inicio."' AND '".$termino."') 
				AND ('".$data_inicio."' BETWEEN data_inicio AND data_termino
				OR '".$data_termino."' BETWEEN data_inicio AND data_termino 
				OR data_inicio BETWEEN '".$data_inicio."' AND '".$data_termino ."'
				OR data_termino BETWEEN '".$data_inicio."' AND '".$data_termino ."')
				AND id_atividade != '".$codigo_atividade."'";
		
		$resultado = $this->query($sql);	   
		return $resultado;
	}
	
	public function excluirAtividade($id){
		$tabela = "atividades";
		$condicao = "id_atividade = ".$id;
		
		if ($this->delete($tabela,$condicao)){
			return 1;
		}else{
			return 0;
		}
	}
		/**
     * atividadeModel::excluirParticipacaoAtividade()
     *
     * Verifica se alguma oficina na sessão, bate horario com a oficina desejada.
     *
     */
    public function excluirParticipacaoAtividade($codigo_atividade,$codigo_congressista){
		
		$sql1 = "SELECT id_relacao_inscrito_atividade FROM participante_atividade WHERE fid_congressista=".$codigo_congressista." AND fid_atividade=".$codigo_atividade;
		$resultado = $this->query($sql1);	   
		
		/*Nesse caso, o usuario pode ter marcado a oficina, mas ainda nao a tem salva*/
		if(mysql_num_rows($resultado) > 0){
			$dado = mysql_fetch_object($resultado);
			
			$sql2 = "DELETE FROM pagamento WHERE fid_participante_atividade=".$dado->id_relacao_inscrito_atividade;	   
			$result2 = $this->query($sql2);	   
			
			if($result2){
				$sql = "DELETE FROM participante_atividade WHERE id_relacao_inscrito_atividade=".$dado->id_relacao_inscrito_atividade;	   
				$resultado = $this->query($sql);	   
				return $resultado;
			}else return -1;
		}	
	}
	
	/**
     * atividadeModel::verificarPagamento()
     *
     * Verifica se aluno ja efetuou o pagamento da atividade.
     *
     */
    public function verificarPagamento($codigo_atividade,$codigo_congressista){
        
		$sql = "SELECT b.status FROM pagamento AS b INNER JOIN participante_atividade AS po 
		ON b.fid_participante_atividade = po.id_relacao_inscrito_atividade 
		WHERE b.status=1 AND po.fid_congressista=".$codigo_congressista." AND po.fid_atividade=".$codigo_atividade;	   
		$resultado = $this->query($sql);	   
		return $resultado;
	}	

	public function buscarDadoAtividade($codigoAtividade){
        
		$sql = "SELECT * 
				FROM atividades   
				WHERE atividades.id_atividade = '".$codigoAtividade."' ";
		$retorno = $this->query($sql);
		return ($retorno);		
	}
	public function alterarDadoAtividade(){
        /*
			Receber dados vindos do formulario.
		*/
		$codigoAtividade = $this->post("codigoAtividade");
		$nome = $this->post("nome");
		$cargaHoraria = $this->post("cargaHoraria");
		$horarioInicio = $this->post("horarioInicio");
		$horarioTermino = $this->post("horarioTermino");
		$local = $this->post("local");
		if($local == 1){
			$local = "Campus Santo Antônio";
		}else{
			$local = "SENAI";
		}
		$preponente = $this->post("preponente");
		$descricao = $this->post("descricao");
		$dataNova = explode("/", $this->post("dataInicio"));
		$dataInicio = $dataNova[2]."-".$dataNova[1]."-".$dataNova[0];	//Data yyyy-mm-dd
		$dataNova = explode("/", $this->post("dataTermino"));
		$dataTermino = $dataNova[2]."-".$dataNova[1]."-".$dataNova[0];	//Data yyyy-mm-dd
		$vagas = $this->post("vagas");
		$set = "nome = '".$nome."',horario_inicio ='".$horarioInicio."',horario_termino ='".$horarioTermino."',local ='".$local."',descricao ='".$descricao."',carga_horaria ='".$cargaHoraria."',nome_preponente ='".$preponente."',data_inicio ='".$dataInicio."',data_termino ='".$dataTermino."',n_vagas ='".$vagas."'";
		$tabela = "atividades";
		$condicao = "id_atividade = '".$codigoAtividade."' ";
		$this->update($tabela,$set,$condicao);
		$set = "fila_de_espera = 0";
		$tabela = "participante_atividade";
		$condicao = "fid_atividade = '".$codigoAtividade."' ORDER BY data_cadastro,id_relacao_inscrito_atividade LIMIT ".$vagas;
		if ($this->update($tabela,$set,$condicao)){
			return 1;
		}else{
			return 0;
		}
	}

	public function imprimirAtividades(){
		if (!isset( $_SESSION )) {
			session_start();
		}
		$idCongressista = $_SESSION['id_congressista'];
		$sql = "SELECT po.*, o.nome, o.horario_inicio, o.horario_termino, o.data_inicio, a.cpf AS atividades, b.status
				FROM participante_atividade AS po 
				INNER JOIN congressista AS a 
					ON po.fid_congressista = a.id_congressista  
				INNER JOIN atividades AS o
					ON po.fid_atividade = o.id_atividade
				INNER JOIN pagamento AS b 
					ON b.fid_participante_atividade = po.id_relacao_inscrito_atividade
				WHERE a.id_congressista = '".$idCongressista."'
					ORDER BY o.data_inicio, o.horario_inicio";
		
		$retorno = $this->query($sql);
		$i = 0;
		while ($dados = mysql_fetch_array($retorno)) {
			if ($dados["status"] == 1){$pagamento = "Confirmado";}else{$pagamento = "Pendente";}
            if ($dados["fila_de_espera"] == 0) $matriculado = "Matriculado"; else $matriculado = "Fila de espera";
            

			$vetor[$i][0] = $dados['nome']; // nome da oficinas
			$vetor[$i][1] = $this->converterDataTela($dados['data_inicio']); // numero de vagas na oficina
			$vetor[$i][2] = date('H:i', strtotime($dados['horario_inicio'])); // quantidade de alunos inscritos
			$vetor[$i][3] = date('H:i', strtotime($dados['horario_termino'])); // quantidade de alunos confirmados (que pagaram)
			$vetor[$i][4] =  $this->converterDataTela($dados["data_cadastro"]);
			$vetor[$i][5] = $pagamento;
			$vetor[$i][6] = $matriculado;
			$i++;
		}
		return $vetor;
	}

	public function listagemParticipantesAtividade($id){
        
		$sql = "SELECT c.id_congressista, c.cpf, c.nome nome, pa.fid_atividade FROM congressista as c
		INNER JOIN participante_atividade AS pa
			ON c.id_congressista = pa.fid_congressista
		INNER JOIN pagamento AS p
			ON c.id_congressista = p.fid_congressista			
		WHERE ((pa.fid_atividade = '".$id."') AND (p.status = 1)) 
		GROUP BY c.id_congressista ORDER BY c.nome";
		$result = $this->query($sql);
		$i = 0;
		while ($dados = mysql_fetch_array($result)) {
			$vetor[$i] = $dados['nome'];
			$i++;
		}
		return ($vetor);
    }

    public function buscarNomeAtividade($id){
        
		$sql = "SELECT nome FROM atividades
			WHERE id_atividade = '".$id."'";
		$result = $this->query($sql);
		$dados = mysql_fetch_array($result);
		return ($dados['nome']);
    }
}
?>