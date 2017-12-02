<?php
function bza_inscricoes_scripts() {
    wp_enqueue_style( 'style-bza_inscricoes', get_stylesheet_directory_uri().'/assets/css/bza_inscricoes_style.css' );
    wp_register_script('ajax-bza_inscricoes', get_stylesheet_directory_uri() . '/assets/js/bza_inscricoes_ajax.js', array('jquery') );
    wp_enqueue_script( 'ajax-bza_inscricoes' );
    wp_localize_script( 'ajax-bza_inscricoes', 'ajax_bza_inscricoes_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url(),
        'loadingmessage' => __('Verificando dados...')
    ));

}
add_action( 'wp_enqueue_scripts', 'bza_inscricoes_scripts' );

//ajax login
function ajax_login_init(){
    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}
add_action( 'wp_ajax_nopriv_pegauser', 'pega_user' );
add_action( 'wp_ajax_pegauser', 'pega_user' );
// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}


// Add a custom user role

$result = add_role( 'candidato', __('Candidato' ),array(
  'read' => true, // true allows this capability
  'edit_posts' => true, // Allows user to edit their own posts
  'edit_pages' => false, // Allows user to edit pages
  'edit_others_posts' => false, // Allows user to edit others posts not just their own
  'create_posts' => true, // Allows user to create new posts
  'manage_categories' => true, // Allows user to manage post categories
  'publish_posts' => true, // Allows the user to publish, otherwise posts stays in draft mode
  'edit_themes' => false, // false denies this capability. User can’t edit your theme
  'install_plugins' => false, // User cant add new plugins
  'update_plugin' => false, // User can’t update any plugins
  'update_core' => false, // user cant perform core updates
  'upload_files' => true, //
  )
);
if ( current_user_can('candidato') && !current_user_can('upload_files') )
    add_action('admin_init', 'allow_contributor_uploads');
function allow_contributor_uploads() {
    $contributor = get_role('candidato');
    $contributor->add_cap('upload_files');
}
/**
 * Add / Edit users
 */
function trac_load_value_user_email( $value, $post_id, $field ) {
	if ( false !== strpos($post_id, 'user_') && $user_id = str_replace('user_', '', $post_id) ) {
		$userdata = get_userdata( $user_id );
		if ( $userdata ) {
			$value = $userdata->user_email;
		}
	}
    return $value;
}
add_filter( 'acf/load_value/name=user_email', 'trac_load_value_user_email', 10, 3 );


// começa formularios de cadastro

