<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FWD_Starter_Theme
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>


		<?php
			$args = array(
				'post_type' => 'fwd-service',
				'orderby' => 'title',
				'order' => 'ASC',
				'posts_per_page' => -1
			);

			$query = new WP_Query( $args );

			if( $query -> have_posts() ) {
				while ( $query -> have_posts() ) {
					$query -> the_post();
					?>
					<?php $postID = get_the_ID(); ?>
					<a href="#post-<?php echo $postID ?>"><?php the_title(); ?></a>
					<?php
				}
				wp_reset_postdata();
			}
				
			if( $query -> have_posts() ) {
				while ( $query -> have_posts() ) {
					$query -> the_post();
					?>
						<article>
							<?php $postID = get_the_ID(); ?>
							<h2 id='post-<?php echo $postID ?>'><?php the_title(); ?></h2>
							
							<?php 
								if (get_field('intro')) {
									the_field('intro');
								}
							?>
						</article>
					<?php
        			
				}
				wp_reset_postdata();
			}
		?>


	</main><!-- #primary -->

<?php
get_sidebar();
get_footer();