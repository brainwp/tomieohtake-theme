<?php acf_form_head(); ?>
<?php
/**
 *Template Name: Cadastro
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package coletivo
 */
get_header('inscricao'); ?>

	<div id="content" class="site-content">
<?php if(has_post_thumbnail() && $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true )):?>
		<div class="page-fullheader">
		 <img src="<?php echo $img[0];?>"/>
		</div>
		<?php endif;?>
		<div id="content-inside" class="container container-form no-sidebar">
		<h2 class="fullheader-title">
			<?php

				if (is_user_logged_in()) {
					$current_user = wp_get_current_user();
					$user_id= 'user_'.$current_user->ID ;
					$user=$current_user->user_login;
					$post_id = $user_id;
					if (get_user_meta($current_user->ID, '_etapa_cadastro',true)=='preliminar') {
						echo "Finalizar cadastro";
						$submit = "Finalizar cadastro";
						$updated = "Cadastro criado";

					}
					else{
						echo "Atualizar cadastro";
						$submit = "Atualizar cadastro";
						$updated = "Cadastro Atualizado";

					}
				}
				else{
					$post_id = 'new_user';
					$submit = 'Finalizar cadastro';
					echo "Finalizar cadastro";
					$submit = "Finalizar cadastro";
				}
				?>
		</h2>
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
					<?php $msg = get_transient( "validacao_user_error" );
						// echo 'MSG: '.$msg;
						$post_acf = get_transient( "post_transient" );
						print_r($msg);
					 ?>
          <?php
							$args=array(
		  					'post_id'		=> $post_id,
							'field_groups' => array('group_59fbfaf0ba8ff'),
		  					'submit_value'		=> $submit,
							'updated_message' => $updated,
	  					);
						acf_form($args); ?>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer(); ?>
