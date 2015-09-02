<?php
require ('view.php');

/**
 * loginController
 *
 * Metodos de visualização de informação.
  */

class loginView extends View
{

    /**
     * loginView::telaInicial()
     *
     * Exibe a tela padrão do modulo.
     *
    */
    public function telaInicial(){ 
		$this->exibirTela('tmpl/login/login.php');		
	}

    public function recuperarSenha(){ 
        $this->exibirTela('tmpl/login/recuperarSenha.php');      
    }   	

    public function erro(){
        $listagem="";
        $listagem = "<div class='alert alert-danger alert-dismissable'>
                        <i class='fa fa-ban'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <b>Alerta!</b> Desculpe mais este link expirou!
                    </div> ";
        $GLOBALS['info']['listagem'] = $listagem;
        $this->exibirTela('tmpl/login/listagem.php');      
    }
    
    public function formulario($codigo){
        $GLOBALS['info']['listagem'] = $codigo;
        $this->exibirTela('tmpl/login/editar.php'); 
    }
	
}
?>