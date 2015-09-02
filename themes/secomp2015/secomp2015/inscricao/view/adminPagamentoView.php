<?php

require ('view.php');

/**
 * adminPagamentoView
 *
 * Metodos de visualização de informação.
 */

class adminPagamentoView extends View
{
   public function telaInicial($retorno,$retorno1,$retornoPagamentoEfetuado,$retornoPagamentoTotais,$valorPadrao,$status,$qtdAtividades,$cong){ 
        $listagem='';
        $listagem = "
                <div class='row'>
                    <div class='col-lg-6'>
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
                            <a class=' small-box-footer link' href='#' target=''>
                            </br>
                            </a>
                        </div>
                    </div><!-- ./col -->
                    <div class='col-lg-6'>
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
                            <h4>Seja Bem-Vindo Administrador de Pagamento  !</h4>
                        </div>';
   
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

	public function listarParticipantesPendentes($resultado){
        $listagem ="";
        $listagem .= "
            <div class='box'>
                <div class='box-header'>
                    <i class='text-red fa fa-dollar'></i>
                    <h3 class='box-title'>Pagamentos Pendentes  </h3>
                </div><!-- /.box-header -->
                <div class='box-body no-padding'>";
               
              $listagem.= " 
                        <table class='table table-striped'>
                           <thead>                                                                
                               <tr >                              
                                  <th>
                                   <label>Filtrar por:</label>                                 
                                   <div class='form-group'>
                                      <input type='text' class='form-control buscarPagamentoPendente' data-mask='999.999.999-99' id='cpf0' placeholder='CPF' >
                                   </div>
                                   CPF</th>
                                  <th>
                                   <div class='form-group'>
                                      <input type='text' class='form-control buscarPagamentoPendente' id='congressista0' placeholder='Congressista' >
                                   </div>
                                   Congressista</th>
                                   <th>
                                      <div class='form-group'>
                                                                         Exibir

                                      <select id='limite0' name='limite0' class='form-control buscarPagamentoPendente margin-top-menos-5'>
                                        <option value='10'>10</option>
                                        <option value='20'>20</option>
                                        <option value='30'>30</option>
                                        <option value='50'>50</option>
                                        <option value='100'>100</option>
                                        <option value='500'>500</option>       
                                      </select>
                                    
                                   </div>
                                   Setar Pagamentos</th>
                                   <th>Ver Mais</th>

                               </tr>
                           </thead>";

                $listagem .="<div id=''><tbody id='listagem0'>";
              if(mysql_num_rows($resultado) > 0){

            
            //Percorre lista de resultados
            while($linha = mysql_fetch_array($resultado)){

                $listagem .= "<tr>
                                <td>".$linha['cpf']."</td>
                                <td>".$linha['nome']."</td>
                                <td><a href='#' id='".$linha['id_congressista']."' class='efetuarPagamento'><i class='fa fa-thumbs-up'></i></a></td>
                                <td><a href='#' id='".$linha['id_congressista']."' class='verMaisPagamento'><i class='fa fa-plus'></i></a></td>
                              </tr>";
            }
            $listagem .="</tbody></div></table></div></div>";
                            
        } else {
            
            $listagem .="
                    <tr>
                    <td colspan=5 align=center>Não existem Pagamentos Pendentes.</td>
                </tr>
                </tbody></div></table></div></div>";
        }

        $GLOBALS['info']['listagem'] = $listagem;
        $this->exibirTela("tmpl/adminPagamento/listagem.php");
    }

    public function listarParticipantesPagos($resultado){
        
        $listagem ="";
        $listagem .= "
            <div class='box'>
                <div class='box-header'>
                    <i class='text-green fa fa-dollar'></i>
                    <h3 class='box-title'>Pagamentos Confirmados</h3>
                </div><!-- /.box-header -->
                <div class='box-body no-padding'>";
               
              $listagem.= " 
                        <table class='table table-striped'>
                           <thead>                                                                
                               <tr >                              
                                  <th>
                                   <label>Filtrar por:</label>                                 
                                   <div class='form-group'>
                                      <input type='text' class='form-control buscarPagamentoConfirmado' data-mask='999.999.999-99' id='cpf1' placeholder='CPF' >
                                   </div>
                                   CPF</th>
                                  <th>
                                   <label>Nome Congressista</label>
                                   <div class='form-group'>
                                      <input type='text' class='form-control buscarPagamentoConfirmado' id='congressista1' placeholder='Congressista' >
                                   </div>
                                   Congressista</th>
                                   <th>
                                      <div class='form-group'>
                                        Exibir

                                      <select id='limite1' name='limite0' class='form-control buscarPagamentoConfirmado margin-top-menos-5'>
                                        <option value='10'>10</option>
                                        <option value='20'>20</option>
                                        <option value='30'>30</option>
                                        <option value='50'>50</option>
                                        <option value='100'>100</option>
                                        <option value='500'>500</option>       
                                      </select>
                                    
                                   </div>
                                   Remover Pagamentos</th>
                                   <th>Ver Mais</th>
                               </tr>
                           </thead>";

        
     
                $listagem .="<div id=''><tbody id='listagem1'>";
     
      if(mysql_num_rows($resultado) > 0){
        
            
            //Percorre lista de resultados
            while($linha = mysql_fetch_array($resultado)){
                $listagem .= "<tr>
                                <td>".$linha['cpf']."</td>
                                <td>".$linha['nome']."</td>
                                <td><a href='#' id='".$linha['id_congressista']."' class='removerPagamento'><i class='fa fa-thumbs-down'></i></td>
                                <td><a href='#' id='".$linha['id_congressista']."' class='verMaisPagamento'><i class='fa fa-plus'></i></a></td>
                              </tr>";

            }
            $listagem .="</tbody></div></table></div></div>";
                            
        } else {
            
             $listagem .="
                    <tr>
                    <td colspan=5 align=center>Não existem Pagamentos Confirmados.</td>
                </tr>
                </tbody></div></table></div></div>                        ";
                            
        }

        $GLOBALS['info']['listagem'] = $listagem;
        $this->exibirTela("tmpl/adminPagamento/listagem.php");
    }

    public function listarParticipantesFiltro($resultado, $flag){
        
        $listagem = "";

        if ($flag == 0) {
            $classe = "efetuarPagamento";
            $icon = "fa-thumbs-up";
            $status = "pendentes";
        } else {
            $classe = "removerPagamento";
            $icon = "fa-thumbs-down";
            $status = "confirmados";
        }

        if(mysql_num_rows($resultado) > 0){
            
            //Percorre lista de resultados
            while($linha = mysql_fetch_array($resultado)){
                $listagem .= "<tr>
                                <td>".$linha['cpf']."</td>
                                <td>".$linha['nome']."</td>
                                <td><a href='#' id='".$linha['id_congressista']."' class='".$classe."'><i class='fa ".$icon."'></i></span></a></td>
                                <td><a href='#' id='".$linha['id_congressista']."' class='verMaisPagamento'><i class='fa fa-plus'></i></a></td>
                              </tr>";
            }

        } else {
            $listagem .="
              <tr>
                <td colspan=5 align=center>Não existem pagamentos ".$status." cadastrados com esse valor.</td>
              </tr>";
        }

        echo $listagem;           
    }

    public function editarValores() {
      $this->exibirTela('tmpl/adminPagamento/editarValores.php');
    }

  public function exibirValorPendente($resultado){
    $total = 25;
    $flag = false;
    $listagem = "";
    $listagem = '<div class="panel panel-default">
                  <div class="panel-heading">Valores</div><ul class="list-group">
                  <li class="list-group-item">Inscrição - R$25,00</li>'; 
    while($linha = mysql_fetch_array($resultado)){
        if ($flag == false) {
          $listagem .= '<li class="list-group-item">'.$linha["nome"].' - Grátis</li>';
          $flag = true;
        } else {
          $listagem .= '<li class="list-group-item">'.$linha["nome"].' - R$'.$linha["preco"].',00</li>';
          $total += $linha["preco"];
        }
    }
    $listagem .= '</ul><div class="panel-footer">Total - R$'.$total.',00</div></div>';
    echo $listagem;
  }
}
?>