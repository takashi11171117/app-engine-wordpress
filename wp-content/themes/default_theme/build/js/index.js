webpackJsonp([0],[
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _jquery = __webpack_require__(1);

var _jquery2 = _interopRequireDefault(_jquery);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var main = function main() {
    anchorScroll();
    toTopScroll();
};

var anchorScroll = function anchorScroll() {
    (0, _jquery2.default)(function ($) {
        $('a[href*=#]').click(function () {
            var target = $(this.hash);
            if (target) {
                var targetOffset = target.offset().top;
                $('html,body').animate({ scrollTop: targetOffset }, 800);
                return false;
            }
        });
    });
};

var toTopScroll = function toTopScroll() {
    (0, _jquery2.default)(function ($) {
        var topBtn = $('#page-top');
        topBtn.hide();
        //スクロールが100に達したらボタン表示
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                topBtn.fadeIn();
            } else {
                topBtn.fadeOut();
            }
        });
        //スクロールしてトップ
        topBtn.click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 500);
            return false;
        });
    });
};

main();

/***/ }),
/* 1 */
/***/ (function(module, exports) {

module.exports = jQuery;

/***/ })
],[0]);