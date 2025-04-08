<?php
/**
 * The template for displaying the footer.
 * Contains the body & html closing tags.
 *
 * @package HD
 */

\defined( 'ABSPATH' ) || die;

?>
    </div><!-- #site-content -->
    <?php

    /**
     * Before Footer
     */
    do_action( 'hd_before_footer' );

    ?>
    <footer class="site-footer" <?php echo \Cores\Helper::microdata( 'footer' ); ?>>
        <?php

        /**
         * Footer
         *
         * @see __hd_construct_footer_widgets - 5
         * @see __hd_construct_footer_credit - 10
         */
        do_action( 'hd_footer' );

        ?>
    </footer><!-- .site-footer -->
    <script>
        jQuery(document).ready(function($) {
            // Tìm phần tử chứa văn bản "Show more" và thay thế nó
            $('.section.archive-product .grid-products > .sidebar-col .yith-wcan-filters .yith-wcan-filter a.show-more').text('Hiển thị thêm');
            
            // Đảm bảo khi AJAX hoạt động, văn bản vẫn được cập nhật
            $(document).ajaxComplete(function() {
                $('.section.archive-product .grid-products > .sidebar-col .yith-wcan-filters .yith-wcan-filter a.show-more').text('Hiển thị thêm');
            });
        });
    </script>
    <?php

    /**
     * After Footer
     */
    do_action( 'hd_after_footer' );
    if ( is_active_sidebar( 'w-cta-sidebar' ) ) :
        dynamic_sidebar( 'w-cta-sidebar' );
    endif;
    /**
     * Footer
     *
     * @see __wp_footer - 98
     */
    wp_footer();

    ?>
</body>
</html>
