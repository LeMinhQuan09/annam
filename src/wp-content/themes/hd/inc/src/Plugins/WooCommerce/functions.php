<?php

use Composer\Installers\PPIInstaller;
use Cores\Helper;

\defined( 'ABSPATH' ) || die;

// ------------------------------------------------------

if ( ! function_exists( '_wc_cart_link' ) ) {

	/**
	 * Displayed a link to the cart including the number of items present and the cart total
	 *
	 * @return void
	 */
	function _wc_cart_link(): void {
		if ( ! _wc_cart_available() ) {
			return;
		}
		?>
        <a class="header-cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php echo esc_attr__( 'View your shopping cart', TEXT_DOMAIN ); ?>">
				<?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?>
            <span class="icon" data-glyph=""></span>
	            <span class="count"><?php echo wp_kses_data( sprintf( '%d', WC()->cart->get_cart_contents_count() ) ); ?></span>
	            <span class="txt"><?php echo __( 'Shopping cart', TEXT_DOMAIN ) ?></span>
	        </a>
		<?php
	}
}

// ------------------------------------------------------

if ( ! function_exists( '_wc_cart_available' ) ) {

	/**
	 * Validates whether the Woo Cart instance is available in the request
	 *
	 * @return bool
	 */
	function _wc_cart_available(): bool {
		$woo = \WC();

		return $woo instanceof \WooCommerce && $woo->cart instanceof \WC_Cart;
	}
}

// ------------------------------------------------------

if ( ! function_exists( '_wc_get_gallery_image_html' ) ) {

	/**
	 * @param      $attachment_id
	 * @param bool $main_image
	 * @param bool $cover
	 * @param bool $lightbox
	 *
	 * @return string
	 */
	function _wc_get_gallery_image_html( $attachment_id, bool $main_image = false, bool $cover = false, bool $lightbox = false ): string {
		$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
		$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', [
			$gallery_thumbnail['width'],
			$gallery_thumbnail['height']
		] );

		$image_size    = apply_filters( 'woocommerce_gallery_image_size', $main_image ? 'woocommerce_single' : $thumbnail_size );
		$full_size     = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'widescreen' ) );
		$thumbnail_src = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
		$full_src      = wp_get_attachment_image_src( $attachment_id, $full_size );
		$alt_text      = Helper::esc_attr_strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

		$image = wp_get_attachment_image(
			$attachment_id,
			$image_size,
			false,
			apply_filters(
				'woocommerce_gallery_image_html_attachment_image_params',
				[
					'title'                   => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
					'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
					'data-src'                => esc_url( $full_src[0] ),
					'data-large_image'        => esc_url( $full_src[0] ),
					'data-large_image_width'  => esc_attr( $full_src[1] ),
					'data-large_image_height' => esc_attr( $full_src[2] ),
					'class'                   => esc_attr( $main_image ? 'wp-post-image' : '' ),
				],
				$attachment_id,
				$image_size,
				$main_image
			)
		);

		$ratio_class = Helper::aspectRatioClass( 'product' );
		$auto        = $cover ? ' ' : ' auto ';

		if ( $lightbox ) {
			$popup_image = '<span data-rel="lightbox" class="image-popup" data-src="' . esc_url( $full_src[0] ) . '" data-glyph=""></span>';

			return '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" data-thumb-alt="' . esc_attr( $alt_text ) . '" class="wpg__image cover"><a class="res' . $auto . $ratio_class . '" href="' . esc_url( $full_src[0] ) . '">' . $image . '</a>' . $popup_image . '</div>';
		}

		return '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" data-thumb-alt="' . esc_attr( $alt_text ) . '" class="woocommerce-product-gallery__image wpg__thumb cover"><a class="res' . $auto . $ratio_class . '" href="' . esc_url( $full_src[0] ) . '">' . $image . '</a></div>';
	}
}

// ------------------------------------------------------

if ( ! function_exists( '_wc_sale_flash_percent' ) ) {

	/**
	 * @param $product
	 *
	 * @return float|string
	 */
	function _wc_sale_flash_percent( $product ): float|string {
		global $product;
		$percent_off = '';

		if ( $product->is_on_sale() ) {

			if ( $product->is_type( 'variable' ) ) {
				$percent_off = ceil( 100 - ( $product->get_variation_sale_price() / $product->get_variation_regular_price( 'min' ) ) * 100 );
			} elseif ( $product->get_regular_price() && ! $product->is_type( 'grouped' ) ) {
				$percent_off = ceil( 100 - ( $product->get_sale_price() / $product->get_regular_price() ) * 100 );
			}
		}

		return $percent_off;
	}
}

