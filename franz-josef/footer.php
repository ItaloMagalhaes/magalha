		<?php do_action( 'franz_before_footer' ); ?>
        <div class="footer footer-inverse">
        	<?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>
                <div class="footer-lg">
                    <div class="container">
                        <div class="row">
                            <?php dynamic_sidebar( 'footer-widgets' ); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
            <div class="footer-menu-wrapper">
				<?php 
                    /* Footer menu */
                    $args = array(
                        'theme_location'=> 'footer-menu',
                        'container'     => false,
                        'menu_class'    => 'footer-menu container',
                        'echo'          => true,
                        'fallback_cb'   => false,
                        'items_wrap'    => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'         => 1
                    );
                    
                    wp_nav_menu( $args );
                ?>
            </div>
            <?php endif; ?>
            
            <?php do_action( 'franz_before_bottom_bar' ); ?>
        	<div class="bottom-bar">
            	<div class="container clearfix">
                	<div class="row">
                    	<?php do_action( 'franz_bottom_bar' ); ?>
                        <p class="copyright col-xs-12 col-sm-6">
                            <?php 
                                global $franz_settings; 
                                if ( ! $franz_settings['hide_copyright'] ) {
                                    if ( $franz_settings['copyright_text'] ) echo wp_kses_post( $franz_settings['copyright_text'] );
                                    else printf( __( '&copy; %1$s %2$s. All rights reserved.', 'franz-josef' ), date( 'Y' ), get_bloginfo( 'name' ) );
                                    echo '<br />';
                                }
                            ?>
                            <?php if ( ! $franz_settings['disable_credit'] ) printf( __( 'Criado por Linked EMpresa Junior' ), '<a href="http://www.graphene-theme.com/franz-josef/">' . __( 'Linked EJ', 'SJDR' ) . '</a>' ); ?>
                        </p>
                        
                        <?php
							$social_profiles = ( $franz_settings['social_profiles'][0] == false ) ? array_diff( $franz_settings['social_profiles'], array( '', false ) ) : $franz_settings['social_profiles'];
							if ( $social_profiles ) :
						?>
                        <ul class="social-links col-xs-12 col-sm-6">
							<?php foreach ( $social_profiles as $social_profile ) : ?>
                                <li><a href="<?php echo esc_url( $social_profile['url'] ); ?>" title="<?php echo esc_attr( $social_profile['title'] ); ?>" <?php if ( $franz_settings['social_media_new_window'] ) echo 'target="_blank"';?>>
                                    <?php if ( $social_profile['type'] != 'custom' ) : ?>
                                        <i class="fa fa-<?php echo esc_attr( $social_profile['type'] ); ?>"></i>
                                    <?php elseif ( $social_profile['icon_fa'] ) : ?>
                                        <i class="fa fa-<?php echo esc_attr( $social_profile['icon_fa'] ); ?>"></i>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url( $social_profile['icon_url'] ); ?>" alt="" />
                                    <?php endif; ?>
                                </a></li>
                            <?php endforeach; ?>
                            <?php do_action( 'franz_social_links' ); ?>
                        </ul>
                        <?php endif; ?>
                    </div>
            	</div>
            </div>
            
        	<?php wp_footer(); ?>
        </div>
    </body>
</html>