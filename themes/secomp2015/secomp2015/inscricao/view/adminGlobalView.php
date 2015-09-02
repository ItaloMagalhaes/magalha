<?php

require ('view.php');

/**
 * adminGlobalView
 *
 * Metodos de visualização de informação.
 */

class adminGlobalView extends View
{

    public function filaEspera(){ 
        $this->exibirTela('tmpl/adminGlobal/filaEspera.php');       
    }
    /**
     * alunoView::telaInicial()
     *
     * Exibe a tela padrão do modulo.
     *
    */
    public function telaInicial($retorno,$retorno1,$retornoPagamentoEfetuado,$retornoPagamentoTotais,$valorPadrao,$status,$qtdAtividades,$cong){ 
        $listagem='';
        $listagem = "
            <div class='row'>
                <div class='col-lg-3 col-xs-6'>
                    <!-- small box -->
                    <div class='small-box bg-aqua'>
                        <div class='inner'>
                            <h3>
                                ".$retorno1."
                            </h3>
                            <p>
                                Administradores Pagamento
                            </p>
                        </div>
                        <div class='icon'>
                            <i class='fa fa-money'></i>
                        </div>
                        <a class=' small-box-footer link' href='sistema.php?acao=adminGlobal/listagemAdmPagamento' target=''>
                        Veja Mais <i class='fa fa-arrow-circle-right'></i>
                        </a>
                    </div>
                </div><!-- ./col -->
                <div class='col-lg-3 col-xs-6'>
                    <!-- small box -->
                    <div class='small-box bg-green'>
                        <div class='inner'>
                            <h3>
                                ".$cong."
                            </h3>
                            <p>
                                Congressistas Cadastrados
                            </p>
                        </div>
                        <div class='icon'>
                            <i class='ion ion-stats-bars'></i>
                        </div>
                        <a href='#' class='small-box-footer'>
                            </br>
                        </a>
                    </div>
                </div><!-- ./col -->
                <div class='col-lg-3 col-xs-6'>
                    <!-- small box -->
                    <div class='small-box bg-yellow'>
                        <div class='inner'>
                            <h3>
                                ".$retorno."
                            </h3>
                            <p>
                                Usuários Registrados
                            </p>
                        </div>
                        <div class='icon'>
                            <i class='ion ion-person-add'></i>
                        </div>
                        <a href='#' class='small-box-footer'>
                            </br>
                        </a>
                    </div>
                </div><!-- ./col -->
                <div class='col-lg-3 col-xs-6'>
                    <!-- small box -->
                    <div class='small-box bg-red'>
                        <div class='inner'>
                            <h3>
                                ".$qtdAtividades."
                            </h3>
                            <p>
                                Atividades Cadastradas
                            </p>
                        </div>
                        <div class='icon'>
                            <i class='fa fa-tasks'></i>
                        </div>
                       <a class=' small-box-footer link' href='sistema.php?acao=atividade/listarAtividades' target=''>
                        Veja Mais <i class='fa fa-arrow-circle-right'></i>
                        </a>
                    </div>
                </div><!-- ./col -->
            </div><!-- /.row -->
            </div>
             <div class='box-body'>
        

        </div><!-- /.row -->
    </div><!-- /.box-body -->
    </div><!-- /.box -->
    </div><!-- /.col -->
    </div><!-- /.row -->";
        $this->pagamento($retornoPagamentoEfetuado,$retornoPagamentoTotais);
        $this->valores($retornoPagamentoEfetuado,$retornoPagamentoTotais,$valorPadrao);
        $this->avisos($status,$valorPadrao);
        $GLOBALS['info']['listagem'] = $listagem;  
        $this->exibirTela("tmpl/adminGlobal/telaInicial.php");   		
	}	
	public function exibirFormularioSubmissao(){ 
    	$this->exibirTela('tmpl/adminGlobal/exibirFormularioSubmissao.php');		
	}	

