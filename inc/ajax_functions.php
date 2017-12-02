<?php
function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('nome de usuário ou senha errada.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('OK...')));
    }

    die();
}


// pega_user
function pega_user(){
  if (isset($_POST['id'])) {
    $id=$_POST['id'];
    $perfil_completo = (1 == get_user_meta($id, 'perfil_completo', true)) ? '<b>Completo - </b> Sim' : '<b>Completo - </b> Não'; // $r is set to 'Yes'
    $rg_verificado = (1 == get_user_meta($id, 'rg_verificado', true)) ? '<b>RG verificado - </b> Sim' : '<b>RG verificado - </b>Não'; // $r is set to 'Yes'

    $modal_cadastro='';
    $campos_user=get_fields("user_".$id);
    foreach ($campos_user as $campo => $valor) {
      if ($campo != 'senha' && $campo != 'confirmacao_da_senha') {
        if ($campo == 'rg_digitalizado') {
          $valor = '<br><img class="rg-user" src="'.$valor['url'].'">';
        }
        $objeto_campo = get_field_object($campo,"user_".$id);
        $nome_campo = $objeto_campo['label'];
         $modal_cadastro .= '<div><b>'.$nome_campo.': </b>'.$valor.'</div>';
        $teste[$nome_campo]=$valor;
      }

    }
    $args = array(
      'post_type'              => array( 'bza_inscricoes' ),
      'author'            => $id,
      'tax_query' => array(
        array(
          'taxonomy' => 'category',
          'field'    => 'name',
          'terms'    => 'Prêmio EDP nas Artes',
        ),
      ),
    );
    $query = new WP_Query( $args );
  	if($query->post_count != 0 ){
      $modal_inscricao='';
  		$post=$query->posts[0];
      $inscricao_completa=(1 == $meta = get_post_meta($post->ID, "inscricao_completa", true)) ? '<b>Inscrição - </b>  Completa' : '<b>Inscrição - </b>Incompleta'; // $r is set to 'Yes'
      $campos_inscricao=get_fields($post->ID);
      foreach ($campos_inscricao as $campo_insc => $valor_insc) {
        if ($campo_insc == 'portfolio') {
          $path = parse_url($valor_insc['url'], PHP_URL_PATH);
          $path = explode('&',$path);
          $filename = $path[0];
          $valor_insc = '<a target="_blank" href="'.$valor_insc['url'].'">'.basename($filename).'</a>';
        }
          $objeto_campo = get_field_object($campo_insc,$post->ID);
          $nome_campo = $objeto_campo['label'];
          $modal_inscricao .= '<div><b>'.$nome_campo.': </b>'.$valor_insc.'</div>';
          $teste=$post->ID;
      }

  	}
    else{
      $modal_inscricao=false;
    }
    echo json_encode(array('rg_verificado'=>$rg_verificado,'id'=>$id, 'perfil_completo'=>$perfil_completo, 'inscricao_completa'=>$inscricao_completa,'modal_cadastro'=>$modal_cadastro, 'modal_inscricao'=>$modal_inscricao, 'message'=>__('Sucesso!')));
  }
  else {
    echo json_encode(array('id'=>'nao sei', 'message'=>__('duh!')));
  }
  die();
}
