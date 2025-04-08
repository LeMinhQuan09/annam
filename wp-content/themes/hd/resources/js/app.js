import './foundation/_foundation';
import { nanoid } from 'nanoid';
import device from 'current-device';

// const is_mobile = () => device.mobile();
// const is_tablet = () => device.tablet();

// import Cookies from 'js-cookie';
// window.Cookies = Cookies;
// Object.assign(window, { Cookies });

import { Fancybox } from '@fancyapps/ui';

//------------------------------------

Fancybox.bind('.fcy-popup, .fcy-video, .banner-video a', {});
Fancybox.bind('.wp-block-gallery .wp-block-image a, [id^="gallery-"] a, [data-rel="lightbox"]', {
    groupAll: true, // Group all items
});



/** product images slides */
// const spg_swiper = [...document.querySelectorAll('.swiper-product-gallery')];
// spg_swiper.forEach((el, index) => {
//     const _rand = nanoid(8),
//         _class = 'swiper-product-gallery-' + _rand;
//     el.classList.add(_class);
//     let w_images = el.querySelector('.swiper-images');
//     let w_thumbs = el.querySelector('.swiper-thumbs');

//     let swiper_images = false;
//     let swiper_thumbs = false;

//     /** wpg images */
//     if (w_images) {
//         w_images.querySelector('.swiper-button-prev').classList.add('prev-images-' + _rand);
//         w_images.querySelector('.swiper-button-next').classList.add('next-images-' + _rand);
//         w_images.classList.add('images-' + _rand);
//         /** variation image */
//         let firstImage = w_images.querySelector('.swiper-images-first img');
//         firstImage.removeAttribute('srcset');

//         let firstImageSrc = firstImage.getAttribute('src');
//         let imagePopupSrc = w_images.querySelector('.swiper-images-first .image-popup');

//         /** */
//         let firstThumb = false;
//         let firstThumbSrc = false;
//         let dataLargeImage = false;

//         if (swiper_thumbs) {
//             firstThumb = w_thumbs.querySelector('.swiper-thumbs-first img');
//             firstThumb.removeAttribute('srcset');

//             firstThumbSrc = firstThumb.getAttribute('src');
//             dataLargeImage = firstThumb.getAttribute('data-large_image');
//         }

//         /** */
//         const variations_form = $('form.variations_form');
//         jQuery("form.variations_form .variable-item.button-variable-item").click(function (variation) {
//             alert('quan');
//             // if( variation.image.src ) {
//             //     firstImage.setAttribute('src', variation.image.src);
//             //     imagePopupSrc.setAttribute('data-src', variation.image.full_src);
//             //     if (swiper_thumbs) {
//             //         firstThumb.setAttribute('src', variation.image.gallery_thumbnail_src);
//             //     }

//             //     swiper_images.slideTo(0);
//             // }
//         })
//         variations_form.on('found_variation', function (event, variation) {
//             if( variation.image.src ) {
//                 firstImage.setAttribute('src', variation.image.src);
//                 imagePopupSrc.setAttribute('data-src', variation.image.full_src);
//                 if (swiper_thumbs) {
//                     firstThumb.setAttribute('src', variation.image.gallery_thumbnail_src);
//                 }

//                 swiper_images.slideTo(0);
//             }
//         });

//         variations_form.on( 'reset_image', function() {
//             firstImage.setAttribute('src', firstImageSrc);
//             imagePopupSrc.setAttribute('data-src', dataLargeImage);
//             if (swiper_thumbs) {
//                 firstThumb.setAttribute('src', firstThumbSrc);
//             }

//             swiper_images.slideTo(0);
//         });

//         /** */
//         //const reset_variations = $( '.reset_variations' );
//         //reset_variations.on( 'click', function() {});
//     }
// });
//------------------------------------

