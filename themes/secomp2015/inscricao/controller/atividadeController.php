<?php

/*
	Importa os arquivos do MVC
*/
require ('model/atividadeModel.php');
require ('view/atividadeView.php');
require ('controller.php');

/**
 * sistemaController
 *
 * Esta classe contém as funções de acesso a dados do objeto sistema.
 *
 */

class AtividadeController extends Controller
{

    public $model;
    public $view;

    /**
     * AtividadeController::_construct()
     *
     * Construtor.
     *
     */
    public function __construct()
    {
        $this->model = new atividadeModel();
        $this->view = new atividadeView(); 
    }

     /**
     * AtividadeController::listar()
     *
     * Faz o cadastro de Atividade no banco de dados.
     * 
     * Autor: Jefferson
     *
     */
    public function listarAtividades(){
        
		if ( !isset( $_SESSION ) ){
		   session_start();
		}
		/*
			Nesse caso, monta-se o menu a ser exibido.
		*/
		$resultado = "";
		$resultado = $this->model->listarAtividade();
		$this->view->listarAtividades($resultado);
			
    }    

    public function removerAtividade(){
	   
	   if ( !isset( $_SESSION ) ){
		   session_start();
	   }
   
       if ($_SESSION['atividade']){
	       $atividade = $_SESSION['atividade'];        
	   }
	   $id = $this->model->recuperaId($_SESSION['fid_usuario']);

	   // Caso essa oficina ja esteja no banco de dados para esse usuario, apaga de la tambem.
	   $codigo_atividade = $_GET["id"];
	   
	   $pg = 0;
	   
	   if(mysql_num_rows($pg) == 0){
		   //Exclui essa oficina da lista de oficinas	
		   
		   $ok = $this->model->excluirParticipacaoAtividade($codigo_atividade,$id);
		   if ($ok > 0){
			   $key = array_search($codigo_atividade,$atividade);
			   unset($atividade[$key]);
			   $_SESSION['atividade'] = $atividade;
			   //echo funciona como se fosse um return para o javascript
			   echo 'teste'.$codigo_atividade;
			} else {
				echo '-1';
			}		
		}else{
			echo '0';   
		}
	}

	public function removerAtividadeEditar(){
	   
	   if ( !isset( $_SESSION ) ){
		   session_start();
	   }
   
       if ($_SESSION['atividade']){
	       $atividade = $_SESSION['atividade'];        
	   }
	   $id = $_SESSION['congressista_editar'];

	   // Caso essa oficina ja esteja no banco de dados para esse usuario, apaga de la tambem.
	   $codigo_atividade = $_GET["id"];
	   
	   $pg = 0;
	   
	   if(mysql_num_rows($pg) == 0){
		   //Exclui essa oficina da lista de oficinas	
		   
		   $ok = $this->model->excluirParticipacaoAtividade($codigo_atividade,$id);
		   if ($ok > 0){
			   
			   $key = array_search($codigo_atividade,$atividade);
			   unset($atividade[$key]);
			   $_SESSION['atividade'] = $atividade;
			   //echo funciona como se fosse um return para o javascript
			   echo 'teste'.$codigo_atividade;
			
			}else {
				echo '-1';
			}
		
		}else{
			echo '0';   
		}
	}

    /**
     * AtividadeController::exibirFormulario()
     *
     * Exibe o formulário de cadastro de Atividade.
     *
     */
    public function selecionarAtividade(){
		
		
		if ( !isset( $_SESSION ) ){
            session_start();
        }
		 
		/* Seleciona os funcionarios */
		$resultado = "";
		$resultado = $this->model->selecionarAtividade();
		
		/* Exibe a lista de funcionarios desejada. Por padrao exibe todos no limite de 10. */
		$this->view->selecionarAtividade($resultado);
    
	}

