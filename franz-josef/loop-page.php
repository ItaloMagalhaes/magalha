<?php global $franz_settings; ?>
<div <?php post_class(); ?> id="entry-<?php the_ID(); ?>">
    <h1 class="entry-title"><?php the_title(); ?></h1>
    
	<?php if ( has_post_thumbnail() && ! $franz_settings['hide_featured_image'] ) : ?>
    	<div class="featured-image"><?php the_post_thumbnail(); ?></div>
        <?php do_action( 'franz_loop_thumbnail' ); ?>
    <?php endif; ?>
    
    <div class="entry-content clearfix">
    	<?php 
			the_content();
			franz_link_pages();
		?>
    </div>
    
    <?php 
		franz_related_posts();
		comments_template(); 
	?>
    <?php do_action( 'franz_loop_page' ); ?>
</div>