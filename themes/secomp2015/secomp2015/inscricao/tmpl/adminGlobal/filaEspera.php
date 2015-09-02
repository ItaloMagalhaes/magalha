<script> 
	
	$(document).ready(function(){
		$("#aviso").hide();

	});

</script>
<div class="row">
	<div class="col-sm-12">
	    <div class="box atualizarInfo " id="loading-example">
	        <div class="box-header">
	            <!-- tools box -->
	            <i class="fa fa-barsa"></i>

	            <h3 class="box-title">Fila de Espera</h3>
	        </div><!-- /.box-header -->
	        <div class="box-body ">
	            <div class="row">
	                <div class="col-sm-12">
	                 	<div class='clearfix'>
					        <button class="btn btn-grey1 col-sm-12" id="rodarFilaEspera" type="button">Rodar Fila</button>
					    </div>
	                </div><!-- /.col -->
	            </div><!-- /.row - inside box -->
	        </div><!-- /.box-body -->
	        <div class="box-footer">
	               <div class='alert alert-warning alert-dismissable' id="aviso">
                        <i class='fa fa-warning'></i>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                        <b>Alerta!</b> Não é possível rodar a fila de espera hoje.
                    </div>  
	            </div><!-- /.row -->
	        </div><!-- /.box-footer -->
	    </div><!-- /.box -->
	</div>
</div>
<div class='box'>
    <div class='box-header'>
        <i class='fa fa-tasks'></i>
    	<h3 class='box-title'>Tabela Fila de Espera</h3>
	</div><!-- /.box-header -->
	<div class='box-body no-padding'> 
		<div id="tabela">

		</div>
	</div>
</div>