	public function selecionarAtividadeFiltro(){
		
		
		if ( !isset( $_SESSION ) ){
            session_start();
        }
		 
		/* Seleciona os funcionarios */
		$resultado = "";
		$resultado = $this->model->selecionarAtividadeFiltro();
		
		/* Exibe a lista de funcionarios desejada. Por padrao exibe todos no limite de 10. */
		$this->view->selecionarAtividadeFiltro($resultado);
    
	}	
	
	/**
     * atividadeController::verMais()
     *
     * Exibe informações das atividades.
     *
     */
    public function verMais (){
		$id = $_GET["id"];
		$listaDeAtividades = $this->model->selecionarDadosAtividade($id);
		$listaDeVagas = $this->model->selecionarQuantPagamentos($id);
		$this->view->verMais($listaDeAtividades, $listaDeVagas);
	}

	public function exibirFormularioAtividade(){
        
		session_start();
		if ($_SESSION['tipo_usuario'] != 1){
				$this->view->exibeAlerta();
				return false;
		}
		
		/*
			Nesse caso, monta-se o menu a ser exibido.
		*/
		$this->view->exibirFormularioAtividade();
    }
    
    /**
     * AtividadeController::cadastrar()
     *
     * Faz o cadastro de Atividade no banco de dados.
     *
     */
    public function cadastrarAtividade(){
        
		session_start();
		
		/*
			Nesse caso, monta-se o menu a ser exibido.
		*/
		
		$result = $this->model->salvar();
		if ($result == 1) { 
		 	$arr = array ('tipo'=>1,'mensagem'=>"Atividade cadastrada efetuado com sucesso.",'redirecionar'=>"sistema.php?acao=site/telaInicial"); 
		 	echo json_encode($arr); 
		}
		if($result == 0) { 
			$arr = array ('tipo'=>0,'mensagem'=>"Não foi possivel efetuar o cadastro."); 
			echo json_encode($arr); 
		}		
    }

    /**
     * AtividadeController::getInfoSessao()
     *
     * Recupera um dado contido numa sessão.
     *
     */
    public function getInfoSessao(){
		
		$campo = $this->model->get('campo');
		$sesao = $_SESSION[$campo];
		echo json_encode($sesao);
	
	}

	/**
     * AtividadeController::adicionarAtividade()
     *
     * Exibe dados da oficina que deseja editar.
     * Autor: Thiago Gomides / Gleyberson Andrade
     */
	public function exibirDadoAtividade(){
		$codigoAtividade = $this->model->get("id");
		$retorno = $this->model->buscarDadoAtividade($codigoAtividade);
		
		$atividade = mysql_fetch_object($retorno);
		$GLOBALS['info']['nome'] = $atividade->nome;
		$GLOBALS['info']['id_atividade'] = $atividade->id_atividade;
		$GLOBALS['info']['carga_horaria'] = $atividade->carga_horaria;
		$GLOBALS['info']['horario_inicio'] = $atividade->horario_inicio;
		$GLOBALS['info']['horario_termino'] = $atividade->horario_termino;
		$GLOBALS['info']['local'] = $atividade->local;
		$GLOBALS['info']['preponente'] = $atividade->nome_preponente;
		$GLOBALS['info']['descricao'] = $atividade->descricao;
		$GLOBALS['info']['data_inicio'] = $atividade->data_inicio;
		$GLOBALS['info']['data_termino'] = $atividade->data_termino;
		$GLOBALS['info']['n_vagas'] = $atividade->n_vagas;
		$this->view->exibirDadoAtividade();
	}

	public function alterarDadoAtividade(){	
		
		$result = $this->model->alterarDadoAtividade();
		
		if ($result == 1) { 
		 	$arr = array ('tipo'=>1,'mensagem'=>"Dados alterados com sucesso!.",'redirecionar'=>"sistema.php?acao=home/telaInicial"); 
		 	echo json_encode($arr); 
		}else{ 
			$arr = array ('tipo'=>0,'mensagem'=>"Erro ao alterar dados!."); echo json_encode($arr); 
		}    			
		
	}

