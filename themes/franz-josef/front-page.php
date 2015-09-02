<?php get_header(); ?>
    
    <?php do_action( 'franz_front_page_top' ); ?>
    <?php // franz_stack( 'contra' ); ?>
    
    <?php if ( get_option( 'show_on_front' ) == 'page' ) : wp_reset_postdata(); ?>
    <div class="highlights static-front-page">
        <div class="container">
            <h2 class="highlight-title"><?php the_title(); ?></h2>
            <?php the_content(); ?>
            <?php do_action( 'franz_front_page_content' ); ?>
        </div>
    </div>
    <?php endif; ?>
    
    <?php  franz_stack( 'gallery' ); ?>
    <?php  franz_stack( 'quote' ); ?>
    <?php //franz_stack( 'posts' ); ?>
    <?php  //franz_stack( 'cta' ); ?>
    <?php // franz_stack( 'testimonials' ); ?>
    <?php //franz_stack( 'mentions-bar' ); ?>
    
	<?php do_action( 'franz_front_page_bottom' ); ?>
    
<?php get_footer(); ?>