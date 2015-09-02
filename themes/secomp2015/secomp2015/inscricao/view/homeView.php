<?php

require ('view.php');

/**
 * homeView
 *
 * Metodos de visualização de informação.
 */

class homeView extends View
{

    /**
     * homeView::telaInicial()
     *
     * Exibe a tela padrão do modulo.
     *
    */
    public function telaInicial(){ 
        $listagem = '';
                $listagem .= ' 
 <div class="col-md-12">
    <div class="box">

        <div class="box-header">
            <i class="fa fa-comments-o"></i>
            <h3 class="box-title">Perguntas Frequentes</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box">
                    <div class="box-header">
                        <div class="col-sm-11">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    Como cadastrar no sistema?
                                </a>
                            </h4>
                        </div>
                        <div class="col-sm-1">
                            <h4 class="box-title">
                            <a class="text" align="left" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" ><i class="fa  fa-angle-down"></i></a>
                            </h4>
                        </div>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="box-body">
                            <ol class="breadcrumb">
                                <li><i class="fa fa-home"></i> Home</a></li>
                                <li class="active"><a class="link crumb" href="sistema.php?acao=congressista/exibirFormulario" target=""><i class="fa fa-plus"/>  Cadastre-se </a></li>
                            </ol>
                            Caro(a) usúario, se cadastrar no sistema é bem fácil!                           
                            <ul>
                                <li>Primeiramente você deve clicar no menu a esquera da página em "<a class="link crumb1" href="sistema.php?acao=congressista/exibirFormulario" target="">Cadastre-se</a>"!</li>
                                <li>Preencha todos os campos obrigatórios!</li>
                                <li>Clique em enviar!</li>
                                <li> Uma mensagem de sucesso irá aparecer em sua tela</li>  
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel box">
                    <div class="box-header">
                        <div class="col-sm-11">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                    Como conferir as atividades da SECOMP?
                                </a>
                            </h4>
                        </div>
                        <div class="col-sm-1">
                            <h4 class="box-title">
                                <a align="right" class="text" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" ><i class="fa  fa-angle-down"></i></a>
                            </h4>
                        </div>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="box-body">
                            <ol class="breadcrumb">
                                <li><i class="fa fa-home"></i> Home</a></li>
                                <li class="active"><a class="link crumb" href="sistema.php?acao=atividade/listarAtividades" target=""><i class="fa fa-search"/>  Confira as atividades</a></li>
                            </ol>
                            Caro(a) usúario, é bem simples visualizar as atividades cadastradas no sistema!                           
                            <ul>
                                <li>Primeiramente você deve clicar no menu a esquerda da página em "<a class="link crumb1" href="sistema.php?acao=atividade/listarAtividades" target="">Confira as atividades</a>"!</li>
                                <li>Em seguida você será redirecionado para uma página onde contém a lista com todas as atividades!</li>
                                <li>Se quiser visualizar todos os detalhes dessa atividade, clique na <i class="fa fa-search"/> que está na frente da atividade desejada</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel box">
                    <div class="box-header">
                        <div class="col-sm-11">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                    Como logar no sistema?
                                </a>
                            </h4>
                        </div>
                        <div class="col-sm-1">
                            <h4 class="box-title">
                                <a align="right" class="text" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" ><i class="fa  fa-angle-down"></i></a>
                            </h4>
                        </div>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="box-body">
                            <ol class="breadcrumb">
                                <li><i class="fa fa-home"></i> Home</a></li>
                                <li class="active"><a class="link crumb" href="sistema.php?acao=login/telaInicial" target=""><i class="fa fa-sign-in"/>  Login</a></li>
                            </ol>
                            Caro(a) usúario, é bem simples logar no sistema da SECOMP!                           
                            <ul>
                                <li>Primeiramente você deve clicar no menu superior da página em "<a class="link crumb1" href="sistema.php?acao=login/telaInicial" target="">Login</a>"!</li>
                                <li>Em seguida você será redirecionado para a página de Login!</li>
                                <li>Para logar insira seu CPF e sua Senha e clique no botão "Entrar"</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel box">
                    <div class="box-header">
                        <div class="col-sm-11">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                                    Como se inscrever em uma atividade?
                                </a>
                            </h4>
                        </div>
                        <div class="col-sm-1">
                            <h4 class="box-title">
                                <a align="right" class="text" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" ><i class="fa  fa-angle-down"></i></a>
                            </h4>
                        </div>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse">
                        <div class="box-body">
                            <ol class="breadcrumb">
                                <li><i class="fa fa-home"></i> Home</a></li>
                                <li><i class="fa fa-sign-in"></i>  Login</li>
                                <li class="active"><i class="fa fa-plus-circle"></i>  Escolher Atividades   </li>

                            </ol>
                            Caro(a) usuário, é bem simples cadastrar em uma atividade no sistema da SECOMP!                           
                            <ul>
                                <li>Primeiramente você deve clicar no menu superior da página em "Login"!</li>
                                <li>Em seguida você será redirecionado para a página de Login!</li>
                                <li>Para logar insira seu CPF e sua Senha e clique no botão "Entrar"</li>
                                <li>Depois de logado basta clicar em "Escolher Atividades"</li>
                                <li>A lista de todas as atividades irá aparecer, agora você seleciona quais você quer e clica em salvar </li>
                                <li>Uma mensagem de sucesso irá confirmar o seu cadastro</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->
';

        echo $listagem;        
	}	

     
    public function telaAdminGlobal($retorno,$retorno1,$retornoPagamentoEfetuado,$retornoPagamentoTotais,$valorPadrao,$status,$qtdAtividades,$cong){ 
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

    	    /**
     * homeView::telaAdminGlobal()
     *
     * Exibe a tela padrão do administrador Global.
     * 
     * Autor: Jefferson e Bruno
     *
    */
    public function telaAdminPagamento($retorno,$retorno1,$retornoPagamentoEfetuado,$retornoPagamentoTotais,$valorPadrao,$status,$qtdAtividades,$cong){ 
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
        $this->avisos2($status,$valorPadrao);
        $GLOBALS['info']['listagem'] = $listagem;  
        $this->exibirTela("tmpl/adminGlobal/telaInicial.php");          
    }   
 public function avisos2($status,$valorPadrao){
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
    /**
     * homeView::telaCoordenadorArea()
     *
     * Exibe a tela padrão do coordenador de area.
     * 
     * Autor: Jefferson e Bruno
     *
    */
    public function telaCoordenadorArea(){ 
    	$this->exibirTela('tmpl/coordenadorArea/telaInicial.php');		
	}	
	
		    /**
     * homeView::telaAluno()
     *
     * Exibe a tela padrão do Aluno.
     * 
     * Autor: Jefferson e Bruno
     *
    */
    public function telaCongressista($qtdAtividadesCadastradas, $atividades, $atividades2, $qtdAtividadesTotais, $valorPendente){ 
        $listagem='';
        $listagem .= "
            <div class='row'>
                <div class='col-lg-6 col-xs-6'>
                    <!-- small box -->
                    <div class='small-box bg-aqua'>
                        <div class='inner'>
                            <h3>
                                ".$qtdAtividadesCadastradas."
                            </h3>
                            <p>
                                Atividades Cadastradas
                            </p>
                        </div>
                        <div class='icon'>
                            <i class='fa fa-thumbs-up'></i>
                        </div>
                        <a class=' small-box-footer link' href='sistema.php?acao=congressista/listagemAtividadeCadastrada' target=''>
                          Veja Mais <i class='fa fa-arrow-circle-right'></i>
                        </a>
                    </div>
                </div><!-- ./col -->
                <div class='col-lg-6 col-xs-6'>
                    <!-- small box -->
                    <div class='small-box bg-yellow'>
                        <div class='inner'>
                            <h3>
                                ".$qtdAtividadesTotais."
                            </h3>
                            <p>
                                Atividades Disponíveis
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
        echo $listagem;
        $listagem ='';
        $GLOBALS['info']['atividades'] = $this->atividades($atividades);
        $GLOBALS['info']['avisos'] = $this->avisos1($atividades2, $valorPendente);
        $GLOBALS['info']['listagem'] = $listagem;
        $this->exibirTela("tmpl/congressista/telaInicial.php");
  } 

  public function atividades($atividades){
      $listagem = "";
      if (mysql_num_rows($atividades) > 0){
        $listagem = "
          <div class='table-responsive'>
            <!-- .table - Uses sparkline charts-->
            <table class='table table-striped'>
                <tr>
                    <th>Atividade</th>
                    <th>Status</th>
                </tr>";
                while($linha = mysql_fetch_array($atividades)){
                  $status = "<i class = 'fa fa-times text-red'>";
                  if ($linha['status'] == 1) 
                    $status = "<i class = 'fa fa-check text-green'>";
                  $listagem .= "<tr>
                                  <td>".$linha['nome']."</td>
                                  <td>".$status."</td>
                              </tr>";
                }

                $listagem .= "
          </table>
        </div>";
      }
      return ($listagem);
    }

public function avisos1($atividades,$valorPendente){
    $total = 25;
    $flag = false;
    while($linha = mysql_fetch_array($valorPendente)){
        if ($flag == false) {
          $flag = true;
        } else {
          $total += $linha["preco"];
        }
    }
    $avisos = "";
    $avisos .=' <div class="callout callout-info">
                  <h4>Caro(a) '.$_SESSION['nome'].'!</h4>
                  <p>Para efetuar a inscrição em alguma atividade <a href="sistema.php?acao=congressista/listagemAtividade" target=""> clique aqui </a></p>
                </div>';
      if (mysql_num_rows($atividades) > 0){
        while($linha = mysql_fetch_array($atividades)){
          if ($linha['pagamento'] == 0){
            $avisos .= '  <div class="callout callout-warning">
                            <h4><i class="fa fa-warning"></i> Atenção!</h4>
                            <p>Existem pagamentos pendentes</p>
                            <p>Valor: R$'.$total.'</p>
                          </div>';
          } else {
            $avisos .= '  <div class="callout callout-info">
                            <h4><i class="fa fa-thumbs-up"></i> Parabéns!</h4>
                            <p>Seu pagamento foi confirmado</p>
                            <p>Valor: R$'.$total.'</p>
                          </div>';
          }
        }
      }
    return ($avisos);
  }
	



    /**
     * homeView::exibirFormularioErros()
     *
     * Exibe o formulário pra que o usuário insira e envie o erro
     * por email para o grupo da Linked.
     *
    */
    public function exibirFormularioErros(){

        $this->exibirTela('tmpl/home/telaReportarErros.php');

    }
	
}
?>
