jQuery(document).ready(function () {
    jQuery(".niceCheck").each(function () {
        changeCheckStart(jQuery(this))
    })
});
function changeCheck(b) {
    var b = b, a = b.find("input").eq(0);
    if (b.attr("class").indexOf("niceCheckDisabled") == -1) {
        if (!a.attr("checked")) {
            b.addClass("niceChecked");
            a.attr("checked", true)
        } else {
            b.removeClass("niceChecked");
            a.attr("checked", false).focus()
        }
    }
    return true
}
function changeVisualCheck(a) {
    var b = a.parent();
    if (!a.attr("checked")) {
        b.removeClass("niceChecked")
    } else {
        b.addClass("niceChecked")
    }
}
function changeCheckStart(d) {
    try {
        var d = d, h = d.attr("name"), c = d.attr("id"), f = d.attr("checked"), a = d.attr("disabled"), b = d.attr("value");
        checkTab = d.attr("tabindex");
        if (f) {
            d.after("<span class='niceCheck niceChecked'><input type='checkbox'name='" + h + "'id='" + c + "'checked='" + f + "'value='" + b + "'tabindex='" + checkTab + "' /></span>")
        } else {
            d.after("<span class='niceCheck'><input type='checkbox'name='" + h + "'id='" + c + "'value='" + b + "'tabindex='" + checkTab + "' /></span>")
        }
        if (a) {
            d.next().addClass("niceCheckDisabled");
            d.next().find("input").eq(0).attr("disabled", "disabled")
        }
        d.next().bind("mousedown", function (i) {
            changeCheck(jQuery(this))
        });
        d.next().find("input").eq(0).bind("change", function (i) {
            changeVisualCheck(jQuery(this))
        });
        if (jQuery.browser.msie) {
            d.next().find("input").eq(0).bind("click", function (i) {
                changeVisualCheck(jQuery(this))
            })
        }
        d.remove()
    } catch (g) {
    }
    return true
}
;
(function (d) {
    d.fn.redirect = function (a, b, c) {
        void 0 !== c ? (c = c.toUpperCase(), "GET" != c && (c = "POST")) : c = "POST";
        if (void 0 === b || !1 == b)b = d().parse_url(a), a = b.url, b = b.params;
        var e = d("<form></form");
        e.attr("method", c);
        e.attr("action", a);
        for (var f in b)a = d("<input />"), a.attr("type", "hidden"), a.attr("name", f), a.attr("value", b[f]), a.appendTo(e);
        d("body").append(e);
        e.submit()
    };
    d.fn.parse_url = function (a) {
        if (-1 == a.indexOf("?"))return{url:a, params:{}};
        var b = a.split("?"), a = b[0], c = {}, b = b[1].split("&"), e = {}, d;
        for (d in b) {
            var g = b[d].split("=");
            e[g[0]] = g[1]
        }
        c.url = a;
        c.params = e;
        return c
    }
})(jQuery);
(function (b) {
    function a(d) {
        this.input = d;
        if (d.attr("type") == "password") {
            this.handlePassword()
        }
        b(d[0].form).submit(function () {
            if (d.hasClass("placeholder") && d[0].value == d.attr("placeholder")) {
                d[0].value = ""
            }
        })
    }

    a.prototype = {show:function (f) {
        if (this.input[0].value === "" || (f && this.valueIsPlaceholder())) {
            if (this.isPassword) {
                try {
                    this.input[0].setAttribute("type", "text")
                } catch (d) {
                    this.input.before(this.fakePassword.show()).hide()
                }
            }
            this.input.addClass("placeholder");
            this.input[0].value = this.input.attr("placeholder")
        }
    }, hide:function () {
        if (this.valueIsPlaceholder() && this.input.hasClass("placeholder")) {
            this.input.removeClass("placeholder");
            this.input[0].value = "";
            if (this.isPassword) {
                try {
                    this.input[0].setAttribute("type", "password")
                } catch (d) {
                }
                this.input.show();
                this.input[0].focus()
            }
        }
    }, valueIsPlaceholder:function () {
        return this.input[0].value == this.input.attr("placeholder")
    }, handlePassword:function () {
        var d = this.input;
        d.attr("realType", "password");
        this.isPassword = true;
        if (b.browser.msie && d[0].outerHTML) {
            var e = b(d[0].outerHTML.replace(/type=(['"])?password\1/gi, "type=$1text$1"));
            this.fakePassword = e.val(d.attr("placeholder")).addClass("placeholder").focus(function () {
                d.trigger("focus");
                b(this).hide()
            });
            b(d[0].form).submit(function () {
                e.remove();
                d.show()
            })
        }
    }};
    var c = !!("placeholder" in document.createElement("input"));
    b.fn.placeholder = function () {
        return c ? this : this.each(function () {
            var d = b(this);
            var e = new a(d);
            e.show(true);
            d.focus(function () {
                e.hide()
            });
            d.blur(function () {
                e.show(false)
            });
            if (b.browser.msie) {
                b(window).load(function () {
                    if (d.val()) {
                        d.removeClass("placeholder")
                    }
                    e.show(true)
                });
                d.focus(function () {
                    if (this.value == "") {
                        var f = this.createTextRange();
                        f.collapse(true);
                        f.moveStart("character", 0);
                        f.select()
                    }
                })
            }
        })
    }
})(jQuery);