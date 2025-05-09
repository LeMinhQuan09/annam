<?php
/**
 * Header hooks
 *
 * @author HD
 */

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

// -----------------------------------------------
// wp_head
// -----------------------------------------------

if ( ! function_exists( '__wp_head' ) ) {
	add_action( 'wp_head', '__wp_head', 1 );

	function __wp_head(): void {

		//$meta_viewport = '<meta name="viewport" content="user-scalable=yes, width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=1.0" />';
		$meta_viewport = '<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />';
		echo apply_filters( 'hd_meta_viewport', $meta_viewport );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		// Add a ping-back url auto-discovery header for singularly identifiable articles.
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s" />', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}

		// Theme color
		$theme_color = Helper::getThemeMod( 'theme_color_setting' );
		if ( $theme_color ) {
			echo '<meta name="theme-color" content="' . $theme_color . '" />';
		}

		// Fb
		$fb_appid = Helper::getThemeMod( 'social_fb_setting' );
		if ( $fb_appid ) {
			echo '<meta property="fb:app_id" content="' . $fb_appid . '" />';
		}
	}
}

// -----------------------------------------------

if ( ! function_exists( '__external_fonts' ) ) {
	add_action( 'wp_head', '__external_fonts', 10 );

	function __external_fonts(): void {
    ?>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600..800;1,600..800&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
		
    <?php
	}
}

// -----------------------------------------------
// hd_before_header
// -----------------------------------------------

if ( ! function_exists( '__hd_skip_to_content_link' ) ) {
	add_action( 'hd_before_header', '__hd_skip_to_content_link', 2 );

	/**
	 * Add skip to a content link before the header.
	 *
	 * @return void
	 */
	function __hd_skip_to_content_link(): void {
		printf(
			'<a class="screen-reader-text skip-link" href="#site-content" title="%1$s">%2$s</a>',
			esc_attr__( 'Skip to content', TEXT_DOMAIN ),
			esc_html__( 'Skip to content', TEXT_DOMAIN )
		);
	}
}

// -----------------------------------------------

if ( ! function_exists( '__hd_off_canvas_menu' ) ) {
	add_action( 'hd_before_header', '__hd_off_canvas_menu', 10 );

	/**
	 * Position canvas menu
	 *
	 * @return void
	 */
	function __hd_off_canvas_menu(): void {

		$position = Helper::getThemeMod( 'offcanvas_menu_setting' );
		if ( ! in_array( $position, [ 'left', 'right', 'top', 'bottom' ], false ) ) {
			$position = 'right';
		}

		// Check if OffCanvas_Widget active
		if ( is_active_widget( false, false, 'w-offcanvas', true ) ) {
			get_template_part( 'template-parts/header/off-canvas/' . $position );
		}
	}
}

// -----------------------------------------------
// hd_header
// -----------------------------------------------

if ( ! function_exists( '__hd_construct_header' ) ) {
	add_action( 'hd_header', '__hd_construct_header', 10 );

	function __hd_construct_header(): void {

		/**
		 * @see _hd_top_header - 10
		 * @see _hd_header - 11
		 * @see _hd_bottom_header - 12
		 */
		do_action( 'masthead' );
	}
}

// -----------------------------------------------

if ( ! function_exists( '_hd_top_header' ) ) {
	add_action( 'masthead', '_hd_top_header', 10 );

	function _hd_top_header(): void {
		$top_header_cols      = (int) Helper::getThemeMod( 'top_header_setting' );
		$top_header_container = Helper::getThemeMod( 'top_header_container_setting' );

		if ( $top_header_cols > 0 ) :

			?>
            <div class="top-header" id="top-header">
	        <?php

	        toggle_container( $top_header_container );

	        for ( $i = 1; $i <= $top_header_cols; $i ++ ) :
		        if ( is_active_sidebar( 'hd-top-header-' . $i . '-sidebar' ) ) :
			        echo '<div class="cell cell-' . $i . '">';
			        dynamic_sidebar( 'hd-top-header-' . $i . '-sidebar' );
			        echo '</div>';
		        endif;
	        endfor;

	        echo '</div>';

	        ?>
        </div>
		<?php endif;
	}
}

// -----------------------------------------------

if ( ! function_exists( '_hd_header' ) ) {
	add_action( 'masthead', '_hd_header', 11 );

	function _hd_header(): void {
		$header_cols      = (int) Helper::getThemeMod( 'header_setting' );
		$header_container = Helper::getThemeMod( 'header_container_setting' );

		if ( $header_cols > 0 ) :

			?>
            <div class="inside-header" id="inside-header">
	        <?php

	        toggle_container( $header_container );

	        for ( $i = 1; $i <= $header_cols; $i ++ ) :
		        if ( is_active_sidebar( 'hd-header-' . $i . '-sidebar' ) ) :
			        echo '<div class="cell cell-' . $i . '">';
			        dynamic_sidebar( 'hd-header-' . $i . '-sidebar' );
			        echo '</div>';
		        endif;
	        endfor;

	        echo '</div>';

	        ?>
        </div>
		<?php endif;
	}
}

// -----------------------------------------------

if ( ! function_exists( '_hd_bottom_header' ) ) {
	add_action( 'masthead', '_hd_bottom_header', 12 );

	function _hd_bottom_header(): void {
		$bottom_header_cols      = (int) Helper::getThemeMod( 'bottom_header_setting' );
		$bottom_header_container = Helper::getThemeMod( 'bottom_header_container_setting' );
		$sticky_data = 'data-sticky data-options="marginTop:0;stickyOn:small"';
		if ( ! $bottom_header_cols ) {
			 $sticky_data = 'data-sticky data-options="marginTop:0;stickyOn:small"';
		}
		// if ( $bottom_header_cols > 0 ) :

			?>
            <div class="bottom-header header-content" id="bottom-header" <?=$sticky_data?>>
            <?php

            toggle_container( $bottom_header_container );

            for ( $i = 1; $i <= $bottom_header_cols; $i ++ ) :
	            if ( is_active_sidebar( 'hd-bottom-header-' . $i . '-sidebar' ) ) :
		            echo '<div class="cell cell-' . $i . '">';
		            dynamic_sidebar( 'hd-bottom-header-' . $i . '-sidebar' );
		            echo '</div>';
	            endif;
            endfor;

            echo '</div>';

            ?>
        </div>
		<?php //endif;
	}
}

// -----------------------------------------------
