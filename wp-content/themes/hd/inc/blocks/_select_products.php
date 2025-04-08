<?php

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

$fc_heading = $args['fc_heading'] ?? '';
$title_flash_sale = $args['title_flash_sale'] ?? false;
$fc_sl_products = $args['sl_products_sale'] ?? false;
$fc_navigation  = $args['fc_navigation'] ?? true;
$fc_pagination  = $args['fc_pagination'] ?? true;
$fc_autoplay    = $args['fc_autoplay'] ?? true;
$columns_desktop    = $args['columns_desktop'] ?? '';
$columns_tablet    = $args['columns_tablet'] ?? '';
$columns_mobile    = $args['columns_mobile'] ?? '';
$fc_autoplay    = $args['fc_autoplay'] ?? true;
$fc_css_class   = ! empty( $args['css_class'] ) ? ' ' . Helper::esc_attr_strip_tags( $args['css_class'] ) : '';

wc_set_loop_prop( 'name', 'home_products_list' );
$date_end = get_field('sl_date_end','option');
$time_end = get_field('sl_time_end','option'); ?>
<section class="section grid-section select-products-section <?php if($title_flash_sale == 1){ echo 'flash-sale-section'; } ?><?= $fc_css_class ?>">
	<div class="container">
        <div class="section-title flex">
            <?php if($title_flash_sale == 1){ ?>
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
                <?php ?>
            <?php } 
            if ( $fc_heading ) { echo '<h2 class="heading-title">' . $fc_heading . '</h2>'; } ?>
        </div>
		<?php
        if ($fc_sl_products) {
            $taxonomy = [];
            $query_args = [
                'post_type' => 'product',
                'post_status' => 'publish',
                'post__in' => $fc_sl_products,
                'orderby' => ['date' => 'DESC'],
            ];
            $product_query = new WP_Query($query_args); ?>
            <div class="swiper-container products product-list grid-product-list">
                <?php
                $swiper_class = '';
                $_data = [
                    'loop' => false,
                    'mobile' => [
                        'spaceBetween'   => 10,
                        'slidesPerView'  => $columns_mobile,
                        'slidesPerGroup' => 1,
                    ],
                    'tablet' => [
                        'spaceBetween'   => 20,
                        'slidesPerView'  => $columns_tablet,
                        'slidesPerGroup' => 1,
                    ],
                    'desktop' => [
                        'spaceBetween'   => 20,
                        'slidesPerView'  => $columns_desktop,
                        'slidesPerGroup' => 2,
                    ]
                ];
                if ( $fc_navigation ) {
                    $_data['navigation'] = Helper::toBool( $fc_navigation );
                }

                if ( $fc_pagination ) {
                    $_data['pagination'] = 'bullets';
                    $swiper_class        .= ' pagination-bullets';
                }

                if ( $fc_autoplay ) {
                    $_data['autoplay'] = Helper::toBool( $fc_autoplay );
                }
                // swiper_data
                try {
                    $swiper_data = json_encode( $_data, JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE );
                } catch ( JsonException $e ) {}
                if ( $swiper_data ) : ?>
                <div class="w-swiper swiper">
                    <div class="swiper-wrapper<?= $swiper_class ?>" data-options='<?= $swiper_data ?>'>
                        <?php 
                        if ($product_query->have_posts()) {
                            while ($product_query->have_posts()) {
                                $product_query->the_post(); ?>
                                <div class="swiper-slide">
                                    <?php wc_get_template_part( 'content', 'product' ); ?>
                                </div>
                            <?php }
                            wp_reset_postdata();
                        } else {
                            echo 'No products found !';
                        }
                        ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php } ?>
	</div>
</section>