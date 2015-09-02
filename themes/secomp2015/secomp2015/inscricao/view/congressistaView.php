  <?php

require ('view.php');

/**
 * congressistaView
 *
 * Metodos de visualização de informação.
 */
class congressistaView extends View{

    /**
     * congressistaView::telaInicial()
     *
     * Exibe a tela padrão do modulo.
     *
    */
    public function telaInicial($qtdAtividadesCadastradas, $atividades, $atividades2, $qtdAtividadesTotais, $valorPendente){ 
        $listagem = '';
        $listagem = "
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
        $GLOBALS['info']['atividades'] = $this->atividades($atividades);
        $GLOBALS['info']['avisos'] = $this->avisos($atividades2, $valorPendente);
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

public function avisos($atividades, $valorPendente){
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
     * congressistaView::Cadastrarcongressista()
     *
     * Exibe o formulário de cadastro.
     *
    */
    public function exibirFormulario(){ 
    	$this->exibirTela('tmpl/congressista/formulario.php');		
	}

    /**
     * congressistaView::exibirMensagemInscricoesEncerradas()
     *
     * Exibe a tela informando inscrições encerradas.
     *
    */
    public function exibirMensagemInscricoesEncerradas(){ 
        $this->exibirTela('tmpl/congressista/inscricoesEncerradas.php');       
    }       

	public function listagemAtividade($resultado){ 
        
        if ( !isset( $_SESSION ) ){
            session_start();
        }
        
        if ($_SESSION['atividade']){
            $atividade = $_SESSION['atividade'];        
        }
        $listagem="";
        $checked ='';
        $class ='';
        $cabecalho="";
            
        $listagem .= "<div class='box'>
                        <div class='box-header'>
                            <i class='fa  fa-plus-circle'></i>
                          <h3 class='box-title'>Escolher Atividades  </h3>
                      </div><!-- /.box-header -->
                        <div class='box-body no-padding'> 
                      ";
              $listagem.= " 
                        <table class='table table-striped'>
                           <thead>                                                                
                                <tr>                              
                                  <th>Selecionar</th>
                                  <th>Nome</th>
                                  <th>Local</th>
                                  <th>Ver Mais</th>
                                </tr>
                           </thead>";
              $listagem .="<div id=''><tbody id='listagem'>";       

              $teste = '';
        if(mysql_num_rows($resultado) > 0){
          while($linha = mysql_fetch_array($resultado)){
            if($linha['data_inicio'] != $teste){
              $listagem .="
        <tr>
          <td class='callout callout-info' colspan=5 ><b> Data ".$this->converterDataTela($linha['data_inicio'])."</b></td>
        </tr>";
        $teste = $linha['data_inicio'];
              }
            $checked = "";
            $class = "selecionarAtividade";   
                if(isset($atividade) && in_array($linha['id_atividade'], $atividade)){
                    $checked = 'checked';
                    $class = "removerAtividade";  
                }
                $listagem .= "<tr>

                                <td><input type='checkbox' id='".$linha['id_atividade']."' class='".$class." check' value=".$linha['id_atividade']." ".$checked."></td>
                                <td>".$linha['nome']."</td>
                                <td>".$linha['local']."</td>
                                <td><button  href='#".$cabecalho."' id='".$linha['id_atividade']."'  type='button' class='btn btn-default btn-sm verMais pull-right '><span class='glyphicon glyphicon-search'></span></button></td>
                              </tr>";
            }
            $listagem .="</tbody></div></table></div></div>";
                            
        }else {

                $listagem .="
                  <tr>
                    <td colspan=5 align=center>Não existe atividades cadastradas</td>
                  </tr>";
                $listagem .="</tbody></div></table></div></div>";

                            
        }
        
        $GLOBALS['info']['listagem'] = $listagem;  
        $this->exibirTela("tmpl/congressista/listagemAtividades.php");  
 
    }
    public function listagemAtividadesEditar($resultado){ 
        
        if ( !isset( $_SESSION ) ){
            session_start();
        }
        
        if ($_SESSION['atividade']){
            $atividade = $_SESSION['atividade'];        
        }
        $listagem="";
        $checked ='';
        $class ='';
        $cabecalho="";
            
        $listagem .= "<div class='box'>
                        <div class='box-header'>
                            <i class='fa  fa-plus-circle'></i>
                          <h3 class='box-title'>Escolher Atividades  </h3>
                      </div><!-- /.box-header -->
                        <div class='box-body no-padding'> 
                             
                          ";
               
              $listagem.= " 
                        <table class='table table-striped'>
                           <thead>                                                                
                               <tr >                              
                                  <th>Selecionar</th>
                                  <th>
                                   Nome</th>
                                   <th >
                                     Local</th>
                                   <th >
                                 Ver Mais</th>
                               </tr>
                           </thead>";
                                           $listagem .="<div id=''><tbody id='listagem'>";       

                    $teste = '';    
        if(mysql_num_rows($resultado) > 0){
           

         
            
            while($linha = mysql_fetch_array($resultado)){
              if($linha['data_inicio'] != $teste){
              $listagem .="
        <tr>
          <td class='callout callout-info' colspan=5 ><b> Data ".$this->converterDataTela($linha['data_inicio'])."</b></td>
        </tr>";
        $teste = $linha['data_inicio'];
              }

            $checked = "";
            $class = "selecionarAtividade";   
                if(isset($atividade) && in_array($linha['id_atividade'], $atividade)){
                    $checked = 'checked';
                    $class = "removerAtividadeEditar";  
                }
                $listagem .= "<tr>

                                <td><input type='checkbox' id='".$linha['id_atividade']."' class='".$class." check' value=".$linha['id_atividade']." ".$checked."></td>
                                <td>".$linha['nome']."</td>
                                <td>".$linha['local']."</td>
                                <td><button  href='#".$cabecalho."' id='".$linha['id_atividade']."'  type='button' class='btn btn-default btn-sm verMais pull-right '><span class='glyphicon glyphicon-search'></span></button></td>
                              </tr>";
            }
            $listagem .="</tbody></div></table></div></div>";
                            
        }else {

                $listagem .="
                  <tr>
                    <td colspan=5 align=center>Não existe atividades cadastradas</td>
                  </tr>";
                $listagem .="</tbody></div></table></div></div>";
        }
        
        $GLOBALS['info']['listagem'] = $listagem;  
        $this->exibirTela("tmpl/congressista/listagemAtividadesEditar.php");  
 
    }
    
    public function listarAtividadesCadastradas($resultado){


        
        // Mostra primeiro a opção de alterar os dados do aluno
        
        $listagem = "";
        $corLinha="";
                if(mysql_num_rows($resultado) > 0){    

        $listagem .= "<div class='box'>
                        <div class='box-header'>
                            <i class='fa fa-tasks'></i>
                            <h3 class='box-title'>Atividades Cadastradas</h3>
                            <a class='link' href='sistema.php?acao=atividade/imprimirAtividades' target='_blank'><button class='box-title pull-right btn btn-info btn-sm'><i class='fa fa-file-text'></i> Gerar PDF &nbsp;</button> </a>   
                        </div><!-- /.box-header -->
                    <div class='box-body no-padding'> 
                    ";
        }else{
          $listagem .= "<div class='box'>
                        <div class='box-header'>
                            <i class='fa fa-tasks'></i>
                            <h3 class='box-title'>Atividades Cadastradas</h3>
                            <button class='box-title pull-right btn btn-disabled btn-sm'><i class='fa fa-file-text'></i> Gerar PDF &nbsp;</button>    
                        </div><!-- /.box-header -->
                    <div class='box-body no-padding'> 
                    ";
        }
        
        $listagem.="<div class='table-responsive'>
                    <!-- .table - Uses sparkline charts-->
                    <table class='table table-striped'>
                                    ";
        $listagem .= "<tr>";
        $listagem .= "<th  ><div  align='left'>Atividade</th>";
          $listagem .= "<th  ><div  align='left'>Data da atividade</th>";
            $listagem .= "<th  ><div  align='left'>Horário de início</th>";
            $listagem .= "<th  ><div  align='left'>Horário de término</th>";
            $listagem .= "<th  ><div  align='left'>Data de matrícula</th>";
            $listagem .= "<th  ><div  align='left'>Pagamento</th>";
            $listagem .= "<th  ><div  align='left'>Status</th>";
            $listagem .= "</tr>";
        $aux = "";
        
        if(mysql_num_rows($resultado) > 0){    
            while($linha = mysql_fetch_array($resultado)){
                  /*Monta o cabeçalho*/ 
                 
                  
                  //Verificando pagamento
                  if ($linha["status"] == 1){$pagamento = "<i class='text-green fa fa-check'></i>";}else{$pagamento = "<i class='text-red fa fa-times'></i>";}
                  
                  //Verificando fila de espera
                  if ($linha["fila_de_espera"] == 0) $matriculado = "Matriculado"; else $matriculado = "Fila de espera";
                
                  $listagem .= "<tr class='center_title_table' align='left'>
                    <td >".$linha["nome"]."</td>
                    <td >".$this->converterDataTela($linha["data_inicio"])."</td>
                    <td >".date('H:i', strtotime($linha['horario_inicio']))."</td>
                    <td >".date('H:i', strtotime($linha['horario_termino']))."</td>
                    <td >".$this->converterDataTela($linha["data_cadastro"])."</td>
                    <td >".$pagamento."</td>
                    <td >".$matriculado."</td>
                    </tr>";
            }
        }else{
        $listagem .="
        <tr>
          <td colspan=5 align=center>Não existem atividades cadastradas.</td>
        </tr>";  
              }   
        
        $listagem.="</tbody></table>";
        $listagem .= "</div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->";
            
        $GLOBALS["info"]["listagem"]=$listagem;
        
        $this->exibirTela("tmpl/congressista/listagemAtividadeCadastrada.php");
    } 
        public function listarAtividadesCertificados($resultado,$resultado2,$resultado3){


        
        // Mostra primeiro a opção de alterar os dados do aluno
        
        $listagem = "";
        $listagem .= "<div class='box'>
                        <div class='box-header'>
                            <i class='fa fa-book'></i>
                            <h3 class='box-title'>Certificados</h3>
                        </div><!-- /.box-header -->
                    <div class='box-body no-padding'> 
                    ";
        
        
        $listagem.="<div class='table-responsive'>
                    <!-- .table - Uses sparkline charts-->
                    <table class='table table-striped'>
                                    ";
        $listagem .= "<tr align='pull-right'>";
          $listagem .= "<th  >Certificado</th>";
          $listagem .= "<th  ></th>";
        $listagem .= "</tr>";
        $aux = "";
        if(mysql_num_rows($resultado2) > 0){    
                    $linha = mysql_fetch_array($resultado2);
                    $listagem .= "<tr class='callout callout-info'>
                      <td> Certificado de Participação no Evento</td>
                      <td> </td>
                      </tr>";
                    $listagem .="<tr>
                      <td>Certificado de  Participação</td>
                      <td><a class='link' href='sistema.php?acao=relatorio/certificadoParticipacao&id=".$linha['id_congressista']."' target='_blank'><button class=' btn btn-info col-md-12'><i class='fa fa-file-text'></i> Gerar Certificado &nbsp;</button> </a></td></tr>";           
                  $idCongressista = $linha['id_congressista'];

        }
        if(mysql_num_rows($resultado3) > 0 ){
             $listagem .= "<tr class='callout callout-danger'>
                <td> Certificados Artigos Apresentados</td>
                <td> </td>
                </tr>";
             
            while ($linha = mysql_fetch_array($resultado3)) {
                $listagem .= "<tr>
                <td>".$linha["nome_artigo"]."</td>
                <td  ><a class='link' href='sistema.php?acao=relatorio/certificadoArtigo&idCongressista=".$idCongressista."&id_artigo=".$linha['id']."' target='_blank'><button class=' btn btn-info col-md-12'><i class='fa fa-file-text'></i> Gerar Certificado &nbsp;</button> </a></td>           
                </tr>";
            }               
        }
        if(mysql_num_rows($resultado) > 0){    
              $listagem .= "<tr class='callout callout-warning'>
                      <td> Certificados Atividades Realizadas</td>
                      <td> </td>
                      </tr>";
            while($linha = mysql_fetch_array($resultado)){
                  $id = $_SESSION['id_congressista'];
                  if($linha['presenca'] == 1 && ($linha['tipo'] == 5 || $linha['tipo'] == 2 )){                  
                    $listagem .= "<tr>
                      <td>".$linha["nome"]."</td>
                      <td  ><a class='link' href='sistema.php?acao=relatorio/certificadoAtividade&idAtividade=".$linha['fid_atividade']."&idCongressista=".$idCongressista."' target='_blank'><button class=' btn btn-info col-md-12'><i class='fa fa-file-text'></i> Gerar Certificado &nbsp;</button> </a></td>           
                      </tr>";
                  }  
            }

        }else{
      
        $listagem .="
        <tr>
          <td colspan=5 align=center>Não existem atividades cadastradas.</td>
        </tr>";  
              }   
        
        $listagem.="</tbody></table>";
        $listagem .= "</div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->";
            
        $GLOBALS["info"]["listagem"]=$listagem;
        
        $this->exibirTela("tmpl/congressista/listagemAtividadeCadastrada.php");
    }  
    public function listarAreas($result){
      $radio = "<label for='estado' class='col-sm-2 control-label text-red'>Área:</label>
          <div class='col-sm-4'>
            <select id='area_artivo'  name='area_artivo' class='form-control texto-obrigatorio'>";
      while ($linha = mysql_fetch_object($result)) {
          $item = '<label><option   value="'.$linha->id_artigo.'">'.$linha->nome.'</option></label>';
          $radio = $radio.$item;
      }
      echo $radio;
    }

    public function listarAtividadesCongressista($resultado){        
        // Mostra primeiro a opção de alterar os dados do aluno
  
        $listagem = "<div class='box'>
                        <div class='box-body '> 
                          <button type='button' class='btn btn-default alterarAtividades' id='".$_SESSION['id_congressista']."'><span class='glyphicon glyphicon-edit'></span> Editar</button><sub style='margin-left: 10px;'>Editar atividades cadastradas</sub>
                        </div>
                      </div>  ";
        $corLinha="";
        if(mysql_num_rows($resultado) > 0){    

          $listagem .= "<div class='box'>
                        <div class='box-header'>
                            <i class='fa fa-tasks'></i>
                            <h3 class='box-title'>Atividades Cadastradas</h3>
                        </div><!-- /.box-header -->
                    <div class='box-body no-padding'> 
                    ";
        }else{
          $listagem .= "<div class='box'>
                        <div class='box-header'>
                            <i class='fa fa-tasks'></i>
                            <h3 class='box-title'>Atividades Cadastradas</h3>
                            <button class='box-title pull-right btn btn-disabled btn-sm'><i class='fa fa-file-text'></i> Gerar PDF &nbsp;</button>    
                        </div><!-- /.box-header -->
                    <div class='box-body no-padding'> 
                    ";
        }
        
        $listagem.="<div class='table-responsive'>
                    <!-- .table - Uses sparkline charts-->
                    <table class='table table-striped'>
                                    ";
        $listagem .= "<tr>";
        $listagem .= "<th  ><div  align='left'>Atividade</th>";
          $listagem .= "<th  ><div  align='left'>Data da atividade</th>";
            $listagem .= "<th  ><div  align='left'>Horário de início</th>";
            $listagem .= "<th  ><div  align='left'>Horário de término</th>";
            $listagem .= "<th  ><div  align='left'>Data de matrícula</th>";
            $listagem .= "<th  ><div  align='left'>Pagamento</th>";
            $listagem .= "<th  ><div  align='left'>Status</th>";
            $listagem .= "</tr>";
        $aux = "";
        
        if(mysql_num_rows($resultado) > 0){    
            while($linha = mysql_fetch_array($resultado)){
                  /*Monta o cabeçalho*/ 
                 
                  
                  //Verificando pagamento
                  if ($linha["status"] == 1){$pagamento = "<i class='text-green fa fa-check'></i>";}else{$pagamento = "<i class='text-red fa fa-times'></i>";}
                  
                  //Verificando fila de espera
                  if ($linha["fila_de_espera"] == 0) $matriculado = "Matriculado"; else $matriculado = "Fila de espera";
                
                  $listagem .= "<tr class='center_title_table' align='left'>
                    <td >".$linha["nome"]."</td>
                    <td >".$this->converterDataTela($linha["data_inicio"])."</td>
                    <td >".date('H:i', strtotime($linha['horario_inicio']))."</td>
                    <td >".date('H:i', strtotime($linha['horario_termino']))."</td>
                    <td >".$this->converterDataTela($linha["data_cadastro"])."</td>
                    <td >".$pagamento."</td>
                    <td >".$matriculado."</td>
                    </tr>";
            }
        }else{
        $listagem .="
        <tr>
          <td colspan=5 align=center>Não existem atividades cadastradas.</td>
        </tr>";  
              }   
        
        $listagem.="</tbody></table>";
        $listagem .= "</div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->";
            
        $GLOBALS["info"]["listagem"]=$listagem;
        $this->exibirTela("tmpl/congressista/listagemAtividadeCadastrada.php");
    } 

    public function exibirMensagemPagamento(){
      $avisos = '
        <div class="callout callout-info">
          <h4>Caro(a) '.$_SESSION['nome'].'!</h4>
          <p>Seu pagamento já foi confirmado, caso deseje se inscrever em uma nova atividade, favor entrar em contato com a organização do evento!</p>
        </div>
      ';
      echo $avisos;
    }
}
?>
