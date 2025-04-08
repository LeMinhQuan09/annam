<?php

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

$acf_fc_layout = $args['acf_fc_layout'] ?? '';

$fc_form_title          = $args['fc_form_title'] ?? '';
$fc_form_desc           = $args['fc_form_desc'] ?? '';
$fc_form                = $args['fc_form'] ?? false;
$fc_title_faq           = $args['fc_title_faq'] ?? '';
$fc_html_desc           = $args['fc_html_desc'] ?? '';
$fc_button_link         = $args['fc_button_link'] ?? '';
$fc_button_name         = $args['fc_button_name'] ?? '';
$fc_css_class           = ! empty( $args['fc_css_class'] ) ? ' ' . Helper::esc_attr_strip_tags( $args['fc_css_class'] ) : '';
ob_start(); ?>
<section class="section home-contact<?= $fc_css_class ?>">
    <div class="container">
        <div class="form-contact">
            <?php if ( $fc_form_title ) { echo '<p class="heading">' . $fc_form_title . '</p>'; } ?>
            <?php if ( $fc_form_desc ) { echo '<div class="form-desc">' . $fc_form_desc . '</div>'; } ?>
            <?php if ( $fc_form ) {
                $form = \WPCF7_ContactForm::get_instance( $fc_form );
                if ( $form ) {
                    echo do_shortcode( $form->shortcode() );
                }
            } ?>
        </div>
        <div class="home-faq">
            <?php if ( $fc_title_faq ) { echo '<h2 class="heading">' . $fc_title_faq . '</h2>'; } ?>
            <?php if ( $fc_html_desc ) { echo '<div class="html-desc">' . $fc_html_desc . '</div>'; } ?>
            <?php if($fc_button_link){
                echo Helper::ACF_Link_Wrap($fc_button_name, $fc_button_link, 'button-link' );
            } ?>
        </div>
    </div>
</section>
<?php
echo ob_get_clean(); // WPCS: XSS ok.
