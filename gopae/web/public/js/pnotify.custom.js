/*
 PNotify 2.0.0 sciactive.com/pnotify/
 (C) 2014 Hunter Perrin
 license GPL/LGPL/MPL
 */
(function(c) {
    "function" === typeof define && define.amd ? define(["jquery"], c) : c(jQuery)
})(function(c) {
    var n = {
        dir1: "down",
        dir2: "left",
        push: "bottom",
        spacing1: 25,
        spacing2: 25,
        context: c("body")
    },
    f, g, h = c(window),
            m = function() {
                g = c("body");
                PNotify.prototype.options.stack.context = g;
                h = c(window);
                h.bind("resize", function() {
                    f && clearTimeout(f);
                    f = setTimeout(function() {
                        PNotify.positionAll(!0)
                    }, 10)
                })
            };
    PNotify = function(b) {
        this.parseOptions(b);
        this.init()
    };
    c.extend(PNotify.prototype, {
        version: "2.0.0",
        options: {
            title: !1,
            title_escape: !1,
            text: !1,
            text_escape: !1,
            styling: "bootstrap3",
            addclass: "",
            cornerclass: "",
            auto_display: !0,
            width: "300px",
            min_height: "16px",
            type: "notice",
            icon: !0,
            opacity: 1,
            animation: "fade",
            animate_speed: "slow",
            position_animate_speed: 500,
            shadow: !0,
            hide: !0,
            delay: 8E3,
            mouse_reset: !0,
            remove: !0,
            insert_brs: !0,
            destroy: !0,
            stack: n
        },
        modules: {},
        runModules: function(b, a) {
            var c, d;
            for (d in this.modules)
                if (c = "object" === typeof a && d in a ? a[d] : a, "function" === typeof this.modules[d][b])
                    this.modules[d][b](this, "object" === typeof this.options[d] ?
                            this.options[d] : {}, c)
        },
        state: "initializing",
        timer: null,
        styles: null,
        elem: null,
        container: null,
        title_container: null,
        text_container: null,
        animating: !1,
        timerHide: !1,
        init: function() {
            var b = this;
            this.modules = {};
            c.extend(!0, this.modules, PNotify.prototype.modules);
            this.styles = "object" === typeof this.options.styling ? this.options.styling : PNotify.styling[this.options.styling];
            this.elem = c("<div />", {
                "class": "ui-pnotify " + this.options.addclass,
                css: {
                    display: "none"
                },
                mouseenter: function(a) {
                    if (b.options.mouse_reset &&
                            "out" === b.animating) {
                        if (!b.timerHide)
                            return;
                        b.elem.stop(!0);
                        b.state = "open";
                        b.animating = "in";
                        b.elem.css("height", "auto").animate({
                            width: b.options.width,
                            opacity: b.options.opacity
                        }, "fast")
                    }
                    b.options.hide && b.options.mouse_reset && b.cancelRemove()
                },
                mouseleave: function(a) {
                    b.options.hide && b.options.mouse_reset && b.queueRemove();
                    PNotify.positionAll()
                }
            });
            this.container = c("<div />", {
                "class": this.styles.container + " ui-pnotify-container " + ("error" === this.options.type ? this.styles.error : "info" === this.options.type ?
                        this.styles.info : "success" === this.options.type ? this.styles.success : this.styles.notice)
            }).appendTo(this.elem);
            "" !== this.options.cornerclass && this.container.removeClass("ui-corner-all").addClass(this.options.cornerclass);
            this.options.shadow && this.container.addClass("ui-pnotify-shadow");
            !1 !== this.options.icon && c("<div />", {
                "class": "ui-pnotify-icon"
            }).append(c("<span />", {
                "class": !0 === this.options.icon ? "error" === this.options.type ? this.styles.error_icon : "info" === this.options.type ? this.styles.info_icon :
                        "success" === this.options.type ? this.styles.success_icon : this.styles.notice_icon : this.options.icon
            })).prependTo(this.container);
            this.title_container = c("<h4 />", {
                "class": "ui-pnotify-title"
            }).appendTo(this.container);
            !1 === this.options.title ? this.title_container.hide() : this.options.title_escape ? this.title_container.text(this.options.title) : this.title_container.html(this.options.title);
            this.text_container = c("<div />", {
                "class": "ui-pnotify-text"
            }).appendTo(this.container);
            !1 === this.options.text ? this.text_container.hide() :
                    this.options.text_escape ? this.text_container.text(this.options.text) : this.text_container.html(this.options.insert_brs ? String(this.options.text).replace(/\n/g, "<br />") : this.options.text);
            "string" === typeof this.options.width && this.elem.css("width", this.options.width);
            "string" === typeof this.options.min_height && this.container.css("min-height", this.options.min_height);
            PNotify.notices = "top" === this.options.stack.push ? c.merge([this], PNotify.notices) : c.merge(PNotify.notices, [this]);
            "top" === this.options.stack.push &&
                    this.queuePosition(!1, 1);
            this.options.stack.animation = !1;
            this.runModules("init");
            this.options.auto_display && this.open();
            return this
        },
        update: function(b) {
            var a = this.options;
            this.parseOptions(a, b);
            this.options.cornerclass !== a.cornerclass && this.container.removeClass("ui-corner-all " + a.cornerclass).addClass(this.options.cornerclass);
            this.options.shadow !== a.shadow && (this.options.shadow ? this.container.addClass("ui-pnotify-shadow") : this.container.removeClass("ui-pnotify-shadow"));
            !1 === this.options.addclass ?
                    this.elem.removeClass(a.addclass) : this.options.addclass !== a.addclass && this.elem.removeClass(a.addclass).addClass(this.options.addclass);
            !1 === this.options.title ? this.title_container.slideUp("fast") : this.options.title !== a.title && (this.options.title_escape ? this.title_container.text(this.options.title) : this.title_container.html(this.options.title), !1 === a.title && this.title_container.slideDown(200));
            !1 === this.options.text ? this.text_container.slideUp("fast") : this.options.text !== a.text && (this.options.text_escape ?
                    this.text_container.text(this.options.text) : this.text_container.html(this.options.insert_brs ? String(this.options.text).replace(/\n/g, "<br />") : this.options.text), !1 === a.text && this.text_container.slideDown(200));
            this.options.type !== a.type && this.container.removeClass(this.styles.error + " " + this.styles.notice + " " + this.styles.success + " " + this.styles.info).addClass("error" === this.options.type ? this.styles.error : "info" === this.options.type ? this.styles.info : "success" === this.options.type ? this.styles.success :
                    this.styles.notice);
            if (this.options.icon !== a.icon || !0 === this.options.icon && this.options.type !== a.type)
                this.container.find("div.ui-pnotify-icon").remove(), !1 !== this.options.icon && c("<div />", {
                    "class": "ui-pnotify-icon"
                }).append(c("<span />", {
                    "class": !0 === this.options.icon ? "error" === this.options.type ? this.styles.error_icon : "info" === this.options.type ? this.styles.info_icon : "success" === this.options.type ? this.styles.success_icon : this.styles.notice_icon : this.options.icon
                })).prependTo(this.container);
            this.options.width !==
                    a.width && this.elem.animate({
                        width: this.options.width
                    });
            this.options.min_height !== a.min_height && this.container.animate({
                minHeight: this.options.min_height
            });
            this.options.opacity !== a.opacity && this.elem.fadeTo(this.options.animate_speed, this.options.opacity);
            this.options.hide ? a.hide || this.queueRemove() : this.cancelRemove();
            this.queuePosition(!0);
            this.runModules("update", a);
            return this
        },
        open: function() {
            this.state = "opening";
            this.runModules("beforeOpen");
            var b = this;
            this.elem.parent().length || this.elem.appendTo(this.options.stack.context ?
                    this.options.stack.context : g);
            "top" !== this.options.stack.push && this.position(!0);
            "fade" === this.options.animation || "fade" === this.options.animation.effect_in ? this.elem.show().fadeTo(0, 0).hide() : 1 !== this.options.opacity && this.elem.show().fadeTo(0, this.options.opacity).hide();
            this.animateIn(function() {
                b.queuePosition(!0);
                b.options.hide && b.queueRemove();
                b.state = "open";
                b.runModules("afterOpen")
            });
            return this
        },
        remove: function(b) {
            this.state = "closing";
            this.timerHide = !!b;
            this.runModules("beforeClose");
            var a =
                    this;
            this.timer && (window.clearTimeout(this.timer), this.timer = null);
            this.animateOut(function() {
                a.state = "closed";
                a.runModules("afterClose");
                a.queuePosition(!0);
                a.options.remove && a.elem.detach();
                a.runModules("beforeDestroy");
                if (a.options.destroy && null !== PNotify.notices) {
                    var b = c.inArray(a, PNotify.notices);
                    -1 !== b && PNotify.notices.splice(b, 1)
                }
                a.runModules("afterDestroy")
            });
            return this
        },
        get: function() {
            return this.elem
        },
        parseOptions: function(b, a) {
            this.options = c.extend(!0, {}, PNotify.prototype.options);
            this.options.stack =
                    PNotify.prototype.options.stack;
            var f = [b, a],
                    d, e;
            for (e in f) {
                d = f[e];
                if ("undefined" == typeof d)
                    break;
                if ("object" !== typeof d)
                    this.options.text = d;
                else
                    for (var l in d)
                        this.modules[l] ? c.extend(!0, this.options[l], d[l]) : this.options[l] = d[l]
            }
        },
        animateIn: function(b) {
            this.animating = "in";
            var a;
            a = "undefined" !== typeof this.options.animation.effect_in ? this.options.animation.effect_in : this.options.animation;
            "none" === a ? (this.elem.show(), b()) : "show" === a ? this.elem.show(this.options.animate_speed, b) : "fade" === a ? this.elem.show().fadeTo(this.options.animate_speed,
                    this.options.opacity, b) : "slide" === a ? this.elem.slideDown(this.options.animate_speed, b) : "function" === typeof a ? a("in", b, this.elem) : this.elem.show(a, "object" === typeof this.options.animation.options_in ? this.options.animation.options_in : {}, this.options.animate_speed, b)
        },
        animateOut: function(b) {
            this.animating = "out";
            var a;
            a = "undefined" !== typeof this.options.animation.effect_out ? this.options.animation.effect_out : this.options.animation;
            "none" === a ? (this.elem.hide(), b()) : "show" === a ? this.elem.hide(this.options.animate_speed,
                    b) : "fade" === a ? this.elem.fadeOut(this.options.animate_speed, b) : "slide" === a ? this.elem.slideUp(this.options.animate_speed, b) : "function" === typeof a ? a("out", b, this.elem) : this.elem.hide(a, "object" === typeof this.options.animation.options_out ? this.options.animation.options_out : {}, this.options.animate_speed, b)
        },
        position: function(b) {
            var a = this.options.stack;
            "undefined" === typeof a.context && (a.context = g);
            if (a) {
                "number" !== typeof a.nextpos1 && (a.nextpos1 = a.firstpos1);
                "number" !== typeof a.nextpos2 && (a.nextpos2 = a.firstpos2);
                "number" !== typeof a.addpos2 && (a.addpos2 = 0);
                var c = "none" === this.elem.css("display");
                if (!c || b) {
                    var d, e = {},
                            f;
                    switch (a.dir1) {
                        case "down":
                            f = "top";
                            break;
                        case "up":
                            f = "bottom";
                            break;
                        case "left":
                            f = "right";
                            break;
                        case "right":
                            f = "left"
                    }
                    b = parseInt(this.elem.css(f).replace(/(?:\..*|[^0-9.])/g, ""));
                    isNaN(b) && (b = 0);
                    "undefined" !== typeof a.firstpos1 || c || (a.firstpos1 = b, a.nextpos1 = a.firstpos1);
                    var k;
                    switch (a.dir2) {
                        case "down":
                            k = "top";
                            break;
                        case "up":
                            k = "bottom";
                            break;
                        case "left":
                            k = "right";
                            break;
                        case "right":
                            k = "left"
                    }
                    d =
                            parseInt(this.elem.css(k).replace(/(?:\..*|[^0-9.])/g, ""));
                    isNaN(d) && (d = 0);
                    "undefined" !== typeof a.firstpos2 || c || (a.firstpos2 = d, a.nextpos2 = a.firstpos2);
                    if ("down" === a.dir1 && a.nextpos1 + this.elem.height() > (a.context.is(g) ? h.height() : a.context.prop("scrollHeight")) || "up" === a.dir1 && a.nextpos1 + this.elem.height() > (a.context.is(g) ? h.height() : a.context.prop("scrollHeight")) || "left" === a.dir1 && a.nextpos1 + this.elem.width() > (a.context.is(g) ? h.width() : a.context.prop("scrollWidth")) || "right" === a.dir1 && a.nextpos1 +
                            this.elem.width() > (a.context.is(g) ? h.width() : a.context.prop("scrollWidth")))
                        a.nextpos1 = a.firstpos1, a.nextpos2 += a.addpos2 + ("undefined" === typeof a.spacing2 ? 25 : a.spacing2), a.addpos2 = 0;
                    if (a.animation && a.nextpos2 < d)
                        switch (a.dir2) {
                            case "down":
                                e.top = a.nextpos2 + "px";
                                break;
                            case "up":
                                e.bottom = a.nextpos2 + "px";
                                break;
                            case "left":
                                e.right = a.nextpos2 + "px";
                                break;
                            case "right":
                                e.left = a.nextpos2 + "px"
                        }
                    else
                        "number" === typeof a.nextpos2 && this.elem.css(k, a.nextpos2 + "px");
                    switch (a.dir2) {
                        case "down":
                        case "up":
                            this.elem.outerHeight(!0) >
                                    a.addpos2 && (a.addpos2 = this.elem.height());
                            break;
                        case "left":
                        case "right":
                            this.elem.outerWidth(!0) > a.addpos2 && (a.addpos2 = this.elem.width())
                    }
                    if ("number" === typeof a.nextpos1)
                        if (a.animation && (b > a.nextpos1 || e.top || e.bottom || e.right || e.left))
                            switch (a.dir1) {
                                case "down":
                                    e.top = a.nextpos1 + "px";
                                    break;
                                case "up":
                                    e.bottom = a.nextpos1 + "px";
                                    break;
                                case "left":
                                    e.right = a.nextpos1 + "px";
                                    break;
                                case "right":
                                    e.left = a.nextpos1 + "px"
                            }
                        else
                            this.elem.css(f, a.nextpos1 + "px");
                    (e.top || e.bottom || e.right || e.left) && this.elem.animate(e, {
                        duration: this.options.position_animate_speed,
                        queue: !1
                    });
                    switch (a.dir1) {
                        case "down":
                        case "up":
                            a.nextpos1 += this.elem.height() + ("undefined" === typeof a.spacing1 ? 25 : a.spacing1);
                            break;
                        case "left":
                        case "right":
                            a.nextpos1 += this.elem.width() + ("undefined" === typeof a.spacing1 ? 25 : a.spacing1)
                    }
                }
                return this
            }
        },
        queuePosition: function(b, a) {
            f && clearTimeout(f);
            a || (a = 10);
            f = setTimeout(function() {
                PNotify.positionAll(b)
            }, a);
            return this
        },
        cancelRemove: function() {
            this.timer && window.clearTimeout(this.timer);
            return this
        },
        queueRemove: function() {
            var b =
                    this;
            this.cancelRemove();
            this.timer = window.setTimeout(function() {
                b.remove(!0)
            }, isNaN(this.options.delay) ? 0 : this.options.delay);
            return this
        }
    });
    c.extend(PNotify, {
        notices: [],
        removeAll: function() {
            c.each(PNotify.notices, function() {
                this.remove && this.remove()
            })
        },
        positionAll: function(b) {
            f && clearTimeout(f);
            f = null;
            c.each(PNotify.notices, function() {
                var a = this.options.stack;
                a && (a.nextpos1 = a.firstpos1, a.nextpos2 = a.firstpos2, a.addpos2 = 0, a.animation = b)
            });
            c.each(PNotify.notices, function() {
                this.position()
            })
        },
        styling: {
            jqueryui: {
                container: "ui-widget ui-widget-content ui-corner-all",
                notice: "ui-state-highlight",
                notice_icon: "ui-icon ui-icon-info",
                info: "",
                info_icon: "ui-icon ui-icon-info",
                success: "ui-state-default",
                success_icon: "ui-icon ui-icon-circle-check",
                error: "ui-state-error",
                error_icon: "ui-icon ui-icon-alert"
            },
            bootstrap2: {
                container: "alert",
                notice: "",
                notice_icon: "icon-exclamation-sign",
                info: "alert-info",
                info_icon: "icon-info-sign",
                success: "alert-success",
                success_icon: "icon-ok-sign",
                error: "alert-error",
                error_icon: "icon-warning-sign"
            },
            bootstrap3: {
                container: "alert",
                notice: "alert-warning",
                notice_icon: "fa fa-exclamation-sign",
                info: "alert-info",
                info_icon: "fa fa-info-sign",
                success: "alert-success",
                success_icon: "fa fa-ok-sign",
                error: "alert-danger",
                error_icon: "fa fa-warning-sign"
            }
        }
    });
    PNotify.styling.fontawesome = c.extend({}, PNotify.styling.bootstrap3);
    c.extend(PNotify.styling.fontawesome, {
        notice_icon: "fa fa-exclamation-circle",
        info_icon: "fa fa-info",
        success_icon: "fa fa-check",
        error_icon: "fa fa-warning"
    });
    document.body ? m() : c(m)
});
(function(c) {
    PNotify.prototype.options.buttons = {
        closer: !0,
        closer_hover: !0,
        sticker: !0,
        sticker_hover: !0,
        labels: {
            close: "Cerrar",
            stick: "Mantener"
        }
    };
    PNotify.prototype.modules.buttons = {
        myOptions: null,
        closer: null,
        sticker: null,
        init: function(a, b) {
            var d = this;
            this.myOptions = b;
            a.elem.on({
                mouseenter: function(b) {
                    !d.myOptions.sticker || a.options.nonblock && a.options.nonblock.nonblock || d.sticker.trigger("pnotify_icon").css("visibility", "visible");
                    !d.myOptions.closer || a.options.nonblock && a.options.nonblock.nonblock || d.closer.css("visibility",
                            "visible")
                },
                mouseleave: function(a) {
                    d.myOptions.sticker_hover && d.sticker.css("visibility", "hidden");
                    d.myOptions.closer_hover && d.closer.css("visibility", "hidden")
                }
            });
            this.sticker = c("<div />", {
                "class": "ui-pnotify-sticker",
                css: {
                    cursor: "pointer",
                    visibility: b.sticker_hover ? "hidden" : "visible"
                },
                click: function() {
                    a.options.hide = !a.options.hide;
                    a.options.hide ? a.queueRemove() : a.cancelRemove();
                    c(this).trigger("pnotify_icon")
                }
            }).bind("pnotify_icon", function() {
                c(this).children().removeClass(a.styles.pin_up + " " +
                        a.styles.pin_down).addClass(a.options.hide ? a.styles.pin_up : a.styles.pin_down)
            }).append(c("<span />", {
                "class": a.styles.pin_up,
                title: b.labels.stick
            })).prependTo(a.container);
            (!b.sticker || a.options.nonblock && a.options.nonblock.nonblock) && this.sticker.css("display", "none");
            this.closer = c("<div />", {
                "class": "ui-pnotify-closer",
                css: {
                    cursor: "pointer",
                    visibility: b.closer_hover ? "hidden" : "visible"
                },
                click: function() {
                    a.remove(!1);
                    d.sticker.css("visibility", "hidden");
                    d.closer.css("visibility", "hidden")
                }
            }).append(c("<span />", {
                "class": a.styles.closer,
                title: b.labels.close
            })).prependTo(a.container);
            (!b.closer || a.options.nonblock && a.options.nonblock.nonblock) && this.closer.css("display", "none")
        },
        update: function(a, b) {
            this.myOptions = b;
            !b.closer || a.options.nonblock && a.options.nonblock.nonblock ? this.closer.css("display", "none") : b.closer && this.closer.css("display", "block");
            !b.sticker || a.options.nonblock && a.options.nonblock.nonblock ? this.sticker.css("display", "none") : b.sticker && this.sticker.css("display", "block");
            this.sticker.trigger("pnotify_icon");
            b.sticker_hover ? this.sticker.css("visibility", "hidden") : a.options.nonblock && a.options.nonblock.nonblock || this.sticker.css("visibility", "visible");
            b.closer_hover ? this.closer.css("visibility", "hidden") : a.options.nonblock && a.options.nonblock.nonblock || this.closer.css("visibility", "visible")
        }
    };
    c.extend(PNotify.styling.jqueryui, {
        closer: "ui-icon ui-icon-close",
        pin_up: "ui-icon ui-icon-pin-w",
        pin_down: "ui-icon ui-icon-pin-s"
    });
    c.extend(PNotify.styling.bootstrap2, {
        closer: "icon-remove",
        pin_up: "icon-pause",
        pin_down: "icon-play"
    });
    c.extend(PNotify.styling.bootstrap3, {
        closer: "fa fa-times",
        pin_up: "fa fa-pause",
        pin_down: "fa fa-play"
    });
    c.extend(PNotify.styling.fontawesome, {
        closer: "fa fa-times",
        pin_up: "fa fa-pause",
        pin_down: "fa fa-play"
    })
})(jQuery);
(function(f) {
    var c = PNotify.prototype.init,
            d = PNotify.prototype.open,
            e = PNotify.prototype.remove;
    PNotify.prototype.init = function() {
        this.options.before_init && this.options.before_init(this.options);
        c.apply(this, arguments);
        this.options.after_init && this.options.after_init(this)
    };
    PNotify.prototype.open = function() {
        var a;
        this.options.before_open && (a = this.options.before_open(this));
        !1 !== a && (d.apply(this, arguments), this.options.after_open && this.options.after_open(this))
    };
    PNotify.prototype.remove = function(a) {
        var b;
        this.options.before_close && (b = this.options.before_close(this, a));
        !1 !== b && (e.apply(this, arguments), this.options.after_close && this.options.after_close(this, a))
    }
})(jQuery);
(function(d) {
    PNotify.prototype.options.confirm = {
        confirm: !1,
        align: "right",
        buttons: [{
                text: "Ok",
                addClass: "",
                click: function(b) {
                    b.get().trigger("pnotify.confirm");
                    b.remove()
                }
            }, {
                text: "Cancel",
                addClass: "",
                click: function(b) {
                    b.get().trigger("pnotify.cancel");
                    b.remove()
                }
            }]
    };
    PNotify.prototype.modules.confirm = {
        buttonContainer: null,
        init: function(b, c) {
            this.buttonContainer = d('<div style="margin-top:5px;clear:both;text-align:' + c.align + ';" />').appendTo(b.container);
            c.confirm ? this.makeButtons(b, c) : this.buttonContainer.hide()
        },
        update: function(b, c) {
            c.confirm ? (this.makeButtons(b, c), this.buttonContainer.show()) : this.buttonContainer.hide().empty()
        },
        makeButtons: function(b, c) {
            var e = !1,
                    a;
            this.buttonContainer.empty();
            for (var f in c.buttons) {
                a = c.buttons[f];
                e ? this.buttonContainer.append(" ") : e = !0;
                a = d('<button type="button" class="' + b.styles.btn + " " + a.addClass + '">' + a.text + "</button>").appendTo(this.buttonContainer).on("click", function(a) {
                    return function() {
                        "function" == typeof a.click && a.click(b)
                    }
                }(a));
                b.styles.text && a.wrapInner('<span class="' +
                        b.styles.text + '"></span>');
                b.styles.btnhover && a.hover(function(a) {
                    return function() {
                        a.addClass(b.styles.btnhover)
                    }
                }(a), function(a) {
                    return function() {
                        a.removeClass(b.styles.btnhover)
                    }
                }(a));
                if (b.styles.btnactive)
                    a.on("mousedown", function(a) {
                        return function() {
                            a.addClass(b.styles.btnactive)
                        }
                    }(a)).on("mouseup", function(a) {
                        return function() {
                            a.removeClass(b.styles.btnactive)
                        }
                    }(a));
                if (b.styles.btnfocus)
                    a.on("focus", function(a) {
                        return function() {
                            a.addClass(b.styles.btnfocus)
                        }
                    }(a)).on("blur", function(a) {
                        return function() {
                            a.removeClass(b.styles.btnfocus)
                        }
                    }(a))
            }
        }
    };
    d.extend(PNotify.styling.jqueryui, {
        btn: "ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only",
        btnhover: "ui-state-hover",
        btnactive: "ui-state-active",
        btnfocus: "ui-state-focus",
        text: "ui-button-text"
    });
    d.extend(PNotify.styling.bootstrap2, {
        btn: "btn"
    });
    d.extend(PNotify.styling.bootstrap3, {
        btn: "btn btn-default"
    });
    d.extend(PNotify.styling.fontawesome, {
        btn: "btn btn-default"
    })
})(jQuery);
(function(e) {
    var c, d = function(a, b) {
        d = "Notification" in window ? function(a, b) {
            return new Notification(a, b)
        } : "mozNotification" in navigator ? function(a, b) {
            return navigator.mozNotification.createNotification(a, b.body, b.icon).show()
        } : "webkitNotifications" in window ? function(a, b) {
            return window.webkitNotifications.createNotification(b.icon, a, b.body)
        } : function(a, b) {
            return null
        };
        return d(a, b)
    };
    PNotify.prototype.options.desktop = {
        desktop: !1,
        icon: null
    };
    PNotify.prototype.modules.desktop = {
        init: function(a, b) {
            b.desktop &&
                    (c = PNotify.desktop.checkPermission(), 0 == c && (null === b.icon ? b.icon = "http://sciactive.com/pnotify/includes/desktop/" + a.options.type + ".png" : !1 === b.icon && (b.icon = null), a.desktop = d(a.options.title, {
                        icon: b.icon,
                        body: a.options.text
                    }), "close" in a.desktop || (a.desktop = function() {
                        a.desktop.cancel()
                    }), a.desktop.onclick = function() {
                        a.elem.trigger("click")
                    }, a.desktop.onclose = function() {
                        "closing" !== a.state && "closed" !== a.state && a.remove()
                    }))
        },
        update: function(a, b, c) {
        },
        beforeOpen: function(a, b) {
            0 == c && b.desktop && a.elem.css({
                left: "-10000px",
                display: "none"
            })
        },
        afterOpen: function(a, b) {
            0 == c && b.desktop && (a.elem.css({
                left: "-10000px",
                display: "none"
            }), "show" in a.desktop && a.desktop.show())
        },
        beforeClose: function(a, b) {
            0 == c && b.desktop && a.elem.css({
                left: "-10000px",
                display: "none"
            })
        },
        afterClose: function(a, b) {
            0 == c && b.desktop && (a.elem.css({
                left: "-10000px",
                display: "none"
            }), a.desktop.close())
        }
    };
    PNotify.desktop = {
        permission: function() {
            "undefined" !== typeof Notification && "requestPermission" in Notification ? Notification.requestPermission() : "webkitNotifications" in
                    window && window.webkitNotifications.requestPermission()
        },
        checkPermission: function() {
            return "undefined" !== typeof Notification && "permission" in Notification ? "granted" == Notification.permission ? 0 : 1 : "webkitNotifications" in window ? window.webkitNotifications.checkPermission() : 1
        }
    };
    c = PNotify.desktop.checkPermission()
})(jQuery);
(function(a) {
    var c, f;
    a(function() {
        a("body").on("pnotify.history-all", function() {
            a.each(PNotify.notices, function() {
                this.modules.history.inHistory && (this.elem.is(":visible") ? this.options.hide && this.queueRemove() : this.open && this.open())
            })
        }).on("pnotify.history-last", function() {
            var a = "top" === PNotify.prototype.options.stack.push,
                    b = a ? 0 : -1,
                    d;
            do {
                d = -1 === b ? PNotify.notices.slice(b) : PNotify.notices.slice(b, b + 1);
                if (!d[0])
                    return !1;
                b = a ? b + 1 : b - 1
            } while (!d[0].modules.history.inHistory || d[0].elem.is(":visible"));
            d[0].open &&
                    d[0].open()
        })
    });
    PNotify.prototype.options.history = {
        history: !0,
        menu: !1,
        fixed: !0,
        maxonscreen: Infinity,
        labels: {
            redisplay: "Redisplay",
            all: "All",
            last: "Last"
        }
    };
    PNotify.prototype.modules.history = {
        inHistory: !1,
        init: function(e, b) {
            e.options.destroy = !1;
            this.inHistory = b.history;
            if (b.menu && "undefined" === typeof c) {
                c = a("<div />", {
                    "class": "ui-pnotify-history-container " + e.styles.hi_menu,
                    mouseleave: function() {
                        c.animate({
                            top: "-" + f + "px"
                        }, {
                            duration: 100,
                            queue: !1
                        })
                    }
                }).append(a("<div />", {
                    "class": "ui-pnotify-history-header",
                    text: b.labels.redisplay
                })).append(a("<button />", {
                    "class": "ui-pnotify-history-all " + e.styles.hi_btn,
                    text: b.labels.all,
                    mouseenter: function() {
                        a(this).addClass(e.styles.hi_btnhov)
                    },
                    mouseleave: function() {
                        a(this).removeClass(e.styles.hi_btnhov)
                    },
                    click: function() {
                        a(this).trigger("pnotify.history-all");
                        return !1
                    }
                })).append(a("<button />", {
                    "class": "ui-pnotify-history-last " + e.styles.hi_btn,
                    text: b.labels.last,
                    mouseenter: function() {
                        a(this).addClass(e.styles.hi_btnhov)
                    },
                    mouseleave: function() {
                        a(this).removeClass(e.styles.hi_btnhov)
                    },
                    click: function() {
                        a(this).trigger("pnotify.history-last");
                        return !1
                    }
                })).appendTo("body");
                var d = a("<span />", {
                    "class": "ui-pnotify-history-pulldown " + e.styles.hi_hnd,
                    mouseenter: function() {
                        c.animate({
                            top: "0"
                        }, {
                            duration: 100,
                            queue: !1
                        })
                    }
                }).appendTo(c);
                console.log(d.offset());
                f = d.offset().top + 2;
                c.css({
                    top: "-" + f + "px"
                });
                b.fixed && c.addClass("ui-pnotify-history-fixed")
            }
        },
        update: function(a, b) {
            this.inHistory = b.history;
            b.fixed && c ? c.addClass("ui-pnotify-history-fixed") : c && c.removeClass("ui-pnotify-history-fixed")
        },
        beforeOpen: function(c, b) {
            if (PNotify.notices && PNotify.notices.length > b.maxonscreen) {
                var d;
                d = "top" !== c.options.stack.push ? PNotify.notices.slice(0, PNotify.notices.length - b.maxonscreen) : PNotify.notices.slice(b.maxonscreen, PNotify.notices.length);
                a.each(d, function() {
                    this.remove && this.remove()
                })
            }
        }
    };
    a.extend(PNotify.styling.jqueryui, {
        hi_menu: "ui-state-default ui-corner-bottom",
        hi_btn: "ui-state-default ui-corner-all",
        hi_btnhov: "ui-state-hover",
        hi_hnd: "ui-icon ui-icon-grip-dotted-horizontal"
    });
    a.extend(PNotify.styling.bootstrap2, {
        hi_menu: "well",
        hi_btn: "btn",
        hi_btnhov: "",
        hi_hnd: "icon-chevron-down"
    });
    a.extend(PNotify.styling.bootstrap3, {
        hi_menu: "well",
        hi_btn: "btn btn-default",
        hi_btnhov: "",
        hi_hnd: "fa fa-chevron-down"
    });
    a.extend(PNotify.styling.fontawesome, {
        hi_menu: "well",
        hi_btn: "btn btn-default",
        hi_btnhov: "",
        hi_hnd: "fa fa-chevron-down"
    })
})(jQuery);
(function(k) {
    var f = /^on/,
            l = /^(dbl)?click$|^mouse(move|down|up|over|out|enter|leave)$|^contextmenu$/,
            m = /^(focus|blur|select|change|reset)$|^key(press|down|up)$/,
            n = /^(scroll|resize|(un)?load|abort|error)$/,
            g = function(b, a) {
                var c;
                b = b.toLowerCase();
                document.createEvent && this.dispatchEvent ? (b = b.replace(f, ""), b.match(l) ? (k(this).offset(), c = document.createEvent("MouseEvents"), c.initMouseEvent(b, a.bubbles, a.cancelable, a.view, a.detail, a.screenX, a.screenY, a.clientX, a.clientY, a.ctrlKey, a.altKey, a.shiftKey, a.metaKey,
                        a.button, a.relatedTarget)) : b.match(m) ? (c = document.createEvent("UIEvents"), c.initUIEvent(b, a.bubbles, a.cancelable, a.view, a.detail)) : b.match(n) && (c = document.createEvent("HTMLEvents"), c.initEvent(b, a.bubbles, a.cancelable)), c && this.dispatchEvent(c)) : (b.match(f) || (b = "on" + b), c = document.createEventObject(a), this.fireEvent(b, c))
            },
            e, d = function(b, a, c) {
                b.elem.css("display", "none");
                var h = document.elementFromPoint(a.clientX, a.clientY);
                b.elem.css("display", "block");
                var d = k(h),
                        f = d.css("cursor");
                b.elem.css("cursor",
                        "auto" !== f ? f : "default");
                e && e.get(0) == h || (e && (g.call(e.get(0), "mouseleave", a.originalEvent), g.call(e.get(0), "mouseout", a.originalEvent)), g.call(h, "mouseenter", a.originalEvent), g.call(h, "mouseover", a.originalEvent));
                g.call(h, c, a.originalEvent);
                e = d
            };
    PNotify.prototype.options.nonblock = {
        nonblock: !1,
        nonblock_opacity: 0.2
    };
    PNotify.prototype.modules.nonblock = {
        myOptions: null,
        init: function(b, a) {
            var c = this;
            this.myOptions = a;
            b.elem.on({
                mouseenter: function(a) {
                    c.myOptions.nonblock && a.stopPropagation();
                    c.myOptions.nonblock &&
                            b.elem.stop().animate({
                        opacity: c.myOptions.nonblock_opacity
                    }, "fast")
                },
                mouseleave: function(a) {
                    c.myOptions.nonblock && a.stopPropagation();
                    e = null;
                    b.elem.css("cursor", "auto");
                    c.myOptions.nonblock && "out" !== b.animating && b.elem.stop().animate({
                        opacity: b.options.opacity
                    }, "fast")
                },
                mouseover: function(a) {
                    c.myOptions.nonblock && a.stopPropagation()
                },
                mouseout: function(a) {
                    c.myOptions.nonblock && a.stopPropagation()
                },
                mousemove: function(a) {
                    c.myOptions.nonblock && (a.stopPropagation(), d(b, a, "onmousemove"))
                },
                mousedown: function(a) {
                    c.myOptions.nonblock &&
                            (a.stopPropagation(), a.preventDefault(), d(b, a, "onmousedown"))
                },
                mouseup: function(a) {
                    c.myOptions.nonblock && (a.stopPropagation(), a.preventDefault(), d(b, a, "onmouseup"))
                },
                click: function(a) {
                    c.myOptions.nonblock && (a.stopPropagation(), d(b, a, "onclick"))
                },
                dblclick: function(a) {
                    c.myOptions.nonblock && (a.stopPropagation(), d(b, a, "ondblclick"))
                }
            })
        },
        update: function(b, a) {
            this.myOptions = a
        }
    }
})(jQuery);
(function(c) {
    PNotify.prototype.options.reference = {
        putThing: !1,
        labels: {
            text: "Spin Around"
        }
    };
    PNotify.prototype.modules.reference = {
        thingElem: null,
        init: function(b, a) {
            var d = this;
            a.putThing && (this.thingElem = c('<button style="float:right;" class="btn btn-default" type="button" disabled><i class="' + b.styles.athing + '" />&nbsp;' + a.labels.text + "</button>").appendTo(b.container), b.container.append('<div style="clear: right; line-height: 0;" />'), b.elem.on({
                mouseenter: function(b) {
                    d.thingElem.prop("disabled", !1)
                },
                mouseleave: function(b) {
                    d.thingElem.prop("disabled", !0)
                }
            }), this.thingElem.on("click", function() {
                var a = 0,
                        c = setInterval(function() {
                            a += 10;
                            360 == a && (a = 0, clearInterval(c));
                            b.elem.css({
                                "-moz-transform": "rotate(" + a + "deg)",
                                "-webkit-transform": "rotate(" + a + "deg)",
                                "-o-transform": "rotate(" + a + "deg)",
                                "-ms-transform": "rotate(" + a + "deg)",
                                filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=" + a / 360 * 4 + ")"
                            })
                        }, 20)
            }))
        },
        update: function(b, a, c) {
            a.putThing && this.thingElem ? this.thingElem.show() : !a.putThing && this.thingElem &&
                    this.thingElem.hide();
            this.thingElem && this.thingElem.find("i").attr("class", b.styles.athing)
        },
        beforeOpen: function(b, a) {
        },
        afterOpen: function(b, a) {
        },
        beforeClose: function(b, a) {
        },
        afterClose: function(b, a) {
        },
        beforeDestroy: function(b, a) {
        },
        afterDestroy: function(b, a) {
        }
    };
    c.extend(PNotify.styling.jqueryui, {
        athing: "ui-icon ui-icon-refresh"
    });
    c.extend(PNotify.styling.bootstrap2, {
        athing: "icon-refresh"
    });
    c.extend(PNotify.styling.bootstrap3, {
        athing: "fa fa-refresh"
    });
    c.extend(PNotify.styling.fontawesome, {
        athing: "fa fa-refresh"
    })
})(jQuery);