<?php

	if (!is_user_logged_in()) {
		wp_redirect( get_home_url().'/cadastro-edicao-de-usuarios' );

	}

	$current_user = wp_get_current_user();

	$user_id= $current_user->ID ;
	$user=$current_user->user_login;
	$args = array(
		'post_type'              => array( 'bza_inscricoes' ),
		'author'            => $user_id,
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'name',
				'terms'    => '2018',
			),
		),
	);

	// The Query
	$query = new WP_Query( $args );
	if($query->post_count > 4 ){
		wp_redirect( get_home_url().'/projetos' );
	}

acf_form_head(); ?>
<?php
/**
 *Template Name: Inscricao
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package coletivo
 */

get_header('inscricao'); ?>

	<div id="content" class="site-content">
	    <div class="page-header">
	      <div class="container">
	        <h1 class="page-title">Inscrição</h1>
	      </div><!-- container -->
	    </div><!-- page-header -->

    <?php if ( function_exists( 'coletivo_breadcrumb' ) ) : ?>
      <?php echo coletivo_breadcrumb(); ?>
    <?php endif; ?>

		<div id="content-inside" class="container container-form">
				<main id="main" class="site-main" role="main">
          <?php

					acf_form(array(
						'post_id'		=> 'new_post_'.$user_id,
						'field_groups' => array('group_5abeabb3f186a'),
  					'new_post'		=> array(
  						'post_type'		=> 'bza_inscricoes',
  						'post_status'		=> 'publish'
  					),
  					'submit_value'		=> 'Inscrever',
						'return' => get_home_url().'/inscricao-efetuada',
						'html_after_fields' => '<input type="hidden" name="post_category" value="2018"/>',

  				)); ?>
       	 		<br />
				</main><!-- #main -->
		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer(); ?>
