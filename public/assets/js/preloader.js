const preloader = class {

    constructor() {}

    static start(parent = 'body')
    {
        if ($(parent).find('.preloader-container').length) {
            return;
        }

        $(parent).css(
            {
                'position': 'relative',
            }
        );

        var container = document.createElement('div');

        container.className = 'preloader-container';

        $(parent).append(container);

        var preloader = document.createElement('div');

        preloader.className = 'preloader';

        $(container).append(preloader);

        for (var i = 0; i < 5; i++) {
            $(preloader).append('<span></span>');
        }

        $(container).css({
            'border-radius': $(parent).css('border-radius')
        });
    }

    static stop(parent = 'body')
    {
        $(parent).find('.preloader-container').remove();
    }
}
