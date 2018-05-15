<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package coletivo
 */
?>
    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="footer-logos">
            <div class="container">
            <hr>
                <div class="row logos">
                    <div class="col-md-2">
                        <h3>&nbsp;</h3>
                        <br />
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_rouanet.png" style="width: 80px;">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_proacsp.png" style="width: 120px;">
                    </div>
                    <div class="col-md-2">
                        <h3>PATROCÍNIO</h3>
                        <br />
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_leroy-60.png" style="width: 160px;margin-top:10px;">
                    </div>

                    <div class="col-md-4">
                        <h3>APOIO DE MÍDIA<br>&nbsp;</h3>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_archdaily.png" style="width: 80px; float: left;">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_archie.png" style="width: 80px; float: left;">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_archyouw.png" style="width: 80px; float: left;">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_arco.png" style="width: 80px; float: left;">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_artebra.png" style="width: 80px; float: left;">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_coletiva.png" style="width: 80px; float: left;">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_cult.png" style="width: 80px; float: left;">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_culturafm.png" style="width: 80px; float: left;">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_elemidia.png" style="width: 80px; float: left;">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_folha.png" style="width: 80px; float: left;">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_piaui.png" style="width: 80px; float: left;">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_trip.png" style="width: 80px; float: left;">
                    </div>
                    <div class="col-md-2">
                        <h3>IDEALIZAÇÃO E<br> COORDENAÇÃO</h3>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_tomie_peq.png" style="width: 160px;">
                    </div>
                     <div class="col-md-2">
                        <h3>REALIZAÇÃO</h3>
                        <br />
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_govsp.png" style="width: 160px;">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_paitoan_logo_E.png" style="width: 140px;">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h4 style="margin-left:69px;">
                        <a href="http://institutotomieohtake.org.br/" target="_blank">
                            Instituto Tomie Ohtake
                        </a><br>
                            Av. Brigadeiro Faria Lima, 201<br>
                            Pinheiros - São Paulo - SP<br>
                            CEP 05426-100
                        </h4>
                    </div>
                    <div class="col-md-2 col-lg-offset-4">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ito_index_logo2.png" class="img-responsive">
                    </div>
                </div>
                <hr>
            </div>
        </div>

        <?php $coletivo_btt_disable = get_theme_mod('coletivo_btt_disable'); ?>
        <div class="site-info">
            <div class="container">
                <?php
                /**
                 * hooked coletivo_footer_site_info
                 * @see coletivo_footer_site_info
                 */
                do_action('coletivo_footer_site_info');
                ?>
            </div>
        </div>
        <!-- .site-info -->
    </footer><!-- #colophon -->
<?php
/**
 * Hooked: coletivo_site_footer
 *
 * @see coletivo_site_footer
 */
do_action( 'coletivo_site_end' );
?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