    public function avisos($status,$valorPadrao){
        $avisos = '';
        $avisos .= '<div class="callout callout-info">
                            <h4>Seja Bem-Vindo Administrador  !</h4>
                        </div>';
        if($status == 1){
            $avisos .=' <div class="callout callout-info">
                            <h4>As inscrições estão abertas!</h4>
                            <p>Para fechar as inscrições <a href="sistema.php?acao=adminGlobal/telaAbrirInscricoes" target=""> clique aqui </a></p>
                        </div>';
        }else{
            $avisos .=' <div class="callout callout-danger">
                            <h4>As inscrições estão fechadas!</h4>
                            <p>Para abrir as inscrições <a href="sistema.php?acao=adminGlobal/telaAbrirInscricoes" target=""> clique aqui </a></p>
                         </div>';

        }
        $avisos .='<div class="callout callout-warning">
                            <h4>O valor padrão do sistema é R$ '.$valorPadrao.',00</h4>
                            <p>Para modificar o valor padrão do sistema <a href="sistema.php?acao=adminPagamento/editarValores" target=""> clique aqui </a></p>
                        </div>
                        ';
        $GLOBALS['info']['avisos'] = $avisos;  
    }

    public function valores($retornoPagamentoEfetuado, $retornoPagamentoTotais, $valorPadrao){
      $valores = "";
      if($retornoPagamentoTotais > 0){
        $valores = " 
        <div class='pad'>
        <!-- Progress bars -->
        <div class='clearfix'>
            <span class='pull-left'>Total Recebido</span>
            <small class='pull-right'>R$ ".$retornoPagamentoEfetuado.",00</small>
        </div>
        <div class='progress xs'>
            <div class='progress-bar progress-bar-green' style='width: ".($retornoPagamentoEfetuado/$retornoPagamentoTotais*100)."% ;'></div>
        </div>

        <div class='clearfix'>  
            <span class='pull-left'>Total à Receber</span>
            <small class='pull-right'>R$ ".($retornoPagamentoTotais - $retornoPagamentoEfetuado).",00</small>
        </div>
        <div class='progress xs'>
            <div class='progress-bar progress-bar-red' style='width: ".(($retornoPagamentoTotais - $retornoPagamentoEfetuado)/$retornoPagamentoTotais*100)."%;'></div>
        </div>

        <div class='clearfix'>
            <span class='pull-left'>Pagamentos Efetuados</span>
            <small class='pull-right'>R$ ".$retornoPagamentoEfetuado.",00  / R$ ".$retornoPagamentoTotais.",00</small> 
        </div>
        <div class='progress xs'>
            <div class='progress-bar progress-bar-light-blue' style='width: ".(($retornoPagamentoEfetuado/ $retornoPagamentoTotais)*100) ."%;'></div>
        </div>
        </div><!-- /.pad -->";
      }
      $GLOBALS['info']['valores'] = $valores;
    }
	
    public function pagamento($retornoPagamentoEfetuado,$retornoPagamentoTotais){
        $graph = "";
        if($retornoPagamentoTotais > 0){
          $graph ="
              <div class='col-xs-6 text-center' style='border-right: 1px solid #f4f4f4'>
                  <input type='text' data-readonly='true' class='knob' value='".number_format(($retornoPagamentoEfetuado/$retornoPagamentoTotais*100),1)."' data-width='90' data-height='90' data-fgColor='#00c0ef'/>
                      <div class='knob-label'>Pagamentos Efetuados (%) </div>
              </div><!-- ./col -->
              <div class='col-xs-6 text-center' style='border-right: 1px solid #f4f4f4'>
                  <input type='text' class='knob' data-readonly='true' value='".number_format((($retornoPagamentoTotais - $retornoPagamentoEfetuado)/$retornoPagamentoTotais*100),1)."' data-width='90' data-height='90' data-fgColor='#f56954'/>
                  <div class='knob-label'>Pagamentos não Efetuados (%)</div>
              </div><!-- ./col -->
          ";    
        }else{

           $graph ="
              <div class='col-xs-6 text-center' style='border-right: 1px solid #f4f4f4'>
                  <input type='text' data-readonly='true' class='knob' value='0' data-width='90' data-height='90' data-fgColor='#00c0ef'/>
                      <div class='knob-label'>Pagamentos Efetuados (%) </div>
              </div><!-- ./col -->
              <div class='col-xs-6 text-center' style='border-right: 1px solid #f4f4f4'>
                  <input type='text' class='knob' data-readonly='true' value='0' data-width='90' data-height='90' data-fgColor='#f56954'/>
                  <div class='knob-label'>Pagamentos não Efetuados (%)</div>
              </div><!-- ./col -->
          ";    
        }    
        $GLOBALS['info']['graph'] = $graph; 

    }

