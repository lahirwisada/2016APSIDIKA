/* Simple JavaScript Inheritance
 * By John Resig http://ejohn.org/
 * MIT Licensed.
 */
// Inspired by base2 and Prototype
(function() {
    var initializing = false, fnTest = /xyz/.test(function() {
        xyz;
    }) ? /\b_super\b/ : /.*/;

    // The base Class implementation (does nothing)
    this.Class = function() {
    };

    // Create a new Class that inherits from this class
    Class.extend = function(prop) {
        var _super = this.prototype;

        // Instantiate a base class (but only create the instance,
        // don't run the init constructor)
        initializing = true;
        var prototype = new this();
        initializing = false;

        // Copy the properties over onto the new prototype
        for (var name in prop) {
            // Check if we're overwriting an existing function
            prototype[name] = typeof prop[name] == "function" &&
                    typeof _super[name] == "function" && fnTest.test(prop[name]) ?
                    (function(name, fn) {
                        return function() {
                            var tmp = this._super;

                            // Add a new ._super() method that is the same method
                            // but on the super-class
                            this._super = _super[name];

                            // The method only need to be bound temporarily, so we
                            // remove it when we're done executing
                            var ret = fn.apply(this, arguments);
                            this._super = tmp;

                            return ret;
                        };
                    })(name, prop[name]) :
                    prop[name];
        }

        // The dummy class constructor
        function Class() {
            // All construction is actually done in the init method
            if (!initializing && this.init)
                this.init.apply(this, arguments);
        }

        // Populate our constructed prototype object
        Class.prototype = prototype;

        // Enforce the constructor to be what we expect
        Class.prototype.constructor = Class;

        // And make this class extendable
        Class.extend = arguments.callee;

        return Class;
    };
})();