function trac_update_userdata( $post_id ) {

  // Nova inscrição
  if (strpos($post_id, 'new_post_') !== false) {
    $args = array(
     'numberposts' => 1,
     'orderby' => 'post_date',
     'order' => 'DESC',
     'post_type' => 'bza_inscricoes',
     'post_status' => 'publish',
     'suppress_filters' => true
    );
    $novos = wp_get_recent_posts( $args, ARRAY_A );
   //  print_r( $novos[0]['ID']);

   if (isset($novos[0])){
     $titulo=get_the_title( $novos[0]['ID']);
     $titulo + 0;
     $titulo++;

   }
   else{
     $titulo='1';
   }

    $user=str_replace('new_post_', '', $post_id);

    $post = array(
       'post_status'  => 'publish' ,
       'post_title'  => $titulo ,
       'post_type'  => 'bza_inscricoes' ,
       'post_author' => $user
     );

     // insert the post
     $post_id = wp_insert_post( $post );
    //  adiciona a categoria (qual o edital/concurso)
     $termo=get_term_by( 'name', 'PRÊMIO EDP NAS ARTES', 'category' );
     wp_set_post_terms( $post_id, $termo->term_id, 'category' );
     // return the new ID
     do_action('acf/save_post', $post_id);
     global $current_user;
     $user_email = $current_user->user_email;
      email_confirma_user($user_email);
      $_POST['return'] = add_query_arg( array('post_id' => $post_id), $_POST['return'] );

     return $post_id;

  }

  // atualização de inscrição
  else  if (strpos($post_id, 'post_') !== false) {
    $post_id=str_replace('post_', '', $post_id);
    do_action('acf/save_post', $post_id);
    return $post_id;
  }


// cadastro de candidatoas
  // $user_name= $_POST['acf']['field_59fc6a2a127ad'];
	$user_email = $_POST['acf']['field_59fc712d7a1fc'];
  $senha=$_POST['acf']['acf-field_59fe003f256d9'];
  $senha_conf=$_POST['acf']['acf-field_59fe0082256da'];
  $nome_completo= $_POST['acf']['field_59fbfafd7b7da'];
  $data_nasc = $_POST['acf']['field_59fbfb077b7db'];
  $site = $_POST['acf']['field_59fbfbae7b7e1'];
  $password= $_POST['acf']['field_59fe003f256d9'];
  // set_transient( "post_transient", $_POST, 60 );



  // Create a new user
	if ( 'new_user' === $post_id ) {
    if($_POST['honeypot'] != ''){
  		die("spam yourself!");
  	}
    set_transient( "status_inscricao", 'preliminar', 60 );

		// Create a password
		$length = 13;
		$include_standard_special_chars = false;
		$random_password = wp_generate_password( $length, $include_standard_special_chars );
		// Create the user, use email as username
		$user_id = wp_create_user( $user_email, $password, $user_email );
    if (!is_int($user_id)){
      set_transient( "validacao_user_error", $user_id, 60 );
      return false;
    }
    else{
      wp_set_current_user($user_id);
      wp_set_auth_cookie($user_id);
      wp_update_user([
  			'ID' => $user_id,
  			'first_name' => ( ! empty($_POST['acf']['field_59fbfafd7b7da']) ? $_POST['acf']['field_59fbfafd7b7da'] : '' ),
  			'role' => 'candidato',
        'user_url' => $site
  		]);

      add_user_meta( $user_id, '_etapa_cadastro', 'preliminar');
      $post_id='user_'.$user_id;
      // do_action('acf/save_post', $post_id);
      // wp_redirect( get_home_url().'/inscricoes' );

    }
	// Edit the user's email
	}
  // atualizacao de candidatoas
  else {
    $user=str_replace('user_', '', $post_id);
		wp_update_user([
			'ID' => $user,
			'user_email' => $user_email,
      'first_name' => $nome_completo,
      'user_url' => $site

		]);
    wp_set_password( $password, $user );
    wp_set_auth_cookie($user);
    wp_set_current_user($user);
    do_action('wp_login', $user_email, $user);
    delete_user_meta($user, '_etapa_cadastro');

	}
  do_action('acf/save_post', $post_id);

      // You can change home_url() to the specific URL,such as
  //wp_redirect( 'http://www.wpcoke.com' );
}
add_action( 'acf/pre_save_post', 'trac_update_userdata', 1 );
// acaba formularios de cadastro




function my_acf_save_post( $post_id )
{
    if (strpos($post_id, 'user_') !== false && isset($_POST['acf']['field_59fbfafd7b7da'])) {
      wp_redirect(get_home_url().'/inscricao'); exit;
    }

}
add_action('acf/save_post', 'my_acf_save_post', 20);

if(!function_exists('log_it')){
 function log_it( $message ) {
   if( WP_DEBUG === true ){
     if( is_array( $message ) || is_object( $message ) ){
       error_log( print_r( $message, true ) );
     } else {
       error_log( $message );
     }
   }
 }
}

function logout_redirect($logouturl, $redir)
    {
        return $logouturl . '&amp;redirect_to='.get_home_url();
    }
add_filter('logout_url', 'logout_redirect', 10, 2);



function restringe_candidato( $query ) {
    if ( is_admin() || ! $query->is_main_query() )
        return;
    if ( is_home() ) {
        // Display only 1 post for the original blog archive
        return;
    }
    if ( is_post_type_archive( 'bza_inscricoes' ) ) {
        $user_id=get_current_user_id();
        // Display 50 posts for a custom post type called 'movie'
        $query->set( 'author', $user_id );
        return;
    }
}
add_action( 'pre_get_posts', 'restringe_candidato', 1 );

function hasWhiteSpace($string) {
  if ( preg_match('/\s/',$string) ){
    return true;
  }
  else {
    return false;
  }

}




