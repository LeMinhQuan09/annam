<?php

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

$fc_heading      = $args['fc_heading'] ?? '';
$fc_desc = $args['fc_desc'] ?? '';
$fc_link = $args['fc_link_reviews'] ?? '';
$fc_list_reviews = $args['fc_list_reviews'];
$fc_pagination = $args['fc_pagination'] ?? false;
$fc_bgimage = $args['fc_bgimage'];
$fc_css_class = $args['fc_css_class'] ?? '';
ob_start(); ?>

<section class="section reviews-section <?php echo $fc_css_class; ?> <?php if($fc_bgimage){ echo 'has-bg'; } ?>" <?php if($fc_bgimage){ ?> style="background-image: url('<?php echo $fc_bgimage; ?>')" <?php } ?> >
	<div class="container-fluid">
        <?php if($fc_heading){?><h2 class="heading-title centered"><?php echo $fc_heading; ?></h2><?php } ?>
        <?php if($fc_link){ ?><a href="<?php echo $fc_link; ?>" class="link_reviews"><?php echo $fc_desc; ?></a><?php } ?>
        <?php if($fc_list_reviews){ ?>
        <div class="swiper-container carousel-reviews">
            <?php
            $swiper_class = '';
            $_data = [
                'loop' => true,
                'mobile' => [
                    'spaceBetween'   => 10,
                    'slidesPerView'  => 1,
                    'slidesPerGroup' => 1,
                ],
                'tablet' => [
                    'spaceBetween'   => 20,
                    'slidesPerView'  => 2,
                    'slidesPerGroup' => 1,
                ],
                'desktop' => [
                    'spaceBetween'   => 20,
                    'slidesPerView'  => 3,
                    'slidesPerGroup' => 1,
                ]
            ];
            // if ( $fc_pagination ) {
            //     $_data['pagination'] = 'bullets';
            //     $swiper_class        .= ' pagination-bullets';
            // }
            $_data['pagination'] = 'bullets';
            // swiper_data
            try {
                $swiper_data = json_encode( $_data, JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE );
            } catch ( JsonException $e ) {}
            if ( $swiper_data ) : ?>
            <div class="w-swiper swiper">
                <div class="swiper-wrapper<?= $swiper_class ?>" data-options='<?= $swiper_data ?>'>
                    <?php foreach($fc_list_reviews as $val){ ?>
                    <div class="swiper-slide">
                        <div class="item">
                            <div class="item-inf">
                                <?php if($val['fc_avt']){
                                    echo '<div class="avt">';
                                    echo wp_get_attachment_image( $val['fc_avt'], 'medium' );
                                    echo '</div>'; ?>
                                <?php } ?>
                                <?php if($val['fc_name']){
                                    echo '<p class="name">'. $val['fc_name'] .'</p>'; ?>
                                <?php } ?>
                                <?php if($val['fc_rating']){
                                    $percent = 100 * $val['fc_rating_number'] / 5; ?>
                                    <div class="star-rating2">
                                        <div class="rating-inner">
                                            <i data-glyph=""></i>
                                            <i data-glyph=""></i>
                                            <i data-glyph=""></i>
                                            <i data-glyph=""></i>
                                            <i data-glyph=""></i>
                                            <div style="width: <?= $percent ?>%">
                                                <i data-glyph=""></i>
                                                <i data-glyph=""></i>
                                                <i data-glyph=""></i>
                                                <i data-glyph=""></i>
                                                <i data-glyph=""></i>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($val['fc_job']){
                                    echo '<p class="job">'. $val['fc_job'] .'</p>'; ?>
                                <?php } ?>
                            </div>
                            <?php if($val['fc_content']){ ?>
                            <div class="item-content">
                                <?php echo $val['fc_content'] ?>
                            </div>
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
