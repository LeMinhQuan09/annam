<?php

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

$acf_fc_layout = $args['acf_fc_layout'] ?? '';

$fc_heading      = $args['fc_heading'] ?? '';
$fc_desc = $args['html_desc'] ?? '';
$fc_list_content = $args['fc_list_content'] ?? '';
$fc_btn_link = $args['fc_btn_link'] ?? '';
$fc_btn_name = $args['fc_btn_name'] ?? '';
$fc_css_class = $args['fc_css_class'] ?? '';
$fc_bgimage = $args['fc_bgimage'];

ob_start(); ?>

<section class="section linkbox_list-section <?php echo $fc_css_class; ?> <?php if($fc_bgimage){ echo 'has-bg'; } ?>" <?php if($fc_bgimage){ ?> style="background-image: url('<?php echo $fc_bgimage; ?>')" <?php } ?>>
	<div class="container">
        <?php if($fc_heading){?><h2 class="heading-title centered"><?php echo $fc_heading; ?></h2><?php } ?>
        <?php if($fc_desc){?><div class="desc"><?php echo $fc_desc; ?></div><?php } ?>
        <?php if($fc_list_content){ ?>
        <ul class="list-content flex flex-x">
            <?php foreach($fc_list_content as $val){
                echo '<li class="cell flex t-auto">';
                if($val['fc_link']){
                    echo '<a class="link" href="'. $val['fc_link'] .'">';
                }
                echo '<div class="icon">';
                echo wp_get_attachment_image( $val['fc_icon'], 'large' );
                echo '</div>';
                echo '<div class="content">';
                echo '<p class="title">'. $val['fc_title'] .'</p>';
                if($val['fc_content']){
                    echo '<div class="desc">'. $val['fc_content'] .'</div>';
                }
                echo '</div>';
                if($val['fc_link']){
                    echo '</a>';
                }
                echo '</li>';
            } ?>
        </ul>
        <?php } ?>
        <?php if($fc_btn_link){ 
            echo Helper::ACF_Link_Wrap($fc_btn_name, $fc_btn_link, 'button-link' ); 
        } ?>
    </div>
</section>
<?php
echo ob_get_clean(); // WPCS: XSS ok.
