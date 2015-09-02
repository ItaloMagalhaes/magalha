<?php
require ('view.php');

/**
 * oficinaController
 *
 * Metodos de visualização de informação.
 */

class atividadeView extends View {
	
	public function selecionarAtividadeFiltro($resultado){
    	$checked = '';
    	$class = '';
    	$listagem = "";
    	if ( !isset( $_SESSION ) ){
            session_start();
        }
        
        if ($_SESSION['atividade']){
            $atividade = $_SESSION['atividade'];        
        }

   		if(mysql_num_rows($resultado) > 0){
		$teste = '';

			//Percorre lista de resultados
			while($linha = mysql_fetch_array($resultado)){
				  if($linha['data_inicio'] != $teste){
              		$listagem .="
        				<tr>
          				<td class='callout callout-info' colspan=5 ><b> Data ".$this->converterDataTela($linha['data_inicio'])."</b></td>
        				</tr>";
        				        $teste = $linha['data_inicio'];

    			}
				switch ($linha['tipo']) {
                  case 1:
                    $tipo = "Palestra";
                    break;
                  case 2:
                    $tipo = "Workshop";
                    break;
                  case 3:
                    $tipo = "Painel";
                    break;
                  case 4:
                    $tipo = "Sessão Técnica";
                    break;
                  case 5:
                    $tipo = "Minicurso";
                    break;
                  case 6:
                    $tipo = "Visita Técnica";
                    break;
                  case 7:
                    $tipo = "Mesa Redonda";
                    break;
                }
			    $checked = "";
 			    $cabecalho = "";
				$class = "selecionarAtividade";
			    if(isset($atividade) && in_array($linha['id_atividade'], $atividade)){
					$checked = "checked";
					$class = "removerAtividade";	
				}
                $listagem .= "<tr>
                                 <td><input type='checkbox' id='".$linha['id_atividade']."' class='".$class." check' value=".$linha['id_atividade']." ".$checked."></td>
                                <td>".$linha['nome']."</td>
                                <td>".$tipo."</td>
                                <td>".$linha['local']."</td>
                                <td><button  href='#".$cabecalho."' id='".$linha['id_atividade']."'  type='button' class='btn btn-default btn-sm verMais pull-right '><span class='glyphicon glyphicon-search'></span></button></td>
                        </tr>";
			}
			
		}else {
			
		  $listagem .="
        <tr>
          <td colspan=5 align=center>Não existe atividade com esse valor.</td>
        </tr>";				
			
		}

		echo $listagem;			  
    }
	
    /**
     * oficinaView::cadastrarOficina()
     *
     * Exibe o formulário de cadastro da oficina.
     *
    */
    public function exibirFormularioAtividade(){ 
    	$this->exibirTela('tmpl/atividade/formularioCadastrarAtividade.php');		
	}
	
	public function exibirDadoAtividade(){ 
		$this->exibirTela('tmpl/atividade/editarAtividade.php');		
	}
	
	public function getInfoSessao(){
		
		$campo = $this->model->get('campo');
		$sesao = $_SESSION[$campo];
		echo json_encode($sesao);
	}

	/**
     * oficinaView::exibeLocal()
     *
     * Exibe todos os locais.
     *
    */
    public function listarAtividades($resultado){
    	$resultado2 = $resultado;
    	  
        if ( !isset( $_SESSION ) ){
            session_start();
        }
       	$listagem ='';
        $listagem .= "<div class='box'>
                        <div class='box-header'>
                            <i class='fa  fa-search'></i>
                          <h3 class='box-title'>Confira as atividades</h3>
                      </div><!-- /.box-header -->
                        <div class='box-body no-padding'> 
                        ";
            
            $listagem.= "<div class='table-responsive'>
                      <table class='table table-striped'>
                         <thead>                                                                
                             <tr>  
                                <th>Atividade </th>
                                <th>Proponente </th>
                                <th>Local</th>
                                <th class='pull-right'> Ver mais</th>
                             </tr>
                         </thead>";
                $listagem .="<div id=''><tbody id='listagem'>";       
                
        if(mysql_num_rows($resultado) > 0){
 
            	$teste ='';

            //Percorre lista de resultados
            while($linha = mysql_fetch_array($resultado)){
            	if($linha['data_inicio'] != $teste){
              	$listagem .="
        				<tr>
        					<td class='callout callout-info' colspan=5 ><b> Data ".$this->converterDataTela($linha['data_inicio'])."</b></td>
        				</tr>";
        				$teste = $linha['data_inicio'];
              }
              $listagem .= "<tr>
                              <td>".$linha['nome']."</td>
                              <td>".$linha['nome_preponente']."</td>
                              <td>".$linha['local']."</td>
                              <td><button  href='#' id='".$linha['id_atividade']."'  type='button' class='btn btn-default btn-sm verMais pull-right '><i class='fa fa-search'></i></button></td>
                            </tr>";
            }
            $listagem .="</tbody></div></table></div></div>";

        }else {
            $listagem .="
  				  <tr>
  					  <td colspan=5 align=center>Não existe atividades cadastradas</td>
  				  </tr>";                            
        }
        
        $GLOBALS['info']['listagem'] = $listagem;  
		    $this->exibirTela("tmpl/atividade/listagem.php");  
	}

