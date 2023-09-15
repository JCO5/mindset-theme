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

		<!-- link loop -->
		<?php
			$args = array(
				'post_type' => 'fwd-service',
				'orderby' => 'title',
				'order' => 'ASC',
				'posts_per_page' => -1
			);

			$query = new WP_Query( $args );
		?>

		<nav class="service-nav-link">
		<?php
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
		?>
		</nav>

		<?php
			$terms = get_terms( 
				array(
					'taxonomy' => 'fwd-service-category'
				) 
			);
			if ( $terms && ! is_wp_error( $terms ) ) :
				foreach ( $terms as $term ) :
					// Add your WP_Query() code here
					$args = array(
						'post_type' => 'fwd-service',
						'orderby' => 'title',
						'order' => 'ASC',
						'posts_per_page' => -1,
						'tax_query' => array(
							array(
							'taxonomy' => 'fwd-service-category',
							'field' => 'slug',
							'terms' => $term->slug
							)
						)
					);
					$query = new WP_Query( $args );
					// Use $term->slug in your tax_query
					// Use $term->name to organize the posts
					echo '<h2>' . esc_html($term->name) . '</h2>';
					if ($query->have_posts()) :
						while ($query->have_posts()) :
							$query->the_post();
							?>
							<article>
								
								<?php 
								 if ( function_exists( 'get_field' ) ) {
									if ( get_field( 'intro' ) ) {
										echo '<h3 id="post-'. esc_attr( get_the_ID() ) .'">'. esc_html( get_the_title() ) .'</h3>';
										the_field( 'intro' );
									}
								}
						 
								?>
							</article>
						<?php
						endwhile;
						wp_reset_postdata();
					endif;
				endforeach;
			endif;
		?>

	</main><!-- #primary -->

<?php
get_sidebar();
get_footer();