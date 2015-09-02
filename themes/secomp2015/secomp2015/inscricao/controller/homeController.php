<?php

/*
	Importa os arquivos do MVC
*/
require ('model/homeModel.php');
require ('view/homeView.php');
require ('controller.php');

/**
 * homeController
 *
 * Esta classe contém as funções de acesso a dados do objeto home.
 *
 */

class homeController extends Controller
{

    public $model;
    public $view;
    /**
     * homeController::_construct()
     *
     * Construtor.
     *
     */
    public function __construct()
    {
        $this->model = new homeModel();
        $this->view = new homeView();
    }


    /**
     * homeController::telaInicial()
     *
     * Exibe alguma tela dada como padrão.
     *
     */
    public function telaInicial(){
		
		if (!isset( $_SESSION ) ){
           session_start();
       	}
       	if(!isset($_SESSION['tipo_usuario'])){
			$this->view->telaInicial();
			return;
		}
		switch ($_SESSION['tipo_usuario']){
		
			case 1:
		        $valorPadrao = $this->model->recuperaValorPadrao();
		        $status = $this->model->recuperaStatus();
		        $retorno = $this->model->recuperaLinhasUsuarios();
		        $retorno1 = $this->model->recuperaLinhasPagamento();
		        $retorno2 = $this->model->recuperaQtdPagamentoEfetuados($valorPadrao);
		        $retornoPagamentoTotais = $this->model->recuperaQtdPagamentoTotais($valorPadrao);
		        $qtdAtividades = $this->model->recurperaQtdAtividades();
		        $cong = $this->model->recurperaQtdCong();
		        $this->view->telaAdminGlobal($retorno,$retorno1,$retorno2,$retornoPagamentoTotais,$valorPadrao,$status,$qtdAtividades,$cong);
			break;
			
			case 2:
 				$valorPadrao = $this->model->recuperaValorPadrao();
 				$status = $this->model->recuperaStatus();
		        $retorno = $this->model->recuperaLinhasUsuarios();
		        $retorno1 = $this->model->recuperaLinhasPagamento();
		        $retorno2 = $this->model->recuperaQtdPagamentoEfetuados($valorPadrao);
		        $retornoPagamentoTotais = $this->model->recuperaQtdPagamentoTotais($valorPadrao);
		        $qtdAtividades = $this->model->recurperaQtdAtividades();
		        $cong = $this->model->recurperaQtdCong();
		        $this->view->telaAdminPagamento($retorno,$retorno1,$retorno2,$retornoPagamentoTotais,$valorPadrao,$status,$qtdAtividades,$cong);			
		    break;
			
			case 4:
				$idCongressista = $_SESSION['id_congressista'];
		        $retornoQtdAtividadesCadastradas = $this->model->recuperaQtdAtividadesCadastradas($idCongressista);
		        $retornoAtividades = $this->model->recuperaAtividades($idCongressista);
		        $retornoAtividades2 = $this->model->recuperaStatus1($idCongressista);
		        $retornoQtdAtividadesTotais = $this->model->retornoQtdAtividadesTotais();
		        $valorPendente = $this->model->buscarValorPendente($idCongressista);
				$this->view->telaCongressista($retornoQtdAtividadesCadastradas, $retornoAtividades, $retornoAtividades2, $retornoQtdAtividadesTotais, $valorPendente);
			break;	
			
			default:
    			$this->view->telaInicial();
			break;
		}
        
	}
    
    /**
     * homeController::cadastrar()
     *
     * Faz o cadastro do adminComum no banco de dados.
     *
     */
    public function cadastrar(){
        
		session_start();
		
		/*
			Nesse caso, monta-se o menu a ser exibido.
		*/
		
		$result = $this->model->salvar();
		
		if ($result == 1){
			 $json["mensagem"] = "Cadastrado com sucesso!";
			 echo json_encode($json);
		}else{
			 $json["mensagem"] = "Erro ao efetuar o cadastro!";
			 echo json_encode($json);
		}	 
    }
    
    /**
     * homeController::getInfoSessao()
     *
     * Recupera um dado contido numa sessão.
     *
     */
    public function getInfoSessao(){
		
		$campo = $this->model->get('campo');
		$sesao = $_SESSION[$campo];
		echo json_encode($sesao);
	
	}
}
?>