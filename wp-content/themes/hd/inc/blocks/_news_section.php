<?php

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

$acf_fc_layout = $args['acf_fc_layout'] ?? '';

$fc_title       = $args['fc_title'] ?? '';
$fc_post_cat    = $args['fc_post_cat'] ?? false;
$fc_max_number  = $args['fc_max_number'] ?? '1';
$fc_button_link = $args['fc_button_link'] ?? '';
$fc_button_name = $args['fc_button_name'] ?? 'See more';
$fc_css_class   = ! empty( $args['fc_css_class'] ) ? ' ' . Helper::esc_attr_strip_tags( $args['fc_css_class'] ) : '';

$_args          = [
	'post_type'              => 'post',
	'post_status'            => 'publish',
	'posts_per_page'         => $fc_max_number,
	'no_found_rows'          => true,
	'ignore_sticky_posts'    => true,
];

if ( ! empty( $fc_post_cat ) ) {
    $_args['tax_query'] = [ 'relation' => 'AND' ];

	$term_ids = Helper::removeEmptyValues( $fc_post_cat );
	if ( count( $term_ids ) > 0 ) {
		$_args['tax_query'][] = [
			'taxonomy'         => 'category',
			'terms'            => $term_ids,
			'field'            => 'term_id',
			'include_children' => false,
			'operator'         => 'IN',
		];
	}
}

    // set custom posts_per_page
    set_posts_per_page( $fc_max_number );

    // query
    $_query = new WP_Query( $_args );
    if ( ! $_query->have_posts() ) {
        return;
    }
    ob_start(); ?>
<section class="section news-section<?= $fc_css_class ?>">
	<div class="container">
		<?php
		if ( $fc_title ) {
            echo '<div class="section-title flex">'; 
            echo '<h2 class="heading-title">' . $fc_title . '</h2>';
            echo Helper::ACF_Link_Wrap($fc_button_name, $fc_button_link, 'button-link !lg:show' );
            echo '</div>';
        } ?>
        <div class="grid-posts">
            <?php
                while ( $_query->have_posts() ) : $_query->the_post();
                $post = get_post(); ?>
                <?php get_template_part( 'template-parts/posts/loop', null, [ 'title-tag' => 'h3' ] ); ?>
            <?php
            endwhile;
            wp_reset_postdata(); ?>
        </div>
        <?php if($fc_button_name) : ?>
            <div class="hb_button">
                <?php echo Helper::ACF_Link_Wrap($fc_button_name, $fc_button_link, 'button-link !lg:hidden justify-content' ); ?>
            </div>
		<?php endif;?>
	</div>
</section>
<?php
echo ob_get_clean(); // WPCS: XSS ok.
