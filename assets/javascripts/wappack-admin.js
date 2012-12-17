(function ($) {

    "use strict";

    $(function () {

        $('a.menu-top > .wp-menu-image').tooltip({
            title:function () {
                $(this).siblings('.wp-menu-name').find('span > span').removeClass().addClass('badge');
                var title = $(this).siblings('.wp-menu-name').html();
                return title;
            },
            placement:'right',
            html:'true'

        });
        
    });

}(jQuery));
