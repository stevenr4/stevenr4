




















$(document).ready(function(){
    $(document).on('scroll', function(event) {
        $(".awaiting-scroll").each(function(){
            var viewBottom = $(window).scrollTop() + $(window).height();
            var elemTop = $(this).offset().top;
            if ((viewBottom - 100) > elemTop) {
                $(this).removeClass('awaiting-scroll');
                doTheThing(this);
            }
        });

        var viewTop = $(window).scrollTop();
        var elemTop = $('#header-spacer').offset().top;
        $("#following-header").css('width', $('#header-spacer').width() + "px");
        if (viewTop <= elemTop) {
            $('#following-header').removeClass('active');
            $("#header-spacer").css('height', "0");
        } else {
            $('#following-header').addClass('active');
            $("#header-spacer").css('height', $('#following-header').outerHeight() + "px");
        }
    });

    function doTheThing(elem) {
        if (elem.hasAttribute("data-set-width")) {
            $(elem).css("width", $(elem).attr("data-set-width"));
        }
        if (elem.hasAttribute("data-show-when-scrolled")) {

        }
    }

    $('.experience-more').click(function(){
        console.log("CLICKED");
        if ('#experience-extra-hidden::visible') {
            $('.experience-more p').html("Hide Non-software Related Experience (-)");
        } else {
            $('.experience-more p').html("Show Non-software Related Experience (+)");
        }
        $('#experience-extra-hidden').slideToggle();
    });





    // Form stuff here!
    $("#contact-submit").click(function(e){
        e.preventDefault();

        return false;
    })
})































