<?php

\defined( 'ABSPATH' ) || die;

$sidebar = $args['sidebar'] ?? false;
$is_sidebar = false;
// if ( is_active_sidebar( 'post-archive-sidebar' ) && ! is_search() ) {
// 	$is_sidebar = true;
// }
$object = get_queried_object();
$grid_class = 'grid-x grid gap';
if ( $is_sidebar && $sidebar ) {
	$grid_class = 'grid-x grid';

	echo '<div class="sidebar-col">';
	dynamic_sidebar( 'post-archive-sidebar' );
	echo '</div>';
}

// check have posts
if ( have_posts() ) :

if ( $is_sidebar && $sidebar ) { echo '<div class="content-col">';  } ?>
<div class="section-title">
	<h1 class="heading-title"><?php echo get_the_archive_title() ?></h1>
</div> 
<?php echo '<div class="' . $grid_class . '">';
	// Start the Loop.
	$h = 1;
	while ( have_posts() ) : the_post();
		get_template_part( 'template-parts/posts/loop', null, [ 'title-tag' => 'h2' ] );
		// if($h <= 1){
		// 	echo "<div class=\"cell\">";
		// 	get_template_part( 'template-parts/posts/loop-first', null, [ 'title-tag' => 'h2' ] );
		// 	echo "</div>";
		// } else{
		// 	echo "<div class=\"cell\">";
		// 	get_template_part( 'template-parts/posts/loop-lasts', null, [ 'title-tag' => 'h2' ] );
		// 	echo "</div>";
		// }
		// End the loop.
	$h++;
	endwhile;
	wp_reset_postdata();

echo '</div>';

	// Previous/next page navigation.
	the_paginate_links();
else :
	get_template_part( 'template-parts/no-results' );
endif;

if ( $is_sidebar && $sidebar ) { echo '</div>';  }
