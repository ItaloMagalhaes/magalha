<?php

/**
 * Model
 * 
 * Camada base model
 * 
 *
 */

class Model {
    
    /**
     * Model::conectar()
     *
     * Faz conexão para acesso direto ao banco de dados 
     * @author Antonio Marcos <amm.bernardes@gmail.com>
     */
    public function conectar()
    {
    	
    	try
    	{
		//	error_reporting(E_ALL & ~E_DEPRECATED);		
					
			$GLOBALS['host'] = "localhost";
			$GLOBALS['user'] = "linkedej_gleyber";
			$GLOBALS['password'] = "l!nk3d13";
			$GLOBALS['bd'] = "linkedej_secomp2015";

		
			$conexao = mysql_pconnect( $GLOBALS['host'], $GLOBALS['user'], $GLOBALS['password'] ) or
	            die( mysql_error() );
	
	        mysql_select_db( $GLOBALS['bd'], $conexao ) or die( mysql_error() );
	        
        }catch(Exception $e)
        {
        	return false;
        }
    }


    /**
     * Model::query()
     *
     * Excecuta comando (SQL) diretamente no banco de dados
     * @author Antonio Marcos <amm.bernardes@gmail.com>
     */
    public function query( $sql )
    {
 
        try{
            
            $this->conectar();
            
            $resultado = mysql_query($sql) or die(mysql_error()); 
			
			$this->desconectar();
			
			return $resultado;
           
            
        } catch(Exception $e)       { 
           
            echo"Erro ao executar a query</br>"; 
            return false;

        }
    }
    
    /**
     * Model::insert()
     *
     * Metodos faz inserções no banco de dados.
     * @author Antonio Marcos <amm.bernardes@gmail.com>
     * @param string $tabela - Informa qual a tabela onde os dados serão inseridos.
     * @param string $campos - Informa qual os campos da tabela receberão os dados. Formato (dado1,dado2...).
     * @param string $valores - Informa quais os valores a serem inseridos no banco. Formato (valor1,valor2...)
     */
    public function insert( $tabela, $campos, $valores )
    {
		/*
			Sql padrão de inserção
		*/
		$sql = "INSERT INTO ".$tabela." ".$campos." VALUES ".$valores;
		
		//echo $sql; //exit;
		return $this->query($sql);
    }


	/**
     * Model::update()
     *
     * Metodos faz atualizações dos dados de uma tabela no banco de dados.
     * @author Antonio Marcos <amm.bernardes@gmail.com>
     * @param string $tabela - Informa qual a tabela onde os dados serão inseridos.
     * @param string $set - Informa qual os campos serão atualizados, assim como os novos dados. Formato CAMPO1=dado1, CAMPO2=dado2
     * @param string $condicao - Informa a condição para que os dados sejam atualizados
     */
    public function update( $tabela, $set, $condicao )
    {
		/*
			Sql padrão de inserção
		*/
		
		if ($condicao != "" ) $sql = "UPDATE ".$tabela." SET ".$set." WHERE ".$condicao;
        else $sql = "UPDATE ".$tabela." SET ".$set;
        //echo $sql; exit;
        return $this->query($sql);
    }
    
    /**
     * Model::delete()
     *
     * Metodos faz exclusoes no banco de dados.
     * @author Antonio Marcos <amm.bernardes@gmail.com>
     * @param string $tabela - Informa qual a tabela onde os dados serão inseridos.
     * @param string $condicao - Informa a condição para que os dados sejam removidos.
     */
    public function delete( $tabela, $condicao )
    {
		/*
			Sql padrão de inserção
		*/
        $sql = "DELETE FROM ".$tabela." WHERE ".$condicao;
        
        return $this->query($sql);
    }
    
    /**
     * Model::select()
     *
     * Metodos faz exclusoes no banco de dados.
     * @author Antonio Marcos <amm.bernardes@gmail.com>
     * @param string $tabela - Informa qual a tabela onde os dados serão inseridos.
     * @param string $dados - Informa quais os dados a serem buscados no banco de dados.
     * @param string $condicao - Informa a condição para que os dados sejam removidos.
     * @param string $group - Informa possiveis agrupamentos de dados.
     * @param string $order - Informa a ordem como os dados serão selecionados.
     */
    public function select( $tabela, $dados, $condicao="", $group="", $order="" )
    {
		/*
			Sql padrão de inserção
		*/
        $sql = "SELECT ".$dados." FROM ".$tabela;
        
        /*
			Complementação de uma query de busca.
        */
        if(!empty($condicao)) $sql.= " WHERE ".$condicao;
        
        if(!empty($group)) $sql.= " GROUP BY ".$group;
        //echo $sql."<br>";
        return $this->query($sql);
    }

