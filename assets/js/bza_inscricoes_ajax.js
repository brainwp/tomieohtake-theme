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
        $('form#login-user p.status').show().text(ajax_login_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
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


});
