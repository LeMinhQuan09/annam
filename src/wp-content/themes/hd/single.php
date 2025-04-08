<?php
/**
 * The Template for displaying all single posts.
 *
 * @package HD
 */

\defined( 'ABSPATH' ) || die;

// header
get_header( 'single' );

if ( have_posts() ) {
	the_post();
}

if ( post_password_required() ) :
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
endif;

/**
 * Hook: single_before_section.
 *
 * @see __hd_single_title - 10
 */
do_action( 'single_before_section' );
?>
<section class="section singular post">
        <?php // template-parts/parts/archive-title.php
        the_archive_title_theme(); ?>
	<div class="container">
                <div class="grid-posts">
                <?php

                /**
                 * Hook: single_content
                 *
                 * @see __hd_single_share - 10
                 * @see __hd_single_wrapper_open - 12
                 * @see __hd_single_header - 14
                 * @see __hd_single_content - 16
                 * @see __hd_single_wrapper_close - 18
                 */
                do_action( 'single_content' );
                ?>
        </div>
	</div>
</section>
<?php

/**
 * Hook: single_after_section.
 */
do_action( 'single_after_section' );

// footer
get_footer( 'single' );
