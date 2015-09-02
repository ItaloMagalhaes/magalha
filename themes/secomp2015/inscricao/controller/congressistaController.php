<?php
ob_start();
/*
	Importa os arquivos do MVC
*/
require ('model/congressistaModel.php');
require ('view/congressistaView.php');
require ('controller.php');

/**
 * sistemaController
 *
 * Esta classe contém as funções de acesso a dados do objeto sistema.
 *
 */

class congressistaController extends Controller
{

    public $model;
    public $view;

    /**
     * congressistaController::_construct()
     *
     * Construtor.
     *
     */
    public function __construct()
    {
        $this->model = new congressistaModel();
        $this->view = new congressistaView(); 
    }


       
    public function telaInicial(){
        
		session_start();
		if ($_SESSION['tipo_usuario'] != 4){
				$this->view->exibeAlerta();
				return false;
		} 
        
		/*
			Nesse caso, monta-se o menu a ser exibido.
		*/
		$idCongressista = $_SESSION['id_congressista'];
        $retornoQtdAtividadesCadastradas = $this->model->recuperaQtdAtividadesCadastradas($idCongressista);
        $retornoAtividades = $this->model->recuperaAtividades($idCongressista);
        $retornoAtividades2 = $this->model->recuperaStatus($idCongressista);
        $retornoQtdAtividadesTotais = $this->model->retornoQtdAtividadesTotais();
        $valorPendente = $this->model->buscarValorPendente($idCongressista);
		$this->view->telaInicial($retornoQtdAtividadesCadastradas, $retornoAtividades, $retornoAtividades2, $retornoQtdAtividadesTotais, $valorPendente);
    }
    
    
    /**
     * congressistaController::cadastrarcongressista()
     *
     * Chama o formulário de cadastro de congressista.
     *
     */
    public function exibirFormulario(){
    	$result = $this->model->verificarSituacaoCongressista();

		if($result == 1) $this->view->exibirFormulario();
		else $this->view->exibirMensagemInscricoesEncerradas();	
    }
    
    
    /**
     * congressistaController::adicionarOficina()
     *
     * Adiciona Oficinas.
     *
     */
    public function adicionarAtividade($codigo_congressista){
		
		if ( !isset( $_SESSION ) ){
            session_start();
        }
        
        if ($_SESSION['atividade']){
		    $atividade = $_SESSION['atividade'];        
	    }
	    
	    $atividade[] = $codigo_congressista;
		$_SESSION['atividade'] = $atividade;
	
	}
    
    
    /**
     * congressistaController::cadastrar()
     *
     * Faz o cadastro do monitor no banco de dados.
     *
     */
    public function cadastrar(){
        
		if (!isset($_SESSION)){
            session_start();
        }
		
		$result = $this->model->salvar();
		if ($result == 1) { 
		 	$arr = array ('tipo'=>1,'mensagem'=>"Cadasto efetuado com sucesso.",'redirecionar'=>"sistema.php?acao=login/telaInicial"); 
		 	echo json_encode($arr); 
		}
		if($result == 0) { 
			$arr = array ('tipo'=>0,'mensagem'=>"Não foi possivel efetuar o cadastro."); echo json_encode($arr); 
		}
		if($result == 2) { 
			$arr = array ('tipo'=>0,'mensagem'=>"CPF já cadastrado"); echo json_encode($arr); 
		}


    }
    
	
    
    /**
     * congressistaController::cadastrarDependente()
     *
     * Faz o cadastro do dependente no banco de dados.
     *
     */
    public function cadastrarDependente(){
			 
		$result = $this->model->salvarDependente();
		
		if ($result == 1){
			
			 echo "1|Dependente cadastrado com sucesso!|sistema.php?acao=home/telaInicial";//json_encode($json);
		}else{
			 
			 echo $result;//json_encode($json);
		}
    }    
    
     /**
     * congressistaController::escolherOficina()
     *
     * Lista as oficinas para que o congressista passo escolher em qual cadastrar.
     *
     */
    public function escolherOficina(){
		$this->view->escolherOficina();
	}
	
