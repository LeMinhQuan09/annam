<?php
/**
 * The template for displaying 'About Us'
 * Template Name: About Us
 * Template Post Type: page
 */

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

// header
get_header();

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

$alternative_title = $ACF->alternative_title ?? '';
$image_for_banner  = $ACF->image_for_banner ?? false;
$html_desc           = $ACF->html_desc ?? false;
$aboutus_listsbox = $ACF->aboutus_listsbox ?? false;
$post_thumbnail = get_the_post_thumbnail( $post, 'medium' );
$content_other = $ACF->content_other ?? '';
$bg_content = $ACF->bg_content ?? '';
?>
<section class="section singular page page-about-us">
    <div class="main-aboutus">
        <div class="container">
            <header>
                <h1 class="heading-title"><?= $alternative_title ?: get_the_title() ?></h1>
            </header>
            <article <?=Helper::microdata( 'article' )?>>
                <?php the_content(); ?>
                <div class="listsbox">
                <?php if($html_desc){ echo '<div class="desc">'. $html_desc .'</div>'; } ?>
                <?php if($aboutus_listsbox){ ?>
                <ul class="listbox">
                    <?php foreach($aboutus_listsbox as $val){ ?>
                        <li class="item">
                            <div class="icon">
                                <?php echo wp_get_attachment_image( $val['icon_box'], 'medium' ); ?>
                            </div>
                            <div class="content">
                                <?php echo $val['content_box']; ?>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
                <?php } ?>
                </div>
            </article>
        </div>
    </div>
    <?php if($content_other){ ?>
    <div class="bottom-aboutus relative">
        <?php if($bg_content){ ?>
            <div class="bg"><?php echo wp_get_attachment_image( $bg_content, 'widescreen' ) ?></div>
        <?php } ?>
        <div class="container wrapper-content">
            <div class="content"><?php echo $content_other; ?></div>
        </div>
    </div>
    <?php } ?>
</section>
<?php

// footer
get_footer();
