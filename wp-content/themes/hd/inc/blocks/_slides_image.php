<?php

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

$fc_heading      = $args['fc_heading'] ?? '';
$fc_list_img = $args['fc_lists_image'];
$fc_css_class = $args['fc_css_class'] ?? '';
ob_start(); ?>

<section class="section slides-img-section <?php echo $fc_css_class; ?>">
	<div class="container">
        <?php if($fc_list_img){ ?>
        <div class="swiper-container carousel-img">
        <?php if($fc_heading){?><h2 class="heading-title"><?php echo $fc_heading; ?></h2><?php } ?>
            <?php
            $swiper_class = '';
            $_data = [
                'loop' => true,
                'mobile' => [
                    'spaceBetween'   => 10,
                    'slidesPerView'  => 2,
                    'slidesPerGroup' => 1,
                ],
                'tablet' => [
                    'spaceBetween'   => 20,
                    'slidesPerView'  => 4,
                    'slidesPerGroup' => 1,
                ],
                'desktop' => [
                    'spaceBetween'   => 20,
                    'slidesPerView'  => 4,
                    'slidesPerGroup' => 1,
                ]
            ];
            $_data['pagination'] = 'bullets';
            $_data['autoplay'] = false;
            $_data['loop'] = true;
            // swiper_data
            try {
                $swiper_data = json_encode( $_data, JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE );
            } catch ( JsonException $e ) {}
            if ( $swiper_data ) : ?>
            <div class="w-swiper swiper">
                <div class="swiper-wrapper<?= $swiper_class ?>" data-options='<?= $swiper_data ?>'>
                    <?php foreach($fc_list_img as $val){ ?>
                    <div class="swiper-slide">
                        <div class="item">
                            <?php if($val['image']){
                                if($val['link']){
                                  echo '<a class="link" href="'.$val['link'].'">';  
                                }
                                echo wp_get_attachment_image( $val['image'], 'medium' );
                                if($val['link']){ echo '</a>'; } ?>
                            <?php } ?>
                        </div> 
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php } ?>
    </div>
</section>
<?php
echo ob_get_clean(); // WPCS: XSS ok.
