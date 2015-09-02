<?php

/*
	Importa os arquivos do MVC
*/
require ('model/siteModel.php');
require ('view/siteView.php');
require ('controller.php');

/**
 * sistemaController
 *
 * Esta classe cont&eacute;m as fun&ccedil;&otilde;es de acesso a dados do objeto sistema.
 *
 */

class siteController extends Controller
{

    public $model;
    public $view;

    /**
     * siteController::_construct()
     *
     * Construtor.
     *
     */
    public function __construct()
    {
        $this->model = new siteModel();
        $this->view = new siteView(); 
    }


    /**
     * siteController::telaInicial()
     *
     * Exibe alguma tela dada como padr&atilde;o.
     *
     */
    public function telaInicial(){
        
		session_start();
		
		/*
			Nesse caso, monta-se o menu a ser exibido.
		*/
		if(!isset($_SESSION['tipo_usuario'])){
			$GLOBALS['info']['sair'] = utf8_encode("<li class='divider-vertical'><a class='link' href='sistema.php?acao=login/telaInicial' target=''><i class='fa fa-sign-in'></i> Login</a></li>");
			$GLOBALS['info']['menu'] = utf8_encode("
					<li class='divider-vertical'><a class='link' href='sistema.php?acao=home/telaInicial' target=''><i class='fa fa-home''></i> Home</a></li>
					<li class='divider-vertical'><a class='link' href='sistema.php?acao=atividade/listarAtividades' target=''><i class='fa fa-search''></i> Confira as atividades</a></li>
					<li class='divider-vertical'><a class='link' href='sistema.php?acao=congressista/exibirFormulario' target=''><i class='fa fa-plus'></i> Cadastre-se</a></li>
				");
			$this->view->telaInicial();
			return;
		}
		switch ($_SESSION['tipo_usuario']){
		
			case 1: //Adminstrador Global

				$GLOBALS['info']['sair'] = utf8_encode("
					<li class='divider-vertical'><a class='link sair' href='#' target=''><i class='fa fa-sign-out'></i> Sair</a></li>"
				);

				$GLOBALS['info']['menu'] = utf8_encode("
						<li class='divider-vertical'><a class='link' href='sistema.php?acao=adminGlobal/telaInicial' target=''><i class='fa fa-dashboard'></i> Painel</a></li>
						<li class='divider-vertical'><a class='link' href='sistema.php?acao=adminGlobal/telaAbrirInscricoes' target=''><span class='fa fa-cog'></span> Inscri&ccedil;&otilde;es</a></li>
		                <li class='divider-vertical'><a class='link' href='sistema.php?acao=congressista/exibirFormularioDireto' target=''><i class='fa fa-user'></i> Cadastrar congressista</a></li>
		                <li class='divider-vertical'><a class='link' href='sistema.php?acao=adminGlobal/listagemAtividades' target=''><i class='fa fa-tasks'></i> Atividades</a></li>
		                <li class='divider-vertical'><a class='link' href='sistema.php?acao=adminGlobal/listagemAdmGlobal' target=''><i class='fa fa-globe'></i> Adms Globais</a></li>
	                    <li class='divider-vertical'><a class='link' href='sistema.php?acao=adminGlobal/listagemAdmPagamento' target=''><i class='fa fa-money'></i> Adms Pagamentos</a></li>
                    	<li class='divider-vertical'><a class='link' href='sistema.php?acao=adminGlobal/filaEspera' target=''><i class='fa fa-bars'></i> Fila de Espera</a></li>
	                    <li class='divider-vertical'><a class='link' href='sistema.php?acao=adminPagamento/listarParticipantes' target=''><i class='fa fa-dollar'></i> Gerenciar Pagamentos</a></li>
                ");
			break;
						
			case 2: //Adminstrador Pagamento
				$GLOBALS['info']['sair'] = utf8_encode("
							<li class='divider-vertical'><a class='link sair' href='#' target=''><i class='fa fa-sign-out'></i> Sair</a></li>");

				$GLOBALS['info']['menu'] = utf8_encode("
							<li class='divider-vertical'><a class='link' href='sistema.php?acao=adminPagamento/telaInicial' target=''><i class='fa fa-dashboard'></i> Painel</a></li>
							<li class='divider-vertical'><a class='link' href='sistema.php?acao=adminPagamento/listarParticipantes' target=''><span class = 'glyphicon glyphicon-usd'></span> Gerenciar Pagamentos</a></li>
							<li class='divider-vertical'><a class='link' href='sistema.php?acao=adminPagamento/editarValores' target=''><span class = 'glyphicon glyphicon-pencil'></span> Editar Valores</a></li>
							");		
			break;
			
			case 4: //Aluno
				$GLOBALS['info']['sair'] = utf8_encode("
							<li class='divider-vertical'><a class='link sair' href='#' target=''><i class='fa fa-sign-out'></i> Sair</a></li>");

				$GLOBALS['info']['menu'] = utf8_encode("
							<li class='divider-vertical'><a class='link' href='sistema.php?acao=congressista/telaInicial' target=''><i class='fa fa-dashboard'></i> Painel</a></li>
							<li class='divider-vertical'><a class='link' href='sistema.php?acao=congressista/listagemAtividade' target=''><i class='fa  fa-plus-circle'></i>Escolher atividades</a></li>
							<li class='divider-vertical'><a class='link' href='sistema.php?acao=congressista/listagemAtividadeCadastrada' target=''><i class='fa  fa-thumbs-up'></i> Atividades cadastradas</a></li>
				");			

			break;
		}
		
		$this->view->telaInicial();
    }	
	
	/**
     * siteController::verificaStatusInscricaoAluno()
     *
     * Verifica no banco de dados, se a incri&ccedil;&atilde;o de alunos está aberta.
     *
     */
    public function verificaStatusInscricaoAluno(){
		
		$result = $this->model->VerificarStatus();
		$objeto = mysql_fetch_object($result);
		if($objeto->status_aluno == 1) echo '1';
		else echo '0';	
	}
	
	/**
     * siteController::encerrarInsricaoAluno()
     *
     * Encerra as incri&ccedil;&otilde;es dos monitores.
     *
     */
    public function encerrarInsricaoAluno(){
		
		$result = $this->model->encerrarInsricaoAluno();
		
		if(mysql_affected_rows($result)) echo '1';
		else echo '0';
	}
	
	/**
     * siteController::abrirInsricaoAluno()
     *
     * Encerra as incri&ccedil;&otilde;es dos alunos.
     *
     */
    public function abrirInsricaoAluno(){
		
		$result = $this->model->abrirInsricaoAluno();
		
		if(mysql_affected_rows($result)) echo '1';
		else echo '0';	
	}
}

?>