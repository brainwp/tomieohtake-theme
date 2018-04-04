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
    $rg_verificado = (1 == get_user_meta($id, 'rg_verificado', true)) ? '<b>RG e CPF verificados - </b> Sim' : '<b>RG e CPF verificados - </b>Não'; // $r is set to 'Yes'

    $modal_cadastro='';
    $campos_user=get_fields("user_".$id);
    $perfil_completo = ( $campos_user['nome_completo']) ? '<b>Completo - </b> Sim' : '<b>Completo - </b> Não'; // $r is set to 'Yes'

    foreach ($campos_user as $campo => $valor) {
      if ($campo != 'senha' && $campo != 'confirmacao_da_senha') {
        if ($campo == 'rg_digitalizado') {
          $valor = '<br><img class="rg-user" src="'.$valor['url'].'">';
        }
        elseif($campo == 'nome_completo' && !$valor){
          $valor = 'Usuário não adicionou nome completo';
        }
        $objeto_campo = get_field_object($campo,"user_".$id);
        $nome_campo = $objeto_campo['label'];
         $modal_cadastro .= '<div><b>'.$nome_campo.': </b>'.$valor.'</div>';
        $teste[$nome_campo]=$valor;
      }
    }
    $checked = (1 == get_user_meta($id, 'rg_verificado', true)) ? 'checked' : '';
    $modal_cadastro .= '<form id="form-rg">
    <div class="acf-label">
    <label for="rg-verificado-checkbox">RG verificado</label>
    <input type="checkbox" id="rg-verificado-checkbox" name="rg-verificado-checkbox" value="1" '.$checked.' >
    <input type="hidden" id="user-id-rg" name="user-id-rg" value="'.$id.'" >
    <input type="submit" id="rg-verificado-submit" name="rg-verificado-submit" value="Salvar" >
    </div>
    </form>
    ';
    $args = array(
      'post_type'              => array( 'bza_inscricoes' ),
      'author'            => $id,
      'tax_query' => array(
        array(
          'taxonomy' => 'category',
          'field'    => 'name',
          'terms'    => 'PRÊMIO EDP NAS ARTES 2018',
        ),
      ),
    );
    $query = new WP_Query( $args );
  	if($query->post_count != 0 ){
      $modal_inscricao='';
  		$post=$query->posts[0];
      // $inscricao_completa=(1 == $meta = get_post_meta($post->ID, "inscricao_completa", true)) ? '<b>Inscrição - </b>  Completa' : '<b>Inscrição - </b>Incompleta'; // $r is set to 'Yes'
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
      // $modal_inscricao .= '<div class="acf-label">
      // <label for="inscricao-completa-checkbox">Inscrição completa</label>
      // <input type="checkbox" id="inscricao-completa-checkbox" name="inscricao-completa-checkbox" value="1" >
      // </div>';

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

function salva_rg(){
  $resultado = update_user_meta( $_POST['id'], 'rg_verificado', $_POST['verificado'] );
  echo json_encode(array($_POST, $resultado));
  die();
}

function marca_finalista(){
  // comentada a parte de selecionar só 8 como finalistas
  // $user_query = new WP_User_Query( array( 'meta_key' => 'finalista', 'meta_value' => 1 ) );
  // $contagem = json_encode(count($user_query->results));
  // if ($contagem == 8 && $_POST['valor'] == 1) {
  //   echo json_encode('Já existem oito candidatos selecionados');
  // }
  // else {
    $resultado = update_user_meta( $_POST['id'], 'finalista', $_POST['valor'] );
    echo json_encode($resultado);
  // }
    die();
}
// pega usuario com base nos metas
function query_user_ajax(){
  $args = array(
      'role'         => 'candidato',
  );
  $args['meta_query']= array('relation' => 'OR');
  $metas=$_POST['metas'];
  $html ='';
  $response = array();


  foreach ($metas as $key => $value) {
    $estados=explode('/', $value);

    foreach ($estados as $estado) {

        $query = array(
              'key'		=> $key,
              'value' => '[[:<:]]'.$estado.'[[:>:]]',
              'compare'	=> 'RLIKE',
          );
      array_push($args['meta_query'], $query );
    }
      $response['args']= $args;

  }

  //
  $candidatos = get_users($args);
  if (!$candidatos) {
    $response['html'] = '<div class="candidato"> não existem candidatos do estado.</div>';
    echo json_encode($response);

    die();
  }
  foreach ($candidatos as $candidato => $value) {
      $args = array(
        'post_type'              => array( 'bza_inscricoes' ),
        'author'            => $value->ID,
        'tax_query' => array(
          array(
            'taxonomy' => 'category',
            'field'    => 'name',
            'terms'    => 'PRÊMIO EDP NAS ARTES 2018',
          ),
        ),
      );
      $query = new WP_Query( $args );
      if($query->post_count != 0 ){
        $user_nome = ( get_field('nome_completo', 'user_'.$value->ID) ) ? get_field('nome_completo', 'user_'.$value->ID) : 'Usuário não completou o cadastro.';
        $inscritos .= '<div id="'.$value->ID.'" class="candidato">';
        $user_id = $value->ID;
        $inscritos .= '  <a href="#" class="user_ajax" data-id="'.$user_id.'">';
        $inscritos .=  $user_nome;
        $inscritos .=  '</a>';
        $checked = (1 == get_user_meta($user_id, 'finalista', true)) ? 'checked' : '';
        $inscritos .=  '<input class="seleciona-candidato" type="checkbox" data-id="'.$user_id.'" id="user_'. $user_id.'"  value="1" '. $checked.'/>';
        $inscritos .=  '  <label for="user_'.$user_id.'">';
        $inscritos .=  '   </div>';
      }
      else{
        $user_nome = ( get_field('nome_completo', 'user_'.$value->ID) ) ? get_field('nome_completo', 'user_'.$value->ID) : 'Usuário não completou a inscrição.';
        $cadastrados .= '<div id="'.$value->ID.'" class="candidato">';
        $user_id = $value->ID;
        $cadastrados .= '  <a href="#" class="user_ajax" data-id="'.$user_id.'">';
        $cadastrados .=  $user_nome;
        $cadastrados .=  '</a>';
        $checked = (1 == get_user_meta($user_id, 'finalista', true)) ? 'checked' : '';
        $cadastrados .=  '<input class="seleciona-candidato" type="checkbox" data-id="'.$user_id.'" id="user_'. $user_id.'"  value="1" '. $checked.'/>';
        $cadastrados .=  '  <label for="user_'.$user_id.'">';
        $cadastrados .=  '   </div>';
      }


  }
  if ($_POST['page'] == 'cadastrados') {
    $html = $cadastrados;
  }
  else{
    $html = $inscritos;

  }
  if ($html == "") {
    $html = '<div class="candidato"> não existem candidatos do estado.</div>';

  }
  $response['html'] = $html;
  echo json_encode($response);

  die();
}
