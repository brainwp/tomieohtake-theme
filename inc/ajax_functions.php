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
    echo json_encode(array('id'=>$id, 'message'=>__('Sucesso!')));
  }
  else {
    echo json_encode(array('id'=>'nao sei', 'message'=>__('duh!')));
  }
  die();

}