	     /**
     * congressistaController::salvarOficinacongressista()
     *
     * Salva a relação de congressista em oficina
     *
     */
    public function salvarOficinaCongressista(){
		$this->model->salvarOficinacongressista();
	}
	
	
	 /**
     * congressistaController::listagemOficinaCadastrada()
     *
     * Lista as oficinas que o congressista já esta cadastrado.
     *
     */
    public function listagemOficinaCadastrada(){
		$retorno = $this->model->buscarAtividadesCadastradas();
		$this->view->listagemOficinaCadastrada($retorno);
	}
    
     /**
     * congressistaController::exibirFormularioDependente()
     *
     * exibir o formulario de cadastro de dependente.
     *
     */
    public function exibirFormularioDependente(){
		$this->view->exibirFormularioDependente();
	
	}
    
    
    /**
     * congressistaController::listarDependente()
     *
     * exibi na tela todos os denpendetes de um asuario.
     *
     * Autor: Bruno M. Rafael
     */
    public function listarDependente(){
		$retorno = $this->model->buscarDependente();
		$this->view->listarDependente($retorno);	
	}
	
    /**
     * congressistaController::listarDependenteEscolhaOficina()
     *
     * Lista os dependentes para escolha das oficinas
     *
     * Autor: Jefferson Maia
     */
    public function listarDependenteEscolhaOficina(){
		$retorno = $this->model->buscarDependente();
		$this->view->listarDependenteEscolhaOficina($retorno);	
	}	
	
    
     /**
     * congressistaController::exibirDados()
     *
     * exibe na tela os dados do congressista
     *
     */
    public function exibirDadoCongressista(){
		
		$retorno = $this->model->buscarDado();
		
		$congressista = mysql_fetch_object($retorno);

		$GLOBALS['info']['nome'] = $congressista->nome;
		$GLOBALS['info']['dataNascimento'] = $this->model->converterDataTela($congressista->data_nascimento);
		$GLOBALS['info']['sexo'] = $congressista->sexo;
		$GLOBALS['info']['escolaridade'] = $congressista->escolaridade;
		$GLOBALS['info']['telefone'] = $congressista->telefone;
		$GLOBALS['info']['rua'] = $congressista->rua;
		$GLOBALS['info']['bairro'] = $congressista->bairro;
		$GLOBALS['info']['numero'] = $congressista->numero;
		$GLOBALS['info']['complemento'] = $congressista->complemento;
		$GLOBALS['info']['cidade'] = $congressista->cidade;
		$GLOBALS['info']['estado'] = $congressista->estado;
		$GLOBALS['info']['cep'] = $congressista->cep;
		$GLOBALS['info']['login'] = $congressista->login;
		$GLOBALS['info']['senha'] = $congressista->senha;
		$this->view->exibirDadocongressista();
	}
	
	 /**
     * congressistaController::exibirDadoDependente()
     *
     * exibe na tela os dados do denpendete
     *
     * autor: Bruno M. Rafael
     */
    public function exibirDadoDependente(){
		
		$codigoDependente = $_GET["id"];
		
		$retorno = $this->model->buscarDadoDependente($codigoDependente);
		
		$congressista = mysql_fetch_object($retorno);
		$GLOBALS['info']['nome'] = $congressista->nome;
		$GLOBALS['info']['escolaridade'] = $congressista->escolaridade;
		$GLOBALS['info']['sexo'] = $congressista->sexo;
		$GLOBALS['info']['dataNascimento'] = $this->model->converterDataTela($congressista->data_nascimento);
		$GLOBALS['info']['codigoDependente'] = $codigoDependente;
		$this->view->exibirDadoDependente();
	}
		
	 /**
     * congressistaController::alterarDado()
     *
     * guarda os dados alterado do congressista
     *
     */
    public function alterarDado(){	
	
		$result = $this->model->alterarDado();
		
		if ($result == 1){
			echo "1|Dados alterados com sucesso!|sistema.php?acao=home/telaInicial";
			//$json["mensagem"] = "Dados alterados com sucesso!";
			//echo json_encode($json);
		}else{
			 //$json["mensagem"] = "Erro ao efetuar o cadastro!";
			 //echo json_encode($json);
			 echo $result;
		}
			
	}

