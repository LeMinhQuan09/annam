<?php

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

$breadcrumb_class = '';
$title            = '';
$breadcrumb_bg    = Helper::getThemeMod( 'breadcrumb_bg_setting' );
$banner_default = get_field('banner_page_default','option');
if ( $breadcrumb_bg ) {
	$breadcrumb_class = ' has-background';
}

$object = get_queried_object();
if ( $object && ! empty( $object->ID ) ) {

    // breadcrumb of page
	$image_for_banner = Helper::get_field( 'image_for_banner', $object->ID );
	if ( $image_for_banner ) {
		$breadcrumb_class = ' has-background';
		$breadcrumb_bg    = $image_for_banner;
	}

    // title
	$title = Helper::get_field( 'alternative_title', $object->ID ) ?: ( $object->post_title ?? '' );
}

if ( is_search() ) {
	$title = sprintf( __( 'Search Results for: %s', TEXT_DOMAIN ), get_search_query() );
}

?>
<section class="section section-title-top">
	<div class="container">
		<?php 
			if ( method_exists( Helper::class, 'breadcrumbs' ) ) :
				Helper::breadcrumbs();
			elseif ( function_exists( 'woocommerce_breadcrumb' ) ) :
				woocommerce_breadcrumb();
			elseif ( function_exists( 'rank_math_the_breadcrumbs' ) ) :
				rank_math_the_breadcrumbs();
			endif;
		?>
	</div>
	
</section>