    /**
     * Model::desconectar()
     *
     * Encerra conexão com o banco de dados.
     * @author Antonio Marcos <amm.bernardes@gmail.com>
     * 
     */
    public function desconectar()
    {
        mysql_close();
    }


    /**
     * Model::converterDataTela()
     * 
     * Converte datas do formato armazenado no banco para o formato brasileiro.
     * @author Antonio Marcos <amm.bernardes@gmail.com>
     * @param string $data - Contém a data no formato armazenado no banco de dados.
     */
    public function converterDataTela($data)
    {
        if($data){
            $t = explode(" ", $data);
            $d = explode("-", $t[0]);
            $nova_data = $d[2] . "/" . $d[1] . "/" . $d[0];
            return $nova_data;
        }else{
            return "";
        }    
    }
    
    
    /**
     * Model::converterDataBanco()
     * 
     * Formata datas originadas de formulárioo formato do banco de dados(yyyymmdd).
     * @author Antonio Marcos <amm.bernardes@gmail.com>
     * @param string $data - Contém a data no formato brasileiro normal.
     * 
     */
    public function converterDataBanco( $data )
    {
        if($data){
            $d = explode( "/", $data );
            $d[0] = str_pad( $d[0], 2, "0", STR_PAD_LEFT );
            $d[1] = str_pad( $d[1], 2, "0", STR_PAD_LEFT );
            $d[2] = str_pad( $d[2], 4, "0", STR_PAD_BOTH );
            $nova_data = $d[2] ."-". $d[1] ."-". $d[0];
            return $nova_data;
        }else{
            return "";
        }
    }
    
    /**
     * Model::antiInjection()
     *
     * Verifica se houve tentativas de injection. 
     * Retorna uma string sem os caracteres suspeitos.
     * Método sedido por Fabio Ferraz.
     * 
     * @author Fabio Ferraz <fabioruffs@gmail.com>
     * @param $str - String a ser verificada.
     */
   
    
    /**
     * Model::post()
     *
     * Faz o post e retorna ja com antiInjection
     * 
     * @author Antonio Marcos <amm.bernardes@gmail.com>
     * @param $campo - Nome do campo do formulário cujo dado deve ser obtido.
     * @param $nome - Parametro não obrigatorio, necessario para a validação.
     */
    public function post($campo,$nome=""){
		if (!empty($nome)){
			echo "0|O campo ".$nome." é obrigatório e deve ser preenchido";
			exit;
		}
		if (!empty($_POST[$campo]) ){
			return $_POST[$campo];
            //return trim($this->antiInjection( $_POST[$campo] ));
        } 
    }
    
    /**
     * Model::get()
     *
     * Faz o get e retorna ja com antiInjection
     * 
     * @author Antonio Marcos <amm.bernardes@gmail.com>
     * @param $campo - Nome do campo do formulário cujo dado deve ser obtido.
     */
    public function get($campo){

        if (!empty($_GET[$campo]) ){
        	return  mysql_escape_string($_GET[$campo]);
            //return trim($this->antiInjection( $_GET[$campo] ));
        } 
    }
    
    
    /**
     * Model::criaTabelas()
     *
     * 
     * 
     * @author Bruno Medeiros <brunomedeirosrafael@gmail.com>
     * 
     */
    public function criaTabelas(){


			// tabela com os dados de configuração do sistema
		$sql = "CREATE TABLE IF NOT EXISTS config_sistema (
				status_monitor			BOOLEAN					NOT NULL,
				status_aluno			BOOLEAN					NOT NULL,
				data_vencimento			DATE					NOT NULL,					
				ultima_data_fila		DATE					NOT NULL
			)ENGINE = InnoDB";
		
