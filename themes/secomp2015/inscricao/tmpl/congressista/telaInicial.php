    <?php echo $info['listagem'];?>

        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-bullhorn"></i>
                        <h3 class="box-title">Avisos</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?php echo $info['avisos']; ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="box atualizarInfo " id="loading-example">
                    <div class="box-header">
                        <!-- tools box -->
                        <i class="fa fa-tasks"></i>
                        <h3 class="box-title">Atividades</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php echo $info['atividades']; ?>
                            </div><!-- /.col -->
                        </div><!-- /.row - inside box -->
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                            
                        </div><!-- /.row -->
                    </div><!-- /.box-footer -->
                </div><!-- /.box -->
            </div>
        </div>