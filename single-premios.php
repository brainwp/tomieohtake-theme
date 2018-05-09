<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package coletivo
 */
get_header(); ?>

<div id="content" class="site-content">
	<div id="content-inside" class="container no-sidebar">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<?php the_title( '<h2 class="fullheader-title">', '</h2>' ); ?>
			<div class="container">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content', 'single' ); ?>

				<?php endwhile; // End of the loop. ?>
			</div>
		<?php if ( $premiado_1 = get_field('premiado_1') ): ?>
		<hr />
	    <h3 class="header-title">Premiados</h3>
	<div class="container">
        <div class="row">
                <div class="feature-item col-lg-4 col-sm-6">
                    <div class="feature-media">
			<?php $premiado_1 = get_field('premiado_1'); ?>
			<?php $img_premiado_1 = wp_get_attachment_link( $premiado_1, 'tomie-square', true); ?>
				<?php echo $img_premiado_1; ?></a>
                    </div>
                    <h3>1º Lugar - <?php the_field('nome_premiado_1'); ?></h3>
                    <?php $content_premiado_1 = get_post_meta( get_the_ID(), 'desc_premiado_1', true ); ?>
                    	<p><?php echo apply_filters( 'the_content', $content_premiado_1 );?></p>
                </div>
            <?php endif; ?>
            <?php if ( $premiado_2 = get_field('premiado_2') ): ?>
                <div class="feature-item col-lg-4 col-sm-6">
                    <div class="feature-media">
			<?php $premiado_2 = get_field('premiado_2'); ?>
			<?php $img_premiado_2 = wp_get_attachment_link( $premiado_2, 'tomie-square', true); ?>
				<?php echo $img_premiado_2; ?>
                    </div>
                    <h3>2º Lugar - <?php the_field('nome_premiado_2'); ?></h3>
                    <?php $content_premiado_2 = get_post_meta( get_the_ID(), 'desc_premiado_2', true ); ?>
                    	<p><?php echo apply_filters( 'the_content', $content_premiado_2 );?></p>
                </div>
                <?php endif; ?>
                <?php if ( $premiado_3 = get_field('premiado_3') ): ?>
                <div class="feature-item col-lg-4 col-sm-6">
                    <div class="feature-media">
			<?php $premiado_3 = get_field('premiado_3'); ?>
			<?php $img_premiado_3 = wp_get_attachment_link( $premiado_3, 'tomie-square', true); ?>
				<?php echo $img_premiado_3; ?>
                    </div>
                    <h3>3º Lugar - <?php the_field('nome_premiado_3'); ?></h3>
                    <?php $content_premiado_3 = get_post_meta( get_the_ID(), 'desc_premiado_3', true ); ?>
                    <p><?php echo apply_filters( 'the_content', $content_premiado_3 );?></p>
            	</div>
            	<?php endif; ?>
        </div>
	</div>
		<br />
			<?php if ( $mencao_honrosa = get_field('mencao_honrosa') ): ?>
			<hr />
			<h3 class="header-title">Menção Honrosa</h3>
		<div class="container">
	        <div class="row">
					<div class="feature-item col-lg-4 col-sm-6">
						<div class="feature-media">
					<?php $mencao_honrosa = get_field('mencao_honrosa'); ?>
					<?php $img_mencao_honrosa = wp_get_attachment_link( $mencao_honrosa, 'tomie-square', true); ?>
					<?php echo $img_mencao_honrosa;?>
		                </div>
		                    <h3 style="text-align: center;"><?php the_field('nome_mencao_honrosa'); ?></h3>
		                    <?php $content_mencao_honrosa = get_post_meta( get_the_ID(), 'desc_mencao_honrosa', true ); ?>
		                    	<p><?php echo apply_filters( 'the_content', $content_mencao_honrosa );?></p>
		            </div>
					<div class="feature-item col-lg-4 col-sm-6">
					<?php if ( $mencao_honrosa_2 = get_field('mencao_honrosa_2') ): ?>
						<div class="feature-media">
					<?php $mencao_honrosa_2 = get_field('mencao_honrosa_2'); ?>
					<?php $img_mencao_honrosa_2 = wp_get_attachment_link( $mencao_honrosa_2, 'tomie-square', true); ?>
					<?php echo $img_mencao_honrosa_2;?>
		                </div>
		                    <h3 style="text-align: center;"><?php the_field('nome_mencao_honrosa_2'); ?></h3>
		                    <?php $content_mencao_honrosa_2 = get_post_meta( get_the_ID(), 'desc_mencao_honrosa_2', true ); ?>
		                    	<p><?php echo apply_filters( 'the_content', $content_mencao_honrosa_2 );?></p>
		            <?php endif; ?>
		            </div>
		            <div class="feature-item col-lg-4 col-sm-6"></div>
	        </div>
        </div>
	        <br />
			<?php endif; ?>
				<?php if ( $selecionados = get_field('selecionados') ): ?>
				<hr />
				<h3 class="header-title">Selecionados</h3>
					<div class="container">
						<?php $selecionados = get_post_meta( get_the_ID(), 'selecionados', true );
						?>
						<?php if ( isset($selecionados)) :
							$selecionados_array =  explode( ',', $selecionados) ;
							if (!empty($selecionados_array) )  {
	 							$valor = '<div id="gallery">[gallery ids="'.$selecionados.'" type="square"]</div>';?>
								<?php echo apply_filters( 'the_content', $valor );
							}
						?>
						<?php endif;?>
					</div>
				<?php endif; ?>
				<?php if ( $juri = get_field('juri') ): ?>
				<hr />
				<?php $content_juri = get_post_meta( get_the_ID(), 'juri', true ); ?>
				<h3 class="header-title">Membros do Júri</h3>
					<div class="container">
						<p">
							<?php echo apply_filters( 'the_content', $content_juri );?>
						</p>
					</div>
				<?php endif; ?>
				<?php if ( $premiacoes = get_field('premiacoes') ): ?>
				<hr />
				<?php $content_premiacoes = get_post_meta( get_the_ID(), 'premiacoes', true ); ?>
				<h3 class="header-title">Premiações</h3>
					<div class="container">
						<p><?php echo apply_filters( 'the_content', $content_premiacoes );?></p>
					</div>
				<?php endif; ?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!--#content-inside -->
</div><!-- #content -->
<?php get_footer(); ?>
