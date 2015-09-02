<?php

require ('view.php');

/**
 * sistemaController
 *
 * Metodos de visualiza��o de informa��o.
 */

class siteView extends View
{

    /**
     * sistemaView::telaInicial()
     *
     * Exibe a tela padr�o do modulo.
     *
    */
    public function telaInicial(){ 
    	$this->exibirTela('tmpl/site/telaInicial.php');		
	}
	
    /**
     * sistemaView::telaInicialAluno()
     *
     * Exibe a tela padr�o do modulo.
     *
    */
    public function telaInicialCongressita(){ 
    	$this->exibirTela('tmpl/congressista/telaInicial.php');		
	}	
	
    /**
     * sistemaView::telaInicialCoordenadorArea()
     *
     * Exibe a tela padr�o do modulo.
     *
    */
    public function telaInicialCoordenadorArea(){ 
    	$this->exibirTela('tmpl/coordenadorArea/telaInicial.php');		
	}	
	
    /**
     * sistemaView::telaInicial()
     *
     * Exibe a tela padr�o do modulo.
     *
    */
    public function telaInicialAdminComun(){ 
    	$this->exibirTela('tmpl/adminComum/telaInicial.php');		
	}	
	
    /**
     * sistemaView::telaInicialAluno()
     *
     * Exibe a tela padr�o do modulo.
     *
    */
    public function telaInicialAdminGlobal(){ 
    	$this->exibirTela('tmpl/adminGlobal/telaInicial.php');		
	}
	
}
?>
