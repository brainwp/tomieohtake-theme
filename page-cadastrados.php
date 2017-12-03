<?php acf_form_head(); ?>
<?php
/**
 *Template Name: Artistas Cadastrados
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package coletivo
 */
 // if (is_user_logged_in()) {
 // 	wp_redirect( get_home_url().'/cadastro-edicao-de-usuarios' );
 //
 // }
get_header('inscricao'); ?>

	<div id="content" class="site-content">
<?php if(has_post_thumbnail() && $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true )):?>
		<div class="page-fullheader">
		 <img src="<?php echo $img[0];?>"/>
		</div>
		<?php endif;?>
		<div id="content-inside" class="container no-sidebar">
		<br />
		<h1 class="fullheader-title">
			Cdastrados
		</h1>
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
					<div class="col-md-6" id="login-preliminar">
						<h2 class="fullheader-title">Lista</h2>
            <div class="candidatos">
							<form class="" action="" method="get">
								<input id="busca-nome" type="text" name="nome" value="">
								<input type=submit id="label-busca-nome" value="">
								<a href="<?php echo get_permalink(); ?>">Ver todos</a>
							</form>

							<div class="clearfix">
							</div>
  						<?php
              // add_user_meta( 212, 'perfil_completo', '1', true );
              // add_user_meta( 218, 'perfil_completo', 1, true );
              // add_post_meta( 356, 'inscricao_completa', 1, true );

                $args = array(
  	                'role'         => 'candidato',
                );
								if (isset($_GET['nome'])) {
									$args['meta_query']= array(
											array(
													'key' => 'nome_completo',
													'value' =>  $_GET['nome'],
													'compare' => 'LIKE'
											)
									);
								}
                $candidatos = get_users($args);
                foreach ($candidatos as $candidato => $value) {
									$args = array(
										'post_type'              => array( 'bza_inscricoes' ),
										'author'            => $value->ID,
										'tax_query' => array(
											array(
												'taxonomy' => 'category',
												'field'    => 'name',
												'terms'    => 'Prêmio EDP nas Artes',
											),
										),
									);
									$query = new WP_Query( $args );
									if($query->post_count == 0 ){
										?>
										<div id="<?php echo $value->ID ?>" class="candidato">
											<?php
											$user_nome = ( get_field('nome_completo', 'user_'.$value->ID) ) ? get_field('nome_completo', 'user_'.$value->ID) : 'Usuário não completou a inscrição.';
											$user_id = $value->ID;
											?>
											<a href="#" class="user_ajax" data-id="<?php echo $user_id;?>">
												<?php echo $user_nome; ?>
											</a>
											<?php $checked = (1 == get_user_meta($user_id, 'finalista', true)) ? 'checked' : '';?>

												<br>

											<?php
											// print_r($value->ID);
											// echo "mais uma<br>";
											?>
										</div>
										<?php
									}


                }
              ?>
            </div>
					</div>
					<div class="col-md-6" id="mostra-user-ajax">
					<h2 class="fullheader-title">Cadastro</h2>
          <div id="dados-user">
            <h3 id="nome-user">Escolha um usuário para visualizar</h3>
            <div id="links-user">
              <div id="cadastro">
                Clique em um dos úsuários da lista para carregar suas informações.
              </div>
              <div id="inscricao">
              </div>
            </div>
            <div id="user-loading">

            </div>
          </div>


					</div>



				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!--#content-inside -->
	</div><!-- #content -->
  <div id="modal">
    <div id="modal-fundo">
      <div id="modal-loading" data-state=""></div>
      <div id="modal-cadastro" data-state=""></div>
      <div id="modal-inscricao" data-state=""></div>
    </div>
  </div>
<?php get_footer(); ?>
