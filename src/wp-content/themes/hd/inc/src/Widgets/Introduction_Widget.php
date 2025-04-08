<?php

namespace Widgets;

use Cores\Abstract_Widget;
use Cores\Helper;

\defined( 'ABSPATH' ) || die;

class Introduction_Widget extends Abstract_Widget {
	public function __construct() {
		$this->widget_description = __( 'Your site&#8217;s Introduction Widget.' );
		$this->widget_name        = __( '* Introduction_Widget', TEXT_DOMAIN );
		$this->settings           = [
			'title'                 => [
				'type'  => 'textarea',
				'std' => '',
				'label' => __( 'Title', TEXT_DOMAIN ),
			],
		];

		parent::__construct();
	}

	/**
	 * Outputs the content for the posts widget instance.
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @throws \JsonException
	 */
	public function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		$title = $this->get_instance_title( $instance );
		// ACF fields
		$ACF = $this->acfFields( 'widget_' . $args['widget_id'] );
        $img = $ACF->img ?? '';
		$sub_img = $ACF->sub_image ?? '';
        $desc = $ACF->html_desc ?? '';
		$css_class = ! empty( $ACF->css_class ) ? ' ' . Helper::esc_attr_strip_tags( $ACF->css_class ) : '';
		ob_start();
		?>
        <section class="section introduction-section <?= $css_class ?>">
			<div class="container-fluid">
                <div class="flex flex-x flex-info">
                    <div class="cell stretch d-auto cell-content">
                        <div class="content-inner">
                            <?php
                            if ( $title ) { echo '<h2 class="heading-title">' . $title . '</h2>'; }
                            if ( Helper::stripSpace( $desc ) ) { echo '<div class="desc">' . $desc . '</div>'; }
                            ?>
                        </div>
                    </div>

                <?php
                if ( $img ) : ?>
                <div class="cell stretch d-auto cell-thumbs">
                    <div class="thumb-inner relative">
                        <span class="after-overlay">
                        	<?php echo wp_get_attachment_image( $img, 'large' ); ?>
                        </span>
						<?php if($sub_img){ ?>
							<div class="sub-img"><img src="<?php echo do_shortcode($sub_img['url']); ?>" alt=""></div>
						<?php } ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            </div>
        </section>
		<?php
        echo $this->cache_widget( $args, ob_get_clean() ); // WPCS: XSS ok.
	}
}
