<?php

/*
	Importa os arquivos do MVC
*/
require ('model/adminGlobalModel.php');
require ('view/adminGlobalView.php');
require ('controller.php');

/**
 * adminGlobalController
 *
 * Esta classe contém as funções de acesso a dados do objeto adminGlobal.
 *
 */

class adminGlobalController extends Controller
{

    public $model;
    public $view;

    /**
     * adminGlobalController::_construct()
     *
     * Construtor.
     *
     */
    public function __construct()
    {
        $this->model = new adminGlobalModel();
        $this->view = new adminGlobalView(); 
    }

    public function elimiarParticipantesNPagos(){
        $this->model->elimiarParticipantesNPagos();
    }

    public function telaInicial(){
        $valorPadrao = $this->model->recuperaValorPadrao();
        $status = $this->model->recuperaStatus();
        $retorno = $this->model->recuperaLinhasUsuarios();
        $retorno1 = $this->model->recuperaLinhasPagamento();
        $retorno2 = $this->model->recuperaQtdPagamentoEfetuados($valorPadrao);
        $retornoPagamentoTotais = $this->model->recuperaQtdPagamentoTotais($valorPadrao);
        $qtdAtividades = $this->model->recurperaQtdAtividades();
        $cong = $this->model->recurperaQtdCong();
        $this->view->telaInicial($retorno,$retorno1,$retorno2,$retornoPagamentoTotais,$valorPadrao,$status,$qtdAtividades,$cong);
    }

    public function exibirFormularioSubmissao(){
        
        /*
            Nesse caso, monta-se o menu a ser exibido.
        */
        $this->view->exibirFormularioSubmissao();
    }
    
    public function listagemAdmPagamento(){

        if ( !isset( $_SESSION ) ){
            session_start();
        }

        $resultado = "";
        $resultado = $this->model->listagemAdmPagamento();
        $this->view->listagemAdmPagamento($resultado);   
    }

    public function listagemAdmPagamentoFiltro(){
        
        if ( !isset( $_SESSION ) ){
            session_start();
        }
         
        /* Seleciona os funcionarios */
        $resultado = "";
        $resultado = $this->model->listagemAdmPagamentoFiltro();
        
        /* Exibe a lista de funcionarios desejada. Por padrao exibe todos no limite de 10. */
        $this->view->listagemAdmPagamentoFiltro($resultado);
    }

    public function novoAdmPagamento(){
        
        if ( !isset( $_SESSION ) ){
            session_start();
        }
        
        $this->view->novoAdmPagamento();
    }

    public function cadastrarAdmPagamento(){
        
        session_start();
        
        $result = $this->model->salvarAdmPagamento();

        if ($result == 1) { 
            $arr = array ('tipo'=>1,'mensagem'=>"Administrador cadastrado com sucesso.",'redirecionar'=>"sistema.php?acao=adminGlobal/listagemAdmPagamento"); 
            echo json_encode($arr); 
            exit;
        }
        if($result == 0) { 
            $arr = array ('tipo'=>0,'mensagem'=>"Não foi possivel efetuar o cadastro do administrador."); echo json_encode($arr); 
            exit;
        }
        if($result == 2) {
            $arr = array ('tipo'=>0,'mensagem'=>"CPF já cadastrado"); echo json_encode($arr); 
            exit;
        }
    }

    public function telaAbrirInscricoes()
    {
        $resultadoSQL= $this->model->verificaEstadoSistema();

        $this->view->mostrarEstadoSistema($resultadoSQL);
    }

     /**
     * adminGlobalController::filaEspera()
     *
     * Rodar fila de espera
     * 
     * Autor: Jefferson
     *
     */   
    public function filaEspera(){
        
        session_start();
        if ($_SESSION['tipo_usuario'] != 1){
                $this->view->exibeAlerta();
                return false;
        } 
        
        /*
            Nesse caso, monta-se o menu a ser exibido.
        */
        $this->view->filaEspera();
    }   
    
    public function abrirInscricoes()
    {
        $this->model->abrirInscricoes();
        header("Location:sistema.php?acao=site/telaInicial");
    }

    public function fecharInscricoes()
    {
        $this->model->fecharInscricoes();
        header("Location:sistema.php?acao=site/telaInicial");         
    }

    public function editarAdmPagamento() {
        $id = $_GET["id"];
        $resultado = $this->model->selecionarAdmPagamento($id);
        $atividade = mysql_fetch_object($resultado);
        $GLOBALS['info']['id_usuario'] = $atividade->id_usuario;
        $GLOBALS['info']['nome'] = $atividade->nome;
        $GLOBALS['info']['cpf'] = $atividade->login;
        $GLOBALS['info']['senha'] = $atividade->senha;
        $result = $this->view->editarAdmPagamento();
    }

