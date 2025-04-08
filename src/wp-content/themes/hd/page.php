<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package HD
 */

\defined( 'ABSPATH' ) || die;

// header
get_header( 'page' );

if ( have_posts() ) {
	the_post();
}

if ( post_password_required() ) :
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
endif;

/**
 * Hook: page_before_section.
 *
 * @see __hd_page_title - 10
 */
do_action( 'page_before_section' );

?>
<section class="section singular page">
        <?php the_page_title_theme(); ?>
        <div class="page-container">
	<div class="container">
                <div class="page-wrapper section-padding">
                <div class="section-title"><h1 class="heading-title"><?php the_title(); ?></h1></div>
        <?php

        /**
         * Hook: page_content
         *
         * @see __hd_page_header - 10
         * @see __hd_page_content - 12
         */
        do_action( 'page_content' );
        ?>
        </div>
        </div>
	</div>
</section>
<?php

/**
 * Hook: page_after_section.
 */
do_action( 'page_after_section' );

// footer
get_footer( 'page' );
