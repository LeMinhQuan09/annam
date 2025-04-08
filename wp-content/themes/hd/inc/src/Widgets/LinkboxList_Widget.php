<?php

namespace Widgets;

use Cores\Abstract_Widget;
use Cores\Helper;

\defined( 'ABSPATH' ) || die;

class LinkboxList_Widget extends Abstract_Widget {
	public function __construct() {
		$this->widget_description = __( 'Your site&#8217;s Linkbox List Widget.' );
		$this->widget_name        = __( '* LinkboxList_Widget', TEXT_DOMAIN );

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
        $fc_list_content = $ACF->fc_list_content ?? '';
		$fc_heading  = $ACF->fc_heading ?? '';
		$fc_desc = $ACF->html_desc ?? '';
		$fc_bgimage = $ACF->fc_bgimage ?? '';
		$css_class = ! empty( $ACF->css_class ) ? ' ' . Helper::esc_attr_strip_tags( $ACF->css_class ) : '';
		ob_start();
		?>
        <section class="section linkbox-widget <?= $css_class ?> <?php if($fc_bgimage){ echo 'has-bg'; } ?>" <?php if($fc_bgimage){ ?> style="background-image: url('<?php echo $fc_bgimage; ?>')" <?php } ?>>
            <div class="container">
			<?php if($fc_heading){?><h2 class="heading-title centered"><?php echo $fc_heading; ?></h2><?php } ?>
			<?php if($fc_desc){?><div class="desc"><?php echo $fc_desc; ?></div><?php } ?>
            <?php if($fc_list_content){ ?>
            <ul class="list-content flex flex-x">
                <?php foreach($fc_list_content as $val){
                    echo '<li class="cell">';
					if($val['fc_link']){ echo '<a href="'.$val['fc_link'].'" class="link" target="_blank">';};
                    if($val['fc_icon']){
						echo '<div class="icon">';
						echo wp_get_attachment_image( $val['fc_icon'], 'large' );
						echo '</div>';
					}
					if($val['fc_icon_font']){
						echo '<div class="icon">';
						echo $val['fc_icon_font'];
						echo '</div>';
					}
					if($val['fc_title'] || $val['fc_content']){
						echo '<div class="wrapper">';
						if($val['fc_title']){
							echo '<p class="title">'. $val['fc_title'] .'</p>';
						}
						if($val['fc_content']){
						echo '<div class="content">';
							echo '<div class="desc">'. $val['fc_content'] .'</div>';
							echo '</div>';
						}
						echo '</div>';
					}
					if($val['fc_link']){ echo '</a>';};
                    echo '</li>';
                } ?>
            </ul>
            <?php } ?>
        </div>
        </section>
		<?php
        echo $this->cache_widget( $args, ob_get_clean() ); // WPCS: XSS ok.
	}
}