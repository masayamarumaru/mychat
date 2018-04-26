(function($, document, window, undefined) {
    var ctr = 0,
        defaults = {
            transitionTime: 300,
            disableMove: false,
            position: {
                horizontal:"right",
                vertical:"top"
            },
            css: {
                position: "absolute",
                zIndex: 9999,
                padding: "10px 20px",
                border: "1px solid #b3c9ce",
                borderRadius: "4px",
                font: "14px/1.3 arial, sans-serif",
                color: "#333",
                maxWidth: "250px",
                background: "#fff",
                boxShadow: "3px 3px 3px rgba(0, 0, 0, .3)",
                opacity: 0
            }
        },
        touchSupport = "ontouchstart" in document.documentElement,
        ios = /(iPad|iPhone|iPod)/g.test(navigator.userAgent),
        android = (navigator.userAgent.toLowerCase().indexOf("android") > -1),
        mobile = touchSupport || ios || android;


    $.fn.niceTooltip = function (options) {
        var opts = $.extend({}, defaults, options),
            $b = $('body'),
            $tp = $b.find('#nice-tooltip-instance');

        if (!$tp.length) {
            $tp = $('<div id="nice-tooltip-instance"></div>')
                    .appendTo('body')
                    .css(defaults.css);
        }


        var moveTooltip = (function (throttle, $tp, opts) {
            var shift = Date.now();
            return function (e) {
                var newShift = Date.now();
                if ((newShift - shift) < throttle ) {
                    return;
                } else {
                    shift = newShift;
                    fixPageXY(e);
                    var coords = {
                            left: e.pageX,
                            top: e.pageY
                        },
                        w = $tp.width(),
                        h = $tp.height(),
                        values = setPosition(w,h,coords, opts);
                    $tp.css({
                        left:values.horizontal,
                        top: values.vertical
                    });
                }
            }
        })(25,$tp,opts);

        this.data({
            'nice-tooltip-content': opts.HTML,
            'nice-tooltip-id': ctr++
        });

        if (!mobile) {
            this
                .on('mouseenter', function (e) {
                    var $el = $(this),
                        tpId = $tp.data('id'),
                        thId = $el.data('nice-tooltip-id');

                    if (!(tpId === thId)) {
                        $tp.data('id',thId).html( $el.data('nice-tooltip-content') );
                    }

                    if (opts.disableMove) {
                        var coords = setPosition($tp.width(), $tp.height(), $el.position(), opts);
                        $tp.css({
                            left: coords.horizontal,
                            top: coords.vertical
                        });
                    }

                    $tp.stop().animate({ opacity:1 }, opts.transitionTime);
                })
                .on('mouseleave', function (e) {
                    $tp.stop().animate({ opacity:0 },opts.transitionTime, function () {
                        // to avoid overlap issues
                        $tp.css({
                            left: "-10000px",
                            top: "-10000px"
                        });
                    });
                });

            if (!opts.disableMove) {
                this.on('mousemove', moveTooltip);
            }
        } else {
            this.on('touchstart', function (e) {

                if ( Number($tp.css('opacity')) === 1 ) {
                    return;
                } else {
                    var $el = $(this),
                        tpId = $tp.data('id'),
                        thId = $el.data('nice-tooltip-id');

                    if ( !( tpId === thId ) ) {
                        $tp.data('id', thId).html( $el.data('nice-tooltip-content') );
                    }

                    var coords = setPosition($tp.width(), $tp.height(), $el.position(), opts);

                    $tp.css({
                        left: coords.horizontal,
                        top: coords.vertical
                    });

                    $tp.stop().animate({opacity:1}, opts.transitionTime);

                    // setTimeout to put in the end of event loop
                    setTimeout(function () {
                        $(document).on('touchstart.nicetooltipfade', function () {
                            $tp.stop().animate({ opacity:0 }, opts.transitionTime, function () {
                                // to avoid overlap issues
                                $tp.css({
                                    left: "-10000px",
                                    top: "-10000px"
                                });
                            });
                            $(document).off('.nicetooltipfade');
                        });
                    }, 0);
                }
            });
        }

        return this;

        // compatiblity with old IE
        function fixPageXY(e) {
            if (e.pageX == null && e.clientX != null ) {
                var html = document.documentElement;
                var body = document.body;
                e.pageX = e.clientX + (html.scrollLeft || body && body.scrollLeft || 0);
                e.pageX -= html.clientLeft || 0;
                e.pageY = e.clientY + (html.scrollTop || body && body.scrollTop || 0);
                e.pageY -= html.clientTop || 0;
            }
        }

        // auxiliary function to prevent cutting edges from screen's border
        function setPosition (w, h, coords, opts) {
            var aw = document.documentElement.clientWidth,
                ah = document.documentElement.clientHeight,
                check = {
                    horizontal: {
                        left: coords.left - w - 20,
                        center: coords.left - Math.ceil(w/2),
                        right: aw - coords.left - w + 20
                    },
                    vertical: {
                        top: coords.top - h - 20,
                        center: coords.top - Math.ceil(h/2),
                        bottom: ah - coords.top + h + 20
                    }
                },
                values = {
                    horizontal: {
                        left: coords.left - w - 50,
                        center: coords.left - Math.ceil(w/2),
                        right: coords.left + 20
                    },
                    vertical: {
                        top: coords.top - h - 30,
                        center: coords.top - Math.ceil(h/2),
                        bottom: coords.top + 25
                    }
                },
                obj = {};

            if (check.horizontal[opts.position.horizontal] > 0) {
                obj.horizontal = values.horizontal[opts.position.horizontal];
            } else {
                switch (opts.position.horizontal) {
                case "center":
                    if (check.horizontal.right > 0) obj.horizontal = values.horizontal["right"];
                    else if (check.horizontal.left > 0) obj.horizontal = values.horizontal["left"];
                    else obj.horizontal = values.horizontal["center"];
                    break;
                case "left":
                    if (check.horizontal.right > 0) obj.horizontal = values.horizontal["right"];
                    else obj.horizontal = values.horizontal["center"];
                    break;
                default:
                    if (check.horizontal.left > 0) obj.horizontal = values.horizontal["left"];
                    else obj.horizontal = values.horizontal["center"];
                }
            }

            if (check.vertical[opts.position.vertical] > 0) {
                obj.vertical = values.vertical[opts.position.vertical];
            } else {
                switch (opts.position.vertical) {
                case "center":
                    if (check.vertical.top > 0) obj.vertical = values.vertical["top"];
                    else if (check.vertical.bottom > 0) obj.vertical = values.vertical["bottom"];
                    else obj.vertical = values.vertical["center"];
                    break;
                case "bottom":
                    if (check.vertical.top > 0) obj.vertical = values.vertical["top"];
                    else obj.vertical = values.vertical["center"];
                    break;
                default:
                    if (check.vertical.bottom > 0) obj.vertical = values.vertical["bottom"];
                    else obj.vertical = values.vertical["center"];
                }
            }
            return obj;
        }
    };
})(jQuery, document, window);