// Thêm danh mục sản phẩm trước tiêu đề trên trang archive
function add_category_before_product_title() {
	if (is_product_category() || is_shop() || is_product_taxonomy() || is_product()) {
		global $product;
		$categories = wp_get_post_terms($product->get_id(), 'product_cat');
		if (!empty($categories) && !is_wp_error($categories)) {
			$category_names = array();
			foreach ($categories as $category) {
				$category_link = get_term_link($category);
				$category_names[] = $category->name;
			}
			echo '<a href="' . esc_url($category_link) . '" class="product-category-link">' . esc_html($category->name) . '</a>';
		}
	}
}
// custom rating
function custom_woocommerce_template_loop_rating() {
    global $product;
    if ( wc_get_rating_html( $product->get_average_rating() ) ) {
        // Sản phẩm có đánh giá
        echo wc_get_rating_html( $product->get_average_rating() );
    } else {
        // Sản phẩm chưa có đánh giá
        echo '<div class="loop-stars-rating no-rating">';
        echo '<span style="width:0%"><strong class="rating">0</strong> out of 5</span>';
        echo '</div>';
    }
}
// Function change text 'Add to basket' -> 'Add to cart'
function change_text_add_to_cart( $translated_text) {
    if ( $translated_text === 'Add to basket' ) {
        $translated_text = 'Add to cart';
    }
    return $translated_text;
}

function woocommerce_cart_icon_shortcode() {
    ob_start(); ?>
    <a class="header-cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'hd' ); ?>">
		<span class="icon"><i class="fa fa-shopping-cart"></i></span>
        <span class="count"><?php echo wp_kses_data(sprintf('%d', WC()->cart->get_cart_contents_count())); ?> <span class="pre-count">sản phẩm - </span></span>
        <!-- <span class="count"><?php //echo WC()->cart->get_cart_contents_count(); ?> <span class="pre-count">sản phẩm - </span></span> -->
		<span class="cart-total"><?php echo WC()->cart->get_cart_total(); ?></span>
    </a>
    <?php
    return ob_get_clean();
}
add_shortcode('woocommerce_cart_icon', 'woocommerce_cart_icon_shortcode');

//== function custom variation prices
function display_variation_prices() {
    global $product;
    if ($product->is_type('variable')) {
        $available_variations = $product->get_available_variations();
        $max_regular_price = 0;
        $min_sale_price = PHP_INT_MAX;
        foreach ($available_variations as $variation) {
            $variation_id = $variation['variation_id'];
            $variation_product = new WC_Product_Variation($variation_id);
            $regular_price = $variation_product->get_regular_price();
            $sale_price = $variation_product->get_sale_price();
            if ($regular_price) {
                $max_regular_price = max($max_regular_price, $regular_price);
            }
            if ($sale_price) {
                $min_sale_price = min($min_sale_price, $sale_price);
            }
        }
        echo '<div class="variation-price">';
        echo '<p class="regular"><span class="text">Giá Niêm yết:</span> ' . ($max_regular_price ? wc_price($max_regular_price) : 'N/A') . '</p>';
        echo '<p class="sale"><span class="text">Còn:</span> <b>' . ($min_sale_price < PHP_INT_MAX ? wc_price($min_sale_price) : 'N/A') . '</b></p>';
        echo '</div>';
    }
}
//add_action('woocommerce_shop_loop_item_title', 'display_variation_prices', 15);

