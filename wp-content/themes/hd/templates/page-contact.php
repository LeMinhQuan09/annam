<?php
/**
 * The template for displaying 'Contact'
 * Template Name: Contact
 * Template Post Type: page
 */

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

// header
get_header( 'contact' );

if ( have_posts() ) {
	the_post();
}

if ( post_password_required() ) :
	echo get_the_password_form(); // WPCS: XSS ok.

	return;
endif;

// template-parts/parts/page-title.php
the_page_title_theme();

$ID = $post->ID ?? false;
try {
	$ACF = Helper::acfFields( $ID ) ?? '';
} catch ( JsonException $e ) {}

$alternative_title = $ACF->alternative_title ?? '';
$fc_form  = $ACF->form_contact ?? false;
$iframe_map = $ACF->iframe_map ?? '';
?>
<section class="section singular page page-contact relative">
	<div class="container">
        <article <?=Helper::microdata( 'article' )?>>
            <div class="section-title">
                <h1 class="heading-title"><?php the_title(); ?></h1>
            </div>
            <div class="main-contact">
                <div class="wrapper">
                    <div class="iframe-map">
                        <?php echo $iframe_map; ?>
                    </div>
                    <div class="contact-form">
                        <?php if ( $fc_form ) { ?>
                            <p class="title">Liên hệ với chúng tôi</p>
                            <?php $form = \WPCF7_ContactForm::get_instance( $fc_form );
                            if ( $form ) {
                                echo do_shortcode( $form->shortcode() );
                            }
                        } ?>
                    </div>
                </div>
                
            </div>
        </article>
	</div>
</section>
<?php

// footer
get_footer( 'contact' );