	public function salvarArea($resultado){ 
		
        if ( !isset( $_SESSION ) ){
            session_start();
        }

       	  $listagem = "
            <div class='box'>
              <div class='box-body '> 
                <button type='button' class='btn btn-default novaArea' id='botao-salvar'><span class='glyphicon glyphicon-plus'></span> Novo</button><sub style='margin-left: 10px;'>Criar nova area</sub>
              </div>
            </div>
            <div class='box'>
                        <div class='box-header'>
                            <i class='fa fa-file-text-o'></i>
                          <h3 class='box-title'>Submeter artigo</h3>
                      </div><!-- /.box-header -->
                        <div class='box-body no-padding'> ";    
           
            $listagem.= " <div class='table-responsive'>
   					  <table class='table table-striped'>
   						 <thead>   						    						 			
						     <tr >							 	
							 	<th >
						  		Nome</th>
								 <th class='pull-right'>Excluir </th>
							 </tr>
					     </thead>";
               if(mysql_num_rows($resultado) > 0){
        
				$listagem .="<div id=''><tbody id='listagem'>";		
            //Percorre lista de resultados
            while($linha = mysql_fetch_array($resultado)){
                
              

                $listagem .= "<tr>
                				<td >".$linha['nome']."</td>
					          	<td><a href='#' id='".$linha['id_artigo']."' class='pull-right 	excluirArea'><span class='glyphicon glyphicon-remove-circle'></span></a></td>
                              </tr>";
            }
            $listagem .="</tbody></div></table></div></div>";
                            
        }else {
            
            $listagem .="<tr>
                        <td align=center colspan=2> Não existem áreas de artigos cadastrados ainda!
                        </td>  
                        </tr>";
                            
        }
        
        $GLOBALS['info']['listagem'] = $listagem;  
		$this->exibirTela("tmpl/atividade/listagem.php");  	
	}

  public function mostrarEstadoSistema($resultadoSQL) {
    
    $sistema = mysql_fetch_object($resultadoSQL);
    $listagem = '';    
    if ($sistema->status_aluno == 1) {
        $listagem .= '
          <div class="alert alert-success" >O sistema de inscições está aberto <a href="sistema.php?acao=adminGlobal/fecharInscricoes"> clique aqui </a> para fechá-lo.</div>';
    } else {
        $listagem .= '<div class="alert alert-danger">O sistema de inscições está fechado <a href="sistema.php?acao=adminGlobal/abrirInscricoes"> clique aqui </a> para abri-lo.</div>';
    }
    $GLOBALS['info']['listagem'] = $listagem;  
    $this->exibirTela("tmpl/adminGlobal/listagem.php");   
  }
    
