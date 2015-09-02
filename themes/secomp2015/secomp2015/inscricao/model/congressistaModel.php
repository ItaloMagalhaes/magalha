<?php

require ('model/model.php');

/**
 * congressistaModel
 *
 * Metodos de acesso ao banco
 *
 **/

class congressistaModel extends Model{
	
	/**
     * congressistaModel::selecionar()
     *
     * Seleciona os dados de aluno do banco de dados.
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

	public function buscarValorPendente($id){

		$sql = "SELECT a.nome, a.preco
			    FROM atividades as a
			    INNER JOIN participante_atividade as pa
			    ON a.id_atividade = pa.fid_atividade
			   	WHERE ((pa.fid_congressista = '".$id."') AND (pa.fila_de_espera = 0))";
		$result = $this->query($sql);
		return ($result);
    }

	public function verificarPagamento($id){
		$sql = "SELECT pagamento FROM congressista
				WHERE id_congressista = '".$id."'";
		$result = $this->query($sql);
		$valor = mysql_fetch_object($result);
		return $valor->pagamento;
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

	public function recuperaStatus($id){
		$sql = "SELECT pagamento
			    FROM congressista
			   	WHERE id_congressista = '".$id."'";
		
		$result = $this->query($sql);
		return ($result);
	}

	/**
     * alunoModel::listagemOficina()
     *
     * Lista as atividades para que o aluno possa escolher a oficina
     * 
     * Autor: Jefferson
     *
     */	
	public function listagemAtividade(){
		$sql = "SELECT * FROM atividades ORDER BY data_inicio";
		$result = $this->query($sql);
		return $result;

	}	
	
	/**
     * congressistaModel::salvar()
     *
     * Salva os dados de coordenadorArea no banco de dados.
     *
     */
    public function salvar(){
        
		/*
			Receber dados vindos do formulario.
		*/
		$nome = $this->post("nome");
		$cpf = $this->post("cpf");
		$email = $this->post("email");
		$data_nascimento = $this->post("data_nascimento");
		$data_nascimento = $this->converterDataBanco($data_nascimento);
		$data_cadastro = date("Y-m-d");
		$sexo = $this->post("sexo");
		$escolaridade = $this->post("escolaridade");
		$camisa = $this->post("camisa");
		$telefone = $this->post("telefone");
		$rua = $this->post("rua");
		$numero = $this->post("numero");
		$complemento = $this->post("complemento");
		$bairro = $this->post("bairro");
		$cidade = $this->post("cidade");
		$estado = $this->post("estado");
		$cep = $this->post("cep");
		$senha = $this->post("senha");		

		$senhaCript = md5($senha);
		$tipo = 4;
		


		/*Verifação de cpf*/
		if($this->verificarCpf($cpf)){
			return 2;
		}



		/*
			Inserindo dados na tabela usuário.
		*/
		$campos = "(login,senha,tipo)";		
		$valores = "('".$cpf."','".$senhaCript."','".$tipo."')";		
		$tabela = "usuarios";
		
		$this->insert( $tabela, $campos, $valores );	
		
		/*
			Buscando o id do usuário cadastrado para ser foreing key na tabela congressista.
		*/
		
		$dados = "id_usuario";
		$condicao = "login = '".$cpf."'";
		$tabela = "usuarios";
		$result = $this->select($tabela, $dados, $condicao);		
		$result = mysql_fetch_array($result);
		$fidUsuario = $result['id_usuario'];
		$pagamento = 0;
		
		/*
			Inserindo congressista.
		*/
		$campos = "(nome, cpf, email, data_nascimento, data_cadastro, sexo, escolaridade, telefone, rua, bairro, numero, complemento, cidade, estado, cep, fid_usuario, material, pagamento, camisa)";
		$valores = "('".$nome."','".$cpf."','".$email."','".$data_nascimento."','".$data_cadastro."','".$sexo."','".$escolaridade."','".$telefone."','".$rua."','".$bairro."','".$numero."','".$complemento."','".$cidade."','".$estado."','".$cep."','".$fidUsuario."', 0,'".$pagamento."','".$camisa."')";
		$tabela = "congressista";
		
		if ($this->insert( $tabela, $campos, $valores )){
			$this->enviarEmail($email,$nome);
			return ("1|Seu cadastro foi realizado com sucesso! Em breve um e-mail será enviado!|Enviado com sucesso");
		}else{
			return ("0|Aluno não pôde ser cadastrado!");
		}
	}

