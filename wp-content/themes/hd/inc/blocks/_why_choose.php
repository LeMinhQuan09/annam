<?php

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

$acf_fc_layout = $args['acf_fc_layout'] ?? '';

$fc_heading      = $args['fc_heading'] ?? '';
$fc_list_content = $args['fc_list_content'];
$fc_btn_link = $args['fc_btn_link'] ?? '';
$fc_btn_name = $args['fc_btn_name'] ?? '';
$fc_css_class = $args['fc_css_class'] ?? '';

ob_start(); ?>

<section class="section whychoose-section <?php echo $fc_css_class; ?>">
	<div class="container-fluid">
        <?php if($fc_heading){?><h2 class="heading-title centered"><?php echo $fc_heading; ?></h2><?php } ?>
        <?php if($fc_list_content){ ?>
        <ul class="list-content flex flex-x">
            <?php foreach($fc_list_content as $val){
                echo '<li class="cell t-auto">';
                echo '<div class="icon">';
                echo wp_get_attachment_image( $val['fc_icon'], 'large' );
                echo '</div>';
                echo '<div class="content">';
                echo '<p class="title">'. $val['fc_title'] .'</p>';
                echo '<div class="desc">'. $val['fc_content'] .'</div>';
                echo '</div>';
                echo '</li>';
            } ?>
        </ul>
        <?php } ?>
        <?php echo Helper::ACF_Link_Wrap($fc_btn_name, $fc_btn_link, 'button-link' ); ?>
    </div>
</section>
<?php
echo ob_get_clean(); // WPCS: XSS ok.
