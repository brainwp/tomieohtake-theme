<?php
/**
 *
 * @package OnePress
 */

get_header(); ?>
<div id="content" class="site-content">
	<div id="content-inside" class="container no-sidebar">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			<h2 class="fullheader-title">Edições Anteriores do Prêmio</h2>
				<br />
				<div class="container">
				    <div class="row">
						
						<?php
								/* $paged é a variável para paginação do Loop CPT Prêmios */	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

								/* $args_loop_cpt_prêmios são os argumentos para o Loop */
								$args_loop_cpt_premios = array(
								'post_type' => 'premios',
								'orderby' => 'date',
								'order' => 'DESC',
								'posts_per_page' => '-1',
								'paged' => $paged
								);
								$loop_cpt_premios = new WP_Query( $args_loop_cpt_premios ); if ( $loop_cpt_premios->have_posts() ) {
								while ( $loop_cpt_premios->have_posts() ) : $loop_cpt_premios->the_post();
							?>		
							<div class="feature-item col-lg-4 col-sm-6">
								<div class="feature-media">
										<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_post_thumbnail('medium'); ?>
										</a>
								</div><!-- .feature-media -->
									<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>	
							</div><!-- .feature-item -->
							<?php
								// Fim do Loop
								endwhile;
							}
							?>
					</div><!-- .row -->
				</div><!-- .container -->
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!--#content-inside -->
</div><!-- #content -->

<?php get_footer(); ?>