  public function listagemAdmPagamento($resultado){

    $listagem = "";

    $listagem = "<div class='box'>

    <div class='box-body '> 
    <button type='button' class='btn btn-default novoAdm' id='botao-salvar'><span class='glyphicon glyphicon-plus'></span> Novo</button><sub style='margin-left: 10px;'>Criar novo administrador</sub></div></div></div></div></div></div>";  
    $listagem .= "<div class='box'>
                    <div class='box-header'>
                        <i class='fa  fa-cogs'></i>
                      <h3 class='box-title'>Administradores de Pagamento  </h3>
                  </div><!-- /.box-header -->
                    <div class='box-body no-padding'>                      
    ";
               
              $listagem.= " 
                        <table class='table table-striped'>
                           <thead>                                                                
                               <tr >                              
                                  <th>
                                   <label>Filtrar por:</label>                                 
                                   <div class='form-group'>
                                      <input type='text' class='form-control buscarAdmPagamento' data-mask='999.999.999-99' id='cpf' placeholder='CPF' >
                                   </div>
                                   CPF</th>
                                  <th>
                                   <div class='form-group'>
                                      <input type='text' class='form-control buscarAdmPagamento' id='nome' placeholder='Nome' >
                                   </div>
                                   Nome</th>
                                   <th>
                                      <div class='form-group'>
                                                                         Exibir

                                      <select id='limite' name='limite' class='form-control buscarAdmPagamento margin-top-menos-5'>
                                        <option value='10'>10</option>
                                        <option value='20'>20</option>
                                        <option value='30'>30</option>
                                        <option value='50'>50</option>
                                        <option value='100'>100</option>
                                        <option value='500'>500</option>       
                                      </select>
                                    
                                   </div>
                                   Editar</th>
                                   <th>
                                 Excluir</th>
                               </tr>
                           </thead>";
                  $listagem .="<div id=''><tbody id='listagem'>";
                  if(mysql_num_rows($resultado) > 0){

              
              //Percorre lista de resultados
            while($linha = mysql_fetch_array($resultado)){

                $listagem .= "<tr>
                              <td>".$linha['cpf']."</td>
                              <td>".$linha['nome']."</td>
                              <td><a href='#' id='".$linha['id_usuario']."' class='editarAdmPagamento'><i class='fa fa-edit'></i></a></td>
                              <td><a href='#' id='".$linha['id_usuario']."' class='excluirAdmPagamento'><i class='fa fa-trash'></i></a></td>
                            </tr>";
            }
            $listagem .="</tbody></div></table></div></div>";        
        } else {
             $listagem .="
                <tr>
                  <td colspan=5 align=center>Não existem administradores de pagamento cadastrados com esse valor.</td>
                </tr>";
                          
      }

      $GLOBALS['info']['listagem'] = $listagem;  
      $this->exibirTela("tmpl/adminGlobal/listagem.php");
    }

    public function listagemAdmPagamentoFiltro($resultado){
        
      $listagem = "";

      if(mysql_num_rows($resultado) > 0){
          
          //Percorre lista de resultados
          while($linha = mysql_fetch_array($resultado)){
          
              
              $listagem .= "<tr>
                              <td>".$linha['cpf']."</td>
                              <td>".$linha['nome']."</td>
                              <td><a href='#' id='".$linha['id_usuario']."' class='editarAdmPagamento'><i class='fa fa-edit'></i></a></td>
                              <td><a href='#' id='".$linha['id_usuario']."' class='excluirAdmPagamento'><i class='fa fa-trash'></i></a></td>
                            </tr>";
          }
          
      }else {
          $listagem .="
        <tr>
          <td colspan=5 align=center>Não existem administradores de pagamento cadastrados com esse valor.</td>
        </tr>";
   
      }

      echo $listagem;           
    }

    public function novoAdmPagamento(){ 
      $this->exibirTela('tmpl/adminGlobal/novoAdmPagamento.php');   
    }

    public function editarAdmPagamento() {
      $this->exibirTela('tmpl/adminGlobal/editarAdmPagamento.php');
    }
    