	public function verificarCpf(){
		
		$cpf = $this->post("cpf");
		$tabela = "congressista";
		$dados = "cpf";
		$condicao = "cpf = '".$cpf."'";
		
		$result = $this->select($tabela, $dados, $condicao);
		
		/*
		    Verifica se encontrou algum resultado com esse cpf
		    0 -> não cadastrado
		    1 -> já cadastrado
		*/
		
		if(mysql_num_rows($result) == 0){
			return 0;
		}else return 1;	
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
     * oficinaModel::matricularAluno()
     *
     * Faz o cadastro no banco de dados, das atividades que determinado aluno escolheu
     *
     */
    public function matricularCongressistaAtividade($codigo_congressista){
        
		//Percorre o vetor da sessão de matricula. Salvando os novos valores.
		if ( !isset( $_SESSION ) ){
		    session_start();
	    }

        if ($_SESSION['atividade']){
	        $atividade = $_SESSION['atividade'];   
	    }
	    $atividade = $_SESSION['atividade'];        

	    $data_cadastro = date("Y-m-d");
		$retorno = 1;
		

		foreach($atividade as $value){
			$se = $this->verificarMatriculaCongressista($codigo_congressista, $value);
			if (mysql_num_rows($se) == 0){
				$vagas = $this->verificarVagas($value);
				
				$tabela = "participante_atividade";
				$campos = "(fid_congressista,fid_atividade,data_cadastro,fila_de_espera)";
				
				if($vagas == 1){
					$valores = "('".$codigo_congressista."','".$value."','".$data_cadastro."',0)";
				}else{
					$valores = "('".$codigo_congressista."','".$value."','".$data_cadastro."',1)";
				}
				
				$resultado = $this->insert($tabela,$campos,$valores);
				
				//Busca o id da relação para inserir os dados do boleto
				$dados = "id_relacao_inscrito_atividade, fila_de_espera";
				$condicao = "fid_congressista = '".$codigo_congressista."' AND fid_atividade ='".$value."'";
				$resultado1 = $this->select($tabela,$dados,$condicao);
				$dado = mysql_fetch_array($resultado1);
				
				//Busca o preço da oficina para inserir na tabela boletos
				$dados3 = "preco";
				$condicao3 = "id_atividade ='".$value."'";
				$tabela3 = "atividades";
				$resultado3 = $this->select($tabela3,$dados3,$condicao3);
				$dado3 = mysql_fetch_array($resultado3);
				$preco = $dado3['preco'];
				
				//Verifica se não está na fila de espera -> se não estiver: data de hoje, se estiver será setado quando for chamado na fila de espera
				//Do mesmo modo verifica a data_vencimento. se não estiver na fila de espera data_vencimento é buscada na tabela config_sistema caso contrário é setado quando for chamado na fila de espera
				$dados4 = "pagamento";
				$condicao4 = "id_congressista ='".$codigo_congressista."'";
				$tabela4 = "congressista";
				$resultado4 = $this->select($tabela4,$dados4,$condicao4);
				$dado4 = mysql_fetch_array($resultado4);
				$status = $dado4['pagamento'];
				
				//Salva os dados na tabela boletos
				$tabela1 = "pagamento";
				$campos1 = "(preco, status, fid_congressista, fid_atividade, fid_participante_atividade)";
				$valores1 = "('".$preco."','".$status."','".$codigo_congressista."','".$value."','".$dado['id_relacao_inscrito_atividade']."')";
				$this->insert($tabela1,$campos1,$valores1);
				$retorno++;
		
			}		
		}
		return $retorno;	
	}
	/**
     * oficinaModel::verificarMatriculacongressista()
     *
     * Verifica no banco de dados, se um dado aluno ja encontra-se matriculado numa dada oficina.
     *
     */
    public function verificarMatriculaCongressista($codigo_congressista, $codigo_atividade){
        
        $sql = "SELECT * FROM participante_atividade
				WHERE fid_congressista =".$codigo_congressista." AND fid_atividade = ".$codigo_atividade;
		
		$resultado = $this->query($sql);	   
		return $resultado;
	}	

	/**
     * oficinaModel::verificarVagas()
     *
     * Verifica quantidade de vagas na oficina
     *
     * Autor: Antonio Marcos
     * 
     */
    public function verificarVagas($id){
        
        $sql = "SELECT o.n_vagas, COUNT(po.id_relacao_inscrito_atividade) AS total FROM atividades AS o INNER JOIN participante_atividade AS po ON o.id_atividade = po.fid_atividade WHERE o.id_atividade=".$id;

		
		$resultado = $this->query($sql);	
		
		while($dado = mysql_fetch_object($resultado)){
			$vagas = $dado->n_vagas;
			$total = $dado->total;	
		}
		
		
		if ($total >= $vagas) return 0;
		else return 1;
	}

	public function listarParticipacao(){
		if ( !isset( $_SESSION ) ){
           session_start();
       	} 		
       	$idCongressista = $_SESSION['id_congressista'];
		$sql = "SELECT * FROM congressista WHERE id_congressista='".$idCongressista."' AND pagamento = 1 ";
		
		$retorno = $this->query($sql);
		return ($retorno);		
	}
	public function listarApresentacaoArtigo(){
		if ( !isset( $_SESSION ) ){
           session_start();
       	} 		
       	$idCongressista = $_SESSION['id_congressista'];
		$sql = "SELECT * FROM artigos WHERE fid_congressista='".$idCongressista."' AND apresentacao_artigo = 1 ";
		
		$retorno = $this->query($sql);
		return ($retorno);		
	}
	public function listarAtividadesCadastradas(){
		if ( !isset( $_SESSION ) ){
           session_start();
       	} 		
       	$idCongressista = $_SESSION['id_congressista'];
		$sql = "SELECT po.*, o.nome, o.tipo, o.horario_inicio, o.horario_termino, o.data_inicio, a.cpf AS atividades, b.status
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
		return ($retorno);		
	}

	public function obterCpfCongressista($id_congressista){

		$sql = "SELECT * FROM congressista WHERE id_congressista = '".$id_congressista."'";
		$retorno = $this->query($sql);
		return($retorno);
	}

	public function obterAtividadesCongressista($codigo_congressista){

		$dados = "po.fid_atividade";
		$tabela = "participante_atividade AS po";
		$condicao = "po.fid_congressista='".$codigo_congressista."'";
		$result = $this->select($tabela, $dados,$condicao);
		return $result;
	}
	
	public function buscarAtividadesCadastradas(){

		$sql = "SELECT pa.id_relacao_inscrito_atividade, pa.data_cadastro, a.nome ,p.status as atividade 
			    FROM participante_atividade as pa 
			    INNER JOIN congressista AS c 
			        ON c.fid_usuario = pa.fid_congressista
			    INNER JOIN atividades as a
			   		ON pa.fid_atividade = a.id_atividade   
			   	INNER JOIN pagamento as p
			   		ON p.fid_participante_atividade = pa.id_relacao_inscrito_atividade
			   	WHERE pa.fila_de_espera = 0 AND p.status = 1";
		$result = $this->query($sql);
		return ($result);
	}

	/**
     * congressistaModel::verificarInscrição()
     *
     * Vefirica no banco se as incrições de congressista estão abertas.
     * Autor: Thiago Gomides 
     */
    public function verificarSituacaoCongressista(){
		
		$tabela = "config_sistema";
		$dados = "*";
		$condicao = "status_aluno = 1";
		
		$result = $this->select($tabela, $dados, $condicao);
		
		/*
		    Verifica se encontrou algum resultado com esse cpf
		    0 -> não cadastrado
		    1 -> já cadastrado
		*/
		
		if(mysql_num_rows($result) == 0){
			return 0;
		}else return 1;
		
	}

	public function listarAtividadesCongressista($idCongressista){

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
		return ($retorno);		
	}

	public function enviarEmail($email,$nome){

		require 'PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'contatosecompufsj@gmail.com';                 // SMTP username
        $mail->Password = 'l!nk3d37';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                           // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to
        $mail->From = 'contatosecompufsj@gmail.com';
        $mail->FromName = 'IV SECOMP';
        $mail->addAddress($email, $nome);     // Add a recipient
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'IV SECOMP';
        $mail->AltBody = 'IV SECOMP';
        $mail->Body =  utf8_decode('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	    <head>
	    	<!-- NAME: POP-UP -->
	        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	        <title>*|MC:SUBJECT|*</title>
	        
	    <style type="text/css">
			body,#bodyTable,#bodyCell{
				height:100% !important;
				margin:0;
				padding:0;
				width:100% !important;
			}
			table{
				border-collapse:collapse;
			}
			img,a img{
				border:0;
				outline:none;
				text-decoration:none;
			}
			h1,h2,h3,h4,h5,h6{
				margin:0;
				padding:0;
			}
			p{
				margin:1em 0;
				padding:0;
			}
			a{
				word-wrap:break-word;
			}
			.ReadMsgBody{
				width:100%;
			}
			.ExternalClass{
				width:100%;
			}
			.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{
				line-height:100%;
			}
			table,td{
				mso-table-lspace:0pt;
				mso-table-rspace:0pt;
			}
			#outlook a{
				padding:0;
			}
			img{
				-ms-interpolation-mode:bicubic;
			}
			body,table,td,p,a,li,blockquote{
				-ms-text-size-adjust:100%;
				-webkit-text-size-adjust:100%;
			}
			#bodyCell{
				padding:0;
			}
			.mcnImage{
				vertical-align:bottom;
			}
			.mcnTextContent img{
				height:auto !important;
			}
			a.mcnButton{
				display:block;
			}
		/*
		@tab Page
		@section background style
		@tip Set the background color and top border for your email. You may want to choose colors that match your company"s branding.
		*/
			body,#bodyTable{
				/*@editable*/background-color:#F5F5F5;
			}
		/*
		@tab Page
		@section background style
		@tip Set the background color and top border for your email. You may want to choose colors that match your company"s branding.
		*/
			#bodyCell{
				/*@editable*/border-top:0;
			}
		/*
		@tab Page
		@section heading 1
		@tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
		@style heading 1
		*/
			h1{
				/*@editable*/color:#202020 !important;
				display:block;
				/*@editable*/font-family:Helvetica;
				/*@editable*/font-size:34px;
				/*@editable*/font-style:normal;
				/*@editable*/font-weight:bold;
				/*@editable*/line-height:125%;
				/*@editable*/letter-spacing:normal;
				margin:0;
				/*@editable*/text-align:center;
			}
		/*
		@tab Page
		@section heading 2
		@tip Set the styling for all second-level headings in your emails.
		@style heading 2
		*/
			h2{
				/*@editable*/color:#FFFFFF !important;
				display:block;
				/*@editable*/font-family:Helvetica;
				/*@editable*/font-size:26px;
				/*@editable*/font-style:normal;
				/*@editable*/font-weight:bold;
				/*@editable*/line-height:125%;
				/*@editable*/letter-spacing:normal;
				margin:0;
				/*@editable*/text-align:left;
			}
		/*
		@tab Page
		@section heading 3
		@tip Set the styling for all third-level headings in your emails.
		@style heading 3
		*/
			h3{
				/*@editable*/color:#404040 !important;
				display:block;
				/*@editable*/font-family:Helvetica;
				/*@editable*/font-size:18px;
				/*@editable*/font-style:normal;
				/*@editable*/font-weight:bold;
				/*@editable*/line-height:125%;
				/*@editable*/letter-spacing:normal;
				margin:0;
				/*@editable*/text-align:left;
			}
		/*
		@tab Page
		@section heading 4
		@tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
		@style heading 4
		*/
			h4{
				/*@editable*/color:#606060 !important;
				display:block;
				/*@editable*/font-family:Helvetica;
				/*@editable*/font-size:16px;
				/*@editable*/font-style:normal;
				/*@editable*/font-weight:bold;
				/*@editable*/line-height:125%;
				/*@editable*/letter-spacing:normal;
				margin:0;
				/*@editable*/text-align:left;
			}
		/*
		@tab Preheader
		@section preheader style
		@tip Set the background color and borders for your email"s preheader area.
		*/
			#templatePreheader{
				/*@editable*/background-color:#b3e9ec;
				/*@editable*/border-top:0;
				/*@editable*/border-bottom:0;
			}
		/*
		@tab Preheader
		@section preheader container
		@tip Set the background color and borders for your email"s preheader text container.
		*/
			#preheaderBackground{
				/*@editable*/background-color:#b3e9ec;
				/*@editable*/border-top:0;
				/*@editable*/border-bottom:0;
			}

			.teste {
				width: 90% !important;
			}
		/*
		@tab Preheader
		@section preheader text
		@tip Set the styling for your email"s preheader text. Choose a size and color that is easy to read.
		*/
			.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
				/*@editable*/color:#000000;
				/*@editable*/font-family:Helvetica;
				/*@editable*/font-size:10px;
				/*@editable*/line-height:125%;
				/*@editable*/text-align:left;
			}
		/*
		@tab Preheader
		@section preheader link
		@tip Set the styling for your email"s header links. Choose a color that helps them stand out from your text.
		*/
			.preheaderContainer .mcnTextContent a{
				/*@editable*/color:#000000;
				/*@editable*/font-weight:normal;
				/*@editable*/text-decoration:underline;
			}
		/*
		@tab Header
		@section header style
		@tip Set the background color and borders for your email"s header area.
		*/
			#templateHeader{
				/*@editable*/background-color:#b3e9ec;
				/*@editable*/border-top:0;
				/*@editable*/border-bottom:0;
			}
		/*
		@tab Header
		@section header container
		@tip Set the background color and borders for your email"s header text container.
		*/
			#headerBackground{
				/*@editable*/background-color:#FFFFFF;
				/*@editable*/border-top:0;
				/*@editable*/border-bottom:0;
			}
		/*
		@tab Header
		@section header text
		@tip Set the styling for your email"s header text. Choose a size and color that is easy to read.
		*/
			.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
				/*@editable*/color:#202020;
				/*@editable*/font-family:Helvetica;
				/*@editable*/font-size:16px;
				/*@editable*/line-height:150%;
				/*@editable*/text-align:left;
			}
		/*
		@tab Header
		@section header link
		@tip Set the styling for your email"s header links. Choose a color that helps them stand out from your text.
		*/
			.headerContainer .mcnTextContent a{
				/*@editable*/color:#EE4343;
				/*@editable*/font-weight:normal;
				/*@editable*/text-decoration:underline;
			}
		/*
		@tab Body
		@section body style
		@tip Set the background color and borders for your email"s body area.
		*/
			#templateBody{
				/*@editable*/background-color:#F5F5F5;
				/*@editable*/border-top:0;
				/*@editable*/border-bottom:0;
			}
		/*
		@tab Body
		@section body container
		@tip Set the background color and borders for your email"s body text container.
		*/
			#bodyBackground{
				/*@editable*/background-color:#FFFFFF;
				/*@editable*/border-top:0;
				/*@editable*/border-bottom:0;
			}
		/*
		@tab Body
		@section body text
		@tip Set the styling for your email"s body text. Choose a size and color that is easy to read.
		*/
			.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
				/*@editable*/color:#202020;
				/*@editable*/font-family:Helvetica;
				/*@editable*/font-size:18px;
				/*@editable*/line-height:150%;
				/*@editable*/text-align:center;
			}
		/*
		@tab Body
		@section body link
		@tip Set the styling for your email"s body links. Choose a color that helps them stand out from your text.
		*/
			.bodyContainer .mcnTextContent a{
				/*@editable*/color:#3f7a7d;
				/*@editable*/font-weight:normal;
				/*@editable*/text-decoration:underline;
			}
		/*
		@tab Footer
		@section footer style
		@tip Set the background color and borders for your email"s footer area.
		*/
			#templateFooter{
				/*@editable*/background-color:#F5F5F5;
				/*@editable*/border-top:0;
				/*@editable*/border-bottom:0;
			}
		/*
		@tab Footer
		@section footer container
		@tip Set the background color and borders for your email"s footer text container.
		*/
			#footerBackground{
				/*@editable*/background-color:#FFFFFF;
				/*@editable*/border-top:0;
				/*@editable*/border-bottom:0;
			}
		/*
		@tab Footer
		@section footer text
		@tip Set the styling for your email"s footer text. Choose a size and color that is easy to read.
		*/
			.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
				/*@editable*/color:#606060;
				/*@editable*/font-family:Helvetica;
				/*@editable*/font-size:10px;
				/*@editable*/line-height:125%;
				/*@editable*/text-align:center;
			}
		/*
		@tab Footer
		@section footer link
		@tip Set the styling for your email"s footer links. Choose a color that helps them stand out from your text.
		*/
			.footerContainer .mcnTextContent a{
				/*@editable*/color:#606060;
				/*@editable*/font-weight:normal;
				/*@editable*/text-decoration:underline;
			}
		@media only screen and (max-width: 480px){
			body,table,td,p,a,li,blockquote{
				-webkit-text-size-adjust:none !important;
			}

		}	@media only screen and (max-width: 480px){
				body{
					width:100% !important;
					min-width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnTextContentContainer]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnBoxedTextContentContainer]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcpreview-image-uploader]{
					width:100% !important;
					display:none !important;
				}

		}	@media only screen and (max-width: 480px){
				img[class=mcnImage]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnImageGroupContentContainer]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageGroupContent]{
					padding:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageGroupBlockInner]{
					padding-bottom:0 !important;
					padding-top:0 !important;
				}

		}	@media only screen and (max-width: 480px){
				tbody[class=mcnImageGroupBlockOuter]{
					padding-bottom:9px !important;
					padding-top:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnCaptionTopContent],table[class=mcnCaptionBottomContent]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnCaptionLeftTextContentContainer],table[class=mcnCaptionRightTextContentContainer],table[class=mcnCaptionLeftImageContentContainer],table[class=mcnCaptionRightImageContentContainer],table[class=mcnImageCardLeftTextContentContainer],table[class=mcnImageCardRightTextContentContainer]{
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
					padding-right:18px !important;
					padding-left:18px !important;
					padding-bottom:0 !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardBottomImageContent]{
					padding-bottom:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardTopImageContent]{
					padding-top:18px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
					padding-right:18px !important;
					padding-left:18px !important;
					padding-bottom:0 !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardBottomImageContent]{
					padding-bottom:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnImageCardTopImageContent]{
					padding-top:18px !important;
				}

		}	@media only screen and (max-width: 480px){
				table[class=mcnCaptionLeftContentOuter] td[class=mcnTextContent],table[class=mcnCaptionRightContentOuter] td[class=mcnTextContent]{
					padding-top:9px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnCaptionBlockInner] table[class=mcnCaptionTopContent]:last-child td[class=mcnTextContent]{
					padding-top:18px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnBoxedTextContentColumn]{
					padding-left:18px !important;
					padding-right:18px !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=mcnTextContent]{
					padding-right:18px !important;
					padding-left:18px !important;
				}

		}	@media only screen and (max-width: 480px){
				img[class=flexibleImage]{
					height:auto !important;
					width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section template width
			@tip Make the template fluid for portrait or landscape view adaptability. If a fluid layout doesn"t work for you, set the width to 300px instead.
			*/
				table[class=templateContainer]{
					/*@tab Mobile Styles
		@section template width
		@tip Make the template fluid for portrait or landscape view adaptability. If a fluid layout doesn"t work for you, set the width to 300px instead.*/max-width:600px !important;
					/*@editable*/width:100% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section heading 1
			@tip Make the first-level headings larger in size for better readability on small screens.
			*/
				h1{
					/*@editable*/font-size:24px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section heading 2
			@tip Make the second-level headings larger in size for better readability on small screens.
			*/
				h2{
					/*@editable*/font-size:20px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section heading 3
			@tip Make the third-level headings larger in size for better readability on small screens.
			*/
				h3{
					/*@editable*/font-size:18px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section heading 4
			@tip Make the fourth-level headings larger in size for better readability on small screens.
			*/
				h4{
					/*@editable*/font-size:16px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Boxed Text
			@tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
			*/
				table[class=mcnBoxedTextContentContainer] td[class=mcnTextContent],td[class=mcnBoxedTextContentContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:18px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Preheader Visibility
			@tip Set the visibility of the email"s preheader on small screens. You can hide it to save space.
			*/
				table[id=templatePreheader]{
					/*@editable*/display:block !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Preheader Text
			@tip Make the preheader text larger in size for better readability on small screens.
			*/
				td[class=preheaderContainer] td[class=mcnTextContent],td[class=preheaderContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:14px !important;
					/*@editable*/line-height:115% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Header Text
			@tip Make the header text larger in size for better readability on small screens.
			*/
				td[class=headerContainer] td[class=mcnTextContent],td[class=headerContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:18px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section Body Text
			@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
			*/
				td[class=bodyContainer] td[class=mcnTextContent],td[class=bodyContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:18px !important;
					/*@editable*/line-height:125% !important;
				}

		}	@media only screen and (max-width: 480px){
			/*
			@tab Mobile Styles
			@section footer text
			@tip Make the body content text larger in size for better readability on small screens.
			*/
				td[class=footerContainer] td[class=mcnTextContent],td[class=footerContainer] td[class=mcnTextContent] p{
					/*@editable*/font-size:14px !important;
					/*@editable*/line-height:115% !important;
				}

		}	@media only screen and (max-width: 480px){
				td[class=footerContainer] a[class=utilityLink]{
					display:block !important;
				}

		}</style></head>
		    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		        <center>
		            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
		                <tr>
		                    <td align="center" valign="top" id="bodyCell" style="padding-bottom:40px;">
		                        <!-- BEGIN TEMPLATE // -->
		                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
		                            <tr>
		                                <td align="center" valign="top">
		                                    <!-- BEGIN PREHEADER // -->
		                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templatePreheader">
		                                        <tr>
		                                            <td align="center" valign="top" style="padding-right:10px; padding-left:10px;">
		                                                <table border="0" cellpadding="0" cellspacing="0" width="800" class="templateContainer">
		                                                    <tr>
		                                                        <td align="center" valign="top">
		                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" id="preheaderBackground">
		                                                                <tr>
		                                                                    <td valign="top" class="preheaderContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock">
		</table></td>
		                                                                </tr>
		                                                            </table>
		                                                        </td>
		                                                    </tr>
		                                                </table>
		                                            </td>
		                                        </tr>
		                                    </table>
		                                    <!-- // END PREHEADER -->
		                                </td>
		                            </tr>
		                            <tr>
		                                <td align="center" valign="top">
		                                    <!-- BEGIN HEADER // -->
		                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateHeader">
		                                        <tr>
		                                            <td align="center" valign="top" style="padding-right:10px; padding-left:10px;">
		                                                <table border="0" cellpadding="0" cellspacing="0" width="800" class="templateContainer">
		                                                    <tr>
		                                                        <td align="center" valign="top">
		                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" id="headerBackground">
		                                                                <tr>
		                                                                    <td valign="top" class="headerContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageGroupBlock">
		</table></td>
		                                                                </tr>
		                                                            </table>
		                                                        </td>
		                                                    </tr>
		                                                </table>
		                                            </td>
		                                        </tr>
		                                    </table>
		                                    <!-- // END HEADER -->
		                                </td>
		                            </tr>
		                            <tr>
		                                <td align="center" valign="top">
		                                    <!-- BEGIN BODY // -->
		                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody">
		                                        <tr>
		                                            <td align="center" valign="top" style="padding-right:10px; padding-left:10px;">
		                                                <table border="0" cellpadding="0" cellspacing="0" width="600" class="templateContainer">
		                                                    <tr>
		                                                        <td align="center" valign="top">
		                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" id="bodyBackground">
		                                                                <tr>
		                                                                    <td valign="top" class="bodyContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock">
		    <tbody class="mcnDividerBlockOuter">
		        <tr>
		            <td class="mcnDividerBlockInner" style="padding: 18px;">
		                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%">
		                    <tbody><tr>
		                        <td>
		                            <span></span>
		                        </td>
		                    </tr>
		                </tbody></table>
		            </td>
		        </tr>
		    </tbody>
		</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock">
		    <tbody class="mcnTextBlockOuter">
		        <tr>
		            <td valign="top" class="mcnTextBlockInner">
		                
		                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="mcnTextContentContainer">
		                    <tbody><tr>
		                        
		                        <td valign="top" class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;">
		                        
		                            <h1>Parabéns! '.$nome.' Seu cadastro na IV SECOMP foi efetuado com sucesso!</h1>

		                        </td>
		                    </tr>
		                </tbody></table>
		                
		            </td>
		        </tr>
		    </tbody>
		</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock">
		    <tbody class="mcnDividerBlockOuter">
		        <tr>
		            <td class="mcnDividerBlockInner" style="padding: 18px;">
		                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%">
		                    <tbody><tr>
		                        <td>
		                            <span></span>
		                        </td>
		                    </tr>
		                </tbody></table>
		            </td>
		        </tr>
		    </tbody>
		</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock">
		    <tbody class="mcnDividerBlockOuter">
		        <tr>
		            <td class="mcnDividerBlockInner" style="padding: 18px;">
		                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top-width: 1px;border-top-style: solid;border-top-color: #999999;">
		                    <tbody><tr>
		                        <td>
		                            <span></span>
		                        </td>
		                    </tr>
		                </tbody></table>
		            </td>
		        </tr>
		    </tbody>
		</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock">
		    <tbody class="mcnDividerBlockOuter">
		        <tr>
		            <td class="mcnDividerBlockInner" style="padding: 18px;">
		                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%">
		                    <tbody><tr>
		                        <td>
		                            <span></span>
		                        </td>
		                    </tr>
		                </tbody></table>
		            </td>
		        </tr>
		    </tbody>
		</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock">
		    <tbody class="mcnTextBlockOuter">
		        <tr>
		            <td valign="top" class="mcnTextBlockInner">
		                
		                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="mcnTextContentContainer">
		                    <tbody><tr>
		                        
		                        <td valign="top" class="mcnTextContent" style="padding-top:9px; padding-right: 18px; padding-bottom: 9px; padding-left: 18px;">
		                        
		                            Visite o site da <a href="http://secomp2015.linkedej.com.br" target="_blank">SECOMP</a>&nbsp;para conferir a programação do evento!
		                        </td>
		                    </tr>
		                </tbody></table>
		                
		            </td>
		        </tr>
		    </tbody>
		</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock">
		    <tbody class="mcnDividerBlockOuter">
		        <tr>
		            <td class="mcnDividerBlockInner" style="padding: 18px;">
		                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%">
		                    <tbody><tr>
		                        <td>
		                            <span></span>
		                        </td>
		                    </tr>
		                </tbody></table>
		            </td>
		        </tr>
		    </tbody>
		</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageCardBlock">
		    <tbody class="mcnImageCardBlockOuter">
		        <tr>
		            <td class="mcnImageCardBlockInner" valign="top" style="padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:18px;">
		                


		<table border="0" cellpadding="0" cellspacing="0" class="mcnImageCardRightContentOuter" width="100%">
		    <tbody><tr>
		        <td valign="top" class="mcnImageCardRightContentInner" style="padding: 0px;background-color: #B3E9EC;">
		            <table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnImageCardRightImageContentContainer">
		                <tbody><tr>
		                    <td class="mcnImageCardRightImageContentE2E " valign="top" style="padding-top:0px; padding-right:0; padding-bottom:0px; padding-left:0px;">
		                    
		                        

		                        <img alt="" src="https://gallery.mailchimp.com/79f1130d7288ac723874c3478/images/0486bd91-d5f2-4bef-8968-b773c0da6fd7.png" width="194" style="max-width:220px;" class="mcnImage">
		                        

		                    
		                    </td>
		                </tr>
		            </tbody></table>
		            <table class="mcnImageCardRightTextContentContainer" align="right" border="0" cellpadding="0" cellspacing="0" width="352">
		                <tbody><tr>
		                    <td valign="top" class="mcnTextContent" style="padding-right: 18px;padding-top: 18px;padding-bottom: 18px;color: #000000;font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;text-align: left;">
		                        <h2>&nbsp;</h2>

		<h1 class="null" style="text-align: left;"><span style="font-size:24px">Dúvidas?</span></h1>
		Clique <a href="http://www.secomp2015.linkedej.com.br/" target="_blank">aqui</a> e fale conosco através do nosso formulário de contato no final da página.
		                    </td>
		                </tr>
		            </tbody></table>
		        </td>
		    </tr>
		</tbody></table>


		            </td>
		        </tr>
		    </tbody>
		</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock">
		    <tbody class="mcnDividerBlockOuter">
		        <tr>
		            <td class="mcnDividerBlockInner" style="padding: 18px;">
		                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%">
		                    <tbody><tr>
		                        <td>
		                            <span></span>
		                        </td>
		                    </tr>
		                </tbody></table>
		            </td>
		        </tr>
		    </tbody>
		</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock">
		    <tbody class="mcnButtonBlockOuter">
		        <tr>
		            <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
		                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border: 2px solid #707070;border-top-left-radius: 4px;border-top-right-radius: 4px;border-bottom-right-radius: 4px;border-bottom-left-radius: 4px;background-color: #202020;">
		                    <tbody>
		                        <tr>
		                            <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Arial; font-size: 16px; padding: 20px;">
		                                <a class="mcnButton " title="Acesse nosso site" href="http://www.secomp2015.linkedej.com.br/" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Acesse nosso site</a>
		                            </td>
		                        </tr>
		                    </tbody>
		                </table>
		            </td>
		        </tr>
		    </tbody>
		</table></td>
		                                                                </tr>
		                                                            </table>
		                                                        </td>
		                                                    </tr>
		                                                </table>
		                                            </td>
		                                        </tr>
		                                    </table>
		                                    <!-- // END BODY -->
		                                </td>
		                            </tr>
		                            <tr>
		                                <td align="center" valign="top">
		                                    <!-- BEGIN FOOTER // -->
		                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateFooter">
		                                        <tr>
		                                            <td align="center" valign="top" style="padding-right:10px; padding-left:10px;">
		                                                <table border="0" cellpadding="0" cellspacing="0" width="600" class="templateContainer">
		                                                    <tr>
		                                                        <td align="center" valign="top">
		                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" id="footerBackground">
		                                                                <tr>
		                                                                    <td valign="top" class="footerContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock">
		    <tbody class="mcnDividerBlockOuter">
		        <tr>
		            <td class="mcnDividerBlockInner" style="padding: 18px;">
		                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%">
		                    <tbody><tr>
		                        <td>
		                            <span></span>
		                        </td>
		                    </tr>
		                </tbody></table>
		            </td>
		        </tr>
		    </tbody>
		</table></td>
		                                                                </tr>
		                                                            </table>
		                                                        </td>
		                                                    </tr>
		                                                </table>
		                                            </td>
		                                        </tr>
		                                    </table>
		                                    <!-- // END FOOTER -->
		                                </td>
		                            </tr>
		                        </table>
		                        <!-- // END TEMPLATE -->
		                    </td>
		                </tr>
		            </table>
		        </center>
		    </body>
		</html>');
		if ($mail->send()){
			return "1";
			//Seta no banco que o email foi enviado
		}else{
			return "0";
		}
	}
	
}

?>