	 /**
     * congressistaController::alterarDadoDependente()
     *
     * guarda os dados alterado do dependente
     *
	 *autor : Bruno M. Rafael
     */
    public function alterarDadoDependente(){	
		
		$result = $this->model->alterarDadoDependente();
		
		if ($result == 1){
			echo "1|Dados alterados com sucesso!|sistema.php?acao=home/telaInicial";
		}else{
			 echo "0|Erro ao alterar dados";
		}
    			
		
	}
	
	
     /**
     * congressistaController::exibirOficinasBoleto()
     *
     * exibe os dados das oficinas para geração de boleto
     *
     */
    public function exibirOficinasBoleto(){
		$retorno = $this->model->exibirOficinasBoleto();
		$this->view->exibirOficinasBoleto($retorno);
	}	
	
     /**
     * congressistaController::exibirOficinasCertificado()
     *
     * exibe os dados das oficinas para geração de certificados
     *
     */
    public function exibirOficinasCertificado(){
		$retorno = $this->model->exibirOficinasCertificado();
		$this->view->exibirOficinasCertificado($retorno);
	}		
	

    /**
     * congressistaController::getInfoSessao()
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
     * congressistaController::verificarCpf()
     *
     * Vefirica se um cpf já se encontra cadastrado no banco.
     *
     */	
	public function verificarCpf(){
		$resultado = $this->model->verificarCpf();
		
		if($resultado == 1) echo '1';
		else echo '0';			
	}
		
	/**
     * congressistaController::verificarEmail()
     *
     * Vefirica se um email já se encontra cadastrado no banco.
     * 0 -> não cadastrado
	 * 1 -> já cadastrado
     *
     */	
	public function verificarEmail(){
		$resultado = $this->model->verificarEmail();

		if($resultado == 1) echo '1';
		else echo '0';		
		
	}	
	
	/**
     * congressistaController::verificarEmailcongressista()
     *
     * Vefirica se um email já se encontra cadastrado no banco.
     *
     */	
	public function verificarEmailCongressista(){

		$resultado = $this->model->verificarEmailcongressista();
		
		if($resultado == 1) echo '1';
		else echo '0';		
	}	
	
	/**
     * congressistaController::telaSituacao()
     *
     * Exibe tela de busca, para obter os dados de um congressista.
     *
     */	
	public function telaSituacao(){
		$palavra = $_GET["palavra"];
		
		$result = $this->model->selecionarcongressista($palavra);
		$this->view->telaSituacao($result);
	}
	
	/**
     * congressistaController::exibirSituacao()
     *
     * Exibe tela de busca, para obter os dados de um congressista.
     *
     */	
	public function exibirSituacao(){
		$id = $_GET["id"];
		
		$result = $this->model->obterDadosSituacaocongressista($id);
		$this->view->exibirDadosSituacaocongressista($result);
	}
	
	/**
     * congressistaController::selecionarDadosBoleto()
     *
     * Busca os dados do boleto e preenche-o.
     *
     */	
	public function selecionarDadosBoleto(){
		
		$resultado = $this->model->selecionarDadosBoleto();
		$encerramento = $this->model->buscarDataVencimentoBoleto();
		$result = $this->view->selecionarDadosBoleto($resultado, $encerramento);
		
		if ($result != 1){
			echo $result;
		}
	}
	
	/**
     * congressistaController::excluirDependente()
     *
     * Busca os dados do boleto e preenche-o.
     *
     */	
	public function excluirDependente(){
		$id = $this->model->get("id");
		
		if($resultado = $this->model->excluirDependente($id)){
			$this->listarDependente();
		}	
		
	}


