<?php
/**
 * The template for displaying 'Contact'
 * Template Name: Khuyến Mãi
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
$date_end = get_field('sl_date_end','option');
$time_end = get_field('sl_time_end','option');
$alternative_title = $ACF->alternative_title ?? '';
?>
<section class="section singular page page-promotion relative">
	<div class="container">
        <div class="grid-posts">
            <?php echo '<div class="sidebar-col">';
                dynamic_sidebar( 'post-archive-sidebar' );
            echo '</div>'; ?>
            <div class="content-col">
                <!-- FlashSale -->
                <?php 
                    $argsProducts = array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        'meta_query' => array(
                            array(
                                'key'     => 'sl_flash_sale',
                                'value'   => '1',
                                'compare' => '='
                            ),
                        ),
                    );
                    $product_query = new WP_Query($argsProducts);
                    if ($product_query->have_posts()) { ?>
                    <section class="section grid-section select-products-section flash-sale-section bg-white">
                        <div class="container">
                            <div class="section-title flex">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img-flashsale.png" alt="">
                                <div class="countdown" data-end-date="<?php echo esc_attr($date_end); ?>"
                                data-end-time="<?php echo esc_attr($time_end); ?>">
                                    <div class="countdown-item">
                                        <span class="day time"></span>
                                        <span class="prefix">ngày</span> 
                                    </div>
                                    <div class="countdown-item">
                                        <span class="hour time"></span>
                                        <span class="prefix">giờ</span>
                                    </div>
                                    <div class="countdown-item">
                                        <span class="minute time"></span>
                                        <span class="prefix">phút</span>
                                    </div>
                                    <div class="countdown-item">
                                        <span class="second time"></span>
                                        <span class="prefix">giây</span>
                                    </div>
                                </div>
                            </div>
                            <div class="products product-list grid-product-list">
                                <?php 
                                while ($product_query->have_posts()) {
                                    $product_query->the_post(); ?>
                                    <div class="item">
                                        <?php wc_get_template_part( 'content', 'product' ); ?>
                                    </div>
                                <?php }
                                wp_reset_postdata(); ?>
                            </div>
                        </div>
                    </section>
                <?php } ?>
            </div>
        </div>
	</div>
</section>
<?php

// footer
get_footer();