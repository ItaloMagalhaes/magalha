<?php

require ('model/model.php');


/**
 * loginModel
 *
 * Metodos de acesso ao banco
 *
 **/

class loginModel extends Model{

	/**
     * loginModel::selecionar()
     *
     * Seleciona os dados do login do banco de dados.
     *
     */
    public function logar(){
        /*Recebendo os dados*/
        $login = $_POST["login"];
		$senha = $_POST["senha"];
        
        /*Montando a sql*/
        $tabela = "usuarios";
        $dados = "*";
        $where = "login = '".$login."' AND senha= '".md5($senha)."'";
		
        /*Executando a sql de busca*/
        $result = $this->select($tabela,$dados, $where);
        
        return $result;
	}
	
	/**
     * loginModel::selecionar()
     *
     * Verifica se um login existe no banco de dados.
     *
     */
    public function verificarUsuario(){
		
		$login = $this->post("login");
		$tabela = "usuarios";
		$dados = "login";
		$condicao = "login = '".$login."'";
		
		$result = $this->select($tabela, $dados, $condicao);
		
		/*
		    Verifica se encontrou algum resultado com esse login
		    0 -> disponível
		    1 -> já existe
		*/
		
		if(mysql_num_rows($result) == 0){
			echo '0';
		}else echo '1';
		
	}
	
	
	/**
     * loginModel::buscarDadosAluno()
     *
     * Busca dados do aluno para guarda na sessão.
     *
     */
    public function buscarDadosCongressista($objeto){
		
		$sql = "SELECT * FROM congressista WHERE fid_usuario = ".$objeto->id_usuario."";
		$retorno = $this->query($sql);
        return $retorno;
	}
		
	public function salvar(){
		$codigo = $this->post('codigo');
		$email_codigo = base64_decode($codigo);
		$tabela = "codigos";
		$dados = "*";
		$condicao = "codigo = '".$codigo."' AND data > NOW()";
		
		$result = $this->select($tabela, $dados, $condicao);
		
	if(mysql_num_rows($result) > 0){
			$nova_senha = $this->post('novasenha');
			$nova_senha = md5($nova_senha);
			$set = "senha = '".$nova_senha."'";
			$tabela = "usuarios";
			$condicao = "login = '".$email_codigo."'";
			$atualizar = $this->update($tabela,$set,$condicao);
			if($atualizar){
				$sql = "DELETE FROM codigos WHERE codigo = '$codigo'";
				$this->query($sql);
				return 1;
			}else{
				return 0;
			}
		}
	}
}
?>