<?php

/*
	Importa os arquivos do MVC
*/
require ('model/loginModel.php');
require ('view/loginView.php');
require ('controller.php');

/**
 * loginController
 *
 * Esta classe contém as funções de acesso a dados do objeto login.
 *
 */

class loginController extends Controller
{

    public $model;
    public $view;

    /**
     * loginController::_construct()
     *
     * Construtor.
     *
     */
    public function __construct(){
        $this->model = new loginModel();
        $this->view = new loginView(); 
    }

    public function telaInicial(){
		//session_start();
		/*
			Nesse caso, monta-se o menu a ser exibido.
		*/
		$this->view->telaInicial();
    }

    public function logar(){
		

    	if(isset($_SESSION)) session_destroy($_SESSION);
		
		session_start();
		
		$resultado = $this->model->logar();
		
		/*
		    Verifica se encontrou alguem com esse login
		    0 -> Erro, dados invalidos ou usuario não existe
		*/
		
		if(mysql_num_rows($resultado) == 0){
			return '0';
		}else {
			$objeto = mysql_fetch_object($resultado);
			if ($objeto->tipo == 4){
				$retorno = $this->model->buscarDadosCongressista($objeto);
				$retorno = mysql_fetch_object($retorno);
				$_SESSION['nome'] = $retorno->nome;
				$_SESSION['tipo_usuario'] = $objeto->tipo;
				$_SESSION['id_congressista'] = $retorno->id_congressista;
				$_SESSION['fid_usuario'] = $retorno->fid_usuario;
				echo '1';
			}else{
				$_SESSION['tipo_usuario'] = $objeto->tipo;

				echo '1';	
			}				
		}		
	}
    
    /**
     * loginController::logout()
     *
     * Faz logout no sistema.
     *
     */
    public function sair(){
		
		session_start();
		session_destroy();
		
	}
	
	/**
     * loginController::verificarUsuario()
     *
     * Vefirica se um login esta disponivel.
     *
     */
    public function verificarUsuario(){
		
		$this->model->verificarUsuario();
	}
}

?>
