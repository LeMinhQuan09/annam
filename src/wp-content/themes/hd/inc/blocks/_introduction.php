<?php

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

$acf_fc_layout = $args['acf_fc_layout'] ?? '';

$fc_title       = $args['fc_title'] ?? '';
$fc_html_desc   = $args['fc_html_desc'] ?? '';
$fc_image       = $args['fc_image'] ?? false;
$fc_button_link = $args['fc_button_link'] ?? '';
$fc_button_name = $args['fc_button_name'] ?? '';
$fc_video_link = $args['fc_video_link'] ?? '';
$fc_css_class   = ! empty( $args['fc_css_class'] ) ? ' ' . Helper::esc_attr_strip_tags( $args['fc_css_class'] ) : '';
ob_start();
?>
<section class="section home-info-section <?= $fc_css_class ?>">
	<div class="container-fluid">
		<div class="flex flex-x flex-info">
			<div class="cell stretch d-auto cell-content">
				<div class="content-inner">
					<?php
					if ( $fc_title ) { echo '<h2 class="heading-title">' . $fc_title . '</h2>'; }
					if ( Helper::stripSpace( $fc_html_desc ) ) { echo '<div class="desc">' . $fc_html_desc . '</div>'; }
					echo Helper::ACF_Link_Wrap($fc_button_name, $fc_button_link, 'button-link' );
					?>
				</div>
			</div>

			<?php
			if ( $fc_image ) :

				$_class = '';
				$_video = '';
				if ( $fc_video_link ) {
					$_class = 'fcy-video';
					$_video = ' data-glyph=""';
				}

				try {
					$attachment_meta = Helper::getAttachment( $fc_image );
				} catch ( JsonException $e ) {}

				$attachment_title = $attachment_meta->title ?? $fc_title;
				$content = wp_get_attachment_image( $fc_image, 'large' );

				?>
			<div class="cell stretch d-auto cell-thumbs">
				<div class="thumb-inner">
					<?php
					echo '<span class="after-overlay"' . $_video . '>';
					echo Helper::ACF_Link_Wrap( $content, $fc_video_link, $_class, $attachment_title );
					echo '</span>';

					?>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php
echo ob_get_clean(); // WPCS: XSS ok.
