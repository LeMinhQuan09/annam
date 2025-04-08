<?php

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

$acf_fc_layout = $args['acf_fc_layout'] ?? '';

$fc_title       = $args['fc_title'] ?? '';
$fc_product_cat = $args['fc_product_cat'] ?? false;
$fc_max_number  = $args['fc_max_number'] ?? 8;
$fc_button_name = $args['fc_button_name'] ?? '';
$fc_css_class   = ! empty( $args['fc_css_class'] ) ? ' ' . Helper::esc_attr_strip_tags( $args['fc_css_class'] ) : '';

$query_args = [
	'post_type' => 'product',
	'post_status' => 'publish',
	'orderby' => ['date' => 'DESC'],
	'posts_per_page' => $fc_max_number,
	'tax_query' => [
		[
			'taxonomy'         => 'product_cat',
			'terms'            => $fc_product_cat,
			'field'            => 'term_id',
			'include_children' => true,
			'operator'         => 'IN'
		],
	],
];
//dump($query_args);
$product_query = new WP_Query($query_args);
//dump($product_query);

?>
<section class="section grid-section products-section<?= $fc_css_class ?>">
	<div class="container">
		<div class="section-title flex">
			<?php
			if ( ! empty( $fc_product_cat ) && is_object( $fc_product_cat ) ) {
				$fc_tax_id = $fc_product_cat->term_id;
				$fc_tax_link = get_term_link($fc_tax_id);

				$child_categories = get_term_children($fc_tax_id, 'product_cat');
				$total_count = $fc_product_cat->count;
				// dump($fc_product_cat);
				// dump($total_count);
				// dump($product_query->found_posts);
				// If there are child categories, count the products in those categories
				if ( ! empty($child_categories) ) {
					$args = [
						'taxonomy' => 'product_cat',
						'include' => $child_categories,
						'hide_empty' => true,
					];
					$child_terms = get_terms($args);
					foreach ($child_terms as $child_term) {
						$total_count += $child_term->count; // Add the count of each child category
					}
				}

				//dump($fc_product_cat->count);
				if ( $fc_title ) { echo '<h2 class="heading-title"><a href="'. $fc_tax_link .'" rel="nofollow">' . $fc_title . ' <small>( '. $product_query->found_posts .' sản phẩm )</small></a></h2>'; }
				//print_r($fc_product_cat);
				echo Helper::ACF_Link_Wrap($fc_button_name, $fc_tax_link, 'button-link !lg:show' );
			}
			?>
		</div>
        <div class="grid-products" aria-label="<?php echo Helper::esc_attr_strip_tags( $fc_title ); ?>">
        	<div class="products">
			<?php
			if ($product_query->have_posts()) {
					while ($product_query->have_posts()) {
						$product_query->the_post(); ?>
						<?php wc_get_template_part( 'content', 'product' ); ?>
					<?php }
					wp_reset_postdata();
				}
			?>
			</div>
        </div>
		<?php if($fc_button_name) : ?>
			<div class="hb_button">
				<?php echo Helper::ACF_Link_Wrap($fc_button_name, $fc_tax_link, 'button-link !lg:hidden justify-content' ); ?>
			</div>
		<?php endif;?>
		<?php //echo Helper::ACF_Link( $fc_button_link, 'button-link' ); ?>

	</div>
</section>
