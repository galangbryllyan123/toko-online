$(document).ready(function() {

    $(".js-messenger-form").on('submit', function(e) {
        $(this).find("input[type=submit]").prop('disabled', true);
    });

    // Ajax to load previous message.
    var mmessengerp             = 1,
        $loader                 = $(".js-thread-loader"),
        $threadMessages         = $(".js-thread-messages"),
        $threadErrorMessage     = $(".js-thread-error-message"),
        $threadNoMoreMessage    = $(".js-thread-no-more-message"),
        dataHasMore             = $threadMessages.data("has-more"),
        dataUrl                 = $threadMessages.data("url"),
        dataNumberPerPage       = $threadMessages.data("number-per-page"),
        dataTemplateUrl         = $threadMessages.data("template-url"),
        dataThreadId            = $threadMessages.data("thread-id"),
        threadSecret            = $(".js-messenger-form").find('input[name="secret"]').val(),
        userEmail               = $(".js-messenger-form").find('input[name="email"]').val(),
        dataContentRead         = $threadMessages.data("content-read"),
        dataContentDelete       = $threadMessages.data("content-delete"),
        dataContentDeleteAction = $threadMessages.data("content-delete-action"),
        running                 = false,
        threadMessagesHeight    = getThreadMessagesHeight(),
        template                = twig({
            id: "message", // id is optional, but useful for referencing the template later
            href: dataTemplateUrl,
            async: false
        });

    $(window).scroll(function() {
        if($(window).scrollTop()+$(window).height() >= threadMessagesHeight && !running)
        {
            loadMessages();
        }
    });

    function getThreadMessagesHeight() {
        return Math.round($threadMessages.offset().top + $threadMessages.outerHeight(true));
    }

	function loadMessages() {
        if(dataHasMore) {
            running = true;
            $loader.show();

    		$.ajax({
    			type: "GET",
    			url: dataUrl,
    			data: {
    				"do": "more",
    				"n": dataNumberPerPage,
    				"p": mmessengerp + 1,
    				"tid": dataThreadId,
                    "secret": threadSecret,
                    "email": userEmail,
    			},
    			dataType: "json",
    			success: function(response, text, jqXHR) {

                    if (response.error) {
                        dataHasMore = false;
                        $threadErrorMessage.append(response.reason);
                        $loader.hide();
                        $threadErrorMessage.fadeIn();
                    } else {
                        var output = twig({ref:"message"}).render({
                            messages: response.data,
                            content: {
                                read: dataContentRead,
                                delete: dataContentDelete,
                                deleteAction: dataContentDeleteAction
                            }
                        });
                        output = output.replace(/[\u200B]/g, '');

                        $threadMessages.append(output);

                        // Is there more messages in this thread?
                        if(response.hasMore == false) {
                            dataHasMore = false;
                            $threadNoMoreMessage.fadeIn();
                        } else {
                            running = false;
                            threadMessagesHeight = getThreadMessagesHeight();
                        }
                        $loader.hide();
                        runAutoLlinker();
                        ++mmessengerp;
                    }
    			},
                error: function(xhr, ajaxOptions, thrownError) {
                    $loader.hide();
                    $threadNoMoreMessage.fadeIn();
                    dataHasMore = false;
                }
    		});
        }
    }


    $('.fancybox').fancybox({
        type        : 'image',
        beforeLoad : function() {
            this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
        }
    });


    function runAutoLlinker() {
        if ($('.js-thread-messages').length > 0) {
            $jsMessages = $('.js-thread-messages');

            if ($jsMessages.data('autolinker-enable') == '1') {
                var autolinker = new Autolinker(
                    {
                        newWindow: $jsMessages.data('autolinker-new-window'),
                        stripPrefix: $jsMessages.data('autolinker-strip-prefix'),
                        truncate: $jsMessages.data('autolinker-truncate-length'),
                        "phone": false,
                        "hashtag": "twitter"
                    }
                );

                $(".js-text").map(function(e) {
                    $(this).html(autolinker.link($(this).html()));
                });
            }
        }
    }
    runAutoLlinker();
});

$(document).ready(function(){

    var $threadTitleContainer      = $('.js-thread-title-container'),
        $threadTitleEdit       = $('.js-thread-title-edit'),
        $addAttachment       = $('.js-add-attachment'),
        $attachmentWrapper   = $('.js-attachment-wrapper'),
        $attachmentContainer = $('.js-attachment-container'),
        maxFile              = $attachmentWrapper.data('attachment-max'),
        template             = $attachmentWrapper.clone();


    $threadTitleEdit.on("click", function (e) {
        e.preventDefault();
        $threadTitleContainer.fadeToggle();
    });

    $addAttachment.on("click", function (e) {
        $attachmentContainer.fadeToggle();
    });

    $(document).on("change", '.js-attachment-file', function(){

        if ($(this).find('input[type="file"]').val() != "") {
            $(this).closest(".form-group").find('.js-remove-button').removeClass('hidden');
        }

        var n = $('.js-attachment-wrapper').length + 1;
        if(n > maxFile || $('.js-attachment-wrapper:last').find('input[type="file"]').val() == "") {
            return false;
        }

        $('.js-attachment-wrapper:last').after(template.clone());
    });

    $(document).on('click', '.js-remove-button', function(e){
        e.preventDefault();

        var n = $('.js-attachment-wrapper').length;

        if (n == maxFile && $('.js-attachment-wrapper:last').closest(".form-group").find('.js-attachment-file').val() != "") {
            $('.js-attachment-wrapper:last').after(template.clone());
        }

        if ($(this).closest(".form-group").find('.js-attachment-file').val() != "") {
            $(this).closest(".form-group").remove();
        }
    });

});