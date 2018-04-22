import jQuery from 'jquery';

const main = () => {
    anchorScroll();
    toTopScroll();
}

const anchorScroll = () => {
    jQuery(($) => {
        $('a[href*=#]').click(function() {
            var target = $(this.hash);
            if (target) {
                var targetOffset = target.offset().top;
                $('html,body').animate({scrollTop: targetOffset},800);
                return false;
            }
        });
    })
}

const toTopScroll = () => {
    jQuery(($) => {
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
    })
}

main();
