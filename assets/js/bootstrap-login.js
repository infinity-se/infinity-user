(function($)
{
    var
    properties = {
        currentSlide: null,
        deferred: {},
        downloaded: {},
        fadeDuration: 'slow',
        form: null,
        padding: 0
    },
    methods = {
        init: function()
        {
            // Set up properties
            properties.form = $('.form-signin');
            properties.currentSlide = $('form', properties.form);
            properties.padding = properties.form.height() - properties.currentSlide.height();
            
            // Set state
            var location = properties.currentSlide.attr('action');
            properties.downloaded[location] = properties.currentSlide;
            methods.updateState(properties.currentSlide.children('.form-signin-heading').text(), location);
            methods.setState();
            
            // Assign click events
            properties.form.on('click', '.form-links', methods.click);
        },
        click: function(event)
        {
            var target = $(event.target),
            // Get new location
            title = target.text(),
            location = target.attr('href');
    
            // Update state
            methods.updateState(title, location);
            
            // Perform ajax request
            methods.makeRequest(location);
            
            // Prevent standard click
            return false;
        },
        fadeIn: function()
        {
            properties.form.animate({
                height: properties.currentSlide.height() + properties.padding
            }, function()
            {
               properties.currentSlide.fadeIn(properties.fadeDuration);
            });
        },
        fadeOut: function()
        {
            properties.form.height(properties.form.height());
            return properties.currentSlide.fadeOut(properties.fadeDuration);
        },
        makeRequest: function(location)
        {
            if (typeof properties.downloaded[location] === 'undefined') {
                properties.deferred.fadeOut = methods.fadeOut();
                $.ajax({
                    dataType: 'html',
                    error: methods.ajaxError,
                    success: methods.changeSlide,
                    type: 'GET',
                    url: location
                });
            } else {
                if (properties.currentSlide.attr('action') !== location) {
                    properties.deferred.fadeOut = methods.fadeOut();
                    methods.changeSlide(properties.downloaded[location]);
                }
            }
        },
        changeSlide: function(data, status)
        {
            var slide = $(data);
            slide.hide();
            if (status === 'success') {
                properties.downloaded[slide.attr('action')] = slide;
            }
            properties.currentSlide = slide;
            $.when(properties.deferred.fadeOut).done(function()
            {
                if (status === 'success') {
                    properties.form.append(slide);
                }
                methods.fadeIn();
            });
        },
        ajaxError: function(xhr, status, error)
        {
            // Throw error
            var markup = [
                '<div class="alert alert-block alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><h4 class="alert-heading">Error: ',
                status,
                '</h4><p>',
                error,
                '</p>'
            ].join('');
            $('.form-signin-heading', properties.form).after(markup);
            methods.fadeIn();
        },
        updateState: function(title, location)
        {
            if (typeof window.history.pushState === 'undefined') {
                window.location.href = location;
            }
            window.history.pushState(location, title, location);
        },
        setState: function()
        {
            if (typeof window.onpopstate !== 'undefined') {
                window.onpopstate = methods.changeState;
            }
        },
        changeState: function(event)
        {
            if (event.state !== null) {
                methods.makeRequest(event.state);
            }
        }
    };
    
    $(document).ready(function()
    {
        methods.init();
    });
})(jQuery);