jQuery(($) => {
    // replaceState
    // let url = new URL(window.location.href);
    // if (url.searchParams.has('added')) {
    //     url.searchParams.delete('added');
    //     window.history.replaceState(null, '', url.toString());
    // }

    //...
    const onload_events = () => {};

    onload_events();
    $(window).on('load', () => {
        onload_events();
    });
    device.onChangeOrientation(() => {
        onload_events();
    });
});

//------------------------------------

/** DOMContentLoaded */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('a._blank, a.blank, a[target="_blank"]').forEach((el) => {
        if (!el.hasAttribute('target') || el.getAttribute('target') !== '_blank') {
            el.setAttribute('target', '_blank');
        }

        const relValue = el.getAttribute('rel');
        if (!relValue || !relValue.includes('noopener') || !relValue.includes('nofollow')) {
            const newRelValue = (relValue ? relValue + ' ' : '') + 'noopener nofollow';
            el.setAttribute('rel', newRelValue);
        }
    });

    // javascript disable right click
    //document.addEventListener('contextmenu', event => event.preventDefault());
    // document.addEventListener('contextmenu', function (event) {
    //     if (event.target.nodeName === 'IMG') {
    //         event.preventDefault();
    //     }
    // });

    /** remove style img tag */
    document.querySelectorAll('img').forEach((el) => el.removeAttribute('style'));
});

//------------------------------------

/** vars */
const getParameters = (URL) =>
    JSON.parse('{"' + decodeURI(URL.split('?')[1]).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g, '":"') + '"}');

//------------------------------------

/**
 * @param el
 * @returns {*|jQuery}
 */
function rand_element_init(el) {
    const $el = $(el);
    const _rand = nanoid(9);
    $el.addClass(_rand);

    let _id = $el.attr('id');
    if (!_id) {
        _id = _rand;
        $el.attr('id', _id);
    }

    return _id;
}

/**
 * @param url
 * @param $delay
 */
