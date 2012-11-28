(function ($) {

    "use strict";

    $(function () {

        // tooltip demo
        $('#adminmenu').children('.menu-top').tooltip({
            title:function () {

                $(this).find('span.pending-count').removeClass('pending-count').addClass('badge');
                var title = $(this).children('.menu-top').html(); //TODO add badge class to the inner span
                return title;
            },
            trigger: 'click',
            placement: 'right',
            html: 'true'

        });

    });

}(jQuery));