    public function listagemAdmGlobal($resultado){

        $listagem = "";

        $listagem = "<div class='box'>

        <div class='box-body '> 
        <button type='button' class='btn btn-default novoAdmGlobal' id='botao-salvar'><span class='glyphicon glyphicon-plus'></span> Novo</button><sub style='margin-left: 10px;'>Criar novo administrador</sub></div></div></div></div></div></div>";

      
        $listagem .= "<div class='box'>
                        <div class='box-header'>
                            <i class='fa  fa-cogs'></i>
                          <h3 class='box-title'>Administradores Globais  </h3>
                      </div><!-- /.box-header -->
                        <div class='box-body no-padding'> 
                             
                          ";
               
              $listagem.= " 
                        <table class='table table-striped'>
                           <thead>                                                                
                               <tr >                              
                                  <th>
                                   <label>Filtrar por:</label>                                 
                                   <div class='form-group'>
                                      <input type='text' class='form-control buscarAdmGlobal' data-mask='999.999.999-99' id='cpf' placeholder='CPF' >
                                   </div>
                                   CPF</th>
                                  <th>
                                   <div class='form-group'>
                                      <input type='text' class='form-control buscarAdmGlobal' id='nome' placeholder='Nome' >
                                   </div>
                                   Nome</th>
                                   <th>
                                      <div class='form-group'>
                                                                         Exibir

                                      <select id='limite' name='limite' class='form-control buscarAdmGlobal margin-top-menos-5'>
                                        <option value='10'>10</option>
                                        <option value='20'>20</option>
                                        <option value='30'>30</option>
                                        <option value='50'>50</option>
                                        <option value='100'>100</option>
                                        <option value='500'>500</option>       
                                      </select>
                                    
                                   </div>
                                   Editar</th>
                                   <th>
                                 Excluir</th>
                               </tr>
                           </thead>";
                  $listagem .="<div id=''><tbody id='listagem'>";
                  if(mysql_num_rows($resultado) > 0){

              
              //Percorre lista de resultados
            while($linha = mysql_fetch_array($resultado)){

                $listagem .= "<tr>
                              <td>".$linha['cpf']."</td>
                              <td>".$linha['nome']."</td>
                              <td><a href='#' id='".$linha['id_usuario']."' class='editarAdmGlobal'><i class='fa fa-edit'></i></a></td>
                              <td><a href='#' id='".$linha['id_usuario']."' class='excluirAdmGlobal'><i class='fa fa-trash'></i></a></td>
                            </tr>";
            }
            $listagem .="</tbody></div></table></div></div>";        
        } else {
                 $listagem .="
        <tr>
          <td colspan=5 align=center>Não existem administradores globais cadastrados com esse valor.</td>
        </tr>";
      }

      $GLOBALS['info']['listagem'] = $listagem;  
      $this->exibirTela("tmpl/adminGlobal/listagem.php");
    }

    public function listagemAdmGlobalFiltro($resultado){
        
      $listagem = "";

      if(mysql_num_rows($resultado) > 0){
          
          //Percorre lista de resultados
          while($linha = mysql_fetch_array($resultado)){
          
              
              $listagem .= "<tr>
                              <td>".$linha['cpf']."</td>
                              <td>".$linha['nome']."</td>
                              <td><a href='#' id='".$linha['id_usuario']."' class='editarAdmGlobal'><i class='fa fa-edit'></i></a></td>
                              <td><a href='#' id='".$linha['id_usuario']."' class='excluirAdmGlobal'><i class='fa fa-trash'></i></a></td>
                            </tr>";
          }
          
      }else {
          
             $listagem .="
        <tr>
          <td colspan=5 align=center>Não existem administradores globais cadastrados com esse valor.</td>
        </tr>";     
      }

      echo $listagem;           
    }

    public function novoAdmGlobal(){ 
      $this->exibirTela('tmpl/adminGlobal/novoAdmGlobal.php');   
    }

    public function editarAdmGlobal() {
      $this->exibirTela('tmpl/adminGlobal/editarAdmGlobal.php');
    }

