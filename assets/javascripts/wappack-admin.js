(function ($) {

    "use strict";

    $(function () {

        // Disable certain links in docs
        $('.wp-menu-image a').click(function (e) {
            e.preventDefault();
            $('.wp-has-current-submenu-preloaded').removeClass('wp-has-current-submenu-preloaded');
            $('.wp-has-current-submenu').addClass('wp-has-current-submenu-loaded');
            $(this).parents('li.menu-top').addClass('wp-has-current-submenu-preloaded');
        });

        // tooltip demo
        $('#adminmenu').children('.menu-top').tooltip({
            title:function () {

                $(this).find('span > span').removeClass().addClass('badge'); //TODO concerned the span > span might not always be true, need better solution
                var title = $(this).children('.menu-top').html();
                return title;
            },
            placement:'right',
            html:'true'

        });

    });

}(jQuery));