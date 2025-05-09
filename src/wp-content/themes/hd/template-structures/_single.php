<?php
/**
 * Single hooks
 *
 * @author HD
 */

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

// -----------------------------------------------
// single_before_section
// -----------------------------------------------

if ( ! function_exists( '__hd_single_title' ) ) {
	//add_action( 'single_before_section', '__hd_single_title', 10 );

	function __hd_single_title(): void {

		$args = [];
		the_page_title_theme( $args );
	}
}

// -----------------------------------------------
// single_content
// -----------------------------------------------

if ( ! function_exists( '__hd_single_share' ) ) {
	//add_action( 'single_content', '__hd_single_share', 10 );

	function __hd_single_share(): void {
		get_template_part( 'template-parts/parts/sharing' );
	}
}

// -----------------------------------------------

add_action( 'single_content', '__hd_single_wrapper_open', 12 );
add_action( 'single_content', '__hd_single_wrapper_close', 18 );

function __hd_single_wrapper_open(): void {
	echo '<div class="content-col">';
}

function __hd_single_wrapper_close(): void {
	echo '</div>';
}

// -----------------------------------------------

if ( ! function_exists( '__hd_single_header' ) ) {
	add_action( 'single_content', '__hd_single_header', 14 );

	function __hd_single_header(): void {
		global $post;
		$alternative_title = Helper::get_field( 'alternative_title', $post->ID );
		?>
		<header>
			<div class="section-title">
            	<h1 class="heading-title"><?= $alternative_title ?: get_the_title( $post ) ?></h1>
			</div>
			<?php echo Helper::postExcerpt( $post, 'excerpt', true );?>
        </header>
	<?php
	}
}

// -----------------------------------------------

if ( ! function_exists( '__hd_single_content' ) ) {
	add_action( 'single_content', '__hd_single_content', 16 );

	function __hd_single_content(): void {
		global $post;
		$post_thumbnail = get_the_post_thumbnail( $post, 'large', [ 'alt' => 'image' ] );
		$categories = get_the_category( $post->ID )[0]->name;
		echo '<div class="content"><div class="meta">';
		$from = get_the_time( 'U', $post );
		echo '<span class="post-date">' . date('F j, Y', $from) . '</span>';
		echo '<span class="cat">Thể loại:'. $categories .'</span>';
		echo '</div>'; ?>
		<div class="thumbnail">
			<?php echo $post_thumbnail; ?>
		</div>
        <?php echo '<article ' . Helper::microdata( 'article' ) . '>';
		the_content();
        echo '</article></div>';
	}
}
