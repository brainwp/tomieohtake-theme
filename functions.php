<?php
/**
 * Tomie Ohtake functions and definitions.
 *
 */

// Altera a função do footer, originalmente no arquivo inc/template-tags.php

if ( ! function_exists( 'coletivo_footer_site_info' ) ) {
    /**
     * Add Copyright and Credit text to footer
     * @since 1.1.3
     */
    function coletivo_footer_site_info()
    {
        ?>
        <?php $coletivo_footer_text = get_theme_mod( 'coletivo_footer_text', esc_html__('Few Rights Reserved', 'coletivo') );?>
        <?php $coletivo_footer_text_link = get_theme_mod( 'coletivo_footer_text_link' );?>
        <?php if ( $coletivo_footer_text_link != '' ) echo '<a href="' . esc_html( $coletivo_footer_text_link) . '" alt="" target="_blank">'; ?>
        <?php if ( $coletivo_footer_text != '' ) echo '<div class="container">' . esc_html( $coletivo_footer_text) . '</div>'; ?>
        <?php if ( $coletivo_footer_text_link != '' ) echo '</a>'; ?>

        <?php printf(esc_html__('%2$s %1$s', 'coletivo'), esc_attr(date('Y')), esc_attr(get_bloginfo())); ?>
        <span class="sep"> &ndash; </span>
        <?php printf(esc_html__('Desenvolvido pela %1$s com %2$s', 'coletivo'), '<a class="logo-brasa" href="' . esc_url('http://brasa.art.br', 'coletivo') . '">Brasa</a>', '<a class="logo-wp" href="' . esc_url('https://br.wordpress.org', 'coletivo') . '"><i class="fa fa-wordpress" aria-hidden="true"></i></a>'); ?>
        <?php
    }
}
add_action( 'coletivo_footer_site_info', 'coletivo_footer_site_info' );

if ( ! function_exists( 'coletivo_site_header' ) ) {

    function coletivo_site_header(){
        ?>
        <header id="masthead" class="site-header" role="banner">
            <div class="container">
                <div class="site-branding">
                	<div class="site-brand-inner has-logo-img no-desc">
	                	<div class="site-logo-div"><a href="http://institutotomieohtake.org.br/" class="custom-logo-link" rel="home" itemprop="url" target="_blank">
	                		<img width="264" height="57" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_logo_menu.png" class="custom-logo" alt="Instituto Tomie Ohtake" itemprop="logo"></a>
	                	</div>
                	</div>
                </div>
                <!-- .site-branding -->

                <div class="header-right-wrapper">
                    <a href="#0" id="nav-toggle"><?php _e('Menu', 'coletivo'); ?><span></span></a>
                    <nav id="site-navigation" class="main-navigation" role="navigation">
                        <ul class="coletivo-menu">
                            <?php wp_nav_menu(array('theme_location' => 'primary', 'container' => '', 'items_wrap' => '%3$s')); ?>
                        </ul>
                    </nav>
                    <?php
                    if (is_user_logged_in()) {
                      if (current_user_can( 'jurado')) {?>

                        <nav id="user-navigation" class="main-navigation" role="navigation">
                            <ul class="user-menu coletivo-menu">
                              <li>Olá, <?php
                              	$current_user = wp_get_current_user();
                                // print_r($current_user);
                              	$nome= km_get_users_name($current_user->ID) ;
                                echo $nome;
                                ?>.</li>
                                <li id="user-menu-inscritos" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_home_url() ?>/inscritos">Inscritos</a></li>
                                <li id="user-menu-finalistas" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_home_url() ?>/finalistas">Selecionados</a></li>
                            </ul>
                        </nav>

                      <?php
                      }
                      else{
                        ?>
                        <nav id="user-navigation" class="main-navigation" role="navigation">
                            <ul class="user-menu coletivo-menu">
                              <li>Olá, <?php
                              	$current_user = wp_get_current_user();
                                // print_r($current_user);
                              	$nome= km_get_users_name($current_user->ID) ;
                                echo $nome;
                                ?>.</li>
                                <li id="user-menu-inscricao" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_home_url() ?>/inscricao">Inscrição</a></li>
                                <li id="user-menu-cadastro" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_home_url() ?>/cadastro-edicao-de-usuarios/">Cadastro</a></li>
                            </ul>
                        </nav>
                      <?php
                      }

                    } ?>

                    <!-- #site-navigation -->
                </div>
            </div>
        </header><!-- #masthead -->
        <?php
    }
}
add_action( 'coletivo_site_header', 'coletivo_site_header' );
//plugin
require get_stylesheet_directory() . '/inc/custom-post.php';
require get_stylesheet_directory() . '/inc/ajax_functions.php';
require get_stylesheet_directory() . '/inc/funcoes.php';