  public function verMais($retorno, $retorno2){ 
		$listagem = "";
		
		while($linha = mysql_fetch_array($retorno)){
			
			$numVagas = $linha['n_vagas'] - mysql_num_rows($retorno2);
			$dataInicio = explode("-", $linha["data_inicio"]);
			$dataTermino = explode("-", $linha["data_termino"]);
					
			$horarioInicio = explode(":", $linha["horario_inicio"]);
			$horarioTermino =  explode(":", $linha["horario_termino"]);
			
			$GLOBALS["info"]["atividade"] = $linha["nome"];
			
			$listagem = '<div class="panel panel-default">
							<div class="panel-heading">'.$linha["descricao"].'</div></br>'; 
		if(!empty($linha["observacao"])){
			$listagem .= '<ul class="list-group">
				<li class="list-group-item"><strong>Carga horária:</strong> '.$linha["carga_horaria"].' horas</li>
				<li class="list-group-item"><strong>Nº de vagas:</strong> '.$linha["n_vagas"].'</li>
				<li class="list-group-item"><strong>Vagas disponíveis:</strong> '.$numVagas.'</li>
				<li class="list-group-item"><strong>Observação: </strong> '.$linha["observacao"].'</li>
				<li class="list-group-item"><strong>Duração:</strong> '.$dataInicio[2]."/".$dataInicio[1]."/".$dataInicio[0]." a ".$dataTermino[2]."/".$dataTermino[1]."/".$dataTermino[0].'</li>
				<li class="list-group-item"><strong>Horário:</strong> '.$horarioInicio[0].":".$horarioInicio[1]." a ".$horarioTermino[0].":".$horarioTermino[1].' horas</li>
				<li class="list-group-item"><strong>Proponente:</strong> '.$linha["nome_preponente"].'</li>
				<li class="list-group-item"><strong>Local:</strong> '.$linha["local"].'</li>';
			}else{
			
			$listagem .= '
				<ul class="list-group">
				<li class="list-group-item"><strong>Carga horária:</strong> '.$linha["carga_horaria"].' horas</li>
				<li class="list-group-item"><strong>Nº de vagas:</strong> '.$linha["n_vagas"].'</li>
				<li class="list-group-item"><strong>Vagas disponíveis:</strong> '.$numVagas.'</li>
				<li class="list-group-item"><strong>Duração:</strong> '.$dataInicio[2]."/".$dataInicio[1]."/".$dataInicio[0]." a ".$dataTermino[2]."/".$dataTermino[1]."/".$dataTermino[0].'</li>
				<li class="list-group-item"><strong>Horário:</strong> '.$horarioInicio[0].":".$horarioInicio[1]." a ".$horarioTermino[0].":".$horarioTermino[1].' horas</li>
				<li class="list-group-item"><strong>Proponente:</strong> '.$linha["nome_preponente"].'</li>
				<li class="list-group-item"><strong>Local:</strong> '.$linha["local"].'</li>';
			}
		
		}
		$GLOBALS["info"]["listagem"] = $listagem;
		$this->exibirTela("tmpl/atividade/listagem.php");		
	}
}
?>