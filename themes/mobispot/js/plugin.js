(function (d) {
    var c = {preloadImg:true};
    var e = false;
    var i = function (l) {
        l = l.replace(/^url\((.*)\)/, "$1").replace(/^\"(.*)\"$/, "$1");
        var j = new Image();
        j.src = l.replace(/\.([a-zA-Z]*)$/, "-hover.$1");
        var k = new Image();
        k.src = l.replace(/\.([a-zA-Z]*)$/, "-focus.$1")
    };
    var b = function (l) {
        var j = d(l.get(0).form);
        var m = l.next();
        if (!m.is("label")) {
            m = l.prev();
            if (m.is("label")) {
                var k = l.attr("id");
                if (k) {
                    m = j.find('label[for="' + k + '"]')
                }
            }
        }
        if (m.is("label")) {
            return m.css("cursor", "pointer")
        }
        return false
    };
    var a = function (j) {
        var k = d(".jqTransformSelectWrapper ul:visible");
        k.each(function () {
            var l = d(this).parents(".jqTransformSelectWrapper:first").find("select").get(0);
            if (!(j && l.oLabel && l.oLabel.get(0) == j.get(0))) {
                d(this).hide()
            }
        })
    };
    var f = function (j) {
        if (d(j.target).parents(".jqTransformSelectWrapper").length === 0) {
            a(d(j.target))
        }
    };
    var h = function () {
        d(document).mousedown(f)
    };
    var g = function (k) {
        var j;
        d(".jqTransformSelectWrapper select", k).each(function () {
            j = (this.selectedIndex < 0) ? 0 : this.selectedIndex;
            d("ul", d(this).parent()).each(function () {
                d("a:eq(" + j + ")", this).click()
            })
        });
        d("a.jqTransformCheckbox, a.jqTransformRadio", k).removeClass("jqTransformChecked");
        d("input:checkbox, input:radio", k).each(function () {
            if (this.checked) {
                d("a", d(this).parent()).addClass("jqTransformChecked")
            }
        })
    };
    d.fn.jqTransInputButton = function () {
        return this.each(function () {
            var j = d('<button id="' + this.id + '" name="' + this.name + '" type="' + this.type + '" class="' + this.className + ' jqTransformButton"><span><span>' + d(this).attr("value") + "</span></span>").hover(function () {
                j.addClass("jqTransformButton_hover")
            },function () {
                j.removeClass("jqTransformButton_hover")
            }).mousedown(function () {
                j.addClass("jqTransformButton_click")
            }).mouseup(function () {
                j.removeClass("jqTransformButton_click")
            });
            d(this).replaceWith(j)
        })
    };
    d.fn.jqTransInputText = function () {
        return this.each(function () {
            var m = d(this);
            if (m.hasClass("jqtranformdone") || !m.is("input")) {
                return
            }
            m.addClass("jqtranformdone");
            var l = b(d(this));
            l && l.bind("click", function () {
                m.focus()
            });
            var j = m.width();
            m.addClass("jqTransformInput").wrap('<div class="jqTransformInputWrapper"><div class="jqTransformInputInner"><div></div></div></div>');
            var k = m.parent().parent().parent();
            k.css("width", j + 18);
            m.focus(function () {
                k.addClass("jqTransformInputWrapper_focus")
            }).blur(function () {
                k.removeClass("jqTransformInputWrapper_focus")
            }).hover(function () {
                k.addClass("jqTransformInputWrapper_hover")
            }, function () {
                k.removeClass("jqTransformInputWrapper_hover")
            });
            d.browser.safari && k.addClass("jqTransformSafari");
            this.wrapper = k
        })
    };
    d.fn.jqTransCheckBox = function () {
        return this.each(function () {
            if (d(this).hasClass("jqTransformHidden")) {
                return
            }
            var m = d(this);
            var k = this;
            var l = b(m);
            l && l.click(function () {
                j.trigger("click")
            });
            var j = d('<a href="#" class="jqTransformCheckbox"></a>');
            m.addClass("jqTransformHidden").wrap('<span class="jqTransformCheckboxWrapper"></span>').parent().prepend(j);
            m.change(function () {
                this.checked && j.addClass("jqTransformChecked") || j.removeClass("jqTransformChecked");
                return true
            });
            j.click(function () {
                if (m.attr("disabled")) {
                    return false
                }
                m.trigger("click").trigger("change");
                return false
            });
            this.checked && j.addClass("jqTransformChecked")
        })
    };
    d.fn.jqTransRadio = function () {
        return this.each(function () {
            if (d(this).hasClass("jqTransformHidden")) {
                return
            }
            var l = d(this);
            var k = this;
            oLabel = b(l);
            oLabel && oLabel.click(function () {
                j.trigger("click")
            });
            var j = d('<a href="#" class="jqTransformRadio" rel="' + this.name + '"></a>');
            l.addClass("jqTransformHidden").wrap('<span class="jqTransformRadioWrapper"></span>').parent().prepend(j);
            l.change(function () {
                k.checked && j.addClass("jqTransformChecked") || j.removeClass("jqTransformChecked");
                return true
            });
            j.click(function () {
                if (l.attr("disabled")) {
                    return false
                }
                l.trigger("click").trigger("change");
                d('input[name="' + l.attr("name") + '"]', k.form).not(l).each(function () {
                    d(this).attr("type") == "radio" && d(this).trigger("change")
                });
                return false
            });
            k.checked && j.addClass("jqTransformChecked")
        })
    };
    d.fn.jqTransTextarea = function () {
        return this.each(function () {
            var j = d(this);
            if (j.hasClass("jqtransformdone")) {
                return
            }
            j.addClass("jqtransformdone");
            oLabel = b(j);
            oLabel && oLabel.click(function () {
                j.focus()
            });
            var l = '<table cellspacing="0" cellpadding="0" border="0" class="jqTransformTextarea">';
            l += '<tr><td id="jqTransformTextarea-tl"></td><td id="jqTransformTextarea-tm"></td><td id="jqTransformTextarea-tr"></td></tr>';
            l += '<tr><td id="jqTransformTextarea-ml">&nbsp;</td><td id="jqTransformTextarea-mm"><div></div></td><td id="jqTransformTextarea-mr">&nbsp;</td></tr>';
            l += '<tr><td id="jqTransformTextarea-bl"></td><td id="jqTransformTextarea-bm"></td><td id="jqTransformTextarea-br"></td></tr>';
            l += "</table>";
            var k = d(l).insertAfter(j).hover(function () {
                !k.hasClass("jqTransformTextarea-focus") && k.addClass("jqTransformTextarea-hover")
            }, function () {
                k.removeClass("jqTransformTextarea-hover")
            });
            j.focus(function () {
                k.removeClass("jqTransformTextarea-hover").addClass("jqTransformTextarea-focus")
            }).blur(function () {
                k.removeClass("jqTransformTextarea-focus")
            }).appendTo(d("#jqTransformTextarea-mm div", k));
            this.oTable = k;
            if (d.browser.safari) {
                d("#jqTransformTextarea-mm", k).addClass("jqTransformSafariTextarea").find("div").css("height", j.height()).css("width", j.width())
            }
        })
    };
    d.fn.jqTransSelect = function () {
        return this.each(function (o) {
            var j = d(this);
            if (j.hasClass("jqTransformHidden")) {
                return
            }
            if (j.attr("multiple")) {
                return
            }
            var p = b(j);
            var n = j.addClass("jqTransformHidden").wrap('<div class="jqTransformSelectWrapper"></div>').parent().css({zIndex:10 - o});
            n.prepend('<div><span></span><a href="#" class="jqTransformSelectOpen"></a></div><ul></ul>');
            var l = d("ul", n).css("width", j.width()).hide();
            d("option", this).each(function (t) {
                var u = d('<li><a href="#" index="' + t + '">' + d(this).html() + "</a></li>");
                l.append(u)
            });
            l.find("a").click(function () {
                d("a.selected", n).removeClass("selected");
                d(this).addClass("selected");
                if (j[0].selectedIndex != d(this).attr("index") && j[0].onchange) {
                    j[0].selectedIndex = d(this).attr("index");
                    j[0].onchange()
                }
                j[0].selectedIndex = d(this).attr("index");
                d("span:eq(0)", n).html(d(this).html());
                l.hide();
                return false
            });
            d("a:eq(" + this.selectedIndex + ")", l).click();
            d("span:first", n).click(function () {
                d("a.jqTransformSelectOpen", n).trigger("click")
            });
            p && p.click(function () {
                d("a.jqTransformSelectOpen", n).trigger("click")
            });
            this.oLabel = p;
            var r = d("a.jqTransformSelectOpen", n).click(function () {
                if (l.css("display") == "none") {
                    a()
                }
                if (j.attr("disabled")) {
                    return false
                }
                l.slideToggle("fast", function () {
                    var t = (d("a.selected", l).offset().top - l.offset().top);
                    l.animate({scrollTop:t})
                });
                return false
            });
            var q = j.outerWidth();
            var m = d("span:first", n);
            var k = (q > m.innerWidth()) ? q + r.outerWidth() : n.width();
            n.css("width", k);
            l.css("width", k - 2);
            m.css({width:q});
            l.css({display:"block", visibility:"hidden"});
            var s = (d("li", l).length) * (d("li:first", l).height());
            (s < l.height()) && l.css({height:s, overflow:"hidden"});
            l.css({display:"none", visibility:"visible"})
        })
    };
    d.fn.jqTransform = function (j) {
        var k = d.extend({}, c, j);
        return this.each(function () {
            var l = d(this);
            if (l.hasClass("jqtransformdone")) {
                return
            }
            l.addClass("jqtransformdone");
            d('input:submit, input:reset, input[type="button"]', this).jqTransInputButton();
            d("input:text, input:password", this).jqTransInputText();
            d("input:checkbox", this).jqTransCheckBox();
            d("input:radio", this).jqTransRadio();
            d("textarea", this).jqTransTextarea();
            if (d("select", this).jqTransSelect().length > 0) {
                h()
            }
            l.bind("reset", function () {
                var m = function () {
                    g(this)
                };
                window.setTimeout(m, 10)
            })
        })
    }
})(jQuery);
if (jQuery)(function ($) {
    $.extend($.fn, {selectBox:function (method, data) {
        var typeTimer, typeSearch = '', isMac = navigator.platform.match(/mac/i);
        var init = function (select, data) {
            var options;
            if (navigator.userAgent.match(/iPad|iPhone|Android|IEMobile|BlackBerry/i))return false;
            if (select.tagName.toLowerCase() !== 'select')return false;
            select = $(select);
            if (select.data('selectBox-control'))return false;
            var control = $('<a class="selectBox" />'), inline = select.attr('multiple') || parseInt(select.attr('size')) > 1;
            var settings = data || {};
            control.width(select.outerWidth()).addClass(select.attr('class')).attr('title', select.attr('title') || '').attr('tabindex', parseInt(select.attr('tabindex'))).css('display', 'inline-block').bind('focus.selectBox',function () {
                if (this !== document.activeElement && document.body !== document.activeElement)$(document.activeElement).blur();
                if (control.hasClass('selectBox-active'))return;
                control.addClass('selectBox-active');
                select.trigger('focus')
            }).bind('blur.selectBox', function () {
                if (!control.hasClass('selectBox-active'))return;
                control.removeClass('selectBox-active');
                select.trigger('blur')
            });
            if (!$(window).data('selectBox-bindings')) {
                $(window).data('selectBox-bindings', true).bind('scroll.selectBox', hideMenus).bind('resize.selectBox', hideMenus)
            }
            if (select.attr('disabled'))control.addClass('selectBox-disabled');
            select.bind('click.selectBox', function (event) {
                control.focus();
                event.preventDefault()
            });
            if (inline) {
                options = getOptions(select, 'inline');
                control.append(options).data('selectBox-options', options).addClass('selectBox-inline selectBox-menuShowing').bind('keydown.selectBox',function (event) {
                    handleKeyDown(select, event)
                }).bind('keypress.selectBox',function (event) {
                    handleKeyPress(select, event)
                }).bind('mousedown.selectBox',function (event) {
                    if ($(event.target).is('A.selectBox-inline'))event.preventDefault();
                    if (!control.hasClass('selectBox-focus'))control.focus()
                }).insertAfter(select);
                if (!select[0].style.height) {
                    var size = select.attr('size') ? parseInt(select.attr('size')) : 5;
                    var tmp = control.clone().removeAttr('id').css({position:'absolute', top:'-9999em'}).show().appendTo('body');
                    tmp.find('.selectBox-options').html('<li><a>\u00A0</a></li>');
                    var optionHeight = parseInt(tmp.find('.selectBox-options A:first').html('&nbsp;').outerHeight());
                    tmp.remove();
                    control.height(optionHeight * size)
                }
                disableSelection(control)
            } else {
                var label = $('<span class="selectBox-label" />'), arrow = $('<span class="selectBox-arrow" />');
                label.attr('class', getLabelClass(select)).text(getLabelText(select));
                options = getOptions(select, 'dropdown');
                options.appendTo('BODY');
                control.data('selectBox-options', options).addClass('selectBox-dropdown').append(label).append(arrow).bind('mousedown.selectBox',function (event) {
                    if (control.hasClass('selectBox-menuShowing')) {
                        hideMenus()
                    } else {
                        event.stopPropagation();
                        options.data('selectBox-down-at-x', event.screenX).data('selectBox-down-at-y', event.screenY);
                        showMenu(select)
                    }
                }).bind('keydown.selectBox',function (event) {
                    handleKeyDown(select, event)
                }).bind('keypress.selectBox',function (event) {
                    handleKeyPress(select, event)
                }).bind('open.selectBox',function (event, triggerData) {
                    if (triggerData && triggerData._selectBox === true)return;
                    showMenu(select)
                }).bind('close.selectBox',function (event, triggerData) {
                    if (triggerData && triggerData._selectBox === true)return;
                    hideMenus()
                }).insertAfter(select);
                var labelWidth = control.width() - arrow.outerWidth() - parseInt(label.css('paddingLeft')) - parseInt(label.css('paddingLeft'));
                label.width(labelWidth);
                disableSelection(control)
            }
            select.addClass('selectBox').data('selectBox-control', control).data('selectBox-settings', settings).hide()
        };
        var getOptions = function (select, type) {
            var options;
            var _getOptions = function (select, options) {
                select.children('OPTION, OPTGROUP').each(function () {
                    if ($(this).is('OPTION')) {
                        if ($(this).length > 0) {
                            generateOptions($(this), options)
                        } else {
                            options.append('<li>\u00A0</li>')
                        }
                    } else {
                        var optgroup = $('<li class="selectBox-optgroup" />');
                        optgroup.text($(this).attr('label'));
                        options.append(optgroup);
                        options = _getOptions($(this), options)
                    }
                });
                return options
            };
            switch (type) {
                case'inline':
                    options = $('<ul class="selectBox-options" />');
                    options = _getOptions(select, options);
                    options.find('A').bind('mouseover.selectBox',function (event) {
                        addHover(select, $(this).parent())
                    }).bind('mouseout.selectBox',function (event) {
                        removeHover(select, $(this).parent())
                    }).bind('mousedown.selectBox',function (event) {
                        event.preventDefault();
                        if (!select.selectBox('control').hasClass('selectBox-active'))select.selectBox('control').focus()
                    }).bind('mouseup.selectBox', function (event) {
                        hideMenus();
                        selectOption(select, $(this).parent(), event)
                    });
                    disableSelection(options);
                    return options;
                case'dropdown':
                    options = $('<ul class="selectBox-dropdown-menu selectBox-options" />');
                    options = _getOptions(select, options);
                    options.data('selectBox-select', select).css('display', 'none').appendTo('BODY').find('A').bind('mousedown.selectBox',function (event) {
                        event.preventDefault();
                        if (event.screenX === options.data('selectBox-down-at-x') && event.screenY === options.data('selectBox-down-at-y')) {
                            options.removeData('selectBox-down-at-x').removeData('selectBox-down-at-y');
                            hideMenus()
                        }
                    }).bind('mouseup.selectBox',function (event) {
                        if (event.screenX === options.data('selectBox-down-at-x') && event.screenY === options.data('selectBox-down-at-y')) {
                            return
                        } else {
                            options.removeData('selectBox-down-at-x').removeData('selectBox-down-at-y')
                        }
                        selectOption(select, $(this).parent());
                        hideMenus()
                    }).bind('mouseover.selectBox',function (event) {
                        addHover(select, $(this).parent())
                    }).bind('mouseout.selectBox', function (event) {
                        removeHover(select, $(this).parent())
                    });
                    var classes = select.attr('class') || '';
                    if (classes !== '') {
                        classes = classes.split(' ');
                        for (var i in classes)options.addClass(classes[i] + '-selectBox-dropdown-menu')
                    }
                    disableSelection(options);
                    return options
            }
        };
        var getLabelClass = function (select) {
            var selected = $(select).find('OPTION:selected');
            return('selectBox-label ' + (selected.attr('class') || '')).replace(/\s+$/, '')
        };
        var getLabelText = function (select) {
            var selected = $(select).find('OPTION:selected');
            return selected.text() || '\u00A0'
        };
        var setLabel = function (select) {
            select = $(select);
            var control = select.data('selectBox-control');
            if (!control)return;
            control.find('.selectBox-label').attr('class', getLabelClass(select)).text(getLabelText(select))
        };
        var destroy = function (select) {
            select = $(select);
            var control = select.data('selectBox-control');
            if (!control)return;
            var options = control.data('selectBox-options');
            options.remove();
            control.remove();
            select.removeClass('selectBox').removeData('selectBox-control').data('selectBox-control', null).removeData('selectBox-settings').data('selectBox-settings', null).show()
        };
        var refresh = function (select) {
            select = $(select);
            select.selectBox('options', select.html())
        };
        var showMenu = function (select) {
            select = $(select);
            var control = select.data('selectBox-control'), settings = select.data('selectBox-settings'), options = control.data('selectBox-options');
            if (control.hasClass('selectBox-disabled'))return false;
            hideMenus();
            var borderBottomWidth = isNaN(control.css('borderBottomWidth')) ? 0 : parseInt(control.css('borderBottomWidth'));
            options.width(control.innerWidth()).css({top:control.offset().top + control.outerHeight() - borderBottomWidth, left:control.offset().left});
            if (select.triggerHandler('beforeopen'))return false;
            var dispatchOpenEvent = function () {
                select.triggerHandler('open', {_selectBox:true})
            };
            switch (settings.menuTransition) {
                case'fade':
                    options.fadeIn(settings.menuSpeed, dispatchOpenEvent);
                    break;
                case'slide':
                    options.slideDown(settings.menuSpeed, dispatchOpenEvent);
                    break;
                default:
                    options.show(settings.menuSpeed, dispatchOpenEvent);
                    break
            }
            if (!settings.menuSpeed)dispatchOpenEvent();
            var li = options.find('.selectBox-selected:first');
            keepOptionInView(select, li, true);
            addHover(select, li);
            control.addClass('selectBox-menuShowing');
            $(document).bind('mousedown.selectBox', function (event) {
                if ($(event.target).parents().andSelf().hasClass('selectBox-options'))return;
                hideMenus()
            })
        };
        var hideMenus = function () {
            if ($(".selectBox-dropdown-menu:visible").length === 0)return;
            $(document).unbind('mousedown.selectBox');
            $(".selectBox-dropdown-menu").each(function () {
                var options = $(this), select = options.data('selectBox-select'), control = select.data('selectBox-control'), settings = select.data('selectBox-settings');
                if (select.triggerHandler('beforeclose'))return false;
                var dispatchCloseEvent = function () {
                    select.triggerHandler('close', {_selectBox:true})
                };
                if (settings) {
                    switch (settings.menuTransition) {
                        case'fade':
                            options.fadeOut(settings.menuSpeed, dispatchCloseEvent);
                            break;
                        case'slide':
                            options.slideUp(settings.menuSpeed, dispatchCloseEvent);
                            break;
                        default:
                            options.hide(settings.menuSpeed, dispatchCloseEvent);
                            break
                    }
                    if (!settings.menuSpeed)dispatchCloseEvent();
                    control.removeClass('selectBox-menuShowing')
                } else {
                    $(this).hide();
                    $(this).triggerHandler('close', {_selectBox:true});
                    $(this).removeClass('selectBox-menuShowing')
                }
            })
        };
        var selectOption = function (select, li, event) {
            select = $(select);
            li = $(li);
            var control = select.data('selectBox-control'), settings = select.data('selectBox-settings');
            if (control.hasClass('selectBox-disabled'))return false;
            if (li.length === 0 || li.hasClass('selectBox-disabled'))return false;
            if (select.attr('multiple')) {
                if (event.shiftKey && control.data('selectBox-last-selected')) {
                    li.toggleClass('selectBox-selected');
                    var affectedOptions;
                    if (li.index() > control.data('selectBox-last-selected').index()) {
                        affectedOptions = li.siblings().slice(control.data('selectBox-last-selected').index(), li.index())
                    } else {
                        affectedOptions = li.siblings().slice(li.index(), control.data('selectBox-last-selected').index())
                    }
                    affectedOptions = affectedOptions.not('.selectBox-optgroup, .selectBox-disabled');
                    if (li.hasClass('selectBox-selected')) {
                        affectedOptions.addClass('selectBox-selected')
                    } else {
                        affectedOptions.removeClass('selectBox-selected')
                    }
                } else if ((isMac && event.metaKey) || (!isMac && event.ctrlKey)) {
                    li.toggleClass('selectBox-selected')
                } else {
                    li.siblings().removeClass('selectBox-selected');
                    li.addClass('selectBox-selected')
                }
            } else {
                li.siblings().removeClass('selectBox-selected');
                li.addClass('selectBox-selected')
            }
            if (control.hasClass('selectBox-dropdown')) {
                control.find('.selectBox-label').text(li.text())
            }
            var i = 0, selection = [];
            if (select.attr('multiple')) {
                control.find('.selectBox-selected A').each(function () {
                    selection[i++] = $(this).attr('rel')
                })
            } else {
                selection = li.find('A').attr('rel')
            }
            control.data('selectBox-last-selected', li);
            if (select.val() !== selection) {
                select.val(selection);
                setLabel(select);
                select.trigger('change')
            }
            return true
        };
        var addHover = function (select, li) {
            select = $(select);
            li = $(li);
            var control = select.data('selectBox-control'), options = control.data('selectBox-options');
            options.find('.selectBox-hover').removeClass('selectBox-hover');
            li.addClass('selectBox-hover')
        };
        var removeHover = function (select, li) {
            select = $(select);
            li = $(li);
            var control = select.data('selectBox-control'), options = control.data('selectBox-options');
            options.find('.selectBox-hover').removeClass('selectBox-hover')
        };
        var keepOptionInView = function (select, li, center) {
            if (!li || li.length === 0)return;
            select = $(select);
            var control = select.data('selectBox-control'), options = control.data('selectBox-options'), scrollBox = control.hasClass('selectBox-dropdown') ? options : options.parent(), top = parseInt(li.offset().top - scrollBox.position().top), bottom = parseInt(top + li.outerHeight());
            if (center) {
                scrollBox.scrollTop(li.offset().top - scrollBox.offset().top + scrollBox.scrollTop() - (scrollBox.height() / 2))
            } else {
                if (top < 0) {
                    scrollBox.scrollTop(li.offset().top - scrollBox.offset().top + scrollBox.scrollTop())
                }
                if (bottom > scrollBox.height()) {
                    scrollBox.scrollTop((li.offset().top + li.outerHeight()) - scrollBox.offset().top + scrollBox.scrollTop() - scrollBox.height())
                }
            }
        };
        var handleKeyDown = function (select, event) {
            select = $(select);
            var control = select.data('selectBox-control'), options = control.data('selectBox-options'), settings = select.data('selectBox-settings'), totalOptions = 0, i = 0;
            if (control.hasClass('selectBox-disabled'))return;
            switch (event.keyCode) {
                case 8:
                    event.preventDefault();
                    typeSearch = '';
                    break;
                case 9:
                case 27:
                    hideMenus();
                    removeHover(select);
                    break;
                case 13:
                    if (control.hasClass('selectBox-menuShowing')) {
                        selectOption(select, options.find('LI.selectBox-hover:first'), event);
                        if (control.hasClass('selectBox-dropdown'))hideMenus()
                    } else {
                        showMenu(select)
                    }
                    break;
                case 38:
                case 37:
                    event.preventDefault();
                    if (control.hasClass('selectBox-menuShowing')) {
                        var prev = options.find('.selectBox-hover').prev('LI');
                        totalOptions = options.find('LI:not(.selectBox-optgroup)').length;
                        i = 0;
                        while (prev.length === 0 || prev.hasClass('selectBox-disabled') || prev.hasClass('selectBox-optgroup')) {
                            prev = prev.prev('LI');
                            if (prev.length === 0) {
                                if (settings.loopOptions) {
                                    prev = options.find('LI:last')
                                } else {
                                    prev = options.find('LI:first')
                                }
                            }
                            if (++i >= totalOptions)break
                        }
                        addHover(select, prev);
                        selectOption(select, prev, event);
                        keepOptionInView(select, prev)
                    } else {
                        showMenu(select)
                    }
                    break;
                case 40:
                case 39:
                    event.preventDefault();
                    if (control.hasClass('selectBox-menuShowing')) {
                        var next = options.find('.selectBox-hover').next('LI');
                        totalOptions = options.find('LI:not(.selectBox-optgroup)').length;
                        i = 0;
                        while (next.length === 0 || next.hasClass('selectBox-disabled') || next.hasClass('selectBox-optgroup')) {
                            next = next.next('LI');
                            if (next.length === 0) {
                                if (settings.loopOptions) {
                                    next = options.find('LI:first')
                                } else {
                                    next = options.find('LI:last')
                                }
                            }
                            if (++i >= totalOptions)break
                        }
                        addHover(select, next);
                        selectOption(select, next, event);
                        keepOptionInView(select, next)
                    } else {
                        showMenu(select)
                    }
                    break
            }
        };
        var handleKeyPress = function (select, event) {
            select = $(select);
            var control = select.data('selectBox-control'), options = control.data('selectBox-options');
            if (control.hasClass('selectBox-disabled'))return;
            switch (event.keyCode) {
                case 9:
                case 27:
                case 13:
                case 38:
                case 37:
                case 40:
                case 39:
                    break;
                default:
                    if (!control.hasClass('selectBox-menuShowing'))showMenu(select);
                    event.preventDefault();
                    clearTimeout(typeTimer);
                    typeSearch += String.fromCharCode(event.charCode || event.keyCode);
                    options.find('A').each(function () {
                        if ($(this).text().substr(0, typeSearch.length).toLowerCase() === typeSearch.toLowerCase()) {
                            addHover(select, $(this).parent());
                            keepOptionInView(select, $(this).parent());
                            return false
                        }
                    });
                    typeTimer = setTimeout(function () {
                        typeSearch = ''
                    }, 1000);
                    break
            }
        };
        var enable = function (select) {
            select = $(select);
            select.attr('disabled', false);
            var control = select.data('selectBox-control');
            if (!control)return;
            control.removeClass('selectBox-disabled')
        };
        var disable = function (select) {
            select = $(select);
            select.attr('disabled', true);
            var control = select.data('selectBox-control');
            if (!control)return;
            control.addClass('selectBox-disabled')
        };
        var setValue = function (select, value) {
            select = $(select);
            select.val(value);
            value = select.val();
            if (value === null) {
                value = select.children().first().val();
                select.val(value)
            }
            var control = select.data('selectBox-control');
            if (!control)return;
            var settings = select.data('selectBox-settings'), options = control.data('selectBox-options');
            setLabel(select);
            options.find('.selectBox-selected').removeClass('selectBox-selected');
            options.find('A').each(function () {
                if (typeof(value) === 'object') {
                    for (var i = 0; i < value.length; i++) {
                        if ($(this).attr('rel') == value[i]) {
                            $(this).parent().addClass('selectBox-selected')
                        }
                    }
                } else {
                    if ($(this).attr('rel') == value) {
                        $(this).parent().addClass('selectBox-selected')
                    }
                }
            });
            if (settings.change)settings.change.call(select)
        };
        var setOptions = function (select, options) {
            select = $(select);
            var control = select.data('selectBox-control'), settings = select.data('selectBox-settings');
            switch (typeof(data)) {
                case'string':
                    select.html(data);
                    break;
                case'object':
                    select.html('');
                    for (var i in data) {
                        if (data[i] === null)continue;
                        if (typeof(data[i]) === 'object') {
                            var optgroup = $('<optgroup label="' + i + '" />');
                            for (var j in data[i]) {
                                optgroup.append('<option value="' + j + '">' + data[i][j] + '</option>')
                            }
                            select.append(optgroup)
                        } else {
                            var option = $('<option value="' + i + '">' + data[i] + '</option>');
                            select.append(option)
                        }
                    }
                    break
            }
            if (!control)return;
            control.data('selectBox-options').remove();
            var type = control.hasClass('selectBox-dropdown') ? 'dropdown' : 'inline';
            options = getOptions(select, type);
            control.data('selectBox-options', options);
            switch (type) {
                case'inline':
                    control.append(options);
                    break;
                case'dropdown':
                    setLabel(select);
                    $("BODY").append(options);
                    break
            }
        };
        var disableSelection = function (selector) {
            $(selector).css('MozUserSelect', 'none').bind('selectstart', function (event) {
                event.preventDefault()
            })
        };
        var generateOptions = function (self, options) {
            var li = $('<li />'), a = $('<a />');
            li.addClass(self.attr('class'));
            li.data(self.data());
            a.attr('rel', self.val()).text(self.text());
            li.append(a);
            if (self.attr('disabled'))li.addClass('selectBox-disabled');
            if (self.attr('selected'))li.addClass('selectBox-selected');
            options.append(li)
        };
        switch (method) {
            case'control':
                return $(this).data('selectBox-control');
            case'settings':
                if (!data)return $(this).data('selectBox-settings');
                $(this).each(function () {
                    $(this).data('selectBox-settings', $.extend(true, $(this).data('selectBox-settings'), data))
                });
                break;
            case'options':
                if (data === undefined)return $(this).data('selectBox-control').data('selectBox-options');
                $(this).each(function () {
                    setOptions(this, data)
                });
                break;
            case'value':
                if (data === undefined)return $(this).val();
                $(this).each(function () {
                    setValue(this, data)
                });
                break;
            case'refresh':
                $(this).each(function () {
                    refresh(this)
                });
                break;
            case'enable':
                $(this).each(function () {
                    enable(this)
                });
                break;
            case'disable':
                $(this).each(function () {
                    disable(this)
                });
                break;
            case'destroy':
                $(this).each(function () {
                    destroy(this)
                });
                break;
            default:
                $(this).each(function () {
                    init(this, method)
                });
                break
        }
        return $(this)
    }})
})(jQuery);
(function (e) {
    var c = {};
    c.fileapi = e("<input type='file'/>").get(0).files !== undefined;
    c.formdata = window.FormData !== undefined;
    e.fn.ajaxSubmit = function (g) {
        if (!this.length) {
            d("ajaxSubmit: skipping submit process - no element selected");
            return this
        }
        var f, w, i, l = this;
        if (typeof g == "function") {
            g = {success:g}
        }
        f = this.attr("method");
        w = this.attr("action");
        i = (typeof w === "string") ? e.trim(w) : "";
        i = i || window.location.href || "";
        if (i) {
            i = (i.match(/^([^#]+)/) || [])[1]
        }
        g = e.extend(true, {url:i, success:e.ajaxSettings.success, type:f || "GET", iframeSrc:/^https/i.test(window.location.href || "") ? "javascript:false" : "about:blank"}, g);
        var r = {};
        this.trigger("form-pre-serialize", [this, g, r]);
        if (r.veto) {
            d("ajaxSubmit: submit vetoed via form-pre-serialize trigger");
            return this
        }
        if (g.beforeSerialize && g.beforeSerialize(this, g) === false) {
            d("ajaxSubmit: submit aborted via beforeSerialize callback");
            return this
        }
        var j = g.traditional;
        if (j === undefined) {
            j = e.ajaxSettings.traditional
        }
        var o = [];
        var z, A = this.formToArray(g.semantic, o);
        if (g.data) {
            g.extraData = g.data;
            z = e.param(g.data, j)
        }
        if (g.beforeSubmit && g.beforeSubmit(A, this, g) === false) {
            d("ajaxSubmit: submit aborted via beforeSubmit callback");
            return this
        }
        this.trigger("form-submit-validate", [A, this, g, r]);
        if (r.veto) {
            d("ajaxSubmit: submit vetoed via form-submit-validate trigger");
            return this
        }
        var u = e.param(A, j);
        if (z) {
            u = (u ? (u + "&" + z) : z)
        }
        if (g.type.toUpperCase() == "GET") {
            g.url += (g.url.indexOf("?") >= 0 ? "&" : "?") + u;
            g.data = null
        } else {
            g.data = u
        }
        var C = [];
        if (g.resetForm) {
            C.push(function () {
                l.resetForm()
            })
        }
        if (g.clearForm) {
            C.push(function () {
                l.clearForm(g.includeHidden)
            })
        }
        if (!g.dataType && g.target) {
            var h = g.success || function () {
            };
            C.push(function (q) {
                var k = g.replaceTarget ? "replaceWith" : "html";
                e(g.target)[k](q).each(h, arguments)
            })
        } else {
            if (g.success) {
                C.push(g.success)
            }
        }
        g.success = function (F, q, G) {
            var E = g.context || g;
            for (var D = 0, k = C.length; D < k; D++) {
                C[D].apply(E, [F, q, G || l, l])
            }
        };
        var y = e("input:file:enabled[value]", this);
        var m = y.length > 0;
        var x = "multipart/form-data";
        var t = (l.attr("enctype") == x || l.attr("encoding") == x);
        var s = c.fileapi && c.formdata;
        d("fileAPI :" + s);
        var n = (m || t) && !s;
        if (g.iframe !== false && (g.iframe || n)) {
            if (g.closeKeepAlive) {
                e.get(g.closeKeepAlive, function () {
                    B(A)
                })
            } else {
                B(A)
            }
        } else {
            if ((m || t) && s) {
                p(A)
            } else {
                e.ajax(g)
            }
        }
        for (var v = 0; v < o.length; v++) {
            o[v] = null
        }
        this.trigger("form-submit-notify", [this, g]);
        return this;
        function p(q) {
            var k = new FormData();
            for (var D = 0; D < q.length; D++) {
                k.append(q[D].name, q[D].value)
            }
            if (g.extraData) {
                for (var G in g.extraData) {
                    if (g.extraData.hasOwnProperty(G)) {
                        k.append(G, g.extraData[G])
                    }
                }
            }
            g.data = null;
            var F = e.extend(true, {}, e.ajaxSettings, g, {contentType:false, processData:false, cache:false, type:"POST"});
            if (g.uploadProgress) {
                F.xhr = function () {
                    var H = jQuery.ajaxSettings.xhr();
                    if (H.upload) {
                        H.upload.onprogress = function (L) {
                            var K = 0;
                            var I = L.loaded || L.position;
                            var J = L.total;
                            if (L.lengthComputable) {
                                K = Math.ceil(I / J * 100)
                            }
                            g.uploadProgress(L, I, J, K)
                        }
                    }
                    return H
                }
            }
            F.data = null;
            var E = F.beforeSend;
            F.beforeSend = function (I, H) {
                H.data = k;
                if (E) {
                    E.call(H, I, g)
                }
            };
            e.ajax(F)
        }

        function B(ab) {
            var G = l[0], F, X, R, Z, U, I, M, K, L, V, Y, P;
            var J = !!e.fn.prop;
            if (e(":input[name=submit],:input[id=submit]", G).length) {
                alert('Error: Form elements must not have name or id of "submit".');
                return
            }
            if (ab) {
                for (X = 0; X < o.length; X++) {
                    F = e(o[X]);
                    if (J) {
                        F.prop("disabled", false)
                    } else {
                        F.removeAttr("disabled")
                    }
                }
            }
            R = e.extend(true, {}, e.ajaxSettings, g);
            R.context = R.context || R;
            U = "jqFormIO" + (new Date().getTime());
            if (R.iframeTarget) {
                I = e(R.iframeTarget);
                V = I.attr("name");
                if (!V) {
                    I.attr("name", U)
                } else {
                    U = V
                }
            } else {
                I = e('<iframe name="' + U + '" src="' + R.iframeSrc + '" />');
                I.css({position:"absolute", top:"-1000px", left:"-1000px"})
            }
            M = I[0];
            K = {aborted:0, responseText:null, responseXML:null, status:0, statusText:"n/a", getAllResponseHeaders:function () {
            }, getResponseHeader:function () {
            }, setRequestHeader:function () {
            }, abort:function (ae) {
                var af = (ae === "timeout" ? "timeout" : "aborted");
                d("aborting upload... " + af);
                this.aborted = 1;
                I.attr("src", R.iframeSrc);
                K.error = af;
                if (R.error) {
                    R.error.call(R.context, K, af, ae)
                }
                if (Z) {
                    e.event.trigger("ajaxError", [K, R, af])
                }
                if (R.complete) {
                    R.complete.call(R.context, K, af)
                }
            }};
            Z = R.global;
            if (Z && 0 === e.active++) {
                e.event.trigger("ajaxStart")
            }
            if (Z) {
                e.event.trigger("ajaxSend", [K, R])
            }
            if (R.beforeSend && R.beforeSend.call(R.context, K, R) === false) {
                if (R.global) {
                    e.active--
                }
                return
            }
            if (K.aborted) {
                return
            }
            L = G.clk;
            if (L) {
                V = L.name;
                if (V && !L.disabled) {
                    R.extraData = R.extraData || {};
                    R.extraData[V] = L.value;
                    if (L.type == "image") {
                        R.extraData[V + ".x"] = G.clk_x;
                        R.extraData[V + ".y"] = G.clk_y
                    }
                }
            }
            var Q = 1;
            var N = 2;

            function O(af) {
                var ae = af.contentWindow ? af.contentWindow.document : af.contentDocument ? af.contentDocument : af.document;
                return ae
            }

            var E = e("meta[name=csrf-token]").attr("content");
            var D = e("meta[name=csrf-param]").attr("content");
            if (D && E) {
                R.extraData = R.extraData || {};
                R.extraData[D] = E
            }
            function W() {
                var ag = l.attr("target"), ae = l.attr("action");
                G.setAttribute("target", U);
                if (!f) {
                    G.setAttribute("method", "POST")
                }
                if (ae != R.url) {
                    G.setAttribute("action", R.url)
                }
                if (!R.skipEncodingOverride && (!f || /post/i.test(f))) {
                    l.attr({encoding:"multipart/form-data", enctype:"multipart/form-data"})
                }
                if (R.timeout) {
                    P = setTimeout(function () {
                        Y = true;
                        T(Q)
                    }, R.timeout)
                }
                function ah() {
                    try {
                        var aj = O(M).readyState;
                        d("state = " + aj);
                        if (aj && aj.toLowerCase() == "uninitialized") {
                            setTimeout(ah, 50)
                        }
                    } catch (ak) {
                        d("Server abort: ", ak, " (", ak.name, ")");
                        T(N);
                        if (P) {
                            clearTimeout(P)
                        }
                        P = undefined
                    }
                }

                var af = [];
                try {
                    if (R.extraData) {
                        for (var ai in R.extraData) {
                            if (R.extraData.hasOwnProperty(ai)) {
                                af.push(e('<input type="hidden" name="' + ai + '">').attr("value", R.extraData[ai]).appendTo(G)[0])
                            }
                        }
                    }
                    if (!R.iframeTarget) {
                        I.appendTo("body");
                        if (M.attachEvent) {
                            M.attachEvent("onload", T)
                        } else {
                            M.addEventListener("load", T, false)
                        }
                    }
                    setTimeout(ah, 15);
                    G.submit()
                } finally {
                    G.setAttribute("action", ae);
                    if (ag) {
                        G.setAttribute("target", ag)
                    } else {
                        l.removeAttr("target")
                    }
                    e(af).remove()
                }
            }

            if (R.forceSync) {
                W()
            } else {
                setTimeout(W, 10)
            }
            var ac, ad, aa = 50, H;

            function T(aj) {
                if (K.aborted || H) {
                    return
                }
                try {
                    ad = O(M)
                } catch (am) {
                    d("cannot access response document: ", am);
                    aj = N
                }
                if (aj === Q && K) {
                    K.abort("timeout");
                    return
                } else {
                    if (aj == N && K) {
                        K.abort("server abort");
                        return
                    }
                }
                if (!ad || ad.location.href == R.iframeSrc) {
                    if (!Y) {
                        return
                    }
                }
                if (M.detachEvent) {
                    M.detachEvent("onload", T)
                } else {
                    M.removeEventListener("load", T, false)
                }
                var ah = "success", al;
                try {
                    if (Y) {
                        throw"timeout"
                    }
                    var ag = R.dataType == "xml" || ad.XMLDocument || e.isXMLDoc(ad);
                    d("isXml=" + ag);
                    if (!ag && window.opera && (ad.body === null || !ad.body.innerHTML)) {
                        if (--aa) {
                            d("requeing onLoad callback, DOM not available");
                            setTimeout(T, 250);
                            return
                        }
                    }
                    var an = ad.body ? ad.body : ad.documentElement;
                    K.responseText = an ? an.innerHTML : null;
                    K.responseXML = ad.XMLDocument ? ad.XMLDocument : ad;
                    if (ag) {
                        R.dataType = "xml"
                    }
                    K.getResponseHeader = function (aq) {
                        var ap = {"content-type":R.dataType};
                        return ap[aq]
                    };
                    if (an) {
                        K.status = Number(an.getAttribute("status")) || K.status;
                        K.statusText = an.getAttribute("statusText") || K.statusText
                    }
                    var ae = (R.dataType || "").toLowerCase();
                    var ak = /(json|script|text)/.test(ae);
                    if (ak || R.textarea) {
                        var ai = ad.getElementsByTagName("textarea")[0];
                        if (ai) {
                            K.responseText = ai.value;
                            K.status = Number(ai.getAttribute("status")) || K.status;
                            K.statusText = ai.getAttribute("statusText") || K.statusText
                        } else {
                            if (ak) {
                                var af = ad.getElementsByTagName("pre")[0];
                                var ao = ad.getElementsByTagName("body")[0];
                                if (af) {
                                    K.responseText = af.textContent ? af.textContent : af.innerText
                                } else {
                                    if (ao) {
                                        K.responseText = ao.textContent ? ao.textContent : ao.innerText
                                    }
                                }
                            }
                        }
                    } else {
                        if (ae == "xml" && !K.responseXML && K.responseText) {
                            K.responseXML = S(K.responseText)
                        }
                    }
                    try {
                        ac = k(K, ae, R)
                    } catch (aj) {
                        ah = "parsererror";
                        K.error = al = (aj || ah)
                    }
                } catch (aj) {
                    d("error caught: ", aj);
                    ah = "error";
                    K.error = al = (aj || ah)
                }
                if (K.aborted) {
                    d("upload aborted");
                    ah = null
                }
                if (K.status) {
                    ah = (K.status >= 200 && K.status < 300 || K.status === 304) ? "success" : "error"
                }
                if (ah === "success") {
                    if (R.success) {
                        R.success.call(R.context, ac, "success", K)
                    }
                    if (Z) {
                        e.event.trigger("ajaxSuccess", [K, R])
                    }
                } else {
                    if (ah) {
                        if (al === undefined) {
                            al = K.statusText
                        }
                        if (R.error) {
                            R.error.call(R.context, K, ah, al)
                        }
                        if (Z) {
                            e.event.trigger("ajaxError", [K, R, al])
                        }
                    }
                }
                if (Z) {
                    e.event.trigger("ajaxComplete", [K, R])
                }
                if (Z && !--e.active) {
                    e.event.trigger("ajaxStop")
                }
                if (R.complete) {
                    R.complete.call(R.context, K, ah)
                }
                H = true;
                if (R.timeout) {
                    clearTimeout(P)
                }
                setTimeout(function () {
                    if (!R.iframeTarget) {
                        I.remove()
                    }
                    K.responseXML = null
                }, 100)
            }

            var S = e.parseXML || function (ae, af) {
                if (window.ActiveXObject) {
                    af = new ActiveXObject("Microsoft.XMLDOM");
                    af.async = "false";
                    af.loadXML(ae)
                } else {
                    af = (new DOMParser()).parseFromString(ae, "text/xml")
                }
                return(af && af.documentElement && af.documentElement.nodeName != "parsererror") ? af : null
            };
            var q = e.parseJSON || function (ae) {
                return window["eval"]("(" + ae + ")")
            };
            var k = function (aj, ah, ag) {
                var af = aj.getResponseHeader("content-type") || "", ae = ah === "xml" || !ah && af.indexOf("xml") >= 0, ai = ae ? aj.responseXML : aj.responseText;
                if (ae && ai.documentElement.nodeName === "parsererror") {
                    if (e.error) {
                        e.error("parsererror")
                    }
                }
                if (ag && ag.dataFilter) {
                    ai = ag.dataFilter(ai, ah)
                }
                if (typeof ai === "string") {
                    if (ah === "json" || !ah && af.indexOf("json") >= 0) {
                        ai = q(ai)
                    } else {
                        if (ah === "script" || !ah && af.indexOf("javascript") >= 0) {
                            e.globalEval(ai)
                        }
                    }
                }
                return ai
            }
        }
    };
    e.fn.ajaxForm = function (f) {
        f = f || {};
        f.delegation = f.delegation && e.isFunction(e.fn.on);
        if (!f.delegation && this.length === 0) {
            var g = {s:this.selector, c:this.context};
            if (!e.isReady && g.s) {
                d("DOM not ready, queuing ajaxForm");
                e(function () {
                    e(g.s, g.c).ajaxForm(f)
                });
                return this
            }
            d("terminating; zero elements found by selector" + (e.isReady ? "" : " (DOM not ready)"));
            return this
        }
        if (f.delegation) {
            e(document).off("submit.form-plugin", this.selector, b).off("click.form-plugin", this.selector, a).on("submit.form-plugin", this.selector, f, b).on("click.form-plugin", this.selector, f, a);
            return this
        }
        return this.ajaxFormUnbind().bind("submit.form-plugin", f, b).bind("click.form-plugin", f, a)
    };
    function b(g) {
        var f = g.data;
        if (!g.isDefaultPrevented()) {
            g.preventDefault();
            e(this).ajaxSubmit(f)
        }
    }

    function a(j) {
        var i = j.target;
        var g = e(i);
        if (!(g.is(":submit,input:image"))) {
            var f = g.closest(":submit");
            if (f.length === 0) {
                return
            }
            i = f[0]
        }
        var h = this;
        h.clk = i;
        if (i.type == "image") {
            if (j.offsetX !== undefined) {
                h.clk_x = j.offsetX;
                h.clk_y = j.offsetY
            } else {
                if (typeof e.fn.offset == "function") {
                    var k = g.offset();
                    h.clk_x = j.pageX - k.left;
                    h.clk_y = j.pageY - k.top
                } else {
                    h.clk_x = j.pageX - i.offsetLeft;
                    h.clk_y = j.pageY - i.offsetTop
                }
            }
        }
        setTimeout(function () {
            h.clk = h.clk_x = h.clk_y = null
        }, 100)
    }

    e.fn.ajaxFormUnbind = function () {
        return this.unbind("submit.form-plugin click.form-plugin")
    };
    e.fn.formToArray = function (w, f) {
        var u = [];
        if (this.length === 0) {
            return u
        }
        var k = this[0];
        var o = w ? k.getElementsByTagName("*") : k.elements;
        if (!o) {
            return u
        }
        var q, p, m, x, l, s, h;
        for (q = 0, s = o.length; q < s; q++) {
            l = o[q];
            m = l.name;
            if (!m) {
                continue
            }
            if (w && k.clk && l.type == "image") {
                if (!l.disabled && k.clk == l) {
                    u.push({name:m, value:e(l).val(), type:l.type});
                    u.push({name:m + ".x", value:k.clk_x}, {name:m + ".y", value:k.clk_y})
                }
                continue
            }
            x = e.fieldValue(l, true);
            if (x && x.constructor == Array) {
                if (f) {
                    f.push(l)
                }
                for (p = 0, h = x.length; p < h; p++) {
                    u.push({name:m, value:x[p]})
                }
            } else {
                if (c.fileapi && l.type == "file" && !l.disabled) {
                    if (f) {
                        f.push(l)
                    }
                    var g = l.files;
                    if (g.length) {
                        for (p = 0; p < g.length; p++) {
                            u.push({name:m, value:g[p], type:l.type})
                        }
                    } else {
                        u.push({name:m, value:"", type:l.type})
                    }
                } else {
                    if (x !== null && typeof x != "undefined") {
                        if (f) {
                            f.push(l)
                        }
                        u.push({name:m, value:x, type:l.type, required:l.required})
                    }
                }
            }
        }
        if (!w && k.clk) {
            var r = e(k.clk), t = r[0];
            m = t.name;
            if (m && !t.disabled && t.type == "image") {
                u.push({name:m, value:r.val()});
                u.push({name:m + ".x", value:k.clk_x}, {name:m + ".y", value:k.clk_y})
            }
        }
        return u
    };
    e.fn.formSerialize = function (f) {
        return e.param(this.formToArray(f))
    };
    e.fn.fieldSerialize = function (g) {
        var f = [];
        this.each(function () {
            var l = this.name;
            if (!l) {
                return
            }
            var j = e.fieldValue(this, g);
            if (j && j.constructor == Array) {
                for (var k = 0, h = j.length; k < h; k++) {
                    f.push({name:l, value:j[k]})
                }
            } else {
                if (j !== null && typeof j != "undefined") {
                    f.push({name:this.name, value:j})
                }
            }
        });
        return e.param(f)
    };
    e.fn.fieldValue = function (l) {
        for (var k = [], h = 0, f = this.length; h < f; h++) {
            var j = this[h];
            var g = e.fieldValue(j, l);
            if (g === null || typeof g == "undefined" || (g.constructor == Array && !g.length)) {
                continue
            }
            if (g.constructor == Array) {
                e.merge(k, g)
            } else {
                k.push(g)
            }
        }
        return k
    };
    e.fieldValue = function (f, m) {
        var h = f.name, s = f.type, u = f.tagName.toLowerCase();
        if (m === undefined) {
            m = true
        }
        if (m && (!h || f.disabled || s == "reset" || s == "button" || (s == "checkbox" || s == "radio") && !f.checked || (s == "submit" || s == "image") && f.form && f.form.clk != f || u == "select" && f.selectedIndex == -1)) {
            return null
        }
        if (u == "select") {
            var o = f.selectedIndex;
            if (o < 0) {
                return null
            }
            var q = [], g = f.options;
            var k = (s == "select-one");
            var p = (k ? o + 1 : g.length);
            for (var j = (k ? o : 0); j < p; j++) {
                var l = g[j];
                if (l.selected) {
                    var r = l.value;
                    if (!r) {
                        r = (l.attributes && l.attributes.value && !(l.attributes.value.specified)) ? l.text : l.value
                    }
                    if (k) {
                        return r
                    }
                    q.push(r)
                }
            }
            return q
        }
        return e(f).val()
    };
    e.fn.clearForm = function (f) {
        return this.each(function () {
            e("input,select,textarea", this).clearFields(f)
        })
    };
    e.fn.clearFields = e.fn.clearInputs = function (f) {
        var g = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;
        return this.each(function () {
            var i = this.type, h = this.tagName.toLowerCase();
            if (g.test(i) || h == "textarea") {
                this.value = ""
            } else {
                if (i == "checkbox" || i == "radio") {
                    this.checked = false
                } else {
                    if (h == "select") {
                        this.selectedIndex = -1
                    } else {
                        if (f) {
                            if ((f === true && /hidden/.test(i)) || (typeof f == "string" && e(this).is(f))) {
                                this.value = ""
                            }
                        }
                    }
                }
            }
        })
    };
    e.fn.resetForm = function () {
        return this.each(function () {
            if (typeof this.reset == "function" || (typeof this.reset == "object" && !this.reset.nodeType)) {
                this.reset()
            }
        })
    };
    e.fn.enable = function (f) {
        if (f === undefined) {
            f = true
        }
        return this.each(function () {
            this.disabled = !f
        })
    };
    e.fn.selected = function (f) {
        if (f === undefined) {
            f = true
        }
        return this.each(function () {
            var g = this.type;
            if (g == "checkbox" || g == "radio") {
                this.checked = f
            } else {
                if (this.tagName.toLowerCase() == "option") {
                    var h = e(this).parent("select");
                    if (f && h[0] && h[0].type == "select-one") {
                        h.find("option").selected(false)
                    }
                    this.selected = f
                }
            }
        })
    };
    e.fn.ajaxSubmit.debug = false;
    function d() {
        if (!e.fn.ajaxSubmit.debug) {
            return
        }
        var f = "[jquery.form] " + Array.prototype.join.call(arguments, "");
        if (window.console && window.console.log) {
            window.console.log(f)
        } else {
            if (window.opera && window.opera.postError) {
                window.opera.postError(f)
            }
        }
    }
})(jQuery);
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
    var c = {preloadImg:true};
    var e = false;
    var i = function (l) {
        l = l.replace(/^url\((.*)\)/, "$1").replace(/^\"(.*)\"$/, "$1");
        var j = new Image();
        j.src = l.replace(/\.([a-zA-Z]*)$/, "-hover.$1");
        var k = new Image();
        k.src = l.replace(/\.([a-zA-Z]*)$/, "-focus.$1")
    };
    var b = function (l) {
        var j = d(l.get(0).form);
        var m = l.next();
        if (!m.is("label")) {
            m = l.prev();
            if (m.is("label")) {
                var k = l.attr("id");
                if (k) {
                    m = j.find('label[for="' + k + '"]')
                }
            }
        }
        if (m.is("label")) {
            return m.css("cursor", "pointer")
        }
        return false
    };
    var a = function (j) {
        var k = d(".jqTransformSelectWrapper ul:visible");
        k.each(function () {
            var l = d(this).parents(".jqTransformSelectWrapper:first").find("select").get(0);
            if (!(j && l.oLabel && l.oLabel.get(0) == j.get(0))) {
                d(this).hide()
            }
        })
    };
    var f = function (j) {
        if (d(j.target).parents(".jqTransformSelectWrapper").length === 0) {
            a(d(j.target))
        }
    };
    var h = function () {
        d(document).mousedown(f)
    };
    var g = function (k) {
        var j;
        d(".jqTransformSelectWrapper select", k).each(function () {
            j = (this.selectedIndex < 0) ? 0 : this.selectedIndex;
            d("ul", d(this).parent()).each(function () {
                d("a:eq(" + j + ")", this).click()
            })
        });
        d("a.jqTransformCheckbox, a.jqTransformRadio", k).removeClass("jqTransformChecked");
        d("input:checkbox, input:radio", k).each(function () {
            if (this.checked) {
                d("a", d(this).parent()).addClass("jqTransformChecked")
            }
        })
    };
    d.fn.jqTransInputButton = function () {
        return this.each(function () {
            var j = d('<button id="' + this.id + '" name="' + this.name + '" type="' + this.type + '" class="' + this.className + ' jqTransformButton"><span><span>' + d(this).attr("value") + "</span></span>").hover(function () {
                j.addClass("jqTransformButton_hover")
            },function () {
                j.removeClass("jqTransformButton_hover")
            }).mousedown(function () {
                j.addClass("jqTransformButton_click")
            }).mouseup(function () {
                j.removeClass("jqTransformButton_click")
            });
            d(this).replaceWith(j)
        })
    };
    d.fn.jqTransInputText = function () {
        return this.each(function () {
            var m = d(this);
            if (m.hasClass("jqtranformdone") || !m.is("input")) {
                return
            }
            m.addClass("jqtranformdone");
            var l = b(d(this));
            l && l.bind("click", function () {
                m.focus()
            });
            var j = m.width();
            m.addClass("jqTransformInput").wrap('<div class="jqTransformInputWrapper"><div class="jqTransformInputInner"><div></div></div></div>');
            var k = m.parent().parent().parent();
            k.css("width", j + 18);
            m.focus(function () {
                k.addClass("jqTransformInputWrapper_focus")
            }).blur(function () {
                k.removeClass("jqTransformInputWrapper_focus")
            }).hover(function () {
                k.addClass("jqTransformInputWrapper_hover")
            }, function () {
                k.removeClass("jqTransformInputWrapper_hover")
            });
            d.browser.safari && k.addClass("jqTransformSafari");
            this.wrapper = k
        })
    };
    d.fn.jqTransCheckBox = function () {
        return this.each(function () {
            if (d(this).hasClass("jqTransformHidden")) {
                return
            }
            var m = d(this);
            var k = this;
            var l = b(m);
            l && l.click(function () {
                j.trigger("click")
            });
            var j = d('<a href="#" class="jqTransformCheckbox"></a>');
            m.addClass("jqTransformHidden").wrap('<span class="jqTransformCheckboxWrapper"></span>').parent().prepend(j);
            m.change(function () {
                this.checked && j.addClass("jqTransformChecked") || j.removeClass("jqTransformChecked");
                return true
            });
            j.click(function () {
                if (m.attr("disabled")) {
                    return false
                }
                m.trigger("click").trigger("change");
                return false
            });
            this.checked && j.addClass("jqTransformChecked")
        })
    };
    d.fn.jqTransRadio = function () {
        return this.each(function () {
            if (d(this).hasClass("jqTransformHidden")) {
                return
            }
            var l = d(this);
            var k = this;
            oLabel = b(l);
            oLabel && oLabel.click(function () {
                j.trigger("click")
            });
            var j = d('<a href="#" class="jqTransformRadio" rel="' + this.name + '"></a>');
            l.addClass("jqTransformHidden").wrap('<span class="jqTransformRadioWrapper"></span>').parent().prepend(j);
            l.change(function () {
                k.checked && j.addClass("jqTransformChecked") || j.removeClass("jqTransformChecked");
                return true
            });
            j.click(function () {
                if (l.attr("disabled")) {
                    return false
                }
                l.trigger("click").trigger("change");
                d('input[name="' + l.attr("name") + '"]', k.form).not(l).each(function () {
                    d(this).attr("type") == "radio" && d(this).trigger("change")
                });
                return false
            });
            k.checked && j.addClass("jqTransformChecked")
        })
    };
    d.fn.jqTransTextarea = function () {
        return this.each(function () {
            var j = d(this);
            if (j.hasClass("jqtransformdone")) {
                return
            }
            j.addClass("jqtransformdone");
            oLabel = b(j);
            oLabel && oLabel.click(function () {
                j.focus()
            });
            var l = '<table cellspacing="0" cellpadding="0" border="0" class="jqTransformTextarea">';
            l += '<tr><td id="jqTransformTextarea-tl"></td><td id="jqTransformTextarea-tm"></td><td id="jqTransformTextarea-tr"></td></tr>';
            l += '<tr><td id="jqTransformTextarea-ml">&nbsp;</td><td id="jqTransformTextarea-mm"><div></div></td><td id="jqTransformTextarea-mr">&nbsp;</td></tr>';
            l += '<tr><td id="jqTransformTextarea-bl"></td><td id="jqTransformTextarea-bm"></td><td id="jqTransformTextarea-br"></td></tr>';
            l += "</table>";
            var k = d(l).insertAfter(j).hover(function () {
                !k.hasClass("jqTransformTextarea-focus") && k.addClass("jqTransformTextarea-hover")
            }, function () {
                k.removeClass("jqTransformTextarea-hover")
            });
            j.focus(function () {
                k.removeClass("jqTransformTextarea-hover").addClass("jqTransformTextarea-focus")
            }).blur(function () {
                k.removeClass("jqTransformTextarea-focus")
            }).appendTo(d("#jqTransformTextarea-mm div", k));
            this.oTable = k;
            if (d.browser.safari) {
                d("#jqTransformTextarea-mm", k).addClass("jqTransformSafariTextarea").find("div").css("height", j.height()).css("width", j.width())
            }
        })
    };
    d.fn.jqTransSelect = function () {
        return this.each(function (o) {
            var j = d(this);
            if (j.hasClass("jqTransformHidden")) {
                return
            }
            if (j.attr("multiple")) {
                return
            }
            var p = b(j);
            var n = j.addClass("jqTransformHidden").wrap('<div class="jqTransformSelectWrapper"></div>').parent().css({zIndex:10 - o});
            n.prepend('<div><span></span><a href="#" class="jqTransformSelectOpen"></a></div><ul></ul>');
            var l = d("ul", n).css("width", j.width()).hide();
            d("option", this).each(function (t) {
                var u = d('<li><a href="#" index="' + t + '">' + d(this).html() + "</a></li>");
                l.append(u)
            });
            l.find("a").click(function () {
                d("a.selected", n).removeClass("selected");
                d(this).addClass("selected");
                if (j[0].selectedIndex != d(this).attr("index") && j[0].onchange) {
                    j[0].selectedIndex = d(this).attr("index");
                    j[0].onchange()
                }
                j[0].selectedIndex = d(this).attr("index");
                d("span:eq(0)", n).html(d(this).html());
                l.hide();
                return false
            });
            d("a:eq(" + this.selectedIndex + ")", l).click();
            d("span:first", n).click(function () {
                d("a.jqTransformSelectOpen", n).trigger("click")
            });
            p && p.click(function () {
                d("a.jqTransformSelectOpen", n).trigger("click")
            });
            this.oLabel = p;
            var r = d("a.jqTransformSelectOpen", n).click(function () {
                if (l.css("display") == "none") {
                    a()
                }
                if (j.attr("disabled")) {
                    return false
                }
                l.slideToggle("fast", function () {
                    var t = (d("a.selected", l).offset().top - l.offset().top);
                    l.animate({scrollTop:t})
                });
                return false
            });
            var q = j.outerWidth();
            var m = d("span:first", n);
            var k = (q > m.innerWidth()) ? q + r.outerWidth() : n.width();
            n.css("width", k);
            l.css("width", k - 2);
            m.css({width:q});
            l.css({display:"block", visibility:"hidden"});
            var s = (d("li", l).length) * (d("li:first", l).height());
            (s < l.height()) && l.css({height:s, overflow:"hidden"});
            l.css({display:"none", visibility:"visible"})
        })
    };
    d.fn.jqTransform = function (j) {
        var k = d.extend({}, c, j);
        return this.each(function () {
            var l = d(this);
            if (l.hasClass("jqtransformdone")) {
                return
            }
            l.addClass("jqtransformdone");
            d('input:submit, input:reset, input[type="button"]', this).jqTransInputButton();
            d("input:text, input:password", this).jqTransInputText();
            d("input:checkbox", this).jqTransCheckBox();
            d("input:radio", this).jqTransRadio();
            d("textarea", this).jqTransTextarea();
            if (d("select", this).jqTransSelect().length > 0) {
                h()
            }
            l.bind("reset", function () {
                var m = function () {
                    g(this)
                };
                window.setTimeout(m, 10)
            })
        })
    }
})(jQuery);
(function (a) {
    a("a[data-reveal-id]").live("click", function (c) {
        c.preventDefault();
        var b = a(this).attr("data-reveal-id");
        a("#" + b).reveal(a(this).data())
    });
    a.fn.reveal = function (b) {
        var c = {animation:"fadeAndPop", animationSpeed:300, closeOnBackgroundClick:true, dismissModalClass:"close-reveal-modal"};
        var b = a.extend({}, c, b);
        return this.each(function () {
            var l = a(this), g = parseInt(l.css("top")), i = l.height() + g, h = false, e = a(".reveal-modal-bg");
            if (e.length == 0) {
                e = a('<div class="reveal-modal-bg" />').insertAfter(l);
                e.fadeTo("fast", 0.8)
            }
            function k() {
                e.unbind("click.modalEvent");
                a("." + b.dismissModalClass).unbind("click.modalEvent");
                if (!h) {
                    m();
                    if (b.animation == "fadeAndPop") {
                        l.css({top:a(document).scrollTop() - i, opacity:0, visibility:"visible"});
                        e.fadeIn(b.animationSpeed / 2);
                        l.delay(b.animationSpeed / 2).animate({top:a(document).scrollTop() + g + "px", opacity:1}, b.animationSpeed, j)
                    }
                    if (b.animation == "fade") {
                        l.css({opacity:0, visibility:"visible", top:a(document).scrollTop() + g});
                        e.fadeIn(b.animationSpeed / 2);
                        l.delay(b.animationSpeed / 2).animate({opacity:1}, b.animationSpeed, j)
                    }
                    if (b.animation == "none") {
                        l.css({visibility:"visible", top:a(document).scrollTop() + g});
                        e.css({display:"block"});
                        j()
                    }
                }
                l.unbind("reveal:open", k)
            }

            l.bind("reveal:open", k);
            function f() {
                if (!h) {
                    m();
                    if (b.animation == "fadeAndPop") {
                        e.delay(b.animationSpeed).fadeOut(b.animationSpeed);
                        l.animate({top:a(document).scrollTop() - i + "px", opacity:0}, b.animationSpeed / 2, function () {
                            l.css({top:g, opacity:1, visibility:"hidden"});
                            j()
                        })
                    }
                    if (b.animation == "fade") {
                        e.delay(b.animationSpeed).fadeOut(b.animationSpeed);
                        l.animate({opacity:0}, b.animationSpeed, function () {
                            l.css({opacity:1, visibility:"hidden", top:g});
                            j()
                        })
                    }
                    if (b.animation == "none") {
                        l.css({visibility:"hidden", top:g});
                        e.css({display:"none"})
                    }
                }
                l.unbind("reveal:close", f)
            }

            l.bind("reveal:close", f);
            l.trigger("reveal:open");
            var d = a("." + b.dismissModalClass).bind("click.modalEvent", function () {
                l.trigger("reveal:close")
            });
            if (b.closeOnBackgroundClick) {
                e.css({cursor:"pointer"});
                e.bind("click.modalEvent", function () {
                    l.trigger("reveal:close")
                })
            }
            a("body").keyup(function (n) {
                if (n.which === 27) {
                    l.trigger("reveal:close")
                }
            });
            function j() {
                h = false
            }

            function m() {
                h = true
            }
        })
    }
})(jQuery);