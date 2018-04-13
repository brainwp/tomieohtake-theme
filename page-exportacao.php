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
	$csv_array = array(
						array(
							"email","nome_completo","nome_artistico","data_de_nascimento","cep","uf","cidade","endereco_completo","telefone","website","formacao","identidade_de_genero","raca","e_pessoa_com_deficiencia","necessita_recurso_especifico","identidade","cpf","rg_digitalizado","cpf_digitalizado",
							"como","portfolio","link_para_video"
									)
							);
	$candidatos = get_users( $args = array('role' => 'candidato') );
	foreach ($candidatos as $candidato ) {
		$user_meta= get_fields('user_'.$candidato->ID);
		// print_r($user_meta);
		$candidato_array = array();
		foreach ($user_meta as $key => $value ) {

			if ($key == 'cpf_digitalizado' || $key == 'rg_digitalizado' ) {
				$value = $value['url'];
			}
			elseif 	($key == 'senha' || $key == 'confirmacao_da_senha'){
				continue;
			}
			array_push($candidato_array, $value);

		}
		$inscricoes = get_posts(
			array(
				'author' =>  $candidato->ID,
				'post_type' => 'bza_inscricoes',
				'tax_query' => array(
					array(
						'taxonomy' => 'category',
						'field'    => 'name',
						'terms'    => 'PRÊMIO EDP NAS ARTES 2018',
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
				foreach ($post_meta as $key => $value) {
					if ($key == 'portfolio') {
						$value = $value['url'];
					}
					array_push($projeto, $value);
				}
				array_push($csv_array, $projeto);
			}
		}
	}

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