(function() {
    "use strict";

    /**
     * debouncing function from John Hann
     * http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
     */
    var debounce = function(func, threshold, execAsap) {
        var timeout;

        return function debounced() {
            var obj = this, args = arguments;
            function delayed() {
                if (!execAsap)
                    func.apply(obj, args);
                timeout = null;
            }
            ;

            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);

            timeout = setTimeout(delayed, threshold || 100);
        };
    };

    /**
     * Register smartresize plugin
     */
    $.fn['smartresize'] = function(fn) {
        return fn ? this.bind('resize', debounce(fn)) : this.trigger('smartresize');
    };

    /**
     * Base component class
     */
    var Component = Class.extend({
        defaultOptions: {},
        init: function(element, options) {
            this.element = element;
            this.options = $.extend({}, this.defaultOptions, options);
        }
    });

    /**
     * Portfolio component
     */
    var Portfolio = Component.extend({
        defaultOptions: {
            ajaxEnabled: true,
            ajaxContent: '.baris-konten.line-content-single-portfolio',
            ajaxContainer: '#line-load-ajax',
            filter: true,
            filterList: '.line-filter',
            gridColumns: 4,
            gridContainer: '.baris-konten-isotope',
            gridItems: '.entry',
            loadMore: true,
            loadMoreElement: 'a.load-more'
        },
        init: function(element, options) {
            this._super(element, options);

            this.container = $(this.options.gridContainer, this.element);
            this.filter = $(this.options.filterList, this.element);
            this.filterActive = $(this.options.filterList, this.element).find('a.selected');

            // Find ajax panel
            if (this.options.ajaxEnabled == true) {
                this.ajaxPanel = $(this.options.ajaxContainer, this.element);
            }

            $(window).on('load', $.proxy(this._initLayout, this));

            /**
             * Register events
             */
            if (this.options.filter == true) {
                this.filter.on('click', 'a', $.proxy(this._filterItems, this));
            }

            if (this.options.loadMore == true) {
                this.element.on('click', this.options.loadMoreElement, $.proxy(this._loadItems, this));
            }

            if (this.options.ajaxEnabled == true) {
                this.container.on('click', '.entry > a', $.proxy(this._loadAjaxContent, this));
                this.ajaxPanel.on('click', '.line-nav-prev, .line-nav-next', $.proxy(this._loadAjaxContent, this));
                this.ajaxPanel.on('click', '.line-nav-hide', $.proxy(this._closeAjaxBox, this));
            }
        },
        _filterItems: function(e) {
            e.preventDefault();

            if (this.filterActive.size() > 0) {
                this.filterActive.removeClass('selected');
            }

            this.filterActive = $(e.target);
            this.filterActive.addClass('selected');
            this.container.isotope({
                filter: this.filterActive.attr('data-filter')
            });
        },
        _loadItems: function(e) {
            e.preventDefault();

            var elm = $(e.target);
            if (elm.is('a') == false)
                elm = elm.closets('a');

            var href = elm.attr('href'),
                    container = this.container;

            // Set loading state
            var portfolio = this.element;
            portfolio.addClass('line-portfolio-loading');

            $.get(href, function(response) {
                var items = $('article', $(response)),
                        nextUrl = $('a.load-more', $(response));

                items.css('visibility', 'hidden');
                container.append(items);
                imagesLoaded(container.get(0), function() {
                    items.css('visibility', 'visible');
                    container.isotope('appended', items);

                    if (nextUrl.size() > 0)
                        elm.replaceWith(nextUrl);
                    else
                        elm.fadeOut();
                });
            });
        },
        _loadAjaxContent: function(e) {
            e.preventDefault();

            var elm = $(e.target),
                    contentSelector = this.options.ajaxContent,
                    panel = this.ajaxPanel;

            if (elm.is('a.a') == false) {
                elm = elm.closest('a');
            }

            if (!elm.hasClass('inprocess')) {
                elm.addClass('inprocess');
                panel.html('<center>Loading...</center>');
                panel.load(elm.attr('href') + '#line-portfolio-single', function() {
                    elm.removeClass('inprocess');
                    panel.slideDown(500);

                    panel.find('.flexslider').flexslider({
                        animation: 'fade',
                        slideshow: true,
                        controlNav: false,
                        prevText: '<i class="fa fa-angle-left"></i>',
                        nextText: '<i class="fa fa-angle-right"></i>',
                    });

                    $("html, body").animate({scrollTop: panel.offset().top}, 1000);
                });
            }
        },
        _closeAjaxBox: function(e) {
            e.preventDefault();

            this.ajaxPanel
                    .slideUp(500);
        },
        _initLayout: function() {
            this.container.isotope({
                filter: '*',
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false,
                }
            });

            this.container.isotope('on', 'layoutComplete', $.proxy(this._onLayoutComplete, this));
            this._onLayoutComplete();
        },
        _onLayoutComplete: function() {
            this.element.trigger('layoutComplete');
        }
    });


    var AjaxForm = Component.extend({
        init: function(element, options) {
            this._super(element, options);
            this.form = this.element;

            if (!this.form.is('form')) {
                this.form = this.element.closest('form');
            }

            this.form.validate({
                submitHandler: $.proxy(function() {
                    $.ajax(this.form.attr('action'), {
                        type: 'POST',
                        data: this.form.serializeArray(),
                        dataType: 'JSON',
                        beforeSend: $.proxy(function() {
                            this.form.find(':input').attr('disabled', 'disabled');
                            this.form.find('.line-alert').remove();
                            this.form.addClass('form-sending');
                        }, this),
                        success: $.proxy(function(response) {
                            this.form.prepend(
                                    $('<div />', {
                                        'class': 'line-alert ' + response.status,
                                        'text': response.content
                                    }).append(
                                    $('<a class="close" href="javascript:void(0)"><i class="fa fa-times"></i></a>')
                                    )
                                    );
                            this.form.find(':input').val('');
                        }, this),
                        complete: $.proxy(function(xhr, status, error_thrown) {
                            this.form.find(':input').removeAttr('disabled');
                            this.form.removeClass('form-sending');
                        }, this)
                    });
                }, this)
            });
        }
    });

    var Tabs = Component.extend({
        init: function(element, options) {
            this._super(element, options);
            this.element.on('click', '> ul a', $.proxy(function(e) {
                e.preventDefault();

                this.element.find('> ul a').removeClass('selected');
                this.element.find('.tab-content').hide();

                $(e.target).addClass('selected');
                $(e.target.href.substring(e.target.href.indexOf('#'))).fadeIn();
            }, this));

            this.element.find('> ul li:first-child a').trigger('click');
        }
    });

    var Accordion = Component.extend({
        init: function(element, options) {
            this._super(element, options);

            this.element.find('.accordion-container').hide();
            var find_first_element_ok = false;
            if (options !== undefined) {
                if (options.first_focus !== undefined) {
                    if (options.first_focus.title_id !== undefined && options.first_focus.content_id !== undefined) {
                        this.element.find('#' + options.first_focus.title_id)
                                .addClass('active')
                                .next().show();
                        find_first_element_ok = true;
                    }
                }
            }
            if (find_first_element_ok === false) {
                this.element.find('.accordion-title:first-child')
                        .addClass('active')
                        .next().show();
            }

            this.element.on('click', '.accordion-title', function(e) {
                e.preventDefault();

                if ($(this).next().is(':hidden')) {
                    $(this).parent().find($('.active')).removeClass('active').next().slideUp(300);
                    $(this).toggleClass('active').next().slideDown(300);
                }
            });
        }
    });

    var ProgressBar = Component.extend({
        init: function(element, options) {
            this._super(element, options);
            this.element.find(".line-progress-bar-inner").each(function() {
                $(this).data("origWidth", ($(this).width() / $(this).parent().width()) * 100)
                        .width(0)
                        .animate({width: $(this).data("origWidth") + "%"}, 1200);
            });
        }
    });

    var Reveal = Component.extend({
        init: function(element, options) {
            this._super(element, options);
            this.element.on('click', (function(e) {
                e.preventDefault();

                var elm = $(e.target);
                if (elm.is('a') == false)
                    elm = elm.closest('a');

                var href = elm.attr('href');

                if (href !== undefined && href.indexOf('#') != -1) {
                    var target = href.substring(href.indexOf('#')),
                            page = $(target);

                    $("html, body").animate({
                        scrollTop: page.offset().top
                    }, 500);
                }
            }).bind(this));
        }
    });

    /**
     * Components registry
     */
    var components = {
        'portfolio': Portfolio,
        'ajax-form': AjaxForm,
        'tabs': Tabs,
        'accordion': Accordion,
        'progress-bar': ProgressBar,
        'reveal': Reveal
    };

    /**
     * Register line's components
     */
    $.fn['component'] = function(component, options) {
        if (components[component] !== undefined) {
            return this.each(function() {
                $(this).data('line-' + component,
                        new components[component]($(this), options)
                        );
            });
        }

        return this;
    };
})(jQuery);