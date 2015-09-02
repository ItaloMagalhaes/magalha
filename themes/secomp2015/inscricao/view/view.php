<?php

 /**
 * View
 * 
 * Camada base de visulalização de dados.
 *
 */
class View {
    /**
     * View::exibirTela()
     * 
     * Exibe a tela indicada no parâmetro.
     * 
     */

    public function exibirTela($template)
    {
         
        
        if(isset($GLOBALS['info'])) $info = $GLOBALS["info"];
        else $info = '';
        
        try
		{
        	require ($template); 
        	
 		}catch(Exception $e){
			 	
			 return false;
 		}
    }
    
    /**
     * View::converterDataTela()
     * 
     * Converte datas do formato armazenado no banco para o formato brasileiro.
     * @author Antonio Marcos <amm.bernardes@gmail.com>
     * @param string $data - Contém a data no formato armazenado no banco de dados.
     */
    public function converterDataTela($data)
    {
        if($data){
            $t = explode(" ", $data);
            $d = explode("-", $t[0]);
            $nova_data = $d[2] . "/" . $d[1] . "/" . $d[0];
            return $nova_data;
        }else{
            return "";
        }    
    }
    
    
    /**
     * View::converterDataBanco()
     * 
     * Formata datas originadas de formulárioo formato do banco de dados(yyyymmdd).
     * @author Antonio Marcos <amm.bernardes@gmail.com>
     * @param string $data - Contém a data no formato brasileiro normal.
     * 
     */
    public function converterDataBanco( $data )
    {
        if($data){
            $d = explode( "/", $data );
            $d[0] = str_pad( $d[0], 2, "0", STR_PAD_LEFT );
            $d[1] = str_pad( $d[1], 2, "0", STR_PAD_LEFT );
            $d[2] = str_pad( $d[2], 4, "0", STR_PAD_BOTH );
            $nova_data = $d[2] ."-". $d[1] ."-". $d[0];
            return $nova_data;
        }else{
            return "";
        }
    }
}

?>