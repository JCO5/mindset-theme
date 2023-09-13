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
			?>
			<section class="home-intro">
				<?php
					if ( function_exists( 'get_field' ) ) {
						if ( get_field( 'top_section' ) ) {
						the_field( 'top_section' );
					}
				}
				?>
			</section>
				<?php
				$args = array(
					'post_type' => 'fwd-work',
					'posts_per_page' => 4,
					'tax_query' => array(
						array(
							'taxonomy' => 'fwd-featured',
							'field' => 'slug',
							'terms' => 'front-page'
						)
					)
				);

				$query = new WP_Query( $args );

				if( $query -> have_posts() ) :
					?>
					<section class="home-work">
						<h2>Featured Works</h2>
					<?php
					while ( $query -> have_posts() ) :
						$query -> the_post();
						?>
							<article>
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail('medium');?>
									<h3><?php the_title(); ?></h3>
								</a>
							</article>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
					</section>
				<?php
				endif;
				?>
			<section class="home-left">
			<?php
				if ( function_exists( 'get_field' ) ) {

					if ( get_field( 'left_section_heading' ) ) {
						echo '<h2>';
						the_field( 'left_section_heading' );
						echo '</h2>';
					}

					if ( get_field( 'left_section_content' ) ) {
						echo '<p>';
						the_field( 'left_section_content' );
						echo '</p>';
					}

				}
			?>
			</section>
			<section class="home-right">
			<?php
				if ( function_exists( 'get_field' ) ) {

					if ( get_field( 'right_section_heading' ) ) {
						echo '<h2>';
						the_field( 'right_section_heading' );
						echo '</h2>';
					}

					if ( get_field( 'right_section_content' ) ) {
						echo '<p>';
						the_field( 'right_section_content' );
						echo '</p>';
					}

				}
			?>
			</section>
			<section class="home-slider">

			</section>
			<section class="home-blog">
				<h2><?php esc_html_e('Latest Blog Posts')?></h2>
				<?php
					$args = array(
						'post_type' => 'post',
						'posts_per_page' => 4
					);
					$blog_query = new WP_Query( $args );
					if ($blog_query -> have_posts() ) {
						while($blog_query -> have_posts() ) {
							$blog_query -> the_post();
				?>
					<article>
						<a href="<?php the_permalink(); ?>">
							<h3><?php the_title(); ?></h3>
							<time> <?php the_time('F j, Y'); ?> </time> <br>
							<?php
							the_post_thumbnail('featured-image-home', array(
								'alt' => the_title_attribute(
									array(
										'echo' => false,
									)
								),
							));
							?>
						</a>
						
					</article>
				<?php
						}
						wp_reset_postdata();
					}
				?>
			</section>
		
		<?php
		endwhile; // End of the loop.
		?>

	</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
