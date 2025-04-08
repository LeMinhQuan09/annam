<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @see woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
$current_product = get_queried_object();
$id_product = get_queried_object()->ID;
// print_r($id_product);
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
	<div class="main-product-wrapper">
		<div class="main-product">
			<div class="product-details">
				<?php

				/**
				 * Hook: woocommerce_before_single_product_summary.
				 *
				 * @see woocommerce_show_product_sale_flash - 10
				 * @see woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' );
				?>
				<div class="summary entry-summary">
					<?php

					/**
					 * Hook: woocommerce_single_product_summary.
					 *
					 * @see woocommerce_template_single_title - 5
					 * @see woocommerce_template_single_rating - 10
					 * @see woocommerce_template_single_price - 10
					 * @see woocommerce_template_single_excerpt - 20
					 * @see woocommerce_template_single_add_to_cart - 30
					 * @see woocommerce_template_single_meta - 40
					 * @see woocommerce_template_single_sharing - 50
					 * @see WC_Structured_Data::generate_product_data() - 60
					 */
					do_action( 'woocommerce_single_product_summary' );
					echo '<div class="bottom_product-single">';
					dynamic_sidebar( 'bottom-product-single' );
					echo '</div>';
					?>
				</div>
			</div>
			<div class="product-after-summary">
				<div class="container">
					<div class="flex">
						<div class="cell inf-product">
							<div class="widget-title"><span><?php _e( 'Thông tin chi tiết', TEXT_DOMAIN ) ?></span></div>
							<?php
								/**
								 * Hook: woocommerce_after_single_product_summary.
								 *
								 * @see woocommerce_output_product_data_tabs - 10
								 * @see woocommerce_upsell_display - 15
								 * @see woocommerce_output_related_products - 20
								 */
								do_action( 'woocommerce_after_single_product_summary' );
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="section-product-related">
				<?php woocommerce_output_related_products(); ?>
			</div>
		</div>
		<div class="sidebar-product">
			<p class="widget-title"><?php _e( 'Sản phẩm nổi bật', TEXT_DOMAIN ) ?></p>
			<?php 
			$terms = get_the_terms($id_product, 'product_cat');
			$parent_cat_id = false;
				if ($terms && !is_wp_error($terms)) {
					foreach ($terms as $term) {
						$terms_id = $term->term_id;
						if ($term->parent != 0) {
							$parent_cat_id = $term->parent;
							break;
						} else {
							$parent_cat_id = $term->term_id;
							break;
						}
					}
				}
				if ($parent_cat_id) {
					$args = array(
						'post_type' => 'product',
						'posts_per_page' => 8,
						'tax_query' => array(
							array(
								'taxonomy' => 'product_cat',
								'field'    => 'term_id',
								'terms'    => $parent_cat_id,
							),
						),
					);
					$hot_products= new WP_Query($args);
					if ($hot_products->have_posts()) { ?>
						<div class="grid-products">
							<div class="products">
							<?php while ($hot_products->have_posts()) : $hot_products->the_post();
								//wc_get_template_part( 'content', 'product' );
								wc_get_template_part( 'content', 'widget-product' );
							endwhile;
						echo '</ul>';
						echo '</div>';
					}
					wp_reset_postdata();
				}
			?>
		</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
