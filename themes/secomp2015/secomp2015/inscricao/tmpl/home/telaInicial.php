 <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <i class="fa fa-bullhorn"></i>
                <h3 class="box-title">Avisos</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php   if(isset($info['listagem'])){
                            echo $info['listagem'];
                        }else{

                             ?>
                            <div class='callout callout-info  '>
                                <h4>Quando logado</h4>
                                <p>Para visualizar sua situação de inscrição clique no link 'Painel' que irá aparecer no menu a esquerda da página</p>
                            </div>
                        <?php } ?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
