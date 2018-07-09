<?php acf_form_head(); ?>
<?php
/**
 *Template Name: Artistas Inscritos
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package coletivo
 */
 // if (is_user_logged_in()) {
 // 	wp_redirect( get_home_url().'/cadastro-edicao-de-usuarios' );
 //
 // }
 if 	( !current_user_can( 'jurado' ) && !current_user_can( 'administrator' ) ){
	 wp_redirect( get_home_url());

 }

get_header('inscricao'); ?>

	<div id="content" class="site-content">
<?php if(has_post_thumbnail() && $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true )):?>
		<div class="page-fullheader">
		 <img src="<?php echo $img[0];?>"/>
		</div>
		<?php endif;?>
		<div id="content-inside" class="container no-sidebar">
			<div id="primary" class="content-area">
        <br />
        <h1 class="fullheader-title">
          Inscritos
        </h1>
				<main id="main" class="site-main" role="main">
            <div class="candidatos-lista col-md-6">
            <h2 class="fullheader-title">Lista <a class="btn btn-theme-primary" href="<?php echo get_permalink(); ?>">Ver todos</a></h2>
						<?php echo "número total de candidatos com projetos: ".cont_proj();?>

              <form class="" action="" method="get">
                <input id="busca-nome" type="text" name="nome_completo" value="">
                <input type="submit" id="label-busca-nome" value="">
                <select name="estado" id="uf">

                  <option value="">Estado</option>
                  <option value="AC">AC</option>
                  <option value="AL">AL</option>
                  <option value="AM">AM</option>
                  <option value="AP">AP</option>
                  <option value="BA">BA</option>
                  <option value="CE">CE</option>
                  <option value="DF">DF</option>
                  <option value="ES">ES</option>
                  <option value="GO">GO</option>
                  <option value="MA">MA</option>
                  <option value="MG">MG</option>
                  <option value="MS">MS</option>
                  <option value="MT">MT</option>
                  <option value="PA">PA</option>
                  <option value="PB">PB</option>
                  <option value="PE">PE</option>
                  <option value="PI">PI</option>
                  <option value="PR">PR</option>
                  <option value="RJ">RJ</option>
                  <option value="RN">RN</option>
                  <option value="RS">RS</option>
                  <option value="RO">RO</option>
                  <option value="RR">RR</option>
                  <option value="SC">SC</option>
                  <option value="SE">SE</option>
                  <option value="SP">SP</option>
                  <option value="TO">TO</option>
                </select>
              </form>

						<div class="clearfix">
						</div>

            <div class="candidatos">

  						<?php
              // add_user_meta( 212, 'perfil_completo', '1', true );
              // add_user_meta( 218, 'perfil_completo', 1, true );
              // add_post_meta( 356, 'inscricao_completa', 1, true );

                $args = array(
  	                'role'         => 'candidato',
                );
								$args['meta_query']= array();

                if (isset($_GET['nome_completo'])) {
                      $nome=array(
                          'key' => 'nome_completo',
                          'value' =>  $_GET['nome_completo'],
                          'compare' => 'LIKE'
                      );
											array_push($args['meta_query'], $nome);
                }
                if (isset($_GET['estado'])) {
                      $estado=array(
                          'key' => 'estado',
                          'value' =>  $_GET['estado'],
                          'compare' => 'LIKE'
                      );
											array_push($args['meta_query'], $estado);
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
												'terms'    => '2018',
											),
										),
									);
									$query = new WP_Query( $args );
									if($query->post_count != 0 ){
	                  ?>
	                    <?php
	                    $user_nome = ( get_field('nome_completo', 'user_'.$value->ID) ) ? get_field('nome_completo', 'user_'.$value->ID) : 'Usuário não completou o cadastro.';
	                    $user_id = $value->ID;
											foreach ($query->posts as $post ) {?>
												<div id="<?php echo $value->ID ?>" class="candidato">

													<a href="#" class="inscricao_ajax" data-user-id="<?php echo $user_id;?>" data-id="<?php echo $post->ID;?>">
			                      <?php echo $user_nome." - ". get_field('nome_do_projeto',  $post->ID ); ?>
			                    </a>
													<?php
                          $jurado = wp_get_current_user();
                          $checked = (1 == get_post_meta($post->ID, 'finalista-2018_'.$jurado->ID, true)) ? 'checked' : '';?>
														<input class="seleciona-candidato" type="checkbox" data-id="<?php echo $post->ID;?>" id="user_<?php echo $post->ID;?>"  value="1" <?php echo $checked ?>/>
														<label for="user_<?php echo $post->ID;?>">
														</label>
														<br>
												</div>

												<?php
											}
											// print_r($query->posts);
											?>




	                    <?php
	                    // print_r($value->ID);
	                    // echo "mais uma<br>";
	                    ?>
	                <?php
									}
                } //fecha foreach ($candidatos as $candidato => $value)
              ?>
            </div>
					</div>
					<div class="col-md-6" id="mostra-user-ajax">
					<h2 class="fullheader-title">Inscrição do projeto</h2>
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
