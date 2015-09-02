<?php

require ('model/model.php');

/**
 * siteModel
 *
 * Metodos de acesso ao banco
 *
 **/

class siteModel extends Model{
	
	
	/**
     * siteModel::VerificarStatus()
     *
     * Verifica no banco de dados, se a incrição de alunos está aberta.
     *
     */
    public function VerificarStatus(){
		
		$campos = "status_aluno";
		$tabela = "config_sistema";	
		$resultado = $this->select($tabela,$campos);
		return $resultado;
	}
	
	/**
     * siteModel::encerrarInsricaoAluno()
     *
     * Encerra as inscrições de alunos no banco de dados.
     *
     */
    public function encerrarInsricaoAluno(){
		
		$set = "status_aluno=0";
		$tabela = "config_sistema";	
		$condicao = "status_aluno=1";
		$resultado = $this->update($tabela,$set,$condicao);
		return $resultado;
	}	
	
	/**
     * siteModel::abrirInsricaoAluno()
     *
     * Abre as inscrições de alunos no banco de dados.
     *
     */
    public function abrirInsricaoAluno(){
		
		$set = "status_aluno=1";
		$tabela = "config_sistema";	
		$condicao = "status_aluno=0";
		$resultado = $this->update($tabela,$set,$condicao);
		return $resultado;
	}
}
?>
