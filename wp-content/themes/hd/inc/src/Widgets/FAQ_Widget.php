<?php

namespace Widgets;

use Cores\Abstract_Widget;
use Cores\Helper;

\defined( 'ABSPATH' ) || die;

class FAQ_Widget extends Abstract_Widget {
	public function __construct() {
		$this->widget_description = __( 'Your site&#8217;s FAQ Widget.' );
		$this->widget_name        = __( '* FAQ_Widget', TEXT_DOMAIN );
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
        $lists_faq = $ACF->lists_faq ?? '';
		$css_class = ! empty( $ACF->css_class ) ? ' ' . Helper::esc_attr_strip_tags( $ACF->css_class ) : '';
		ob_start();
		?>
        <section class="section faq-section <?= $css_class ?>">
            <?php if($lists_faq){ ?>
            <div class="top-faq">
                <div class="container">
                    <h2 class="heading-title"><?php echo $title; ?></h2>
                    <?php $total_faq = count($lists_faq);
                        $half_faq = ceil($total_faq / 2); ?>
                        <div class="faq-columns">
                            <ul class="lists-faq">
                                <?php for ($i = 0; $i < $half_faq; $i++) { ?>
                                    <li class="toggle-item">
                                        <div class="tab-title">
                                            <p class="title"><?php echo $lists_faq[$i]['ques_faq']; ?></p>
                                        </div>
                                        <div class="tab-content">
                                            <div class="content"><?php echo $lists_faq[$i]['answer_faq']; ?></div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                            <ul class="lists-faq">
                                <?php for ($i = $half_faq; $i < $total_faq; $i++) { ?>
                                    <li class="toggle-item">
                                        <div class="tab-title">
                                            <p class="title"><?php echo $lists_faq[$i]['ques_faq']; ?></p>
                                        </div>
                                        <div class="tab-content">
                                            <div class="content"><?php echo $lists_faq[$i]['answer_faq']; ?></div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                </div>
            </div>
            <?php } ?>
        </section>
		<?php
        echo $this->cache_widget( $args, ob_get_clean() ); // WPCS: XSS ok.
	}
}
