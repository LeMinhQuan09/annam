/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./wp-content/plugins/hd-addons/resources/js/custom_order.js":
/*!*******************************************************************!*\
  !*** ./wp-content/plugins/hd-addons/resources/js/custom_order.js ***!
  \*******************************************************************/
/***/ (function() {

jQuery(function ($) {
  $('table.widefat tbody th, table.widefat tbody td').css('cursor', 'move');
  var _helper = function _helper(event, ui) {
    ui.each(function () {
      $(this).width($(this).width());
    });
    return ui;
  };
  var _start = function _start(event, ui) {
    ui.item.css('background-color', '#ffffff');
    ui.item.children('td, th').css('border-bottom-width', '0');
    ui.item.css('outline', '1px solid #dfdfdf');
  };
  var _stop = function _stop(event, ui) {
    ui.item.removeAttr('style');
    ui.item.children('td,th').css('border-bottom-width', '1px');
  };
  var _sort = function _sort(e, ui) {
    ui.placeholder.find('td').each(function (key, value) {
      if (ui.helper.find('td').eq(key).is(':visible')) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  };

  // pages, posts
  $('table.posts #the-list, table.pages #the-list').sortable({
    items: 'tr:not(.inline-edit-row)',
    cursor: 'move',
    axis: 'y',
    containment: 'table.widefat',
    scrollSensitivity: 40,
    helper: _helper,
    start: _start,
    stop: _stop,
    update: function update(event, ui) {
      $('table.widefat tbody th, table.widefat tbody td').css('cursor', 'default');
      $('table.widefat tbody').sortable('disable');

      // Show Spinner
      ui.item.find('.check-column input').hide().after('<img alt="processing" src="images/wpspin_light.gif" class="waiting" style="margin-left: 6px;" />');

      // sorting via ajax
      $.post(ajaxurl, {
        action: 'update-menu-order',
        order: $('#the-list').sortable('serialize')
      }, function (response) {
        ui.item.find('.check-column input').show().siblings('img').remove();
        $('table.widefat tbody th, table.widefat tbody td').css('cursor', 'move');
        $('table.widefat tbody').sortable('enable');
      });

      // fix cell colors
      $('table.widefat tbody tr').each(function () {
        var i = $('table.widefat tbody tr').index(this);
        if (i % 2 === 0) {
          $(this).addClass('alternate');
        } else {
          $(this).removeClass('alternate');
        }
      });
    },
    sort: _sort
  });

  // tags
  $('table.tags #the-list').sortable({
    items: 'tr:not(.inline-edit-row)',
    cursor: 'move',
    axis: 'y',
    containment: 'table.widefat',
    scrollSensitivity: 40,
    helper: _helper,
    start: _start,
    stop: _stop,
    update: function update(event, ui) {
      $('table.widefat tbody th, table.widefat tbody td').css('cursor', 'default');
      $('table.widefat tbody').sortable('disable');

      // Show Spinner
      ui.item.find('.check-column input').hide().after('<img alt="processing" src="images/wpspin_light.gif" class="waiting" style="margin-left: 6px;" />');

      // sorting via ajax
      $.post(ajaxurl, {
        action: 'update-menu-order-tags',
        order: $('#the-list').sortable('serialize')
      }, function (response) {
        ui.item.find('.check-column input').show().siblings('img').remove();
        $('table.widefat tbody th, table.widefat tbody td').css('cursor', 'move');
        $('table.widefat tbody').sortable('enable');
      });

      // fix cell colors
      $('table.widefat tbody tr').each(function () {
        var i = $('table.widefat tbody tr').index(this);
        if (i % 2 === 0) {
          $(this).addClass('alternate');
        } else {
          $(this).removeClass('alternate');
        }
      });
    },
    sort: _sort
  });
});

/***/ }),

/***/ "./wp-content/themes/hd/resources/sass/fonts.scss":
/*!********************************************************!*\
  !*** ./wp-content/themes/hd/resources/sass/fonts.scss ***!
  \********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./wp-content/themes/hd/resources/sass/plugins.scss":
/*!**********************************************************!*\
  !*** ./wp-content/themes/hd/resources/sass/plugins.scss ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./wp-content/themes/hd/resources/sass/app.scss":
/*!******************************************************!*\
  !*** ./wp-content/themes/hd/resources/sass/app.scss ***!
  \******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./wp-content/plugins/hd-addons/resources/sass/editor-style.scss":
/*!***********************************************************************!*\
  !*** ./wp-content/plugins/hd-addons/resources/sass/editor-style.scss ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./wp-content/themes/hd/resources/sass/admin.scss":
/*!********************************************************!*\
  !*** ./wp-content/themes/hd/resources/sass/admin.scss ***!
  \********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./wp-content/themes/hd/resources/sass/plugins/swiper.scss":
/*!*****************************************************************!*\
  !*** ./wp-content/themes/hd/resources/sass/plugins/swiper.scss ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./wp-content/themes/hd/resources/sass/plugins/woocommerce.scss":
/*!**********************************************************************!*\
  !*** ./wp-content/themes/hd/resources/sass/plugins/woocommerce.scss ***!
  \**********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./wp-content/themes/hd/resources/sass/plugins/elementor.scss":
/*!********************************************************************!*\
  !*** ./wp-content/themes/hd/resources/sass/plugins/elementor.scss ***!
  \********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	!function() {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = function(result, chunkIds, fn, priority) {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every(function(key) { return __webpack_require__.O[key](chunkIds[j]); })) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	!function() {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/wp-content/plugins/hd-addons/assets/js/custom_order": 0,
/******/ 			"wp-content/themes/hd/assets/css/plugins": 0,
/******/ 			"wp-content/themes/hd/assets/css/plugins/elementor": 0,
/******/ 			"wp-content/themes/hd/assets/css/plugins/woocommerce": 0,
/******/ 			"wp-content/themes/hd/assets/css/plugins/swiper": 0,
/******/ 			"wp-content/themes/hd/assets/css/admin": 0,
/******/ 			"wp-content/plugins/hd-addons/assets/css/editor-style": 0,
/******/ 			"wp-content/themes/hd/assets/css/app": 0,
/******/ 			"wp-content/themes/hd/assets/css/fonts": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = function(chunkId) { return installedChunks[chunkId] === 0; };
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = function(parentChunkLoadingFunction, data) {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some(function(id) { return installedChunks[id] !== 0; })) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkhd"] = self["webpackChunkhd"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["wp-content/themes/hd/assets/css/plugins","wp-content/themes/hd/assets/css/plugins/elementor","wp-content/themes/hd/assets/css/plugins/woocommerce","wp-content/themes/hd/assets/css/plugins/swiper","wp-content/themes/hd/assets/css/admin","wp-content/plugins/hd-addons/assets/css/editor-style","wp-content/themes/hd/assets/css/app","wp-content/themes/hd/assets/css/fonts"], function() { return __webpack_require__("./wp-content/plugins/hd-addons/resources/js/custom_order.js"); })
/******/ 	__webpack_require__.O(undefined, ["wp-content/themes/hd/assets/css/plugins","wp-content/themes/hd/assets/css/plugins/elementor","wp-content/themes/hd/assets/css/plugins/woocommerce","wp-content/themes/hd/assets/css/plugins/swiper","wp-content/themes/hd/assets/css/admin","wp-content/plugins/hd-addons/assets/css/editor-style","wp-content/themes/hd/assets/css/app","wp-content/themes/hd/assets/css/fonts"], function() { return __webpack_require__("./wp-content/plugins/hd-addons/resources/sass/editor-style.scss"); })
/******/ 	__webpack_require__.O(undefined, ["wp-content/themes/hd/assets/css/plugins","wp-content/themes/hd/assets/css/plugins/elementor","wp-content/themes/hd/assets/css/plugins/woocommerce","wp-content/themes/hd/assets/css/plugins/swiper","wp-content/themes/hd/assets/css/admin","wp-content/plugins/hd-addons/assets/css/editor-style","wp-content/themes/hd/assets/css/app","wp-content/themes/hd/assets/css/fonts"], function() { return __webpack_require__("./wp-content/themes/hd/resources/sass/admin.scss"); })
/******/ 	__webpack_require__.O(undefined, ["wp-content/themes/hd/assets/css/plugins","wp-content/themes/hd/assets/css/plugins/elementor","wp-content/themes/hd/assets/css/plugins/woocommerce","wp-content/themes/hd/assets/css/plugins/swiper","wp-content/themes/hd/assets/css/admin","wp-content/plugins/hd-addons/assets/css/editor-style","wp-content/themes/hd/assets/css/app","wp-content/themes/hd/assets/css/fonts"], function() { return __webpack_require__("./wp-content/themes/hd/resources/sass/plugins/swiper.scss"); })
/******/ 	__webpack_require__.O(undefined, ["wp-content/themes/hd/assets/css/plugins","wp-content/themes/hd/assets/css/plugins/elementor","wp-content/themes/hd/assets/css/plugins/woocommerce","wp-content/themes/hd/assets/css/plugins/swiper","wp-content/themes/hd/assets/css/admin","wp-content/plugins/hd-addons/assets/css/editor-style","wp-content/themes/hd/assets/css/app","wp-content/themes/hd/assets/css/fonts"], function() { return __webpack_require__("./wp-content/themes/hd/resources/sass/plugins/woocommerce.scss"); })
/******/ 	__webpack_require__.O(undefined, ["wp-content/themes/hd/assets/css/plugins","wp-content/themes/hd/assets/css/plugins/elementor","wp-content/themes/hd/assets/css/plugins/woocommerce","wp-content/themes/hd/assets/css/plugins/swiper","wp-content/themes/hd/assets/css/admin","wp-content/plugins/hd-addons/assets/css/editor-style","wp-content/themes/hd/assets/css/app","wp-content/themes/hd/assets/css/fonts"], function() { return __webpack_require__("./wp-content/themes/hd/resources/sass/plugins/elementor.scss"); })
/******/ 	__webpack_require__.O(undefined, ["wp-content/themes/hd/assets/css/plugins","wp-content/themes/hd/assets/css/plugins/elementor","wp-content/themes/hd/assets/css/plugins/woocommerce","wp-content/themes/hd/assets/css/plugins/swiper","wp-content/themes/hd/assets/css/admin","wp-content/plugins/hd-addons/assets/css/editor-style","wp-content/themes/hd/assets/css/app","wp-content/themes/hd/assets/css/fonts"], function() { return __webpack_require__("./wp-content/themes/hd/resources/sass/fonts.scss"); })
/******/ 	__webpack_require__.O(undefined, ["wp-content/themes/hd/assets/css/plugins","wp-content/themes/hd/assets/css/plugins/elementor","wp-content/themes/hd/assets/css/plugins/woocommerce","wp-content/themes/hd/assets/css/plugins/swiper","wp-content/themes/hd/assets/css/admin","wp-content/plugins/hd-addons/assets/css/editor-style","wp-content/themes/hd/assets/css/app","wp-content/themes/hd/assets/css/fonts"], function() { return __webpack_require__("./wp-content/themes/hd/resources/sass/plugins.scss"); })
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["wp-content/themes/hd/assets/css/plugins","wp-content/themes/hd/assets/css/plugins/elementor","wp-content/themes/hd/assets/css/plugins/woocommerce","wp-content/themes/hd/assets/css/plugins/swiper","wp-content/themes/hd/assets/css/admin","wp-content/plugins/hd-addons/assets/css/editor-style","wp-content/themes/hd/assets/css/app","wp-content/themes/hd/assets/css/fonts"], function() { return __webpack_require__("./wp-content/themes/hd/resources/sass/app.scss"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=custom_order.js.map