    public function excluirAdmPagamento(){
        
        if ( !isset( $_SESSION ) ){
           session_start();
        }
       
        $id = $_GET["id"];

        $result = $this->model->excluirAdmPagamento($id);

        if ($result == 1) { 
            $arr = array ('tipo'=>1,'mensagem'=>"Administrador excluido com sucesso.",'redirecionar'=>"sistema.php?acao=adminGlobal/listagemAdmPagamento"); 
            echo json_encode($arr); 
        
        }
        if($result == 0) { 
            $arr = array ('tipo'=>0,'mensagem'=>"Não foi possivel excluir a alteração.");
            echo json_encode($arr); 
        }
    }

    public function salvarValoresAdmPagamento(){
        
        if ( !isset( $_SESSION ) ){
            session_start();
        }
        
        $result = $this->model->editarValoresAdmPagamento();
        if ($result == 1) { 
            $arr = array ('tipo'=>1,'mensagem'=>"Administrador alterado com sucesso.",'redirecionar'=>"sistema.php?acao=adminGlobal/listagemAdmPagamento"); 
            echo json_encode($arr); 
        }
        if($result == 0) { 
            $arr = array ('tipo'=>0,'mensagem'=>"Não foi possivel efetuar a alteração.");
            echo json_encode($arr); 
        }
    }
    /**
     * adminComumModel::rodarFilaDeEspera()
     *
     * Função responsável por rodar a fila de espera.
     * 
     * Autoras: Isabella Vieira e Mônica Neli
     *
    */
    public function rodarFilaEspera(){

        date_default_timezone_set("Brazil/East");
        
        if($this->model->verificarSeRodaFila()){

            //Avisa la que não pode rodar.
            $arr = array ('retorno'=>0); 
            echo json_encode($arr); 
        
        }else{

            // Setando a ultima data que foi rodada a fila de espera.
            $data = date("Y-m-d");
            $tabela = "config_sistema";
            $set = "ultima_data_fila = '".$data."'";
            $condicao = "";
            $this->model->update($tabela, $set, $condicao);
            
            //Seleciona todas os oficinas que existem no banco.             
            $tabela = "atividades";
            $dados = "*";
            
            $tabelaResult = "<table class=\"table table-striped table-borded\">
                                <tr>
                                    <th><div class=\"tituloFiladeEspera\" >Atividades</div></th>
                                    <th><div class=\"tituloFiladeEspera\" >Participantes na fila de espera</div></th>
                                    <th><div class=\"tituloFiladeEspera\" >Participantes chamados</div></th>
                                </tr>";

            $resultadoSql = $this->model->select($tabela, $dados);
            
            //Percorre a lista de oficinas.
            while($linha = mysql_fetch_object($resultadoSql)){
                
                //Selecionando todos os pagamentos confirmados que são da oficina x.
                $tabela = "pagamento";
                $dados = "*";
                $condicao = "fid_atividade = ".$linha->id_atividade." and status = 1";
                $participantesConfirmados = mysql_num_rows($this->model->select($tabela, $dados, $condicao));
                
                //echo "participantes confirmados ".$participantesConfirmados."<br/>";
                $numeroDeVagasOciosas = $linha->n_vagas - $participantesConfirmados;
                $cont = 0;
                
                //Seleciona todo mundo que está na fila de espera para a oficina x.
                $tabela = "participante_atividade";
                $dados = "*";
                $condicao = "fid_atividade = ".$linha->id_atividade." and fila_de_espera = 1";
                $order = "id_relacao_inscrito_atividade ASC";
                $group = "";
                $participantesFila = $this->model->select($tabela, $dados, $condicao, $group, $order);
                $qntdeNaFila = mysql_num_rows($participantesFila);
        
                //Enquanto houverem pessoas na fila e vagas desocupadas.
                while (($linha1 = mysql_fetch_array($participantesFila)) && ($cont < $numeroDeVagasOciosas)){
                    
                    //Atualiza o status do aluno, ele sai da fila de espera e ganha a vaga.
                    $data = date("Y-m-d");
                    $tabela = "participante_atividade";
                    $set = "fila_de_espera = '0', data_chamada_fila = '".$data."'";
                    $condicao = "id_relacao_inscrito_atividade = ".$linha1["id_relacao_inscrito_atividade"];
                    $this->model->update($tabela, $set, $condicao);


                    $tabela = "congressista";
                    $dados = "nome, email, cidade, estado";
                    $condicao = "id_congressista = ".$linha1["fid_congressista"];
                    $result = $this->model->select($tabela, $dados, $condicao);
                    $aluno = mysql_fetch_object($result);
                    
                    //enviarenviarEmail
                    //$this->gerarBoletoDaFila($linha1["id_relacao_inscrito_oficina"]);
                    
                    $cont = $cont + 1;      
                }
                
                
                if ($cont > 1){
                    $cont = $cont - 1;
                }
                
                
                $qntdeNaFila = $qntdeNaFila - $cont;

                
                $tabelaResult = $tabelaResult."<tr>
                                                    <td>".$linha->nome."</td>
                                                    <td>".$qntdeNaFila."</td>
                                                    <td>".$cont."</td>
                                                </tr>
                                            ";
            }
            $tabelaResult = $tabelaResult."</table>";       
            
            $arr = array ('retorno'=>1,'tabela'=> $tabelaResult); 
            echo json_encode($arr); 
            //return $tabelaResult;
        }   
    }