//== function doi 'giam gia' thanh %
add_filter('woocommerce_sale_flash', 'custom_woocommerce_sale_flash', 10, 3);
function custom_woocommerce_sale_flash($html, $post, $product){
    return '<span class="onsale"><span>' . custom_presentage_bubble($product) . '</span></span>';
}
function custom_presentage_bubble( $product ) {
    $post_id = $product->get_id();
    if ( $product->is_type( 'simple' ) || $product->is_type( 'external' ) ) {
        $regular_price  = $product->get_regular_price();
        $sale_price     = $product->get_sale_price();
        $bubble_content = round( ( ( floatval( $regular_price ) - floatval( $sale_price ) ) / floatval( $regular_price ) ) * 100 );
    } elseif ( $product->is_type( 'variable' ) ) {
        if ( $bubble_content = custom_percentage_get_cache( $post_id ) ) {
            return custom_percentage_format( $bubble_content );
        }
        $available_variations = $product->get_available_variations();
        $maximumper           = 0;
        for ( $i = 0; $i < count( $available_variations ); ++ $i ) {
            $variation_id     = $available_variations[ $i ]['variation_id'];
            $variable_product = new WC_Product_Variation( $variation_id );
            if ( ! $variable_product->is_on_sale() ) {
                continue;
            }
            $regular_price = $variable_product->get_regular_price();
            $sale_price    = $variable_product->get_sale_price();
            $percentage    = round( ( ( floatval( $regular_price ) - floatval( $sale_price ) ) / floatval( $regular_price ) ) * 100 );
            if ( $percentage > $maximumper ) {
                $maximumper = $percentage;
            }
        }
        $bubble_content = sprintf( __( '%s', 'woocommerce' ), $maximumper );
        custom_percentage_set_cache( $post_id, $bubble_content );
    } else {
        $bubble_content = __( 'Sale!', 'woocommerce' );
        return $bubble_content;
    }
    return custom_percentage_format( $bubble_content );
}
function custom_percentage_get_cache( $post_id ) {
    return get_post_meta( $post_id, '_custom_product_percentage', true );
}
function custom_percentage_set_cache( $post_id, $bubble_content ) {
    update_post_meta( $post_id, '_custom_product_percentage', $bubble_content );
}
//Định dạng kết quả dạng -{value}%. Ví dụ -20%
function custom_percentage_format( $value ) {
    return str_replace( '{value}', $value, '-{value}%' );
}
// Xóa cache khi sản phẩm hoặc biến thể thay đổi
function custom_percentage_clear( $object ) {
    $post_id = 'variation' === $object->get_type()
        ? $object->get_parent_id()
        : $object->get_id();
    delete_post_meta( $post_id, '_custom_product_percentage' );
}
add_action( 'woocommerce_before_product_object_save', 'custom_percentage_clear' );

//== add rating va so luong ban
function add_rating_and_number_sold() {
	global $product;
	$number_sold = get_field('number_product_sold',$product->get_id());
	$number_rating = get_field('number_product_rating',$product->get_id()); ?>
    <div class="rating-and-productsold flex hidden">
		<div class="star">
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
			<i class="fa fa-star"></i>
		</div>
		<?php if($number_rating){ ?>
			<div class="number_rating relative"><span><?php echo $number_rating; ?></span> đánh giá</div>
		<?php } ?>
		<?php if($number_sold){ ?>
			<div class="number_sold relative">Đã bán <span><?php echo $number_sold; ?></span> sản phẩm</div>
		<?php } ?>
	</div>
<?php }
add_action('woocommerce_single_product_summary', 'add_rating_and_number_sold', 7);

