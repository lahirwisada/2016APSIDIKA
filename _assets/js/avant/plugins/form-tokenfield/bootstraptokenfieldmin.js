(function(n,t){typeof define=="function"&&define.amd?define(["jquery"],t):n.Tokenfield=t(n.jQuery)})(this,function(n){"use strict";var t=function(t,i){var f=this,s,u,h,c;this.$element=n(t);this.direction=this.$element.css("direction")==="ltr"?"left":"right";this.options=n.extend({},n.fn.tokenfield.defaults,{tokens:this.$element.val()},i);this._delimiters=typeof this.options.delimiter=="string"?[this.options.delimiter]:this.options.delimiter;this._triggerKeys=n.map(this._delimiters,function(n){return n.charCodeAt(0)});var e=typeof getMatchedCSSRules=="function"?window.getMatchedCSSRules(t):null,o=t.style.width,r,l=this.$element.width();e&&n.each(e,function(n,t){t.style.width&&(r=t.style.width)});this.$element.css("position","absolute").css(this.direction,"-10000px").prop("tabindex",-1);this.$wrapper=n('<div class="tokenfield form-control" />');this.$element.hasClass("input-lg")&&this.$wrapper.addClass("input-lg");this.$element.hasClass("input-sm")&&this.$wrapper.addClass("input-sm");this.direction==="right"&&this.$wrapper.addClass("rtl");s=this.$element.prop("id")||(new Date).getTime()+""+Math.floor((1+Math.random())*100);this.$input=n('<input type="text" class="token-input" autocomplete="off" />').appendTo(this.$wrapper).prop("placeholder",this.$element.prop("placeholder")).prop("id",s+"-tokenfield");u=n('label[for="'+this.$element.prop("id")+'"]');u.length&&u.prop("for",this.$input.prop("id"));this.$copyHelper=n('<input type="text" />').css("position","absolute").css(this.direction,"-10000px").prop("tabindex",-1).prependTo(this.$wrapper);o?this.$wrapper.css("width",o):r?this.$wrapper.css("width",r):this.$element.parents(".form-inline").length&&this.$wrapper.width(l);(this.$element.prop("disabled")||this.$element.parents("fieldset[disabled]").length)&&this.disable();this.$mirror=n('<span style="position:absolute; top:-999px; left:0; white-space:pre;"/>');this.$input.css("min-width",this.options.minWidth+"px");n.each(["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],function(n,t){f.$mirror[0].style[t]=f.$input.css(t)});this.$mirror.appendTo("body");this.$wrapper.insertBefore(this.$element);this.$element.prependTo(this.$wrapper);this.update();this.setTokens(this.options.tokens,!1,!1);this.listen();n.isEmptyObject(this.options.autocomplete)||(h=n.extend({},this.options.autocomplete,{minLength:this.options.showAutocompleteOnFocus?0:null,position:{my:this.direction+" top",at:this.direction+" bottom",of:this.$wrapper}}),this.$input.autocomplete(h));n.isEmptyObject(this.options.typeahead)||(c=n.extend({},this.options.typeahead,{}),this.$input.typeahead(c),this.typeahead=!0)},i;return t.prototype={constructor:t,createToken:function(t,i){var o,l,v,r,e,h,c,a;typeof t=="string"&&(t={value:t,label:t});typeof i=="undefined"&&(i=!0);var f=this,u=n.trim(t.value),s=t.label.length?n.trim(t.label):u;if(u.length&&s.length&&!(u.length<this.options.minLength)&&(o=n.Event("beforeCreateToken"),o.token={value:u,label:s},this.$element.trigger(o),o.token)){if(u=o.token.value,s=o.token.label,!this.options.allowDuplicates&&n.grep(this.getTokens(),function(n){return n.value===u}).length)return l=n.Event("preventDuplicateToken"),l.token={value:u,label:s},this.$element.trigger(l),v=this.$wrapper.find('.token[data-value="'+u+'"]').addClass("duplicate"),setTimeout(function(){v.removeClass("duplicate")},250),!1;r=n('<div class="token" />').attr("data-value",u).append('<span class="token-label" />').append('<a href="#" class="close" tabindex="-1">&times;<\/a>');this.$input.hasClass("tt-query")?this.$input.parent().before(r):this.$input.before(r);this.$input.css("width",this.options.minWidth+"px");e=r.find(".token-label");h=r.find(".close");this.maxTokenWidth||(this.maxTokenWidth=this.$wrapper.width()-h.outerWidth()-parseInt(h.css("margin-left"),10)-parseInt(h.css("margin-right"),10)-parseInt(r.css("border-left-width"),10)-parseInt(r.css("border-right-width"),10)-parseInt(r.css("padding-left"),10)-parseInt(r.css("padding-right"),10),parseInt(e.css("border-left-width"),10)-parseInt(e.css("border-right-width"),10)-parseInt(e.css("padding-left"),10)-parseInt(e.css("padding-right"),10),parseInt(e.css("margin-left"),10)-parseInt(e.css("margin-right"),10));e.text(s).css("max-width",this.maxTokenWidth);r.on("mousedown",function(){if(f.disabled)return!1;f.preventDeactivation=!0}).on("click",function(n){if(f.disabled)return!1;if(f.preventDeactivation=!1,n.ctrlKey||n.metaKey)return n.preventDefault(),f.toggle(r);f.activate(r,n.shiftKey,n.shiftKey)}).on("dblclick",function(){if(f.disabled)return!1;f.edit(r)});h.on("click",n.proxy(this.remove,this));return c=n.Event("afterCreateToken"),c.token=o.token,c.relatedTarget=r.get(0),this.$element.trigger(c),a=n.Event("change"),a.initiator="tokenfield",i&&this.$element.val(this.getTokensList()).trigger(a),this.update(),this.$input.get(0)}},setTokens:function(t,i,r){if(t){i||this.$wrapper.find(".token").remove();typeof r=="undefined"&&(r=!0);typeof t=="string"&&(t=this._delimiters.length?t.split(new RegExp("["+this._delimiters.join("")+"]")):[t]);var u=this;return n.each(t,function(n,t){u.createToken(t,r)}),this.$element.get(0)}},getTokenData:function(t){var i=t.map(function(){var t=n(this);return{value:t.attr("data-value")||t.find(".token-label").text(),label:t.find(".token-label").text()}}).get();return i.length==1&&(i=i[0]),i},getTokens:function(t){var r=this,i=[],u=t?".active":"";return this.$wrapper.find(".token"+u).each(function(){i.push(r.getTokenData(n(this)))}),i},getTokensList:function(t,i,r){t=t||this._delimiters[0];i=typeof i!="undefined"&&i!==null?i:this.options.beautify;var u=t+(i&&t!==" "?" ":"");return n.map(this.getTokens(r),function(n){return n.value}).join(u)},getInput:function(){return this.$input.val()},listen:function(){var t=this;this.$element.on("change",n.proxy(this.change,this));this.$wrapper.on("mousedown",n.proxy(this.focusInput,this));this.$input.on("focus",n.proxy(this.focus,this)).on("blur",n.proxy(this.blur,this)).on("paste",n.proxy(this.paste,this)).on("keydown",n.proxy(this.keydown,this)).on("keypress",n.proxy(this.keypress,this)).on("keyup",n.proxy(this.keyup,this));this.$copyHelper.on("focus",n.proxy(this.focus,this)).on("blur",n.proxy(this.blur,this)).on("keydown",n.proxy(this.keydown,this)).on("keyup",n.proxy(this.keyup,this));this.$input.on("keypress",n.proxy(this.update,this)).on("keyup",n.proxy(this.update,this));this.$input.on("autocompletecreate",function(){var i=n(this).data("ui-autocomplete").menu.element,r=t.$wrapper.outerWidth()-parseInt(i.css("border-left-width"),10)-parseInt(i.css("border-right-width"),10);i.css("min-width",r+"px")}).on("autocompleteselect",function(n,i){return t.createToken(i.item)&&(t.$input.val(""),t.$input.data("edit")&&t.unedit(!0)),!1}).on("typeahead:selected",function(i,r,u){var f="value";n.each(t.$input.data("ttView").datasets,function(n,t){t.name===u&&(f=t.valueKey)});t.createToken(r[f])&&(t.$input.typeahead("setQuery",""),t.$input.data("edit")&&t.unedit(!0))}).on("typeahead:autocompleted",function(){t.createToken(t.$input.val());t.$input.typeahead("setQuery","");t.$input.data("edit")&&t.unedit(!0)});n(window).on("resize",n.proxy(this.update,this))},keydown:function(t){var i,r,u;if(this.focused){switch(t.keyCode){case 8:if(!this.$input.is(document.activeElement))break;this.lastInputValue=this.$input.val();break;case 37:if(this.$input.is(document.activeElement)){if(this.$input.val().length>0)break;if(i=this.$input.hasClass("tt-query")?this.$input.parent().prevAll(".token:first"):this.$input.prevAll(".token:first"),!i.length)break;this.preventInputFocus=!0;this.preventDeactivation=!0;this.activate(i);t.preventDefault()}else this.prev(t.shiftKey),t.preventDefault();break;case 38:if(!t.shiftKey)return;if(this.$input.is(document.activeElement)){if(this.$input.val().length>0)break;if(i=this.$input.hasClass("tt-query")?this.$input.parent().prevAll(".token:last"):this.$input.prevAll(".token:last"),!i.length)return;this.activate(i)}u=this;this.firstActiveToken.nextAll(".token").each(function(){u.deactivate(n(this))});this.activate(this.$wrapper.find(".token:first"),!0,!0);t.preventDefault();break;case 39:if(this.$input.is(document.activeElement)){if(this.$input.val().length>0)break;if(r=this.$input.hasClass("tt-query")?this.$input.parent().nextAll(".token:first"):this.$input.nextAll(".token:first"),!r.length)break;this.preventInputFocus=!0;this.preventDeactivation=!0;this.activate(r);t.preventDefault()}else this.next(t.shiftKey),t.preventDefault();break;case 40:if(!t.shiftKey)return;if(this.$input.is(document.activeElement)){if(this.$input.val().length>0)break;if(r=this.$input.hasClass("tt-query")?this.$input.parent().nextAll(".token:first"):this.$input.nextAll(".token:first"),!r.length)return;this.activate(r)}u=this;this.firstActiveToken.prevAll(".token").each(function(){u.deactivate(n(this))});this.activate(this.$wrapper.find(".token:last"),!0,!0);t.preventDefault();break;case 65:if(this.$input.val().length>0||!(t.ctrlKey||t.metaKey))break;this.activateAll();t.preventDefault();break;case 9:case 13:if(this.$input.data("ui-autocomplete")&&this.$input.data("ui-autocomplete").menu.element.find("li:has(a.ui-state-focus)").length)break;if(this.$input.hasClass("tt-query")&&this.$wrapper.find(".tt-is-under-cursor").length)break;if(this.$input.hasClass("tt-query")&&this.$wrapper.find(".tt-hint").val().length)break;if(this.$input.is(document.activeElement)&&this.$input.val().length||this.$input.data("edit"))return this.createTokensFromInput(t,this.$input.data("edit"));if(t.keyCode===13){if(!this.$copyHelper.is(document.activeElement)||this.$wrapper.find(".token.active").length!==1)break;this.edit(this.$wrapper.find(".token.active"))}}this.lastKeyDown=t.keyCode}},keypress:function(t){return this.lastKeyPressCode=t.keyCode,this.lastKeyPressCharCode=t.charCode,n.inArray(t.charCode,this._triggerKeys)!==-1&&this.$input.is(document.activeElement)?(this.$input.val()&&this.createTokensFromInput(t),!1):void 0},keyup:function(n){if(this.preventInputFocus=!1,this.focused){switch(n.keyCode){case 8:if(this.$input.is(document.activeElement)){if(this.$input.val().length||this.lastInputValue.length&&this.lastKeyDown===8)break;this.preventDeactivation=!0;var t=this.$input.hasClass("tt-query")?this.$input.parent().prevAll(".token:first"):this.$input.prevAll(".token:first");if(!t.length)break;this.activate(t)}else this.remove(n);break;case 46:this.remove(n,"next")}this.lastKeyUp=n.keyCode}},focus:function(){this.focused=!0;this.$wrapper.addClass("focus");this.$input.is(document.activeElement)&&(this.$wrapper.find(".active").removeClass("active"),this.firstActiveToken=null,this.options.showAutocompleteOnFocus&&this.search())},blur:function(n){this.focused=!1;this.$wrapper.removeClass("focus");this.preventDeactivation||this.$element.is(document.activeElement)||(this.$wrapper.find(".active").removeClass("active"),this.firstActiveToken=null);!this.preventCreateTokens&&(this.$input.data("edit")&&!this.$input.is(document.activeElement)||this.options.createTokensOnBlur)&&this.createTokensFromInput(n);this.preventDeactivation=!1;this.preventCreateTokens=!1},paste:function(n){var t=this;setTimeout(function(){t.createTokensFromInput(n)},1)},change:function(n){n.initiator!=="tokenfield"&&this.setTokens(this.$element.val())},createTokensFromInput:function(n,t){if(!(this.$input.val().length<this.options.minLength)){var i=this.getTokensList();return(this.setTokens(this.$input.val(),!0),i==this.getTokensList()&&this.$input.val().length)?!1:(this.$input.hasClass("tt-query")?this.$input.typeahead("setQuery",""):this.$input.val(""),this.$input.data("edit")&&this.unedit(t),!1)}},next:function(n){var t,r,u,i;if(n&&(t=this.$wrapper.find(".active:first"),r=t&&this.firstActiveToken?t.index()<this.firstActiveToken.index():!1,r))return this.deactivate(t);if(u=this.$wrapper.find(".active:last"),i=u.nextAll(".token:first"),!i.length){this.$input.focus();return}this.activate(i,n)},prev:function(n){var i,r,u,t;if(n&&(i=this.$wrapper.find(".active:last"),r=i&&this.firstActiveToken?i.index()>this.firstActiveToken.index():!1,r))return this.deactivate(i);if(u=this.$wrapper.find(".active:first"),t=u.prevAll(".token:first"),t.length||(t=this.$wrapper.find(".token:first")),!t.length&&!n){this.$input.focus();return}this.activate(t,n)},activate:function(t,i,r,u){var u,i;if(t&&this.$wrapper.find(".token.active").length!==this.$wrapper.find(".token").length){if(typeof u=="undefined"&&(u=!0),r&&(i=!0),this.$copyHelper.focus(),i||(this.$wrapper.find(".active").removeClass("active"),u?this.firstActiveToken=t:delete this.firstActiveToken),r&&this.firstActiveToken){var f=this.firstActiveToken.index()-2,e=t.index()-2,o=this;this.$wrapper.find(".token").slice(Math.min(f,e)+1,Math.max(f,e)).each(function(){o.activate(n(this),!0)})}t.addClass("active");this.$copyHelper.val(this.getTokensList(null,null,!0)).select()}},activateAll:function(){var t=this;this.$wrapper.find(".token").each(function(i){t.activate(n(this),i!==0,!1,!1)})},deactivate:function(n){n&&(n.removeClass("active"),this.$copyHelper.val(this.getTokensList(null,null,!0)).select())},toggle:function(n){n&&(n.toggleClass("active"),this.$copyHelper.val(this.getTokensList(null,null,!0)).select())},edit:function(t){var f,e;if(t){var r=t.data("value"),u=t.find(".token-label").text(),i=n.Event("beforeEditToken");(i.token={value:r,label:u},i.relatedTarget=t.get(0),this.$element.trigger(i),i.token)&&(r=i.token.value,u=i.token.label,t.find(".token-label").text(r),f=t.outerWidth(),e=this.$input.hasClass("tt-query")?this.$input.parent():this.$input,t.replaceWith(e),this.preventCreateTokens=!0,this.$input.val(r).select().data("edit",!0).width(f))}},unedit:function(n){var i=this.$input.hasClass("tt-query")?this.$input.parent():this.$input,t;i.appendTo(this.$wrapper);this.$input.data("edit",!1);this.update();n&&(t=this,setTimeout(function(){t.$input.focus()},1))},remove:function(t,i){var r,i,e,u,f;this.$input.is(document.activeElement)||this.disabled||(r=t.type==="click"?n(t.target).closest(".token"):this.$wrapper.find(".token.active"),t.type!=="click"&&(i||(i="prev"),this[i](),i==="prev"&&(e=r.first().prevAll(".token:first").length===0)),u=n.Event("removeToken"),u.token=this.getTokenData(r),f=n.Event("change"),f.initiator="tokenfield",r.remove(),this.$element.val(this.getTokensList()).trigger(u).trigger(f),(!this.$wrapper.find(".token").length||t.type==="click"||e)&&this.$input.focus(),this.$input.css("width",this.options.minWidth+"px"),this.update(),t.preventDefault(),t.stopPropagation())},update:function(){var n=this.$input.val(),t;if(this.$input.data("edit")){if(n||(n=this.$input.prop("placeholder")),n===this.$mirror.text())return;if(this.$mirror.text(n),t=this.$mirror.width()+10,t>this.$wrapper.width())return this.$input.width(this.$wrapper.width());this.$input.width(t)}else{if(this.$input.css("width",this.options.minWidth+"px"),this.direction==="right")return this.$input.width(this.$input.offset().left+this.$input.outerWidth()-this.$wrapper.offset().left-parseInt(this.$wrapper.css("padding-left"),10)-1);this.$input.width(this.$wrapper.offset().left+this.$wrapper.width()+parseInt(this.$wrapper.css("padding-left"),10)-this.$input.offset().left)}},focusInput:function(t){if(!n(t.target).closest(".token").length&&!n(t.target).closest(".token-input").length){var i=this;setTimeout(function(){i.$input.focus()},0)}},search:function(){this.$input.data("ui-autocomplete")&&this.$input.autocomplete("search")},disable:function(){this.disabled=!0;this.$input.prop("disabled",!0);this.$element.prop("disabled",!0);this.$wrapper.addClass("disabled")},enable:function(){this.disabled=!1;this.$input.prop("disabled",!1);this.$element.prop("disabled",!1);this.$wrapper.removeClass("disabled")}},i=n.fn.tokenfield,n.fn.tokenfield=function(i){var r,u=[],f;return Array.prototype.push.apply(u,arguments),f=this.each(function(){var e=n(this),f=e.data("bs.tokenfield"),o=typeof i=="object"&&i;typeof i=="string"&&f&&f[i]?(u.shift(),r=f[i].apply(f,u)):f||e.data("bs.tokenfield",f=new t(this,o))}),typeof r!="undefined"?r:f},n.fn.tokenfield.defaults={minWidth:60,minLength:0,allowDuplicates:!1,autocomplete:{},typeahead:{},showAutocompleteOnFocus:!1,createTokensOnBlur:!1,delimiter:",",beautify:!0},n.fn.tokenfield.Constructor=t,n.fn.tokenfield.noConflict=function(){return n.fn.tokenfield=i,this},t});
/*
//# sourceMappingURL=bootstrap-tokenfield.min.js.map
*/