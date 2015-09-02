<?php

/**
 * sistema
 *
 * Arquivo responsável pela validação da página de origem, validação de usuário e execução do método.
 *
 * @copyright Antonio Marcos <amm.bernardes@gmail.com>
 */
//ini_set("display_errors",1);
//error_reporting(E_ALL);
	
	/*
		Necessario usar algum anti injection na hora de receber o get.
	*/
	
	$pagina = explode("/",$_GET['acao']);
	
	/*
		$pagina[0] -> pacote referenciado.
		$pagina[1] -> metodo desejado.
    */
	require ("controller/".$pagina[0]."Controller.php");
    
    eval('$obj = new '.$pagina[0].'Controller();');

    #Obtém ação
    if ($pagina[1])
    {
        $acao = $pagina[1];
    
	} else
    {
        $acao = 'telaInicial';
    }
		
    #Executa o método solicitado
    eval('$obj->' . $acao . '();');


?>
