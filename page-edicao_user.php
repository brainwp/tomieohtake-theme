<?php acf_form_head(); ?>
<?php
/**
 *Template Name: Edicao user
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package coletivo
 */
$user_id=get_current_user_id();
get_header('inscricao'); ?>
<?php $msg = get_transient( "validacao_user_error" );
	// echo 'MSG: '.$msg;
	$post_acf = get_transient( "post_transient" );
	print_r($msg);

 ?>
	<div id="content" class="site-content">
<?php if(has_post_thumbnail() && $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true )):?>
		<div class="page-fullheader">
		 <img src="<?php echo $img[0];?>"/>
		</div>
		<?php endif;?>
		<div id="content-inside" class="container container-form no-sidebar">
		<?php the_title( '<h2 class="fullheader-title">', '</h2>' ); ?>
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
          <?php acf_form(array(
  					'post_id'		=> 'user_'.$user_id,
						// 'field_groups' => array('group_59fbfaf0ba8ff'),
						'field_groups' => array(61),

  					'new_post'		=> array(
  						'post_type'		=> 'post',
  						'post_status'		=> 'publish'
  					),
  					'submit_value'		=> 'Inscrever'
  				)); ?>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer(); ?>