		$resultado = $this->query($sql); 
		echo "<br \>Tabela config_sistma criada com sucesso !";
		
		
		// tabela que contém os usuários com acesso ao sistema
			$sql = "CREATE TABLE IF NOT EXISTS usuarios (
					id_usuario			INT 			unsigned			NOT NULL	AUTO_INCREMENT,
					login				VARCHAR(70)		CHARACTER SET utf8	NOT NULL,
					senha		 		VARCHAR(150) 	CHARACTER SET utf8	NOT NULL,
					tipo				VARCHAR(30)		CHARACTER SET utf8	NOT NULL,
					PRIMARY KEY (id_usuario)
				)ENGINE = InnoDB";	
			
			$resultado = $this->query($sql); 
			echo "<br \>Tabela usuario criada com sucesso !";
				
			
			// tabela que contém os coodenadores
			$sql = "CREATE TABLE IF NOT EXISTS coordenador_area (
					id_coordenador		INT 		unsigned			NOT NULL	AUTO_INCREMENT,
					nome				VARCHAR(70)	CHARACTER SET utf8	NOT NULL,
					cpf 		VARCHAR(15) 	CHARACTER SET utf8	NOT NULL,
					fid_usuario INT				unsigned			NOT NULL,
					FOREIGN KEY (fid_usuario)	REFERENCES usuarios (id_usuario) ON UPDATE CASCADE ON DELETE CASCADE,
					PRIMARY KEY (id_coordenador)
				)ENGINE = InnoDB";	
			
			$resultado = $this->query($sql); 
			echo "<br \>Tabela coordenador_ares criada com sucesso !";
			
		
		// tabela que contém as áreas
			$sql = "CREATE TABLE IF NOT EXISTS areas (
					id_area				 INT				unsigned			NOT NULL	AUTO_INCREMENT,
					nome				 VARCHAR(140)	CHARACTER SET utf8	NOT NULL,
					fid_coordenador_area INT 	unsigned 			NOT NULL,
					FOREIGN KEY (fid_coordenador_area) REFERENCES 	coordenador_area (id_coordenador) ON UPDATE CASCADE ON DELETE CASCADE,
					PRIMARY KEY (id_area)
					
				)ENGINE = InnoDB";

		$resultado = $this->query($sql); 
		echo "<br \>Tabela areas criada com sucesso !";
		
					
		// tabela que contém os monitores
		$sql = "CREATE TABLE IF NOT EXISTS monitores (
				id_monitor				INT				unsigned			NOT NULL		AUTO_INCREMENT,							
				nome 					VARCHAR(100)	CHARACTER SET utf8	NOT NULL,
				sexo 					VARCHAR(100)	CHARACTER SET utf8	NOT NULL,
				data_nascimento			DATE								NOT NULL,
				turno 					VARCHAR(45)		CHARACTER SET utf8	NOT NULL,
				rua						VARCHAR(100)	CHARACTER SET utf8	NOT NULL,
				bairro					VARCHAR(100)	CHARACTER SET utf8	NOT NULL,	
				numero					INT				unsigned			NOT NULL,	
				cidade					VARCHAR(100)	CHARACTER SET utf8	NOT NULL,
				estado					VARCHAR(100)	CHARACTER SET utf8	NOT NULL,
				complemento				VARCHAR(100)	CHARACTER SET utf8	NOT NULL,
				cep						VARCHAR(100)	CHARACTER SET utf8	NOT NULL,
				telefone 				VARCHAR(45) 	CHARACTER SET utf8	NOT NULL,
				cpf 					VARCHAR(15) 	CHARACTER SET utf8	NOT NULL,
				rg 						VARCHAR(45) 	CHARACTER SET utf8	NOT NULL,
				pis_pasep 				VARCHAR(20) 	CHARACTER SET utf8	NOT NULL,
				curso 					VARCHAR(70) 	CHARACTER SET utf8	NOT NULL,
				matricula 				VARCHAR(15) 	CHARACTER SET utf8	NOT NULL,
				email 					VARCHAR(50) 	CHARACTER SET utf8	NOT NULL,
				disponibilidade_manha 	VARCHAR(45) 	CHARACTER SET utf8	NOT NULL,
				disponibilidade_tarde 	VARCHAR(45) 	CHARACTER SET utf8	NOT NULL,
				disponibilidade_noite 	VARCHAR(45) 	CHARACTER SET utf8	NOT NULL,
				outras_informacoes 		TEXT(500) 		CHARACTER SET utf8	NOT NULL,
				interesse_monitor 		TEXT(500) 		CHARACTER SET utf8	NOT NULL,
				experiencia 			TEXT(500) 		CHARACTER SET utf8	NOT NULL,
				ja_participou 			VARCHAR(45) 	CHARACTER SET utf8	NOT NULL,
				forma_participacao		TEXT(500) 		CHARACTER SET utf8	NOT NULL,
				banco 					VARCHAR(50)		CHARACTER SET utf8	NOT NULL,
				tipo_conta 				VARCHAR(100)	CHARACTER SET utf8	NOT NULL,
				numero_conta 			VARCHAR(45) 	CHARACTER SET utf8	NOT NULL,
				agencia 				VARCHAR(45) 	CHARACTER SET utf8	NOT NULL,
				forma_pagamento			VARCHAR(45) 	CHARACTER SET utf8	NOT NULL,
				operacao 				INT	 			unsigned			NOT NULL,
				cidade_participacao		VARCHAR(100)	CHARACTER SET utf8	NOT NULL,
				data_cadastro			DATE								NOT NULL,
				selecionado				BOOLEAN								NOT NULL,
				fid_area				INT				unsigned			NOT NULL,

				FOREIGN KEY (fid_area)		REFERENCES areas (id_area) ON UPDATE CASCADE ON DELETE CASCADE,

				PRIMARY KEY (id_monitor)

			)ENGINE = InnoDB";

			$resultado = $this->query($sql); 
			echo "<br \>Tabela monitor criada com sucesso !";
			
			// tabela que contém os participantes
			$sql = "CREATE TABLE IF NOT EXISTS alunos (
					id_aluno			INT 			unsigned			NOT NULL 	AUTO_INCREMENT,
					nome 				VARCHAR(100)	CHARACTER SET utf8	NOT NULL,
					cpf 				VARCHAR(15) 	CHARACTER SET utf8	NOT NULL,
					email 				VARCHAR(50) 	CHARACTER SET utf8,
					data_nascimento		DATE								NOT NULL,
					data_cadastro		DATE								NOT NULL,
					sexo				VARCHAR(15)		CHARACTER SET utf8	NOT NULL,
					escolaridade		VARCHAR(30)		CHARACTER SET utf8	NOT NULL,
					telefone			VARCHAR(15)		CHARACTER SET utf8,
					rua					VARCHAR(100)	CHARACTER SET utf8,
					bairro				VARCHAR(100)	CHARACTER SET utf8,	
					numero				INT				unsigned,
					complemento			VARCHAR(100)	CHARACTER SET utf8,			
					cidade				VARCHAR(100)	CHARACTER SET utf8,
					estado				VARCHAR(100)	CHARACTER SET utf8,
					cep					VARCHAR(100)	CHARACTER SET utf8,
					email_enviado		BOOLEAN								NOT NULL,
					fid_usuario			INT				unsigned,
					dependente			INT				unsigned			NOT NULL,
					FOREIGN KEY (fid_usuario)	REFERENCES usuarios (id_usuario) ON UPDATE CASCADE ON DELETE CASCADE,
					PRIMARY KEY (id_aluno)
				)ENGINE = InnoDB";

			$resultado = $this->query($sql); 
			echo "<br \>Tabela alunos criada com sucesso !";		
			
			// tabela que contém as oficinas
			$sql = "CREATE TABLE IF NOT EXISTS oficinas (
					id_oficina				INT 				unsigned			NOT NULL	AUTO_INCREMENT,	
					codigo_oficina			VARCHAR(100) 		CHARACTER SET utf8	NOT NULL,
					nome					VARCHAR(100) 		CHARACTER SET utf8	NOT NULL,
					descricao 				TEXT(500) 			CHARACTER SET utf8	NOT NULL,
					idade_min 				INT	 									NOT NULL,
					idade_max 				INT	 									NOT NULL,
					carga_horaria 			VARCHAR(45) 		CHARACTER SET utf8	NOT NULL,
					publico_alvo 			VARCHAR(200) 		CHARACTER SET utf8	NOT NULL,
					material_do_aluno 		VARCHAR(200) 		CHARACTER SET utf8	NOT NULL,
					pre_requisito	 		VARCHAR(200) 		CHARACTER SET utf8	NOT NULL,
					numero_vagas 			INT			 		unsigned			NOT NULL,
					preco					FLOAT									NOT NULL,
					data_inicio				DATE									NOT NULL,
					data_termino			DATE									NOT NULL,
					horario_inicio			TIME									NOT NULL,					
					horario_termino			TIME									NOT NULL,					
					professor				VARCHAR(150) 		CHARACTER SET utf8	NOT NULL,
					local					VARCHAR(200) 		CHARACTER SET utf8	NOT NULL,
					fid_area					INT					unsigned			NOT NULL,
					FOREIGN KEY (fid_area)		REFERENCES areas (id_area) ON UPDATE CASCADE ON DELETE CASCADE,
					PRIMARY KEY (id_oficina)
				)ENGINE = InnoDB";

			$resultado = $this->query($sql); 
			echo "<br \>Tabela oficinas criada com sucesso !";


			// tabela que contém a relação de inscrito em oficina
			$sql = "CREATE TABLE IF NOT EXISTS participante_oficina (
					id_relacao_inscrito_oficina		INT 				unsigned			NOT NULL	AUTO_INCREMENT,	
					fid_aluno						INT 				unsigned			NOT NULL,	
					fid_oficina						INT 				unsigned			NOT NULL,
					presenca						BOOLEAN									NOT NULL,
					fila_de_espera					BOOLEAN									NOT NULL,
					data_cadastro					DATE 									NOT NULL,
					data_chamada_fila				DATE 									NOT NULL,
					FOREIGN KEY (fid_aluno)			REFERENCES alunos (id_aluno) ON UPDATE CASCADE ON DELETE CASCADE,
					FOREIGN KEY (fid_oficina)		REFERENCES oficinas (id_oficina) ON UPDATE CASCADE ON DELETE CASCADE,
					PRIMARY KEY (id_relacao_inscrito_oficina)
				)ENGINE = InnoDB";
		
			$resultado = $this->query($sql); 
			echo "<br \>Tabela participantes_oficina criada com sucesso !";


			// tabela que contém os boletos de cada aluno na oficina
			$sql = "CREATE TABLE IF NOT EXISTS boletos (
					id_boleto					INT 			unsigned			NOT NULL 	AUTO_INCREMENT,
					num_boleto					INT 			unsigned			NOT NULL,
					preco						FLOAT								NOT NULL,
					data_validacao      		DATE								NOT NULL,
					data_emissao				DATE								NOT NULL,
					data_vencimento				DATE								NOT NULL,
					status						BOOLEAN								NOT NULL,
					fid_participante_oficina	INT 			unsigned			NOT NULL,
					fid_aluno			INT 			unsigned			NOT NULL,
					fid_oficina			INT 			unsigned			NOT NULL,
					FOREIGN KEY (fid_aluno)		REFERENCES alunos (id_aluno) ON UPDATE CASCADE ON DELETE CASCADE,
					FOREIGN KEY (fid_oficina)	REFERENCES oficinas (id_oficina)ON UPDATE CASCADE ON DELETE CASCADE,
					FOREIGN KEY (fid_participante_oficina)		REFERENCES participante_oficina (id_relacao_inscrito_oficina) ON UPDATE CASCADE ON DELETE CASCADE,
					PRIMARY KEY (id_boleto)

				)ENGINE = InnoDB";

			$resultado = $this->query($sql); 
			echo "<br \>Tabela boletos criada com sucesso !";
			
			
			echo "<br \><p>Tabelas criadas com sucesso!</p>"; 
    }
    
	/**
    * Controller::CalcularIdade()
    *
    * Calcula a idade a partir da data específicada no parâmetro $nascimento.
    * Retorna a idade obtida.
    *
    */
    function Calcularidade($data_nascimento){
		//Data atual.
		$data_calcula = date("Y-m-d");
		
		//as datas devem ser no formato aaaa-mm-dd
		//conversão das datas para o formato de tempo linux
		$data_nascimento = strtotime($data_nascimento." 00:00:00");
		$data_calcula = strtotime($data_calcula." 00:00:00");
		
		//cálculo da idade fazendo a diferença entre as duas datas
		$idade = floor(abs($data_calcula-$data_nascimento)/60/60/24/365);
		return($idade);

}
   
   /**
     * Model::obterCpfAluno()
     *
     * Busca no banco o cpf de um aluno.
     *
     * Autor: Antonio Marcos
     */
     
    public function obterCpfAluno($idAluno){
        
		$sql = "SELECT cpf 
				FROM alunos   
				WHERE alunos.id_aluno = ".$idAluno;
		
		$retorno = $this->query($sql);
		return ($retorno);		
	}
	
	/**
     * Model::obterDataNasc()
     *
     * Busca no banco a data de nascimento de um aluno.
     *
     * Autor: Antonio Marcos
     */
     
    public function obterDataNasc($idAluno){
        
		$sql = "SELECT data_nascimento 
				FROM alunos   
				WHERE alunos.id_aluno = ".$idAluno;
		
		$retorno = $this->query($sql);
		return ($retorno);		
	}
	
		
    
}
?>