	/**
     * AtividadeController::adicionarAtividade()
     *
     * Adiciona Atividades.
     *
     */
    public function adicionarAtividade($codigo_atividade){
		
		if ( !isset( $_SESSION ) ){
            session_start();
        }
        
        if ($_SESSION['atividade']){
		    $atividade = $_SESSION['atividade'];        
	    }
	    
	    $atividade[] = $codigo_atividade;
		$_SESSION['atividade'] = $atividade;
	
	}
		
	public function excluirAtividade(){
	   
	   if ( !isset( $_SESSION ) ){
		   session_start();
	   } 
       // Caso essa Atividade ja esteja no banco de dados para esse usuario, apaga de la tambem.
	   $codigo_Atividade = $_GET["id"];
	   
	   $this->model->excluirAtividade($codigo_Atividade);
	}
	/**
     * oficinaController::verificarDisponibilidade()
     *
     * Verifica se um aluno pode se matricular em uma oficina.
     *
     */
    public function verificarDisponibilidade(){

		
		/*Codigo da oficina*/
		$id = $_GET["id"];
		
		
		if ( !isset( $_SESSION ) ){
	            session_start();
	        }
	        
	        if ($_SESSION['atividade']){
			    $atividade = $_SESSION['atividade'];     
		    }else{ 
		    	//Nesse caso, nenhuma atividade no banco, bate horario com a oficina escolhida.
				$this->adicionarAtividade($id);
				echo '3|'.$id; exit;
		    }	
		

		
		$resultado = $this->model->obterDadosAtividade($id);
		
		while($dado = mysql_fetch_object($resultado)){
			$horario_inicio =  $dado->horario_inicio;
			$horario_termino = $dado->horario_termino;
			$data_inicio =  $dado->data_inicio;
			$data_termino =  $dado->data_termino;
			$vagas = $dado->n_vagas;
			$total = $dado->total;	
		}		
		
		/*Verifica se a oficina ainda tem vagas*/
		if($total >= $vagas){
			
			/*Adiciona essa oficina para o aluno. Porem, na fila de espera*/
			$this->adicionarAtividade($id);
			echo '2|'.$id; exit;
		}
		
		//----------------------Verificando se bate horário--------------//
		
		$resultado = $this->model->verificarHorario($id, $horario_inicio, $horario_termino, $data_inicio, $data_termino);
		
		//------------------------verificado-----------------------------//
		
		if(mysql_num_rows($resultado) == 0){
			
			//Nesse caso, nenhuma oficna no banco, bate horario com a oficina escolhida.
			$this->adicionarAtividade($id);
			echo '3|'.$id;
		
		}else{
			/*Existem oficinas que batem horario com a oficina selecionada. 
			Basta checar, se o usuario ja está matriculado em alguma delas.*/
			
			$aux = $this->verificacao($resultado);
			if (!empty($aux)){
				echo "Não é possível se inscrever nessa oficina. Existe um conflito de horário com a oficina ".$aux."|".$id;
			}else{
				//Nesse caso, nenhuma oficna no banco, bate horario com a oficina escolhida.
				$this->adicionarAtividade($id);
				echo '3|'.$id;
			}
		}
	}

	/**
     * atividadeController::verificacao()
     *
     * Verifica as atividades.
     *
     */
    public function verificacao($resultado){
		
		if ( !isset( $_SESSION ) ){
            session_start();
        }
        
        if ($_SESSION['atividade']){
		    $atividade = $_SESSION['atividade'];        
	    }
	    
	    while($dado = mysql_fetch_object($resultado)){
				
			if(isset($atividade)){	
				if (in_array($dado->id_atividade,$atividade)){
					return $dado->nome;
				}
			}	
		}
		return 0;	
	}	

	public function criarPdf($orientacao) {

		//Incluindo o arquivo onde está a Classe FPDF
		require ("fpdf/fpdf.php");

		//Definindo o diretório das fontes
		define("FPDF_FONTPATH", "fpdf/font/");

		//Iniciando o construtor FPDF
		$pdf = new FPDF($orientacao, "mm", "A4");

		header("Content-type: application/pdf; charset=utf-8");

		return $pdf;
	}