    public function listagemAdmGlobal(){

        if ( !isset( $_SESSION ) ){
            session_start();
        }

        $resultado = "";
        $resultado = $this->model->listagemAdmGlobal();
        $this->view->listagemAdmGlobal($resultado);
        
    }

    public function listagemAdmGlobalFiltro(){
        
        if ( !isset( $_SESSION ) ){
            session_start();
        }
         
        /* Seleciona os funcionarios */
        $resultado = "";
        $resultado = $this->model->listagemAdmGlobalFiltro();
        
        /* Exibe a lista de funcionarios desejada. Por padrao exibe todos no limite de 10. */
        $this->view->listagemAdmGlobalFiltro($resultado);
    }

    public function novoAdmGlobal(){
        
        if ( !isset( $_SESSION ) ){
            session_start();
        }
        
        $this->view->novoAdmGlobal();
    }

    public function editarAdmGlobal() {
        $id = $_GET["id"];
        $resultado = $this->model->selecionarAdmGlobal($id);
        $atividade = mysql_fetch_object($resultado);
        $GLOBALS['info']['id_usuario'] = $atividade->id_usuario;
        $GLOBALS['info']['nome'] = $atividade->nome;
        $GLOBALS['info']['cpf'] = $atividade->login;
        $GLOBALS['info']['senha'] = $atividade->senha;
        $this->view->editarAdmGlobal();
    }

    public function excluirAdmGlobal(){
        
        if ( !isset( $_SESSION ) ){
           session_start();
        }
       
        $id = $_GET["id"];
        echo $id;

        $result = $this->model->excluirAdmGlobal($id);

        if ($result == 1) { 
            $arr = array ('tipo'=>1,'mensagem'=>"Administrador excluido com sucesso.",'redirecionar'=>"sistema.php?acao=adminGlobal/listagemAdmGlobal"); 
            echo json_encode($arr); 
        
        }
        if($result == 0) { 
            $arr = array ('tipo'=>0,'mensagem'=>"Não foi possivel excluir a alteração.");
            echo json_encode($arr); 
        }
    }

    public function cadastrarAdmGlobal(){
        
        session_start();
        
        $result = $this->model->salvarAdmGlobal();

        if ($result == 1) { 
            $arr = array ('tipo'=>1,'mensagem'=>"Administrador cadastrado com sucesso.",'redirecionar'=>"sistema.php?acao=adminGlobal/listagemAdmGlobal"); 
            echo json_encode($arr); 
            exit;
        }
        if($result == 0) { 
            $arr = array ('tipo'=>0,'mensagem'=>"Não foi possivel efetuar o cadastro do administrador."); echo json_encode($arr); 
            exit;
        }
        if($result == 2) {
            $arr = array ('tipo'=>0,'mensagem'=>"CPF já cadastrado"); echo json_encode($arr); 
            exit;
        }
    }

    public function salvarValoresAdmGlobal(){
        
        if ( !isset( $_SESSION ) ){
            session_start();
        }
        
        $result = $this->model->editarValoresAdmGlobal();
        if ($result == 1) { 
            $arr = array ('tipo'=>1,'mensagem'=>"Administrador alterado com sucesso.",'redirecionar'=>"sistema.php?acao=adminGlobal/listagemAdmGlobal"); 
            echo json_encode($arr); 
        }
        if($result == 0) { 
            $arr = array ('tipo'=>0,'mensagem'=>"Não foi possivel efetuar a alteração.");
            echo json_encode($arr); 
        }
    }

    public function listagemAtividades(){

        if ( !isset( $_SESSION ) ){
            session_start();
        }
        $resultado = "";
        $resultado = $this->model->listagemAtividades();
        $this->view->listagemAtividades($resultado);
    }

    public function listagemAtividadesFiltro(){
        
        if ( !isset( $_SESSION ) ){
            session_start();
        }
        /* Seleciona os funcionarios */
        $resultado = "";
        $resultado = $this->model->listagemAtividadesFiltro();       
        /* Exibe a lista de funcionarios desejada. Por padrao exibe todos no limite de 10. */
        $this->view->listagemAtividadesFiltro($resultado);
    }
}
?>