    public function listagemAtividades($resultado){

        $listagem = "";
        $listagem .= "
          <div class='box'>
            <div class='box-body '> 
              <button type='button' class='btn btn-default novaAtividade' id='botao-salvar'><span class='glyphicon glyphicon-plus'></span> Novo</button><sub style='margin-left: 10px;'>Criar nova Atividade</sub>
            </div>
          </div>"; 
          
        $listagem .= "<div class='box-body '>
                      <div class='box'>
                        <div class='box-header'>
                            <i class='fa  fa-cogs'></i>
                          <h3 class='box-title'>Atividades  </h3>
                      </div><!-- /.box-header -->
                        <div class='box-body no-padding'> 
                             
                          ";
               
              $listagem.= " 
                        <table class='table table-striped'>
                           <thead>                                                                
                               <tr >                              
                                  <th>
                                   <label>Filtrar por:</label>                                 
                                   <div class='form-group'>
                                      <input type='text' class='form-control buscarAtividades' id='nome' placeholder='nome' >
                                   </div>
                                   Nome</th>
                                  <th>
                                   <div class='form-group'>
                                      <input type='text' class='form-control buscarAtividades' id='preponente' placeholder='Proponente' >
                                   </div>
                                   Proponente</th>
                                
                                   <th>
                                      <div class='form-group'>
                                                                         Exibir

                                      <select id='limite' name='limite' class='form-control buscarAtividades margin-top-menos-5'>
                                        <option value='10'>10</option>
                                        <option value='20'>20</option>
                                        <option value='30'>30</option>
                                        <option value='50'>50</option>
                                        <option value='100'>100</option>
                                        <option value='500'>500</option>       
                                      </select>
                                    
                                   </div>
                                   Local</th>
                                   <th>Lista de presença</th>
                                   </th>
                           </thead>";
                  $listagem .="<div id=''><tbody id='listagem'>";
                  if(mysql_num_rows($resultado) > 0){

              
              //Percorre lista de resultados
            while($linha = mysql_fetch_array($resultado)){

                $listagem .= "<tr>
                              <td>".$linha['nome']."</td>
                              <td>".$linha['nome_preponente']."</td>
                              <td>".$linha['local']."</td>
                              <td><a class='link' href='sistema.php?acao=atividade/listarParticipantesAtividade&id=".$linha['id_atividade']."' target='_blank'><button class='box-title pull-right btn btn-info btn-sm'><i class='fa fa-file-text'></i> PDF &nbsp;</button> </a></td>
                            </tr>";
            }
            $listagem .="</tbody></div></table></div></div>";        
        } else {
             $listagem .="
                <tr>
                  <td colspan=5 align=center>Não existem atividades cadastradas com esse valor.</td>
                </tr>";
                          
      }

      $GLOBALS['info']['listagem'] = $listagem;
      $this->exibirTela("tmpl/adminGlobal/telaAtividades.php");
    }

    public function listagemAtividadesFiltro($resultado){
        
      $listagem = "";

      if(mysql_num_rows($resultado) > 0){
          
          //Percorre lista de resultados
          while($linha = mysql_fetch_array($resultado)){

                $listagem .= "<tr>
                              <td>".$linha['nome']."</td>
                              <td>".$linha['nome_preponente']."</td>
                              <td>".$linha['local']."</td>
                              <td><a class='link' href='sistema.php?acao=atividade/listarParticipantesAtividade&id=".$linha['id_atividade']."' target='_blank'><button class='box-title pull-right btn btn-info btn-sm'><i class='fa fa-file-text'></i> PDF &nbsp;</button> </a></td>
                            </tr>";
          }
          
      }else {
          $listagem .="
        <tr>
          <td colspan=5 align=center>Não existem atividades cadastradas com esse valor.</td>
        </tr>";
   
      }
      echo $listagem;           
    }
}
?>