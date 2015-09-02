    <?php echo $info['listagem'];?>

 		<script src="js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- Sparkline -->
        
        <script type="text/javascript">
            $(function() {
                /* jQueryKnob */

                $(".knob").knob({
                    draw: function() {

                        // "tron" case
                        if (this.$.data('skin') == 'tron') {

                            var a = this.angle(this.cv)  // Angle
                                    , sa = this.startAngle          // Previous start angle
                                    , sat = this.startAngle         // Start angle
                                    , ea                            // Previous end angle
                                    , eat = sat + a                 // End angle
                                    , r = true;

                            this.g.lineWidth = this.lineWidth;

                            this.o.cursor
                                    && (sat = eat - 0.3)
                                    && (eat = eat + 0.3);

                            if (this.o.displayPrevious) {
                                ea = this.startAngle + this.angle(this.value);
                                this.o.cursor
                                        && (sa = ea - 0.3)
                                        && (ea = ea + 0.3);
                                this.g.beginPath();
                                this.g.strokeStyle = this.previousColor;
                                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                                this.g.stroke();
                            }

                            this.g.beginPath();
                            this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                            this.g.stroke();

                            this.g.lineWidth = 2;
                            this.g.beginPath();
                            this.g.strokeStyle = this.o.fgColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                            this.g.stroke();

                            return false;
                        }
                    }
                });
                /* END JQUERY KNOB */

                //INITIALIZE SPARKLINE CHARTS
                $(".sparkline").each(function() {
                    var $this = $(this);
                    $this.sparkline('html', $this.data());
                });

            });

        </script>
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <i class="fa fa-bullhorn"></i>
                        <h3 class="box-title">Avisos</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                       <?php echo $info['avisos'] ?>
                        
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div class="box atualizarInfo " id="loading-example">
                    <div class="box-header">
                        <!-- tools box -->
                        <i class="fa fa-dollar"></i>

                        <h3 class="box-title">Pagamento</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php echo $info['valores']; ?>
                            </div><!-- /.col -->
                        </div><!-- /.row - inside box -->
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <div class="row">
                                   <?php echo $info['graph'];?>
                            
                        </div><!-- /.row -->
                    </div><!-- /.box-footer -->
                </div><!-- /.box -->
            </div>
        </div>

