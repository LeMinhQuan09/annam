/******/ (function() { // webpackBootstrap
/*!******************************************************************!*\
  !*** ./wp-content/themes/hd/resources/js/plugins/woocommerce.js ***!
  \******************************************************************/
jQuery(function ($) {
  /** */
  var wpg__image = $('.wpg__image');
  wpg__image.find('a').on('click', function (e) {
    e.preventDefault();
    $(this).next('.image-popup').trigger('click');
  });

  /** */
  var wpg__thumb = $('.wpg__thumb');
  wpg__thumb.find('a').on('click', function (e) {
    e.preventDefault();
  });
});
// js button quanlity
jQuery(document).ready(function () {
  jQuery('.quantity').on('click', '.plus', function (e) {
    jQueryinput = jQuery(this).prev('input.qty');
    var val = parseInt(jQueryinput.val());
    jQueryinput.val(val + 1).change();
  });
  jQuery('.quantity').on('click', '.minus', function (e) {
    jQueryinput = jQuery(this).next('input.qty');
    var val = parseInt(jQueryinput.val());
    if (val > 0) {
      jQueryinput.val(val - 1).change();
    }
  });
});
jQuery(document).ajaxComplete(function () {
  jQuery('.quantity').off('click', '.plus').on('click', '.plus', function (e) {
    jQueryinput = jQuery(this).prev('input.qty');
    var val = parseInt(jQueryinput.val());
    jQueryinput.val(val + 1).change();
  });
  jQuery('.quantity').off('click', '.minus').on('click', '.minus', function (e) {
    jQueryinput = jQuery(this).next('input.qty');
    var val = parseInt(jQueryinput.val());
    if (val > 1) {
      jQueryinput.val(val - 1).change();
    }
  });
});
/******/ })()
;
//# sourceMappingURL=woocommerce.js.map