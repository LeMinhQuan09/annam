<?php

namespace Widgets;

use Cores\Abstract_Widget;
use Cores\Helper;

\defined( 'ABSPATH' ) || die;

class ButtonCTA_Widget extends Abstract_Widget {
	public function __construct() {
		$this->widget_description = __( 'Your site&#8217;s Button CTA Widget.' );
		$this->widget_name        = __( '* ButtonCTA_Widget', TEXT_DOMAIN );

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
		// ACF fields
		$ACF = $this->acfFields( 'widget_' . $args['widget_id'] );
        $fc_lists_contact = $ACF->fc_lists_contact ?? '';
		$fc_title_popup = $ACF->fc_title_popup ?? '';
		$css_class = ! empty( $ACF->css_class ) ? ' ' . Helper::esc_attr_strip_tags( $ACF->css_class ) : '';
		ob_start();
		?>
        <section class="section-cta-sidebar">
            <?php if($fc_lists_contact){ ?>
            <ul class="cta-lists">
                <?php foreach($fc_lists_contact as $val){
					//dump($val['fc_link'] );
					if($val['fc_popup']){} ?>
                    <li class="btn-cta <?php if($val['fc_popup']){ echo 'has-popup';} else { 'btn-link'; } ?> <?php if($val['fc_css_class']){echo $val['fc_css_class'];}?>" data-attr="<?php if($val['fc_css_class']){echo $val['fc_css_class'];}?>">
                        <div class="btn-cta-wrapper">
                            <div class="circle-fill"></div>
                            <div class="cta-img-circle">
								<?php if($val['fc_popup']) {?>
									<a href="javascript:void(0)">
										<?php if( $val['fc_img'] ) {
											echo wp_get_attachment_image( $val['fc_img'], 'large' );
										} ?>
									</a>
								<?php }else{ ?>
									<?php echo wp_get_attachment_image( $val['fc_img'], 'large' );?>
								<?php } ?>
                            </div>
							<?php if(!$val['fc_popup']) {
								?>
								<?php echo Helper::ACF_Link( $val['fc_link'], 'button-text' ); ?>
							<?php } ?>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <?php } ?> 
        </section>
		<div class="modal-popup">
			<div class="bg"></div>
			<div class="modal-content">
				<div class="modal-header">
					<p class="title"><?php echo $fc_title_popup; ?></p>
				</div>
				<?php if($fc_lists_contact){ ?>
					<div class="modal-body">
						<?php foreach($fc_lists_contact as $lists_contact){
							if($lists_contact['fc_detail']){ ?>
								<ul class="cta-detail <?php if($lists_contact['fc_css_class']){echo $lists_contact['fc_css_class'];}?>">
								<?php foreach($lists_contact['fc_detail'] as $detail){ ?>
								<li>
									<a href="<?php echo $detail['fc_link_content'] ?>">
										<?php if( $detail['fc_img_content'] ) {
											echo wp_get_attachment_image( $detail['fc_img_content'], 'large' );
										} ?>
										<?php echo $detail['fc_content']; ?>
									</a>
								</li>
								<?php } ?>
							<?php echo '</ul>'; 
						}
					} ?>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php
        echo $this->cache_widget( $args, ob_get_clean() ); // WPCS: XSS ok.
	}
}