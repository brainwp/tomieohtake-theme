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
            $('#links-user #cadastro').append('<div><button class="button button-primary">Ver cadastro</button></div>');
            if (data['modal_inscricao']) {
              $('#links-user #inscricao').html('<div><b>Inscrição - </b>  Completa</div>');
              // $('#links-user #inscricao').html('<div>'+data['inscricao_completa']+'</div>');
              $('#links-user #inscricao').append('<div><button class="acf-button button button-primary button-large">Ver Inscrição</button></div>');
            }
            else{
              $('#links-user #inscricao').html('<div>O candidato não fez uma inscrição</div>');
            }
            $('#user-loading').fadeOut(500);
            $('.candidatos').removeClass('desativado');1
            $('#modal-cadastro').html('<a id="fechar" href="#">X</a>'+data['modal_cadastro']);
            $('#modal-inscricao').html('<a id="fechar" href="#">X</a>'+data['modal_inscricao']);
            $('#links-user').fadeIn();


          }
      });

    }
    // ajax da página de inscritos
    $('.page-template-page-inscritos-php .user_ajax, .page-template-page-cadastrados-php .user_ajax').on('click', function(e){
      // alert($(this).attr('data-id'));
      id=$(this).attr('data-id');
      nome=$(this).text();

      carrega_user(id,nome)
      e.preventDefault();
    });

    // Clique no cadastro

    $('.page-template-page-inscritos-php #links-user #cadastro, .page-template-page-cadastrados-php #links-user #cadastro').on('click', function(e){
      $('body').prepend('<div style="display:none" class="login_overlay"></div>');
      $('.login_overlay').fadeIn(500);

      $('#modal-cadastro').fadeIn();
      e.preventDefault();
      $('.page-template-page-inscritos-php #modal-cadastro #fechar, .page-template-page-cadastrados-php #modal-cadastro #fechar').on('click', function(e){
        $('#modal-cadastro').fadeOut(500);
        $('.login_overlay').fadeOut(500,function(){
          $('.login_overlay').remove()
        });
        e.preventDefault();
      });
    });


    // Clique na inscricao

    $('.page-template-page-inscritos-php #links-user #inscricao, .page-template-page-cadastrados-php #links-user #inscricao').on('click', function(e){
      $('body').prepend('<div style="display:none" class="login_overlay"></div>');
      $('.login_overlay').fadeIn(500);

      $('#modal-inscricao').fadeIn();
      e.preventDefault();
      $('.page-template-page-inscritos-php #modal-inscricao #fechar .page-template-page-cadastrados-php #modal-inscricao #fechar').on('click', function(e){
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
      // alert('teste');
      var verificado = verifica_box($('#rg-verificado-checkbox'));
      // if ($('#rg-verificado-checkbox').is(":checked")){
      //   var verificado = 1;
      // }
      // else{
      //   var verificado = 0;
      // }
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
            $('#modal-cadastro').fadeOut(500);
            $('.login_overlay').fadeOut(500,function(){
              $('.login_overlay').remove()
              carrega_user(id,nome )
            });
          }
      });
      e.preventDefault();
    });

    // marca candidato como finalista
    $('.page-template-page-inscritos-php .seleciona-candidato').on('click', function(e){
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
            if (data!=true) {
              $(elemento).attr('checked', false); // Unchecks it
              alert(data)
            }
          }
      });
    });

});
