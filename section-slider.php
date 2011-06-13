<?php
/**
 * Featured Content (slider) Template
 *
 * This file is used for the slider on the home and blog page.
 *
 * @package Cakifo
 * @subpackage Template
 */
?>

<?php
	/**
	 * Select posts from selected categories
	 * or sticky posts
	 */
	if ( hybrid_get_setting( 'featured_category' ) ) :
		$feature_query = array( 
			'cat' => hybrid_get_setting( 'featured_category' ),
			'showposts' => hybrid_get_setting( 'featured_posts' ),
			'ignore_sticky_posts' => 1,
			'no_found_rows' => true
		);
	else :
		$feature_query = array(
			'post__in' => get_option( 'sticky_posts' ),
			'showposts' => hybrid_get_setting( 'featured_posts' ),
			'no_found_rows' => true
		);
	endif;
?>

<?php $loop = new WP_Query( $feature_query ); ?>

<?php if ( $loop->have_posts() ) : ?>

	<?php do_atomic( 'before_slider' ); // cakifo_before_slider ?>

	<section id="slider">

    	<h1 class="assistive-text"><?php _e( 'Featured Posts', hybrid_get_textdomain() ); ?></h1>

		<div class="slides_container">

			<?php do_atomic( 'open_slider' ); // cakifo_open_slider ?>

			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

				<?php do_atomic( 'before_slide' ); // cakifo_before_slide ?>

				<article class="slide">
					<?php do_atomic( 'open_slide' ); // cakifo_open_slide ?>

					<?php
						if ( current_theme_supports( 'get-the-image' ) )
							get_the_image( array(
								'size' => 'slider',
								'attachment' => false,
								'meta_key' => null, // Don't allow to set thumbnail with custom field. That way you can have 2 thumbnails. One for the post and one for the slider
								'image_class' => 'thumbnail'
							) );
					?>

					<div class="entry-summary">
						<?php echo apply_atomic_shortcode( 'slider_entry_title', '[entry-title]' ); ?>
						<?php the_excerpt(); ?>
						<a class="more-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e( 'Continue reading <span class="meta-nav">&raquo;</span>', hybrid_get_textdomain() ); ?></a>
					</div> <!-- .entry-summary -->

					<?php do_atomic( 'close_slide' ); // cakifo_close_slide ?>
				</article> <!-- .slide -->

				<?php do_atomic( 'after_slide' ); // after_close_slide ?>

			<?php endwhile; ?>

			<?php do_atomic( 'close_slider' ); // cakifo_close_slider ?>

		</div> <!-- .slides_container -->

	</section> <!-- #slider -->

	<?php do_atomic( 'after_slider' ); // cakifo_after_slider ?>

<?php endif; wp_reset_query(); ?>