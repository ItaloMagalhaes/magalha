<?php

/*
	Importa os arquivos do MVC
*/
require ('model/adminPagamentoModel.php');
require ('view/adminPagamentoView.php');
require ('controller.php');

/**
 * adminPagamentoController
 *
 * Esta classe contém as funções de acesso a dados do objeto adminPagamento.
 *
 */

class adminPagamentoController extends Controller
{

    public $model;
    public $view;

    /**
     * adminPagamentoController::_construct()
     *
     * Construtor.
     *
     */
    public function __construct()
    {
        $this->model = new adminPagamentoModel();
        $this->view = new adminPagamentoView(); 
    }
    public function telaInicial(){
        
        /*
            Nesse caso, monta-se o menu a ser exibido.
        */
        $valorPadrao = $this->model->recuperaValorPadrao();
        $status = $this->model->recuperaStatus();
        $retorno = $this->model->recuperaLinhasUsuarios();
        $retorno1 = $this->model->recuperaLinhasPagamento();
        $retorno2 = $this->model->recuperaQtdPagamentoEfetuados($valorPadrao);
        $retornoPagamentoTotais = $this->model->recuperaQtdPagamentoTotais($valorPadrao);
        $qtdAtividades = $this->model->recurperaQtdAtividades();
        $cong = $this->model->recurperaQtdCong();
        $this->view->telaInicial($retorno,$retorno1,$retorno2,$retornoPagamentoTotais,$valorPadrao,$status,$qtdAtividades,$cong);
    }

    public function salvarValores(){
        
        session_start();
        
        $result = $this->model->editarValores();
        if ($result == 1) { 
            $arr = array ('tipo'=>1,'mensagem'=>"Valores editados com sucesso.",'redirecionar'=>"sistema.php?acao=home/telaInicial"); 
            echo json_encode($arr); 
        }
        if($result == 0) { 
            $arr = array ('tipo'=>0,'mensagem'=>"Não foi possivel efetuar o cadastro.");
            echo json_encode($arr); 
        }
    }

    public function editarValores() {
        $retornoSQL = $this->model->buscarValoresAtuais();
        $atividade = mysql_fetch_object($retornoSQL);
        $GLOBALS['info']['valorPadrao'] = $atividade->valor_padrao;
        $GLOBALS['info']['acrescimo'] = $atividade->acrescimo;
        $this->view->editarValores();
    }

    public function efetuarPagamento(){
        $id = $_GET["id"];
        $resultado = "";
        $resultado = $this->model->setarPagamento($id);
        $resultado2 = "";
        $resultado2 = $this->model->selecionarCongressista($id);
        $congressista = mysql_fetch_array($resultado2);
    }

    public function removerPagamento(){
        $id = $_GET["id"];
        $resultado = "";
        $resultado = $this->model->removerPagamento($id);
    }
    
    /**
     * adminPagamentoController::telaInicial()
     *
     * Exibe alguma tela dada como padrão.
     *
     */
    public function listarParticipantes(){
        
		/*
			Nesse caso, monta-se o menu a ser exibido.
		*/
        $resultado = "";
        $resultado = $this->model->listarParticipantesPendentes();
        $resultado2 = $this->model->listarParticipantesPagos();
		$this->view->listarParticipantesPendentes($resultado);
        $this->view->listarParticipantesPagos($resultado2);
    }

    public function listarParticipantesPendentesFiltro(){
        
        
        if ( !isset( $_SESSION ) ){
            session_start();
        }
         
        /* Seleciona os funcionarios */
        $resultado = "";
        $resultado = $this->model->listarParticipantesPendentesFiltro();
        
        /* Exibe a lista de funcionarios desejada. Por padrao exibe todos no limite de 10. */
        $this->view->listarParticipantesFiltro($resultado, 0);
    }

    public function listarParticipantesPagosFiltro(){
        
        
        if ( !isset( $_SESSION ) ){
            session_start();
        }
         
        /* Seleciona os funcionarios */
        $resultado = "";
        $resultado = $this->model->listarParticipantesPagosFiltro();
        
        /* Exibe a lista de funcionarios desejada. Por padrao exibe todos no limite de 10. */
        $this->view->listarParticipantesFiltro($resultado, 1);
    }

    public function verMaisPagamento(){
        
        $result = $this->model->buscarValorPendente();
        $this->view->exibirValorPendente($result);
    }
}
?>