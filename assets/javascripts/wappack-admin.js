(function ($) {

    "use strict";

    $(function () {

        $('.menu-top > .wp-menu-image').tooltip({
            title:function () {
                $(this).find('span > span').removeClass().addClass('badge'); //TODO concerned the span > span might not always be true, need better solution
                var title = $(this).siblings('.menu-top').html();
                return title;
            },
            placement:'right',
            html:'true'

        });

    });

}(jQuery));