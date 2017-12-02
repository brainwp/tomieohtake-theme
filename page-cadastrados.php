<?php acf_form_head(); ?>
<?php
/**
 *Template Name: Artistas Cadastradas
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
			Inscritos
		</h1>
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
					<div class="col-md-6" id="login-preliminar">
						<h2 class="fullheader-title">Lista</h2>
            <div class="Cadidatos">
  						<?php
                $args = array(
  	                'role'         => 'candidato',
                );
                $candidatos = get_users($args);
                foreach ($candidatos as $candidato => $value) {
                  ?>
                  <div id="<?php echo $value->ID ?>" class="candidato">

                    <?php
                    echo get_field('nome_completo', 'user_'.$value->ID).'<input type="checkbox" id="user_'.$value->ID.'" value="1" /><label for="user_'.$value->ID.'"></label><br>';
                    // print_r($value->ID);
                    // echo "mais uma<br>";
                    ?>
                </div>
                <?php
                }
              ?>
            </div>
					</div>
					<div class="col-md-6" id="cadastro-preliminar">
					<h2 class="fullheader-title">Não possui? Cadastre-se!</h2>
						<?php
								$args=array(
									'post_id'		=> 'new_user',
									// 'field_groups' => array(61),
									'fields' => array('field_59fc6a2a127ad','field_59fc712d7a1fc','field_59fe003f256d9','field_59fe0082256da'),
									'html_after_fields'	=> '<input type="text" id="honeypot" name="honeypot" autocomplete="off">',
									'updated_message' => __("", 'acf'),


									'submit_value'		=> 'Próximo passo'
								);
							acf_form($args);

							?>
					</div>



				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer(); ?>
