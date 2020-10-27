(function ($) {

    "use strict";

    var fullHeight = function () {

        $('.js-fullheight').css('height', $(window).height());
        $(window).resize(function () {
            $('.js-fullheight').css('height', $(window).height());
        });

    };
    fullHeight();

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

    let activeLi = window.location.pathname.split('/');
    if (activeLi[1] == 'user')
        activeLi = activeLi[activeLi.length - 1]
    else
        activeLi = activeLi[1]

    document.getElementById(activeLi)?.classList.add('active')

})(jQuery);