	public function estruturaRelatorioHorizontal($pdf) {

		$pdf->AddPage();

		//Definindo titulo do evento
		$pdf->SetFont("Helvetica", "B", 16); //SetFont($fonte, $estilo, $tamanho);
		$nome = utf8_decode("IV SECOMP");
		$pdf->SetXY(128, 10, 1);
		//Inserindo célula de texto
		$pdf->Cell(0, 5, $nome);

		//Definindo data e hora
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');
		$hora = date('H:i:s');
		$data = $data . " " . $hora;
		$pdf->SetFont("Helvetica", "B", 8); //SetFont($fonte, $estilo, $tamanho);
		$pdf->SetXY(230, 25, 1);
		//Inserindo célula data e hora
		$pdf->Cell(0, 5, $data);

		//Definindo Rodapé
		// Gerando um rodapé simples
		$pdf->Line(13, 186, 284, 186); // insere linha divisória

		$pdf->SetXY(270, 189); //posição para o texto

		// Pega o número da página
		$conteudo = " Pag. " . $pdf->PageNo(); //pegando o número da página

		$pdf->Cell(0, 0, $conteudo); //Insere célula de texto alinhado à direita
	}

	public function imprimirAtividades(){

		$pdf = $this->criarPdf("L");

		$this->estruturaRelatorioHorizontal($pdf);

		//Definindo titulo do relatorio
		$pdf->SetFont("Helvetica", "B", 14); //SetFont($fonte, $estilo, $tamanho);
		$nome = utf8_decode("Relatório das Atividades Cadastradas");
		$pdf->SetXY(100, 25, 1);
		$pdf->Cell(0, 5, $nome);

		$pdf->SetFont("Helvetica", "B", 10);
		$nome = utf8_decode("Atividade");
		$pdf->SetXY(13, 37, 1);
		$pdf->Cell(0, 5, $nome);

		$nome = utf8_decode("Data da atividade");
		$pdf->SetXY(100, 37, 1);
		$pdf->Cell(0, 5, $nome);

		$nome = utf8_decode("Horário de início");
		$pdf->SetXY(135, 37, 1);
		$pdf->Cell(0, 5, $nome);

		$nome = utf8_decode("Horário de término");
		$pdf->SetXY(165, 37, 1);
		$pdf->Cell(0, 5, $nome);

		$nome = utf8_decode("Data de matrícula");
		$pdf->SetXY(200, 37, 1);
		$pdf->Cell(0, 5, $nome);

		$nome = utf8_decode("Pagamento");
		$pdf->SetXY(235, 37, 1);
		$pdf->Cell(0, 5, $nome);

		$nome = utf8_decode("Status");
		$pdf->SetXY(260, 37, 1);
		$pdf->Cell(0, 5, $nome);

		$pdf->Line(13, 36, 284, 36); // insere linha divisória em cima dos campos

		$pdf->Line(13, 42, 284, 42); // insere linha divisória embaixo dos campos

		$vetor = $this->model->imprimirAtividades();

		$pdf->SetFont("Helvetica", "", 10); //SetFont($fonte, $estilo, $tamanho);

		$tamanhoVetor = count($vetor);

		// Coordenada Y da página
		$y = 38;

		$quantidade = 0;

		for ($i = 0; $i < $tamanhoVetor; $i++)
		{

			$y = $y + 5;

			// Nome
			$nome = utf8_decode($vetor[$i][0]);
			$nome = trim($nome);
			$nome = strtoupper(substr($nome,0,39));
			$pdf->SetXY(13, $y, 1);
			$pdf->Cell(0, 5, $nome);

			// Matricula
			$pdf->SetXY(105, $y, 1);
			$pdf->Cell(0, 5, $vetor[$i][1]);

			// CPF
			$pdf->SetXY(144, $y, 1);
			$pdf->Cell(0, 5, $vetor[$i][2]);

			// Area
			$area = $vetor[$i][3];
			$pdf->SetXY(177, $y, 1);
			$pdf->Cell(0, 5, $area);

			// Telefone
			$pdf->SetXY(206, $y, 1);
			$pdf->Cell(0, 5, $vetor[$i][4]);

			// Telefone
			$pdf->SetXY(237, $y, 1);
			$pdf->Cell(0, 5, $vetor[$i][5]);

			// Email
			$email = $vetor[$i][6];
			$pdf->SetXY(260, $y, 1);
			$pdf->Cell(0, 5, $email);

			$quantidade++;

			if ($quantidade == 27)
			{

				$y = 43;
				$quantidade = 0;

				$this->estruturaRelatorioHorizontal($pdf);

				//Definindo titulo do relatorio
				$pdf->SetFont("Helvetica", "B", 14); //SetFont($fonte, $estilo, $tamanho);
				$nome = utf8_decode("Relatório das Atividades Cadastradas");
				$pdf->SetXY(100, 25, 1);
				$pdf->Cell(0, 5, $nome);

				$pdf->SetFont("Helvetica", "B", 10);
				$nome = utf8_decode("Atividade");
				$pdf->SetXY(13, 37, 1);
				$pdf->Cell(0, 5, $nome);

				$nome = utf8_decode("Data da atividade");
				$pdf->SetXY(100, 37, 1);
				$pdf->Cell(0, 5, $nome);

				$nome = utf8_decode("Horário de início");
				$pdf->SetXY(135, 37, 1);
				$pdf->Cell(0, 5, $nome);

				$nome = utf8_decode("Horário de término");
				$pdf->SetXY(165, 37, 1);
				$pdf->Cell(0, 5, $nome);

				$nome = utf8_decode("Data de matrícula");
				$pdf->SetXY(200, 37, 1);
				$pdf->Cell(0, 5, $nome);

				$nome = utf8_decode("Pagamento");
				$pdf->SetXY(235, 37, 1);
				$pdf->Cell(0, 5, $nome);

				$nome = utf8_decode("Status");
				$pdf->SetXY(260, 37, 1);
				$pdf->Cell(0, 5, $nome);

				$pdf->Line(13, 36, 284, 36); // insere linha divisória em cima dos campos

				$pdf->Line(13, 42, 284, 42); // insere linha divisória embaixo dos campos

				$pdf->SetFont("Helvetica", "", 10); //SetFont($fonte, $estilo, $tamanho);

					// Nome
				$nome = utf8_decode($vetor[$i][0]);
				$nome = trim($nome);
				$nome = strtoupper(substr($nome,0,39));
				$pdf->SetXY(13, $y, 1);
				$pdf->Cell(0, 5, $nome);

				// Matricula
				$pdf->SetXY(105, $y, 1);
				$pdf->Cell(0, 5, $vetor[$i][1]);

				// CPF
				$pdf->SetXY(144, $y, 1);
				$pdf->Cell(0, 5, $vetor[$i][2]);

				// Area
				$area = $vetor[$i][3];
				$pdf->SetXY(177, $y, 1);
				$pdf->Cell(0, 5, $area);

				// Telefone
				$pdf->SetXY(206, $y, 1);
				$pdf->Cell(0, 5, $vetor[$i][4]);

				// Telefone
				$pdf->SetXY(237, $y, 1);
				$pdf->Cell(0, 5, $vetor[$i][5]);

				// Email
				$email = $vetor[$i][6];
				$pdf->SetXY(260, $y, 1);
				$pdf->Cell(0, 5, $email);
			}
		}

		//Definindo data e hora
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d.m.Y');
		$hora = date('H:i:s');

		$pdf->Output("relatorioAtividades_" . $data . "_" . $hora . ".pdf", "D");
		echo "Relatorio gerado com sucesso";
	}