// add flash sale
function add_flash_sale($product){
	global $product;
	$is_flash_sale = get_field('sl_flash_sale',$product->get_id());
	if($is_flash_sale == 1){ ?>
		<div class="flashsale-single flex">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/img-flashsale.png" alt="">
			<div class="countdown" data-end-date="<?php echo esc_attr(get_field('sl_date_end','option')); ?>"
			data-end-time="<?php echo esc_attr(get_field('sl_time_end','option')); ?>">
				<div class="countdown-item">
					<span class="day time"></span>
					<span class="prefix">ngày</span> 
				</div>
				<div class="countdown-item">
					<span class="hour time"></span>
					<span class="prefix">giờ</span>
				</div>
				<div class="countdown-item">
					<span class="minute time"></span>
					<span class="prefix">phút</span>
				</div>
				<div class="countdown-item">
					<span class="second time"></span>
					<span class="prefix">giây</span>
				</div>
			</div>
		</div>
	<?php }
}
//add_action('woocommerce_single_product_summary', 'add_flash_sale', 8);
// add phone product
function add_phone_form(){ ?>
	<div class="section-form-phone">
		<div class="section-form-phone_text">
			<i class="fa-solid fa-headset"></i>
			<div class="text">Hãy để lại <b>SĐT</b><br>
			Chuyên Viên Tư Vấn sẽ Gọi ngay cho bạn MIỄN PHÍ
			</div>
		</div>
		<div class="section-form-phone_form">
			<?php echo do_shortcode('[contact-form-7 id="002259f" title="Form điện thoại"]'); ?>
		</div>
	</div>
<?php }
//add_action('woocommerce_single_product_summary', 'add_phone_form', 45);
//== add button 'Mua ngay' single-product
function add_button_buy_now(){
	global $product; ?>
    <button type="button" class="button buy_now_button"><i class="fa-solid fa-cart-shopping"></i> Mua ngay</button>
    <input type="hidden" name="is_buy_now" class="is_buy_now" value="0" autocomplete="off"/>
<?php }
//add_action('woocommerce_after_add_to_cart_button','add_button_buy_now');
//== Xu ly button mua ngay -> trang thanh toan
//add_filter('woocommerce_add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout($redirect_url) {
    if(!get_theme_mod( 'ajax_add_to_cart' )) {
        if (isset($_REQUEST['is_buy_now']) && $_REQUEST['is_buy_now'] && get_option('woocommerce_cart_redirect_after_add') !== 'yes') {
            $redirect_url = wc_get_checkout_url();
        }
    }
    return $redirect_url;
}
// add_filter('woocommerce_get_script_data', 'devvn_woocommerce_get_script_data', 10, 2);
function devvn_woocommerce_get_script_data($params, $handle) {
    if($handle == 'wc-add-to-cart'){
        $params['cart_url'] = wc_get_checkout_url();
    }
    return $params;
}

//== Remove input form checkout
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
	$fields['billing']['billing_first_name'] = array(
        'label' => __('Họ và tên', 'hd'),
        'placeholder' => _x('Họ và tên', 'placeholder', 'hd'),
        'required' => true,
        'class' => array('form-row-first'),
        'clear' => true,
        'priority' => 10
    );
	unset($fields['billing']['billing_last_name']);
	unset($fields['billing']['billing_postcode']);
	unset($fields['billing']['billing_state']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_country']);
	unset($fields['billing']['billing_company']);
	unset($fields['billing']['billing_city']);
	$fields['billing']['billing_email']['required'] = false;
	return $fields;
}
//== Mở <div> bao nút và wishlist 
add_action('woocommerce_after_shop_loop_item', 'custom_wrap_add_to_cart_and_wishlist', 9);
function custom_wrap_add_to_cart_and_wishlist() {
    echo '<div class="custom-group-button">'; // Mở div wrapper
}

add_action('woocommerce_after_shop_loop_item', 'custom_add_to_wishlist_button', 11);
function custom_add_to_wishlist_button() {
    echo do_shortcode('[yith_wcwl_add_to_wishlist]'); // Nút YITH Wishlist
}

add_action('woocommerce_after_shop_loop_item', 'custom_close_wrap_add_to_cart_and_wishlist', 15);
function custom_close_wrap_add_to_cart_and_wishlist() {
    echo '</div>';
}
//== Đóng thẻ <div> bao nút và wishlist 
// Thay đổi nút "Thêm vào giỏ hàng" thành icon
//add_filter( 'woocommerce_loop_add_to_cart_link', 'custom_icon_add_to_cart_button', 10, 2 );
function custom_icon_add_to_cart_button( $button, $product ) {
    // Nút icon thêm vào giỏ hàng
    $button_text = '<i class="fa-regular fa-cart-plus"></i>';
    $button = sprintf(
        '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
        esc_url( $product->add_to_cart_url() ),
        esc_attr( isset( $quantity ) ? $quantity : 1 ),
        'button button-add-to-cart product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart product_button',
        '',
        $button_text
    );

    return $button;
}
// hook tu dong cap nhat khi them san pham
add_filter('woocommerce_add_to_cart_fragments', 'update_cart_fragment');
function update_cart_fragment($fragments) {
    ob_start();
    ?>
    <a class="header-cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'hd' ); ?>">
        <span class="icon"><i class="fa fa-shopping-cart"></i></span>
        <span class="count"><?php echo wp_kses_data(sprintf('%d', WC()->cart->get_cart_contents_count())); ?> <span class="pre-count">sản phẩm - </span></span>
        <span class="cart-total"><?php echo WC()->cart->get_cart_total(); ?></span>
    </a>
    <?php
    $fragments['a.header-cart-contents'] = ob_get_clean();
    return $fragments;
}