	public function listagemAtividadeEditar(){
 		if ( !isset( $_SESSION ) ){
           session_start();
       	} 
		$identificador = $_GET['id'];

		
		$id = $this->model->recuperaId($identificador);
		$_SESSION['congressista_editar'] = $identificador;
		$_SESSION["atividade"] = "";
		
		$resultado = $this->model->obterAtividadesCongressista($identificador);
		
		
		if(mysql_num_rows($resultado) > 0){
			
			while($dado = mysql_fetch_array($resultado)){
				$this->adicionarAtividade($dado["fid_atividade"]);
			}	
		}
		

		$result = $this->model->listagemAtividade();
		$this->view->listagemAtividadesEditar($result);	
    } 

	/**
     * alunoController::listagemAtividade()
     *
     * Chama o formulário de cadastro de aluno.
     *
     */
    public function listagemAtividade(){
		
		session_start();
		$id = $this->model->recuperaId($_SESSION['fid_usuario']);
		$resultado = $this->model->verificarPagamento($id);
		if ($resultado == 0) {
			$_SESSION["atividade"] = "";
			$resultado = $this->model->obterAtividadesCongressista($id);
			if(mysql_num_rows($resultado) > 0){	
				while($dado = mysql_fetch_array($resultado)){
					$this->adicionarAtividade($dado["fid_atividade"]);
				}	
			}
			$result = $this->model->listagemAtividade();
			$this->view->listagemAtividade($result);
		} else {
			$this->view->exibirMensagemPagamento();
		}
    }

	/**
     * oficinaController::matriculaAluno()
     *
     * Faz o cadastro do aluno nas oficinas que ele houver selecionado.
     *
     */
    public function matricularCongressista(){
		session_start();
		$id = $this->model->recuperaId($_SESSION['fid_usuario']);
		$result = $this->model->matricularCongressistaAtividade($id);
		
		
		if ($result > 0) { 
		 	$arr = array ('tipo'=>1,'mensagem'=>"Matrícula efetuada com sucesso!",'redirecionar'=>"sistema.php?acao=congressista/listagemAtividadeCadastrada"); 
		 	echo json_encode($arr); 
		}
		if($result == 0) { 
			$arr = array ('tipo'=>0,'mensagem'=>"Não foi possivel efetuar o cadastro."); 
			echo json_encode($arr); 
		}
	}

	 public function matricularCongressistaEditar(){
		if ( !isset( $_SESSION ) ){
           session_start();
       	} 

       	$id = $_SESSION['congressista_editar'];
		$result = $this->model->matricularCongressistaAtividade($id);
		
		
		if ($result > 0) { 
		 	$arr = array ('tipo'=>1,'mensagem'=>"Matrícula efetuada com sucesso!",'redirecionar'=>"sistema.php?acao=adminCredenciamento/listarParticipantes"); 
		 	echo json_encode($arr); 
		}
		if($result == 0) { 
			$arr = array ('tipo'=>0,'mensagem'=>"Não foi possivel efetuar o cadastro."); 
			echo json_encode($arr); 
		}
	}

	public function listagemAtividadeCadastrada(){
		
		$retorno = $this->model->listarAtividadesCadastradas();
		$this->view->listarAtividadesCadastradas($retorno);
	}

	public function listarAreas(){
		$result = $this->model->listarAreas();
		$this->view->listarAreas($result);
	}	
	public function listagemCertificados(){
 		if ( !isset( $_SESSION ) ){
           session_start();
       	} 
		$retorno = $this->model->listarAtividadesCadastradas();
		$retorno2 = $this->model->listarParticipacao();
		$retorno3 = $this->model->listarApresentacaoArtigo();
		$this->view->listarAtividadesCertificados($retorno,$retorno2,$retorno3);
		
    } 

    /**
     * congressistaController::exibirFormularioDireto()
     *
     * Chama o formulário de cadastro de congressista.
     *
     */
    public function exibirFormularioDireto(){
		$this->view->exibirFormulario();
    }

    public function listagemAtividadeCongressista(){
    	
    	$id = $_GET['id'];
    	$_SESSION['id_congressista'] = $id;
		$retorno = $this->model->listarAtividadesCongressista($id);
		$this->view->listarAtividadesCongressista($retorno);
	}
     
}

?>
