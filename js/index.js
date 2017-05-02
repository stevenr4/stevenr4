




















$(document).ready(function(){
    $(document).on('scroll', function(event) {

        // Activates elements that were waiting to be scrolled onto
        $(".awaiting-scroll").each(function(){
            var viewBottom = $(window).scrollTop() + $(window).height();
            var elemTop = $(this).offset().top;
            if ((viewBottom - 100) > elemTop) {
                $(this).removeClass('awaiting-scroll');
                $(this).addClass('active');
                doTheThing(this);
            }
        });

        // Handles the header to allow it to follow when needed.
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

        var lastSegment = "about";
        var segments = $(".segment");
        for (var i = 0; i < segments.length; i++) {
            var headerBottom = $('#following-header').offset().top + $('#following-header').outerHeight();
            if ($(segments[i]).offset().top < headerBottom + 40) {
                lastSegment = $(segments[i]).attr('id');
            } else {
                break;
            }
        }
        $(".navbar-item").removeClass("active");
        $("#navbar-item-" + lastSegment).addClass("active");
    });

    function doTheThing(elem) {
        if (elem.hasAttribute("data-set-width")) {
            $(elem).css("width", $(elem).attr("data-set-width"));
        }
        if (elem.hasAttribute("data-show-when-scrolled")) {

        }
    }

    $(".navbar-item").click(function(){
        $(".navbar-item").removeClass("active");
        $(this).addClass("active");
        EPPZScrollTo.scrollVerticalToElementById($(this).attr("data-element-id"), $('#following-header').outerHeight() + 20);
    });




    // Form stuff here!
    $("#contact-submit").click(function(e){
        // Once it's being submitted, lock the inputs
        $("#contact-form :input").prop('disabled', true).css('cursor', 'wait');

        // Collect together the formData
        var formData = {
            'email': $("#email").val(),
            'name': $("#name").val(),
            'phone': $("#phone").val(),
            'message': $("#message").val()
        };

        // Don't let the form do the normal thing
        e.preventDefault();

        console.log(formData);

        // Post the information to the website
        $.post("/email.php", formData, function(returnedData) {
            console.log(returnedData);
            if (returnedData['success'] === "false") {

                var message = "There was a problem handling your contact request.\nReason: ";
                if (returnedData['reason']) {
                    message += returnedData['reason'];
                } else {
                    message += 'Unknown Error';
                }
                alert("There was a problem handling your contact request.\nReason: " + returnedData['reason']);
                $("#contact-form :input").prop('disabled', false).css('cursor', '');
            } else {
                // TODO: Show successful contact message
            }
        }).fail(function(){
            console.log("FAILED");
        });

        // Also helps prevent the form from doing the normal thing.
        return false;
    });
});
















/**
 *
 * Created by Borbás Geri on 12/17/13
 * Copyright (c) 2013 eppz! development, LLC.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 */


var EPPZScrollTo =
{
    /**
     * Helpers.
     */
    documentVerticalScrollPosition: function()
    {
        if (self.pageYOffset) return self.pageYOffset; // Firefox, Chrome, Opera, Safari.
        if (document.documentElement && document.documentElement.scrollTop) return document.documentElement.scrollTop; // Internet Explorer 6 (standards mode).
        if (document.body.scrollTop) return document.body.scrollTop; // Internet Explorer 6, 7 and 8.
        return 0; // None of the above.
    },

    viewportHeight: function()
    { return (document.compatMode === "CSS1Compat") ? document.documentElement.clientHeight : document.body.clientHeight; },

    documentHeight: function()
    { return (document.height !== undefined) ? document.height : document.body.offsetHeight; },

    documentMaximumScrollPosition: function()
    { return this.documentHeight() - this.viewportHeight(); },

    elementVerticalClientPositionById: function(id)
    {
        var element = document.getElementById(id);
        var rectangle = element.getBoundingClientRect();
        return rectangle.top;
    },

    /**
     * Animation tick.
     */
    scrollVerticalTickToPosition: function(currentPosition, targetPosition)
    {
        var filter = 0.2;
        var fps = 60;
        var difference = parseFloat(targetPosition) - parseFloat(currentPosition);

        // Snap, then stop if arrived.
        var arrived = (Math.abs(difference) <= 0.5);
        if (arrived)
        {
            // Apply target.
            scrollTo(0.0, targetPosition);
            return;
        }

        // Filtered position.
        currentPosition = (parseFloat(currentPosition) * (1.0 - filter)) + (parseFloat(targetPosition) * filter);

        // Apply target.
        scrollTo(0.0, Math.round(currentPosition));

        // Schedule next tick.
        setTimeout("EPPZScrollTo.scrollVerticalTickToPosition("+currentPosition+", "+targetPosition+")", (1000 / fps));
    },

    /**
     * For public use.
     *
     * @param id The id of the element to scroll to.
     * @param padding Top padding to apply above element.
     */
    scrollVerticalToElementById: function(id, padding)
    {
        var element = document.getElementById(id);
        if (element === null)
        {
            console.warn('Cannot find element with id \''+id+'\'.');
            return;
        }

        var targetPosition = this.documentVerticalScrollPosition() + this.elementVerticalClientPositionById(id) - padding;
        var currentPosition = this.documentVerticalScrollPosition();

        // Clamp.
        var maximumScrollPosition = this.documentMaximumScrollPosition();
        if (targetPosition > maximumScrollPosition) targetPosition = maximumScrollPosition;

        // Start animation.
        this.scrollVerticalTickToPosition(currentPosition, targetPosition);
    }
};














