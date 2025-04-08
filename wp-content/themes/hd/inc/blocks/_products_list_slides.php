<?php

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

$fc_subtitle    = $args['fc_subtitle'] ?? '';
$fc_title       = $args['fc_title'] ?? '';
$fc_product_cat = $args['fc_product_cat'] ?? false;
$fc_tab_sub = $args['fc_tab_sub'] ?? false;
$fc_sl_tax = $args['fc_sl_product'] ?? false;
$fc_navigation  = $args['fc_navigation'] ?? true;
$fc_pagination  = $args['fc_pagination'] ?? true;
$fc_autoplay    = $args['fc_autoplay'] ?? true;
$fc_max_number  = $args['fc_max_number'] ?? 8;
$fc_button_link = $args['fc_button_link'] ?? '';
$fc_css_class   = ! empty( $args['fc_css_class'] ) ? ' ' . Helper::esc_attr_strip_tags( $args['fc_css_class'] ) : '';

wc_set_loop_prop( 'name', 'home_products_list' ); ?>
<section class="section grid-section products-section<?= $fc_css_class ?>">
	<div class="container">
        <div class="section-title flex">
		<?php
		if ( $fc_title ) { echo '<h2 class="heading-title">' . $fc_title . '</h2>'; }
		$fc_tax_id = $fc_product_cat->term_id;
		$fc_tax_link = get_term_link($fc_tax_id);
		$fc_terms = get_term_children($fc_tax_id, 'product_cat');
        if($fc_tab_sub == 1){
            echo '<ul class="list-tax-child flex">';
			foreach ( $fc_sl_tax as $child ) {
				echo '<li><a class="relative" href="' . get_term_link( $child->term_id ) . '">' . $child->name . '</a></li>';
			}
			echo '</ul>';
            // print_r($fc_sl_tax);
        } elseif($fc_terms) {
            echo '<ul class="list-tax-child flex">';
            foreach ( $fc_terms as $child ) {
                $term = get_term_by( 'id', $child, 'product_cat' );
                echo '<li><a class="relative" href="' . get_term_link( $child, 'product_cat' ) . '">' . $term->name . '</a></li>';
            }
            echo '</ul>';
        }
		 ?>
		</div>
        <?php if ($fc_product_cat) {
            $taxonomy = $fc_product_cat->term_id;
            // $taxonomy = [];
            // foreach ($fc_product_cat as $tax) {
            //     $taxonomy[] = $tax->term_id;
            // }
            $query_args = [
                'post_type' => 'product',
                'post_status' => 'publish',
                'orderby' => ['date' => 'DESC'],
                'tax_query' => [
                    [
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $taxonomy,
                        'operator' => 'IN',
                    ],
                ],
                'posts_per_page' => $fc_max_number,
            ];
            $product_query = new WP_Query($query_args); ?>
            <div class="swiper-container carousel-product-list grid-product-list">
                <?php
                $swiper_class = '';
                $_data = [
                    'loop' => false,
                    'mobile' => [
                        'spaceBetween'   => 20,
                        'slidesPerView'  => 2,
                        'slidesPerGroup' => 1,
                    ],
                    'tablet' => [
                        'spaceBetween'   => 20,
                        'slidesPerView'  => 4,
                        'slidesPerGroup' => 1,
                    ],
                    'desktop' => [
                        'spaceBetween'   => 30,
                        'slidesPerView'  => 5,
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