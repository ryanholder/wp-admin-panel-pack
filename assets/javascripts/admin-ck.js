(function(e) {
    "use strict";
    e(function() {
        e("#adminmenu").children(".menu-top").tooltip({
            title: function() {
                e(this).find("span.pending-count").removeClass("pending-count").addClass("badge");
                var t = e(this).children(".menu-top").html();
                return t;
            },
            trigger: "click",
            placement: "right",
            html: "true"
        });
    });
})(jQuery);