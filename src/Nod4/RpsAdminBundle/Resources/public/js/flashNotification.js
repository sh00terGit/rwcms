/*
ВСПЛЫВАЮЩИЕ FLASHMESSAGES

Пример использования вьюха

{% block javascripts %}

    {{ parent() }}
    {% javascripts  '@RpsAdminBundle/Resources/public/js/flashNotification.js'
    %}
 <script src="{{ asset_url }}"></script>

    {% endjavascripts  %}

{% block entity_content %}

   <p> {{ include('RpsAdminBundle:form:flashMessages.html.twig') }}</p>

   {% endblock %}



Контроллер

 $this->get('session')->getFlashBag()->add(
                'success',$formname.' cохранено успешно'
            );


*/





(function($) {
    var methods = {
        init: function(options) {
            methods.settings = $.extend({}, $.fn.flashNotification.defaults, options);

            setTimeout(
                function() {
                    $('.alert')
                        .show('slow')
                        .delay(methods.settings.hideDelay)
                        .hide('fast')
                    ;
                },
                500
            );

            methods.listenIncomingMessages();
        },

        /**
         * Listen to AJAX responses and display messages if they contain some
         */
        listenIncomingMessages: function() {
            $(document).ajaxComplete(function(event, xhr, settings) {
                var data = $.parseJSON(xhr.responseText);

                if (data.messages) {
                    var messages = data.messages;

                    var i;

                    if (messages.error) {
                        for (i = 0; i < messages.error.length; i++) {
                            methods.addError(messages.error[i]);
                        }
                    }

                    if (messages.success) {
                        for (i = 0; i < messages.success.length; i++) {
                            methods.addSuccess(messages.success[i]);
                        }
                    }

                    if (messages.info) {
                        for (i = 0; i < messages.info.length; i++) {
                            methods.addInfo(messages.info[i]);
                        }
                    }
                }
            });
        },

        addSuccess: function(message) {
            var flashMessageElt = methods.getBasicFlash(message).addClass('alert-success');
            console.log('added success');
            methods.addToList(flashMessageElt);
            methods.display(flashMessageElt);
        },

        addError: function(message) {
            var flashMessageElt = methods.getBasicFlash(message).addClass('alert alert-error');

            methods.addToList(flashMessageElt);
            methods.display(flashMessageElt);
        },

        addInfo: function(message) {
            var flashMessageElt = methods.getBasicFlash(message).addClass('alert-info');

            methods.addToList(flashMessageElt);
            methods.display(flashMessageElt);
        },

        getBasicFlash: function(message) {
            var flashMessageElt = $('<div></div>')
                .hide()
                .addClass('alert')
                .append(methods.getCloseButton())
                .append($('<div></div>').html(message))
            ;

            return flashMessageElt;
        },

        getCloseButton: function() {
            var closeButtonElt = $('<button></button>')
                .addClass('close')
                .attr('data-dismiss', 'alert')
                .html('&times')
            ;

            return closeButtonElt;
        },

        addToList: function(flashMessageElt) {
            flashMessageElt.appendTo($('#flash-messages'));
        },

        display: function(flashMessageElt) {
            setTimeout(
                function() {
                    flashMessageElt
                        .show('slow')
                        .delay(methods.settings.hideDelay)
                        .hide('fast', function() { $(this).remove(); } )
                    ;
                },
                500
            );
        }
    };

    $.fn.flashNotification = function(method) {
        // Method calling logic
        if (methods[method]) {
            return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || ! method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' +  method + ' does not exist on jQuery.flashNotification');
        }
    };

    $.fn.flashNotification.defaults = {
        'hideDelay'         : 3000,
        'autoHide'          : false,
        'animate'           : true
    };
})(jQuery);


$('#flash-messages').flashNotification('init');
