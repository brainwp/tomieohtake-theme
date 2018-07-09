jQuery(document).ready(function($) {
  if ($('body').hasClass('logged-in')) {
    $('#acf-field_59fc6a2a127ad').attr('disabled', 'disabled')
    // $('#acf-field_59fc712d7a1fc').attr('disabled', 'disabled')

  }
    $('#register-user').on('click', function(e){
        $('form#login-user').fadeIOut(500);
        $('div.login_overlay, form#login a.close').on('click', function(e){
            $('div.login_overlay').remove();
            $('form#login').hide();
            e.preventDefault();

        });
        e.preventDefault();
    });
    $('#acf-form').on('click', 'a.show_login_link', function(e){
      $('body').prepend('<div class="login_overlay"></div>');
      $('form#login-user').fadeIn(500);

      $('div.login_overlay, form#login-user a.close').on('click', function(e){
          e.preventDefault();
          $('div.login_overlay').remove();
          $('form#login-user').hide();
      });
      e.preventDefault();
    });
    // Show the login dialog box on click
    $('a.show_login_link').on('click', function(e){
        $('body').prepend('<div class="login_overlay"></div>');
        $('form#login-user').fadeIn(500);

        $('div.login_overlay, form#login-user a.close').on('click', function(e){
            e.preventDefault();
            $('div.login_overlay').remove();
            $('form#login-user').hide();
        });
        e.preventDefault();
    });



    // Perform AJAX login on form submit
    $('form#login-user').on('submit', function(e){
        $('form#login-user p.status').show().text(ajax_bza_inscricoes_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_bza_inscricoes_object.ajaxurl,
            data: {
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('form#login-user #username').val(),
                'password': $('form#login-user #password').val(),
                'security': $('form#login-user #security').val() },
            success: function(data){
              var url      = window.location.href;
                $('form#login-user p.status').text(data.message);
                if (data.loggedin == true){
                    document.location.href = url;
                }
            }
        });
        e.preventDefault();
    });

// Função para pegar inscrição de projeto
// 			carrega_inscricao(post_id,user_id,nome);

		function carrega_inscricao(post_id,user_id,nome){
      $('#nome-user').html(nome);
      $('.candidatos').addClass('desativado');
      $('#links-user').fadeOut();
      $('#user-loading').fadeIn(500);
      $.ajax({
          type: 'POST',
          dataType: 'json',
          url: ajax_bza_inscricoes_object.ajaxurl,
          data: {
              'action': 'pegainscricao',
              'user_id': user_id,
							'post_id': post_id

            },
          success: function(data){
            $('#links-user #cadastro').html('<div>'+data['perfil_completo']+'</div>');
            $('#links-user #cadastro').append('<div>'+data['rg_verificado']+'</div>');
            $('#links-user #cadastro').append('<div><button class="btn btn-theme-primary">Ver DADOS DO PROPONENTE</button></div>');
            if (data['modal_inscricao']) {
              $('#links-user #inscricao').html('<div><b>Inscrição de projeto - </b>  Completa</div>');
              // $('#links-user #inscricao').html('<div>'+data['inscricao_completa']+'</div>');
              $('#links-user #inscricao').append('<div><button class="btn btn-theme-primary">DADOS PROJETO</button></div>');
            }
            else{
              $('#links-user #inscricao').html('<div>O candidato não inscreveu nenhum projeto</div>');
            }
            $('#user-loading').fadeOut(500);
            $('.candidatos').removeClass('desativado');
            $('#modal-cadastro').html('<a id="fechar" href="#">X</a>'+data['modal_cadastro']);
            $('#modal-inscricao').html('<a id="fechar" href="#">X</a>'+data['modal_inscricao']);
            console.log(data['teste'])
            $('#links-user').fadeIn();


          }
      });

    }
// Pega_inscricao



// Função para carregar usuários da página de cadastro e de inscritos (quando aplicavel)
    function carrega_user(id,nome ){
      $('#nome-user').html(nome);
      $('.candidatos').addClass('desativado');
      $('#links-user').fadeOut();
      $('#user-loading').fadeIn(500);
      $.ajax({
          type: 'POST',
          dataType: 'json',
          url: ajax_bza_inscricoes_object.ajaxurl,
          data: {
              'action': 'pegauser', //calls wp_ajax_nopriv_ajaxlogin
              'id': id
            },
          success: function(data){
            $('#links-user #cadastro').html('<div>'+data['perfil_completo']+'</div>');
            $('#links-user #cadastro').append('<div>'+data['rg_verificado']+'</div>');
            $('#links-user #cadastro').append('<div><button class="btn btn-theme-primary">DADOS ARQUITETO PROPONENTE</button></div>');
            if (data['modal_inscricao']) {
              $('#links-user #inscricao').html('<div><b>Inscrição de projeto - </b>  Completa</div>');
              // $('#links-user #inscricao').html('<div>'+data['inscricao_completa']+'</div>');
              $('#links-user #inscricao').append('<div><button class="btn btn-theme-primary">DADOS PROJETO</button></div>');
            }
            else{
              $('#links-user #inscricao').html('<div>O candidato não inscreveu nenhum projeto</div>');
            }
            $('#user-loading').fadeOut(500);
            $('.candidatos').removeClass('desativado');
            $('#modal-cadastro').html('<a id="fechar" href="#">X</a>'+data['modal_cadastro']);
            $('#modal-inscricao').html('<a id="fechar" href="#">X</a>'+data['modal_inscricao']);
            $('#links-user').fadeIn();


          }
      });

    }
    // ajax da página de inscritos
    $('.page-template-page-inscritos-php , .page-template-page-cadastrados-php ').on('click', '.user_ajax', function(e){
      // alert($(this).attr('data-id'));
      id=$(this).attr('data-id');
      nome=$(this).text();

      carrega_user(id,nome);
      window.scrollTo(0, 0);

      e.preventDefault();
    });

    // novo ajax da página de inscritos, pegando os projetos e não os candidatos
		$('.page-template-page-inscritos-php ').on('click', '.inscricao_ajax', function(e){
			// alert($(this).attr('data-id'));
			user_id=$(this).attr('data-user-id');
			post_id=$(this).attr('data-id');
			nome=$(this).text();

			carrega_inscricao(post_id,user_id,nome);
			window.scrollTo(0, 0);

			e.preventDefault();
		});
    // Clique no cadastro

    $('.page-template-page-inscritos-php , .page-template-page-cadastrados-php ').on('click', '#cadastro',function(e){
      $('body').prepend('<div style="display:none" class="login_overlay"></div>');
      $('.login_overlay').fadeIn(500);

      $('#modal-cadastro').fadeIn();
      e.preventDefault();
      $('.page-template-page-inscritos-php , .page-template-page-cadastrados-php ,  .page-template-page-finalistas-php, .page-template-page-proj-finalistas-php, .page-template-page-finalistas-jur ').on('click',' #fechar', function(e){
        $('#modal-cadastro').fadeOut(500);
        $('.login_overlay').fadeOut(500,function(){
          $('.login_overlay').remove()
        });
        e.preventDefault();
      });
    });


    // Clique na inscricao

    $('.page-template-page-inscritos-php  , .page-template-page-cadastrados-php').on('click', '#inscricao', function(e){
      $('body').prepend('<div style="display:none" class="login_overlay"></div>');
      $('.login_overlay').fadeIn(500);

      $('#modal-inscricao').fadeIn();
      e.preventDefault();
      $('.page-template-page-inscritos-php , .page-template-page-cadastrados-php , .page-template-page-finalistas-php, .page-template-page-proj-finalistas-php, .page-template-page-finalistas-jur ').on('click','#fechar' ,function(e){
        $('#modal-inscricao').fadeOut(500);
        $('.login_overlay').fadeOut(500,function(){
          $('.login_overlay').remove()
        });
        e.preventDefault();
      });
    });

// funcao erifica se checkbox esta marcado
function verifica_box(elemento){
  if (elemento.is(":checked")){
    return 1;
  }
  else{
    return 0;
  }
}



// Clique no salvar verificacao do rg
    $('.page-template-page-inscritos-php, .page-template-page-cadastrados-php').on('submit','#form-rg',function(e){
      var verificado = verifica_box($('#rg-verificado-checkbox'));
      $.ajax({
          type: 'POST',
          dataType: 'json',
          url: ajax_bza_inscricoes_object.ajaxurl,
          data: {
              'action': 'salvarg',
              'verificado': verificado,
              'id' : $('#user-id-rg').val()
            },
          success: function(data){
            window.scrollTo(0, 0);

            $('#modal-cadastro').fadeOut(500);
            $('.login_overlay').fadeOut(500,function(){
              $('.login_overlay').remove()
							if ($('body').hasClass('page-template-page-inscritos-php')) {
								user_id=$('#user-id-rg').val();
								post_id=$('#post-id-rg').val();
								carrega_inscricao(post_id,user_id,nome);
							}
							else {
								carrega_user(id,nome)
							}
            });
          }
      });
      e.preventDefault();
    });

    // marca candidato como finalista
    $('.page-template-page-proj-finalistas-php, .page-template-page-inscritos-php, .page-template-page-finalistas-jur ').on('click','.seleciona-candidato', function(e){
			console.log('teste');
      var valor = verifica_box($(this));
      var elemento = $(this);
      $.ajax({
          type: 'POST',
          dataType: 'json',
          url: ajax_bza_inscricoes_object.ajaxurl,
          data: {
              'action': 'marcafinalista',
              'id': $(this).attr('data-id'),
              'valor': valor
            },
          success: function(data){
            console.log(data)
						if ($("body").hasClass('page-template-page-proj-finalistas-php')) {
							location.reload();
						}
            // if (data!=true) {
            //   $(elemento).attr('checked', false); // Unchecks it
            // }
            // console.log(data)

          }
      });

    });
    $('.page-template-page-finalistas-php, .page-template-page-proj-finalistas-php, .page-template-page-finalistas-jur ').on('click', '.inscricao-finalista', function(e){
      $('.candidatos').addClass('desativado');
      $('body').prepend('<div class="login_overlay"></div>');
      $('.login_overlay').fadeIn(500);
      $('#user-loading').fadeIn(500);
      user_id=$(this).attr('data-user-id');
			post_id=$(this).attr('data-id');
      $.ajax({
          type: 'POST',
          dataType: 'json',
          url: ajax_bza_inscricoes_object.ajaxurl,
          data: {
						'action': 'pegainscricao',
						'user_id': user_id,
						'post_id': post_id
            },
          success: function(data){
            window.scrollTo(0, 0);
						console.log(data);
            $('#links-user #cadastro').html('<div>'+data['perfil_completo']+'</div>');
            $('#links-user #cadastro').append('<div>'+data['rg_verificado']+'</div>');
            if (data['modal_inscricao']) {
              $('#modal-inscricao').html('<a id="fechar" href="#">X</a>'+data['modal_inscricao']);
            }
            else{
              $('#modal-inscricao').html('<a id="fechar" href="#">X</a><div>O candidato não inscreveu nenhum projeto</div>');
            }
            $('.candidatos').removeClass('desativado');
            $('#user-loading').fadeOut(500);
            $('#modal-inscricao').fadeIn();
            // $('#links-user').fadeIn();
            $('.page-template-page-finalistas-php, .page-template-page-proj-finalistas-php, .page-template-page-finalistas-jur ').on('click', '#fechar', function(e){
              $('#modal-inscricao').fadeOut(500);
              $('.login_overlay').fadeOut(500,function(){
                $('.login_overlay').remove()
              });
              e.preventDefault();
            });
          }
      });
      e.preventDefault();
    });

    $('.page-template-page-finalistas-php, .page-template-page-proj-finalistas-php, .page-template-page-finalistas-jur ').on('click','.cadastro-finalista', function(e){
			console.log('cadastro');
			$('.candidatos').addClass('desativado');
      $('body').prepend('<div class="login_overlay"></div>');
      $('.login_overlay').fadeIn(500);
      $('#user-loading').fadeIn(500);
      id=$(this).attr('data-id');
      $.ajax({
          type: 'POST',
          dataType: 'json',
          url: ajax_bza_inscricoes_object.ajaxurl,
          data: {
              'action': 'pegauser', //calls wp_ajax_nopriv_ajaxlogin
              'id': id
            },
          success: function(data){
            window.scrollTo(0, 0);

            $('#links-user #cadastro').html('<div>'+data['perfil_completo']+'</div>');
            $('#links-user #cadastro').append('<div>'+data['rg_verificado']+'</div>');
            $('#modal-cadastro').html('<a id="fechar" href="#">X</a>'+data['modal_cadastro']+'<div>'+data['perfil_completo']+'</div>'+'<div>'+data['rg_verificado']+'</div>');
            $('.candidatos').removeClass('desativado');
            $('#user-loading').fadeOut(500);
            $('#modal-cadastro').fadeIn();
            // $('#links-user').fadeIn();
            $('.page-template-page-finalistas-php, .page-template-page-proj-finalistas-php, .page-template-page-finalistas-jur ').on('click', '#fechar', function(e){
              $('#modal-cadastro').fadeOut(500);
              $('.login_overlay').fadeOut(500,function(){
                $('.login_overlay').remove()
              });
              e.preventDefault();
            });
          }
      });
      e.preventDefault();
    });
    //
    // $('.page-template-page-inscritos-php #uf, .page-template-page-cadastrados-php #uf').on('change', function(e){
    //   $('.candidato').remove();
    //   $('#dados-user').html(' <h3 id="nome-user">Escolha um usuário para visualizar</h3><div id="links-user"><div id="cadastro">Clique em um dos úsuários da lista para carregar suas informações.</div><div id="inscricao"></div></div><div id="user-loading"></div>')
    //   var elemento = $(this);
    //   nome = elemento.attr('name');
    //   valor = elemento.val();
    //   document.location.href = '/inscritos/?estado='+valor;
    //   if ($('body').hasClass('page-template-page-cadastrados-php')) {
    //     page='cadastrados';
    //   }
    //   else{
    //     page='inscritos';
    //   }
    //   var metas={
    //     'estado' : valor,
    //   }
    //   console.log(metas);
    //
    //   $.ajax({
    //       type: 'POST',
    //       dataType: 'json',
    //       url: ajax_bza_inscricoes_object.ajaxurl,
    //       data: {
    //           'action': 'queryuser',
    //           'metas': metas,
    //           'page': page
    //         },
    //       success: function(data){
    //         console.log(data);
    //         $('.candidatos').append(data['html'])
    //       }
    //     });
    //   });



});
