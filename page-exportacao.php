<?php
/**
 *Template Name: Página de exportação
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
$options = array();

$field_groups = acf_get_field_groups();
foreach ( $field_groups as $group ) {

  if ($group['title'] == 'Candidatos 2018') {
    $fields = get_posts(array(
      'posts_per_page'   => -1,
      'post_type'        => 'acf-field',
      'orderby'          => 'menu_order',
      'order'            => 'ASC',
      'suppress_filters' => true, // DO NOT allow WPML to modify the query
      'post_parent'      => $group['ID'],
      'post_status'      => 'any',
      'update_post_meta_cache' => false
    ));
    $array_user_keys = array();
    foreach ( $fields as $field ) {
      $key = $field->post_excerpt;
      if ($key != 'senha' && $key != 'confirmacao_da_senha'  ) {
        array_push($array_user_keys, $key);
        // print_r($field->post_excerpt);
      }
      // print_r($field->post_excerpt);


      // die;
      // $options[$field->post_name] = $field->post_title;
    }
    // print_r($array_user_keys);
    // die;
  }
  elseif ($group['title'] == 'Prêmio Design 2018'){
    $fields = get_posts(array(
      'posts_per_page'   => -1,
      'post_type'        => 'acf-field',
      'orderby'          => 'menu_order',
      'order'            => 'ASC',
      'suppress_filters' => true, // DO NOT allow WPML to modify the query
      'post_parent'      => $group['ID'],
      'post_status'      => 'any',
      'update_post_meta_cache' => false
    ));
    $array_proj_keys = array();
    foreach ( $fields as $field ) {
      $key = $field->post_excerpt;
      if ($key != 'senha' && $key != 'confirmacao_da_senha'  ) {
        array_push($array_proj_keys, $key);
        // print_r($field->post_excerpt);
      }
    }
  }
  $csv_array = $array_user_keys;
  if (is_array($array_proj_keys)) {
    $csv_array = array(array_merge($array_user_keys,$array_proj_keys));

  }
}
	$candidatos = get_users( $args = array('role' => 'candidato') );
	foreach ($candidatos as $candidato ) {
		$user_meta= get_fields('user_'.$candidato->ID);
		// print_r($user_meta);
		$candidato_array = array();
		foreach ($user_meta as $key => $value ) {

			if ($key == 'cpf_digitalizado' || $key == 'rg_digitalizado' || $key == 'formacao_doc_digitalizado') {
				$value = $value['url'];
			}
			elseif 	($key == 'senha' || $key == 'confirmacao_da_senha'){
				continue;
			}
			array_push($candidato_array, $value);
      if 	($key == 'como_ficou_sabendo_do_premio' && !isset($user_meta['outros'])){
        array_push($candidato_array, '');

      }
      // if(!isset($user_meta['outros'])){
      //   print_r($user_meta['email']);
      //   echo "--<br>";
      // }
		}

		$inscricoes = get_posts(
			array(
				'author' =>  $candidato->ID,
				'post_type' => 'bza_inscricoes',
				'tax_query' => array(
					array(
						'taxonomy' => 'category',
						'field'    => 'name',
						'terms'    => '2018',

					),
				),
			)
		);
		if ($inscricoes == array()) {
		}
		else{
			foreach ($inscricoes as $inscricao ) {
				$projeto = $candidato_array;
				$post_meta=get_fields( $inscricao->ID );
				if (is_array($post_meta)) {
					foreach ($post_meta as $key => $value) {
						if ($key == 'projeto' || $key == 'orcamento_cronograma' ) {
							$value = $value['url'];
						}
						array_push($projeto, $value);
            if($key == 'tipo_projeto' && $value !="Outro"){
              array_push($projeto, '');

            }
					}
					array_push($csv_array, $projeto);
				}
			}
		}
	}
	// print_r($csv_array);
	// wp_die();
// die;
	$uploads = wp_upload_dir();

	$fp = fopen($uploads['path'].'/incricoes.csv', 'w');

	foreach ($csv_array as $fields) {
			fputcsv($fp, $fields);
	}

	fclose($fp);
	header('Content-Type: application/csv');
	header('Content-Disposition: attachment; filename=incricoes.csv');
	header('Pragma: no-cache');
	$teste=file_get_contents($uploads['path'].'/incricoes.csv');
	echo $teste;
?>