//FORM IMAGE VALIDATION
add_filter('acf/validate_value/type=password', 'my_acf_validate_value', 10, 4);
function my_acf_validate_value( $valid, $value, $field, $input ){
	// bail early if value is already invalid
	if( !$valid ) {
		return $valid;
	}
  $value_1 = $_POST['acf']['field_59fe003f256d9'];
  $value_2 = $_POST['acf']['field_59fe0082256da'];
	if ($value_1 != $value_2 )  {
    $valid = 'As senhas não são iguais';
  }
	// return
	return $valid;

}
add_filter('acf/validate_value/key=field_59fc6a2a127ad', 'username_validation', 10, 4);
function username_validation( $valid, $value, $field, $input ){
  if( !$valid ) {
    return $valid;
  }
  // bail early if value is already invalid
  if (!validate_username( $value ) || hasWhiteSpace($value)) {
    $valid = "Nome de usuário inválido";
    return $valid;
  }
  if (username_exists( $value )) {
    $valid = "Nome já existe, por favor faça login <a class='show_login_link' href='#'> Aqui </a>";
    return $valid;
  }

	// return
	return $valid;

}
add_filter('acf/validate_value/key=field_59fbfb077b7db', 'date_validation', 10, 4);
function date_validation( $valid, $value, $field, $input ){
  $data_final=date("Ymd", strtotime("-18 year"));
  $data_inicial= date("Ymd", strtotime("-27 year"));
  if(strtotime($value) > strtotime(date("Ymd") )){
    return 'Por favor escolha uma data no passado.';
  }
  elseif (strtotime($value) > strtotime('19991223' ) || strtotime($value) < strtotime('19891223' )){

    return 'A inscrição é valida para jovens artistas de 18 a 27 anos.';
  }
  return $valid;

}
add_filter('acf/validate_value/key=field_59fc712d7a1fc', 'email_validation', 10, 4);
function email_validation( $valid, $value, $field, $input ){
  if( !$valid ) {
    return $valid;
  }
  if ( email_exists( $value ) && !is_user_logged_in() ) {
    $valid = "E-mail já cadastrado, por favor faça login <a class='show_login_link' href='".get_home_url()."/inscreva-se'> Aqui </a> ";
    return $valid;
  }
	// return
	return $valid;

}

// adiciona login/logout
add_filter( 'wp_nav_menu_items', 'your_custom_menu_item', 10, 2 );
function your_custom_menu_item ( $items, $args ) {
    if ($args->theme_location == 'primary') {
      if (is_user_logged_in()) {
         $items .='<li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item "><a class="login_button btn btn-theme-primary btn-lg" id="logout-botao" href="'.wp_logout_url( get_permalink() ).'">Sair</a></li>';
      }
      else {
        $items .='<li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item "><a class=" btn btn-theme-primary btn-lg" id="inscreva-se" href="'.get_home_url().'/inscreva-se">Inscreva-se</a></li>';
      }
    }
    return $items;
}

// restringe midia
add_action('pre_get_posts','users_own_attachments');
function users_own_attachments( $wp_query_obj ) {

    global $current_user, $pagenow;

    $is_attachment_request = ($wp_query_obj->get('post_type')=='attachment');

    if( !$is_attachment_request )
        return;

    if( !is_a( $current_user, 'WP_User') )
        return;

    if( !in_array( $pagenow, array( 'upload.php', 'admin-ajax.php' ) ) )
        return;

    if( !current_user_can('delete_pages') )
        $wp_query_obj->set('author', $current_user->ID );

    return;
}

add_action( 'init', 'blockusers_init' );
function blockusers_init() {
  if ( is_admin() && ! current_user_can( 'administrator' ) &&
    ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
    wp_redirect( home_url() );
    exit;
  }
}
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
  if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
  }
}


// get full Name
function km_get_users_name( $user_id = null ) {
	$user_info = $user_id ? new WP_User( $user_id ) : wp_get_current_user();
	if ( $user_info->first_name ) {
		if ( $user_info->last_name ) {
			return $user_info->first_name . ' ' . $user_info->last_name;
		}
		return $user_info->first_name;
	}
	return $user_info->display_name;
}



// reduzir users spans
// CHECK PRE SAVE POST ACF
function honeypot( $post_id ) {

}
add_filter('acf/pre_save_post' , 'honeypot', 10, 1 );


// email de confirmacao
function email_confirma_user($email){
  $subject = 'Inscrição Prêmio EDP nas Artes';
  $message = 'Você está inscrito.';
  $body = file_get_contents(get_stylesheet_directory() . '/inc/email-user.php');
  function usar_html(){
      return "text/html";
  }

  add_filter( 'wp_mail_content_type','usar_html' );
  wp_mail( $email, $subject, $body );


  // Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578

 }


//Verifica se usuário tem inscrição
//Verifica se usuário tem inscrição
//Verifica se usuário tem inscrição
//$args é um array que da forma:
// array(
//  'user' => 'id_user',
//  'user_role' => 'role',
//  'cpt' => 'slug_cpt',
//  'tax' => array(
//    'tax_1'=>tax,
//    'tax_2'=>tax2,
//   ),
//  'meta_user' => array(
//    'meta_user_1'=>'meta',
//    'meta_user_2'=>'meta_2',
//   ),
//  'meta_post' => array(
//    'meta_post_1'=>'meta',
//    'meta_post_2'=>'meta_2',
//   ),
// )
function verifica_cpt($args){

}
