<?php

/**
 *Template Name: Home Provisória
 *
 * @package coletivo
 */

get_header('inscricao'); ?>

	<div id="content" class="site-content homeprov">
		<div id="content-inside" class="container no-sidebar">
			<div class="container">
			<div class="homeprov-logo">
 			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_index_logo.jpg">
 			</div>
            <hr>
            </div>
		<?php the_title( '<h2 class="fullheader-title">', '</h2>' ); ?>
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'template-parts/content', 'page' ); ?>

					<?php endwhile; // End of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer(); ?>