function redirect(url = null, $delay = 10) {
    setTimeout(function () {
        if (url === null || url === '' || typeof url === 'undefined') {
            document.location.assign(window.location.href);
        } else {
            url = url.replace(/\s+/g, '');
            document.location.assign(url);
        }
    }, $delay);
}
//== js xu ly thay doi gia sp bien the
jQuery(document).ready(function () {
    jQuery(".section.product .product-details .summary.entry-summary form.cart .variations tbody .label label").text("CHỌN LOẠI SẢN PHẨM BẠN MUỐN MUA");
    jQuery(".variable-items-wrapper.button-variable-items-wrapper .variable-item.button-variable-item").click(function () {
        var $this = jQuery(this);
        setTimeout(function() {
            // var thumbVaridation = $this.closest(".product-details").find(".woocommerce-product-gallery__wrapper.wpg__thumbs .swiper-thumbs-first.swiper-slide-active .wpg__thumb").attr('data-thumb');
            // $this.closest(".product-details").find(".woocommerce-product-gallery__wrapper.wpg__thumbs .swiper-thumbs-first.swiper-slide-active .wpg__thumb img").attr('src', thumbVaridation);
            var priceVari = $this.closest("form.variations_form.cart").find(".single_variation_wrap .woocommerce-variation-price ins bdi").text();
            var priceChange = $this.closest(".summary.entry-summary").find(".variation-price .sale b");
            priceChange.text(priceVari);
        }, 400);
    });
});
//== js xu ly countdown flash-sale
jQuery(document).ready(function($) {
    var $countdown = jQuery('.countdown');
    const dateNow = new Date();
    const currentDate = dateNow.toLocaleDateString('vi-VN', {
        day: '2-digit',
        month: '2-digit', 
        year: 'numeric'
    });
    const currentTime = dateNow.toLocaleTimeString();
    // console.log(currentDate);
    // console.log(currentTime);
    if ($countdown.length) {
        var endDateStr = $countdown.data('end-date'); 
        var endTimeStr = $countdown.data('end-time');
        // console.log(endDateStr);
        // console.log(endTimeStr);
        var dateParts = endDateStr.split('/');
        var isoFormatdDate = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0]; 
        //console.log(isoFormatdDate);
        var isoFormattedDate = isoFormatdDate + 'T' + endTimeStr;
        var endDate = new Date(isoFormattedDate).getTime();
        //console.log(endDate);
        // console.log(endDate);
        var isoFormattedDate = isoFormatdDate + 'T' + endTimeStr;
        var endDate = new Date(isoFormattedDate).getTime();
        // console.log(endDate);
        var countdownInterval = setInterval(function() {
            var now = new Date().getTime();
            var timeLeft = endDate - now;
            if (timeLeft > 0) {
                var days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                // Định dạng với số 0 trước nếu là số có một chữ số
                days = days < 10 ? '0' + days : days;
                hours = hours < 10 ? '0' + hours : hours;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;
                if (parseInt(days) < 1) {
                    $countdown.find('.day').closest('.countdown-item').hide();
                }
                // Hiển thị thời gian đếm ngược
                $countdown.find('.day').text(days);
                $countdown.find('.hour').text(hours);
                $countdown.find('.minute').text(minutes);
                $countdown.find('.second').text(seconds);
            } else {
                $countdown.html('Hết thời gian!');
                clearInterval(countdownInterval);
                jQuery(".flash-sale-section, .flashsale-single").remove();
                // if (currentDate > endDateStr && currentTime > endTimeStr) {
                // }
            }
        }, 1000);
    }
});
//== js xu ly btn mua ngay
jQuery(document).ready(function(){
    jQuery('.is_buy_now').val('0');
    jQuery('body').on('click', '.buy_now_button', function(e){
        e.preventDefault();
        var thisParent = jQuery(this).parents('form.cart');
        if(jQuery('.single_add_to_cart_button', thisParent).hasClass('disabled')) {
            jQuery('.single_add_to_cart_button', thisParent).trigger('click');
            return false;
        }
        thisParent.addClass('btn-buynow');
        jQuery('.is_buy_now', thisParent).val('1');
        jQuery('.single_add_to_cart_button', thisParent).trigger('click');
    });
});
jQuery( document.body ).on( 'added_to_cart', function (e, fragments, cart_hash, addToCartButton){
    let thisForm  = addToCartButton.closest('.cart');
    let is_buy_now = parseInt(jQuery('.is_buy_now', thisForm).val()) || 0;
    if(is_buy_now === 1 && typeof wc_add_to_cart_params !== "undefined") {
        window.location = wc_add_to_cart_params.cart_url;
    }
});
//== js them nut rut gon trong chi tiet san pham
jQuery(document).ready(function () {
    var description = jQuery('.woocommerce-Tabs-panel--description.entry-content');
    var heightDescription = description.height();
    if (heightDescription > 1000) {
        description.after('<a href="javascript:void(0)" id="btn-more-content">Xem thêm nội dung sản phẩm</a>');
    }
    jQuery('#btn-more-content').click(function () {
        jQuery(this).toggleClass('active');
        description.toggleClass('expanded');
        if (description.hasClass('expanded')) {
            jQuery(this).text('Thu gọn nội dung');
        } else {
            jQuery(this).text('Xem thêm nội dung sản phẩm');
        }
    });
    // remove swiper slide img video
    if (jQuery('.custom-swiper-first').length) {
        jQuery('.custom-swiper-first .wpg__image').first().remove();
    }
    // click cta btn
    jQuery('.btn-cta.has-popup, .contact-product .item').click(function (e) {
        e.preventDefault();
        jQuery('.cta-detail').removeClass('show');
        var attrButton = jQuery(this).attr('data-attr');
        jQuery('.' + attrButton).addClass('show');
        jQuery('.modal-popup').addClass('show');
    });
    jQuery('.modal-popup .bg').click(function () {
        jQuery('.modal-popup').removeClass('show');
    });

});