		public function listaPresenca($atividade, $alunos){

		$pdf = $this->criarPdf("L");

		$this->estruturaRelatorioHorizontal($pdf);

		//Definindo titulo do relatorio
		$pdf->SetFont("Helvetica", "B", 14); //SetFont($fonte, $estilo, $tamanho);
		$nome = utf8_decode("Lista de Presença - ");
		$pdf->SetXY(13, 25, 1);
		$pdf->Cell(0, 5, $nome);

		$pdf->SetFont("Helvetica", "B", 14); //SetFont($fonte, $estilo, $tamanho);
		$nome = utf8_decode($atividade);
		$pdf->SetXY(60, 25, 1);
		$pdf->Cell(0, 5, $nome);

		$pdf->SetFont("Helvetica", "B", 10);
		$nome = utf8_decode("Aluno");
		$pdf->SetXY(13, 37, 1);
		$pdf->Cell(0, 5, $nome);

		$nome = utf8_decode("Assinatura");
		$pdf->SetXY(200, 37, 1);
		$pdf->Cell(0, 5, $nome);

		$pdf->Line(13, 36, 284, 36); // insere linha divisória em cima dos campos

		$pdf->Line(13, 42, 284, 42); // insere linha divisória embaixo dos campos

		$pdf->SetFont("Helvetica", "", 10); //SetFont($fonte, $estilo, $tamanho);

		$tamanhoVetor = count($alunos);

		// Coordenada Y da página
		$y = 38;

		$quantidade = 0;

		for ($i = 0; $i < $tamanhoVetor; $i++)
		{

			$y = $y + 5;

			$quantidade++;

			if ($quantidade == 28)
			{

				$y = 43;
				$quantidade = 0;

				$this->estruturaRelatorioHorizontal($pdf);

				//Definindo titulo do relatorio
				$pdf->SetFont("Helvetica", "B", 14); //SetFont($fonte, $estilo, $tamanho);
				$nome = utf8_decode("Lista de Presença - ");
				$pdf->SetXY(13, 25, 1);
				$pdf->Cell(0, 5, $nome);

				$pdf->SetFont("Helvetica", "B", 14); //SetFont($fonte, $estilo, $tamanho);
				$nome = utf8_decode($atividade);
				$pdf->SetXY(60, 25, 1);
				$pdf->Cell(0, 5, $nome);

				$pdf->SetFont("Helvetica", "B", 10);
				$nome = utf8_decode("Aluno");
				$pdf->SetXY(13, 37, 1);
				$pdf->Cell(0, 5, $nome);

				$nome = utf8_decode("Assinatura");
				$pdf->SetXY(200, 37, 1);
				$pdf->Cell(0, 5, $nome);

				$pdf->Line(13, 36, 284, 36); // insere linha divisória em cima dos campos

				$pdf->Line(13, 42, 284, 42); // insere linha divisória embaixo dos campos

				$pdf->SetFont("Helvetica", "", 10); //SetFont($fonte, $estilo, $tamanho);
			}
			// Nome
			$nome = utf8_decode($alunos[$i]);
			$nome = trim($nome);
			$nome = strtoupper(substr($nome,0,39));
			$pdf->SetXY(13, $y, 1);
			$pdf->Cell(0, 5, $nome);
		}

		//Definindo data e hora
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d.m.Y');
		$hora = date('H:i:s');

		$pdf->Output("relatorioAtividades_" . $data . "_" . $hora . ".pdf", "D");
		echo "Relatorio gerado com sucesso";
	}

	public function listarParticipantesAtividade(){

        if ( !isset( $_SESSION ) ){
            session_start();
        }

        $resultado = "";
        $id = $_GET["id"];
        
        $_SESSION["id_atividade"] = $id;
        $_SESSION["participante"] = "";
        
        $atividade = $this->model->buscarNomeAtividade($id);
        $resultado = $this->model->listagemParticipantesAtividade($id);
        $this->listaPresenca($atividade, $resultado);
    }
}

?>