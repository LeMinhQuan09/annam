<?php

\defined( 'ABSPATH' ) || die;

use Cores\Helper;

/**
 * Displays navigation mobile
 *
 * @package WordPress
 */

$txt_logo = Helper::getOption( 'blogname' );
$img_logo = Helper::getThemeMod( 'alt_logo' );

if ( ! $img_logo ) :
	$html = sprintf( '<a href="%1$s" class="mobile-logo-link" rel="home" aria-label="%2$s">%3$s</a>', Helper::home(), esc_attr( $txt_logo ), $txt_logo );
else :
	$image = '<img src="' . $img_logo . '" alt="logo">';
	$html  = sprintf( '<a href="%1$s" class="mobile-logo-link" rel="home">%2$s</a>', Helper::home(), $image );
endif;

?>
<div class="off-canvas position-left white-color" id="offCanvasMenu" data-off-canvas data-content-scroll="false">
    <div class="menu-heading-outer">
        <button class="menu-lines" aria-label="Close" type="button" data-close>
            <span class="line line-1"></span>
            <span class="line line-2"></span>
        </button>
	    <!-- <div class="title-bar-title"><?php //echo $html; ?></div> -->
    </div>
    <div class="menu-outer">
        <?php
        // echo Helper::doShortcode( 'inline_search' );
        echo Helper::doShortcode( 'vertical_menu' );
        if (is_active_sidebar('w-language-sidebar')) { ?>
            <div class="bottom-outer"><?php dynamic_sidebar('w-language-sidebar'); ?></div>
        <?php } ?>
    </div>
</div>
