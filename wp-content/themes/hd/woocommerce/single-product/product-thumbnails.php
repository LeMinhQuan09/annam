<?php
/**
 * Single Product Thumbnails
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( '_wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$attachment_ids = $product->get_gallery_image_ids();
// Lấy URL YouTube từ ACF
$youtube_url = get_field('link_video', $product->get_id());
if ($youtube_url) {
    // Lấy ID video từ URL YouTube
    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $youtube_url, $matches);
    $youtube_id = $matches[1];
    $youtube_thumbnail_url = 'https://img.youtube.com/vi/' . $youtube_id . '/hqdefault.jpg'; // Link đến thumbnail của video YouTube
    // Hiển thị thumbnail của video YouTube đầu tiên
    //echo '<div class="swiper-slide">'; ?>
	<!-- <div data-thumb="<?php //echo esc_url($youtube_thumbnail_url) ?>" data-thumb-alt="" class="woocommerce-product-gallery__image wpg__thumb thumb_video cover">
		<a class="res ar[1-1]" href="<?php //echo esc_url($youtube_thumbnail_url) ?>">
			<img width="100" height="100" src="<?php //echo esc_url($youtube_thumbnail_url); ?>" class="" alt="" title="" data-caption="" data-src="<?php //echo esc_url($youtube_thumbnail_url); ?>" data-large_image="<?php //echo esc_url($youtube_thumbnail_url); ?>" data-large_image_width="400" data-large_image_height="400" decoding="async" loading="lazy" srcset="<?php //echo esc_url($youtube_thumbnail_url); ?> 100w, <?php //echo esc_url($youtube_thumbnail_url); ?> 400w" sizes="(max-width: 100px) 100vw, 100px">
		</a>
	</div> -->
    <?php
    //echo '</div>';
}

if ( $attachment_ids && $product->get_image_id() ) {
	foreach ( $attachment_ids as $attachment_id ) {
		echo '<div class="swiper-slide">';
		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', _wc_get_gallery_image_html( $attachment_id, false, true ), $attachment_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
		echo '</div>';
	}
}
