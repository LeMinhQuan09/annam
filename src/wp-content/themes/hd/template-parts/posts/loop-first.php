<?php

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

global $post;

$post_title     = get_the_title( $post->ID );
$post_title     = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)', TEXT_DOMAIN );

$attr_post_title = Helper::esc_attr_strip_tags( $post_title );
$post_thumbnail = get_the_post_thumbnail( $post, 'large', [ 'alt' => $attr_post_title ] );

if ( empty( $post_thumbnail ) ) {
	$post_thumbnail = Helper::placeholderSrc();
}

$from = get_the_time( 'U', $post );

$scale_class = 'scale';
$ratio_class = Helper::aspectRatioClass();

$title_tag = $args['title-tag'] ?? 'p';

echo '<div class="item">';
echo '<div class="cover-content">';
echo '<a href="' . get_permalink( $post->ID ) . '" title="' . $attr_post_title . '"><' . $title_tag . ' class="title">' . $post_title . '</' . $title_tag . '></a>';
echo '</div>'; // .cover-content
echo '<div class="meta">';
echo '<span class="post-date">' . date('d/m/Y g:i a', $from) . '</span>';
echo '<span class="post-author">' . get_the_author() . '</span>';
echo '</div>';
// thumbs
echo '<a class="block cover" href="' . get_permalink( $post->ID ) . '" aria-label="' . $attr_post_title . '">';
echo '<span class="' . $scale_class . ' after-overlay res ' . $ratio_class . '">' . $post_thumbnail . '</span>';
echo '</a>';

echo '<div class="cover-content">';

echo Helper::loopExcerpt( $post );
//echo '<a class="view-detail" href="' . get_permalink( $post->ID ) . '" title="' . $attr_post_title . '"><span>' . __( 'Detail', TEXT_DOMAIN ) . '</span></a>';

echo '</div>'; // .cover-content

echo '</div>';
