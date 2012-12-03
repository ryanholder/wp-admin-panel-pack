(function ($) {

    "use strict";

    $(function () {

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