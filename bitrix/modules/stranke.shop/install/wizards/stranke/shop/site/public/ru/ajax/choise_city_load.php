<script type="text/javascript" src="/bitrix/js/sale/core_ui_widget.min.js?14655605616009"></script>
<script type="text/javascript" src="/bitrix/js/sale/core_ui_etc.min.js?14655605615781"></script>
<script type="text/javascript" src="/bitrix/js/sale/core_ui_autocomplete.min.js?153752175418509"></script>
<script type="text/javascript">
    setTimeout(function () {
        BX.namespace("BX.Sale.component.location.selector");
        if (typeof BX.Sale.component.location.selector.search == "undefined" && typeof BX.ui != "undefined" && typeof BX.ui.widget != "undefined") {
            BX.Sale.component.location.selector.search = function (e, t) {
                this.parentConstruct(BX.Sale.component.location.selector.search, e);
                BX.merge(this, {
                    opts: {
                        usePagingOnScroll: true,
                        pageSize: 10,
                        arrowScrollAdditional: 2,
                        pageUpWardOffset: 3,
                        provideLinkBy: "id",
                        bindEvents: {
                            "after-input-value-modify": function () {
                                this.ctrls.fullRoute.value = ""
                            }, "after-select-item": function (e) {
                                var t = this.opts;
                                var i = this.vars.cache.nodes[e];
                                var s = i.DISPLAY;
                                if (typeof i.PATH == "object") {
                                    for (var o = 0; o < i.PATH.length; o++) {
                                        s += ", " + this.vars.cache.path[i.PATH[o]]
                                    }
                                }
                                this.ctrls.inputs.fake.setAttribute("title", s);
                                this.ctrls.fullRoute.value = s;
                                if (typeof this.opts.callback == "string" && this.opts.callback.length > 0 && this.opts.callback in window) window[this.opts.callback].apply(this, [e, this])
                            }, "after-deselect-item": function () {
                                this.ctrls.fullRoute.value = "";
                                this.ctrls.inputs.fake.setAttribute("title", "")
                            }, "before-render-variant": function (e) {
                                if (e.PATH.length > 0) {
                                    var t = "";
                                    for (var i = 0; i < e.PATH.length; i++) t += ", " + this.vars.cache.path[e.PATH[i]];
                                    e.PATH = t
                                } else e.PATH = "";
                                var s = "";
                                if (this.vars && this.vars.lastQuery && this.vars.lastQuery.QUERY) s = this.vars.lastQuery.QUERY;
                                if (BX.type.isNotEmptyString(s)) {
                                    var o = [];
                                    if (this.opts.wrapSeparate) o = s.split(/\s+/); else o = [s];
                                    e["=display_wrapped"] = BX.util.wrapSubstring(e.DISPLAY + e.PATH, o, this.opts.wrapTagName, true)
                                } else e["=display_wrapped"] = BX.util.htmlspecialchars(e.DISPLAY)
                            }
                        }
                    },
                    vars: {cache: {path: {}, nodesByCode: {}}},
                    sys: {code: "sls"}
                });
                this.handleInitStack(t, BX.Sale.component.location.selector.search, e)
            };
            BX.extend(BX.Sale.component.location.selector.search, BX.ui.autoComplete);
            BX.merge(BX.Sale.component.location.selector.search.prototype, {
                init: function () {
                    if (typeof this.opts.pathNames == "object") BX.merge(this.vars.cache.path, this.opts.pathNames);
                    this.pushFuncStack("buildUpDOM", BX.Sale.component.location.selector.search);
                    this.pushFuncStack("bindEvents", BX.Sale.component.location.selector.search)
                }, buildUpDOM: function () {
                    var e = this.ctrls, t = this.opts, i = this.vars, s = this,
                        o = this.sys.code;
                    e.fullRoute = BX.create("input", {
                        props: {className: "bx-ui-" + o + "-route"},
                        attrs: {
                            type: "text",
                            disabled: "disabled",
                            autocomplete: "off"
                        }
                    });
                    BX.style(e.fullRoute, "paddingTop", BX.style(e.inputs.fake, "paddingTop"));
                    BX.style(e.fullRoute, "paddingLeft", BX.style(e.inputs.fake, "paddingLeft"));
                    BX.style(e.fullRoute, "paddingRight", "0px");
                    BX.style(e.fullRoute, "paddingBottom", "0px");
                    BX.style(e.fullRoute, "marginTop", BX.style(e.inputs.fake, "marginTop"));
                    BX.style(e.fullRoute, "marginLeft", BX.style(e.inputs.fake, "marginLeft"));
                    BX.style(e.fullRoute, "marginRight", "0px");
                    BX.style(e.fullRoute, "marginBottom", "0px");
                    if (BX.style(e.inputs.fake, "borderTopStyle") != "none") {
                        BX.style(e.fullRoute, "borderTopStyle", "solid");
                        BX.style(e.fullRoute, "borderTopColor", "transparent");
                        BX.style(e.fullRoute, "borderTopWidth", BX.style(e.inputs.fake, "borderTopWidth"))
                    }
                    if (BX.style(e.inputs.fake, "borderLeftStyle") != "none") {
                        BX.style(e.fullRoute, "borderLeftStyle", "solid");
                        BX.style(e.fullRoute, "borderLeftColor", "transparent");
                        BX.style(e.fullRoute, "borderLeftWidth", BX.style(e.inputs.fake, "borderLeftWidth"))
                    }
                    BX.prepend(e.fullRoute, e.container);
                    e.inputBlock = this.getControl("input-block");
                    e.loader = this.getControl("loader")
                }, bindEvents: function () {
                    var e = this;
                    BX.bindDelegate(this.getControl("quick-locations", true), "click", {tag: "a"}, function () {
                        e.setValueByLocationId(BX.data(this, "id"))
                    });
                    this.vars.outSideClickScope = this.ctrls.inputBlock
                }, setValueByLocationId: function (e, t) {
                    BX.Sale.component.location.selector.search.superclass.setValue.apply(this, [e, t])
                }, setValueByLocationIds: function (e) {
                    if (e.IDS) {
                        this.displayPage({
                            VALUE: e.IDS,
                            order: {TYPE_ID: "ASC", "NAME.NAME": "ASC"}
                        })
                    }
                }, setValueByLocationCode: function (e, t) {
                    var i = this.vars, s = this.opts, o = this.ctrls, n = this;
                    this.hideError();
                    if (e == null || e == false || typeof e == "undefined" || e.toString().length == 0) {
                        this.resetVariables();
                        BX.cleanNode(o.vars);
                        if (BX.type.isElementNode(o.nothingFound)) BX.hide(o.nothingFound);
                        this.fireEvent("after-deselect-item");
                        this.fireEvent("after-clear-selection");
                        return
                    }
                    if (t !== false) i.forceSelectSingeOnce = true;
                    if (typeof i.cache.nodesByCode[e] == "undefined") {
                        this.resetNavVariables();
                        n.downloadBundle({CODE: e}, function (t) {
                            n.fillCache(t, false);
                            if (typeof i.cache.nodesByCode[e] == "undefined") {
                                n.showNothingFound()
                            } else {
                                var o = i.cache.nodesByCode[e].VALUE;
                                if (s.autoSelectIfOneVariant || i.forceSelectSingeOnce) n.selectItem(o); else n.displayVariants([o])
                            }
                        }, function () {
                            i.forceSelectSingeOnce = false
                        })
                    } else {
                        var a = i.cache.nodesByCode[e].VALUE;
                        if (i.forceSelectSingeOnce) this.selectItem(a); else this.displayVariants([a]);
                        i.forceSelectSingeOnce = false
                    }
                }, getNodeByValue: function (e) {
                    if (this.opts.provideLinkBy == "id") return this.vars.cache.nodes[e]; else return this.vars.cache.nodesByCode[e]
                }, getNodeByLocationId: function (e) {
                    return this.vars.cache.nodes[e]
                }, setValue: function (e) {
                    if (this.opts.provideLinkBy == "id") BX.Sale.component.location.selector.search.superclass.setValue.apply(this, [e]); else this.setValueByLocationCode(e)
                }, getValue: function () {
                    if (this.opts.provideLinkBy == "id") return this.vars.value === false ? "" : this.vars.value; else {
                        return this.vars.value ? this.vars.cache.nodes[this.vars.value].CODE : ""
                    }
                }, getSelectedPath: function () {
                    var e = this.vars, t = [];
                    if (typeof e.value == "undefined" || e.value == false || e.value == "") return t;
                    if (typeof e.cache.nodes[e.value] != "undefined") {
                        var i = BX.clone(e.cache.nodes[e.value]);
                        if (typeof i.TYPE_ID != "undefined" && typeof this.opts.types != "undefined") i.TYPE = this.opts.types[i.TYPE_ID].CODE;
                        var s = i.PATH;
                        delete i.PATH;
                        t.push(i);
                        if (typeof s != "undefined") {
                            for (var o in s) {
                                var i = BX.clone(e.cache.nodes[s[o]]);
                                if (typeof i.TYPE_ID != "undefined" && typeof this.opts.types != "undefined") i.TYPE = this.opts.types[i.TYPE_ID].CODE;
                                delete i.PATH;
                                t.push(i)
                            }
                        }
                    }
                    return t
                }, setInitialValue: function () {
                    if (this.opts.selectedItem !== false) this.setValueByLocationId(this.opts.selectedItem); else if (this.ctrls.inputs.origin.value.length > 0) {
                        if (this.opts.provideLinkBy == "id") this.setValueByLocationId(this.ctrls.inputs.origin.value); else this.setValueByLocationCode(this.ctrls.inputs.origin.value)
                    }
                }, addItem2Cache: function (e) {
                    this.vars.cache.nodes[e.VALUE] = e;
                    this.vars.cache.nodesByCode[e.CODE] = e
                }, refineRequest: function (e) {
                    var t = {};
                    if (typeof e["QUERY"] != "undefined") t["=PHRASE"] = e.QUERY;
                    if (typeof e["VALUE"] != "undefined") t["=ID"] = e.VALUE;
                    if (typeof e["CODE"] != "undefined") t["=CODE"] = e.CODE;
                    if (typeof this.opts.query.BEHAVIOUR.LANGUAGE_ID != "undefined") t["=NAME.LANGUAGE_ID"] = this.opts.query.BEHAVIOUR.LANGUAGE_ID;
                    if (BX.type.isNotEmptyString(this.opts.query.FILTER.SITE_ID)) t["=SITE_ID"] = this.opts.query.FILTER.SITE_ID;
                    var i = {
                        select: {
                            VALUE: "ID",
                            DISPLAY: "NAME.NAME",
                            1: "CODE",
                            2: "TYPE_ID"
                        }, additionals: {1: "PATH"}, filter: t, version: "2"
                    };
                    if (typeof e["order"] != "undefined") i["order"] = e.order;
                    return i
                }, refineResponce: function (e, t) {
                    if (typeof e.ETC.PATH_ITEMS != "undefined") {
                        for (var i in e.ETC.PATH_ITEMS) {
                            if (BX.type.isNotEmptyString(e.ETC.PATH_ITEMS[i].DISPLAY)) this.vars.cache.path[i] = e.ETC.PATH_ITEMS[i].DISPLAY
                        }
                        for (var i in e.ITEMS) {
                            var s = e.ITEMS[i];
                            if (typeof s.PATH != "undefined") {
                                var o = BX.clone(s.PATH);
                                for (var n in s.PATH) {
                                    var a = s.PATH[n];
                                    o.shift();
                                    if (typeof this.vars.cache.nodes[a] == "undefined" && typeof e.ETC.PATH_ITEMS[a] != "undefined") {
                                        var l = BX.clone(e.ETC.PATH_ITEMS[a]);
                                        l.PATH = BX.clone(o);
                                        this.vars.cache.nodes[a] = l
                                    }
                                }
                            }
                        }
                    }
                    return e.ITEMS
                }, refineItems: function (e) {
                    return e
                }, refineItemDataForTemplate: function (e) {
                    return e
                }, getSelectorValue: function (e) {
                    if (this.opts.provideLinkBy == "id") return e;
                    if (typeof this.vars.cache.nodes[e] != "undefined") return this.vars.cache.nodes[e].CODE; else return ""
                }, whenLoaderToggle: function (e) {
                    BX[e ? "show" : "hide"](this.ctrls.loader)
                }
            })
        }
    }, 500)
</script>
