<?php

use Cores\Helper;

\defined( 'ABSPATH' ) || die;

$fc_heading      = $args['fc_heading'] ?? '';
$fc_lists_image = $args['fc_lists_image'];
$fc_css_class = $args['fc_css_class'] ?? '';
ob_start(); ?>

<section class="section lists-img-section <?php echo $fc_css_class; ?>">
	<div class="container">
    <?php 
    if ($fc_lists_image) {
        echo '<div class="wrapper">';
        $index = 0;
        while ($index < count($fc_lists_image)) {
            // Cột 1: 1 hình
            echo '<div class="col">';
            if (isset($fc_lists_image[$index]['fc_link'])) { 
                echo '<a href="' . esc_url($fc_lists_image[$index]['fc_link']) . '">'; 
            }
            echo '<img src="' . esc_url($fc_lists_image[$index]['fc_img']['url']) . '" alt="Image">';
            if (isset($fc_lists_image[$index]['fc_link'])) { 
                echo '</a>'; 
            }
            echo '</div>';
            $index++;

            // Cột 2: 2 hình
            if ($index < count($fc_lists_image)) {
                echo '<div class="col">';
                for ($i = 0; $i < 2 && $index < count($fc_lists_image); $i++, $index++) {
                    if (isset($fc_lists_image[$index]['fc_link'])) { 
                        echo '<a href="' . esc_url($fc_lists_image[$index]['fc_link']) . '">'; 
                    }
                    echo '<img src="' . esc_url($fc_lists_image[$index]['fc_img']['url']) . '" alt="Image">';
                    if (isset($fc_lists_image[$index]['fc_link'])) { 
                        echo '</a>'; 
                    }
                }
                echo '</div>';
            }

            // Cột 3: 1 hình
            if ($index < count($fc_lists_image)) {
                echo '<div class="col">';
                if (isset($fc_lists_image[$index]['fc_link'])) { 
                    echo '<a href="' . esc_url($fc_lists_image[$index]['fc_link']) . '">'; 
                }
                echo '<img src="' . esc_url($fc_lists_image[$index]['fc_img']['url']) . '" alt="Image">';
                if (isset($fc_lists_image[$index]['fc_link'])) { 
                    echo '</a>'; 
                }
                echo '</div>';
                $index++;
            }
        }
        echo '</div>';
    }
?>
    </div>
</section>
<?php
echo ob_get_clean(); // WPCS: XSS ok.
