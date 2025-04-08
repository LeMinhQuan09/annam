<?php
/**
 * Single Product Image
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 */

use Cores\Helper;

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( '_wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns = apply_filters('woocommerce_product_thumbnails_columns', 6);
$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();
$wrapper_classes = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	[
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
		'swiper-product-gallery',
	]
);

$outstanding_features = Helper::get_field( 'outstanding_features', $product->get_id() );

// Lấy URL YouTube từ ACF
$youtube_url = get_field('link_video', $product->get_id());
if ($youtube_url) {
    // Lấy ID video từ URL YouTube
    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $youtube_url, $matches);
    $youtube_id = $matches[1];
    $youtube_embed_url = 'https://www.youtube.com/embed/' . $youtube_id . '?autoplay=1&mute=1';
    $youtube_thumbnail_url = 'https://img.youtube.com/vi/' . $youtube_id . '/hqdefault.jpg';
}
?>

<div class="woocommerce-product-gallery-wrapper">
    <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
        <div class="woocommerce-product-gallery__wrapper wpg__images">
            <div class="swiper swiper-images">
                <div class="swiper-wrapper">
					<?php
	                if ($youtube_url) { ?>
					<div class="swiper-slide swiper-images-video">
						<iframe width="100%" height="425" src="<?php echo esc_url($youtube_embed_url); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
						<!-- <span data-rel="lightbox" class="image-popup" data-src="<?php //echo $youtube_url; ?>" data-glyph=""></span> -->
					</div>
					<div class="swiper-slide swiper-images-first custom-swiper-first">
		                <?php
		                if ( $product->get_image_id() ) :
			                $html = _wc_get_gallery_image_html( $post_thumbnail_id, true, true, true );
							print_r($html);
		                else :
			                $html = '<div class="woocommerce-product-gallery__image--placeholder">';
			                $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			                $html .= '</div>';
		                endif;

		                echo apply_filters( 'woocommerce_single_product_image_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
		                ?>
                    </div>
	                <?php } else { ?>
						<div class="swiper-slide swiper-images-first">
		                <?php
		                if ( $product->get_image_id() ) :
			                $html = _wc_get_gallery_image_html( $post_thumbnail_id, true, true, true );
							//print_r($html);
		                else :
			                $html = '<div class="woocommerce-product-gallery__image--placeholder">';
			                $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			                $html .= '</div>';
		                endif;

		                echo apply_filters( 'woocommerce_single_product_image_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
		                ?>
                    </div>
					<?php } ?>
                    
	                <?php
	                if ( $attachment_ids && $product->get_image_id() ) {
		                foreach ( $attachment_ids as $attachment_id ) {
			                echo '<div class="swiper-slide">';
			                echo _wc_get_gallery_image_html( $attachment_id, true, true, true );
			                echo '</div>';
		                }
	                }
	                ?>
                </div>
                <div class="swiper-controls">
                    <div class="swiper-button swiper-button-prev" data-glyph=""></div>
                    <div class="swiper-button swiper-button-next" data-glyph=""></div>
                </div>
            </div>
        </div>
	    <?php if ( $attachment_ids ) : ?>
        <div class="woocommerce-product-gallery__wrapper wpg__thumbs">
            <div class="swiper swiper-thumbs">
                <div class="swiper-wrapper">
					<?php if($youtube_url){ ?>
						<div class="swiper-slide swiper-thumbs-first">
							<div data-thumb="<?php echo esc_url($youtube_thumbnail_url) ?>" data-thumb-alt="" class="woocommerce-product-gallery__image wpg__thumb thumb_video cover">
								<a class="res ar[1-1]" href="<?php echo esc_url($youtube_thumbnail_url); ?>">
									<img width="100" height="100" src="<?php echo esc_url($youtube_thumbnail_url); ?>" class="" alt="" title="" data-caption="" data-src="<?php echo esc_url($youtube_thumbnail_url); ?>" data-large_image="<?php echo esc_url($youtube_thumbnail_url); ?>" data-large_image_width="400" data-large_image_height="400" decoding="async" loading="lazy" srcset="<?php echo esc_url($youtube_thumbnail_url); ?> 100w, <?php echo esc_url($youtube_thumbnail_url); ?> 400w" sizes="(max-width: 100px) 100vw, 100px">
								</a>
								<span data-rel="lightbox" class="image-popup" data-src="<?php echo $youtube_url; ?>" data-glyph=""></span>
							</div>
						</div>
						<div class="swiper-slide">
							<?php
							if ( $product->get_image_id() ) :
								$html = _wc_get_gallery_image_html( $post_thumbnail_id, false, true );
							else :
								$html = '<div class="woocommerce-product-gallery__image--placeholder">';
								$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'wpa-gallery' ) );
								$html .= '</div>';
							endif;
							echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_ids ); ?>
						</div>
					<?php } else { ?>
					<div class="swiper-slide swiper-thumbs-first">
						<?php
							if ( $product->get_image_id() ) :
								$html = _wc_get_gallery_image_html( $post_thumbnail_id, false, true );
							else :
								$html = '<div class="woocommerce-product-gallery__image--placeholder">';
								$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'wpa-gallery' ) );
								$html .= '</div>';
							endif;
							echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_ids ); ?>
					</div>
					<?php } ?>
                   
					
		            <?php do_action( 'woocommerce_product_thumbnails' ); ?>

                </div>
                <div class="swiper-controls">
                    <div class="swiper-button swiper-button-prev" data-glyph=""></div>
                    <div class="swiper-button swiper-button-next" data-glyph=""></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
