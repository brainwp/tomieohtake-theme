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
        <?php printf(esc_html__('Desenvolvido pela %1$s com %2$s', 'coletivo'), '<a class="logo-brasa" href="' . esc_url('https://brasa.art.br', 'coletivo') . '">Brasa</a>', '<a class="logo-wp" href="' . esc_url('https://br.wordpress.org', 'coletivo') . '"><i class="fa fa-wordpress" aria-hidden="true"></i></a>'); ?>
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
                      if (current_user_can( 'jurado') || current_user_can( 'administrator')) {?>

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


add_image_size( 'tomie-square', 500, 500, true );

// Register Custom Post Type
function post_type_premios() {

  $labels = array(
    'name'                => _x( 'Prêmios', 'Post Type General Name', 'tema-coletivo' ),
    'singular_name'       => _x( 'Prêmios', 'Post Type Singular Name', 'tema-coletivo' ),
    'menu_name'           => __( 'Prêmios', 'tema-brasa' ),
    'parent_item_colon'   => __( 'Item parente', 'tema-coletivo' ),
    'all_items'           => __( 'Todos prêmios', 'tema-coletivo' ),
    'view_item'           => __( 'Ver prêmio', 'tema-coletivo' ),
    'add_new_item'        => __( 'Adicionar novo prêmio', 'tema-coletivo' ),
    'add_new'             => __( 'Adicionar novo', 'tema-coletivo' ),
    'edit_item'           => __( 'Editar item', 'tema-coletivo' ),
    'update_item'         => __( 'Atualizar item', 'tema-coletivo' ),
    'search_items'        => __( 'Buscar prêmio', 'tema-coletivo' ),
    'not_found'           => __( 'Não encontrado', 'tema-coletivo' ),
    'not_found_in_trash'  => __( 'Não encontrado na lixeira', 'tema-coletivo' ),
  );
  $args = array(
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions' ,),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 20,
    'menu_icon'           => 'dashicons-images-alt2',
    'can_export'          => true,
    'has_archive'         => 'premios',
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'capability_type'     => 'page',
  );
  register_post_type( 'premios', $args );

}

// Hook into the 'init' action
add_action( 'init', 'post_type_premios', 1 );


// Adicionando Campos ao CPT

if (!function_exists('get_field')) {
  function get_field($field) {
    global $post;
    return get_post_meta($post->ID, $field, true);
  }
} 
if (!function_exists('the_field')) {
  function the_field($field) {
    global $post;
    echo get_field($field);
  }
}
function premios_query( $query ) {
    if ( is_post_type_archive('premios') ) {
        $query->set( 'orderby', 'asc' );
        return;
    }
}
add_action( 'pre_get_posts', 'premios_query' ); 

// Adicionando classes dos campos

require get_template_directory() . '/inc/class-metabox.php';
$premios_metabox = new Odin_Metabox(
    'premios_metabox', // Slug/ID do Metabox (obrigatório)
    'Projetos, Jurí e Prêmios', // Nome do Metabox  (obrigatório)
    'premios', // Slug do Post Type, sendo possível enviar apenas um valor ou um array com vários (opcional)
    'normal', // Contexto (opções: normal, advanced, ou side) (opcional)
    'high' // Prioridade (opções: high, core, default ou low) (opcional)
);
$premios_metabox->set_fields(
    array(
        array(
            'id'          => 'premiado_1',
            'label'       => 'Imagem 1º Lugar',
            'type'        => 'image',
            'description' => ''
        ),
        array(
            'id'          => 'nome_premiado_1',
            'label'       => 'Nome do Projeto 1º Lugar',
            'type'        => 'text',
            'description' => ''
        ),
        array(
            'id'          => 'desc_premiado_1',
            'label'       => 'Descrição da equipe 1º Lugar',
            'type'        => 'editor',
            'description' => ''
        ),
        array(
            'id'          => 'premiado_2',
            'label'       => 'Premiado 2º Lugar',
            'type'        => 'image',
            'description' => ''
        ),
        array(
            'id'          => 'nome_premiado_2',
            'label'       => 'Nome do Projeto 2º Lugar',
            'type'        => 'text',
            'description' => ''
        ),
        array(
            'id'          => 'desc_premiado_2',
            'label'       => 'Descrição da equipe 2º Lugar',
            'type'        => 'editor',
            'description' => ''
        ),
        array(
            'id'          => 'premiado_3',
            'label'       => 'Premiado 3º Lugar',
            'type'        => 'image',
            'description' => ''
        ),
        array(
            'id'          => 'nome_premiado_3',
            'label'       => 'Nome do Projeto 3º Lugar',
            'type'        => 'text',
            'description' => ''
        ),
        array(
            'id'          => 'desc_premiado_3',
            'label'       => 'Descrição da equipe 3º Lugar',
            'type'        => 'editor',
            'description' => ''
        ),
        array(
            'id'          => 'mencao_honrosa',
            'label'       => 'Menção Honrosa',
            'type'        => 'image',
            'description' => ''
        ),
        array(
            'id'          => 'nome_mencao_honrosa',
            'label'       => 'Nome da Menção Honrosa',
            'type'        => 'text',
            'description' => ''
        ),
        array(
            'id'          => 'desc_mencao_honrosa',
            'label'       => 'Descrição da Menção Honrosa',
            'type'        => 'editor',
            'description' => ''
        ),
                array(
            'id'          => 'mencao_honrosa_2',
            'label'       => 'Menção Honrosa 2',
            'type'        => 'image',
            'description' => ''
        ),
        array(
            'id'          => 'nome_mencao_honrosa_2',
            'label'       => 'Nome da Menção Honrosa 2',
            'type'        => 'text',
            'description' => ''
        ),
        array(
            'id'          => 'desc_mencao_honrosa_2',
            'label'       => 'Descrição da Menção Honrosa 2',
            'type'        => 'editor',
            'description' => ''
        ),
        array(
            'id'          => 'selecionados',
            'label'       => 'Selecionados',
            'type'        => 'image_plupload',
            'description' => ''
        ),
        array(
            'id'          => 'juri',
            'label'       => 'Júri',
            'type'        => 'editor',
            'description' => ''
        ),
        array(
            'id'          => 'premiacoes',
            'label'       => 'Premiações',
            'type'        => 'editor',
            'description' => ''
        ),
    )
);

//plugin inscricoes
require get_stylesheet_directory() . '/inc/custom-post.php';
require get_stylesheet_directory() . '/inc/ajax_functions.php';
require get_stylesheet_directory() . '/inc/funcoes.php';

//custom content width for gallerys
function jeherve_custom_tiled_gallery_width() {
    return '940';
}
add_filter( 'tiled_gallery_content_width', 'jeherve_custom_tiled_gallery_width' );
