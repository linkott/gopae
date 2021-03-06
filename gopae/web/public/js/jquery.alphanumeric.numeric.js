(function(a) {
    a.fn.alphanumeric = function(j) {
        var b = a(this), g = "abcdefghijklmnñopqrstuvwxyzáéíóúÁÉÍÓÚüÜ", c = a.extend({ichars: "!@#$%^&*()+=[]\\';,/{}|\":<>?~`.- _¿·", nchars: "", allow: ""}, j), f = c.allow.split(""), d = 0, e, h;
        for (d; d < f.length; d++) {
            if (c.ichars.indexOf(f[d]) != -1) {
                f[d] = "\\" + f[d]
            }
        }
        if (c.nocaps) {
            c.nchars += g.toUpperCase()
        }
        if (c.allcaps) {
            c.nchars += g
        }
        c.allow = f.join("|");
        h = new RegExp(c.allow, "gi");
        e = (c.ichars + c.nchars).replace(h, "");
        b.keypress(function(k) {
            var i = String.fromCharCode(!k.charCode ? k.which : k.charCode);
            if (e.indexOf(i) != -1 && !k.ctrlKey) {
                k.preventDefault()
            }
        });
        b.blur(function() {
            var k = b.val(), i = 0;
            for (i; i < k.length; i++) {
                if (e.indexOf(k[i]) != -1) {
                    b.val("");
                    return false
                }
            }
            return false
        });
        return b
    };
    a.fn.numeric = function(d) {
        var c = "abcdefghijklmnñopqrstuvwxyzáéíóúÁÉÍÓÚüÜ", b = c.toUpperCase();
        return this.each(function() {
            a(this).alphanumeric(a.extend({nchars: c + b}, d))
        })
    };
    a.fn.alpha = function(c) {
        var b = "1234567890";
        return this.each(function() {
            a(this).alphanumeric(a.extend({nchars: b}, c))
        })
    }
})(jQuery);

