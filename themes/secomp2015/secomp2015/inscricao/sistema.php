<?php

/**
 * sistema
 *
 * Arquivo respons�vel pela valida��o da p�gina de origem, valida��o de usu�rio e execu��o do m�todo.
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

    #Obt�m a��o
    if ($pagina[1])
    {
        $acao = $pagina[1];
    
	} else
    {
        $acao = 'telaInicial';
    }
		
    #Executa o m�todo solicitado
    eval('$obj->' . $acao . '();');


?>