(function(a) {
    a.fn.numeric = function(d, e) {
        if (typeof d === "boolean") {
            d = {decimal: d}
        }
        d = d || {};
        if (typeof d.negative == "undefined") {
            d.negative = true
        }
        var b = (d.decimal === false) ? "" : d.decimal || ".";
        var c = (d.negative === true) ? true : false;
        e = (typeof (e) == "function" ? e : function() {
        });
        return this.data("numeric.decimal", b).data("numeric.negative", c).data("numeric.callback", e).keypress(a.fn.numeric.keypress).keyup(a.fn.numeric.keyup).blur(a.fn.numeric.blur)
    };
    a.fn.numeric.keypress = function(h) {
        var b = a.data(this, "numeric.decimal");
        var c = a.data(this, "numeric.negative");
        var d = h.charCode ? h.charCode : h.keyCode ? h.keyCode : 0;
        if (d == 13 && this.nodeName.toLowerCase() == "input") {
            return true
        } else {
            if (d == 13) {
                return false
            }
        }
        var f = false;
        if ((h.ctrlKey && d == 97) || (h.ctrlKey && d == 65)) {
            return true
        }
        if ((h.ctrlKey && d == 120) || (h.ctrlKey && d == 88)) {
            return true
        }
        if ((h.ctrlKey && d == 99) || (h.ctrlKey && d == 67)) {
            return true
        }
        if ((h.ctrlKey && d == 122) || (h.ctrlKey && d == 90)) {
            return true
        }
        if ((h.ctrlKey && d == 118) || (h.ctrlKey && d == 86) || (h.shiftKey && d == 45)) {
            return true
        }
        if (d < 48 || d > 57) {
            var g = a(this).val();
            if (g.indexOf("-") !== 0 && c && d == 45 && (g.length === 0 || parseInt(a.fn.getSelectionStart(this), 10) === 0)) {
                return true
            }
            if (b && d == b.charCodeAt(0) && g.indexOf(b) != -1) {
                f = false
            }
            if (d != 8 && d != 9 && d != 13 && d != 35 && d != 36 && d != 37 && d != 39 && d != 46) {
                f = false
            } else {
                if (typeof h.charCode != "undefined") {
                    if (h.keyCode == h.which && h.which !== 0) {
                        f = true;
                        if (h.which == 46) {
                            f = false
                        }
                    } else {
                        if (h.keyCode !== 0 && h.charCode === 0 && h.which === 0) {
                            f = true
                        }
                    }
                }
            }
            if (b && d == b.charCodeAt(0)) {
                if (g.indexOf(b) == -1) {
                    f = true
                } else {
                    f = false
                }
            }
        } else {
            f = true
        }
        return f
    };
    a.fn.numeric.keyup = function(r) {
        var l = a(this).val();
        if (l && l.length > 0) {
            var f = a.fn.getSelectionStart(this);
            var u = a.fn.getSelectionEnd(this);
            var q = a.data(this, "numeric.decimal");
            var n = a.data(this, "numeric.negative");
            if (q !== "" && q !== null) {
                var d = l.indexOf(q);
                if (d === 0) {
                    this.value = "0" + l
                }
                if (d == 1 && l.charAt(0) == "-") {
                    this.value = "-0" + l.substring(1)
                }
                l = this.value
            }
            var c = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "-", q];
            var h = l.length;
            for (var p = h - 1; p >= 0; p--) {
                var b = l.charAt(p);
                if (p !== 0 && b == "-") {
                    l = l.substring(0, p) + l.substring(p + 1)
                } else {
                    if (p === 0 && !n && b == "-") {
                        l = l.substring(1)
                    }
                }
                var g = false;
                for (var o = 0; o < c.length; o++) {
                    if (b == c[o]) {
                        g = true;
                        break
                    }
                }
                if (!g || b == " ") {
                    l = l.substring(0, p) + l.substring(p + 1)
                }
            }
            var s = l.indexOf(q);
            if (s > 0) {
                for (var m = h - 1; m > s; m--) {
                    var t = l.charAt(m);
                    if (t == q) {
                        l = l.substring(0, m) + l.substring(m + 1)
                    }
                }
            }
            this.value = l;
            a.fn.setSelection(this, [f, u])
        }
    };
    a.fn.numeric.blur = function() {
        var b = a.data(this, "numeric.decimal");
        var e = a.data(this, "numeric.callback");
        var d = this.value;
        if (d !== "") {
            var c = new RegExp("^\\d+$|^\\d*" + b + "\\d+$");
            if (!c.exec(d)) {
                e.apply(this)
            }
        }
    };
    a.fn.removeNumeric = function() {
        return this.data("numeric.decimal", null).data("numeric.negative", null).data("numeric.callback", null).unbind("keypress", a.fn.numeric.keypress).unbind("blur", a.fn.numeric.blur)
    };
    a.fn.getSelectionStart = function(c) {
        if (c.createTextRange) {
            var b = document.selection.createRange().duplicate();
            b.moveEnd("character", c.value.length);
            if (b.text === "") {
                return c.value.length
            }
            return c.value.lastIndexOf(b.text)
        } else {
            return c.selectionStart
        }
    };
    a.fn.getSelectionEnd = function(c) {
        if (c.createTextRange) {
            var b = document.selection.createRange().duplicate();
            b.moveStart("character", -c.value.length);
            return b.text.length
        } else {
            return c.selectionEnd
        }
    };
    a.fn.setSelection = function(d, c) {
        if (typeof c == "number") {
            c = [c, c]
        }
        if (c && c.constructor == Array && c.length == 2) {
            if (d.createTextRange) {
                var b = d.createTextRange();
                b.collapse(true);
                b.moveStart("character", c[0]);
                b.moveEnd("character", c[1]);
                b.select()
            } else {
                if (d.setSelectionRange) {
                    d.focus();
                    d.setSelectionRange(c[0], c[1])
                }
            }
        }
    }
})(jQuery);