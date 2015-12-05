/* Thursday 17th of September 2015 12:57:22 PM*/



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
    this.NClass = function() {
    };

    // Create a new Class that inherits from this class
    NClass.extend = function(prop) {
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
        function NClass() {
            var $this = this;
            // All construction is actually done in the init method
            if (!initializing && this.init)
                this.init.apply(this, arguments);
        }

        // Populate our constructed prototype object
        NClass.prototype = prototype;

        // Enforce the constructor to be what we expect
        NClass.prototype.constructor = NClass;

        // And make this class extendable
        NClass.extend = arguments.callee;

        return NClass;
    };
})();

window.njQuery = typeof jQuery == "undefined" ? null : jQuery;

(function ($) {
    if(typeof bindNextendQ != 'undefined'){
        $.each(bindNextendQ, function (index, a) {
            $(a[0])[a[1]](a[2]);
        });
    }
})(njQuery);
(function($) {
    var uaMatch = '', 
        prefix = '',
        html = $('html'),
        dir = $(document.documentElement).attr('dir');
    if(!dir) dir = 'ltr';
    html.addClass('x-'+dir);
    window.nextendDir = dir;

    if (navigator.userAgent.match(/Windows/))
    {
        html.addClass('x-win');
    }
    else if (navigator.userAgent.match(/Mac OS X/))
    {
        html.addClass('x-mac');
    }
    else if (navigator.userAgent.match(/X11/))
    {
        html.addClass('x-x11');
    }

    if (navigator.userAgent.match(/Chrome/))
    {
        uaMatch = ' Chrome/';
        prefix = 'x-chrome';
    }
    else if (navigator.userAgent.match(/Safari/))
    {
        uaMatch = ' Version/';
        prefix = 'x-safari';
    }
    else if (navigator.userAgent.match(/Firefox/))
    {
        uaMatch = ' Firefox/';
        prefix = 'x-firefox';
    }
    else if (navigator.userAgent.match(/MSIE/))
    {
        uaMatch = ' MSIE ';
        prefix = 'x-msie';
    }else if(!!navigator.userAgent.match(/Trident/)){
        uaMatch = ' rv:';
        prefix = 'x-msie';
    }
    if (prefix)
    {
        html.addClass(prefix);

        uaMatch = new RegExp(uaMatch + '(\\d+)\.(\\d+)');
        var uaMatch = navigator.userAgent.match(uaMatch);
        if (uaMatch && uaMatch[1])
        {
            html.addClass(prefix + '-' + uaMatch[1]);
            html.addClass(prefix + '-' + uaMatch[1] + '-' + uaMatch[2]);
        }
    }
    $(window).load(function(){
        setTimeout(function(){
            html.addClass('x-ready');
        }, 500);
    });
})(njQuery);/**
 * jquery.unique-element-id.js
 *
 * A simple jQuery plugin to get a unique ID for
 * any HTML element
 *
 * Usage:
 *    $('some_element_selector').uid();
 *
 * by Jamie Rumbelow <jamie@jamierumbelow.net>
 * http://jamieonsoftware.com
 * Copyright (c)2011 Jamie Rumbelow
 *
 * Licensed under the MIT license (http://www.opensource.org/licenses/MIT)
 */

(function($){
    /**
     * Generate a new unqiue ID
     */
    function generateUniqueId() {

        // Return a unique ID
        return "nextend-element-" + Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
    }

    /**
     * Get a unique ID for an element, ensuring that the
     * element has an id="" attribute
     */
    $.fn.uid = function(){
        // We need an element! Check the selector returned something
        if (!this.length > 0) {
            return generateUniqueId();
        }

        // Act on only the first element. Also, fetch the element's ID attr
        var first_element = this.first();

        // No? Generate one!
        id_attr = generateUniqueId();

        // And set the ID attribute
        first_element.attr('id', id_attr);

        // Return it
        return id_attr;
    };
})(njQuery);/*! qTip2 v2.0.1-28- (includes: svg ajax tips modal viewport imagemap ie6 / basic css3) | qtip2.com | Licensed MIT, GPL | Fri Mar 01 2013 22:50:30 */

(function (jQuery) {

(function(e,t,n){(function(e){"use strict";typeof define=="function"&&define.amd?define(["jquery"],e):jQuery&&!jQuery.fn.qtip&&e(jQuery)})(function(r){function P(n){S={pageX:n.pageX,pageY:n.pageY,type:"mousemove",scrollX:e.pageXOffset||t.body.scrollLeft||t.documentElement.scrollLeft,scrollY:e.pageYOffset||t.body.scrollTop||t.documentElement.scrollTop}}function H(e){var t=function(e){return e===o||"object"!=typeof e},n=function(e){return!r.isFunction(e)&&(!e&&!e.attr||e.length<1||"object"==typeof e&&!e.jquery&&!e.then)};if(!e||"object"!=typeof e)return s;t(e.metadata)&&(e.metadata={type:e.metadata});if("content"in e){if(t(e.content)||e.content.jquery)e.content={text:e.content};n(e.content.text||s)&&(e.content.text=s),"title"in e.content&&(t(e.content.title)&&(e.content.title={text:e.content.title}),n(e.content.title.text||s)&&(e.content.title.text=s))}return"position"in e&&t(e.position)&&(e.position={my:e.position,at:e.position}),"show"in e&&t(e.show)&&(e.show=e.show.jquery?{target:e.show}:e.show===i?{ready:i}:{event:e.show}),"hide"in e&&t(e.hide)&&(e.hide=e.hide.jquery?{target:e.hide}:{event:e.hide}),"style"in e&&t(e.style)&&(e.style={classes:e.style}),r.each(E,function(){this.sanitize&&this.sanitize(e)}),e}function B(n,u,a,f){function R(e){var t=0,n,r=u,i=e.split(".");while(r=r[i[t++]])t<i.length&&(n=r);return[n||u,i.pop()]}function U(e){return C.concat("").join(e?"-"+e+" ":" ")}function z(){var e=u.style.widget,t=B.hasClass(F);B.removeClass(F),F=e?"ui-state-disabled":"qtip-disabled",B.toggleClass(F,t),B.toggleClass("ui-helper-reset "+U(),e).toggleClass(L,u.style.def&&!e),I.content&&I.content.toggleClass(U("content"),e),I.titlebar&&I.titlebar.toggleClass(U("header"),e),I.button&&I.button.toggleClass(x+"-icon",!e)}function W(e){I.title&&(I.titlebar.remove(),I.titlebar=I.title=I.button=o,e!==s&&l.reposition())}function X(){var e=u.content.title.button,t=typeof e=="string",n=t?e:"Close tooltip";I.button&&I.button.remove(),e.jquery?I.button=e:I.button=r("<a />",{"class":"qtip-close "+(u.style.widget?"":x+"-icon"),title:n,"aria-label":n}).prepend(r("<span />",{"class":"ui-icon ui-icon-close",html:"&times;"})),I.button.appendTo(I.titlebar||B).attr("role","button").click(function(e){return B.hasClass(F)||l.hide(e),s})}function V(){var e=g+"-title";I.titlebar&&W(),I.titlebar=r("<div />",{"class":x+"-titlebar "+(u.style.widget?U("header"):"")}).append(I.title=r("<div />",{id:e,"class":x+"-title","aria-atomic":i})).insertBefore(I.content).delegate(".qtip-close","mousedown keydown mouseup keyup mouseout",function(e){r(this).toggleClass("ui-state-active ui-state-focus",e.type.substr(-4)==="down")}).delegate(".qtip-close","mouseover mouseout",function(e){r(this).toggleClass("ui-state-hover",e.type==="mouseover")}),u.content.title.button&&X()}function $(e){var t=I.button;if(!l.rendered)return s;e?X():t.remove()}function J(e,t){var i=I.title;if(!l.rendered||!e)return s;r.isFunction(e)&&(e=e.call(n,q.event,l));if(e===s||!e&&e!=="")return W(s);e.jquery&&e.length>0?i.empty().append(e.css({display:"block"})):i.html(e),t!==s&&l.rendered&&B[0].offsetWidth>0&&l.reposition(q.event)}function K(e){e&&r.isFunction(e.done)&&e.done(function(e){Q(e,null,s)})}function Q(e,t,i){function a(e){function s(t){if(t.src===b||r.inArray(t,i)!==-1)return;i.push(t),r.data(t,"imagesLoaded",{src:t.src}),n.length===i.length&&(setTimeout(e),n.unbind(".imagesLoaded"))}var t=r(this),n=t.find("img").add(t.filter("img")),i=[];if(!n.length)return e();n.bind("load.imagesLoaded error.imagesLoaded",function(e){s(e.target)}).each(function(e,t){var n=t.src,i=r.data(t,"imagesLoaded");if(i&&i.src===n||t.complete&&t.naturalWidth)s(t);else if(t.readyState||t.complete)t.src=b,t.src=n})}var o=I.content;return!l.rendered||!e?s:(r.isFunction(e)&&(e=e.call(n,q.event,l)||""),i!==s&&K(u.content.deferred),e.jquery&&e.length>0?o.empty().append(e.css({display:"block"})):o.html(e),l.rendered<0?B.queue("fx",a):(M=0,a.call(B[0],r.noop)),l)}function G(){function p(e){if(B.hasClass(F))return s;clearTimeout(l.timers.show),clearTimeout(l.timers.hide);var t=function(){l.toggle(i,e)};u.show.delay>0?l.timers.show=setTimeout(t,u.show.delay):t()}function d(e){if(B.hasClass(F)||y||M)return s;var t=r(e.relatedTarget),n=t.closest(k)[0]===B[0],i=t[0]===f.show[0];clearTimeout(l.timers.show),clearTimeout(l.timers.hide);if(this!==t[0]&&o.target==="mouse"&&n||u.hide.fixed&&/mouse(out|leave|move)/.test(e.type)&&(n||i)){try{e.preventDefault(),e.stopImmediatePropagation()}catch(a){}return}u.hide.delay>0?l.timers.hide=setTimeout(function(){l.hide(e)},u.hide.delay):l.hide(e)}function v(e){if(B.hasClass(F))return s;clearTimeout(l.timers.inactive),l.timers.inactive=setTimeout(function(){l.hide(e)},u.hide.inactive)}function m(e){l.rendered&&B[0].offsetWidth>0&&l.reposition(e)}var o=u.position,f={show:u.show.target,hide:u.hide.target,viewport:r(o.viewport),document:r(t),body:r(t.body),window:r(e)},c={show:r.trim(""+u.show.event).split(" "),hide:r.trim(""+u.hide.event).split(" ")},h=E.ie===6;B.bind("mouseenter"+j+" mouseleave"+j,function(e){var t=e.type==="mouseenter";t&&l.focus(e),B.toggleClass(O,t)}),/mouse(out|leave)/i.test(u.hide.event)&&u.hide.leave==="window"&&f.document.bind("mouseout"+j+" blur"+j,function(e){!/select|option/.test(e.target.nodeName)&&!e.relatedTarget&&l.hide(e)}),u.hide.fixed?(f.hide=f.hide.add(B),B.bind("mouseover"+j,function(){B.hasClass(F)||clearTimeout(l.timers.hide)})):/mouse(over|enter)/i.test(u.show.event)&&f.hide.bind("mouseleave"+j,function(e){clearTimeout(l.timers.show)}),(""+u.hide.event).indexOf("unfocus")>-1&&o.container.closest("html").bind("mousedown"+j+" touchstart"+j,function(e){var t=r(e.target),i=l.rendered&&!B.hasClass(F)&&B[0].offsetWidth>0,s=t.parents(k).filter(B[0]).length>0;t[0]!==n[0]&&t[0]!==B[0]&&!s&&!n.has(t[0]).length&&i&&l.hide(e)}),"number"==typeof u.hide.inactive&&(f.show.bind("qtip-"+a+"-inactive",v),r.each(w.inactiveEvents,function(e,t){f.hide.add(I.tooltip).bind(t+j+"-inactive",v)})),r.each(c.hide,function(e,t){var n=r.inArray(t,c.show),i=r(f.hide);n>-1&&i.add(f.show).length===i.length||t==="unfocus"?(f.show.bind(t+j,function(e){B[0].offsetWidth>0?d(e):p(e)}),delete c.show[n]):f.hide.bind(t+j,d)}),r.each(c.show,function(e,t){f.show.bind(t+j,p)}),"number"==typeof u.hide.distance&&f.show.add(B).bind("mousemove"+j,function(e){var t=q.origin||{},n=u.hide.distance,r=Math.abs;(r(e.pageX-t.pageX)>=n||r(e.pageY-t.pageY)>=n)&&l.hide(e)}),o.target==="mouse"&&(f.show.bind("mousemove"+j,P),o.adjust.mouse&&(u.hide.event&&(B.bind("mouseleave"+j,function(e){(e.relatedTarget||e.target)!==f.show[0]&&l.hide(e)}),I.target.bind("mouseenter"+j+" mouseleave"+j,function(e){q.onTarget=e.type==="mouseenter"})),f.document.bind("mousemove"+j,function(e){l.rendered&&q.onTarget&&!B.hasClass(F)&&B[0].offsetWidth>0&&l.reposition(e||S)}))),(o.adjust.resize||f.viewport.length)&&(r.event.special.resize?f.viewport:f.window).bind("resize"+j,m),o.adjust.scroll&&f.window.add(o.container).bind("scroll"+j,m)}function Y(){var n=[u.show.target[0],u.hide.target[0],l.rendered&&I.tooltip[0],u.position.container[0],u.position.viewport[0],u.position.container.closest("html")[0],e,t];l.rendered?r([]).pushStack(r.grep(n,function(e){return typeof e=="object"})).unbind(j):u.show.target.unbind(j+"-create")}var l=this,m=t.body,g=x+"-"+a,y=0,M=0,B=r(),j=".qtip-"+a,F="qtip-disabled",I,q;l.id=a,l.rendered=s,l.destroyed=s,l.elements=I={target:n},l.timers={img:{}},l.options=u,l.checks={},l.plugins={},l.cache=q={event:{},target:r(),disabled:s,attr:f,onTarget:s,lastClass:""},l.checks.builtin={"^id$":function(e,t,n){var o=n===i?w.nextid:n,u=x+"-"+o;o!==s&&o.length>0&&!r("#"+u).length&&(B[0].id=u,I.content[0].id=u+"-content",I.title[0].id=u+"-title")},"^content.text$":function(e,t,n){Q(u.content.text)},"^content.deferred$":function(e,t,n){K(u.content.deferred)},"^content.title.text$":function(e,t,n){if(!n)return W();!I.title&&n&&V(),J(n)},"^content.title.button$":function(e,t,n){$(n)},"^position.(my|at)$":function(e,t,n){"string"==typeof n&&(e[t]=new E.Corner(n))},"^position.container$":function(e,t,n){l.rendered&&B.appendTo(n)},"^show.ready$":function(){l.rendered?l.toggle(i):l.render(1)},"^style.classes$":function(e,t,n){B.attr("class",x+" qtip "+n)},"^style.width|height":function(e,t,n){B.css(t,n)},"^style.widget|content.title":z,"^events.(render|show|move|hide|focus|blur)$":function(e,t,n){B[(r.isFunction(n)?"":"un")+"bind"]("tooltip"+t,n)},"^(show|hide|position).(event|target|fixed|inactive|leave|distance|viewport|adjust)":function(){var e=u.position;B.attr("tracking",e.target==="mouse"&&e.adjust.mouse),Y(),G()}},r.extend(l,{_triggerEvent:function(e,t,n){var i=r.Event("tooltip"+e);return i.originalEvent=(n?r.extend({},n):o)||q.event||o,B.trigger(i,[l].concat(t||[])),!i.isDefaultPrevented()},render:function(e){if(l.rendered)return l;var t=u.content.text,o=u.content.title,a=u.position;return r.attr(n[0],"aria-describedby",g),B=I.tooltip=r("<div/>",{id:g,"class":[x,L,u.style.classes,x+"-pos-"+u.position.my.abbrev()].join(" "),width:u.style.width||"",height:u.style.height||"",tracking:a.target==="mouse"&&a.adjust.mouse,role:"alert","aria-live":"polite","aria-atomic":s,"aria-describedby":g+"-content","aria-hidden":i}).toggleClass(F,q.disabled).data("qtip",l).appendTo(u.position.container).append(I.content=r("<div />",{"class":x+"-content",id:g+"-content","aria-atomic":i})),l.rendered=-1,y=1,o.text?(V(),r.isFunction(o.text)||J(o.text,s)):o.button&&X(),(!r.isFunction(t)||t.then)&&Q(t,s),l.rendered=i,z(),r.each(u.events,function(e,t){r.isFunction(t)&&B.bind(e==="toggle"?"tooltipshow tooltiphide":"tooltip"+e,t)}),r.each(E,function(){this.initialize==="render"&&this(l)}),G(),B.queue("fx",function(t){l._triggerEvent("render"),y=0,(u.show.ready||e)&&l.toggle(i,q.event,s),t()}),l},get:function(e){var t,n;switch(e.toLowerCase()){case"dimensions":t={height:B.outerHeight(s),width:B.outerWidth(s)};break;case"offset":t=E.offset(B,u.position.container);break;default:n=R(e.toLowerCase()),t=n[0][n[1]],t=t.precedance?t.string():t}return t},set:function(e,t){function p(e,t){var n,r,i;for(n in c)for(r in c[n])if(i=(new RegExp(r,"i")).exec(e))t.push(i),c[n][r].apply(l,t)}var n=/^position\.(my|at|adjust|target|container)|style|content|show\.ready/i,a=/^content\.(title|attr)|style/i,f=s,c=l.checks,h;return"string"==typeof e?(h=e,e={},e[h]=t):e=r.extend(i,{},e),r.each(e,function(t,i){var s=R(t.toLowerCase()),o;o=s[0][s[1]],s[0][s[1]]="object"==typeof i&&i.nodeType?r(i):i,e[t]=[s[0],s[1],i,o],f=n.test(t)||f}),H(u),y=1,r.each(e,p),y=0,l.rendered&&B[0].offsetWidth>0&&f&&l.reposition(u.position.target==="mouse"?o:q.event),l},toggle:function(e,n){function w(){e?(E.ie&&B[0].style.removeAttribute("filter"),B.css("overflow",""),"string"==typeof f.autofocus&&r(f.autofocus,B).focus(),f.target.trigger("qtip-"+a+"-inactive")):B.css({display:"",visibility:"",opacity:"",left:"",top:""}),l._triggerEvent(e?"visible":"hidden")}if(n){if(/over|enter/.test(n.type)&&/out|leave/.test(q.event.type)&&u.show.target.add(n.target).length===u.show.target.length&&B.has(n.relatedTarget).length)return l;q.event=r.extend({},n)}if(!l.rendered)return e?l.render(1):l;var o=e?"show":"hide",f=u[o],c=u[e?"hide":"show"],h=u.position,p=u.content,d=B.css("width"),v=B[0].offsetWidth>0,m=e||f.target.length===1,g=!n||f.target.length<2||q.target[0]===n.target,y,b;return(typeof e).search("boolean|number")&&(e=!v),!B.is(":animated")&&v===e&&g?l:l._triggerEvent(o,[90])?(r.attr(B[0],"aria-hidden",!e),e?(q.origin=r.extend({},S),l.focus(n),r.isFunction(p.text)&&Q(p.text,s),r.isFunction(p.title.text)&&J(p.title.text,s),!D&&h.target==="mouse"&&h.adjust.mouse&&(r(t).bind("mousemove.qtip",P),D=i),d||B.css("width",B.outerWidth()),l.reposition(n,arguments[2]),d||B.css("width",""),!f.solo||(typeof f.solo=="string"?r(f.solo):r(k,f.solo)).not(B).not(f.target).qtip("hide",r.Event("tooltipsolo"))):(clearTimeout(l.timers.show),delete q.origin,D&&!r(k+'[tracking="true"]:visible',f.solo).not(B).length&&(r(t).unbind("mousemove.qtip"),D=s),l.blur(n)),f.effect===s||m===s?(B[o](),w.call(B)):r.isFunction(f.effect)?(B.stop(1,1),f.effect.call(B,l),B.queue("fx",function(e){w(),e()})):B.fadeTo(90,e?1:0,w),e&&f.target.trigger("qtip-"+a+"-inactive"),l):l},show:function(e){return l.toggle(i,e)},hide:function(e){return l.toggle(s,e)},focus:function(e){if(!l.rendered)return l;var t=r(k),n=parseInt(B[0].style.zIndex,10),i=w.zindex+t.length,s=r.extend({},e),o;return B.hasClass(A)||l._triggerEvent("focus",[i],s)&&(n!==i&&(t.each(function(){this.style.zIndex>n&&(this.style.zIndex=this.style.zIndex-1)}),t.filter("."+A).qtip("blur",s)),B.addClass(A)[0].style.zIndex=i),l},blur:function(e){return B.removeClass(A),l._triggerEvent("blur",[B.css("zIndex")],e),l},reposition:function(n,i){if(!l.rendered||y)return l;y=1;var o=u.position.target,a=u.position,f=a.my,m=a.at,g=a.adjust,b=g.method.split(" "),w=B.outerWidth(s),x=B.outerHeight(s),T=0,N=0,C=B.css("position"),k=a.viewport,L={left:0,top:0},A=a.container,O=B[0].offsetWidth>0,M=n&&n.type==="scroll",_=r(e),D,P;if(r.isArray(o)&&o.length===2)m={x:h,y:c},L={left:o[0],top:o[1]};else if(o==="mouse"&&(n&&n.pageX||q.event.pageX))m={x:h,y:c},n=S&&S.pageX&&(g.mouse||!n||!n.pageX)?{pageX:S.pageX,pageY:S.pageY}:(!n||n.type!=="resize"&&n.type!=="scroll"?n&&n.pageX&&n.type==="mousemove"?n:(!g.mouse||u.show.distance)&&q.origin&&q.origin.pageX?q.origin:n:q.event)||n||q.event||S||{},C!=="static"&&(L=A.offset()),L={left:n.pageX-L.left,top:n.pageY-L.top},g.mouse&&M&&(L.left-=S.scrollX-_.scrollLeft(),L.top-=S.scrollY-_.scrollTop());else{o==="event"&&n&&n.target&&n.type!=="scroll"&&n.type!=="resize"?q.target=r(n.target):o!=="event"&&(q.target=r(o.jquery?o:I.target)),o=q.target,o=r(o).eq(0);if(o.length===0)return l;o[0]===t||o[0]===e?(T=E.iOS?e.innerWidth:o.width(),N=E.iOS?e.innerHeight:o.height(),o[0]===e&&(L={top:(k||o).scrollTop(),left:(k||o).scrollLeft()})):E.imagemap&&o.is("area")?D=E.imagemap(l,o,m,E.viewport?b:s):E.svg&&o[0].ownerSVGElement?D=E.svg(l,o,m,E.viewport?b:s):(T=o.outerWidth(s),N=o.outerHeight(s),L=E.offset(o,A)),D&&(T=D.width,N=D.height,P=D.offset,L=D.position);if(E.iOS>3.1&&E.iOS<4.1||E.iOS>=4.3&&E.iOS<4.33||!E.iOS&&C==="fixed")L.left-=_.scrollLeft(),L.top-=_.scrollTop();L.left+=m.x===d?T:m.x===v?T/2:0,L.top+=m.y===p?N:m.y===v?N/2:0}return L.left+=g.x+(f.x===d?-w:f.x===v?-w/2:0),L.top+=g.y+(f.y===p?-x:f.y===v?-x/2:0),E.viewport?(L.adjusted=E.viewport(l,L,a,T,N,w,x),P&&L.adjusted.left&&(L.left+=P.left),P&&L.adjusted.top&&(L.top+=P.top)):L.adjusted={left:0,top:0},l._triggerEvent("move",[L,k.elem||k],n)?(delete L.adjusted,i===s||!O||isNaN(L.left)||isNaN(L.top)||o==="mouse"||!r.isFunction(a.effect)?B.css(L):r.isFunction(a.effect)&&(a.effect.call(B,l,r.extend({},L)),B.queue(function(e){r(this).css({opacity:"",height:""}),E.ie&&this.style.removeAttribute("filter"),e()})),y=0,l):l},disable:function(e){return"boolean"!=typeof e&&(e=!B.hasClass(F)&&!q.disabled),l.rendered?(B.toggleClass(F,e),r.attr(B[0],"aria-disabled",e)):q.disabled=!!e,l},enable:function(){return l.disable(s)},destroy:function(e){function t(){var e=n[0],t=r.attr(e,_),i=n.data("qtip");l.rendered&&(r.each(l.plugins,function(e){this.destroy&&this.destroy(),delete l.plugins[e]}),B.stop(1,0).find("*").remove().end().remove(),l.rendered=s),clearTimeout(l.timers.show),clearTimeout(l.timers.hide),Y();if(!i||l===i)n.removeData("qtip").removeAttr(T),u.suppress&&t&&(n.attr("title",t),n.removeAttr(_)),n.removeAttr("aria-describedby");n.unbind(".qtip-"+a),delete N[l.id],delete l.options,delete l.elements,delete l.cache,delete l.timers,delete l.checks}if(l.destroyed)return;return l.destroyed=i,e===i?t():(B.bind("tooltiphidden",t),l.hide()),n}})}function j(e,n,u){var a,f,l,c,h,p=r(t.body),d=e[0]===t?p:e,v=e.metadata?e.metadata(u.metadata):o,m=u.metadata.type==="html5"&&v?v[u.metadata.name]:o,g=e.data(u.metadata.name||"qtipopts");try{g=typeof g=="string"?r.parseJSON(g):g}catch(y){}c=r.extend(i,{},w.defaults,u,typeof g=="object"?H(g):o,H(m||v)),f=c.position,c.id=n;if("boolean"==typeof c.content.text){l=e.attr(c.content.attr);if(c.content.attr===s||!l)return s;c.content.text=l}f.container.length||(f.container=p),f.target===s&&(f.target=d),c.show.target===s&&(c.show.target=d),c.show.solo===i&&(c.show.solo=f.container.closest("body")),c.hide.target===s&&(c.hide.target=d),c.position.viewport===i&&(c.position.viewport=f.container),f.container=f.container.eq(0),f.at=new E.Corner(f.at),f.my=new E.Corner(f.my);if(e.data("qtip"))if(c.overwrite)e.qtip("destroy");else if(c.overwrite===s)return s;return e.attr(T,!0),c.suppress&&(h=e.attr("title"))&&e.removeAttr("title").attr(_,h).attr("title",""),a=new B(e,c,n,!!l),e.data("qtip",a),e.one("remove.qtip-"+n+" removeqtip.qtip-"+n,function(){var e;(e=r(this).data("qtip"))&&e.destroy()}),a}function R(e){var t=this,n=e.elements.tooltip,o=e.options.content.ajax,u=w.defaults.content.ajax,a=i,f=s,l;e.checks.ajax={"^content.ajax":function(e,r,i){r==="ajax"&&(o=i),r==="once"?t.init():o&&o.url?t.load():n.unbind(I)}},r.extend(t,{init:function(){return o&&o.url&&n.unbind(I)[o.once?"one":"bind"]("tooltipshow"+I,t.load),t},load:function(n){function m(){var t;if(e.destroyed)return;a=s,d&&(f=i,e.show(n.originalEvent)),(t=u.complete||o.complete)&&r.isFunction(t)&&t.apply(o.context||e,arguments)}function g(t,n,i){var s;if(e.destroyed)return;p&&"string"==typeof t&&(t=r("<div/>").append(t.replace(q,"")).find(p)),(s=u.success||o.success)&&r.isFunction(s)?s.call(o.context||e,t,n,i):e.set("content.text",t)}function y(t,n,r){if(e.destroyed||t.status===0)return;e.set("content.text",n+": "+r)}if(f){f=s;return}var c=o.url.lastIndexOf(" "),h=o.url,p,d=!o.loading&&a;if(d)try{n.preventDefault()}catch(v){}else if(n&&n.isDefaultPrevented())return t;l&&l.abort&&l.abort(),c>-1&&(p=h.substr(c),h=h.substr(0,c)),l=r.ajax(r.extend({error:u.error||y,context:e},o,{url:h,success:g,complete:m}))},destroy:function(){l&&l.abort&&l.abort(),e.destroyed=i}}),t.init()}function X(e,t,n){var r=Math.ceil(t/2),i=Math.ceil(n/2),s={bottomright:[[0,0],[t,n],[t,0]],bottomleft:[[0,0],[t,0],[0,n]],topright:[[0,n],[t,0],[t,n]],topleft:[[0,0],[0,n],[t,n]],topcenter:[[0,n],[r,0],[t,n]],bottomcenter:[[0,0],[t,0],[r,n]],rightcenter:[[0,0],[t,i],[0,n]],leftcenter:[[t,0],[t,n],[0,i]]};return s.lefttop=s.bottomright,s.righttop=s.bottomleft,s.leftbottom=s.topright,s.rightbottom=s.topleft,s[e.string()]}function V(e,t){function k(e){var t=w.is(":visible");w.show(),e(),w.toggle(t)}function L(){x.width=g.height,x.height=g.width}function A(){x.width=g.width,x.height=g.height}function O(t,r,o,f){if(!b.tip)return;var l=m.corner.clone(),w=o.adjusted,E=e.options.position.adjust.method.split(" "),x=E[0],T=E[1]||E[0],N={left:s,top:s,x:0,y:0},C,k={},L;m.corner.fixed!==i&&(x===y&&l.precedance===u&&w.left&&l.y!==v?l.precedance=l.precedance===u?a:u:x!==y&&w.left&&(l.x=l.x===v?w.left>0?h:d:l.x===h?d:h),T===y&&l.precedance===a&&w.top&&l.x!==v?l.precedance=l.precedance===a?u:a:T!==y&&w.top&&(l.y=l.y===v?w.top>0?c:p:l.y===c?p:c),l.string()!==S.corner.string()&&(S.top!==w.top||S.left!==w.left)&&m.update(l,s)),C=m.position(l,w),C[l.x]+=_(l,l.x),C[l.y]+=_(l,l.y),C.right!==n&&(C.left=-C.right),C.bottom!==n&&(C.top=-C.bottom),C.user=Math.max(0,g.offset);if(N.left=x===y&&!!w.left)l.x===v?k["margin-left"]=N.x=C["margin-left"]-w.left:(L=C.right!==n?[w.left,-C.left]:[-w.left,C.left],(N.x=Math.max(L[0],L[1]))>L[0]&&(o.left-=w.left,N.left=s),k[C.right!==n?d:h]=N.x);if(N.top=T===y&&!!w.top)l.y===v?k["margin-top"]=N.y=C["margin-top"]-w.top:(L=C.bottom!==n?[w.top,-C.top]:[-w.top,C.top],(N.y=Math.max(L[0],L[1]))>L[0]&&(o.top-=w.top,N.top=s),k[C.bottom!==n?p:c]=N.y);b.tip.css(k).toggle(!(N.x&&N.y||l.x===v&&N.y||l.y===v&&N.x)),o.left-=C.left.charAt?C.user:x!==y||N.top||!N.left&&!N.top?C.left:0,o.top-=C.top.charAt?C.user:T!==y||N.left||!N.left&&!N.top?C.top:0,S.left=w.left,S.top=w.top,S.corner=l.clone()}function M(){var t=g.corner,n=e.options.position,r=n.at,o=n.my.string?n.my.string():n.my;return t===s||o===s&&r===s?s:(t===i?m.corner=new E.Corner(o):t.string||(m.corner=new E.Corner(t),m.corner.fixed=i),S.corner=new E.Corner(m.corner.string()),m.corner.string()!=="centercenter")}function _(e,t,n){t=t?t:e[e.precedance];var r=b.titlebar&&e.y===c,i=r?b.titlebar:w,s="border-"+t+"-width",o=function(e){return parseInt(e.css(s),10)},u;return k(function(){u=(n?o(n):o(b.content)||o(i)||o(w))||0}),u}function D(e){var t=b.titlebar&&e.y===c,n=t?b.titlebar:b.content,r="-moz-",i="-webkit-",s="border-radius-"+e.y+e.x,o="border-"+e.y+"-"+e.x+"-radius",u=function(e){return parseInt(n.css(e),10)||parseInt(w.css(e),10)},a;return k(function(){a=u(o)||u(s)||u(r+o)||u(r+s)||u(i+o)||u(i+s)||0}),a}function P(e){function N(e,t,n){var r=e.css(t)||p;return n&&r===e.css(n)?s:f.test(r)?s:r}var t,n,o,u=b.tip.css("cssText",""),a=e||m.corner,f=/rgba?\(0, 0, 0(, 0)?\)|transparent|#123456/i,l="border-"+a[a.precedance]+"-color",h="background-color",p="transparent",d=" !important",y=b.titlebar,E=y&&(a.y===c||a.y===v&&u.position().top+x.height/2+g.offset<y.outerHeight(i)),S=E?y:b.content;k(function(){T.fill=N(u,h)||N(S,h)||N(b.content,h)||N(w,h)||u.css(h),T.border=N(u,l,"color")||N(S,l,"color")||N(b.content,l,"color")||N(w,l,"color")||w.css(l),r("*",u).add(u).css("cssText",h+":"+p+d+";border:0"+d+";")})}function H(e){var t=e.precedance===a,n=x[t?f:l],r=x[t?l:f],i=e.string().indexOf(v)>-1,s=n*(i?.5:1),o=Math.pow,u=Math.round,c,h,p,d=Math.sqrt(o(s,2)+o(r,2)),m=[N/s*d,N/r*d];return m[2]=Math.sqrt(o(m[0],2)-o(N,2)),m[3]=Math.sqrt(o(m[1],2)-o(N,2)),c=d+m[2]+m[3]+(i?0:m[0]),h=c/d,p=[u(h*r),u(h*n)],{height:p[t?0:1],width:p[t?1:0]}}function B(e,t,n){return"<qvml:"+e+' xmlns="urn:schemas-microsoft.com:vml" class="qtip-vml" '+(t||"")+' style="behavior: url(#default#VML); '+(n||"")+'" />'}var m=this,g=e.options.style.tip,b=e.elements,w=b.tooltip,S={top:0,left:0},x={width:g.width,height:g.height},T={},N=g.border||0,C;m.corner=o,m.mimic=o,m.border=N,m.offset=g.offset,m.size=x,e.checks.tip={"^position.my|style.tip.(corner|mimic|border)$":function(){m.init()||m.destroy(),e.reposition()},"^style.tip.(height|width)$":function(){x={width:g.width,height:g.height},m.create(),m.update(),e.reposition()},"^content.title.text|style.(classes|widget)$":function(){b.tip&&b.tip.length&&m.update()}},r.extend(m,{init:function(){var e=M()&&(W||E.ie);return e&&(m.create(),m.update(),w.unbind(z).bind("tooltipmove"+z,O)),e},create:function(){var e=x.width,t=x.height,n;b.tip&&b.tip.remove(),b.tip=r("<div />",{"class":"qtip-tip"}).css({width:e,height:t}).prependTo(w),W?r("<canvas />").appendTo(b.tip)[0].getContext("2d").save():(n=B("shape",'coordorigin="0,0"',"position:absolute;"),b.tip.html(n+n),r("*",b.tip).bind("click"+z+" mousedown"+z,function(e){e.stopPropagation()}))},update:function(e,t){var n=b.tip,f=n.children(),l=x.width,y=x.height,C=g.mimic,k=Math.round,O,M,D,j,F;e||(e=S.corner||m.corner),C===s?C=e:(C=new E.Corner(C),C.precedance=e.precedance,C.x==="inherit"?C.x=e.x:C.y==="inherit"?C.y=e.y:C.x===C.y&&(C[e.precedance]=e[e.precedance])),O=C.precedance,e.precedance===u?L():A(),b.tip.css({width:l=x.width,height:y=x.height}),P(e),T.border!=="transparent"?(N=_(e,o),g.border===0&&N>0&&(T.fill=T.border),m.border=N=g.border!==i?g.border:N):m.border=N=0,D=X(C,l,y),m.size=F=H(e),n.css(F).css("line-height",F.height+"px"),e.precedance===a?j=[k(C.x===h?N:C.x===d?F.width-l-N:(F.width-l)/2),k(C.y===c?F.height-y:0)]:j=[k(C.x===h?F.width-l:0),k(C.y===c?N:C.y===p?F.height-y-N:(F.height-y)/2)],W?(f.attr(F),M=f[0].getContext("2d"),M.restore(),M.save(),M.clearRect(0,0,3e3,3e3),M.fillStyle=T.fill,M.strokeStyle=T.border,M.lineWidth=N*2,M.lineJoin="miter",M.miterLimit=100,M.translate(j[0],j[1]),M.beginPath(),M.moveTo(D[0][0],D[0][1]),M.lineTo(D[1][0],D[1][1]),M.lineTo(D[2][0],D[2][1]),M.closePath(),N&&(w.css("background-clip")==="border-box"&&(M.strokeStyle=T.fill,M.stroke()),M.strokeStyle=T.border,M.stroke()),M.fill()):(D="m"+D[0][0]+","+D[0][1]+" l"+D[1][0]+","+D[1][1]+" "+D[2][0]+","+D[2][1]+" xe",j[2]=N&&/^(r|b)/i.test(e.string())?E.ie===8?2:1:0,f.css({coordsize:l+N+" "+(y+N),antialias:""+(C.string().indexOf(v)>-1),left:j[0],top:j[1],width:l+N,height:y+N}).each(function(e){var t=r(this);t[t.prop?"prop":"attr"]({coordsize:l+N+" "+(y+N),path:D,fillcolor:T.fill,filled:!!e,stroked:!e}).toggle(!!N||!!e),!e&&t.html()===""&&t.html(B("stroke",'weight="'+N*2+'px" color="'+T.border+'" miterlimit="1000" joinstyle="miter"'))})),setTimeout(function(){b.tip.css({display:"inline-block",visibility:"visible"})},1),t!==s&&m.position(e)},position:function(e){var t=b.tip,n={},i=Math.max(0,g.offset),o,p,d;return g.corner===s||!t?s:(e=e||m.corner,o=e.precedance,p=H(e),d=[e.x,e.y],o===u&&d.reverse(),r.each(d,function(t,r){var s,u,d;r===v?(s=o===a?h:c,n[s]="50%",n["margin-"+s]=-Math.round(p[o===a?f:l]/2)+i):(s=_(e,r),u=_(e,r,b.content),d=D(e),n[r]=t?u:i+(d>s?d:-s))}),n[e[o]]-=p[o===u?f:l],t.css({top:"",bottom:"",left:"",right:"",margin:""}).css(n),n)},destroy:function(){w.unbind(z),b.tip&&b.tip.find("*").remove().end().remove(),delete m.corner,delete m.mimic,delete m.size}}),m.init()}function Y(e){var n=this,o=e.options.show.modal,u=e.elements,a=u.tooltip,f=G+e.id,l;e.checks.modal={"^show.modal.(on|blur)$":function(){n.destroy(),n.init(),l.toggle(a.is(":visible"))}},r.extend(n,{init:function(){return o.on?(l=u.overlay=J.elem,a.attr(K,i).css("z-index",E.modal.zindex+r(Q).length).bind("tooltipshow"+f+" tooltiphide"+f,function(e,t,i){var s=e.originalEvent;if(e.target===a[0])if(s&&e.type==="tooltiphide"&&/mouse(leave|enter)/.test(s.type)&&r(s.relatedTarget).closest(l[0]).length)try{e.preventDefault()}catch(o){}else(!s||s&&!s.solo)&&n.toggle(e,e.type==="tooltipshow",i)}).bind("tooltipfocus"+f,function(e,t){if(e.isDefaultPrevented()||e.target!==a[0])return;var n=r(Q),i=E.modal.zindex+n.length,s=parseInt(a[0].style.zIndex,10);l[0].style.zIndex=i-1,n.each(function(){this.style.zIndex>s&&(this.style.zIndex-=1)}),n.filter("."+A).qtip("blur",e.originalEvent),a.addClass(A)[0].style.zIndex=i,J.update(t);try{e.preventDefault()}catch(o){}}).bind("tooltiphide"+f,function(e){e.target===a[0]&&r(Q).filter(":visible").not(a).last().qtip("focus",e)}),n):n},toggle:function(t,r,i){return t&&t.isDefaultPrevented()?n:(J.toggle(e,!!r,i),n)},destroy:function(){r([t,a]).removeAttr(K).unbind(f),J.toggle(e,s),delete u.overlay}}),n.init()}function et(n){var o=this,u=n.elements,a=n.options,c=u.tooltip,h=".ie6-"+n.id,p=r("select, object").length<1,d=0,v=s,m;n.checks.ie6={"^content|style$":function(e,t,n){redraw()}},r.extend(o,{init:function(){var n=r(e),s;p&&(u.bgiframe=r('<iframe class="qtip-bgiframe" frameborder="0" tabindex="-1" src="javascript:\'\';"  style="display:block; position:absolute; z-index:-1; filter:alpha(opacity=0); -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";"></iframe>'),u.bgiframe.appendTo(c),c.bind("tooltipmove"+h,o.adjustBGIFrame)),m=r("<div/>",{id:"qtip-rcontainer"}).appendTo(t.body),o.redraw(),u.overlay&&!v&&(s=function(){u.overlay[0].style.top=n.scrollTop()+"px"},n.bind("scroll.qtip-ie6, resize.qtip-ie6",s),s(),u.overlay.addClass("qtipmodal-ie6fix"),v=i)},adjustBGIFrame:function(){var e=n.get("dimensions"),t=n.plugins.tip,r=u.tip,i,s;s=parseInt(c.css("border-left-width"),10)||0,s={left:-s,top:-s},t&&r&&(i=t.corner.precedance==="x"?["width","left"]:["height","top"],s[i[1]]-=r[i[0]]()),u.bgiframe.css(s).css(e)},redraw:function(){if(n.rendered<1||d)return o;var e=a.style,t=a.position.container,r,i,s,u;return d=1,e.height&&c.css(l,e.height),e.width?c.css(f,e.width):(c.css(f,"").appendTo(m),i=c.width(),i%2<1&&(i+=1),s=c.css("max-width")||"",u=c.css("min-width")||"",r=(s+u).indexOf("%")>-1?t.width()/100:0,s=(s.indexOf("%")>-1?r:1)*parseInt(s,10)||i,u=(u.indexOf("%")>-1?r:1)*parseInt(u,10)||0,i=s+u?Math.min(Math.max(i,u),s):i,c.css(f,Math.round(i)).appendTo(t)),d=0,o},destroy:function(){p&&u.bgiframe.remove(),c.unbind(h)}}),o.init()}var i=!0,s=!1,o=null,u="x",a="y",f="width",l="height",c="top",h="left",p="bottom",d="right",v="center",m="flip",g="flipinvert",y="shift",b="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==",w,E,S,x="qtip",T="data-hasqtip",N={},C=["ui-widget","ui-tooltip"],k="div.qtip."+x,L=x+"-default",A=x+"-focus",O=x+"-hover",M="_replacedByqTip",_="oldtitle",D;w=r.fn.qtip=function(e,t,u){var a=(""+e).toLowerCase(),f=o,l=r.makeArray(arguments).slice(1),c=l[l.length-1],h=this[0]?r.data(this[0],"qtip"):o;if(!arguments.length&&h||a==="api")return h;if("string"==typeof e)return this.each(function(){var e=r.data(this,"qtip");if(!e)return i;c&&c.timeStamp&&(e.cache.event=c);if(a!=="option"&&a!=="options"||!t)e[a]&&e[a].apply(e[a],l);else{if(!r.isPlainObject(t)&&u===n)return f=e.get(t),s;e.set(t,u)}}),f!==o?f:this;if("object"==typeof e||!arguments.length)return h=H(r.extend(i,{},e)),w.bind.call(this,h,c)},w.bind=function(e,t){return this.each(function(o){function p(e){function t(){c.render(typeof e=="object"||u.show.ready),a.show.add(a.hide).unbind(l)}if(c.cache.disabled)return s;c.cache.event=r.extend({},e),c.cache.target=e?r(e.target):[n],u.show.delay>0?(clearTimeout(c.timers.show),c.timers.show=setTimeout(t,u.show.delay),f.show!==f.hide&&a.hide.bind(f.hide,function(){clearTimeout(c.timers.show)})):t()}var u,a,f,l,c,h;h=r.isArray(e.id)?e.id[o]:e.id,h=!h||h===s||h.length<1||N[h]?w.nextid++:N[h]=h,l=".qtip-"+h+"-create",c=j(r(this),h,e);if(c===s)return i;u=c.options,r.each(E,function(){this.initialize==="initialize"&&this(c)}),a={show:u.show.target,hide:u.hide.target},f={show:r.trim(""+u.show.event).replace(/ /g,l+" ")+l,hide:r.trim(""+u.hide.event).replace(/ /g,l+" ")+l},/mouse(over|enter)/i.test(f.show)&&!/mouse(out|leave)/i.test(f.hide)&&(f.hide+=" mouseleave"+l),a.show.bind("mousemove"+l,function(e){P(e),c.cache.onTarget=i}),a.show.bind(f.show,p),(u.show.ready||u.prerender)&&p(t)})},E=w.plugins={Corner:function(e){e=(""+e).replace(/([A-Z])/," $1").replace(/middle/gi,v).toLowerCase(),this.x=(e.match(/left|right/i)||e.match(/center/)||["inherit"])[0].toLowerCase(),this.y=(e.match(/top|bottom|center/i)||["inherit"])[0].toLowerCase();var t=e.charAt(0);this.precedance=t==="t"||t==="b"?a:u,this.string=function(){return this.precedance===a?this.y+this.x:this.x+this.y},this.abbrev=function(){var e=this.x.substr(0,1),t=this.y.substr(0,1);return e===t?e:this.precedance===a?t+e:e+t},this.invertx=function(e){this.x=this.x===h?d:this.x===d?h:e||this.x},this.inverty=function(e){this.y=this.y===c?p:this.y===p?c:e||this.y},this.clone=function(){return{x:this.x,y:this.y,precedance:this.precedance,string:this.string,abbrev:this.abbrev,clone:this.clone,invertx:this.invertx,inverty:this.inverty}}},offset:function(e,n){function c(e,t){i.left+=t*e.scrollLeft(),i.top+=t*e.scrollTop()}var i=e.offset(),s=e.closest("body"),o=E.ie&&t.compatMode!=="CSS1Compat",u=n,a,f,l;if(u){do u.css("position")!=="static"&&(f=u.position(),i.left-=f.left+(parseInt(u.css("borderLeftWidth"),10)||0)+(parseInt(u.css("marginLeft"),10)||0),i.top-=f.top+(parseInt(u.css("borderTopWidth"),10)||0)+(parseInt(u.css("marginTop"),10)||0),!a&&(l=u.css("overflow"))!=="hidden"&&l!=="visible"&&(a=u));while((u=r(u[0].offsetParent)).length);(a&&a[0]!==s[0]||o)&&c(a||s,1)}return i},ie:function(){var e=3,n=t.createElement("div");while(n.innerHTML="<!--[if gt IE "+ ++e+"]><i></i><![endif]-->")if(!n.getElementsByTagName("i")[0])break;return e>4?e:s}(),iOS:parseFloat((""+(/CPU.*OS ([0-9_]{1,5})|(CPU like).*AppleWebKit.*Mobile/i.exec(navigator.userAgent)||[0,""])[1]).replace("undefined","3_2").replace("_",".").replace("_",""))||s,fn:{attr:function(e,t){if(this.length){var n=this[0],i="title",s=r.data(n,"qtip");if(e===i&&s&&"object"==typeof s&&s.options.suppress)return arguments.length<2?r.attr(n,_):(s&&s.options.content.attr===i&&s.cache.attr&&s.set("content.text",t),this.attr(_,t))}return r.fn["attr"+M].apply(this,arguments)},clone:function(e){var t=r([]),n="title",i=r.fn["clone"+M].apply(this,arguments);return e||i.filter("["+_+"]").attr("title",function(){return r.attr(this,_)}).removeAttr(_),i}}},r.each(E.fn,function(e,t){if(!t||r.fn[e+M])return i;var n=r.fn[e+M]=r.fn[e];r.fn[e]=function(){return t.apply(this,arguments)||n.apply(this,arguments)}}),r.ui||(r["cleanData"+M]=r.cleanData,r.cleanData=function(e){for(var t=0,i;(i=e[t])!==n&&i.getAttribute(T);t++)try{r(i).triggerHandler("removeqtip")}catch(s){}r["cleanData"+M](e)}),w.version="2.0.1-28-",w.nextid=0,w.inactiveEvents="click dblclick mousedown mouseup mousemove mouseleave mouseenter".split(" "),w.zindex=15e3,w.defaults={prerender:s,id:s,overwrite:i,suppress:i,content:{text:i,attr:"title",deferred:s,title:{text:s,button:s}},position:{my:"top left",at:"bottom right",target:s,container:s,viewport:s,adjust:{x:0,y:0,mouse:i,scroll:i,resize:i,method:"flipinvert flipinvert"},effect:function(e,t,n){r(this).animate(t,{duration:200,queue:s})}},show:{target:s,event:"mouseenter",effect:i,delay:90,solo:s,ready:s,autofocus:s},hide:{target:s,event:"mouseleave",effect:i,delay:0,fixed:s,inactive:s,leave:"window",distance:s},style:{classes:"",widget:s,width:s,height:s,def:i},events:{render:o,move:o,show:o,hide:o,toggle:o,visible:o,hidden:o,focus:o,blur:o}},E.svg=function(e,n,i,s){var o=r(t),u=n[0],a={width:0,height:0,position:{top:1e10,left:1e10}},f,l,c,h,p;while(!u.getBBox)u=u.parentNode;if(u.getBBox&&u.parentNode){f=u.getBBox(),l=u.getScreenCTM(),c=u.farthestViewportElement||u;if(!c.createSVGPoint)return a;h=c.createSVGPoint(),h.x=f.x,h.y=f.y,p=h.matrixTransform(l),a.position.left=p.x,a.position.top=p.y,h.x+=f.width,h.y+=f.height,p=h.matrixTransform(l),a.width=p.x-a.position.left,a.height=p.y-a.position.top,a.position.left+=o.scrollLeft(),a.position.top+=o.scrollTop()}return a};var F,I=".qtip-ajax",q=/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi;F=E.ajax=function(e){var t=e.plugins.ajax;return"object"==typeof t?t:e.plugins.ajax=new R(e)},F.initialize="render",F.sanitize=function(e){var t=e.content,n;t&&"ajax"in t&&(n=t.ajax,typeof n!="object"&&(n=e.content.ajax={url:n}),"boolean"!=typeof n.once&&n.once&&(n.once=!!n.once))},r.extend(i,w.defaults,{content:{ajax:{loading:i,once:i}}});var U,z=".qtip-tip",W=!!t.createElement("canvas").getContext;U=E.tip=function(e){var t=e.plugins.tip;return"object"==typeof t?t:e.plugins.tip=new V(e)},U.initialize="render",U.sanitize=function(e){var t=e.style,n;t&&"tip"in t&&(n=e.style.tip,typeof n!="object"&&(e.style.tip={corner:n}),/string|boolean/i.test(typeof n.corner)||(n.corner=i),typeof n.width!="number"&&delete n.width,typeof n.height!="number"&&delete n.height,typeof n.border!="number"&&n.border!==i&&delete n.border,typeof n.offset!="number"&&delete n.offset)},r.extend(i,w.defaults,{style:{tip:{corner:i,mimic:s,width:12,height:6,border:i,offset:0}}});var $,J,K="is-modal-qtip",Q=k+"["+K+"]",G=".qtipmodal";J=function(){function h(e){if(r.expr[":"].focusable)return r.expr[":"].focusable;var t=!isNaN(r.attr(e,"tabindex")),n=e.nodeName.toLowerCase(),i,s,o;return"area"===n?(i=e.parentNode,s=i.name,!e.href||!s||i.nodeName.toLowerCase()!=="map"?!1:(o=r("img[usemap=#"+s+"]")[0],!!o&&o.is(":visible"))):/input|select|textarea|button|object/.test(n)?!e.disabled:"a"===n?e.href||t:t}function p(e){u.length<1&&e.length?e.not("body").blur():u.first().focus()}function d(e){if(!c.is(":visible"))return;var t=r(e.target),n=a.elements.tooltip,i=t.closest(k),o;o=i.length<1?s:parseInt(i[0].style.zIndex,10)>parseInt(n[0].style.zIndex,10),!o&&t.closest(k)[0]!==n[0]&&p(t),f=e.target===u[u.length-1]}var n=this,u={},a,f,l,c;r.extend(n,{init:function(){function i(){var e=r(this);c.css({height:e.height(),width:e.width()})}return c=n.elem=r("<div />",{id:"qtip-overlay",html:"<div></div>",mousedown:function(){return s}}).hide(),r(e).bind("resize"+G,i),i(),r(t.body).bind("focusin"+G,d),r(t).bind("keydown"+G,function(e){a&&a.options.show.modal.escape&&e.keyCode===27&&a.hide(e)}),c.bind("click"+G,function(e){a&&a.options.show.modal.blur&&a.hide(e)}),n},update:function(e){a=e,e.options.show.modal.stealfocus!==s?u=e.elements.tooltip.find("*").filter(function(){return h(this)}):u=[]},toggle:function(e,u,f){var h=r(t.body),d=e.elements.tooltip,v=e.options.show.modal,m=v.effect,g=u?"show":"hide",y=c.is(":visible"),b=r(Q).filter(":visible:not(:animated)").not(d),w;return n.update(e),u&&v.stealfocus!==s&&p(r(":focus")),c.toggleClass("blurs",v.blur),u&&c.css({left:0,top:0}).appendTo(t.body),c.is(":animated")&&y===u&&l!==s||!u&&b.length?n:(c.stop(i,s),r.isFunction(m)?m.call(c,u):m===s?c[g]():c.fadeTo(parseInt(f,10)||90,u?1:0,function(){u||c.hide()}),u||c.queue(function(e){c.css({left:"",top:""}),b.length||c.detach(),e()}),l=u,a.destroyed&&(a=o),n)}}),n.init()},J=new J,$=E.modal=function(e){var t=e.plugins.modal;return"object"==typeof t?t:e.plugins.modal=new Y(e)},$.sanitize=function(e){e.show&&(typeof e.show.modal!="object"?e.show.modal={on:!!e.show.modal}:typeof e.show.modal.on=="undefined"&&(e.show.modal.on=i))},$.zindex=w.zindex-200,$.initialize="render",r.extend(i,w.defaults,{show:{modal:{on:s,effect:i,blur:i,stealfocus:i,escape:i}}}),E.viewport=function(n,r,i,s,o,m,b){function j(e,t,n,i,s,o,u,a,f){var l=r[s],c=S[e],h=T[e],p=n===y,d=-O.offset[s]+A.offset[s]+A["scroll"+s],m=c===s?f:c===o?-f:-f/2,b=h===s?a:h===o?-a:-a/2,w=_&&_.size?_.size[u]||0:0,E=_&&_.corner&&_.corner.precedance===e&&!p?w:0,x=d-l+E,N=l+f-A[u]-d+E,C=m-(S.precedance===e||c===S[t]?b:0)-(h===v?a/2:0);return p?(E=_&&_.corner&&_.corner.precedance===t?w:0,C=(c===s?1:-1)*m-E,r[s]+=x>0?x:N>0?-N:0,r[s]=Math.max(-O.offset[s]+A.offset[s]+(E&&_.corner[e]===v?_.offset:0),l-C,Math.min(Math.max(-O.offset[s]+A.offset[s]+A[u],l+C),r[s]))):(i*=n===g?2:0,x>0&&(c!==s||N>0)?(r[s]-=C+i,H["invert"+e](s)):N>0&&(c!==o||x>0)&&(r[s]-=(c===v?-C:C)+i,H["invert"+e](o)),r[s]<d&&-r[s]>N&&(r[s]=l,H=S.clone())),r[s]-l}var w=i.target,E=n.elements.tooltip,S=i.my,T=i.at,N=i.adjust,C=N.method.split(" "),k=C[0],L=C[1]||C[0],A=i.viewport,O=i.container,M=n.cache,_=n.plugins.tip,D={left:0,top:0},P,H,B;if(!A.jquery||w[0]===e||w[0]===t.body||N.method==="none")return D;P=E.css("position")==="fixed",A={elem:A,height:A[(A[0]===e?"h":"outerH")+"eight"](),width:A[(A[0]===e?"w":"outerW")+"idth"](),scrollleft:P?0:A.scrollLeft(),scrolltop:P?0:A.scrollTop(),offset:A.offset()||{left:0,top:0}},O={elem:O,scrollLeft:O.scrollLeft(),scrollTop:O.scrollTop(),offset:O.offset()||{left:0,top:0}};if(k!=="shift"||L!=="shift")H=S.clone();return D={left:k!=="none"?j(u,a,k,N.x,h,d,f,s,m):0,top:L!=="none"?j(a,u,L,N.y,c,p,l,o,b):0},H&&M.lastClass!==(B=x+"-pos-"+H.abbrev())&&E.removeClass(n.cache.lastClass).addClass(n.cache.lastClass=B),D},E.imagemap=function(e,t,n,i){function E(e,t,n){var r=0,i=1,s=1,o=0,u=0,a=e.width,f=e.height;while(a>0&&f>0&&i>0&&s>0){a=Math.floor(a/2),f=Math.floor(f/2),n.x===h?i=a:n.x===d?i=e.width-a:i+=Math.floor(a/2),n.y===c?s=f:n.y===p?s=e.height-f:s+=Math.floor(f/2),r=t.length;while(r--){if(t.length<2)break;o=t[r][0]-e.position.left,u=t[r][1]-e.position.top,(n.x===h&&o>=i||n.x===d&&o<=i||n.x===v&&(o<i||o>e.width-i)||n.y===c&&u>=s||n.y===p&&u<=s||n.y===v&&(u<s||u>e.height-s))&&t.splice(r,1)}}return{left:t[0][0],top:t[0][1]}}t.jquery||(t=r(t));var s=e.cache.areas={},o=(t[0].shape||t.attr("shape")).toLowerCase(),u=t[0].coords||t.attr("coords"),a=u.split(","),f=[],l=r('img[usemap="#'+t.parent("map").attr("name")+'"]'),m=l.offset(),g={width:0,height:0,position:{top:1e10,right:0,bottom:0,left:1e10}},y=0,b=0,w;m.left+=Math.ceil((l.outerWidth()-l.width())/2),m.top+=Math.ceil((l.outerHeight()-l.height())/2);if(o==="poly"){y=a.length;while(y--)b=[parseInt(a[--y],10),parseInt(a[y+1],10)],b[0]>g.position.right&&(g.position.right=b[0]),b[0]<g.position.left&&(g.position.left=b[0]),b[1]>g.position.bottom&&(g.position.bottom=b[1]),b[1]<g.position.top&&(g.position.top=b[1]),f.push(b)}else{y=-1;while(y++<a.length)f.push(parseInt(a[y],10))}switch(o){case"rect":g={width:Math.abs(f[2]-f[0]),height:Math.abs(f[3]-f[1]),position:{left:Math.min(f[0],f[2]),top:Math.min(f[1],f[3])}};break;case"circle":g={width:f[2]+2,height:f[2]+2,position:{left:f[0],top:f[1]}};break;case"poly":g.width=Math.abs(g.position.right-g.position.left),g.height=Math.abs(g.position.bottom-g.position.top),n.abbrev()==="c"?g.position={left:g.position.left+g.width/2,top:g.position.top+g.height/2}:(s[n+u]||(g.position=E(g,f.slice(),n),i&&(i[0]==="flip"||i[1]==="flip")&&(g.offset=E(g,f.slice(),{x:n.x===h?d:n.x===d?h:v,y:n.y===c?p:n.y===p?c:v}),g.offset.left-=g.position.left,g.offset.top-=g.position.top),s[n+u]=g),g=s[n+u]),g.width=g.height=0}return g.position.left+=m.left,g.position.top+=m.top,g};var Z;Z=E.ie6=function(e){var t=e.plugins.ie6;return E.ie!==6?s:"object"==typeof t?t:e.plugins.ie6=new et(e)},Z.initialize="render"})})(window,document);

})(njQuery);njQuery(document).ready(function($) {
    var firstcol = $(".smartslider-firstcol");
    var firstcolborder = $(".smartslider-firstcol > .smartslider-border");
    var secondcol = $(".smartslider-secondcol");
    var colresize = function(){
        firstcol.height("auto");
        firstcolborder.height("auto");
        var fcolh = firstcol.height();
        var scolh = secondcol.height();
        if(scolh > fcolh){
            firstcol.height(scolh);
            fcolh = firstcol.height();
        }
        firstcolborder.height(fcolh);
    };
    colresize();
    $(window).resize(colresize);
    $(window).load(colresize);
    window.nextendsmartslidercolresize = colresize;
});/*! jQuery UI - v1.10.2 - 2013-03-14
* http://jqueryui.com
* Copyright 2013 jQuery Foundation and other contributors; Licensed MIT */
(function(e,t){function i(t,i){var a,n,r,o=t.nodeName.toLowerCase();return"area"===o?(a=t.parentNode,n=a.name,t.href&&n&&"map"===a.nodeName.toLowerCase()?(r=e("img[usemap=#"+n+"]")[0],!!r&&s(r)):!1):(/input|select|textarea|button|object/.test(o)?!t.disabled:"a"===o?t.href||i:i)&&s(t)}function s(t){return e.expr.filters.visible(t)&&!e(t).parents().addBack().filter(function(){return"hidden"===e.css(this,"visibility")}).length}var a=0,n=/^ui-id-\d+$/;e.ui=e.ui||{},e.extend(e.ui,{version:"1.10.2",keyCode:{BACKSPACE:8,COMMA:188,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,LEFT:37,NUMPAD_ADD:107,NUMPAD_DECIMAL:110,NUMPAD_DIVIDE:111,NUMPAD_ENTER:108,NUMPAD_MULTIPLY:106,NUMPAD_SUBTRACT:109,PAGE_DOWN:34,PAGE_UP:33,PERIOD:190,RIGHT:39,SPACE:32,TAB:9,UP:38}}),e.fn.extend({focus:function(t){return function(i,s){return"number"==typeof i?this.each(function(){var t=this;setTimeout(function(){e(t).focus(),s&&s.call(t)},i)}):t.apply(this,arguments)}}(e.fn.focus),scrollParent:function(){var t;return t=e.ui.ie&&/(static|relative)/.test(this.css("position"))||/absolute/.test(this.css("position"))?this.parents().filter(function(){return/(relative|absolute|fixed)/.test(e.css(this,"position"))&&/(auto|scroll)/.test(e.css(this,"overflow")+e.css(this,"overflow-y")+e.css(this,"overflow-x"))}).eq(0):this.parents().filter(function(){return/(auto|scroll)/.test(e.css(this,"overflow")+e.css(this,"overflow-y")+e.css(this,"overflow-x"))}).eq(0),/fixed/.test(this.css("position"))||!t.length?e(document):t},zIndex:function(i){if(i!==t)return this.css("zIndex",i);if(this.length)for(var s,a,n=e(this[0]);n.length&&n[0]!==document;){if(s=n.css("position"),("absolute"===s||"relative"===s||"fixed"===s)&&(a=parseInt(n.css("zIndex"),10),!isNaN(a)&&0!==a))return a;n=n.parent()}return 0},uniqueId:function(){return this.each(function(){this.id||(this.id="ui-id-"+ ++a)})},removeUniqueId:function(){return this.each(function(){n.test(this.id)&&e(this).removeAttr("id")})}}),e.extend(e.expr[":"],{data:e.expr.createPseudo?e.expr.createPseudo(function(t){return function(i){return!!e.data(i,t)}}):function(t,i,s){return!!e.data(t,s[3])},focusable:function(t){return i(t,!isNaN(e.attr(t,"tabindex")))},tabbable:function(t){var s=e.attr(t,"tabindex"),a=isNaN(s);return(a||s>=0)&&i(t,!a)}}),e("<a>").outerWidth(1).jquery||e.each(["Width","Height"],function(i,s){function a(t,i,s,a){return e.each(n,function(){i-=parseFloat(e.css(t,"padding"+this))||0,s&&(i-=parseFloat(e.css(t,"border"+this+"Width"))||0),a&&(i-=parseFloat(e.css(t,"margin"+this))||0)}),i}var n="Width"===s?["Left","Right"]:["Top","Bottom"],r=s.toLowerCase(),o={innerWidth:e.fn.innerWidth,innerHeight:e.fn.innerHeight,outerWidth:e.fn.outerWidth,outerHeight:e.fn.outerHeight};e.fn["inner"+s]=function(i){return i===t?o["inner"+s].call(this):this.each(function(){e(this).css(r,a(this,i)+"px")})},e.fn["outer"+s]=function(t,i){return"number"!=typeof t?o["outer"+s].call(this,t):this.each(function(){e(this).css(r,a(this,t,!0,i)+"px")})}}),e.fn.addBack||(e.fn.addBack=function(e){return this.add(null==e?this.prevObject:this.prevObject.filter(e))}),e("<a>").data("a-b","a").removeData("a-b").data("a-b")&&(e.fn.removeData=function(t){return function(i){return arguments.length?t.call(this,e.camelCase(i)):t.call(this)}}(e.fn.removeData)),e.ui.ie=!!/msie [\w.]+/.exec(navigator.userAgent.toLowerCase()),e.support.selectstart="onselectstart"in document.createElement("div"),e.fn.extend({disableSelection:function(){return this.bind((e.support.selectstart?"selectstart":"mousedown")+".ui-disableSelection",function(e){e.preventDefault()})},enableSelection:function(){return this.unbind(".ui-disableSelection")}}),e.extend(e.ui,{plugin:{add:function(t,i,s){var a,n=e.ui[t].prototype;for(a in s)n.plugins[a]=n.plugins[a]||[],n.plugins[a].push([i,s[a]])},call:function(e,t,i){var s,a=e.plugins[t];if(a&&e.element[0].parentNode&&11!==e.element[0].parentNode.nodeType)for(s=0;a.length>s;s++)e.options[a[s][0]]&&a[s][1].apply(e.element,i)}},hasScroll:function(t,i){if("hidden"===e(t).css("overflow"))return!1;var s=i&&"left"===i?"scrollLeft":"scrollTop",a=!1;return t[s]>0?!0:(t[s]=1,a=t[s]>0,t[s]=0,a)}})})(njQuery);/*! jQuery UI - v1.10.2 - 2013-03-14
* http://jqueryui.com
* Copyright 2013 jQuery Foundation and other contributors; Licensed MIT */
(function(e,t){var i=0,s=Array.prototype.slice,n=e.cleanData;e.cleanData=function(t){for(var i,s=0;null!=(i=t[s]);s++)try{e(i).triggerHandler("remove")}catch(a){}n(t)},e.widget=function(i,s,n){var a,r,o,h,l={},u=i.split(".")[0];i=i.split(".")[1],a=u+"-"+i,n||(n=s,s=e.Widget),e.expr[":"][a.toLowerCase()]=function(t){return!!e.data(t,a)},e[u]=e[u]||{},r=e[u][i],o=e[u][i]=function(e,i){return this._createWidget?(arguments.length&&this._createWidget(e,i),t):new o(e,i)},e.extend(o,r,{version:n.version,_proto:e.extend({},n),_childConstructors:[]}),h=new s,h.options=e.widget.extend({},h.options),e.each(n,function(i,n){return e.isFunction(n)?(l[i]=function(){var e=function(){return s.prototype[i].apply(this,arguments)},t=function(e){return s.prototype[i].apply(this,e)};return function(){var i,s=this._super,a=this._superApply;return this._super=e,this._superApply=t,i=n.apply(this,arguments),this._super=s,this._superApply=a,i}}(),t):(l[i]=n,t)}),o.prototype=e.widget.extend(h,{widgetEventPrefix:r?h.widgetEventPrefix:i},l,{constructor:o,namespace:u,widgetName:i,widgetFullName:a}),r?(e.each(r._childConstructors,function(t,i){var s=i.prototype;e.widget(s.namespace+"."+s.widgetName,o,i._proto)}),delete r._childConstructors):s._childConstructors.push(o),e.widget.bridge(i,o)},e.widget.extend=function(i){for(var n,a,r=s.call(arguments,1),o=0,h=r.length;h>o;o++)for(n in r[o])a=r[o][n],r[o].hasOwnProperty(n)&&a!==t&&(i[n]=e.isPlainObject(a)?e.isPlainObject(i[n])?e.widget.extend({},i[n],a):e.widget.extend({},a):a);return i},e.widget.bridge=function(i,n){var a=n.prototype.widgetFullName||i;e.fn[i]=function(r){var o="string"==typeof r,h=s.call(arguments,1),l=this;return r=!o&&h.length?e.widget.extend.apply(null,[r].concat(h)):r,o?this.each(function(){var s,n=e.data(this,a);return n?e.isFunction(n[r])&&"_"!==r.charAt(0)?(s=n[r].apply(n,h),s!==n&&s!==t?(l=s&&s.jquery?l.pushStack(s.get()):s,!1):t):e.error("no such method '"+r+"' for "+i+" widget instance"):e.error("cannot call methods on "+i+" prior to initialization; "+"attempted to call method '"+r+"'")}):this.each(function(){var t=e.data(this,a);t?t.option(r||{})._init():e.data(this,a,new n(r,this))}),l}},e.Widget=function(){},e.Widget._childConstructors=[],e.Widget.prototype={widgetName:"widget",widgetEventPrefix:"",defaultElement:"<div>",options:{disabled:!1,create:null},_createWidget:function(t,s){s=e(s||this.defaultElement||this)[0],this.element=e(s),this.uuid=i++,this.eventNamespace="."+this.widgetName+this.uuid,this.options=e.widget.extend({},this.options,this._getCreateOptions(),t),this.bindings=e(),this.hoverable=e(),this.focusable=e(),s!==this&&(e.data(s,this.widgetFullName,this),this._on(!0,this.element,{remove:function(e){e.target===s&&this.destroy()}}),this.document=e(s.style?s.ownerDocument:s.document||s),this.window=e(this.document[0].defaultView||this.document[0].parentWindow)),this._create(),this._trigger("create",null,this._getCreateEventData()),this._init()},_getCreateOptions:e.noop,_getCreateEventData:e.noop,_create:e.noop,_init:e.noop,destroy:function(){this._destroy(),this.element.unbind(this.eventNamespace).removeData(this.widgetName).removeData(this.widgetFullName).removeData(e.camelCase(this.widgetFullName)),this.widget().unbind(this.eventNamespace).removeAttr("aria-disabled").removeClass(this.widgetFullName+"-disabled "+"ui-state-disabled"),this.bindings.unbind(this.eventNamespace),this.hoverable.removeClass("ui-state-hover"),this.focusable.removeClass("ui-state-focus")},_destroy:e.noop,widget:function(){return this.element},option:function(i,s){var n,a,r,o=i;if(0===arguments.length)return e.widget.extend({},this.options);if("string"==typeof i)if(o={},n=i.split("."),i=n.shift(),n.length){for(a=o[i]=e.widget.extend({},this.options[i]),r=0;n.length-1>r;r++)a[n[r]]=a[n[r]]||{},a=a[n[r]];if(i=n.pop(),s===t)return a[i]===t?null:a[i];a[i]=s}else{if(s===t)return this.options[i]===t?null:this.options[i];o[i]=s}return this._setOptions(o),this},_setOptions:function(e){var t;for(t in e)this._setOption(t,e[t]);return this},_setOption:function(e,t){return this.options[e]=t,"disabled"===e&&(this.widget().toggleClass(this.widgetFullName+"-disabled ui-state-disabled",!!t).attr("aria-disabled",t),this.hoverable.removeClass("ui-state-hover"),this.focusable.removeClass("ui-state-focus")),this},enable:function(){return this._setOption("disabled",!1)},disable:function(){return this._setOption("disabled",!0)},_on:function(i,s,n){var a,r=this;"boolean"!=typeof i&&(n=s,s=i,i=!1),n?(s=a=e(s),this.bindings=this.bindings.add(s)):(n=s,s=this.element,a=this.widget()),e.each(n,function(n,o){function h(){return i||r.options.disabled!==!0&&!e(this).hasClass("ui-state-disabled")?("string"==typeof o?r[o]:o).apply(r,arguments):t}"string"!=typeof o&&(h.guid=o.guid=o.guid||h.guid||e.guid++);var l=n.match(/^(\w+)\s*(.*)$/),u=l[1]+r.eventNamespace,c=l[2];c?a.delegate(c,u,h):s.bind(u,h)})},_off:function(e,t){t=(t||"").split(" ").join(this.eventNamespace+" ")+this.eventNamespace,e.unbind(t).undelegate(t)},_delay:function(e,t){function i(){return("string"==typeof e?s[e]:e).apply(s,arguments)}var s=this;return setTimeout(i,t||0)},_hoverable:function(t){this.hoverable=this.hoverable.add(t),this._on(t,{mouseenter:function(t){e(t.currentTarget).addClass("ui-state-hover")},mouseleave:function(t){e(t.currentTarget).removeClass("ui-state-hover")}})},_focusable:function(t){this.focusable=this.focusable.add(t),this._on(t,{focusin:function(t){e(t.currentTarget).addClass("ui-state-focus")},focusout:function(t){e(t.currentTarget).removeClass("ui-state-focus")}})},_trigger:function(t,i,s){var n,a,r=this.options[t];if(s=s||{},i=e.Event(i),i.type=(t===this.widgetEventPrefix?t:this.widgetEventPrefix+t).toLowerCase(),i.target=this.element[0],a=i.originalEvent)for(n in a)n in i||(i[n]=a[n]);return this.element.trigger(i,s),!(e.isFunction(r)&&r.apply(this.element[0],[i].concat(s))===!1||i.isDefaultPrevented())}},e.each({show:"fadeIn",hide:"fadeOut"},function(t,i){e.Widget.prototype["_"+t]=function(s,n,a){"string"==typeof n&&(n={effect:n});var r,o=n?n===!0||"number"==typeof n?i:n.effect||i:t;n=n||{},"number"==typeof n&&(n={duration:n}),r=!e.isEmptyObject(n),n.complete=a,n.delay&&s.delay(n.delay),r&&e.effects&&e.effects.effect[o]?s[t](n):o!==t&&s[o]?s[o](n.duration,n.easing,a):s.queue(function(i){e(this)[t](),a&&a.call(s[0]),i()})}})})(njQuery);/*! jQuery UI - v1.10.2 - 2013-03-14
* http://jqueryui.com
* Copyright 2013 jQuery Foundation and other contributors; Licensed MIT */
(function(e){var t=!1;e(document).mouseup(function(){t=!1}),e.widget("ui.mouse",{version:"1.10.2",options:{cancel:"input,textarea,button,select,option",distance:1,delay:0},_mouseInit:function(){var t=this;this.element.bind("mousedown."+this.widgetName,function(e){return t._mouseDown(e)}).bind("click."+this.widgetName,function(i){return!0===e.data(i.target,t.widgetName+".preventClickEvent")?(e.removeData(i.target,t.widgetName+".preventClickEvent"),i.stopImmediatePropagation(),!1):undefined}),this.started=!1},_mouseDestroy:function(){this.element.unbind("."+this.widgetName),this._mouseMoveDelegate&&e(document).unbind("mousemove."+this.widgetName,this._mouseMoveDelegate).unbind("mouseup."+this.widgetName,this._mouseUpDelegate)},_mouseDown:function(i){if(!t){this._mouseStarted&&this._mouseUp(i),this._mouseDownEvent=i;var s=this,n=1===i.which,a="string"==typeof this.options.cancel&&i.target.nodeName?e(i.target).closest(this.options.cancel).length:!1;return n&&!a&&this._mouseCapture(i)?(this.mouseDelayMet=!this.options.delay,this.mouseDelayMet||(this._mouseDelayTimer=setTimeout(function(){s.mouseDelayMet=!0},this.options.delay)),this._mouseDistanceMet(i)&&this._mouseDelayMet(i)&&(this._mouseStarted=this._mouseStart(i)!==!1,!this._mouseStarted)?(i.preventDefault(),!0):(!0===e.data(i.target,this.widgetName+".preventClickEvent")&&e.removeData(i.target,this.widgetName+".preventClickEvent"),this._mouseMoveDelegate=function(e){return s._mouseMove(e)},this._mouseUpDelegate=function(e){return s._mouseUp(e)},e(document).bind("mousemove."+this.widgetName,this._mouseMoveDelegate).bind("mouseup."+this.widgetName,this._mouseUpDelegate),i.preventDefault(),t=!0,!0)):!0}},_mouseMove:function(t){return e.ui.ie&&(!document.documentMode||9>document.documentMode)&&!t.button?this._mouseUp(t):this._mouseStarted?(this._mouseDrag(t),t.preventDefault()):(this._mouseDistanceMet(t)&&this._mouseDelayMet(t)&&(this._mouseStarted=this._mouseStart(this._mouseDownEvent,t)!==!1,this._mouseStarted?this._mouseDrag(t):this._mouseUp(t)),!this._mouseStarted)},_mouseUp:function(t){return e(document).unbind("mousemove."+this.widgetName,this._mouseMoveDelegate).unbind("mouseup."+this.widgetName,this._mouseUpDelegate),this._mouseStarted&&(this._mouseStarted=!1,t.target===this._mouseDownEvent.target&&e.data(t.target,this.widgetName+".preventClickEvent",!0),this._mouseStop(t)),!1},_mouseDistanceMet:function(e){return Math.max(Math.abs(this._mouseDownEvent.pageX-e.pageX),Math.abs(this._mouseDownEvent.pageY-e.pageY))>=this.options.distance},_mouseDelayMet:function(){return this.mouseDelayMet},_mouseStart:function(){},_mouseDrag:function(){},_mouseStop:function(){},_mouseCapture:function(){return!0}})})(njQuery);/*!
 * jQuery UI Sortable 1.10.2
 * http://jqueryui.com
 *
 * Copyright 2013 jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 *
 * http://api.jqueryui.com/sortable/
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.mouse.js
 *	jquery.ui.widget.js
 */
(function($, undefined) {

    /*jshint loopfunc: true */

    function isOverAxis(x, reference, size) {
        return (x > reference) && (x < (reference + size));
    }

    function isFloating(item) {
        return (/left|right/).test(item.css("float")) || (/inline|table-cell/).test(item.css("display"));
    }

    $.widget("ui.sortable", $.ui.mouse, {
        version: "1.10.2",
        widgetEventPrefix: "sort",
        ready: false,
        options: {
            appendTo: "parent",
            axis: false,
            connectWith: false,
            containment: false,
            cursor: "auto",
            cursorAt: false,
            dropOnEmpty: true,
            forcePlaceholderSize: false,
            forceHelperSize: false,
            grid: false,
            handle: false,
            helper: "original",
            items: "> *",
            opacity: false,
            placeholder: false,
            revert: false,
            scroll: true,
            scrollSensitivity: 20,
            scrollSpeed: 20,
            scope: "default",
            tolerance: "intersect",
            zIndex: 1000,
            // callbacks
            activate: null,
            beforeStop: null,
            change: null,
            deactivate: null,
            out: null,
            over: null,
            receive: null,
            remove: null,
            sort: null,
            start: null,
            stop: null,
            update: null
        },
        _create: function() {
            var o = this.options;
            this.containerCache = {};
            this.element.addClass("ui-sortable");

            //Get the items
            this.refresh();

            //Let's determine if the items are being displayed horizontally
            this.floating = this.items.length ? o.axis === "x" || isFloating(this.items[0].item) : false;

            //Let's determine the parent's offset
            this.offset = this.element.offset();

            //Initialize mouse events for interaction
            this._mouseInit();

            //We're ready to go
            this.ready = true;

        },
        _destroy: function() {
            this.element
                    .removeClass("ui-sortable ui-sortable-disabled");
            this._mouseDestroy();

            for (var i = this.items.length - 1; i >= 0; i--) {
                this.items[i].item.removeData(this.widgetName + "-item");
            }

            return this;
        },
        _setOption: function(key, value) {
            if (key === "disabled") {
                this.options[ key ] = value;

                this.widget().toggleClass("ui-sortable-disabled", !!value);
            } else {
                // Don't call widget base _setOption for disable as it adds ui-state-disabled class
                $.Widget.prototype._setOption.apply(this, arguments);
            }
        },
        _mouseCapture: function(event, overrideHandle) {
            var currentItem = null,
                    validHandle = false,
                    that = this;

            if (this.reverting) {
                return false;
            }

            if (this.options.disabled || this.options.type === "static") {
                return false;
            }

            //We have to refresh the items data once first
            this._refreshItems(event);

            //Find out if the clicked node (or one of its parents) is a actual item in this.items
            $(event.target).parents().each(function() {
                if ($.data(this, that.widgetName + "-item") === that) {
                    currentItem = $(this);
                    return false;
                }
            });
            if ($.data(event.target, that.widgetName + "-item") === that) {
                currentItem = $(event.target);
            }

            if (!currentItem) {
                return false;
            }
            if (this.options.handle && !overrideHandle) {
                $(this.options.handle, currentItem).find("*").addBack().each(function() {
                    if (this === event.target) {
                        validHandle = true;
                    }
                });
                if (!validHandle) {
                    return false;
                }
            }

            this.currentItem = currentItem;
            this._removeCurrentsFromItems();
            return true;

        },
        _mouseStart: function(event, overrideHandle, noActivation) {

            var i, body,
                    o = this.options;

            this.currentContainer = this;

            //We only need to call refreshPositions, because the refreshItems call has been moved to mouseCapture
            this.refreshPositions();

            //Create and append the visible helper
            this.helper = this._createHelper(event);

            //Cache the helper size
            this._cacheHelperProportions();

            /*
             * - Position generation -
             * This block generates everything position related - it's the core of draggables.
             */

            //Cache the margins of the original element
            this._cacheMargins();

            //Get the next scrolling parent
            this.scrollParent = this.helper.scrollParent();

            //The element's absolute position on the page minus margins
            this.offset = this.currentItem.offset();
            this.offset = {
                top: this.offset.top - this.margins.top,
                left: this.offset.left - this.margins.left
            };

            $.extend(this.offset, {
                click: {//Where the click happened, relative to the element
                    left: event.pageX - this.offset.left,
                    top: event.pageY - this.offset.top
                },
                parent: this._getParentOffset(),
                relative: this._getRelativeOffset() //This is a relative to absolute position minus the actual position calculation - only used for relative positioned helper
            });

            // Only after we got the offset, we can change the helper's position to absolute
            // TODO: Still need to figure out a way to make relative sorting possible
            this.helper.css("position", "absolute");
            this.cssPosition = this.helper.css("position");

            //Generate the original position
            this.originalPosition = this._generatePosition(event);
            this.originalPageX = event.pageX;
            this.originalPageY = event.pageY;

            //Adjust the mouse offset relative to the helper if "cursorAt" is supplied
            (o.cursorAt && this._adjustOffsetFromHelper(o.cursorAt));

            //Cache the former DOM position
            this.domPosition = {prev: this.currentItem.prev()[0], parent: this.currentItem.parent()[0]};

            //If the helper is not the original, hide the original so it's not playing any role during the drag, won't cause anything bad this way
            if (this.helper[0] !== this.currentItem[0]) {
                this.currentItem.hide();
            }

            //Create the placeholder
            this._createPlaceholder();

            //Set a containment if given in the options
            if (o.containment) {
                this._setContainment();
            }

            if (o.cursor && o.cursor !== "auto") { // cursor option
                body = this.document.find("body");

                // support: IE
                this.storedCursor = body.css("cursor");
                body.css("cursor", o.cursor);

                this.storedStylesheet = $("<style>*{ cursor: " + o.cursor + " !important; }</style>").appendTo(body);
            }

            if (o.opacity) { // opacity option
                if (this.helper.css("opacity")) {
                    this._storedOpacity = this.helper.css("opacity");
                }
                this.helper.css("opacity", o.opacity);
            }

            if (o.zIndex) { // zIndex option
                if (this.helper.css("zIndex")) {
                    this._storedZIndex = this.helper.css("zIndex");
                }
                this.helper.css("zIndex", o.zIndex);
            }

            //Prepare scrolling
            if (this.scrollParent[0] !== document && this.scrollParent[0].tagName !== "HTML") {
                this.overflowOffset = this.scrollParent.offset();
            }

            //Call callbacks
            this._trigger("start", event, this._uiHash());

            //Recache the helper size
            if (!this._preserveHelperProportions) {
                this._cacheHelperProportions();
            }


            //Post "activate" events to possible containers
            if (!noActivation) {
                for (i = this.containers.length - 1; i >= 0; i--) {
                    this.containers[ i ]._trigger("activate", event, this._uiHash(this));
                }
            }

            //Prepare possible droppables
            if ($.ui.ddmanager) {
                $.ui.ddmanager.current = this;
            }

            if ($.ui.ddmanager && !o.dropBehaviour) {
                $.ui.ddmanager.prepareOffsets(this, event);
            }

            this.dragging = true;

            this.helper.addClass("ui-sortable-helper");
            this._mouseDrag(event); //Execute the drag once - this causes the helper not to be visible before getting its correct position
            return true;

        },
        _mouseDrag: function(event) {
            var i, item, itemElement, intersection,
                    o = this.options,
                    scrolled = false;

            //Compute the helpers position
            this.position = this._generatePosition(event);
            this.positionAbs = this._convertPositionTo("absolute");

            if (!this.lastPositionAbs) {
                this.lastPositionAbs = this.positionAbs;
            }

            //Do scrolling
            if (this.options.scroll) {
                if (this.scrollParent[0] !== document && this.scrollParent[0].tagName !== "HTML") {

                    if ((this.overflowOffset.top + this.scrollParent[0].offsetHeight) - event.pageY < o.scrollSensitivity) {
                        this.scrollParent[0].scrollTop = scrolled = this.scrollParent[0].scrollTop + o.scrollSpeed;
                    } else if (event.pageY - this.overflowOffset.top < o.scrollSensitivity) {
                        this.scrollParent[0].scrollTop = scrolled = this.scrollParent[0].scrollTop - o.scrollSpeed;
                    }

                    if ((this.overflowOffset.left + this.scrollParent[0].offsetWidth) - event.pageX < o.scrollSensitivity) {
                        this.scrollParent[0].scrollLeft = scrolled = this.scrollParent[0].scrollLeft + o.scrollSpeed;
                    } else if (event.pageX - this.overflowOffset.left < o.scrollSensitivity) {
                        this.scrollParent[0].scrollLeft = scrolled = this.scrollParent[0].scrollLeft - o.scrollSpeed;
                    }

                } else {

                    if (event.pageY - $(document).scrollTop() < o.scrollSensitivity) {
                        scrolled = $(document).scrollTop($(document).scrollTop() - o.scrollSpeed);
                    } else if ($(window).height() - (event.pageY - $(document).scrollTop()) < o.scrollSensitivity) {
                        scrolled = $(document).scrollTop($(document).scrollTop() + o.scrollSpeed);
                    }

                    if (event.pageX - $(document).scrollLeft() < o.scrollSensitivity) {
                        scrolled = $(document).scrollLeft($(document).scrollLeft() - o.scrollSpeed);
                    } else if ($(window).width() - (event.pageX - $(document).scrollLeft()) < o.scrollSensitivity) {
                        scrolled = $(document).scrollLeft($(document).scrollLeft() + o.scrollSpeed);
                    }

                }

                if (scrolled !== false && $.ui.ddmanager && !o.dropBehaviour) {
                    $.ui.ddmanager.prepareOffsets(this, event);
                }
            }

            //Regenerate the absolute position used for position checks
            this.positionAbs = this._convertPositionTo("absolute");

            //Set the helper position
            if (!this.options.axis || this.options.axis !== "y") {
                this.helper[0].style.left = this.position.left + "px";
            }
            if (!this.options.axis || this.options.axis !== "x") {
                this.helper[0].style.top = this.position.top + "px";
            }

            //Rearrange
            for (i = this.items.length - 1; i >= 0; i--) {

                //Cache variables and intersection, continue if no intersection
                item = this.items[i];
                itemElement = item.item[0];
                intersection = this._intersectsWithPointer(item);
                if (!intersection) {
                    continue;
                }

                // Only put the placeholder inside the current Container, skip all
                // items form other containers. This works because when moving
                // an item from one container to another the
                // currentContainer is switched before the placeholder is moved.
                //
                // Without this moving items in "sub-sortables" can cause the placeholder to jitter
                // beetween the outer and inner container.
                if (item.instance !== this.currentContainer) {
                    continue;
                }

                // cannot intersect with itself
                // no useless actions that have been done before
                // no action if the item moved is the parent of the item checked
                if (itemElement !== this.currentItem[0] &&
                        this.placeholder[intersection === 1 ? "next" : "prev"]()[0] !== itemElement &&
                        !$.contains(this.placeholder[0], itemElement) &&
                        (this.options.type === "semi-dynamic" ? !$.contains(this.element[0], itemElement) : true)
                        ) {

                    this.direction = intersection === 1 ? "down" : "up";

                    if (this.options.tolerance === "pointer" || this._intersectsWithSides(item)) {
                        this._rearrange(event, item);
                    } else {
                        break;
                    }

                    this._trigger("change", event, this._uiHash());
                    break;
                }
            }

            //Post events to containers
            this._contactContainers(event);

            //Interconnect with droppables
            if ($.ui.ddmanager) {
                $.ui.ddmanager.drag(this, event);
            }

            //Call callbacks
            this._trigger("sort", event, this._uiHash());

            this.lastPositionAbs = this.positionAbs;
            return false;

        },
        _mouseStop: function(event, noPropagation) {

            if (!event) {
                return;
            }

            //If we are using droppables, inform the manager about the drop
            if ($.ui.ddmanager && !this.options.dropBehaviour) {
                $.ui.ddmanager.drop(this, event);
            }

            if (this.options.revert) {
                var that = this,
                        cur = this.placeholder.offset(),
                        axis = this.options.axis,
                        animation = {};

                if (!axis || axis === "x") {
                    animation.left = cur.left - this.offset.parent.left - this.margins.left + (this.offsetParent[0] === document.body ? 0 : this.offsetParent[0].scrollLeft);
                }
                if (!axis || axis === "y") {
                    animation.top = cur.top - this.offset.parent.top - this.margins.top + (this.offsetParent[0] === document.body ? 0 : this.offsetParent[0].scrollTop);
                }
                this.reverting = true;
                $(this.helper).animate(animation, parseInt(this.options.revert, 10) || 500, function() {
                    that._clear(event);
                });
            } else {
                this._clear(event, noPropagation);
            }

            return false;

        },
        cancel: function() {

            if (this.dragging) {

                this._mouseUp({target: null});

                if (this.options.helper === "original") {
                    this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper");
                } else {
                    this.currentItem.show();
                }

                //Post deactivating events to containers
                for (var i = this.containers.length - 1; i >= 0; i--) {
                    this.containers[i]._trigger("deactivate", null, this._uiHash(this));
                    if (this.containers[i].containerCache.over) {
                        this.containers[i]._trigger("out", null, this._uiHash(this));
                        this.containers[i].containerCache.over = 0;
                    }
                }

            }

            if (this.placeholder) {
                //$(this.placeholder[0]).remove(); would have been the jQuery way - unfortunately, it unbinds ALL events from the original node!
                if (this.placeholder[0].parentNode) {
                    this.placeholder[0].parentNode.removeChild(this.placeholder[0]);
                }
                if (this.options.helper !== "original" && this.helper && this.helper[0].parentNode) {
                    this.helper.remove();
                }

                $.extend(this, {
                    helper: null,
                    dragging: false,
                    reverting: false,
                    _noFinalSort: null
                });

                if (this.domPosition.prev) {
                    $(this.domPosition.prev).after(this.currentItem);
                } else {
                    $(this.domPosition.parent).prepend(this.currentItem);
                }
            }

            return this;

        },
        serialize: function(o) {

            var items = this._getItemsAsjQuery(o && o.connected),
                    str = [];
            o = o || {};

            $(items).each(function() {
                var res = ($(o.item || this).attr(o.attribute || "id") || "").match(o.expression || (/(.+)[\-=_](.+)/));
                if (res) {
                    str.push((o.key || res[1] + "[]") + "=" + (o.key && o.expression ? res[1] : res[2]));
                }
            });

            if (!str.length && o.key) {
                str.push(o.key + "=");
            }

            return str.join("&");

        },
        toArray: function(o) {

            var items = this._getItemsAsjQuery(o && o.connected),
                    ret = [];

            o = o || {};

            items.each(function() {
                ret.push($(o.item || this).attr(o.attribute || "id") || "");
            });
            return ret;

        },
        /* Be careful with the following core functions */
        _intersectsWith: function(item) {

            var x1 = this.positionAbs.left,
                    x2 = x1 + this.helperProportions.width,
                    y1 = this.positionAbs.top,
                    y2 = y1 + this.helperProportions.height,
                    l = item.left,
                    r = l + item.width,
                    t = item.top,
                    b = t + item.height,
                    dyClick = this.offset.click.top,
                    dxClick = this.offset.click.left,
                    isOverElement = (y1 + dyClick) > t && (y1 + dyClick) < b && (x1 + dxClick) > l && (x1 + dxClick) < r;

            if (this.options.tolerance === "pointer" ||
                    this.options.forcePointerForContainers ||
                    (this.options.tolerance !== "pointer" && this.helperProportions[this.floating ? "width" : "height"] > item[this.floating ? "width" : "height"])
                    ) {
                return isOverElement;
            } else {

                return (l < x1 + (this.helperProportions.width / 2) && // Right Half
                        x2 - (this.helperProportions.width / 2) < r && // Left Half
                        t < y1 + (this.helperProportions.height / 2) && // Bottom Half
                        y2 - (this.helperProportions.height / 2) < b); // Top Half

            }
        },
        _intersectsWithPointer: function(item) {

            var isOverElementHeight = (this.options.axis === "x") || isOverAxis(this.positionAbs.top + this.offset.click.top, item.top, item.height),
                    isOverElementWidth = (this.options.axis === "y") || isOverAxis(this.positionAbs.left + this.offset.click.left, item.left, item.width),
                    isOverElement = isOverElementHeight && isOverElementWidth,
                    verticalDirection = this._getDragVerticalDirection(),
                    horizontalDirection = this._getDragHorizontalDirection();

            if (!isOverElement) {
                return false;
            }

            return this.floating ?
                    (((horizontalDirection && horizontalDirection === "right") || verticalDirection === "down") ? 2 : 1)
                    : (verticalDirection && (verticalDirection === "down" ? 2 : 1));

        },
        _intersectsWithSides: function(item) {

            var isOverBottomHalf = isOverAxis(this.positionAbs.top + this.offset.click.top, item.top + (item.height / 2), item.height),
                    isOverRightHalf = isOverAxis(this.positionAbs.left + this.offset.click.left, item.left + (item.width / 2), item.width),
                    verticalDirection = this._getDragVerticalDirection(),
                    horizontalDirection = this._getDragHorizontalDirection();

            if (this.floating && horizontalDirection) {
                return ((horizontalDirection === "right" && isOverRightHalf) || (horizontalDirection === "left" && !isOverRightHalf));
            } else {
                return verticalDirection && ((verticalDirection === "down" && isOverBottomHalf) || (verticalDirection === "up" && !isOverBottomHalf));
            }

        },
        _getDragVerticalDirection: function() {
            var delta = this.positionAbs.top - this.lastPositionAbs.top;
            return delta !== 0 && (delta > 0 ? "down" : "up");
        },
        _getDragHorizontalDirection: function() {
            var delta = this.positionAbs.left - this.lastPositionAbs.left;
            return delta !== 0 && (delta > 0 ? "right" : "left");
        },
        refresh: function(event) {
            this._refreshItems(event);
            this.refreshPositions();
            return this;
        },
        _connectWith: function() {
            var options = this.options;
            return options.connectWith.constructor === String ? [options.connectWith] : options.connectWith;
        },
        _getItemsAsjQuery: function(connected) {

            var i, j, cur, inst,
                    items = [],
                    queries = [],
                    connectWith = this._connectWith();

            if (connectWith && connected) {
                for (i = connectWith.length - 1; i >= 0; i--) {
                    cur = $(connectWith[i]);
                    for (j = cur.length - 1; j >= 0; j--) {
                        inst = $.data(cur[j], this.widgetFullName);
                        if (inst && inst !== this && !inst.options.disabled) {
                            queries.push([$.isFunction(inst.options.items) ? inst.options.items.call(inst.element) : $(inst.options.items, inst.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), inst]);
                        }
                    }
                }
            }

            queries.push([$.isFunction(this.options.items) ? this.options.items.call(this.element, null, {options: this.options, item: this.currentItem}) : $(this.options.items, this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), this]);

            for (i = queries.length - 1; i >= 0; i--) {
                queries[i][0].each(function() {
                    items.push(this);
                });
            }

            return $(items);

        },
        _removeCurrentsFromItems: function() {

            var list = this.currentItem.find(":data(" + this.widgetName + "-item)");

            this.items = $.grep(this.items, function(item) {
                for (var j = 0; j < list.length; j++) {
                    if (list[j] === item.item[0]) {
                        return false;
                    }
                }
                return true;
            });

        },
        _refreshItems: function(event) {

            this.items = [];
            this.containers = [this];

            var i, j, cur, inst, targetData, _queries, item, queriesLength,
                    items = this.items,
                    queries = [[$.isFunction(this.options.items) ? this.options.items.call(this.element[0], event, {item: this.currentItem}) : $(this.options.items, this.element), this]],
                    connectWith = this._connectWith();

            if (connectWith && this.ready) { //Shouldn't be run the first time through due to massive slow-down
                for (i = connectWith.length - 1; i >= 0; i--) {
                    cur = $(connectWith[i]);
                    for (j = cur.length - 1; j >= 0; j--) {
                        inst = $.data(cur[j], this.widgetFullName);
                        if (inst && inst !== this && !inst.options.disabled) {
                            queries.push([$.isFunction(inst.options.items) ? inst.options.items.call(inst.element[0], event, {item: this.currentItem}) : $(inst.options.items, inst.element), inst]);
                            this.containers.push(inst);
                        }
                    }
                }
            }

            for (i = queries.length - 1; i >= 0; i--) {
                targetData = queries[i][1];
                _queries = queries[i][0];

                for (j = 0, queriesLength = _queries.length; j < queriesLength; j++) {
                    item = $(_queries[j]);

                    item.data(this.widgetName + "-item", targetData); // Data for target checking (mouse manager)

                    items.push({
                        item: item,
                        instance: targetData,
                        width: 0, height: 0,
                        left: 0, top: 0
                    });
                }
            }

        },
        refreshPositions: function(fast) {

            //This has to be redone because due to the item being moved out/into the offsetParent, the offsetParent's position will change
            if (this.offsetParent && this.helper) {
                this.offset.parent = this._getParentOffset();
            }

            var i, item, t, p;

            for (i = this.items.length - 1; i >= 0; i--) {
                item = this.items[i];

                //We ignore calculating positions of all connected containers when we're not over them
                if (item.instance !== this.currentContainer && this.currentContainer && item.item[0] !== this.currentItem[0]) {
                    continue;
                }

                t = this.options.toleranceElement ? $(this.options.toleranceElement, item.item) : item.item;

                if (!fast) {
                    item.width = t.outerWidth();
                    item.height = t.outerHeight();
                }

                p = t.offset();
                item.left = p.left;
                item.top = p.top;
            }

            if (this.options.custom && this.options.custom.refreshContainers) {
                this.options.custom.refreshContainers.call(this);
            } else {
                for (i = this.containers.length - 1; i >= 0; i--) {
                    p = this.containers[i].element.offset();
                    this.containers[i].containerCache.left = p.left;
                    this.containers[i].containerCache.top = p.top;
                    this.containers[i].containerCache.width = this.containers[i].element.outerWidth();
                    this.containers[i].containerCache.height = this.containers[i].element.outerHeight();
                }
            }

            return this;
        },
        _createPlaceholder: function(that) {
            that = that || this;
            var className,
                    o = that.options;

            if (!o.placeholder || o.placeholder.constructor === String) {
                className = o.placeholder;
                o.placeholder = {
                    element: function() {

                        var nodeName = that.currentItem[0].nodeName.toLowerCase(),
                                element = $(that.document[0].createElement(nodeName))
                                .addClass(className || that.currentItem[0].className + " ui-sortable-placeholder")
                                .removeClass("ui-sortable-helper");

                        if (nodeName === "tr") {
                            // Use a high colspan to force the td to expand the full
                            // width of the table (browsers are smart enough to
                            // handle this properly)
                            element.append("<td colspan='99'>&#160;</td>");
                        } else if (nodeName === "img") {
                            element.attr("src", that.currentItem.attr("src"));
                        }

                        if (!className) {
                            element.css("visibility", "hidden");
                        }

                        return element;
                    },
                    update: function(container, p) {

                        // 1. If a className is set as 'placeholder option, we don't force sizes - the class is responsible for that
                        // 2. The option 'forcePlaceholderSize can be enabled to force it even if a class name is specified
                        if (className && !o.forcePlaceholderSize) {
                            return;
                        }

                        //If the element doesn't have a actual height by itself (without styles coming from a stylesheet), it receives the inline height from the dragged item
                        if (!p.height()) {
                            p.height(that.currentItem.innerHeight() - parseInt(that.currentItem.css("paddingTop") || 0, 10) - parseInt(that.currentItem.css("paddingBottom") || 0, 10));
                        }
                        if (!p.width()) {
                            p.width(that.currentItem.innerWidth() - parseInt(that.currentItem.css("paddingLeft") || 0, 10) - parseInt(that.currentItem.css("paddingRight") || 0, 10));
                        }
                    }
                };
            }

            //Create the placeholder
            that.placeholder = $(o.placeholder.element.call(that.element, that.currentItem));

            //Append it after the actual current item
            that.currentItem.after(that.placeholder);

            //Update the size of the placeholder (TODO: Logic to fuzzy, see line 316/317)
            o.placeholder.update(that, that.placeholder);

        },
        _contactContainers: function(event) {
            var i, j, dist, itemWithLeastDistance, posProperty, sizeProperty, base, cur, nearBottom, floating,
                    innermostContainer = null,
                    innermostIndex = null;

            // get innermost container that intersects with item
            for (i = this.containers.length - 1; i >= 0; i--) {

                // never consider a container that's located within the item itself
                if ($.contains(this.currentItem[0], this.containers[i].element[0])) {
                    continue;
                }

                if (this._intersectsWith(this.containers[i].containerCache)) {

                    // if we've already found a container and it's more "inner" than this, then continue
                    if (innermostContainer && $.contains(this.containers[i].element[0], innermostContainer.element[0])) {
                        continue;
                    }

                    innermostContainer = this.containers[i];
                    innermostIndex = i;

                } else {
                    // container doesn't intersect. trigger "out" event if necessary
                    if (this.containers[i].containerCache.over) {
                        this.containers[i]._trigger("out", event, this._uiHash(this));
                        this.containers[i].containerCache.over = 0;
                    }
                }

            }

            // if no intersecting containers found, return
            if (!innermostContainer) {
                return;
            }

            // move the item into the container if it's not there already
            if (this.containers.length === 1) {
                if (!this.containers[innermostIndex].containerCache.over) {
                    this.containers[innermostIndex]._trigger("over", event, this._uiHash(this));
                    this.containers[innermostIndex].containerCache.over = 1;
                }
            } else {

                //When entering a new container, we will find the item with the least distance and append our item near it
                dist = 10000;
                itemWithLeastDistance = null;
                floating = innermostContainer.floating || isFloating(this.currentItem);
                posProperty = floating ? "left" : "top";
                sizeProperty = floating ? "width" : "height";
                base = this.positionAbs[posProperty] + this.offset.click[posProperty];
                for (j = this.items.length - 1; j >= 0; j--) {
                    if (!$.contains(this.containers[innermostIndex].element[0], this.items[j].item[0])) {
                        continue;
                    }
                    if (this.items[j].item[0] === this.currentItem[0]) {
                        continue;
                    }
                    if (floating && !isOverAxis(this.positionAbs.top + this.offset.click.top, this.items[j].top, this.items[j].height)) {
                        continue;
                    }
                    cur = this.items[j].item.offset()[posProperty];
                    nearBottom = false;
                    if (Math.abs(cur - base) > Math.abs(cur + this.items[j][sizeProperty] - base)) {
                        nearBottom = true;
                        cur += this.items[j][sizeProperty];
                    }

                    if (Math.abs(cur - base) < dist) {
                        dist = Math.abs(cur - base);
                        itemWithLeastDistance = this.items[j];
                        this.direction = nearBottom ? "up" : "down";
                    }
                }

                //Check if dropOnEmpty is enabled
                if (!itemWithLeastDistance && !this.options.dropOnEmpty) {
                    return;
                }

                if (this.currentContainer === this.containers[innermostIndex]) {
                    return;
                }

                itemWithLeastDistance ? this._rearrange(event, itemWithLeastDistance, null, true) : this._rearrange(event, null, this.containers[innermostIndex].element, true);
                this._trigger("change", event, this._uiHash());
                this.containers[innermostIndex]._trigger("change", event, this._uiHash(this));
                this.currentContainer = this.containers[innermostIndex];

                //Update the placeholder
                this.options.placeholder.update(this.currentContainer, this.placeholder);

                this.containers[innermostIndex]._trigger("over", event, this._uiHash(this));
                this.containers[innermostIndex].containerCache.over = 1;
            }


        },
        _createHelper: function(event) {

            var o = this.options,
                    helper = $.isFunction(o.helper) ? $(o.helper.apply(this.element[0], [event, this.currentItem])) : (o.helper === "clone" ? this.currentItem.clone() : this.currentItem);

            //Add the helper to the DOM if that didn't happen already
            if (!helper.parents("body").length) {
                $(o.appendTo !== "parent" ? o.appendTo : this.currentItem[0].parentNode)[0].appendChild(helper[0]);
            }

            if (helper[0] === this.currentItem[0]) {
                this._storedCSS = {width: this.currentItem[0].style.width, height: this.currentItem[0].style.height, position: this.currentItem.css("position"), top: this.currentItem.css("top"), left: this.currentItem.css("left")};
            }

            if (!helper[0].style.width || o.forceHelperSize) {
                helper.width(this.currentItem.width());
            }
            if (!helper[0].style.height || o.forceHelperSize) {
                helper.height(this.currentItem.height());
            }

            return helper;

        },
        _adjustOffsetFromHelper: function(obj) {
            if (typeof obj === "string") {
                obj = obj.split(" ");
            }
            if ($.isArray(obj)) {
                obj = {left: +obj[0], top: +obj[1] || 0};
            }
            if ("left" in obj) {
                this.offset.click.left = obj.left + this.margins.left;
            }
            if ("right" in obj) {
                this.offset.click.left = this.helperProportions.width - obj.right + this.margins.left;
            }
            if ("top" in obj) {
                this.offset.click.top = obj.top + this.margins.top;
            }
            if ("bottom" in obj) {
                this.offset.click.top = this.helperProportions.height - obj.bottom + this.margins.top;
            }
        },
        _getParentOffset: function() {


            //Get the offsetParent and cache its position
            this.offsetParent = this.helper.offsetParent();
            var po = this.offsetParent.offset();

            // This is a special case where we need to modify a offset calculated on start, since the following happened:
            // 1. The position of the helper is absolute, so it's position is calculated based on the next positioned parent
            // 2. The actual offset parent is a child of the scroll parent, and the scroll parent isn't the document, which means that
            //    the scroll is included in the initial calculation of the offset of the parent, and never recalculated upon drag
            if (this.cssPosition === "absolute" && this.scrollParent[0] !== document && $.contains(this.scrollParent[0], this.offsetParent[0])) {
                po.left += this.scrollParent.scrollLeft();
                po.top += this.scrollParent.scrollTop();
            }

            // This needs to be actually done for all browsers, since pageX/pageY includes this information
            // with an ugly IE fix
            if (this.offsetParent[0] === document.body || (this.offsetParent[0].tagName && this.offsetParent[0].tagName.toLowerCase() === "html" && $.ui.ie)) {
                po = {top: 0, left: 0};
            }

            return {
                top: po.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                left: po.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
            };

        },
        _getRelativeOffset: function() {

            if (this.cssPosition === "relative") {
                var p = this.currentItem.position();
                return {
                    top: p.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
                    left: p.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
                };
            } else {
                return {top: 0, left: 0};
            }

        },
        _cacheMargins: function() {
            this.margins = {
                left: (parseInt(this.currentItem.css("marginLeft"), 10) || 0),
                top: (parseInt(this.currentItem.css("marginTop"), 10) || 0)
            };
        },
        _cacheHelperProportions: function() {
            this.helperProportions = {
                width: this.helper.outerWidth(),
                height: this.helper.outerHeight()
            };
        },
        _setContainment: function() {

            var ce, co, over,
                    o = this.options;
            if (o.containment === "parent") {
                o.containment = this.helper[0].parentNode;
            }
            if (o.containment === "document" || o.containment === "window") {
                this.containment = [
                    0 - this.offset.relative.left - this.offset.parent.left,
                    0 - this.offset.relative.top - this.offset.parent.top,
                    $(o.containment === "document" ? document : window).width() - this.helperProportions.width - this.margins.left,
                    ($(o.containment === "document" ? document : window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top
                ];
            }

            if (!(/^(document|window|parent)$/).test(o.containment)) {
                ce = $(o.containment)[0];
                co = $(o.containment).offset();
                over = ($(ce).css("overflow") !== "hidden");

                this.containment = [
                    co.left + (parseInt($(ce).css("borderLeftWidth"), 10) || 0) + (parseInt($(ce).css("paddingLeft"), 10) || 0) - this.margins.left,
                    co.top + (parseInt($(ce).css("borderTopWidth"), 10) || 0) + (parseInt($(ce).css("paddingTop"), 10) || 0) - this.margins.top,
                    co.left + (over ? Math.max(ce.scrollWidth, ce.offsetWidth) : ce.offsetWidth) - (parseInt($(ce).css("borderLeftWidth"), 10) || 0) - (parseInt($(ce).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left,
                    co.top + (over ? Math.max(ce.scrollHeight, ce.offsetHeight) : ce.offsetHeight) - (parseInt($(ce).css("borderTopWidth"), 10) || 0) - (parseInt($(ce).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top
                ];
            }

        },
        _convertPositionTo: function(d, pos) {

            if (!pos) {
                pos = this.position;
            }
            var mod = d === "absolute" ? 1 : -1,
                    scroll = this.cssPosition === "absolute" && !(this.scrollParent[0] !== document && $.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent : this.scrollParent,
                    scrollIsRootNode = (/(html|body)/i).test(scroll[0].tagName);

            return {
                top: (
                        pos.top + // The absolute mouse position
                        this.offset.relative.top * mod + // Only for relative positioned nodes: Relative offset from element to offset parent
                        this.offset.parent.top * mod - // The offsetParent's offset without borders (offset + border)
                        ((this.cssPosition === "fixed" ? -this.scrollParent.scrollTop() : (scrollIsRootNode ? 0 : scroll.scrollTop())) * mod)
                        ),
                left: (
                        pos.left + // The absolute mouse position
                        this.offset.relative.left * mod + // Only for relative positioned nodes: Relative offset from element to offset parent
                        this.offset.parent.left * mod - // The offsetParent's offset without borders (offset + border)
                        ((this.cssPosition === "fixed" ? -this.scrollParent.scrollLeft() : scrollIsRootNode ? 0 : scroll.scrollLeft()) * mod)
                        )
            };

        },
        _generatePosition: function(event) {

            var top, left,
                    o = this.options,
                    pageX = event.pageX,
                    pageY = event.pageY,
                    scroll = this.cssPosition === "absolute" && !(this.scrollParent[0] !== document && $.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent : this.scrollParent, scrollIsRootNode = (/(html|body)/i).test(scroll[0].tagName);

            // This is another very weird special case that only happens for relative elements:
            // 1. If the css position is relative
            // 2. and the scroll parent is the document or similar to the offset parent
            // we have to refresh the relative offset during the scroll so there are no jumps
            if (this.cssPosition === "relative" && !(this.scrollParent[0] !== document && this.scrollParent[0] !== this.offsetParent[0])) {
                this.offset.relative = this._getRelativeOffset();
            }

            /*
             * - Position constraining -
             * Constrain the position to a mix of grid, containment.
             */

            if (this.originalPosition) { //If we are not dragging yet, we won't check for options

                if (this.containment) {
                    if (event.pageX - this.offset.click.left < this.containment[0]) {
                        pageX = this.containment[0] + this.offset.click.left;
                    }
                    if (event.pageY - this.offset.click.top < this.containment[1]) {
                        pageY = this.containment[1] + this.offset.click.top;
                    }
                    if (event.pageX - this.offset.click.left > this.containment[2]) {
                        pageX = this.containment[2] + this.offset.click.left;
                    }
                    if (event.pageY - this.offset.click.top > this.containment[3]) {
                        pageY = this.containment[3] + this.offset.click.top;
                    }
                }

                if (o.grid) {
                    top = this.originalPageY + Math.round((pageY - this.originalPageY) / o.grid[1]) * o.grid[1];
                    pageY = this.containment ? ((top - this.offset.click.top >= this.containment[1] && top - this.offset.click.top <= this.containment[3]) ? top : ((top - this.offset.click.top >= this.containment[1]) ? top - o.grid[1] : top + o.grid[1])) : top;

                    left = this.originalPageX + Math.round((pageX - this.originalPageX) / o.grid[0]) * o.grid[0];
                    pageX = this.containment ? ((left - this.offset.click.left >= this.containment[0] && left - this.offset.click.left <= this.containment[2]) ? left : ((left - this.offset.click.left >= this.containment[0]) ? left - o.grid[0] : left + o.grid[0])) : left;
                }

            }

            return {
                top: (
                        pageY - // The absolute mouse position
                        this.offset.click.top - // Click offset (relative to the element)
                        this.offset.relative.top - // Only for relative positioned nodes: Relative offset from element to offset parent
                        this.offset.parent.top + // The offsetParent's offset without borders (offset + border)
                        ((this.cssPosition === "fixed" ? -this.scrollParent.scrollTop() : (scrollIsRootNode ? 0 : scroll.scrollTop())))
                        ),
                left: (
                        pageX - // The absolute mouse position
                        this.offset.click.left - // Click offset (relative to the element)
                        this.offset.relative.left - // Only for relative positioned nodes: Relative offset from element to offset parent
                        this.offset.parent.left + // The offsetParent's offset without borders (offset + border)
                        ((this.cssPosition === "fixed" ? -this.scrollParent.scrollLeft() : scrollIsRootNode ? 0 : scroll.scrollLeft()))
                        )
            };

        },
        _rearrange: function(event, i, a, hardRefresh) {

            a ? a[0].appendChild(this.placeholder[0]) : i.item[0].parentNode.insertBefore(this.placeholder[0], (this.direction === "down" ? i.item[0] : i.item[0].nextSibling));

            //Various things done here to improve the performance:
            // 1. we create a setTimeout, that calls refreshPositions
            // 2. on the instance, we have a counter variable, that get's higher after every append
            // 3. on the local scope, we copy the counter variable, and check in the timeout, if it's still the same
            // 4. this lets only the last addition to the timeout stack through
            this.counter = this.counter ? ++this.counter : 1;
            var counter = this.counter;

            this._delay(function() {
                if (counter === this.counter) {
                    this.refreshPositions(!hardRefresh); //Precompute after each DOM insertion, NOT on mousemove
                }
            });

        },
        _clear: function(event, noPropagation) {

            this.reverting = false;
            // We delay all events that have to be triggered to after the point where the placeholder has been removed and
            // everything else normalized again
            var i,
                    delayedTriggers = [];

            // We first have to update the dom position of the actual currentItem
            // Note: don't do it if the current item is already removed (by a user), or it gets reappended (see #4088)
            if (!this._noFinalSort && this.currentItem.parent().length) {
                this.placeholder.before(this.currentItem);
            }
            this._noFinalSort = null;

            if (this.helper[0] === this.currentItem[0]) {
                for (i in this._storedCSS) {
                    if (this._storedCSS[i] === "auto" || this._storedCSS[i] === "static") {
                        this._storedCSS[i] = "";
                    }
                }
                this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper");
            } else {
                this.currentItem.show();
            }

            if (this.fromOutside && !noPropagation) {
                delayedTriggers.push(function(event) {
                    this._trigger("receive", event, this._uiHash(this.fromOutside));
                });
            }
            if ((this.fromOutside || this.domPosition.prev !== this.currentItem.prev().not(".ui-sortable-helper")[0] || this.domPosition.parent !== this.currentItem.parent()[0]) && !noPropagation) {
                delayedTriggers.push(function(event) {
                    this._trigger("update", event, this._uiHash());
                }); //Trigger update callback if the DOM position has changed
            }

            // Check if the items Container has Changed and trigger appropriate
            // events.
            if (this !== this.currentContainer) {
                if (!noPropagation) {
                    delayedTriggers.push(function(event) {
                        this._trigger("remove", event, this._uiHash());
                    });
                    delayedTriggers.push((function(c) {
                        return function(event) {
                            c._trigger("receive", event, this._uiHash(this));
                        };
                    }).call(this, this.currentContainer));
                    delayedTriggers.push((function(c) {
                        return function(event) {
                            c._trigger("update", event, this._uiHash(this));
                        };
                    }).call(this, this.currentContainer));
                }
            }


            //Post events to containers
            for (i = this.containers.length - 1; i >= 0; i--) {
                if (!noPropagation) {
                    delayedTriggers.push((function(c) {
                        return function(event) {
                            c._trigger("deactivate", event, this._uiHash(this));
                        };
                    }).call(this, this.containers[i]));
                }
                if (this.containers[i].containerCache.over) {
                    delayedTriggers.push((function(c) {
                        return function(event) {
                            c._trigger("out", event, this._uiHash(this));
                        };
                    }).call(this, this.containers[i]));
                    this.containers[i].containerCache.over = 0;
                }
            }

            //Do what was originally in plugins
            if (this.storedCursor) {
                this.document.find("body").css("cursor", this.storedCursor);
                this.storedStylesheet.remove();
            }
            if (this._storedOpacity) {
                this.helper.css("opacity", this._storedOpacity);
            }
            if (this._storedZIndex) {
                this.helper.css("zIndex", this._storedZIndex === "auto" ? "" : this._storedZIndex);
            }

            this.dragging = false;
            if (this.cancelHelperRemoval) {
                if (!noPropagation) {
                    this._trigger("beforeStop", event, this._uiHash());
                    for (i = 0; i < delayedTriggers.length; i++) {
                        delayedTriggers[i].call(this, event);
                    } //Trigger all delayed events
                    this._trigger("stop", event, this._uiHash());
                }

                this.fromOutside = false;
                return false;
            }

            if (!noPropagation) {
                this._trigger("beforeStop", event, this._uiHash());
            }

            //$(this.placeholder[0]).remove(); would have been the jQuery way - unfortunately, it unbinds ALL events from the original node!
            this.placeholder[0].parentNode.removeChild(this.placeholder[0]);

            if (this.helper[0] !== this.currentItem[0]) {
                this.helper.remove();
            }
            this.helper = null;

            if (!noPropagation) {
                for (i = 0; i < delayedTriggers.length; i++) {
                    delayedTriggers[i].call(this, event);
                } //Trigger all delayed events
                this._trigger("stop", event, this._uiHash());
            }

            this.fromOutside = false;
            return true;

        },
        _trigger: function() {
            if ($.Widget.prototype._trigger.apply(this, arguments) === false) {
                this.cancel();
            }
        },
        _uiHash: function(_inst) {
            var inst = _inst || this;
            return {
                helper: inst.helper,
                placeholder: inst.placeholder || $([]),
                position: inst.position,
                originalPosition: inst.originalPosition,
                offset: inst.positionAbs,
                item: inst.currentItem,
                sender: _inst ? _inst.element : null
            };
        }

    });

})(njQuery);

(function($) {
    window.smartSliderSlideOrdering = {
        init: function(url) {
            var ul = $(".smartslider-slides-list");
            ul.qtip({
                id: "slides-ordering",
                content: {
                    text: window.ss2lang.Ordering_saved
                },
                show: {
                    event: false,
                    ready: false
                },
                hide: false,
                position: {
                    my: "bottom center",
                    at: "top center",
                    target: ul,
                    viewport: $(window)
                }
            });
            ul.sortable({
                items: "li.smartslider-slide",
                placeholder: "smartslider-placeholder",
                forcePlaceholderSize: true,
                axis: "y",
                handle: ".smartslider-icon-ordering",
                stop: function(event, ui) {
                    var ajaxcall = url;
                    ajaxcall += (ajaxcall.indexOf("?") ? "&" : "?") + $(this).sortable("serialize");
                    $.ajax({
                        url: ajaxcall,
                        context: document.body
                    }).done(function() {
                        ul.qtip("show");
                        setTimeout(function() {
                            ul.qtip("hide");
                        }, 3000);
                    });
                }
            });
            ul.disableSelection();
        }
    }
})(njQuery);
;(function($) {
    var retina = window.devicePixelRatio > 1;
    $.fn.nextendunveil = function(mode) {
        if(mode == 'phone') mode = 'mobile';
        var images = this,
            deferred = $.Deferred(),
            loadedimages = [];
            
        function loaded(img){
            loadedimages.push(img);
            if(loadedimages.length == images.length){
                deferred.resolve(images)
            }
        };
        
        function getSrc(im, mode){
            var src;
            switch(mode){
                case 'mobile':
                    if(retina){
                        src = im.data('mobileretina');
                        if(src) return src;
                    }
                    src = im.data('mobile');
                    if(src) return src;
                case 'tablet':
                    if(retina){
                        src = im.data('tabletretina');
                        if(src) return src;
                    }
                    src = im.data('tablet');
                    if(src) return src;
                default:
                    if(retina){
                        src = im.data('desktopretina');
                        if(src) return src;
                    }
                    return im.data('desktop');
            }
        }
    
        this.each(function() {
            var targetimg = $(this),
                source = getSrc(targetimg, mode);
            
            if (!this.getAttribute("old-src") && source) {
            
                var oldsrc = this.getAttribute("src"),
                    img = $('<img/>');
                    
                this.setAttribute("old-src", oldsrc);
                
                img[0].setAttribute("src", source);
                
                img.one('load', function() {
                    targetimg[0].setAttribute("src", img[0].getAttribute("src"));
                    targetimg.trigger('lazyloaded');
                    loaded(targetimg);
                }).one('error', function() {
                    targetimg[0].setAttribute("src", oldsrc);
                    loaded(targetimg);
                });
            }else{
                loaded(targetimg);
            }
        });
        
        if(!images.length){
            deferred.resolve(images)
        }
        
        return deferred.promise();
    };
})(njQuery);
/*! waitForImages jQuery Plugin - v1.5.0 - 2013-07-20
* https://github.com/alexanderdickson/waitForImages
* Copyright (c) 2013 Alex Dickson; Licensed MIT */
;(function ($) {
    // Namespace all events.
    var eventNamespace = 'waitForImages';

    // CSS properties which contain references to images.
    $.waitForImages = {
        hasImageProperties: ['backgroundImage', 'listStyleImage', 'borderImage', 'borderCornerImage', 'cursor']
    };

    // Custom selector to find `img` elements that have a valid `src` attribute and have not already loaded.
    $.expr[':'].uncached = function (obj) {
        // Ensure we are dealing with an `img` element with a valid `src` attribute.
        if (!$(obj).is('img[src!=""]')) {
            return false;
        }

        // Firefox's `complete` property will always be `true` even if the image has not been downloaded.
        // Doing it this way works in Firefox.
        var img = new Image();
        img.src = obj.src;
        return !img.complete;
    };

    $.fn.waitForImages = function (finishedCallback, eachCallback, waitForAll) {

        var allImgsLength = 0;
        var allImgsLoaded = 0;

        // Handle options object.
        if ($.isPlainObject(arguments[0])) {
            waitForAll = arguments[0].waitForAll;
            eachCallback = arguments[0].each;
			// This must be last as arguments[0]
			// is aliased with finishedCallback.
            finishedCallback = arguments[0].finished;
        }

        // Handle missing callbacks.
        finishedCallback = finishedCallback || $.noop;
        eachCallback = eachCallback || $.noop;

        // Convert waitForAll to Boolean
        waitForAll = !! waitForAll;

        // Ensure callbacks are functions.
        if (!$.isFunction(finishedCallback) || !$.isFunction(eachCallback)) {
            throw new TypeError('An invalid callback was supplied.');
        }

        return this.each(function () {
            // Build a list of all imgs, dependent on what images will be considered.
            var obj = $(this);
            var allImgs = [];
            // CSS properties which may contain an image.
            var hasImgProperties = $.waitForImages.hasImageProperties || [];
            // To match `url()` references.
            // Spec: http://www.w3.org/TR/CSS2/syndata.html#value-def-uri
            var matchUrl = /url\(\s*(['"]?)(.*?)\1\s*\)/g;

            if (waitForAll) {

                // Get all elements (including the original), as any one of them could have a background image.
                obj.find('*').addBack().each(function () {
                    var element = $(this);

                    // If an `img` element, add it. But keep iterating in case it has a background image too.
                    if (element.is('img:uncached')) {
                        allImgs.push({
                            src: element.attr('src'),
                            element: element[0]
                        });
                    }

                    $.each(hasImgProperties, function (i, property) {
                        var propertyValue = element.css(property);
                        var match;

                        // If it doesn't contain this property, skip.
                        if (!propertyValue) {
                            return true;
                        }

                        // Get all url() of this element.
                        while (match = matchUrl.exec(propertyValue)) {
                            allImgs.push({
                                src: match[2],
                                element: element[0]
                            });
                        }
                    });
                });
            } else {
                // For images only, the task is simpler.
                obj.find('img:uncached')
                    .each(function () {
                    allImgs.push({
                        src: this.src,
                        element: this
                    });
                });
            }

            allImgsLength = allImgs.length;
            allImgsLoaded = 0;

            // If no images found, don't bother.
            if (allImgsLength === 0) {
                finishedCallback.call(obj[0]);
            }

            $.each(allImgs, function (i, img) {

                var image = new Image();

                // Handle the image loading and error with the same callback.
                $(image).on('load.' + eventNamespace + ' error.' + eventNamespace, function (event) {
                    allImgsLoaded++;

                    // If an error occurred with loading the image, set the third argument accordingly.
                    eachCallback.call(img.element, allImgsLoaded, allImgsLength, event.type == 'load');

                    if (allImgsLoaded == allImgsLength) {
                        finishedCallback.call(obj[0]);
                        return false;
                    }

                });

                image.src = img.src;
            });
        });
    };
}(njQuery));
/*
* @fileOverview TouchSwipe - jQuery Plugin
* @version 1.6.5
*
* @author Matt Bryson http://www.github.com/mattbryson
* @see https://github.com/mattbryson/TouchSwipe-Jquery-Plugin
* @see http://labs.skinkers.com/touchSwipe/
* @see http://plugins.jquery.com/project/touchSwipe
*
* Copyright (c) 2010 Matt Bryson
* Dual licensed under the MIT or GPL Version 2 licenses.
*
*
* Changelog
* $Date: 2010-12-12 (Wed, 12 Dec 2010) $
* $version: 1.0.0
* $version: 1.0.1 - removed multibyte comments
*
* $Date: 2011-21-02 (Mon, 21 Feb 2011) $
* $version: 1.1.0 	- added allowPageScroll property to allow swiping and scrolling of page
*					- changed handler signatures so one handler can be used for multiple events
* $Date: 2011-23-02 (Wed, 23 Feb 2011) $
* $version: 1.2.0 	- added click handler. This is fired if the user simply clicks and does not swipe. The event object and click target are passed to handler.
*					- If you use the http://code.google.com/p/jquery-ui-for-ipad-and-iphone/ plugin, you can also assign jQuery mouse events to children of a touchSwipe object.
* $version: 1.2.1 	- removed console log!
*
* $version: 1.2.2 	- Fixed bug where scope was not preserved in callback methods.
*
* $Date: 2011-28-04 (Thurs, 28 April 2011) $
* $version: 1.2.4 	- Changed licence terms to be MIT or GPL inline with jQuery. Added check for support of touch events to stop non compatible browsers erroring.
*
* $Date: 2011-27-09 (Tues, 27 September 2011) $
* $version: 1.2.5 	- Added support for testing swipes with mouse on desktop browser (thanks to https://github.com/joelhy)
*
* $Date: 2012-14-05 (Mon, 14 May 2012) $
* $version: 1.2.6 	- Added timeThreshold between start and end touch, so user can ignore slow swipes (thanks to Mark Chase). Default is null, all swipes are detected
*
* $Date: 2012-05-06 (Tues, 05 June 2012) $
* $version: 1.2.7 	- Changed time threshold to have null default for backwards compatibility. Added duration param passed back in events, and refactored how time is handled.
*
* $Date: 2012-05-06 (Tues, 05 June 2012) $
* $version: 1.2.8 	- Added the possibility to return a value like null or false in the trigger callback. In that way we can control when the touch start/move should take effect or not (simply by returning in some cases return null; or return false;) This effects the ontouchstart/ontouchmove event.
*
* $Date: 2012-06-06 (Wed, 06 June 2012) $
* $version: 1.3.0 	- Refactored whole plugin to allow for methods to be executed, as well as exposed defaults for user override. Added 'enable', 'disable', and 'destroy' methods
*
* $Date: 2012-05-06 (Fri, 05 June 2012) $
* $version: 1.3.1 	- Bug fixes  - bind() with false as last argument is no longer supported in jQuery 1.6, also, if you just click, the duration is now returned correctly.
*
* $Date: 2012-29-07 (Sun, 29 July 2012) $
* $version: 1.3.2	- Added fallbackToMouseEvents option to NOT capture mouse events on non touch devices.
* 			- Added "all" fingers value to the fingers property, so any combination of fingers triggers the swipe, allowing event handlers to check the finger count
*
* $Date: 2012-09-08 (Thurs, 9 Aug 2012) $
* $version: 1.3.3	- Code tidy prep for minefied version
*
* $Date: 2012-04-10 (wed, 4 Oct 2012) $
* $version: 1.4.0	- Added pinch support, pinchIn and pinchOut
*
* $Date: 2012-11-10 (Thurs, 11 Oct 2012) $
* $version: 1.5.0	- Added excludedElements, a jquery selector that specifies child elements that do NOT trigger swipes. By default, this is one select that removes all form, input select, button and anchor elements.
*
* $Date: 2012-22-10 (Mon, 22 Oct 2012) $
* $version: 1.5.1	- Fixed bug with jQuery 1.8 and trailing comma in excludedElements
*					- Fixed bug with IE and eventPreventDefault()
* $Date: 2013-01-12 (Fri, 12 Jan 2013) $
* $version: 1.6.0	- Fixed bugs with pinching, mainly when both pinch and swipe enabled, as well as adding time threshold for multifinger gestures, so releasing one finger beofre the other doesnt trigger as single finger gesture.
*					- made the demo site all static local HTML pages so they can be run locally by a developer
*					- added jsDoc comments and added documentation for the plugin	
*					- code tidy
*					- added triggerOnTouchLeave property that will end the event when the user swipes off the element.
* $Date: 2013-03-23 (Sat, 23 Mar 2013) $
* $version: 1.6.1	- Added support for ie8 touch events
* $version: 1.6.2	- Added support for events binding with on / off / bind in jQ for all callback names.
*                   - Deprecated the 'click' handler in favour of tap.
*                   - added cancelThreshold property
*                   - added option method to update init options at runtime
*
* $version 1.6.3    - added doubletap, longtap events and longTapThreshold, doubleTapThreshold property
* $Date: 2013-04-04 (Thurs, 04 April 2013) $
* $version 1.6.4    - Fixed bug with cancelThreshold introduced in 1.6.3, where swipe status no longer fired start event, and stopped once swiping back.
*
* $Date: 2013-08-24 (Sat, 24 Aug 2013) $
* $version 1.6.5    - Merged a few pull requests fixing various bugs, added AMD support.

*/

/**
 * See (http://jquery.com/).
 * @name $
 * @class 
 * See the jQuery Library  (http://jquery.com/) for full details.  This just
 * documents the function and classes that are added to jQuery by this plug-in.
 */
 
/**
 * See (http://jquery.com/)
 * @name fn
 * @class 
 * See the jQuery Library  (http://jquery.com/) for full details.  This just
 * documents the function and classes that are added to jQuery by this plug-in.
 * @memberOf $
 */



(function (factory) {
    if (typeof define === 'function' && define.amd && define.amd.njQuery) {
        // AMD. Register as anonymous module.
        define(['njquery'], factory);
    } else {
        // Browser globals.
        factory(njQuery);
    }
}(function ($) {
	"use strict";

	//Constants
	var LEFT = "left",
		RIGHT = "right",
		UP = "up",
		DOWN = "down",
		IN = "in",
		OUT = "out",

		NONE = "none",
		AUTO = "auto",
		
		SWIPE = "swipe",
		PINCH = "pinch",
		TAP = "tap",
		DOUBLE_TAP = "doubletap",
		LONG_TAP = "longtap",
		
		HORIZONTAL = "horizontal",
		VERTICAL = "vertical",

		ALL_FINGERS = "all",
		
		DOUBLE_TAP_THRESHOLD = 10,

		PHASE_START = "start",
		PHASE_MOVE = "move",
		PHASE_END = "end",
		PHASE_CANCEL = "cancel",

		SUPPORTS_TOUCH = 'ontouchstart' in window,

		PLUGIN_NS = 'TouchSwipe';



	/**
	* The default configuration, and available options to configure touch swipe with.
	* You can set the default values by updating any of the properties prior to instantiation.
	* @name $.fn.swipe.defaults
	* @namespace
	* @property {int} [fingers=1] The number of fingers to detect in a swipe. Any swipes that do not meet this requirement will NOT trigger swipe handlers.
	* @property {int} [threshold=75] The number of pixels that the user must move their finger by before it is considered a swipe. 
	* @property {int} [cancelThreshold=null] The number of pixels that the user must move their finger back from the original swipe direction to cancel the gesture.
	* @property {int} [pinchThreshold=20] The number of pixels that the user must pinch their finger by before it is considered a pinch. 
	* @property {int} [maxTimeThreshold=null] Time, in milliseconds, between touchStart and touchEnd must NOT exceed in order to be considered a swipe. 
	* @property {int} [fingerReleaseThreshold=250] Time in milliseconds between releasing multiple fingers.  If 2 fingers are down, and are released one after the other, if they are within this threshold, it counts as a simultaneous release. 
	* @property {int} [longTapThreshold=500] Time in milliseconds between tap and release for a long tap
    * @property {int} [doubleTapThreshold=200] Time in milliseconds between 2 taps to count as a double tap
	* @property {function} [swipe=null] A handler to catch all swipes. See {@link $.fn.swipe#event:swipe}
	* @property {function} [swipeLeft=null] A handler that is triggered for "left" swipes. See {@link $.fn.swipe#event:swipeLeft}
	* @property {function} [swipeRight=null] A handler that is triggered for "right" swipes. See {@link $.fn.swipe#event:swipeRight}
	* @property {function} [swipeUp=null] A handler that is triggered for "up" swipes. See {@link $.fn.swipe#event:swipeUp}
	* @property {function} [swipeDown=null] A handler that is triggered for "down" swipes. See {@link $.fn.swipe#event:swipeDown}
	* @property {function} [swipeStatus=null] A handler triggered for every phase of the swipe. See {@link $.fn.swipe#event:swipeStatus}
	* @property {function} [pinchIn=null] A handler triggered for pinch in events. See {@link $.fn.swipe#event:pinchIn}
	* @property {function} [pinchOut=null] A handler triggered for pinch out events. See {@link $.fn.swipe#event:pinchOut}
	* @property {function} [pinchStatus=null] A handler triggered for every phase of a pinch. See {@link $.fn.swipe#event:pinchStatus}
	* @property {function} [tap=null] A handler triggered when a user just taps on the item, rather than swipes it. If they do not move, tap is triggered, if they do move, it is not. 
	* @property {function} [doubleTap=null] A handler triggered when a user double taps on the item. The delay between taps can be set with the doubleTapThreshold property. See {@link $.fn.swipe.defaults#doubleTapThreshold}
	* @property {function} [longTap=null] A handler triggered when a user long taps on the item. The delay between start and end can be set with the longTapThreshold property. See {@link $.fn.swipe.defaults#doubleTapThreshold}
	* @property {boolean} [triggerOnTouchEnd=true] If true, the swipe events are triggered when the touch end event is received (user releases finger).  If false, it will be triggered on reaching the threshold, and then cancel the touch event automatically. 
	* @property {boolean} [triggerOnTouchLeave=false] If true, then when the user leaves the swipe object, the swipe will end and trigger appropriate handlers. 
	* @property {string|undefined} [allowPageScroll='auto'] How the browser handles page scrolls when the user is swiping on a touchSwipe object. See {@link $.fn.swipe.pageScroll}.  <br/><br/>
										<code>"auto"</code> : all undefined swipes will cause the page to scroll in that direction. <br/>
										<code>"none"</code> : the page will not scroll when user swipes. <br/>
										<code>"horizontal"</code> : will force page to scroll on horizontal swipes. <br/>
										<code>"vertical"</code> : will force page to scroll on vertical swipes. <br/>
	* @property {boolean} [fallbackToMouseEvents=true] If true mouse events are used when run on a non touch device, false will stop swipes being triggered by mouse events on non tocuh devices. 
	* @property {string} [excludedElements="button, input, select, textarea, a, .noSwipe"] A jquery selector that specifies child elements that do NOT trigger swipes. By default this excludes all form, input, select, button, anchor and .noSwipe elements. 
	
	*/
	var defaults = {
		fingers: 1, 		
		threshold: 75, 	
		cancelThreshold:null,	
		pinchThreshold:20,
		maxTimeThreshold: null, 
		fingerReleaseThreshold:250, 
		longTapThreshold:500,
		doubleTapThreshold:200,
		swipe: null, 		
		swipeLeft: null, 	
		swipeRight: null, 	
		swipeUp: null, 		
		swipeDown: null, 	
		swipeStatus: null, 	
		pinchIn:null,		
		pinchOut:null,		
		pinchStatus:null,	
		click:null, //Deprecated since 1.6.2
		tap:null,
		doubleTap:null,
		longTap:null, 		
		triggerOnTouchEnd: true, 
		triggerOnTouchLeave:false, 
		allowPageScroll: "auto", 
		fallbackToMouseEvents: true,	
		excludedElements:"label, button, input, select, textarea, .noSwipe"
	};



	/**
	* Applies TouchSwipe behaviour to one or more jQuery objects.
	* The TouchSwipe plugin can be instantiated via this method, or methods within 
	* TouchSwipe can be executed via this method as per jQuery plugin architecture.
	* @see TouchSwipe
	* @class
	* @param {Mixed} method If the current DOMNode is a TouchSwipe object, and <code>method</code> is a TouchSwipe method, then
	* the <code>method</code> is executed, and any following arguments are passed to the TouchSwipe method.
	* If <code>method</code> is an object, then the TouchSwipe class is instantiated on the current DOMNode, passing the 
	* configuration properties defined in the object. See TouchSwipe
	*
	*/
	$.fn.swipe = function (method) {
		var $this = $(this),
			plugin = $this.data(PLUGIN_NS);

		//Check if we are already instantiated and trying to execute a method	
		if (plugin && typeof method === 'string') {
			if (plugin[method]) {
				return plugin[method].apply(this, Array.prototype.slice.call(arguments, 1));
			} else {
				$.error('Method ' + method + ' does not exist on jQuery.swipe');
			}
		}
		//Else not instantiated and trying to pass init object (or nothing)
		else if (!plugin && (typeof method === 'object' || !method)) {
			return init.apply(this, arguments);
		}

		return $this;
	};

	//Expose our defaults so a user could override the plugin defaults
	$.fn.swipe.defaults = defaults;

	/**
	* The phases that a touch event goes through.  The <code>phase</code> is passed to the event handlers. 
	* These properties are read only, attempting to change them will not alter the values passed to the event handlers.
	* @namespace
	* @readonly
	* @property {string} PHASE_START Constant indicating the start phase of the touch event. Value is <code>"start"</code>.
	* @property {string} PHASE_MOVE Constant indicating the move phase of the touch event. Value is <code>"move"</code>.
	* @property {string} PHASE_END Constant indicating the end phase of the touch event. Value is <code>"end"</code>.
	* @property {string} PHASE_CANCEL Constant indicating the cancel phase of the touch event. Value is <code>"cancel"</code>.
	*/
	$.fn.swipe.phases = {
		PHASE_START: PHASE_START,
		PHASE_MOVE: PHASE_MOVE,
		PHASE_END: PHASE_END,
		PHASE_CANCEL: PHASE_CANCEL
	};

	/**
	* The direction constants that are passed to the event handlers. 
	* These properties are read only, attempting to change them will not alter the values passed to the event handlers.
	* @namespace
	* @readonly
	* @property {string} LEFT Constant indicating the left direction. Value is <code>"left"</code>.
	* @property {string} RIGHT Constant indicating the right direction. Value is <code>"right"</code>.
	* @property {string} UP Constant indicating the up direction. Value is <code>"up"</code>.
	* @property {string} DOWN Constant indicating the down direction. Value is <code>"cancel"</code>.
	* @property {string} IN Constant indicating the in direction. Value is <code>"in"</code>.
	* @property {string} OUT Constant indicating the out direction. Value is <code>"out"</code>.
	*/
	$.fn.swipe.directions = {
		LEFT: LEFT,
		RIGHT: RIGHT,
		UP: UP,
		DOWN: DOWN,
		IN : IN,
		OUT: OUT
	};
	
	/**
	* The page scroll constants that can be used to set the value of <code>allowPageScroll</code> option
	* These properties are read only
	* @namespace
	* @readonly
	* @see $.fn.swipe.defaults#allowPageScroll
	* @property {string} NONE Constant indicating no page scrolling is allowed. Value is <code>"none"</code>.
	* @property {string} HORIZONTAL Constant indicating horizontal page scrolling is allowed. Value is <code>"horizontal"</code>.
	* @property {string} VERTICAL Constant indicating vertical page scrolling is allowed. Value is <code>"vertical"</code>.
	* @property {string} AUTO Constant indicating either horizontal or vertical will be allowed, depending on the swipe handlers registered. Value is <code>"auto"</code>.
	*/
	$.fn.swipe.pageScroll = {
		NONE: NONE,
		HORIZONTAL: HORIZONTAL,
		VERTICAL: VERTICAL,
		AUTO: AUTO
	};

	/**
	* Constants representing the number of fingers used in a swipe.  These are used to set both the value of <code>fingers</code> in the 
	* options object, as well as the value of the <code>fingers</code> event property.
	* These properties are read only, attempting to change them will not alter the values passed to the event handlers.
	* @namespace
	* @readonly
	* @see $.fn.swipe.defaults#fingers
	* @property {string} ONE Constant indicating 1 finger is to be detected / was detected. Value is <code>1</code>.
	* @property {string} TWO Constant indicating 2 fingers are to be detected / were detected. Value is <code>1</code>.
	* @property {string} THREE Constant indicating 3 finger are to be detected / were detected. Value is <code>1</code>.
	* @property {string} ALL Constant indicating any combination of finger are to be detected.  Value is <code>"all"</code>.
	*/
	$.fn.swipe.fingers = {
		ONE: 1,
		TWO: 2,
		THREE: 3,
		ALL: ALL_FINGERS
	};

	/**
	* Initialise the plugin for each DOM element matched
	* This creates a new instance of the main TouchSwipe class for each DOM element, and then
	* saves a reference to that instance in the elements data property.
	* @internal
	*/
	function init(options) {
		//Prep and extend the options
		if (options && (options.allowPageScroll === undefined && (options.swipe !== undefined || options.swipeStatus !== undefined))) {
			options.allowPageScroll = NONE;
		}
		
        //Check for deprecated options
		//Ensure that any old click handlers are assigned to the new tap, unless we have a tap
		if(options.click!==undefined && options.tap===undefined) {
		    options.tap = options.click;
		}

		if (!options) {
			options = {};
		}
		
        //pass empty object so we dont modify the defaults
		options = $.extend({}, $.fn.swipe.defaults, options);

		//For each element instantiate the plugin
		return this.each(function () {
			var $this = $(this);

			//Check we havent already initialised the plugin
			var plugin = $this.data(PLUGIN_NS);

			if (!plugin) {
				plugin = new TouchSwipe(this, options);
				$this.data(PLUGIN_NS, plugin);
			}
		});
	}

	/**
	* Main TouchSwipe Plugin Class.
	* Do not use this to construct your TouchSwipe object, use the jQuery plugin method $.fn.swipe(); {@link $.fn.swipe}
	* @private
	* @name TouchSwipe
	* @param {DOMNode} element The HTML DOM object to apply to plugin to
	* @param {Object} options The options to configure the plugin with.  @link {$.fn.swipe.defaults}
	* @see $.fh.swipe.defaults
	* @see $.fh.swipe
    * @class
	*/
	function TouchSwipe(element, options) {
		var useTouchEvents = (SUPPORTS_TOUCH || !options.fallbackToMouseEvents),
			START_EV = useTouchEvents ? 'touchstart' : 'mousedown',
			MOVE_EV = useTouchEvents ? 'touchmove' : 'mousemove',
			END_EV = useTouchEvents ? 'touchend' : 'mouseup',
			LEAVE_EV = useTouchEvents ? null : 'mouseleave', //we manually detect leave on touch devices, so null event here
			CANCEL_EV = 'touchcancel';



		//touch properties
		var distance = 0,
			direction = null,
			duration = 0,
			startTouchesDistance = 0,
			endTouchesDistance = 0,
			pinchZoom = 1,
			pinchDistance = 0,
			pinchDirection = 0,
			maximumsMap=null;

		
		
		//jQuery wrapped element for this instance
		var $element = $(element);
		
		//Current phase of th touch cycle
		var phase = "start";

		// the current number of fingers being used.
		var fingerCount = 0; 			

		//track mouse points / delta
		var fingerData=null;

		//track times
		var startTime = 0,
			endTime = 0,
			previousTouchEndTime=0,
			previousTouchFingerCount=0,
			doubleTapStartTime=0;

        //Timeouts
        var singleTapTimeout=null;
        
		// Add gestures to all swipable areas if supported
		try {
			$element.bind(START_EV, touchStart);
			$element.bind(CANCEL_EV, touchCancel);
		}
		catch (e) {
			$.error('events not supported ' + START_EV + ',' + CANCEL_EV + ' on jQuery.swipe');
		}

		//
		//Public methods
		//
		
		/**
		* re-enables the swipe plugin with the previous configuration
		* @function
		* @name $.fn.swipe#enable
		* @return {DOMNode} The Dom element that was registered with TouchSwipe 
		* @example $("#element").swipe("enable");
		*/
		this.enable = function () {
			$element.bind(START_EV, touchStart);
			$element.bind(CANCEL_EV, touchCancel);
			return $element;
		};

		/**
		* disables the swipe plugin
		* @function
		* @name $.fn.swipe#disable
		* @return {DOMNode} The Dom element that is now registered with TouchSwipe
	    * @example $("#element").swipe("disable");
		*/
		this.disable = function () {
			removeListeners();
			return $element;
		};

		/**
		* Destroy the swipe plugin completely. To use any swipe methods, you must re initialise the plugin.
		* @function
		* @name $.fn.swipe#destroy
		* @return {DOMNode} The Dom element that was registered with TouchSwipe 
		* @example $("#element").swipe("destroy");
		*/
		this.destroy = function () {
			removeListeners();
			$element.data(PLUGIN_NS, null);
			return $element;
		};


        /**
         * Allows run time updating of the swipe configuration options.
         * @function
    	 * @name $.fn.swipe#option
    	 * @param {String} property The option property to get or set
         * @param {Object} [value] The value to set the property to
		 * @return {Object} If only a property name is passed, then that property value is returned.
		 * @example $("#element").swipe("option", "threshold"); // return the threshold
         * @example $("#element").swipe("option", "threshold", 100); // set the threshold after init
         * @see $.fn.swipe.defaults
         *
         */
        this.option = function (property, value) {
            if(options[property]!==undefined) {
                if(value===undefined) {
                    return options[property];
                } else {
                    options[property] = value;
                }
            } else {
                $.error('Option ' + property + ' does not exist on jQuery.swipe.options');
            }

            return null;
        }

		//
		// Private methods
		//
		
		//
		// EVENTS
		//
		/**
		* Event handler for a touch start event.
		* Stops the default click event from triggering and stores where we touched
		* @inner
		* @param {object} jqEvent The normalised jQuery event object.
		*/
		function touchStart(jqEvent) {
			//If we already in a touch event (a finger already in use) then ignore subsequent ones..
			if( getTouchInProgress() )
				return;
			
			//Check if this element matches any in the excluded elements selectors,  or its parent is excluded, if so, DON'T swipe
			if( $(jqEvent.target).closest( options.excludedElements, $element ).length>0 ) 
				return;
				
			//As we use Jquery bind for events, we need to target the original event object
			//If these events are being programmatically triggered, we don't have an original event object, so use the Jq one.
			var event = jqEvent.originalEvent ? jqEvent.originalEvent : jqEvent;
			
			var ret,
				evt = SUPPORTS_TOUCH ? event.touches[0] : event;

			phase = PHASE_START;

			//If we support touches, get the finger count
			if (SUPPORTS_TOUCH) {
				// get the total number of fingers touching the screen
				fingerCount = event.touches.length;
			}
			//Else this is the desktop, so stop the browser from dragging the image
			else {
				jqEvent.preventDefault(); //call this on jq event so we are cross browser
			}

			//clear vars..
			distance = 0;
			direction = null;
			pinchDirection=null;
			duration = 0;
			startTouchesDistance=0;
			endTouchesDistance=0;
			pinchZoom = 1;
			pinchDistance = 0;
			fingerData=createAllFingerData();
			maximumsMap=createMaximumsData();
			cancelMultiFingerRelease();

			
			// check the number of fingers is what we are looking for, or we are capturing pinches
			if (!SUPPORTS_TOUCH || (fingerCount === options.fingers || options.fingers === ALL_FINGERS) || hasPinches()) {
				// get the coordinates of the touch
				createFingerData( 0, evt );
				startTime = getTimeStamp();
				
				if(fingerCount==2) {
					//Keep track of the initial pinch distance, so we can calculate the diff later
					//Store second finger data as start
					createFingerData( 1, event.touches[1] );
					startTouchesDistance = endTouchesDistance = calculateTouchesDistance(fingerData[0].start, fingerData[1].start);
				}
				
				if (options.swipeStatus || options.pinchStatus) {
					ret = triggerHandler(event, phase);
				}
			}
			else {
				//A touch with more or less than the fingers we are looking for, so cancel
				ret = false; 
			}

			//If we have a return value from the users handler, then return and cancel
			if (ret === false) {
				phase = PHASE_CANCEL;
				triggerHandler(event, phase);
				return ret;
			}
			else {
				setTouchInProgress(true);
			}

            return null;
		};
		
		
		
		/**
		* Event handler for a touch move event. 
		* If we change fingers during move, then cancel the event
		* @inner
		* @param {object} jqEvent The normalised jQuery event object.
		*/
		function touchMove(jqEvent) {
			
			//As we use Jquery bind for events, we need to target the original event object
			//If these events are being programmatically triggered, we don't have an original event object, so use the Jq one.
			var event = jqEvent.originalEvent ? jqEvent.originalEvent : jqEvent;
			
			//If we are ending, cancelling, or within the threshold of 2 fingers being released, don't track anything..
			if (phase === PHASE_END || phase === PHASE_CANCEL || inMultiFingerRelease())
				return;

			var ret,
				evt = SUPPORTS_TOUCH ? event.touches[0] : event;
			

			//Update the  finger data 
			var currentFinger = updateFingerData(evt);
			endTime = getTimeStamp();
			
			if (SUPPORTS_TOUCH) {
				fingerCount = event.touches.length;
			}

			phase = PHASE_MOVE;

			//If we have 2 fingers get Touches distance as well
			if(fingerCount==2) {
				
				//Keep track of the initial pinch distance, so we can calculate the diff later
				//We do this here as well as the start event, in case they start with 1 finger, and the press 2 fingers
				if(startTouchesDistance==0) {
					//Create second finger if this is the first time...
					createFingerData( 1, event.touches[1] );
					
					startTouchesDistance = endTouchesDistance = calculateTouchesDistance(fingerData[0].start, fingerData[1].start);
				} else {
					//Else just update the second finger
					updateFingerData(event.touches[1]);
				
					endTouchesDistance = calculateTouchesDistance(fingerData[0].end, fingerData[1].end);
					pinchDirection = calculatePinchDirection(fingerData[0].end, fingerData[1].end);
				}
				
				
				pinchZoom = calculatePinchZoom(startTouchesDistance, endTouchesDistance);
				pinchDistance = Math.abs(startTouchesDistance - endTouchesDistance);
			}
			
			
			if ( (fingerCount === options.fingers || options.fingers === ALL_FINGERS) || !SUPPORTS_TOUCH || hasPinches() ) {
				
				direction = calculateDirection(currentFinger.start, currentFinger.end);
				
				//Check if we need to prevent default event (page scroll / pinch zoom) or not
				validateDefaultEvent(jqEvent, direction);

				//Distance and duration are all off the main finger
				distance = calculateDistance(currentFinger.start, currentFinger.end);
				duration = calculateDuration();

                //Cache the maximum distance we made in this direction
                setMaxDistance(direction, distance);


				if (options.swipeStatus || options.pinchStatus) {
					ret = triggerHandler(event, phase);
				}
				
				
				//If we trigger end events when threshold are met, or trigger events when touch leaves element
				if(!options.triggerOnTouchEnd || options.triggerOnTouchLeave) {
					
					var inBounds = true;
					
					//If checking if we leave the element, run the bounds check (we can use touchleave as its not supported on webkit)
					if(options.triggerOnTouchLeave) {
						var bounds = getbounds( this );
						inBounds = isInBounds( currentFinger.end, bounds );
					}
					
					//Trigger end handles as we swipe if thresholds met or if we have left the element if the user has asked to check these..
					if(!options.triggerOnTouchEnd && inBounds) {
						phase = getNextPhase( PHASE_MOVE );
					} 
					//We end if out of bounds here, so set current phase to END, and check if its modified 
					else if(options.triggerOnTouchLeave && !inBounds ) {
						phase = getNextPhase( PHASE_END );
					}
						
					if(phase==PHASE_CANCEL || phase==PHASE_END)	{
						triggerHandler(event, phase);
					}				
				}
			}
			else {
				phase = PHASE_CANCEL;
				triggerHandler(event, phase);
			}

			if (ret === false) {
				phase = PHASE_CANCEL;
				triggerHandler(event, phase);
			}
		}



		/**
		* Event handler for a touch end event. 
		* Calculate the direction and trigger events
		* @inner
		* @param {object} jqEvent The normalised jQuery event object.
		*/
		function touchEnd(jqEvent) {
			//As we use Jquery bind for events, we need to target the original event object
			var event = jqEvent.originalEvent;
				

			//If we are still in a touch with another finger return
			//This allows us to wait a fraction and see if the other finger comes up, if it does within the threshold, then we treat it as a multi release, not a single release.
			if (SUPPORTS_TOUCH) {
				if(event.touches.length>0) {
					startMultiFingerRelease();
					return true;
				}
			}
			
			//If a previous finger has been released, check how long ago, if within the threshold, then assume it was a multifinger release.
			//This is used to allow 2 fingers to release fractionally after each other, whilst maintainig the event as containg 2 fingers, not 1
			if(inMultiFingerRelease()) {	
				fingerCount=previousTouchFingerCount;
			}	
				 
			//call this on jq event so we are cross browser 
			jqEvent.preventDefault(); 
			
			//Set end of swipe
			endTime = getTimeStamp();
			
			//Get duration incase move was never fired
			duration = calculateDuration();
			
			//If we trigger handlers at end of swipe OR, we trigger during, but they didnt trigger and we are still in the move phase
			if(didSwipeBackToCancel()) {
			    phase = PHASE_CANCEL;
                triggerHandler(event, phase);
			} else if (options.triggerOnTouchEnd || (options.triggerOnTouchEnd == false && phase === PHASE_MOVE)) {
				phase = PHASE_END;
                triggerHandler(event, phase);
			}
			//Special cases - A tap should always fire on touch end regardless,
			//So here we manually trigger the tap end handler by itself
			//We dont run trigger handler as it will re-trigger events that may have fired already
			else if (!options.triggerOnTouchEnd && hasTap()) {
                //Trigger the pinch events...
			    phase = PHASE_END;
			    triggerHandlerForGesture(event, phase, TAP);
			}
			else if (phase === PHASE_MOVE) {
				phase = PHASE_CANCEL;
				triggerHandler(event, phase);
			}

			setTouchInProgress(false);

            return null;
		}



		/**
		* Event handler for a touch cancel event. 
		* Clears current vars
		* @inner
		*/
		function touchCancel() {
			// reset the variables back to default values
			fingerCount = 0;
			endTime = 0;
			startTime = 0;
			startTouchesDistance=0;
			endTouchesDistance=0;
			pinchZoom=1;
			
			//If we were in progress of tracking a possible multi touch end, then re set it.
			cancelMultiFingerRelease();
			
			setTouchInProgress(false);
		}
		
		
		/**
		* Event handler for a touch leave event. 
		* This is only triggered on desktops, in touch we work this out manually
		* as the touchleave event is not supported in webkit
		* @inner
		*/
		function touchLeave(jqEvent) {
			var event = jqEvent.originalEvent;
			
			//If we have the trigger on leave property set....
			if(options.triggerOnTouchLeave) {
				phase = getNextPhase( PHASE_END );
				triggerHandler(event, phase);
			}
		}
		
		/**
		* Removes all listeners that were associated with the plugin
		* @inner
		*/
		function removeListeners() {
			$element.unbind(START_EV, touchStart);
			$element.unbind(CANCEL_EV, touchCancel);
			$element.unbind(MOVE_EV, touchMove);
			$element.unbind(END_EV, touchEnd);
			
			//we only have leave events on desktop, we manually calculate leave on touch as its not supported in webkit
			if(LEAVE_EV) { 
				$element.unbind(LEAVE_EV, touchLeave);
			}
			
			setTouchInProgress(false);
		}

		
		/**
		 * Checks if the time and distance thresholds have been met, and if so then the appropriate handlers are fired.
		 */
		function getNextPhase(currentPhase) {
			
			var nextPhase = currentPhase;
			
			// Ensure we have valid swipe (under time and over distance  and check if we are out of bound...)
			var validTime = validateSwipeTime();
			var validDistance = validateSwipeDistance();
			var didCancel = didSwipeBackToCancel();
						
			//If we have exceeded our time, then cancel	
			if(!validTime || didCancel) {
				nextPhase = PHASE_CANCEL;
			}
			//Else if we are moving, and have reached distance then end
			else if (validDistance && currentPhase == PHASE_MOVE && (!options.triggerOnTouchEnd || options.triggerOnTouchLeave) ) {
				nextPhase = PHASE_END;
			} 
			//Else if we have ended by leaving and didn't reach distance, then cancel
			else if (!validDistance && currentPhase==PHASE_END && options.triggerOnTouchLeave) {
				nextPhase = PHASE_CANCEL;
			}
			
			return nextPhase;
		}
		
		
		/**
		* Trigger the relevant event handler
		* The handlers are passed the original event, the element that was swiped, and in the case of the catch all handler, the direction that was swiped, "left", "right", "up", or "down"
		* @param {object} event the original event object
		* @param {string} phase the phase of the swipe (start, end cancel etc) {@link $.fn.swipe.phases}
		* @inner
		*/
		function triggerHandler(event, phase) {
			
			var ret = undefined;
			
			// SWIPE GESTURES
			if(didSwipe() || hasSwipes()) { //hasSwipes as status needs to fire even if swipe is invalid
				//Trigger the swipe events...
				ret = triggerHandlerForGesture(event, phase, SWIPE);
			} 
			
			// PINCH GESTURES (if the above didn't cancel)
			else if((didPinch() || hasPinches()) && ret!==false) {
				//Trigger the pinch events...
				ret = triggerHandlerForGesture(event, phase, PINCH);
			}
			
			// CLICK / TAP (if the above didn't cancel)
			if(didDoubleTap() && ret!==false) {
				//Trigger the tap events...
				ret = triggerHandlerForGesture(event, phase, DOUBLE_TAP);
			}
			
			// CLICK / TAP (if the above didn't cancel)
			else if(didLongTap() && ret!==false) {
				//Trigger the tap events...
				ret = triggerHandlerForGesture(event, phase, LONG_TAP);
			}

			// CLICK / TAP (if the above didn't cancel)
			else if(didTap() && ret!==false) {
				//Trigger the tap event..
				ret = triggerHandlerForGesture(event, phase, TAP);
	    	}
			
			
			
			// If we are cancelling the gesture, then manually trigger the reset handler
			if (phase === PHASE_CANCEL) {
				touchCancel(event);
			}
			
			// If we are ending the gesture, then manually trigger the reset handler IF all fingers are off
			if(phase === PHASE_END) {
				//If we support touch, then check that all fingers are off before we cancel
				if (SUPPORTS_TOUCH) {
					if(event.touches.length==0) {
						touchCancel(event);	
					}
				} 
				else {
					touchCancel(event);
				}
			}
					
			return ret;
		}
		
		
		
		/**
		* Trigger the relevant event handler
		* The handlers are passed the original event, the element that was swiped, and in the case of the catch all handler, the direction that was swiped, "left", "right", "up", or "down"
		* @param {object} event the original event object
		* @param {string} phase the phase of the swipe (start, end cancel etc) {@link $.fn.swipe.phases}
		* @param {string} gesture the gesture to trigger a handler for : PINCH or SWIPE {@link $.fn.swipe.gestures}
		* @return Boolean False, to indicate that the event should stop propagation, or void.
		* @inner
		*/
		function triggerHandlerForGesture(event, phase, gesture) {	
			
			var ret=undefined;
			
			//SWIPES....
			if(gesture==SWIPE) {
				//Trigger status every time..
				
				//Trigger the event...
				$element.trigger('swipeStatus', [phase, direction || null, distance || 0, duration || 0, fingerCount]);
				
				//Fire the callback
				if (options.swipeStatus) {
					ret = options.swipeStatus.call($element, event, phase, direction || null, distance || 0, duration || 0, fingerCount);
					//If the status cancels, then dont run the subsequent event handlers..
					if(ret===false) return false;
				}
				
				
				
				
				if (phase == PHASE_END && validateSwipe()) {
					//Fire the catch all event
					$element.trigger('swipe', [direction, distance, duration, fingerCount]);
					
					//Fire catch all callback
					if (options.swipe) {
						ret = options.swipe.call($element, event, direction, distance, duration, fingerCount);
						//If the status cancels, then dont run the subsequent event handlers..
						if(ret===false) return false;
					}
					
					//trigger direction specific event handlers	
					switch (direction) {
						case LEFT:
							//Trigger the event
							$element.trigger('swipeLeft', [direction, distance, duration, fingerCount]);
					
					        //Fire the callback
							if (options.swipeLeft) {
								ret = options.swipeLeft.call($element, event, direction, distance, duration, fingerCount);
							}
							break;
	
						case RIGHT:
							//Trigger the event
					        $element.trigger('swipeRight', [direction, distance, duration, fingerCount]);
					
					        //Fire the callback
							if (options.swipeRight) {
								ret = options.swipeRight.call($element, event, direction, distance, duration, fingerCount);
							}
							break;
	
						case UP:
							//Trigger the event
					        $element.trigger('swipeUp', [direction, distance, duration, fingerCount]);
					
					        //Fire the callback
							if (options.swipeUp) {
								ret = options.swipeUp.call($element, event, direction, distance, duration, fingerCount);
							}
							break;
	
						case DOWN:
							//Trigger the event
					        $element.trigger('swipeDown', [direction, distance, duration, fingerCount]);
					
					        //Fire the callback
							if (options.swipeDown) {
								ret = options.swipeDown.call($element, event, direction, distance, duration, fingerCount);
							}
							break;
					}
				}
			}
			
			
			//PINCHES....
			if(gesture==PINCH) {
				//Trigger the event
			     $element.trigger('pinchStatus', [phase, pinchDirection || null, pinchDistance || 0, duration || 0, fingerCount, pinchZoom]);
					
                //Fire the callback
				if (options.pinchStatus) {
					ret = options.pinchStatus.call($element, event, phase, pinchDirection || null, pinchDistance || 0, duration || 0, fingerCount, pinchZoom);
					//If the status cancels, then dont run the subsequent event handlers..
					if(ret===false) return false;
				}
				
				if(phase==PHASE_END && validatePinch()) {
					
					switch (pinchDirection) {
						case IN:
							//Trigger the event
                            $element.trigger('pinchIn', [pinchDirection || null, pinchDistance || 0, duration || 0, fingerCount, pinchZoom]);
                    
                            //Fire the callback
                            if (options.pinchIn) {
								ret = options.pinchIn.call($element, event, pinchDirection || null, pinchDistance || 0, duration || 0, fingerCount, pinchZoom);
							}
							break;
						
						case OUT:
							//Trigger the event
                            $element.trigger('pinchOut', [pinchDirection || null, pinchDistance || 0, duration || 0, fingerCount, pinchZoom]);
                    
                            //Fire the callback
                            if (options.pinchOut) {
								ret = options.pinchOut.call($element, event, pinchDirection || null, pinchDistance || 0, duration || 0, fingerCount, pinchZoom);
							}
							break;	
					}
				}
			}
			


                
	    		
			if(gesture==TAP) {
				if(phase === PHASE_CANCEL || phase === PHASE_END) {
					
    			    
    			    //Cancel any existing double tap
				    clearTimeout(singleTapTimeout);
				           
					//If we are also looking for doubelTaps, wait incase this is one...
				    if(hasDoubleTap() && !inDoubleTap()) {
				        //Cache the time of this tap
                        doubleTapStartTime = getTimeStamp();
                       
				        //Now wait for the double tap timeout, and trigger this single tap
				        //if its not cancelled by a double tap
				        singleTapTimeout = setTimeout($.proxy(function() {
        			        doubleTapStartTime=null;
        			        //Trigger the event
                            $element.trigger('tap', [event.target]);

                        
                            //Fire the callback
                            if(options.tap) {
                                ret = options.tap.call($element, event, event.target);
                            }
    			        }, this), options.doubleTapThreshold );
    			    	
    			    } else {
                        doubleTapStartTime=null;
                        
                        //Trigger the event
                        $element.trigger('tap', [event.target]);

                        
                        //Fire the callback
                        if(options.tap) {
                            ret = options.tap.call($element, event, event.target);
                        }
	    		    }
	    		}
			}
			
			else if (gesture==DOUBLE_TAP) {
				if(phase === PHASE_CANCEL || phase === PHASE_END) {
					//Cancel any pending singletap 
				    clearTimeout(singleTapTimeout);
				    doubleTapStartTime=null;
				        
                    //Trigger the event
                    $element.trigger('doubletap', [event.target]);
                
                    //Fire the callback
                    if(options.doubleTap) {
                        ret = options.doubleTap.call($element, event, event.target);
                    }
	    		}
			}
			
			else if (gesture==LONG_TAP) {
				if(phase === PHASE_CANCEL || phase === PHASE_END) {
					//Cancel any pending singletap (shouldnt be one)
				    clearTimeout(singleTapTimeout);
				    doubleTapStartTime=null;
				        
                    //Trigger the event
                    $element.trigger('longtap', [event.target]);
                
                    //Fire the callback
                    if(options.longTap) {
                        ret = options.longTap.call($element, event, event.target);
                    }
	    		}
			}				
				
			return ret;
		}



		
		//
		// GESTURE VALIDATION
		//
		
		/**
		* Checks the user has swipe far enough
		* @return Boolean if <code>threshold</code> has been set, return true if the threshold was met, else false.
		* If no threshold was set, then we return true.
		* @inner
		*/
		function validateSwipeDistance() {
			var valid = true;
			//If we made it past the min swipe distance..
			if (options.threshold !== null) {
				valid = distance >= options.threshold;
			}
			
            return valid;
		}
		
		/**
		* Checks the user has swiped back to cancel.
		* @return Boolean if <code>cancelThreshold</code> has been set, return true if the cancelThreshold was met, else false.
		* If no cancelThreshold was set, then we return true.
		* @inner
		*/
		function didSwipeBackToCancel() {
            var cancelled = false;
    		if(options.cancelThreshold !== null && direction !==null)  {
    		    cancelled =  (getMaxDistance( direction ) - distance) >= options.cancelThreshold;
			}
			
			return cancelled;
		}

		/**
		* Checks the user has pinched far enough
		* @return Boolean if <code>pinchThreshold</code> has been set, return true if the threshold was met, else false.
		* If no threshold was set, then we return true.
		* @inner
		*/
		function validatePinchDistance() {
			if (options.pinchThreshold !== null) {
				return pinchDistance >= options.pinchThreshold;
			}
			return true;
		}

		/**
		* Checks that the time taken to swipe meets the minimum / maximum requirements
		* @return Boolean
		* @inner
		*/
		function validateSwipeTime() {
			var result;
			//If no time set, then return true

			if (options.maxTimeThreshold) {
				if (duration >= options.maxTimeThreshold) {
					result = false;
				} else {
					result = true;
				}
			}
			else {
				result = true;
			}

			return result;
		}


		/**
		* Checks direction of the swipe and the value allowPageScroll to see if we should allow or prevent the default behaviour from occurring.
		* This will essentially allow page scrolling or not when the user is swiping on a touchSwipe object.
		* @param {object} jqEvent The normalised jQuery representation of the event object.
		* @param {string} direction The direction of the event. See {@link $.fn.swipe.directions}
		* @see $.fn.swipe.directions
		* @inner
		*/
		function validateDefaultEvent(jqEvent, direction) {
			if (options.allowPageScroll === NONE || hasPinches()) {
				jqEvent.preventDefault();
			} else {
				var auto = options.allowPageScroll === AUTO;

				switch (direction) {
					case LEFT:
						if ((options.swipeLeft && auto) || (!auto && options.allowPageScroll != HORIZONTAL)) {
							jqEvent.preventDefault();
						}
						break;

					case RIGHT:
						if ((options.swipeRight && auto) || (!auto && options.allowPageScroll != HORIZONTAL)) {
							jqEvent.preventDefault();
						}
						break;

					case UP:
						if ((options.swipeUp && auto) || (!auto && options.allowPageScroll != VERTICAL)) {
							jqEvent.preventDefault();
						}
						break;

					case DOWN:
						if ((options.swipeDown && auto) || (!auto && options.allowPageScroll != VERTICAL)) {
							jqEvent.preventDefault();
						}
						break;
				}
			}

		}


		// PINCHES
		/**
		 * Returns true of the current pinch meets the thresholds
		 * @return Boolean
		 * @inner
		*/
		function validatePinch() {
		    var hasCorrectFingerCount = validateFingers();
		    var hasEndPoint = validateEndPoint();
			var hasCorrectDistance = validatePinchDistance();
			return hasCorrectFingerCount && hasEndPoint && hasCorrectDistance;
			
		}
		
		/**
		 * Returns true if any Pinch events have been registered
		 * @return Boolean
		 * @inner
		*/
		function hasPinches() {
			//Enure we dont return 0 or null for false values
			return !!(options.pinchStatus || options.pinchIn || options.pinchOut);
		}
		
		/**
		 * Returns true if we are detecting pinches, and have one
		 * @return Boolean
		 * @inner
		 */
		function didPinch() {
			//Enure we dont return 0 or null for false values
			return !!(validatePinch() && hasPinches());
		}




		// SWIPES
		/**
		 * Returns true if the current swipe meets the thresholds
		 * @return Boolean
		 * @inner
		*/
		function validateSwipe() {
			//Check validity of swipe
			var hasValidTime = validateSwipeTime();
			var hasValidDistance = validateSwipeDistance();	
			var hasCorrectFingerCount = validateFingers();
		    var hasEndPoint = validateEndPoint();
		    var didCancel = didSwipeBackToCancel();	
		    
			// if the user swiped more than the minimum length, perform the appropriate action
			// hasValidDistance is null when no distance is set 
			var valid =  !didCancel && hasEndPoint && hasCorrectFingerCount && hasValidDistance && hasValidTime;
			
			return valid;
		}
		
		/**
		 * Returns true if any Swipe events have been registered
		 * @return Boolean
		 * @inner
		*/
		function hasSwipes() {
			//Enure we dont return 0 or null for false values
			return !!(options.swipe || options.swipeStatus || options.swipeLeft || options.swipeRight || options.swipeUp || options.swipeDown);
		}
		
		
		/**
		 * Returns true if we are detecting swipes and have one
		 * @return Boolean
		 * @inner
		*/
		function didSwipe() {
			//Enure we dont return 0 or null for false values
			return !!(validateSwipe() && hasSwipes());
		}

        /**
		 * Returns true if we have matched the number of fingers we are looking for
		 * @return Boolean
		 * @inner
		*/
        function validateFingers() {
            //The number of fingers we want were matched, or on desktop we ignore
    		return ((fingerCount === options.fingers || options.fingers === ALL_FINGERS) || !SUPPORTS_TOUCH);
    	}
        
        /**
		 * Returns true if we have an end point for the swipe
		 * @return Boolean
		 * @inner
		*/
        function validateEndPoint() {
            //We have an end value for the finger
		    return fingerData[0].end.x !== 0;
        }

		// TAP / CLICK
		/**
		 * Returns true if a click / tap events have been registered
		 * @return Boolean
		 * @inner
		*/
		function hasTap() {
			//Enure we dont return 0 or null for false values
			return !!(options.tap) ;
		}
		
		/**
		 * Returns true if a double tap events have been registered
		 * @return Boolean
		 * @inner
		*/
		function hasDoubleTap() {
			//Enure we dont return 0 or null for false values
			return !!(options.doubleTap) ;
		}
		
		/**
		 * Returns true if any long tap events have been registered
		 * @return Boolean
		 * @inner
		*/
		function hasLongTap() {
			//Enure we dont return 0 or null for false values
			return !!(options.longTap) ;
		}
		
		/**
		 * Returns true if we could be in the process of a double tap (one tap has occurred, we are listening for double taps, and the threshold hasn't past.
		 * @return Boolean
		 * @inner
		*/
		function validateDoubleTap() {
		    if(doubleTapStartTime==null){
		        return false;
		    }
		    var now = getTimeStamp();
		    return (hasDoubleTap() && ((now-doubleTapStartTime) <= options.doubleTapThreshold));
		}
		
		/**
		 * Returns true if we could be in the process of a double tap (one tap has occurred, we are listening for double taps, and the threshold hasn't past.
		 * @return Boolean
		 * @inner
		*/
		function inDoubleTap() {
		    return validateDoubleTap();
		}
		
		
		/**
		 * Returns true if we have a valid tap
		 * @return Boolean
		 * @inner
		*/
		function validateTap() {
		    return ((fingerCount === 1 || !SUPPORTS_TOUCH) && (isNaN(distance) || distance === 0));
		}
		
		/**
		 * Returns true if we have a valid long tap
		 * @return Boolean
		 * @inner
		*/
		function validateLongTap() {
		    //slight threshold on moving finger
            return ((duration > options.longTapThreshold) && (distance < DOUBLE_TAP_THRESHOLD)); 
		}
		
		/**
		 * Returns true if we are detecting taps and have one
		 * @return Boolean
		 * @inner
		*/
		function didTap() {
		    //Enure we dont return 0 or null for false values
			return !!(validateTap() && hasTap());
		}
		
		
		/**
		 * Returns true if we are detecting double taps and have one
		 * @return Boolean
		 * @inner
		*/
		function didDoubleTap() {
		    //Enure we dont return 0 or null for false values
			return !!(validateDoubleTap() && hasDoubleTap());
		}
		
		/**
		 * Returns true if we are detecting long taps and have one
		 * @return Boolean
		 * @inner
		*/
		function didLongTap() {
		    //Enure we dont return 0 or null for false values
			return !!(validateLongTap() && hasLongTap());
		}
		
		
		
		
		// MULTI FINGER TOUCH
		/**
		 * Starts tracking the time between 2 finger releases, and keeps track of how many fingers we initially had up
		 * @inner
		*/
		function startMultiFingerRelease() {
			previousTouchEndTime = getTimeStamp();
			previousTouchFingerCount = event.touches.length+1;
		}
		
		/**
		 * Cancels the tracking of time between 2 finger releases, and resets counters
		 * @inner
		*/
		function cancelMultiFingerRelease() {
			previousTouchEndTime = 0;
			previousTouchFingerCount = 0;
		}
		
		/**
		 * Checks if we are in the threshold between 2 fingers being released 
		 * @return Boolean
		 * @inner
		*/
		function inMultiFingerRelease() {
			
			var withinThreshold = false;
			
			if(previousTouchEndTime) {	
				var diff = getTimeStamp() - previousTouchEndTime	
				if( diff<=options.fingerReleaseThreshold ) {
					withinThreshold = true;
				}
			}
			
			return withinThreshold;	
		}
		

		/**
		* gets a data flag to indicate that a touch is in progress
		* @return Boolean
		* @inner
		*/
		function getTouchInProgress() {
			//strict equality to ensure only true and false are returned
			return !!($element.data(PLUGIN_NS+'_intouch') === true);
		}
		
		/**
		* Sets a data flag to indicate that a touch is in progress
		* @param {boolean} val The value to set the property to
		* @inner
		*/
		function setTouchInProgress(val) {
			
			//Add or remove event listeners depending on touch status
			if(val===true) {
				$element.bind(MOVE_EV, touchMove);
				$element.bind(END_EV, touchEnd);
				
				//we only have leave events on desktop, we manually calcuate leave on touch as its not supported in webkit
				if(LEAVE_EV) { 
					$element.bind(LEAVE_EV, touchLeave);
				}
			} else {
				$element.unbind(MOVE_EV, touchMove, false);
				$element.unbind(END_EV, touchEnd, false);
			
				//we only have leave events on desktop, we manually calcuate leave on touch as its not supported in webkit
				if(LEAVE_EV) { 
					$element.unbind(LEAVE_EV, touchLeave, false);
				}
			}
			
		
			//strict equality to ensure only true and false can update the value
			$element.data(PLUGIN_NS+'_intouch', val === true);
		}
		
		
		/**
		 * Creates the finger data for the touch/finger in the event object.
		 * @param {int} index The index in the array to store the finger data (usually the order the fingers were pressed)
		 * @param {object} evt The event object containing finger data
		 * @return finger data object
		 * @inner
		*/
		function createFingerData( index, evt ) {
			var id = evt.identifier!==undefined ? evt.identifier : 0; 
			
			fingerData[index].identifier = id;
			fingerData[index].start.x = fingerData[index].end.x = evt.pageX||evt.clientX;
			fingerData[index].start.y = fingerData[index].end.y = evt.pageY||evt.clientY;
			
			return fingerData[index];
		}
		
		/**
		 * Updates the finger data for a particular event object
		 * @param {object} evt The event object containing the touch/finger data to upadte
		 * @return a finger data object.
		 * @inner
		*/
		function updateFingerData(evt) {
			
			var id = evt.identifier!==undefined ? evt.identifier : 0; 
			var f = getFingerData( id );
			
			f.end.x = evt.pageX||evt.clientX;
			f.end.y = evt.pageY||evt.clientY;
			
			return f;
		}
		
		/**
		 * Returns a finger data object by its event ID.
		 * Each touch event has an identifier property, which is used 
		 * to track repeat touches
		 * @param {int} id The unique id of the finger in the sequence of touch events.
		 * @return a finger data object.
		 * @inner
		*/
		function getFingerData( id ) {
			for(var i=0; i<fingerData.length; i++) {
				if(fingerData[i].identifier == id) {
					return fingerData[i];	
				}
			}
		}
		
		/**
		 * Creats all the finger onjects and returns an array of finger data
		 * @return Array of finger objects
		 * @inner
		*/
		function createAllFingerData() {
			var fingerData=[];
			for (var i=0; i<=5; i++) {
				fingerData.push({
					start:{ x: 0, y: 0 },
					end:{ x: 0, y: 0 },
					identifier:0
				});
			}
			
			return fingerData;
		}
		
		/**
		 * Sets the maximum distance swiped in the given direction. 
		 * If the new value is lower than the current value, the max value is not changed.
		 * @param {string}  direction The direction of the swipe
		 * @param {int}  distance The distance of the swipe
		 * @inner
		*/
		function setMaxDistance(direction, distance) {
    		distance = Math.max(distance, getMaxDistance(direction) );
    		maximumsMap[direction].distance = distance;
		}
        
        /**
		 * gets the maximum distance swiped in the given direction. 
		 * @param {string}  direction The direction of the swipe
		 * @return int  The distance of the swipe
		 * @inner
		*/        
		function getMaxDistance(direction) {
			if (maximumsMap[direction]) return maximumsMap[direction].distance;
			return undefined;
		}
		
		/**
		 * Creats a map of directions to maximum swiped values.
		 * @return Object A dictionary of maximum values, indexed by direction.
		 * @inner
		*/
		function createMaximumsData() {
			var maxData={};
			maxData[LEFT]=createMaximumVO(LEFT);
			maxData[RIGHT]=createMaximumVO(RIGHT);
			maxData[UP]=createMaximumVO(UP);
			maxData[DOWN]=createMaximumVO(DOWN);
			
			return maxData;
		}
		
		/**
		 * Creates a map maximum swiped values for a given swipe direction
		 * @param {string} The direction that these values will be associated with
		 * @return Object Maximum values
		 * @inner
		*/
		function createMaximumVO(dir) {
		    return { 
		        direction:dir, 
		        distance:0
		    }
		}
		
		
		//
		// MATHS / UTILS
		//

		/**
		* Calculate the duration of the swipe
		* @return int
		* @inner
		*/
		function calculateDuration() {
			return endTime - startTime;
		}
		
		/**
		* Calculate the distance between 2 touches (pinch)
		* @param {point} startPoint A point object containing x and y co-ordinates
	    * @param {point} endPoint A point object containing x and y co-ordinates
	    * @return int;
		* @inner
		*/
		function calculateTouchesDistance(startPoint, endPoint) {
			var diffX = Math.abs(startPoint.x - endPoint.x);
			var diffY = Math.abs(startPoint.y - endPoint.y);
				
			return Math.round(Math.sqrt(diffX*diffX+diffY*diffY));
		}
		
		/**
		* Calculate the zoom factor between the start and end distances
		* @param {int} startDistance Distance (between 2 fingers) the user started pinching at
	    * @param {int} endDistance Distance (between 2 fingers) the user ended pinching at
	    * @return float The zoom value from 0 to 1.
		* @inner
		*/
		function calculatePinchZoom(startDistance, endDistance) {
			var percent = (endDistance/startDistance) * 1;
			return percent.toFixed(2);
		}
		
		
		/**
		* Returns the pinch direction, either IN or OUT for the given points
		* @return string Either {@link $.fn.swipe.directions.IN} or {@link $.fn.swipe.directions.OUT}
		* @see $.fn.swipe.directions
		* @inner
		*/
		function calculatePinchDirection() {
			if(pinchZoom<1) {
				return OUT;
			}
			else {
				return IN;
			}
		}
		
		
		/**
		* Calculate the length / distance of the swipe
		* @param {point} startPoint A point object containing x and y co-ordinates
	    * @param {point} endPoint A point object containing x and y co-ordinates
	    * @return int
		* @inner
		*/
		function calculateDistance(startPoint, endPoint) {
			return Math.round(Math.sqrt(Math.pow(endPoint.x - startPoint.x, 2) + Math.pow(endPoint.y - startPoint.y, 2)));
		}

		/**
		* Calculate the angle of the swipe
		* @param {point} startPoint A point object containing x and y co-ordinates
	    * @param {point} endPoint A point object containing x and y co-ordinates
	    * @return int
		* @inner
		*/
		function calculateAngle(startPoint, endPoint) {
			var x = startPoint.x - endPoint.x;
			var y = endPoint.y - startPoint.y;
			var r = Math.atan2(y, x); //radians
			var angle = Math.round(r * 180 / Math.PI); //degrees

			//ensure value is positive
			if (angle < 0) {
				angle = 360 - Math.abs(angle);
			}

			return angle;
		}

		/**
		* Calculate the direction of the swipe
		* This will also call calculateAngle to get the latest angle of swipe
		* @param {point} startPoint A point object containing x and y co-ordinates
	    * @param {point} endPoint A point object containing x and y co-ordinates
	    * @return string Either {@link $.fn.swipe.directions.LEFT} / {@link $.fn.swipe.directions.RIGHT} / {@link $.fn.swipe.directions.DOWN} / {@link $.fn.swipe.directions.UP}
		* @see $.fn.swipe.directions
		* @inner
		*/
		function calculateDirection(startPoint, endPoint ) {
			var angle = calculateAngle(startPoint, endPoint);

			if ((angle <= 45) && (angle >= 0)) {
				return LEFT;
			} else if ((angle <= 360) && (angle >= 315)) {
				return LEFT;
			} else if ((angle >= 135) && (angle <= 225)) {
				return RIGHT;
			} else if ((angle > 45) && (angle < 135)) {
				return DOWN;
			} else {
				return UP;
			}
		}
		

		/**
		* Returns a MS time stamp of the current time
		* @return int
		* @inner
		*/
		function getTimeStamp() {
			var now = new Date();
			return now.getTime();
		}
		
		
		
		/**
		 * Returns a bounds object with left, right, top and bottom properties for the element specified.
		 * @param {DomNode} The DOM node to get the bounds for.
		 */
		function getbounds( el ) {
			el = $(el);
			var offset = el.offset();
			
			var bounds = {	
					left:offset.left,
					right:offset.left+el.outerWidth(),
					top:offset.top,
					bottom:offset.top+el.outerHeight()
					}
			
			return bounds;	
		}
		
		
		/**
		 * Checks if the point object is in the bounds object.
		 * @param {object} point A point object.
		 * @param {int} point.x The x value of the point.
		 * @param {int} point.y The x value of the point.
		 * @param {object} bounds The bounds object to test
		 * @param {int} bounds.left The leftmost value
		 * @param {int} bounds.right The righttmost value
		 * @param {int} bounds.top The topmost value
		* @param {int} bounds.bottom The bottommost value
		 */
		function isInBounds(point, bounds) {
			return (point.x > bounds.left && point.x < bounds.right && point.y > bounds.top && point.y < bounds.bottom);
		};
	
	
	}
	
	


/**
 * A catch all handler that is triggered for all swipe directions. 
 * @name $.fn.swipe#swipe
 * @event
 * @default null
 * @param {EventObject} event The original event object
 * @param {int} direction The direction the user swiped in. See {@link $.fn.swipe.directions}
 * @param {int} distance The distance the user swiped
 * @param {int} duration The duration of the swipe in milliseconds
 * @param {int} fingerCount The number of fingers used. See {@link $.fn.swipe.fingers}
 */
 



/**
 * A handler that is triggered for "left" swipes.
 * @name $.fn.swipe#swipeLeft
 * @event
 * @default null
 * @param {EventObject} event The original event object
 * @param {int} direction The direction the user swiped in. See {@link $.fn.swipe.directions}
 * @param {int} distance The distance the user swiped
 * @param {int} duration The duration of the swipe in milliseconds
 * @param {int} fingerCount The number of fingers used. See {@link $.fn.swipe.fingers}
 */
 
/**
 * A handler that is triggered for "right" swipes.
 * @name $.fn.swipe#swipeRight
 * @event
 * @default null
 * @param {EventObject} event The original event object
 * @param {int} direction The direction the user swiped in. See {@link $.fn.swipe.directions}
 * @param {int} distance The distance the user swiped
 * @param {int} duration The duration of the swipe in milliseconds
 * @param {int} fingerCount The number of fingers used. See {@link $.fn.swipe.fingers}
 */

/**
 * A handler that is triggered for "up" swipes.
 * @name $.fn.swipe#swipeUp
 * @event
 * @default null
 * @param {EventObject} event The original event object
 * @param {int} direction The direction the user swiped in. See {@link $.fn.swipe.directions}
 * @param {int} distance The distance the user swiped
 * @param {int} duration The duration of the swipe in milliseconds
 * @param {int} fingerCount The number of fingers used. See {@link $.fn.swipe.fingers}
 */
 
/**
 * A handler that is triggered for "down" swipes.
 * @name $.fn.swipe#swipeDown
 * @event
 * @default null
 * @param {EventObject} event The original event object
 * @param {int} direction The direction the user swiped in. See {@link $.fn.swipe.directions}
 * @param {int} distance The distance the user swiped
 * @param {int} duration The duration of the swipe in milliseconds
 * @param {int} fingerCount The number of fingers used. See {@link $.fn.swipe.fingers}
 */
 
/**
 * A handler triggered for every phase of the swipe. This handler is constantly fired for the duration of the pinch.
 * This is triggered regardless of swipe thresholds.
 * @name $.fn.swipe#swipeStatus
 * @event
 * @default null
 * @param {EventObject} event The original event object
 * @param {string} phase The phase of the swipe event. See {@link $.fn.swipe.phases}
 * @param {string} direction The direction the user swiped in. This is null if the user has yet to move. See {@link $.fn.swipe.directions}
 * @param {int} distance The distance the user swiped. This is 0 if the user has yet to move.
 * @param {int} duration The duration of the swipe in milliseconds
 * @param {int} fingerCount The number of fingers used. See {@link $.fn.swipe.fingers}
 */
 
/**
 * A handler triggered for pinch in events.
 * @name $.fn.swipe#pinchIn
 * @event
 * @default null
 * @param {EventObject} event The original event object
 * @param {int} direction The direction the user pinched in. See {@link $.fn.swipe.directions}
 * @param {int} distance The distance the user pinched
 * @param {int} duration The duration of the swipe in milliseconds
 * @param {int} fingerCount The number of fingers used. See {@link $.fn.swipe.fingers}
 * @param {int} zoom The zoom/scale level the user pinched too, 0-1.
 */

/**
 * A handler triggered for pinch out events.
 * @name $.fn.swipe#pinchOut
 * @event
 * @default null
 * @param {EventObject} event The original event object
 * @param {int} direction The direction the user pinched in. See {@link $.fn.swipe.directions}
 * @param {int} distance The distance the user pinched
 * @param {int} duration The duration of the swipe in milliseconds
 * @param {int} fingerCount The number of fingers used. See {@link $.fn.swipe.fingers}
 * @param {int} zoom The zoom/scale level the user pinched too, 0-1.
 */ 

/**
 * A handler triggered for all pinch events. This handler is constantly fired for the duration of the pinch. This is triggered regardless of thresholds.
 * @name $.fn.swipe#pinchStatus
 * @event
 * @default null
 * @param {EventObject} event The original event object
 * @param {int} direction The direction the user pinched in. See {@link $.fn.swipe.directions}
 * @param {int} distance The distance the user pinched
 * @param {int} duration The duration of the swipe in milliseconds
 * @param {int} fingerCount The number of fingers used. See {@link $.fn.swipe.fingers}
 * @param {int} zoom The zoom/scale level the user pinched too, 0-1.
 */

/**
 * A click handler triggered when a user simply clicks, rather than swipes on an element.
 * This is deprecated since version 1.6.2, any assignment to click will be assigned to the tap handler.
 * You cannot use <code>on</code> to bind to this event as the default jQ <code>click</code> event will be triggered.
 * Use the <code>tap</code> event instead.
 * @name $.fn.swipe#click
 * @event
 * @deprecated since version 1.6.2, please use {@link $.fn.swipe#tap} instead 
 * @default null
 * @param {EventObject} event The original event object
 * @param {DomObject} target The element clicked on.
 */
 
 /**
 * A click / tap handler triggered when a user simply clicks or taps, rather than swipes on an element.
 * @name $.fn.swipe#tap
 * @event
 * @default null
 * @param {EventObject} event The original event object
 * @param {DomObject} target The element clicked on.
 */
 
/**
 * A double tap handler triggered when a user double clicks or taps on an element.
 * You can set the time delay for a double tap with the {@link $.fn.swipe.defaults#doubleTapThreshold} property. 
 * Note: If you set both <code>doubleTap</code> and <code>tap</code> handlers, the <code>tap</code> event will be delayed by the <code>doubleTapThreshold</code>
 * as the script needs to check if its a double tap.
 * @name $.fn.swipe#doubleTap
 * @see  $.fn.swipe.defaults#doubleTapThreshold
 * @event
 * @default null
 * @param {EventObject} event The original event object
 * @param {DomObject} target The element clicked on.
 */
 
 /**
 * A long tap handler triggered when a user long clicks or taps on an element.
 * You can set the time delay for a long tap with the {@link $.fn.swipe.defaults#longTapThreshold} property. 
 * @name $.fn.swipe#longTap
 * @see  $.fn.swipe.defaults#longTapThreshold
 * @event
 * @default null
 * @param {EventObject} event The original event object
 * @param {DomObject} target The element clicked on.
 */

}));
/* ============================================================
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Open source under the BSD License.
 *
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 * https://raw.github.com/danro/jquery-easing/master/LICENSE
 * ======================================================== */
 
(function (jQuery) {

jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend(jQuery.easing, {
    easeInQuad: function(x, t, b, c, d) {
        return c * (t /= d) * t + b;
    },
    easeOutQuad: function(x, t, b, c, d) {
        return -c * (t /= d) * (t - 2) + b;
    },
    easeInOutQuad: function(x, t, b, c, d) {
        if ((t /= d / 2) < 1)
            return c / 2 * t * t + b;
        return -c / 2 * ((--t) * (t - 2) - 1) + b;
    },
    easeInCubic: function(x, t, b, c, d) {
        return c * (t /= d) * t * t + b;
    },
    easeOutCubic: function(x, t, b, c, d) {
        return c * ((t = t / d - 1) * t * t + 1) + b;
    },
    easeInOutCubic: function(x, t, b, c, d) {
        if ((t /= d / 2) < 1)
            return c / 2 * t * t * t + b;
        return c / 2 * ((t -= 2) * t * t + 2) + b;
    },
    easeInQuart: function(x, t, b, c, d) {
        return c * (t /= d) * t * t * t + b;
    },
    easeOutQuart: function(x, t, b, c, d) {
        return -c * ((t = t / d - 1) * t * t * t - 1) + b;
    },
    easeInOutQuart: function(x, t, b, c, d) {
        if ((t /= d / 2) < 1)
            return c / 2 * t * t * t * t + b;
        return -c / 2 * ((t -= 2) * t * t * t - 2) + b;
    },
    easeInQuint: function(x, t, b, c, d) {
        return c * (t /= d) * t * t * t * t + b;
    },
    easeOutQuint: function(x, t, b, c, d) {
        return c * ((t = t / d - 1) * t * t * t * t + 1) + b;
    },
    easeInOutQuint: function(x, t, b, c, d) {
        if ((t /= d / 2) < 1)
            return c / 2 * t * t * t * t * t + b;
        return c / 2 * ((t -= 2) * t * t * t * t + 2) + b;
    },
    easeInSine: function(x, t, b, c, d) {
        return -c * Math.cos(t / d * (Math.PI / 2)) + c + b;
    },
    easeOutSine: function(x, t, b, c, d) {
        return c * Math.sin(t / d * (Math.PI / 2)) + b;
    },
    easeInOutSine: function(x, t, b, c, d) {
        return -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b;
    },
    easeInExpo: function(x, t, b, c, d) {
        return (t == 0) ? b : c * Math.pow(2, 10 * (t / d - 1)) + b;
    },
    easeOutExpo: function(x, t, b, c, d) {
        return (t == d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b;
    },
    easeInOutExpo: function(x, t, b, c, d) {
        if (t == 0)
            return b;
        if (t == d)
            return b + c;
        if ((t /= d / 2) < 1)
            return c / 2 * Math.pow(2, 10 * (t - 1)) + b;
        return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b;
    },
    easeInCirc: function(x, t, b, c, d) {
        return -c * (Math.sqrt(1 - (t /= d) * t) - 1) + b;
    },
    easeOutCirc: function(x, t, b, c, d) {
        return c * Math.sqrt(1 - (t = t / d - 1) * t) + b;
    },
    easeInOutCirc: function(x, t, b, c, d) {
        if ((t /= d / 2) < 1)
            return -c / 2 * (Math.sqrt(1 - t * t) - 1) + b;
        return c / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + b;
    },
    easeInElastic: function(x, t, b, c, d) {
        var s = 1.70158;
        var p = 0;
        var a = c;
        if (t == 0)
            return b;
        if ((t /= d) == 1)
            return b + c;
        if (!p)
            p = d * .3;
        if (a < Math.abs(c)) {
            a = c;
            var s = p / 4;
        }
        else
            var s = p / (2 * Math.PI) * Math.asin(c / a);
        return -(a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
    },
    easeOutElastic: function(x, t, b, c, d) {
        var s = 1.70158;
        var p = 0;
        var a = c;
        if (t == 0)
            return b;
        if ((t /= d) == 1)
            return b + c;
        if (!p)
            p = d * .3;
        if (a < Math.abs(c)) {
            a = c;
            var s = p / 4;
        }
        else
            var s = p / (2 * Math.PI) * Math.asin(c / a);
        return a * Math.pow(2, -10 * t) * Math.sin((t * d - s) * (2 * Math.PI) / p) + c + b;
    },
    easeInOutElastic: function(x, t, b, c, d) {
        var s = 1.70158;
        var p = 0;
        var a = c;
        if (t == 0)
            return b;
        if ((t /= d / 2) == 2)
            return b + c;
        if (!p)
            p = d * (.3 * 1.5);
        if (a < Math.abs(c)) {
            a = c;
            var s = p / 4;
        }
        else
            var s = p / (2 * Math.PI) * Math.asin(c / a);
        if (t < 1)
            return -.5 * (a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
        return a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p) * .5 + c + b;
    },
    easeInBack: function(x, t, b, c, d, s) {
        if (s == undefined)
            s = 1.70158;
        return c * (t /= d) * t * ((s + 1) * t - s) + b;
    },
    easeOutBack: function(x, t, b, c, d, s) {
        if (s == undefined)
            s = 1.70158;
        return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b;
    },
    easeInOutBack: function(x, t, b, c, d, s) {
        if (s == undefined)
            s = 1.70158;
        if ((t /= d / 2) < 1)
            return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b;
        return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b;
    },
    easeInBounce: function(x, t, b, c, d) {
        return c - jQuery.easing.easeOutBounce(x, d - t, 0, c, d) + b;
    },
    easeOutBounce: function(x, t, b, c, d) {
        if ((t /= d) < (1 / 2.75)) {
            return c * (7.5625 * t * t) + b;
        } else if (t < (2 / 2.75)) {
            return c * (7.5625 * (t -= (1.5 / 2.75)) * t + .75) + b;
        } else if (t < (2.5 / 2.75)) {
            return c * (7.5625 * (t -= (2.25 / 2.75)) * t + .9375) + b;
        } else {
            return c * (7.5625 * (t -= (2.625 / 2.75)) * t + .984375) + b;
        }
    },
    easeInOutBounce: function(x, t, b, c, d) {
        if (t < d / 2)
            return jQuery.easing.easeInBounce(x, t * 2, 0, c, d) * .5 + b;
        return jQuery.easing.easeOutBounce(x, t * 2 - d, 0, c, d) * .5 + c * .5 + b;
    }
});

jQuery.csseasing = jQuery();
jQuery.extend(jQuery.csseasing, {
    linear: function() {
        return 'linear';
    },
    easeInQuad: function() {
        return 'cubic-bezier(0.550, 0.085, 0.680, 0.530)';
    },
    easeOutQuad: function() {
        return 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
    },
    easeInOutQuad: function() {
        return 'cubic-bezier(0.455, 0.030, 0.515, 0.955)';
    },
    easeInCubic: function() {
        return 'cubic-bezier(0.550, 0.055, 0.675, 0.190)';
    },
    easeOutCubic: function() {
        return 'cubic-bezier(0.215, 0.610, 0.355, 1.000)';
    },
    easeInOutCubic: function() {
        return 'cubic-bezier(0.645, 0.045, 0.355, 1.000)';
    },
    easeInQuart: function() {
        return 'cubic-bezier(0.895, 0.030, 0.685, 0.220)';
    },
    easeOutQuart: function() {
        return 'cubic-bezier(0.165, 0.840, 0.440, 1.000)';
    },
    easeInOutQuart: function() {
        return 'cubic-bezier(0.770, 0.000, 0.175, 1.000)';
    },
    easeInQuint: function() {
        return 'cubic-bezier(0.755, 0.050, 0.855, 0.060)';
    },
    easeOutQuint: function() {
        return 'cubic-bezier(0.230, 1.000, 0.320, 1.000)';
    },
    easeInOutQuint: function() {
        return 'cubic-bezier(0.860, 0.000, 0.070, 1.000)';
    },
    easeInSine: function() {
        return 'cubic-bezier(0.470, 0.000, 0.745, 0.715)';
    },
    easeOutSine: function() {
        return 'cubic-bezier(0.390, 0.575, 0.565, 1.000)';
    },
    easeInOutSine: function() {
        return 'cubic-bezier(0.445, 0.050, 0.550, 0.950)';
    },
    easeInExpo: function() {
        return 'cubic-bezier(0.950, 0.050, 0.795, 0.035)';
    },
    easeOutExpo: function() {
        return 'cubic-bezier(0.190, 1.000, 0.220, 1.000)';
    },
    easeInOutExpo: function() {
        return 'cubic-bezier(1.000, 0.000, 0.000, 1.000)';
    },
    easeInCirc: function() {
        return 'cubic-bezier(0.600, 0.040, 0.980, 0.335)';
    },
    easeOutCirc: function() {
        return 'cubic-bezier(0.075, 0.820, 0.165, 1.000)';
    },
    easeInOutCirc: function() {
        return 'cubic-bezier(0.785, 0.135, 0.150, 0.860)';
    },
    easeInElastic: function() {
        return 'ease-in';
    },
    easeOutElastic: function() {
        return 'ease-out';
    },
    easeInOutElastic: function() {
        return 'ease-in-out';
    },
    easeInBack: function() {
        return 'cubic-bezier(0.600, -0.280, 0.735, 0.045)';
    },
    easeOutBack: function() {
        return 'cubic-bezier(0.175, 0.885, 0.320, 1.275)';
    },
    easeInOutBack: function() {
        return 'cubic-bezier(0.680, -0.550, 0.265, 1.550)';
    },
    easeInBounce: function() {
        return 'ease-in';
    },
    easeOutBounce: function() {
        return 'ease-out';
    },
    easeInOutBounce: function() {
        return 'ease-in-out';
    }
});

})(njQuery);/*!
 * jQuery Transit - CSS3 transitions and transformations
 * (c) 2011-2012 Rico Sta. Cruz <rico@ricostacruz.com>
 * MIT Licensed.
 *
 * http://ricostacruz.com/jquery.transit
 * http://github.com/rstacruz/jquery.transit
 */

(function ($) {
    $.ntransit = {
        version: "0.9.9",

        // Map of $.css() keys to values for 'transitionProperty'.
        // See https://developer.mozilla.org/en/CSS/CSS_transitions#Properties_that_can_be_animated
        propertyMap: {
            marginLeft: 'margin',
            marginRight: 'margin',
            marginBottom: 'margin',
            marginTop: 'margin',
            paddingLeft: 'padding',
            paddingRight: 'padding',
            paddingBottom: 'padding',
            paddingTop: 'padding'
        },

        // Will simply transition "instantly" if false
        enabled: true,

        // Set this to false if you don't want to use the transition end property.
        useTransitionEnd: false
    };

    var div = document.createElement('div');
    var support = {};

    // Helper function to get the proper vendor property name.
    // (`transition` => `WebkitTransition`)
    function getVendorPropertyName(prop) {
        // Handle unprefixed versions (FF16+, for example)
        if (prop in div.style) return prop;

        var prefixes = ['Moz', 'Webkit', 'O', 'ms'];
        var prop_ = prop.charAt(0).toUpperCase() + prop.substr(1);

        if (prop in div.style) {
            return prop;
        }

        for (var i = 0; i < prefixes.length; ++i) {
            var vendorProp = prefixes[i] + prop_;
            if (vendorProp in div.style) {
                return vendorProp;
            }
        }
    }

    // Helper function to check if transform3D is supported.
    // Should return true for Webkits and Firefox 10+.
    function checkTransform3dSupport() {
        div.style[support.transform] = '';
        div.style[support.transform] = 'rotateY(90deg)';
        return div.style[support.transform] !== '';
    }

    var isChrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;

    // Check for the browser's transitions support.
    support.transition = getVendorPropertyName('transition');
    support.transitionDelay = getVendorPropertyName('transitionDelay');
    support.transitionProperty = getVendorPropertyName('transitionProperty');
    support.transform = getVendorPropertyName('transform');
    support.transformOrigin = getVendorPropertyName('transformOrigin');
    support.transform3d = checkTransform3dSupport();

    // Non-working transitionend event names are gonna get spliced out on the first event
    var eventNames = [
        'transitionend',
        'webkitTransitionEnd',
        'otransitionend',
        'oTransitionEnd'
    ];
    var transitionEnd = support.transitionEnd = eventNames[support.transition] || null;

    // Populate jQuery's `$.support` with the vendor prefixes we know.
    // As per [jQuery's cssHooks documentation](http://api.jquery.com/jQuery.cssHooks/),
    // we set $.support.transition to a string of the actual property name used.
    for (var key in support) {
        if (support.hasOwnProperty(key) && typeof $.support[key] === 'undefined') {
            $.support[key] = support[key];
        }
    }

    // Avoid memory leak in IE.
    div = null;

    // ## $.cssEase
    // List of easing aliases that you can use with `$.fn.transition`.
    $.cssEase = {
        '_default': 'ease',
        'in': 'ease-in',
        'out': 'ease-out',
        'in-out': 'ease-in-out',
        'snap': 'cubic-bezier(0,1,.5,1)',
        // Penner equations
        'easeOutCubic': 'cubic-bezier(.215,.61,.355,1)',
        'easeInOutCubic': 'cubic-bezier(.645,.045,.355,1)',
        'easeInCirc': 'cubic-bezier(.6,.04,.98,.335)',
        'easeOutCirc': 'cubic-bezier(.075,.82,.165,1)',
        'easeInOutCirc': 'cubic-bezier(.785,.135,.15,.86)',
        'easeInExpo': 'cubic-bezier(.95,.05,.795,.035)',
        'easeOutExpo': 'cubic-bezier(.19,1,.22,1)',
        'easeInOutExpo': 'cubic-bezier(1,0,0,1)',
        'easeInQuad': 'cubic-bezier(.55,.085,.68,.53)',
        'easeOutQuad': 'cubic-bezier(.25,.46,.45,.94)',
        'easeInOutQuad': 'cubic-bezier(.455,.03,.515,.955)',
        'easeInQuart': 'cubic-bezier(.895,.03,.685,.22)',
        'easeOutQuart': 'cubic-bezier(.165,.84,.44,1)',
        'easeInOutQuart': 'cubic-bezier(.77,0,.175,1)',
        'easeInQuint': 'cubic-bezier(.755,.05,.855,.06)',
        'easeOutQuint': 'cubic-bezier(.23,1,.32,1)',
        'easeInOutQuint': 'cubic-bezier(.86,0,.07,1)',
        'easeInSine': 'cubic-bezier(.47,0,.745,.715)',
        'easeOutSine': 'cubic-bezier(.39,.575,.565,1)',
        'easeInOutSine': 'cubic-bezier(.445,.05,.55,.95)',
        'easeInBack': 'cubic-bezier(.6,-.28,.735,.045)',
        'easeOutBack': 'cubic-bezier(.175, .885,.32,1.275)',
        'easeInOutBack': 'cubic-bezier(.68,-.55,.265,1.55)'
    };

    // ## 'transform' CSS hook
    // Allows you to use the `transform` property in CSS.
    //
    //     $("#hello").css({ transform: "rotate(90deg)" });
    //
    //     $("#hello").css('transform');
    //     //=> { rotate: '90deg' }
    //
    $.cssHooks['ntransit:transform'] = {
        // The getter returns a `Transform` object.
        get: function (elem) {
            return $(elem).data('transform') || new Transform();
        },

        // The setter accepts a `Transform` object or a string.
        set: function (elem, v) {
            var value = v;

            if (!(value instanceof Transform)) {
                value = new Transform(value);
            }

            // We've seen the 3D version of Scale() not work in Chrome when the
            // element being scaled extends outside of the viewport.  Thus, we're
            // forcing Chrome to not use the 3d transforms as well.  Not sure if
            // translate is affectede, but not risking it.  Detection code from
            // http://davidwalsh.name/detecting-google-chrome-javascript
            if (support.transform === 'WebkitTransform' && !isChrome) {
                elem.style[support.transform] = value.toString(true);
            } else {
                elem.style[support.transform] = value.toString();
            }

            $(elem).data('transform', value);
        }
    };

    // Add a CSS hook for `.css({ transform: '...' })`.
    // In jQuery 1.8+, this will intentionally override the default `transform`
    // CSS hook so it'll play well with Transit. (see issue #62)
    $.cssHooks.transform = {
        set: $.cssHooks['ntransit:transform'].set
    };

    // jQuery 1.8+ supports prefix-free transitions, so these polyfills will not
    // be necessary.
    if ($.fn.jquery < "1.8") {
        // ## 'transformOrigin' CSS hook
        // Allows the use for `transformOrigin` to define where scaling and rotation
        // is pivoted.
        //
        //     $("#hello").css({ transformOrigin: '0 0' });
        //
        $.cssHooks.transformOrigin = {
            get: function (elem) {
                return elem.style[support.transformOrigin];
            },
            set: function (elem, value) {
                elem.style[support.transformOrigin] = value;
            }
        };

        // ## 'transition' CSS hook
        // Allows you to use the `transition` property in CSS.
        //
        //     $("#hello").css({ transition: 'all 0 ease 0' });
        //
        $.cssHooks.transition = {
            get: function (elem) {
                return elem.style[support.transition];
            },
            set: function (elem, value) {
                elem.style[support.transition] = value;
            }
        };
    }

    // ## Other CSS hooks
    // Allows you to rotate, scale and translate.
    registerCssHook('scale');
    registerCssHook('translate');
    registerCssHook('translate3d');
    registerCssHook('rotate');
    registerCssHook('rotateX');
    registerCssHook('rotateY');
    registerCssHook('rotateZ');
    registerCssHook('rotate3d');
    registerCssHook('perspective');
    registerCssHook('skewX');
    registerCssHook('skewY');
    registerCssHook('x', true);
    registerCssHook('y', true);
    registerCssHook('z', true);

    // ## Transform class
    // This is the main class of a transformation property that powers
    // `$.fn.css({ transform: '...' })`.
    //
    // This is, in essence, a dictionary object with key/values as `-transform`
    // properties.
    //
    //     var t = new Transform("rotate(90) scale(4)");
    //
    //     t.rotate             //=> "90deg"
    //     t.scale              //=> "4,4"
    //
    // Setters are accounted for.
    //
    //     t.set('rotate', 4)
    //     t.rotate             //=> "4deg"
    //
    // Convert it to a CSS string using the `toString()` and `toString(true)` (for WebKit)
    // functions.
    //
    //     t.toString()         //=> "rotate(90deg) scale(4,4)"
    //     t.toString(true)     //=> "rotate(90deg) scale3d(4,4,0)" (WebKit version)
    //
    function Transform(str) {
        if (typeof str === 'string') {
            this.parse(str);
        }
        return this;
    }

    Transform.prototype = {
        // ### setFromString()
        // Sets a property from a string.
        //
        //     t.setFromString('scale', '2,4');
        //     // Same as set('scale', '2', '4');
        //
        setFromString: function (prop, val) {
            var args =
                (typeof val === 'string') ? val.split(',') :
                    (val.constructor === Array) ? val :
                        [ val ];

            args.unshift(prop);

            Transform.prototype.set.apply(this, args);
        },

        // ### set()
        // Sets a property.
        //
        //     t.set('scale', 2, 4);
        //
        set: function (prop) {
            var args = Array.prototype.slice.apply(arguments, [1]);
            if (this.setter[prop]) {
                this.setter[prop].apply(this, args);
            } else {
                this[prop] = args.join(',');
            }
        },

        get: function (prop) {
            if (this.getter[prop]) {
                return this.getter[prop].apply(this);
            } else {
                return this[prop] || 0;
            }
        },

        setter: {
            // ### rotate
            //
            //     .css({ rotate: 30 })
            //     .css({ rotate: "30" })
            //     .css({ rotate: "30deg" })
            //     .css({ rotate: "30deg" })
            //
            rotate: function (theta) {
                this.rotate = unit(theta, 'deg');
            },

            rotateX: function (theta) {
                this.rotateX = unit(theta, 'deg');
            },

            rotateY: function (theta) {
                this.rotateY = unit(theta, 'deg');
            },

            rotateZ: function (theta) {
                this.rotateZ = unit(theta, 'deg');
            },

            // ### scale
            //
            //     .css({ scale: 9 })      //=> "scale(9,9)"
            //     .css({ scale: '3,2' })  //=> "scale(3,2)"
            //
            scale: function (x, y) {
                if (y === undefined) {
                    y = x;
                }
                this.scale = x + "," + y;
            },

            // ### skewX + skewY
            skewX: function (x) {
                this.skewX = unit(x, 'deg');
            },

            skewY: function (y) {
                this.skewY = unit(y, 'deg');
            },

            // ### perspectvie
            perspective: function (dist) {
                this.perspective = unit(dist, 'px');
            },

            // ### x / y / z
            // Translations. Notice how this keeps the other value.
            //
            //     .css({ x: 4 })       //=> "translate(4px, 0)"
            //     .css({ y: 10 })      //=> "translate(4px, 10px)"
            //
            x: function (x) {
                this.set('translate', x, null, null);
            },

            y: function (y) {
                this.set('translate', null, y, null);
            },
            
            z: function(z) {
                this.set('translate3d', null, null, z); 
            },

            // ### translate
            // Notice how this keeps the other value.
            //
            //     .css({ translate: '2, 5' })    //=> "translate(2px, 5px)"
            //
            translate: function (x, y) {
                this.set('translate3d', x, y, 0);
            },
        
            translate3d: function(x, y, z) {
                if (this._translateX === undefined) { this._translateX = 0; }
                if (this._translateY === undefined) { this._translateY = 0; }
                if (this._translateZ === undefined) { this._translateZ = 0; }
    
                if (x !== null && x !== undefined) { this._translateX = unit(x, 'px'); }
                if (y !== null && y !== undefined) { this._translateY = unit(y, 'px'); }
                if (z !== null && z !== undefined) { this._translateZ = unit(z, 'px'); } 
                this.translate3d = this._translateX + "," + this._translateY + "," + this._translateZ;
            }
        },

        getter: {
            x: function () {
                return this._translateX || 0;
            },

            y: function () {
                return this._translateY || 0;
            },

            z: function () {
                return this._translateZ || 0;
            },

            scale: function () {
                var s = (this.scale || "1,1").split(',');
                if (s[0]) {
                    s[0] = parseFloat(s[0]);
                }
                if (s[1]) {
                    s[1] = parseFloat(s[1]);
                }

                // "2.5,2.5" => 2.5
                // "2.5,1" => [2.5,1]
                return (s[0] === s[1]) ? s[0] : s;
            },

            rotate3d: function () {
                var s = (this.rotate3d || "0,0,0,0deg").split(',');
                for (var i = 0; i <= 3; ++i) {
                    if (s[i]) {
                        s[i] = parseFloat(s[i]);
                    }
                }
                if (s[3]) {
                    s[3] = unit(s[3], 'deg');
                }

                return s;
            }
        },

        // ### parse()
        // Parses from a string. Called on constructor.
        parse: function (str) {
            var self = this;
            str.replace(/([a-zA-Z0-9]+)\((.*?)\)/g, function (x, prop, val) {
                self.setFromString(prop, val);
            });
        },

        // ### toString()
        // Converts to a `transition` CSS property string. If `use3d` is given,
        // it converts to a `-webkit-transition` CSS property string instead.
        toString: function (use3d) {
            var re = [];

            for (var i in this) {
                if (this.hasOwnProperty(i)) {
                    // Don't use 3D transformations if the browser can't support it.
                    if ((!support.transform3d) && (
                        (i === 'rotateX') ||
                            (i === 'rotateY') ||
                            (i === 'rotateZ') ||
                            (i === 'perspective') ||
                            (i === 'transformOrigin'))) {
                        continue;
                    }

                    if (i[0] !== '_') {
                        if (use3d && (i === 'scale')) {
                            re.push(i + "3d(" + this[i] + ",1)");
                        } else if (use3d && (i === 'translate')) {
                            re.push(i + "3d(" + this[i] + ")");
                        } else {
                            re.push(i + "(" + this[i] + ")");
                        }
                    }
                }
            }

            return re.join(" ");
        }
    };

    function callOrQueue(self, queue, fn) {
        if (queue === true) {
            self.queue(fn);
        } else if (queue) {
            self.queue(queue, fn);
        } else {
            fn();
        }
    }

    // ### getProperties(dict)
    // Returns properties (for `transition-property`) for dictionary `props`. The
    // value of `props` is what you would expect in `$.css(...)`.
    function getProperties(props) {
        var re = [];

        $.each(props, function (key) {
            key = $.camelCase(key); // Convert "text-align" => "textAlign"
            key = $.ntransit.propertyMap[key] || $.cssProps[key] || key;
            key = uncamel(key); // Convert back to dasherized

            if ($.inArray(key, re) === -1) {
                re.push(key);
            }
        });

        return re;
    }

    // ### getTransition()
    // Returns the transition string to be used for the `transition` CSS property.
    //
    // Example:
    //
    //     getTransition({ opacity: 1, rotate: 30 }, 500, 'ease');
    //     //=> 'opacity 500ms ease, -webkit-transform 500ms ease'
    //
    function getTransition(properties, duration, easing, delay) {
        // Get the CSS properties needed.
        var props = getProperties(properties);

        // Account for aliases (`in` => `ease-in`).
        if ($.cssEase[easing]) {
            easing = $.cssEase[easing];
        }

        // Build the duration/easing/delay attributes for it.
        var attribs = '' + toMS(duration) + ' ' + easing;
        if (parseInt(delay, 10) > 0) {
            attribs += ' ' + toMS(delay);
        }

        // For more properties, add them this way:
        // "margin 200ms ease, padding 200ms ease, ..."
        var transitions = [];
        $.each(props, function (i, name) {
            transitions.push(name + ' ' + attribs);
        });

        return transitions.join(', ');
    }

    // ## $.fn.transition
    // Works like $.fn.animate(), but uses CSS transitions.
    //
    //     $("...").transition({ opacity: 0.1, scale: 0.3 });
    //
    //     // Specific duration
    //     $("...").transition({ opacity: 0.1, scale: 0.3 }, 500);
    //
    //     // With duration and easing
    //     $("...").transition({ opacity: 0.1, scale: 0.3 }, 500, 'in');
    //
    //     // With callback
    //     $("...").transition({ opacity: 0.1, scale: 0.3 }, function() { ... });
    //
    //     // With everything
    //     $("...").transition({ opacity: 0.1, scale: 0.3 }, 500, 'in', function() { ... });
    //
    //     // Alternate syntax
    //     $("...").transition({
    //       opacity: 0.1,
    //       duration: 200,
    //       delay: 40,
    //       easing: 'in',
    //       complete: function() { /* ... */ }
    //      });
    //
    $.fn.ntransition = $.fn.ntransit = function (properties, duration, easing, callback) {
        var self = this;
        var delay = 0;
        var queue = true;

        var theseProperties = $.extend(true, {}, properties);

        // Account for `.transition(properties, callback)`.
        if (typeof duration === 'function') {
            callback = duration;
            duration = undefined;
        }

        // Account for `.transition(properties, options)`.
        if (typeof duration === 'object') {
            easing = duration.easing;
            delay = duration.delay || 0;
            queue = duration.queue || true;
            callback = duration.complete;
            duration = duration.duration;
        }

        // Account for `.transition(properties, duration, callback)`.
        if (typeof easing === 'function') {
            callback = easing;
            easing = undefined;
        }

        // Alternate syntax.
        if (typeof theseProperties.easing !== 'undefined') {
            easing = theseProperties.easing;
            delete theseProperties.easing;
        }

        if (typeof theseProperties.duration !== 'undefined') {
            duration = theseProperties.duration;
            delete theseProperties.duration;
        }

        if (typeof theseProperties.complete !== 'undefined') {
            callback = theseProperties.complete;
            delete theseProperties.complete;
        }

        if (typeof theseProperties.queue !== 'undefined') {
            queue = theseProperties.queue;
            delete theseProperties.queue;
        }

        if (typeof theseProperties.delay !== 'undefined') {
            delay = theseProperties.delay;
            delete theseProperties.delay;
        }

        // Set defaults. (`400` duration, `ease` easing)
        if (typeof duration === 'undefined') {
            duration = $.fx.speeds._default;
        }
        if (typeof easing === 'undefined') {
            easing = $.cssEase._default;
        }

        duration = toMS(duration);

        // Build the `transition` property.
        var transitionValue = getTransition(theseProperties, duration, easing, delay);

        // Compute delay until callback.
        // If this becomes 0, don't bother setting the transition property.
        //var work = $.transit.enabled && support.transition;
        var i = $.ntransit.enabled ? (parseInt(duration, 10) + parseInt(delay, 10)) : 0;


        if(!support.transition && i > 0){
            var end = self.data('sstransit');
            if(end){
                var s = 0,
                    e = 1;
                if(end == 'onAnimateOutEnd'){
                    s = 1;
                    e = 0;
                }
                theseProperties.opacity = s;
                self.css(theseProperties);     
                var fn = function (next) {     
                    self.stop().animate({opacity: e}, {
                        duration: i,
                        easing: easing,
                        complete: function(){
                            self.data('sstransit', null);      
                            if (callback) {
                                callback.apply(self);
                            }
                        }                 
                    });
                    if (next) {
                        next();
                    }
                };
    
                callOrQueue(self, queue, fn);
                return self;
            }
            i = 0;
        }
        
        // If there's nothing to do...
        if (i === 0) {
            var fn = function (next) {
                self.css(theseProperties);
                if (callback) {
                    callback.apply(self);
                }
                if (next) {
                    next();
                }
            };

            callOrQueue(self, queue, fn);
            return self;
        }

        // Save the old transitions of each element so we can restore it later.
        var run = function (nextCall, element) {
            var bound = false;

            var self = $(element);
            var oldTransitions = {};

            // Prepare the callback.
            var cb = function (event) {
                if (bound) {
                    for (var j = bound.length; j > 0; --j) {
                        self.unbind(bound[j], cb);
                        if ((eventNames.length > 1) && (bound[j] !== event.type) && (eventNames.indexOf(bound[j]) !== -1)) {
                            eventNames.splice(eventNames.indexOf(bound[j]), 1);
                        }
                    }
                }

                if (i > 0) {
                    self.each(function () {
                        this.style[support.transition] = (oldTransitions[this] || null);
                    });
                }

                if (typeof callback === 'function') {
                    callback.apply(self);
                }
                if (typeof nextCall === 'function') {
                    nextCall();
                }
            };

            if ((i > 0) && ($.ntransit.useTransitionEnd)) {
                // Use the 'transitionend' event if it's available.
                bound = eventNames;
                for (var j = 0; j < eventNames.length; ++j) {
                    self.bind(eventNames[j], cb);
                }
            } else {
                // Fallback to timers if the 'transitionend' event isn't supported.
                var id = window.setTimeout(cb, i + 80);
                self.data('transitTimer', id);
            }

            self.data('transitCallback', cb);

            // Apply transitions.
            self.each(function () {
                if (i > 0) {
                    this.style[support.transition] = transitionValue;
                }
                $(this).css(properties);
            });
        };

        // Defer running. This allows the browser to paint any pending CSS it hasn't
        // painted yet before doing the transitions.
        var deferredRun = function (next) {
            this.offsetWidth; // force a repaint
            run(next, this);
        };

        // Use jQuery's fx queue.
        callOrQueue(self, queue, deferredRun);

        // Chainability.
        return this;
    };

    // ## $.fn.transitionStop
    // Works like $.fn.stop( [clearQueue ] [, jumpToEnd ] )
    //     
    $.fn.ntransitionStop = $.fn.ntransitStop = function (clearQueue, jumpToEnd) {
        this.each(function () {
            var self = $(this);

            var id = self.data('transitTimer');
            clearTimeout(id);

            self.data('transitTimer', null);

            var properties = this.style[support.transitionProperty];

            if (properties) {
                properties = properties.replace(/-([a-z])/gi, function(s, group1) {
				    return group1.toUpperCase();
				}).replace(/\s*/g, '').split(',');

                var style = window.getComputedStyle(this),
                    css = {};

                for (var i = 0; i < properties.length; i++) {
                    css[properties[i]] = this.style[properties[i]];
                    this.style[properties[i]] = style[properties[i]];
                }

                this.offsetWidth; // force a repaint
                this.style[support.transition] = 'none';

                if (jumpToEnd) {
                    for (var i = 0; i < properties.length; i++)
                        this.style[properties[i]] = css[properties[i]];

                    var cb = self.data('transitCallback');
                    if (typeof cb === 'function') cb();

                    self.data('transitCallback', null);

                } else if (clearQueue) {
                    self.clearQueue();
                    self.unbind(transitionEnd);
                } else {
                    self.dequeue();
                }
                ;
            }
            ;
        });
        return this;
    };

    function registerCssHook(prop, isPixels) {
        // For certain properties, the 'px' should not be implied.
        if (!isPixels) {
            $.cssNumber[prop] = true;
        }

        $.ntransit.propertyMap[prop] = support.transform;

        $.cssHooks[prop] = {
            get: function (elem) {
                var t = $(elem).css('ntransit:transform');
                return t.get(prop);
            },

            set: function (elem, value) {
                var t = $(elem).css('ntransit:transform');
                t.setFromString(prop, value);

                $(elem).css({ 'ntransit:transform': t });
            }
        };

    }

    // ### uncamel(str)
    // Converts a camelcase string to a dasherized string.
    // (`marginLeft` => `margin-left`)
    function uncamel(str) {
        return str.replace(/([A-Z])/g, function (letter) {
            return '-' + letter.toLowerCase();
        });
    }

    // ### unit(number, unit)
    // Ensures that number `number` has a unit. If no unit is found, assume the
    // default is `unit`.
    //
    //     unit(2, 'px')          //=> "2px"
    //     unit("30deg", 'rad')   //=> "30deg"
    //
    function unit(i, units) {
        if ((typeof i === "string") && (!i.match(/^[\-0-9\.]+$/))) {
            return i;
        } else {
            return "" + i + units;
        }
    }

    // ### toMS(duration)
    // Converts given `duration` to a millisecond string.
    //
    // toMS('fast') => $.fx.speeds[i] => "200ms"
    // toMS('normal') //=> $.fx.speeds._default => "400ms"
    // toMS(10) //=> '10ms'
    // toMS('100ms') //=> '100ms'
    //
    function toMS(duration) {
        var i = duration;

        // Allow string durations like 'fast' and 'slow', without overriding numeric values.
        if (typeof i === 'string' && (!i.match(/^[\-0-9\.]+/))) {
            i = $.fx.speeds[i] || $.fx.speeds._default;
        }

        return unit(i, 'ms');
    }

    // Export some functions for testable-ness.
    $.ntransit.getTransitionValue = getTransition;
})(njQuery);
(function ($, scope, undefined) {
    scope.ssAnimation = NClass.extend({
        _outplayed: false,
        endFN: null,
        endFired: true,
        init: function (layer, options) {
            var _this = this;
            this.layer = layer;
            this.canvas = $(this.layer).data('slide');
            if (!this.canvas)
                this.canvas = this.layer;
            if (this.layer.animated === undefined)
                this.layer.animated = false;
            this.options = $.extend({
                easingIn: 'linear',
                easingOut: 'linear',
                intervalIn: 400,
                intervalOut: 400,
                delayIn: 0,
                delayOut: 0,
                parallaxIn: 0.45,
                parallaxOut: 0.45,
                animate: "smart-slider-animate",
                animateIn: "smart-slider-animate-in",
                animateOut: "smart-slider-animate-out",
                endFn: function () {
                }
            }, options);
        },
        _initAnimation: function () {
            var $layer = this.layer;
            $(this.canvas).trigger('incrementanimation');
            this.layer.on('ssanimateinstart.ssdefault',function (event) {
                event.stopPropagation();
                $layer.off('ssanimateinstart.ssdefault');
            }).on('ssanimateoutstart.ssdefault',function (event) {
                    event.stopPropagation();
                    $layer.off('ssanimateoutstart.ssdefault');
                }).on('ssanimateinend.ssdefault',function (event) {
                    event.stopPropagation();
                    $layer.off('ssanimateinend.ssdefault');
                }).on('ssanimateoutend.ssdefault', function (event) {
                    event.stopPropagation();
                    $layer.off('ssanimateoutend.ssdefault');
                });
        },
        onResize: function (ratio) {

        },
        refreshPosition: function(dim){
        
        },
        setHiddenState: function () {
            if (!this.layer.animated) {
                this._setHiddenState();
            }
        },
        stop: function () {
            if (!this.endFired) {
                this[this.endFN](true);
                this._stop();
                this.endFired = 1;
            }
        },
        _stop: function () {
        },
        _setHiddenState: function () {

        },
        reset: function () {

        },
        setInStart: function () {
            if (!this.layer.animated) {
                this._setInStart();
            }
        },
        _setInStart: function () {
        },
        outPlayed: function (state) {
            if (state === undefined) {
                return this._outplayed;
            }
            this._outplayed = state;
        },
        setOutStart: function () {
            if (!this.layer.animated) {
                this._setOutStart();
            }
        },
        _setOutStart: function () {
            this.layer.css('display', 'block');
        },
        animateIn: function () {
            if (this._canAnimate()) {
                this._initAnimation();
                this.layer.trigger('ssanimateinstart');

                var out = this.layer.data('motionout');
                if (out)
                    out.outPlayed(false);

                this.endFired = 0;
                this._animateIn();
                return true;
            }
            return false;
        },
        onAnimateInEnd: function (forced) {
            if (typeof forced == 'undefined') forced = false;
            if (!this.endFired) {
                this._endAnimate();
                var playoutafter = this.layer.data('playoutafter');
                if (!forced && playoutafter) {
                    var motion = this.layer.data('motionout');
                    motion.animateOut();
                    motion.outPlayed(true);
                } else {
                    this.layer.trigger('ssanimateinend');
                }
                this.endFired = 1;
            }
        },
        animateOut: function () {
            if (this._canAnimate()) {
                this._initAnimation();
                this.layer.trigger('ssanimateoutstart');
                if (this.outPlayed()) {
                    var $this = this;
                    setTimeout(function () {
                        $this.endFired = 0;
                        $this.onAnimateOutEnd();
                    }, 200); // Hack to fire end with some delay if playafterin
                } else {
                    this.endFired = 0;
                    this._animateOut();
                }
                return true;
            }
            return false;
        },
        onAnimateOutEnd: function (forced) {
            if (!this.endFired) {
                this._endAnimate();
                this.layer.trigger('ssanimateoutend');
                this.endFired = 1;
            }
        },
        _canAnimate: function () {
            if (this.layer.animated)
                return false;
            return this.layer.animated = true;
        },
        _endAnimate: function () {
            this.layer.animated = false;
            this.options.endFn();
            $(this.canvas).trigger('decrementanimation');
        }
    });

    scope.ssAnimationManagerClass = NClass.extend({
        init: function () {
            this.animations = {};
        },
        addAnimation: function (name, classdefinition, options) {
            this.animations[name] = {
                classdefinition: classdefinition,
                options: options
            };
        },
        getAnimation: function (name, layer, options) {
            if (this.animations[name] === undefined) {
                name = 'no';
            }
            return new this.animations[name].classdefinition(layer, $.extend(this.animations[name].options, options));
        }
    });
    if (scope.ssAnimationManager === undefined)
        scope.ssAnimationManager = new scope.ssAnimationManagerClass();

})(njQuery, window);;
(function ($, scope, undefined) {
    var methods = {
        init: function (options) {
            var settings = $.extend({
            }, options);
            return this.each(function () {
                var $this = $(this),
                    data = $this.data('smartslider');
                if (!data) {
                    var slider = smartsliderbase($this, settings)
                    $(this).data('smartslider', {
                        slider: slider
                    });
                    data = $this.data('smartslider');
                    $this.trigger('inited', [slider]);
                }
            });

        },
        onInit: function(fn){
            return this.each(function () {
                var $this = $(this),
                    data = $this.data('smartslider');
                if(data){
                    fn({}, data.slider);
                }else{
                    $this.on('inited', fn);
                }
            });
        },
        next: function () {
            return this.each(function () {
                var $this = $(this),
                    data = $this.data('smartslider');
                data.slider.next();
            });
        },
        previous: function () {
            return this.each(function () {
                var $this = $(this),
                    data = $this.data('smartslider');
                data.slider.previous();
            });
        },
        goto: function (i, reversed) {
            return this.each(function () {
                var $this = $(this),
                    data = $this.data('smartslider');
                data.slider.goto(i, reversed);
            });
        },
        startautoplay: function () {
            return this.each(function () {
                var $this = $(this),
                    data = $this.data('smartslider');
                data.slider.startautoplay();
            });
        },
        pauseautoplay: function () {
            return this.each(function () {
                var $this = $(this),
                    data = $this.data('smartslider');
                data.slider.pauseautoplay();
            });
        }
    };

    $.fn.extend({
        smartslider: function (method) {
            this.defaultOptions = {};

            var options = $.extend({}, this.defaultOptions, options);

            if (methods[method]) {
                return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
            } else if (typeof method === 'object' || !method) {
                return methods.init.apply(this, arguments);
            } else {
                $.error('Method ' + method + ' does not exist on jQuery.tooltip');
            }
        }
    });

    window.smartslider = {};
    window.smartslider.motions = {};

    window.smartsliderbase = function (el, options) {
        var proto = function (el, options) {
            var $this = this;
            this.$el = el;
            this.options = options;

            this.canvasList = null;

            this.slideAnimateIn = "smart-slider-slide-animate-in";
            this.slideAnimateOut = "smart-slider-slide-animate-out";
            this.slideActive = "smart-slider-slide-active";

            this.mainslider = new scope[options.type](this, el, options);

            this.next = function () {
                this.mainslider.next();
            };

            this.previous = function () {
                this.mainslider.previous();
            };

            this.goto = function (i, reversed) {
                this.mainslider.changeTo(i, reversed);
            };

            this.startautoplay = function () {
                this.mainslider.reStartAutoPlay();
            };

            this.pauseautoplay = function () {
                this.mainslider.pauseAutoPlay();
            };
        };
        return new proto(el, options);
    };

})(njQuery, window);;
(function ($, scope, undefined) {
    scope.ssTypeBase = NClass.extend({
        $this: null,
        $slider: null,
        slideList: null,
        _parent: null,
        _active: -1,
        _lastActive: -1,
        _animating: false,
        _runningAnimations: 0,
        lastAvailableWidth: 0,
        _ready: false,
        _currentmode: 'desktop',
        _device: 'desktop',
        init: function (parent, $el, options) {
            this.options = {
                syncAnimations: 1,
                translate3d: 1,
                mainlayer: true,
                playfirstlayer: 0,
                mainafterout: 1,
                inaftermain: 1,
                fadeonscroll: 0,
                autoplay: 0,
                autoplayConfig: {
                    duration: 5000,
                    counter: 0,
                    autoplayToSlide: 0,
                    stopautoplay: {
                        click: 1,
                        mouseenter: 1,
                        slideplaying: 1
                    },
                    resumeautoplay: {
                        mouseleave: 0,
                        slideplayed: 1
                    }
                },
                responsive: {
                    downscale: 0,
                    upscale: 0
                },
                controls: {
                    scroll: 0,
                    touch: 0,
                    keyboard: 0
                },
                blockrightclick: 0,
                lazyload: 1,
                lazyloadneighbor: 0
            };
            this.slideDimension = {
                w: 0,
                h: 0
            };
            this.ssplay = false;

            var _this = this;
            this._parent = parent;

            $.extend(this.options, options);
            this.options.syncAnimations = this.options.mainafterout;

            this.$slider = $el;

            this.initVariables();

            if (this.options.translate3d && nModernizr && nModernizr.csstransforms3d) {
                this.$slider.css(nModernizr.prefixed('transform'), 'translate3d(0,0,0)');
                this.$slider.css(nModernizr.prefixed('perspective'), '1000');
            }

            if (this.options.blockrightclick && window.ssadmin !== 1) {
                this.$slider.bind("contextmenu", function (e) {
                    e.preventDefault();
                });
            }
            if (this.options.lazyload == 1) {
                this.lazyLoadEnable(false);
            } else if (this.options.lazyload == 2) {
                this.lazyLoadEnable(true);
            }

            this.id = $el.attr('id');

            this.$this = $(this);

            if (this.options.randomize) this.randomize();

            this.slideList = $('.smart-slider-canvas', $el);

            this._afterInitCheck();
        },
        _afterInitCheck: function () {
            if (this.$slider.parent().parent().is(':visible')) {
                this.afterInit();
            } else {
                var _this = this;
                setTimeout(function () {
                    _this._afterInitCheck();
                }, 500);
            }
        },
        _resizeEvent: '',
        afterInit: function () {
            var _this = this;

            this.slideDimension.w = this.slideList.width();
            this.slideDimension.h = this.slideList.height();

            for (var i = 0; i < this.slideList.length; i++) {
                var slide = this.slideList[i];

                // syncronize layer animations with the slide changing
                slide.ssanimation = 0;
                this.slideList.eq(i).on('incrementanimation.ssanimation', function () {
                    this.ssanimation++;
                }).on('decrementanimation.ssanimation', function () {
                    this.ssanimation--;
                    if (this.ssanimation === 0) {
                        $(this).trigger('ssanimationsended');
                    }
                }).on('noanimation.ssanimation', function () {
                    if (this.ssanimation === 0) {
                        $(this).trigger('ssanimationsended');
                    }
                });

                // init layers
                slide.layers = new scope.ssLayers(this, slide, {
                    width: this.slideDimension.w,
                    height: this.slideDimension.h,
                    mainlayer: this.options.mainlayer
                });
                slide.layers.changeMode(this._currentmode);
            }

            this.slidebgList = $('.nextend-slide-bg', this.$slider);
            this.slidebgList.width(this.slideDimension.w);

            this._active = this.slideList.index($('.' + this._parent.slideActive, this.$slider));

            this.sizeInited();

            this._bullets = this.$slider.find('.nextend-bullet-container > .nextend-bullet');
            this._bullets.removeClass('active');
            this._bullets.eq(this._active).addClass('active');

            this._bar = this.$slider.find('.nextend-bar-slide');
            this._bar.removeClass('active');
            this._bar.eq(this._active).addClass('active');


            this._thumbnails = window[this.id + '-thumbnail'];
            this.changeThumbnail(this._active);


            if (window.ssadmin !== 1) {

                this._device = this.deviceType();

                _this._animating = true;

                $(this).on('load.first', function () {
                    $(this).off('load.first');

                    this._ready = true;

                    var show = function () {
                        _this.$slider.addClass('nextend-loaded');
                        $('#' + _this.id + '-placeholder').remove();

                        _this.$slider.trigger('loaded');

                        _this._animating = false;
                        if (_this.options.playfirstlayer) {
                            var canvas = $(_this.slideList[_this._active]);
                            canvas.on('ssanimationsended.first', function () {
                                $(this).off('ssanimationsended.first');
                            }).trigger('ssanimatelayersin');
                        }
                        //_this.startAutoplay();
                        _this.initAutoplay();
                    };

                    if (_this.options.fadeonscroll) {
                        var w = $(window),
                            t = _this.$slider.offset().top + _this.$slider.outerHeight(false) / 2;
                        if (w.scrollTop() + w.height() > t) {
                            show();
                        } else {
                            w.on('scroll.' + _this.id, function () {
                                if (w.scrollTop() + w.height() > t) {
                                    w.off('scroll.' + _this.id);
                                    show();
                                }
                            });
                        }
                    } else {
                        show();
                    }
                });

                if (this.options.responsive.downscale || this.options.responsive.upscale) {
                    this.storeDefaults();
                    this.onResize();

                    $(window).on('resize', function (e) {
                        _this._resizeEvent = e.type;
                        _this.onResize();
                    });
                    if (typeof artxJQuery != "undefined" && typeof artxJQuery.fn.on != "undefined") {
                        artxJQuery(window).on('responsive', function (e) {
                            _this._resizeEvent = e.type;
                            _this.onResize();
                        });
                    }
                    if (typeof jQuery != "undefined" && typeof jQuery.fn.on != "undefined") {
                        jQuery(window).on('responsive', function (e) {
                            _this._resizeEvent = e.type;
                            _this.onResize();
                        });
                    }
                    if (typeof jQuery.fn.fitText != 'undefined') jQuery(window).trigger('resize');
                } else {
                    this.storeDefaults();
                    this.onResize(1);
                    this.load(function () {
                        $(_this).trigger('load');
                    });
                }

                if (!this.options.playfirstlayer) {
                    this.slideList[this._active].layers.setOutStart();
                }

                //this.initAutoplay();
                this.initWidgets();
                this.initScroll();
                this.initTouch();
                this.initKeyboard();
                this.initEvents();

            } else {
                this.storeDefaults();
                $(this).trigger('load');
            }
        },
        load: function (fn) {
            this.$slider.waitForImages(fn);
        },
        ready: function (fn) {
            if (this._ready) {
                fn();
            } else {
                $(this).on('load.first', fn);
            }
        },
        refreshMode: function () {
            var basedon = this.options.responsive.basedon,
                screenwidth = window.innerWidth,
                mode = 'desktop';

            if (basedon == 'screen' || basedon == 'combined') {
                if (screenwidth < this.options.responsive.screenwidth.phone) {
                    mode = 'phone';
                } else if (screenwidth < this.options.responsive.screenwidth.tablet) {
                    mode = 'tablet';
                }
            }

            if (basedon == 'combined') basedon = 'device';

            if (basedon == 'device') {
                if (this._device == 'mobile') {
                    mode = 'phone';
                } else if (this._device == 'tablet') {
                    mode = 'tablet';
                }
            }
            if (this._currentmode != mode) {
                this.$slider.addClass('nextend-' + mode).removeClass('nextend-' + this._currentmode);
                this._currentmode = mode;
                for (var i = 0; i < this.slideList.length; i++) {
                    var slide = this.slideList[i];
                    slide.layers.changeMode(mode);
                }
                return true;
            }
            return false;
        },
        sizeInited: function () {

        },
        storeDefaults: function () {
            this.variablesRefreshed();
        },
        onResize: function () {
            var _this = this;

            this.load(function () {
                $(_this).trigger('load');
            });
        },
        initVariables: function () {
            this.variables = {};
            this.variableEls = {
                top: this.$slider.find('[data-sstop]'),
                right: this.$slider.find('[data-ssright]'),
                bottom: this.$slider.find('[data-ssbottom]'),
                left: this.$slider.find('[data-ssleft]'),
                width: this.$slider.find('[data-sswidth]'),
                height: this.$slider.find('[data-ssheight]')
            };

            this.widgets = {
                previous: this.$slider.find('.nextend-arrow-previous'),
                next: this.$slider.find('.nextend-arrow-next'),
                bullet: this.$slider.find('.nextend-widget-bullet'),
                autoplay: this.$slider.find('.nextend-autoplay-button'),
                indicator: this.$slider.find('.nextend-indicator'),
                bar: this.$slider.find('.nextend-bar'),
                thumbnail: this.$slider.find('.nextend-thumbnail-container'),
                shadow: this.$slider.find('.nextend-shadow'),
                html: this.$slider.find('.nextend-widget-html')
            };
        },
        variablesRefreshed: function () {
            for (var key in this.widgets) {
                var el = this.widgets[key],
                    visible = el.is(":visible");
                this.variables[key + 'width'] = visible ? el.outerWidth(false) : 0;
                this.variables[key + 'height'] = visible ? el.outerHeight(false) : 0;
            }

            for (var key in this.variables) {
                eval("var " + key + " = " + this.variables[key] + "");
            }


            for (var k in this.variableEls) {
                for (var i = 0; i < this.variableEls[k].length; i++) {
                    var el = this.variableEls[k].eq(i);
                    try {
                        el.css(k, eval(el.data('ss' + k)) + 'px');
                    } catch (e) {
                        alert('Error in widget(#' + el.attr('id') + ') position variable: ' + e.message);
                    }
                }
            }
        },
        initWidgets: function () {
            var timeout = null,
                block = false,
                widgets = this.$slider.find('.nextend-widget-hover');
            if (widgets.length > 0) {
                this.$slider.on('mouseenter touchstart', function (e) {
                    if (block) return;
                    var slider = $(this);
                    if (timeout) clearTimeout(timeout);
                    widgets.css('visibility', 'visible');
                    if (e.type == 'touchstart') {
                        block = true;
                        setTimeout(function () {
                            block = false;
                        }, 1000);
                    } else {
                        setTimeout(function () {
                            slider.addClass('nextend-widget-hover-show');
                        }, 50);
                    }
                }).on('mouseleave', function () {
                    var slide = this;
                    if (timeout) clearTimeout(timeout);
                    timeout = setTimeout(function () {
                        $(slide).removeClass('nextend-widget-hover-show');
                        timeout = setTimeout(function () {
                            widgets.css('visibility', 'hidden');
                        }, 400);
                    }, 500);
                });
            }
        },
        initScroll: function () {
            if (this.options.controls.scroll == 0) return;
            var _this = this;
            this.$slider.on('mousewheel', function (e, delta, deltaX, deltaY) {
                if (delta < 0) {
                    _this.next();
                } else {
                    _this.previous();
                }
                e.preventDefault();
            });
        },
        initTouch: function () {
            if (this.options.controls.touch == '0') return;
            var _this = this;
            var mode = this.options.controls.touch;
            var delayBetween = 500,
                last = 0;

            if (typeof jQuery != 'undefined' && typeof jQuery.UIkit != 'undefined') {
                var el = this.$slider.find('> div').eq(0);
                if (mode == 'horizontal') {
                    el.on('swipeRight', function () {
                        _this.previous();
                    }).on('swipeLeft', function () {
                        _this.next();
                    });
                } else if (mode == 'vertical') {
                    el.on('swipeDown', function () {
                        _this.previous();
                    }).on('swipeUp', function () {
                        _this.next();
                    });
                }
                el.on('tap', function (e) {
                    var target = e.target;
                    var prevent = false;
                    var a = null;
                    if (target.tagName == 'A') a = $(target);
                    else a = $(target).closest('a');
                    if (a.length) {
                        window.open(a.attr('href'), a.attr('target'));
                        prevent = true;
                    }

                    var accordion = null;
                    if (!prevent) {
                        accordion = $(target).closest('.accordion-vertical-title, .accordion-horizontal-title');
                        if (accordion.length) {
                            accordion.trigger('click');
                            prevent = true;
                        }
                    }

                    if (!prevent) {
                        var act = _this.slideList.eq(_this._active).trigger('click');
                        if (typeof act.attr("onclick") != 'undefined') prevent = true;
                    }
                    if (prevent) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                });
            } else {
                this.$slider.find('> div').eq(0).swipe({
                    tap: function (event, target) {
                        var prevent = false;
                        var a = null;
                        if (target.tagName == 'A') a = $(target);
                        else a = $(target).closest('a');
                        if (a.length) {
                            window.open(a.attr('href'), a.attr('target'));
                            prevent = true;
                        }

                        var accordion = null;
                        if (!prevent) {
                            accordion = $(target).closest('.accordion-vertical-title, .accordion-horizontal-title');
                            if (accordion.length) {
                                accordion.trigger('click');
                                prevent = true;
                            }
                        }

                        if (!prevent) {
                            var act = _this.slideList.eq(_this._active).trigger('click');
                            if (typeof act.attr("onclick") != 'undefined') prevent = true;
                        }
                        if (prevent) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                    },
                    swipe: function (event, direction, distance, duration, fingerCount) {
                        var c = Date.now();
                        if (last < c - delayBetween) {
                            if (mode == 'horizontal') {
                                if (direction == 'right') {
                                    _this.previous();
                                } else if (direction == 'left') {
                                    _this.next();
                                }
                            } else if (mode == 'vertical') {
                                if (direction == 'down') {
                                    _this.previous();
                                } else if (direction == 'up') {
                                    _this.next();
                                }
                            }
                            last = c;
                        }
                    },
                    fallbackToMouseEvents: false,
                    allowPageScroll: (mode == 'horizontal' ? 'vertical' : 'horizontal')
                });
            }

            if (typeof window.MSGesture !== 'undefined') {
                var gesture = new MSGesture(),
                    el = this.$slider.find('> div').get(0),
                    start = {
                        x: 0,
                        y: 0
                    };
                gesture.target = el;

                if (mode == 'horizontal') {
                    el.style['-ms-touch-action'] = 'pan-x';
                    el.style['-ms-scroll-chaining'] = 'none';
                    el.style['touch-action'] = 'pan-x';
                    el.style['scroll-chaining'] = 'none';
                } else if (mode == 'vertical') {
                    el.style['-ms-touch-action'] = 'pan-y';
                    el.style['-ms-scroll-chaining'] = 'none';
                    el.style['touch-action'] = 'pan-y';
                    el.style['scroll-chaining'] = 'none';
                }

                var eventType = '';
                if (window.navigator.pointerEnabled) {
                    eventType = "pointerdown";
                } else if (window.navigator.msPointerEnabled) {
                    eventType = "MSPointerDown";
                }
                if (eventType) {
                    el.addEventListener(eventType, function (evt) {
                        gesture.addPointer(evt.pointerId);
                    });
                }

                el.addEventListener("MSGestureStart", function (e) {
                    start.x = e.offsetX;
                    start.y = e.offsetY;
                });

                el.addEventListener("MSGestureEnd", function (e) {
                    var zoom = document.documentElement.clientWidth / window.innerWidth;

                    var hOffset = 10,
                        vOffset = 10;
                    if (mode == 'horizontal') {
                        if (start.x - hOffset >= e.offsetX) {
                            _this.next();
                        } else if (start.x + hOffset <= e.offsetX) {
                            _this.previous();
                        }
                    } else if (mode == 'vertical') {
                        if (start.y - vOffset >= e.offsetY) {
                            _this.next();
                        } else if (start.y + vOffset <= e.offsetY) {
                            _this.previous();
                        }
                    }
                });
            }
        },
        initKeyboard: function () {
            if (this.options.controls.keyboard == '0') return;
            var _this = this;
            var delayBetween = 500,
                last = 0;

            $(document).keydown(function (e) {
                var c = Date.now();
                if (last < c - delayBetween) {
                    if (e.keyCode == 37) {
                        _this.previous();
                    } else if (e.keyCode == 39) {
                        _this.next();
                    }
                    last = c;
                }
            });
        },
        initEvents: function () {
            this.$slider.find("*[data-click]").each(function () {
                var thisme = $(this);
                if (thisme.data('click') != "") {
                    thisme.on("click", function (e) {
                        var result = eval('(function() {' + thisme.data('click') + '}())');
                        if (!result) {
                            e.preventDefault();
                        }
                    });
                }
            });
            this.$slider.find("*[data-enter]").each(function () {
                var thisme = $(this);
                if (thisme.data('enter') != "") {
                    thisme.on("mouseenter", function () {
                        eval(thisme.data('enter'));
                    });
                }
            });
            this.$slider.find("*[data-leave]").each(function () {
                var thisme = $(this);
                if (thisme.data('leave') != "") {
                    thisme.on("mouseleave", function () {
                        eval(thisme.data('leave'));
                    });
                }
            });
        },
        next: function (autoplay) {
            var i = this._active + 1;
            if (i === this.slideList.length)
                i = 0;
            return this.changeTo(i, false, autoplay);
        },
        previous: function (autoplay) {
            var i = this._active - 1;
            if (i < 0)
                i = this.slideList.length - 1;
            return this.changeTo(i, true, autoplay);
        },
        lazyLoadEnable: function (delayed) {
            if (this.admin) return;
            var _this = this;
            this.lazyloaded = [];
            this.spinner = $('<div class="nextend-spinnerhidden"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div>');
            this.spinner.appendTo(this.$slider);
            
            /*if(typeof this._changeTo === 'undefined'){
                this._changeTo = this.changeTo;
                this.changeTo = this.lazyChangeTo;
                
                this.___animateTouch = this.__animateTouch;
                this.__animateTouch = this.lazy__animateTouch;
            }*/

            this._changeTo = this.changeTo;
            this.changeTo = this.lazyChangeTo;

            this.___animateTouch = this.__animateTouch;
            this.__animateTouch = this.lazy__animateTouch;

            if (delayed) {
                $(this).one('load', function () {
                    $(window).on('load', function () {
                        _this.slideList.each(function (i) {
                            _this.lazyLoadSlide(i, true, true);
                            _this.lazyLoadFlux(i, true);
                        });
                    });
                });
            } else {
                $(this).one('load', function () {
                    _this.lazyLoadSlide(_this._active, true, true);
                    _this.lazyLoadFlux(_this._active, true);
                });
            }
        },
        lazyLoadSlide: function (i, neighbor, delayed) {
            if (!this.lazyloaded[i]) {
                if (!delayed) this.spinner.addClass('nextend-spinner');
                var _this = this,
                    deferred = this.slideList.eq(i).find('img').nextendunveil(this._currentmode);
                this.lazyloaded[i] = deferred;
                $.when(deferred).then(function () {
                    _this.lazyloaded[i] = true;
                });
            }

            var v = this.options.lazyloadneighbor;
            if (!neighbor && v) {
                var j = 0,
                    k = i;
                while (j < v) {
                    k--;
                    if (k < 0) k = this.slideList.length - 1;
                    this.lazyLoadSlide(k, true, false);
                    j++;
                }
                j = 0;
                k = i;
                while (j < v) {
                    k++;
                    if (k >= this.slideList.length) k = 0;
                    this.lazyLoadSlide(k, true, false);
                    j++;
                }
            }

            return this.lazyloaded[i];
        },
        lazyLoadFlux: function (i, delayed) {
            if (typeof this.flux != 'undefined') {
                if (!delayed) this.spinner.addClass('nextend-spinner');
                return $(this.flux.images[i]).nextendunveil(this._currentmode);
            }
        },
        lazyChangeTo: function (i, reversed, autoplay) {
            var _this = this;
            this.pauseAutoPlay(true);
            $.when(this.lazyLoadSlide(i, false, false), this.lazyLoadFlux(i, false)).then(function () {
                _this.spinner.removeClass('nextend-spinner');
                _this._changeTo(i, reversed, autoplay);
            });
        },
        lazy__animateTouch: function (i, lastActive, prop, target, targetActive) {
            var _this = this;
            this.pauseAutoPlay(true);
            $.when(this.lazyLoadSlide(i, false, false), this.lazyLoadFlux(i, false)).then(function () {
                _this.spinner.removeClass('nextend-spinner');
                _this.___animateTouch(i, lastActive, prop, target, targetActive);
            });
        },
        changeTo: function (i, reversed, autoplay) {

            if (typeof window.ssadmin !== 'undefined' || i === this._active || this._animating)
                return false;
            if (!this.options.syncAnimations) {
                if (this._lastActive != i) this.slideList.eq(this._lastActive).trigger('ssanimatestop');
                this.slideList.eq(this._active).trigger('ssanimatestop');
            }


            this.ssplay = false;

            var _this = this;

            this.pauseAutoPlay(true);

            this._animating = true;

            if (this.options.syncAnimations) _this._runningAnimations++;

            this._nextActive = i;

            this.changeBullet(i);

            $(this).trigger('mainanimationstart');

            var $currentactiveslide = this.slideList.eq(this._active),
                $nextactiveslide = this.slideList.eq(i),
                playin = function () {

                    if (_this.options.inaftermain) {

                        $nextactiveslide.trigger('ssanimatelayerssetinstart');

                        _this.$this.on('mainanimationinend.inaftermain', function () {
                            _this.$this.off('mainanimationinend.inaftermain');
                            $nextactiveslide.trigger('ssanimatelayersin');
                        });
                        _this._runningAnimations++;
                        _this.animateIn(i, reversed);
                    } else {
                        _this._runningAnimations++;
                        _this.animateIn(i, reversed);
                        $nextactiveslide.trigger('ssanimatelayersin');
                    }
                };


            if (this.options.mainafterout) {
                $currentactiveslide.on('ssanimationsended.ssinaftermain', function () {
                    $currentactiveslide.off('ssanimationsended.ssinaftermain');
                    _this._runningAnimations++;
                    _this.animateOut(_this._active, reversed);
                    playin();
                });

                if (this.options.syncAnimations) {
                    $currentactiveslide.trigger('ssanimatelayersout');
                }
            } else {
                this._runningAnimations++;
                this.animateOut(this._active, reversed);

                if (this.options.syncAnimations) {
                    $currentactiveslide.trigger('ssanimatelayersout');
                }

                playin();
            }
            return true;

        },
        animateOut: function (i, reversed) {
            var _this = this;
            this._lastActive = i;
            var $slide = this.slideList.eq(i);

            var motion = ssAnimationManager.getAnimation('no', $slide);
            $slide.on('ssanimationsended.ssmainanimateout', function () {
                $slide.off('ssanimationsended.ssmainanimateout');
                _this.$this.trigger('mainanimationoutend');
                _this.mainanimationended();
            }).trigger('ssoutanimationstart');
            motion.animateOut();
        },
        animateIn: function (i, reversed) {
            var _this = this;
            this._active = i;
            var $slide = this.slideList.eq(i);
            var motion = ssAnimationManager.getAnimation('no', $slide);
            $slide.on('ssanimationsended.ssmainanimatein', function () {
                $slide.off('ssanimationsended.ssmainanimatein');
                _this.$this.trigger('mainanimationinend');
                _this.mainanimationended();
                _this.mainanimationended();
            }).trigger('ssinanimationstart');
            motion.animateIn();
        },
        mainanimationended: function () {
            this._runningAnimations--;
            if (this._runningAnimations === 0) {
                this.slideList.eq(this._lastActive).removeClass(this._parent.slideActive);
                this.slideList[this._lastActive].layers.setHiddenState();
                this.slideList.eq(this._active).addClass(this._parent.slideActive);
                this._animating = false;
                this.$this.trigger('mainanimationend');
                this.startAutoplay();
                if (this.options.autoplayConfig.resumeautoplay.slidechanged) this.reStartAutoPlay();
            } else if (this._runningAnimations < 0) {
                this._runningAnimations = 0;
            }
        },
        changeBullet: function (i) {
            this._bullets.removeClass('active');
            this._bullets.eq(i).addClass('active');
            this._bar.removeClass('active');
            this._bar.eq(i).addClass('active');

            this.changeThumbnail(i);
        },
        changeThumbnail: function (i) {
            if (this._thumbnails) this._thumbnails.change(i);
        },

        initAutoplay: function () {
            var _this = this;
            this.indicator = window[this.id + '-indicator'];
            if (typeof this.indicator !== 'undefined') {
                this.indicator.reset = function () {
                    _this.indicatorProgress = 0;
                    this.refresh(0);
                }
            } else {
                this.indicator = false;
            }


            this.autoplayTimer = null;
            var autoplay = this.options.autoplayConfig;
            if (autoplay.stopautoplay.click) {
                this.$slider.find('> div').eq(0).on('click', function () {
                    _this.pauseAutoPlay();
                });
            }
            if (autoplay.stopautoplay.mouseenter) {
                this.$slider.find('> div').eq(0).on('mouseenter', function () {
                    _this.pauseAutoPlay();
                });
            }
            if (autoplay.stopautoplay.slideplaying) {
                this.$slider.on('ssplaystarted', function () {
                    _this.ssplay = true;
                    _this.pauseAutoPlay();
                });
            }
            if (autoplay.resumeautoplay.mouseleave) {
                this.$slider.on('mouseleave', function () {
                    if (!_this.autoplayTimer) {
                        if (!_this.ssplay) {
                            _this.reStartAutoPlay();
                        }
                    }
                });
            }
            this.$slider.on('ssplayended', function () {
                _this.ssplay = false;
            });
            if (autoplay.resumeautoplay.slideplayed) {
                this.$slider.on('ssplayended', function () {
                    if (!_this.autoplayTimer)
                        _this.reStartAutoPlay();
                });
            }

            if (!this.autoplaybutton) this.autoplaybutton = this.$slider.find('.nextend-autoplay-button');
            if (!this.indicatorEl) this.indicatorEl = $('<div></div>').appendTo('body');

            if (this.options.autoplay) {
                this.startAutoplay = this.startAutoplayWorking;

                this.load($.proxy(this.startAutoplay, this));
                //this.startAutoplay();
            } else {
                this.pauseAutoPlay();
            }

        },

        startAutoplay: function () {

        },

        startAutoplayWorking: function () {
            var _this = this,
                duration = this.options.autoplayConfig.duration;

            if (this.autoplayTimer) {
                clearTimeout(this.autoplayTimer);
                this.autoplayTimer = null;
            }
            if (this.indicator) {
                var shift = 0,
                    d = duration,
                    prevProgress = 0,
                    invPrevProgress = 1;
                if (this.indicatorEl.data('animating') && _this.indicatorProgress) {
                    d *= (1 - _this.indicatorProgress);
                    prevProgress = _this.indicatorProgress;
                    invPrevProgress = 1 - prevProgress;
                } else {
                    this.indicator.refresh(0);
                }
                this.indicatorEl.css('width', 0).animate({
                    width: 1
                }, {
                    duration: d,
                    progress: function (e, i) {
                        var j = prevProgress + invPrevProgress * i;
                        _this.indicator.refresh(j * 100);
                        _this.indicatorProgress = j;
                    },
                    complete: function () {

                        if (_this.next(true) !== false) {
                            _this.options.autoplayConfig.counter++;
                        }
                        _this.indicatorEl.data('animating', false);
                        _this.indicatorEl.stop(true);
                        _this.indicatorProgress = 0;
                        if (!_this.options.autoplayConfig.autoplayToSlide || _this.options.autoplayConfig.counter < _this.options.autoplayConfig.autoplayToSlide - 1) _this.reStartAutoPlay();
                    }
                });
                this.indicatorEl.data('animating', true);
            } else {
                this.autoplayTimer = setTimeout(function () {

                    if (_this.next(true) == true) {
                        _this.options.autoplayConfig.counter++;
                    }
                    if (this.indicator) {
                        _this.indicatorEl.stop(true);

                        _this.indicator.refresh(100);
                    }
                    if (!_this.options.autoplayConfig.autoplayToSlide || _this.options.autoplayConfig.counter < _this.options.autoplayConfig.autoplayToSlide - 1) _this.reStartAutoPlay();
                }, duration);
            }
        },

        pauseAutoPlay: function (reset) {
            if (this.autoplayTimer) {
                clearTimeout(this.autoplayTimer);
                this.autoplayTimer = null;
            }
            this.autoplaybutton.addClass('paused');
            this.indicatorEl.stop(true);
            if (this.indicator && reset) {
                this.indicator.reset();
            }
            this.startAutoplay = function () {
            };
        },
        reStartAutoPlay: function () {
            this.autoplaybutton.removeClass('paused');
            this.startAutoplay = this.startAutoplayWorking;
            if (this._runningAnimations === 0) this.startAutoplay();
        },
        deviceType: function () {
            var ua = window.navigator ? window.navigator.userAgent : window.request ? window.request.headers['user-agent'] : 'No User-Agent Provided';
            // smart tv
            return ua.match(/GoogleTV|SmartTV|Internet.TV|NetCast|NETTV|AppleTV|boxee|Kylo|Roku|DLNADOC|CE\-HTML/i) ? 'desktop'
                // tv-based gaming console
                : ua.match(/Xbox|PLAYSTATION.3|Wii/i) ? 'desktop'
                // tablet
                : ua.match(/iPad/i) || ua.match(/tablet/i) && !ua.match(/tablet pc/i) && !ua.match(/RX-34/i) || ua.match(/FOLIO/i) ? 'tablet'
                // android tablet
                : ua.match(/Linux/i) && ua.match(/Android/i) && !ua.match(/Fennec|mobi|HTC.Magic|HTCX06HT|Nexus.One|SC-02B|fone.945/i) ? 'tablet'
                // Kindle or Kindle Fire
                : ua.match(/Kindle/i) || ua.match(/Mac.OS/i) && ua.match(/Silk/i) ? 'tablet'
                // pre Android 3.0 Tablet
                : ua.match(/GT-P10|SC-01C|SHW-M180S|SGH-T849|SCH-I800|SHW-M180L|SPH-P100|SGH-I987|zt180|HTC(.Flyer|\_Flyer)|Sprint.ATP51|ViewPad7|pandigital(sprnova|nova)|Ideos.S7|Dell.Streak.7|Advent.Vega|A101IT|A70BHT|MID7015|Next2|nook/i) || ua.match(/MB511/i) && ua.match(/RUTEM/i) ? 'tablet'
                // unique Mobile User Agent
                : ua.match(/BOLT|Fennec|Iris|Maemo|Minimo|Mobi|mowser|NetFront|Novarra|Prism|RX-34|Skyfire|Tear|XV6875|XV6975|Google.Wireless.Transcoder/i) ? 'mobile'
                // odd Opera User Agent - http://goo.gl/nK90K
                : ua.match(/Opera/i) && ua.match(/Windows.NT.5/i) && ua.match(/HTC|Xda|Mini|Vario|SAMSUNG\-GT\-i8000|SAMSUNG\-SGH\-i9/i) ? 'mobile'
                // Windows Desktop
                : ua.match(/Windows.(NT|XP|ME|9)/) && !ua.match(/Phone/i) || ua.match(/Win(9|.9|NT)/i) ? 'desktop'
                // Mac Desktop
                : ua.match(/Macintosh|PowerPC/i) && !ua.match(/Silk/i) ? 'desktop'
                // Linux Desktop
                : ua.match(/Linux/i) && ua.match(/X11/i) ? 'desktop'
                // Solaris, SunOS, BSD Desktop
                : ua.match(/Solaris|SunOS|BSD/i) ? 'desktop'
                // Desktop BOT/Crawler/Spider
                : ua.match(/Bot|Crawler|Spider|Yahoo|ia_archiver|Covario-IDS|findlinks|DataparkSearch|larbin|Mediapartners-Google|NG-Search|Snappy|Teoma|Jeeves|TinEye/i) && !ua.match(/Mobile/i) ? 'desktop'
                : 'desktop';
        },
        randomize: function () {
            var sl = this.$slider.find('.smart-slider-canvas');
            var p = sl.parent();

            sl = this.shuffle(sl);

            sl.each(function () {
                p.append(this);
            });

            sl.filter('.' + this._parent.slideActive).removeClass(this._parent.slideActive);
            sl.eq(0).addClass(this._parent.slideActive);
        },
        shuffle: function (array) {
            var m = array.length, t, i;

            // While there remain elements to shuffle�
            while (m) {

                // Pick a remaining element�
                i = Math.floor(Math.random() * m--);

                // And swap it with the current element.
                t = array[m];
                array[m] = array[i];
                array[i] = t;
            }

            return array;
        }
    });

})(njQuery, window);

if (!Date.now) {
    Date.now = function now() {
        return new Date().getTime();
    };
};
(function ($, scope, undefined) {

    scope.ssLayers = NClass.extend({
        slide: null,
        $slide: null,
        layers: null,
        show: null,
        mode: 'desktop',
        init: function (slider, slide, options) {
            var _this = this;
            this.options = {};

            this.slider = slider;
            this.slide = slide;
            this.$slide = $(slide);

            $.extend(this.options, options);

            this.refresh();
            
            $(slider).on('resize', function (e, ratio, width, height) {
                _this.onResize(ratio, width, height);
            });

            this.$slide.on('ssanimatelayersin',function () {
                _this.animateIn();
            }).on('ssanimatelayerssetinstart',function () {
                    _this.setInStart();
                }).on('ssanimatelayerssetoutstart',function () {
                    _this.setOutStart();
                }).on('ssanimatelayersresetin',function () {
                    _this.resetIn();
                }).on('ssanimatelayersresetout',function () {
                    _this.resetOut();
                }).on('ssanimatelayersout',function () {
                    _this.animateOut();                    
                }).on('ssanimatestop', function () {
                    _this.stop();
                });
        },
        refresh: function () {
            var _this = this;

            this.layers = $([]);

            var _layers = $('.smart-slider-layer', this.slide),
                _active = $(this.slide).hasClass('smart-slider-slide-active');
                
            _layers.each(function () {
                var $layer = $(this);
                if ($layer.data('animation') !== undefined) {
                    //$layer.css('display', 'none');
                    _this.layers.push(this);
                    $layer.data('slide', _this.slide);
                    $layer.data('layermanager', _this);

                    var motionin = _this.getMotionIn($layer);
                    $layer.data('motionin', motionin);
                    var motionout = _this.getMotionOut($layer);
                    $layer.data('motionout', motionout);
                    
                    if (window.ssadmin === 1) {
                        motionout.setOutStart();
                        motionout.reset();
                        motionin.reset();
                    }
                    
                    if(!_active){
                        motionin.setInStart();
                    }
                }
            });
            
            this.show = {
                realall: _layers,
                notall: $(),
                hidden: _layers.filter('*[data-showdesktop="0"][data-showtablet="0"][data-showphone="0"]'),
                desktop: _layers.filter('*[data-showdesktop="1"]'),
                tablet: _layers.filter('*[data-showtablet="1"]') ,
                phone: _layers.filter('*[data-showphone="1"]')
            };
            this.show.all = _layers.not(this.show.hidden).not(this.show.desktop).not(this.show.tablet).not(this.show.phone)
            
            this.show.notdesktop = $.merge($.merge($([]), this.show.tablet), this.show.phone);
            this.show.nottablet = $.merge($.merge($([]), this.show.desktop), this.show.phone);
            this.show.notphone = $.merge($.merge($([]), this.show.desktop), this.show.tablet);
            
            this.show.hidden.css('display', 'none');
            return this;
        },
        onResize: function (ratio, width, height) {
            this.options.width = width;
            this.options.height = height;
        },
        changeMode: function(mode){
            this.mode = mode;
            if(mode == 'all'){
                this.show['realall'].css('display', 'block');
                this.layers = $.merge($([]), this.show['realall']);
                mode = 'desktop';
            }else{
                this.show['not'+mode].css('display', 'none');
                this.show['all'].css('display', 'block');
                this.show[mode].css('display', 'block');
                this.layers = $.merge($.merge($([]), this.show[mode]), this.show['all']);
            }
            this.layers.each(function(){
                var $this = $(this);
                var dim = {
                    left: $this.data(mode+'left'),
                    top: $this.data(mode+'top'),
                    width: $this.data(mode+'width'),
                    height: $this.data(mode+'height')
                };
                for(var k in dim){
                  if(typeof dim[k] == 'undefined') dim[k] = $this.data('desktop'+k);
                  if(typeof dim[k] != 'undefined') this.style[k] = dim[k];
                }
                $this.data('motionin').refreshPosition(dim);
                $this.data('motionout').refreshPosition(dim);
            });
        },
        stop: function () {
            this.layers.each(function () {
                $(this).data('motionin').stop();
                $(this).data('motionout').stop();
            });
            return this;
        },
        resetIn: function () {
            this.layers.each(function () {
                $(this).data('motionin').reset();
            });
            return this;
        },
        resetOut: function () {
            this.layers.each(function () {
                $(this).data('motionout').reset();
            });
            return this;
        },
        animateIn: function () {
            if (this.layers.length === 0) {
                $(this.slide).trigger('noanimation');
            } else {
                this.layers.each(function () {
                    $(this).data('motionin').animateIn();
                });
            }
            return this;
        },
        setInStart: function () {
            this.layers.each(function () {
                $(this).data('motionout').setOutStart();
                $(this).data('motionin').setInStart();
            });
            return this;
        },
        animateOut: function () {
            if (this.layers.length === 0) {
                $(this.slide).trigger('noanimation');
            } else {
                this.layers.each(function () {
                    $(this).data('motionout').animateOut();
                });
            }
            return this;
        },
        setOutStart: function () {
            this.layers.each(function () {
                $(this).data('motionout').setOutStart();
            });
            return this;
        },
        setHiddenState: function () {
            this.layers.each(function () {
                $(this).data('motionout').setHiddenState();
            });
            return this;
        },
        getMotionIn: function ($layer) {
            var options = this.options;
            return ssAnimationManager.getAnimation($layer.data('animationin'), $layer, {
                width: options.width,
                height: options.height,
                intervalIn: parseInt($layer.data('durationin')),
                easingIn: $layer.data('easingin'),
                delayIn: parseInt($layer.data('delayin')),
                parallaxIn: parseFloat($layer.data('parallaxin'))
            });
        },
        getMotionOut: function ($layer) {
            var options = this.options;
            return ssAnimationManager.getAnimation($layer.data('animationout'), $layer, {
                width: options.width,
                height: options.height,
                intervalOut: parseInt($layer.data('durationout')),
                easingOut: $layer.data('easingout'),
                delayOut: parseInt($layer.data('delayout')),
                parallaxOut: parseFloat($layer.data('parallaxout'))
            });
        }
    });
})(njQuery, window);(function ($, scope, undefined) {

    scope.ssAnimationNo = scope.ssAnimation.extend({
        init: function (layer, options) {
            this._super(layer, options);
        },
        _setInStart: function () {
            this.layer.css('display', 'block');
        },
        _animateIn: function () {
            this.endFN = 'onAnimateInEnd';
            this.layer.css('display', 'block');
            this['onAnimateInEnd']();
        },
        _animateOut: function () {
            this.endFN = 'onAnimateOutEnd';
            this['onAnimateOutEnd']();
        }
    });

    scope.ssAnimationManager.addAnimation('no', scope.ssAnimationNo, {});

})(njQuery, window);(function ($, scope, undefined) {

    scope.ssAnimationNoStatic = scope.ssAnimation.extend({
        init: function (layer, options) {
            this._super(layer, options);
        },
        _setInStart: function () {
        },
        _animateIn: function () {
            this.endFN = 'onAnimateInEnd';
            this.layer.css('left', 0);
            this['onAnimateInEnd']();
        },
        _animateOut: function () {
            this.endFN = 'onAnimateOutEnd';
            this.layer.css('left', '-1000%');
            this['onAnimateOutEnd']();
        }
    });

    scope.ssAnimationManager.addAnimation('nostatic', scope.ssAnimationNoStatic, {});

})(njQuery, window);(function ($, scope, undefined) {
    scope.ssAnimationFade = scope.ssAnimation.extend({
        timeout: null,
        init: function (layer, options) {
            this._super(layer, options);
            this.options.animate += " smart-slider-animate-fade";
        },
        _stop: function () {
            var $this = this,
                slider = $(this.layer.data('layermanager').slider);
            slider.on('mainanimationend.layerstop', function () {
                if ($this.timeout) clearTimeout($this.timeout);
                $this.layer.stop(true).css('display', 'none');
                slider.off('mainanimationend.layerstop');
            });
        },
        _setHiddenState: function () {
            this.layer.css('opacity', '1');
        },
        _setInStart: function () {
            this.layer.css('display', 'none');
        },
        _animateIn: function () {
            this._animate(0, 1, this.options.animate + ' ' + this.options.animateIn, this.options.intervalIn, this.options.easingIn, this.options.delayIn, 'onAnimateInEnd');
        },
        _setOutStart: function () {
            this.layer.css('display', 'block').css('opacity', '1');
        },
        _animateOut: function () {
            this._animate(1, 0, this.options.animate + ' ' + this.options.animateOut, this.options.intervalOut, this.options.easingOut, this.options.delayOut, 'onAnimateOutEnd');
        },
        _animate: function (startOpacity, endOpacity, cssclass, interval, easing, delay, endfn) {
            this.endFN = endfn;
            if (this.timeout) clearTimeout(this.timeout);
            var $this = this;
            var endDisplay = (endOpacity === 0) ? 'none' : 'block';

            this.layer.addClass(cssclass).css('opacity', startOpacity).css('display', 'block');

            this.timeout = setTimeout(function () {
                $this.layer.animate({
                    opacity: endOpacity
                }, {
                    duration: interval,
                    complete: function () {
                        $this.layer.css('display', endDisplay).removeClass(cssclass);
                        $this[endfn]();
                    }
                });
            }, 50 + delay);
        }
    });

    scope.ssAnimationManager.addAnimation('fade', scope.ssAnimationFade, {});

})(njQuery, window);(function ($, scope, undefined) {
    scope.ssAnimationFadestatic = scope.ssAnimationFade.extend({
        timeout: null,
        init: function (layer, options) {
            this._super(layer, options);
            this.options.animate += " smart-slider-animate-fade";
        },
        _stop: function () {
            var $this = this,
                slider = $(this.layer.data('layermanager').slider);
            slider.on('mainanimationend.layerstop', function () {
                if ($this.timeout) clearTimeout($this.timeout);
                $this.layer.stop(true).css('opacity', '0');
                slider.off('mainanimationend.layerstop');
            });
        },
        _setHiddenState: function () {
            this.layer.css('opacity', '1');
        },
        _setInStart: function () {
            this.layer.css('opacity', '0');
        },
        _animateIn: function () {
            this._animate(0, 1, this.options.animate + ' ' + this.options.animateIn, this.options.intervalIn, this.options.easingIn, this.options.delayIn, 'onAnimateInEnd');
        },
        _setOutStart: function () {
            this.layer.css('display', 'block').css('opacity', '1');
        },
        _animateOut: function () {
            this._animate(1, 0, this.options.animate + ' ' + this.options.animateOut, this.options.intervalOut, this.options.easingOut, this.options.delayOut, 'onAnimateOutEnd');
        },
        _animate: function (startOpacity, endOpacity, cssclass, interval, easing, delay, endfn) {
            this.endFN = endfn;
            if (this.timeout) clearTimeout(this.timeout);
            var $this = this;

            this.layer.addClass(cssclass).css('opacity', startOpacity).css('left', 0).css('top', 0);

            this.timeout = setTimeout(function () {
                $this.layer.animate({
                    opacity: endOpacity
                }, {
                    duration: interval,
                    complete: function () {
                        $this.layer.removeClass(cssclass);
                        $this[endfn]();
                    }
                });
            }, 50 + delay);
        }
    });

    scope.ssAnimationManager.addAnimation('fadestatic', scope.ssAnimationFadestatic, {});

})(njQuery, window);(function ($, scope, undefined) {
    scope.ssAnimationSlide = scope.ssAnimation.extend({
        timeout: null,
        delayfnstring: '',
        init: function (layer, options) {
            var _this = this;
            if (!options.target) options.target = {};
            this._super(layer, options);
            this.options.animate += " smart-slider-animate-slide";

            var l = layer[0];
            l.origLeftPercent = parseFloat(l.style.left);
            l.origTopcent = parseFloat(l.style.top);
            if (!l.origLeftPercent) l.origLeftPercent = 0;
            if (!l.origTopcent) l.origTopcent = 0;

            var layermanager = $(this.layer).data('layermanager');
            if (layermanager) {
                $(layermanager.slider).on('resize', function (e, ratio, width, height) {
                    _this.onResize(ratio, width, height);
                });
            }
        },
        _stop: function () {
            var $this = this,
                slider = $(this.layer.data('layermanager').slider);
            window[$this.delayfnstring] = null;
            try {
                delete window[$this.delayfnstring];
            } catch (e) {
            }
            if (this.timeout) clearTimeout(this.timeout);
            slider.on('mainanimationend.layerstop', function () {
                $this.layer.css('display', 'none').stop(true);
                slider.off('mainanimationend.layerstop');
            });
        },
        onResize: function (ratio, width, height) {
            this.options.width = width;
            this.options.height = height;
        },
        refreshPosition: function(dim){
            var l = this.layer[0];
            l.origLeftPercent = parseFloat(dim.left);
            l.origTopcent = parseFloat(dim.top);
        },
        _setInStart: function () {
            var coords = this.getCoords(this.options.mode, this.options.parallaxIn, false);
            var left = this.layer[0].origLeftPercent / 100 * this.options.width;
            var top = this.layer[0].origTopcent / 100 * this.options.height;
            this.layer.css('visibility', 'hidden')
            .css('left', left + coords.origX)
                .css('top', top + coords.origY);
        },
        _animateIn: function () {
            this._animate(this.getCoords(this.options.mode, this.options.parallaxIn, false), 'hidden', 'block', 'block', this.options.animate + ' ' + this.options.animateIn, this.options.intervalIn, this.options.easingIn, this.options.delayIn, 'onAnimateInEnd');
        },
        _setOutStart: function () {
            this.layer.css('left', this.layer[0].origLeftPercent + '%')
                .css('top', this.layer[0].origTopcent + '%')
                .css('display', 'block');
        },
        _animateOut: function () {
            this._animate(this.getCoords(this.options.mode, this.options.parallaxOut, true), 'visible', 'block', 'none', this.options.animate + ' ' + this.options.animateOut, this.options.intervalOut, this.options.easingOut, this.options.delayOut, 'onAnimateOutEnd');
        },
        _animate: function (coords, startVisibility, startDisplay, endDisplay, cssclass, interval, easing, delay, endfn) {
            this.endFN = endfn;
            var $this = this,
                options = this.options;
            var left = this.layer[0].origLeftPercent / 100 * options.width;
            var top = this.layer[0].origTopcent / 100 * options.height;
            this.layer.addClass(cssclass).css('left', left + coords.origX).css('top', top + coords.origY).css('visibility', startVisibility).css('display', startDisplay);

            var target = {};
            $.extend(target, this.options.target);
            if (coords.targetX !== null) target.left = left + coords.targetX;
            if (coords.targetY !== null) target.top = top + coords.targetY;


            if (typeof $.easing[easing] != 'function') easing = 'linear';

            var delay = 50 + delay,
                delaystring = 'sstimer' + delay,
                delayfnstring = delaystring + 'fns';

            this.delayfnstring = delayfnstring;
            if (!window[delayfnstring]) window[delayfnstring] = [];
            window[delayfnstring].push(function () {
                $this.layer.css('visibility', 'visible').animate(target, {
                    duration: interval,
                    easing: easing,
                    complete: function () {
                        $this.layer.css('display', endDisplay).removeClass(cssclass).css('left', $this.layer[0].origLeftPercent + '%').css('top', $this.layer[0].origTopcent + '%');
                        $this[endfn]();
                    }
                });
            });

            if (window[delaystring]) clearTimeout(window[delaystring]);
            this.timeout = window[delaystring] = setTimeout(function () {
                for (var i = 0; i < window[delayfnstring].length; i++) {
                    window[delayfnstring][i]();
                }
                window[delayfnstring] = null;
                try {
                    delete window[delayfnstring];
                } catch (e) {
                }
            }, delay);
        },
        getCoords: function (direction, parallax, out) {
            var coords = {
                targetX: null,
                targetY: null,
                origX: 0,
                origY: 0
            }, options = this.options;
            if (out) {
                switch (direction) {
                    case 'righttoleft':
                        coords.origX = 0;
                        coords.targetX = -1 * options.width * parallax;
                        break;
                    case 'lefttoright':
                        coords.origX = 0;
                        coords.targetX = options.width * parallax;
                        break;
                    case 'toptobottom':
                        coords.origY = 0;
                        coords.targetY = options.height * parallax;
                        break;
                    case 'bottomtotop':
                        coords.origY = 0;
                        coords.targetY = -1 * options.height * parallax;
                        break;
                    default:
                }
            } else {
                switch (direction) {
                    case 'righttoleft':
                        coords.origX = options.width * parallax;
                        coords.targetX = 0;
                        break;
                    case 'lefttoright':
                        coords.origX = -1 * options.width * parallax;
                        coords.targetX = 0;
                        break;
                    case 'toptobottom':
                        coords.origY = -1 * options.height * parallax;
                        coords.targetY = 0;
                        break;
                    case 'bottomtotop':
                        coords.origY = options.height * parallax;
                        coords.targetY = 0;
                        break;
                    default:
                }
            }
            return coords;
        }
    });

    scope.ssAnimationManager.addAnimation('slidelefttoright', scope.ssAnimationSlide, {
        mode: 'lefttoright'
    });

    scope.ssAnimationManager.addAnimation('sliderighttoleft', scope.ssAnimationSlide, {
        mode: 'righttoleft'
    });

    scope.ssAnimationManager.addAnimation('slidetoptobottom', scope.ssAnimationSlide, {
        mode: 'toptobottom'
    });

    scope.ssAnimationManager.addAnimation('slidebottomtotop', scope.ssAnimationSlide, {
        mode: 'bottomtotop'
    });

})(njQuery, window);(function ($, scope, undefined) {
    scope.ssAnimationSlideStatic = scope.ssAnimationSlide.extend({
        timeout: null,
        delayfnstring: '',
        init: function (layer, options) {
            var _this = this;
            if (!options.target) options.target = {};
            this._super(layer, options);
            this.options.animate += " smart-slider-animate-slide";
            var layermanager = $(this.layer).data('layermanager');
            if (layermanager) {
                $(layermanager.slider).on('resize', function (e, ratio, width, height) {
                    _this.onResize(ratio, width, height);
                });
            }
        },
        _stop: function () {
            var $this = this,
                slider = $(this.layer.data('layermanager').slider);
            window[$this.delayfnstring] = null;
            try {
                delete window[$this.delayfnstring];
            } catch (e) {
            }
            if (this.timeout) clearTimeout(this.timeout);
            slider.on('mainanimationend.layerstop', function () {
                $this.layer.stop(true);
                slider.off('mainanimationend.layerstop');
            });
        },
        refreshPosition: function(){
        
        },
        _setInStart: function () {
            var coords = this.getCoords(this.options.mode, this.options.parallaxIn, false);
            this.layer.css('visibility', 'hidden').css('left', coords.origX).css('top', coords.origY);
        },
        _animateIn: function () {
            this._animate(this.getCoords(this.options.mode, this.options.parallaxIn, false), this.options.animate + ' ' + this.options.animateIn, this.options.intervalIn, this.options.easingIn, this.options.delayIn, 'onAnimateInEnd');
        },
        _setOutStart: function () {
            this.layer.css('left', '0%').css('top', '0%');
        },
        _animateOut: function () {
            this._animate(this.getCoords(this.options.mode, this.options.parallaxOut, true), this.options.animate + ' ' + this.options.animateOut, this.options.intervalOut, this.options.easingOut, this.options.delayOut, 'onAnimateOutEnd');
        },
        _animate: function (coords, cssclass, interval, easing, delay, endfn) {
            this.endFN = endfn;
            var $this = this,
                options = this.options;
            this.layer.addClass(cssclass).css('left', coords.origX).css('top', coords.origY).css('opacity', 1);

            var target = {};
            $.extend(target, this.options.target);
            if (coords.targetX !== null) target.left = coords.targetX;
            if (coords.targetY !== null) target.top = coords.targetY;


            if (typeof $.easing[easing] != 'function') easing = 'linear';

            var delay = 50 + delay,
                delaystring = 'sstimer' + delay,
                delayfnstring = delaystring + 'fns';

            this.delayfnstring = delayfnstring;
            if (!window[delayfnstring]) window[delayfnstring] = [];
            window[delayfnstring].push(function () {
                $this.layer.animate(target, {
                    duration: interval,
                    easing: easing,
                    complete: function () {
                        $this.layer.removeClass(cssclass);
                        if(typeof target.left != 'undefined' && target.left != 0) $this.layer.css('left', '-1000%');
                        if(typeof target.top != 'undefined' && target.top != 0) $this.layer.css('left', '-1000%');
                        $this[endfn]();
                    }
                });
            });

            if (window[delaystring]) clearTimeout(window[delaystring]);
            this.timeout = window[delaystring] = setTimeout(function () {
                for (var i = 0; i < window[delayfnstring].length; i++) {
                    window[delayfnstring][i]();
                }
                window[delayfnstring] = null;
                try {
                    delete window[delayfnstring];
                } catch (e) {
                }
            }, delay);
        }
    });

    scope.ssAnimationManager.addAnimation('slidestaticlefttoright', scope.ssAnimationSlideStatic, {
        mode: 'lefttoright'
    });

    scope.ssAnimationManager.addAnimation('slidestaticrighttoleft', scope.ssAnimationSlideStatic, {
        mode: 'righttoleft'
    });

    scope.ssAnimationManager.addAnimation('slidestatictoptobottom', scope.ssAnimationSlideStatic, {
        mode: 'toptobottom'
    });

    scope.ssAnimationManager.addAnimation('slidestaticbottomtotop', scope.ssAnimationSlideStatic, {
        mode: 'bottomtotop'
    });

})(njQuery, window);(function ($, scope, undefined) {
    scope.ssAnimationTransit = scope.ssAnimation.extend({
        timeout: null,
        init: function (layer, options) {
            var _this = this;
            //$.transit.useTransitionEnd = true;
            this._super(layer, options);
            this.options.animate += " smart-slider-animate-slide";

        },
        reset: function () {
            if (this.options.reset) {
                this.layer.css(this.options.reset);
            }
        },
        _stop: function () {
            if (this.timeout) clearTimeout(this.timeout);
            var $this = this,
                slider = $(this.layer.data('layermanager').slider);
            slider.on('mainanimationend.layerstop', function () {
                $this.layer.ntransitionStop(true).css('display', 'none');
                slider.off('mainanimationend.layerstop');
            });
        },
        _setInStart: function () {
            this.layer.css('visibility', 'hidden').css(this.options.startCSS);
        },
        _animateIn: function () {
            this._animate(this.options.animationin, $.extend({}, this.options.startCSS), $.extend({}, this.options.endCSS), 'hidden', 'block', 'block', this.options.animate + ' ' + this.options.animateIn, this.options.intervalIn, this.options.easingIn, this.options.delayIn, this.options.parallaxIn, 'onAnimateInEnd');
        },
        _setOutStart: function () {
            var endcss = $.extend({}, this.options.endCSS);
            if (this.options.parallax) {
                for (var i = 0; i < this.options.parallax.length; i++) {
                    var prop = this.options.parallax[i];
                    endcss[prop] *= this.options.parallaxOut;
                }
            }
            this.layer.css(endcss).css('display', 'block');
        },
        _animateOut: function () {
            this._animate(this.options.animationout, $.extend({}, this.options.endCSS), $.extend({}, this.options.startCSS), 'visible', 'block', 'block', this.options.animate + ' ' + this.options.animateOut, this.options.intervalOut, this.options.easingOut, this.options.delayOut, this.options.parallaxOut, 'onAnimateOutEnd');
        },
        _animate: function (animation, startcss, endcss, startVisibility, startDisplay, endDisplay, cssclass, interval, easing, delay, parallax, endfn) {
            this.endFN = endfn;
            var $this = this,
                options = this.options;
            var left = this.layer[0].origLeftPercent / 100 * options.width;
            var top = this.layer[0].origTopcent / 100 * options.height;

            if (this.options.parallax) {
                for (var i = 0; i < this.options.parallax.length; i++) {
                    var prop = this.options.parallax[i];
                    startcss[prop] *= parallax;
                    endcss[prop] *= parallax;
                }
            }

            this.layer.addClass(cssclass).css('visibility', startVisibility).css(startcss).css('display', startDisplay);


            if (typeof $.easing[easing] != 'function') easing = 'linear';

            this.timeout = setTimeout(function () {
                var layer = $this.layer,
                    percent = 0;
                if (nModernizr.csstransitions && animation && animation.length > 0) {
                    for (var i = 0; i < animation.length; i++) {
                        layer.css('visibility', 'visible').ntransition(
                            animation[i].css,
                            interval * (animation[i].percent - percent) / 100,
                            easing
                        );
                        percent = animation[i].percent;
                    }
                }
                layer.data('sstransit', endfn);
                layer.css('visibility', 'visible').ntransition(
                    endcss,
                    interval * (100 - percent) / 100,
                    easing,
                    function () {
                        $this.layer.css('display', endDisplay).removeClass(cssclass);
                        $this[endfn]();
                    }
                );
            }, 50 + parseInt(delay));

        }
    });

    scope.ssAnimationManager.addAnimation('flipx', scope.ssAnimationTransit, {
        startCSS: {
            opacity: 0,
            perspective: '400px',
            rotateX: 90
        },
        animationin: [
            {
                percent: 40,
                css: {
                    opacity: 0.4,
                    rotateX: -10
                }
            },
            {
                percent: 70,
                css: {
                    opacity: 0.7,
                    rotateX: 10
                }
            }
        ],
        endCSS: {
            opacity: 1,
            rotateX: 0
        }
    });

    scope.ssAnimationManager.addAnimation('flipy', scope.ssAnimationTransit, {
        startCSS: {
            opacity: 0,
            perspective: '400px',
            rotateY: 90
        },
        animationin: [
            {
                percent: 40,
                css: {
                    opacity: 0.4,
                    rotateY: -10
                }
            },
            {
                percent: 70,
                css: {
                    opacity: 0.7,
                    rotateY: 10
                }
            }
        ],
        endCSS: {
            opacity: 1,
            rotateY: 0
        }
    });

    scope.ssAnimationManager.addAnimation('fadeup', scope.ssAnimationTransit, {
        startCSS: {
            opacity: 0,
            y: 1000
        },
        endCSS: {
            opacity: 1,
            y: 0
        },
        parallax: ['y']
    });

    scope.ssAnimationManager.addAnimation('faderight', scope.ssAnimationTransit, {
        startCSS: {
            opacity: 0,
            x: 1000
        },
        endCSS: {
            opacity: 1,
            x: 0
        },
        parallax: ['x']
    });

    scope.ssAnimationManager.addAnimation('fadedown', scope.ssAnimationTransit, {
        startCSS: {
            opacity: 0,
            y: -1000
        },
        endCSS: {
            opacity: 1,
            y: 0
        },
        parallax: ['y']
    });

    scope.ssAnimationManager.addAnimation('fadeleft', scope.ssAnimationTransit, {
        startCSS: {
            opacity: 0,
            x: -1000
        },
        endCSS: {
            opacity: 1,
            x: 0
        },
        parallax: ['x']
    });

    scope.ssAnimationManager.addAnimation('bounce', scope.ssAnimationTransit, {
        startCSS: {
            opacity: 0,
            scale: 0
        },
        animationin: [
            {
                percent: 50,
                css: {
                    opacity: 1,
                    scale: 1.05
                }
            },
            {
                percent: 70,
                css: {
                    scale: 0.9
                }
            }
        ],
        endCSS: {
            opacity: 1,
            scale: 1
        }
    });

    scope.ssAnimationManager.addAnimation('rotate', scope.ssAnimationTransit, {
        startCSS: {
            transformOrigin: 'center center',
            rotate: -360
        },
        endCSS: {
            transformOrigin: 'center center',
            rotate: 0
        },
        parallax: ['rotate']
    });

    scope.ssAnimationManager.addAnimation('rotateupleft', scope.ssAnimationTransit, {
        startCSS: {
            transformOrigin: 'left bottom',
            rotate: 90
        },
        endCSS: {
            transformOrigin: 'left bottom',
            rotate: 0
        },
        parallax: ['rotate']
    });

    scope.ssAnimationManager.addAnimation('rotatedownleft', scope.ssAnimationTransit, {
        startCSS: {
            transformOrigin: 'left bottom',
            rotate: -90
        },
        endCSS: {
            transformOrigin: 'left bottom',
            rotate: 0
        },
        parallax: ['rotate']
    });

    scope.ssAnimationManager.addAnimation('rotateupright', scope.ssAnimationTransit, {
        startCSS: {
            transformOrigin: 'right bottom',
            rotate: 90
        },
        endCSS: {
            transformOrigin: 'right bottom',
            rotate: 0
        },
        parallax: ['rotate']
    });

    scope.ssAnimationManager.addAnimation('rotatedownright', scope.ssAnimationTransit, {
        startCSS: {
            transformOrigin: 'right bottom',
            rotate: -90
        },
        endCSS: {
            transformOrigin: 'right bottom',
            rotate: 0
        },
        parallax: ['rotate']
    });

    scope.ssAnimationManager.addAnimation('rollin', scope.ssAnimationTransit, {
        startCSS: {
            transformOrigin: 'center center',
            opacity: 0,
            x: '-100%',
            rotate: -360
        },
        endCSS: {
            transformOrigin: 'center center',
            opacity: 1,
            x: 0,
            rotate: 0
        },
        parallax: ['rotate']
    });

    scope.ssAnimationManager.addAnimation('rollout', scope.ssAnimationTransit, {
        startCSS: {
            transformOrigin: 'center center',
            opacity: 0,
            x: '100%',
            rotate: 360
        },
        endCSS: {
            transformOrigin: 'center center',
            opacity: 1,
            x: 0,
            rotate: 0
        },
        parallax: ['rotate']
    });

    scope.ssAnimationManager.addAnimation('scale', scope.ssAnimationTransit, {
        startCSS: {
            transformOrigin: 'center center',
            scale: 0
        },
        endCSS: {
            transformOrigin: 'center center',
            scale: 1
        }
    });

})(njQuery, window);(function ($, scope, undefined) {
    scope.ssSimpleSlider = scope.ssTypeBase.extend({
        extraParallax: 1,
        init: function (parent, $el, options) {
            var _this = this;

            options.flux[0] = (options.flux[0] && parseInt(options.flux[0])) ? true : false;

            this._super(parent, $el, options);
        },
        afterInit: function(){
            var _this = this;
            this._super();
            this.smartsliderborder2 = this.$slider.find('.smart-slider-border2');
            this.slideList.not(this.slideList.eq(this._active)).css('left', '-1000%');

            this.$this.on('mainanimationoutend', function () {
                var $slide = this.slideList.eq(_this._lastActive);
                //$slide.css('display', 'none');
            });
            $(this).on('load.firstsub', function () {
                $(this).off('load.firstsub');
            });
        },
        sizeInited: function () {
            if(njQuery('#'+this.id+' .nextend-flux img').length != this.slideList.length) this.options.flux[0] = 0;
            if (this.options.flux[0]) {
                this.flux = new flux.slider('#'+this.id+' .nextend-flux', {
                    transitions: this.options.flux[1],
                    width: this.slideDimension.w,
                    height: this.slideDimension.h,
                    currentImageIndex: this._active,
                    nextImageIndex: this._active + 1
                });
            }
        },
        storeDefaults: function () {
            var _this = this,
                ss = this.$slider;

            ss.data('ss-outerwidth', ss.outerWidth(true));

            //ss.data('ss-fontsize', parseInt(ss.css('fontSize')));

            this.variables.margintop = parseInt(ss.css('marginTop'));
            this.variables.marginright = parseInt(ss.css('marginRight'));
            this.variables.marginbottom = parseInt(ss.css('marginBottom'));
            this.variables.marginleft = parseInt(ss.css('marginLeft'));
            
            ss.data('ss-m-t', this.variables.margintop);
            ss.data('ss-m-r', this.variables.marginright);
            ss.data('ss-m-b', this.variables.marginbottom);
            ss.data('ss-m-l', this.variables.marginleft);
            
            this.variables.outerwidth = ss.parent().width();
            this.variables.outerheight = ss.parent().height();
                
            this.variables.width = ss.width();
            this.variables.height = ss.height();
            
            ss.data('ss-w', this.variables.width);
            ss.data('ss-h', this.variables.height);

            var smartsliderborder1 = this.smartsliderborder1 = ss.find('.smart-slider-border1');
            
            smartsliderborder1.data('ss-w', smartsliderborder1.width());
            smartsliderborder1.data('ss-h', smartsliderborder1.height());
            smartsliderborder1.data('ss-p-t', parseInt(smartsliderborder1.css('paddingTop')));
            smartsliderborder1.data('ss-p-r', parseInt(smartsliderborder1.css('paddingRight')));
            smartsliderborder1.data('ss-p-b', parseInt(smartsliderborder1.css('paddingBottom')));
            smartsliderborder1.data('ss-p-l', parseInt(smartsliderborder1.css('paddingLeft')));

            var canvases = this.smartslidercanvasinner = this.slideList.find('.smart-slider-canvas-inner');
                
            this.variables.canvaswidth = canvases.width();
            this.variables.canvasheight = canvases.height();
            
            canvases.data('ss-w', this.variables.canvaswidth);
            canvases.data('ss-h', this.variables.canvasheight);
            
            this.slideList.css({
                width: this.variables.canvaswidth,
                height: this.variables.canvasheight
            });
            
            this.imagesinited = false;
            this.load(function () {
                $.each(_this.slidebgList, function(){
                    var $img = $(this);
                    var im = $("<img/>").attr("src", $img.attr("src"));
                    $img.data('ss-w', im[0].width < 10 ? _this.variables.canvaswidth : im[0].width);
                    $img.data('ss-h', im[0].height < 10 ? _this.variables.canvasheight : im[0].height);
                });
                _this.imagesinited = true;
                _this.$slider.trigger('imagesinited');
            });
            
            this.slidebgList.on('lazyloaded', function(){
                var $img = $(this);
                var im = $("<img/>").attr("src", $img.attr("src"));
                $img.data('ss-w', im[0].width < 10 ? _this.variables.canvaswidth : im[0].width);
                $img.data('ss-h', im[0].height < 10 ? _this.variables.canvasheight : im[0].height);
                if(typeof _this.variables.oCanvasWidth != 'undefined') $img.height(parseInt(_this.variables.oCanvasWidth/$img.data('ss-w')*$img.data('ss-h')));
            });
            

            this.variablesRefreshed();
        },
        onResize: function (fixedratio) {
            var _this = this,
                ss = this.$slider;
                
            var modechanged = this.refreshMode(); //this._currentmode

            var ratio = 1;

            var availableWidth = ss.parent().width();

            var outerWidth = ss.data('ss-outerwidth');

            if (!this.options.responsive.upscale && availableWidth > outerWidth) availableWidth = outerWidth;
            
            if(typeof fixedratio == 'undefined'){
                if (availableWidth != outerWidth) {
                    ratio = availableWidth / outerWidth;
                }
    
                if (!modechanged && (this.lastAvailableWidth == availableWidth || !this.options.responsive.downscale && ratio < 1)) {
                    var _this = this;
                    this.load(function () {
                        $(_this).trigger('load');
                    });
                    return true;
                }
            }else{
                ratio = fixedratio; 
            }

            this.lastAvailableWidth = availableWidth;

            ss.css('fontSize', ss.data(this._currentmode+'fontsize') * ratio + 'px');

            this.variables.margintop = parseInt(ss.data('ss-m-t') * ratio);
            this.variables.marginright = parseInt(ss.data('ss-m-r') * ratio);
            this.variables.marginbottom = parseInt(ss.data('ss-m-b') * ratio);
            this.variables.marginleft = parseInt(ss.data('ss-m-l') * ratio);

            ss.css('marginTop', this.variables.margintop);
            ss.css('marginRight', this.variables.marginright);
            ss.css('marginBottom', this.variables.marginbottom);
            ss.css('marginLeft', this.variables.marginleft);

            var smartsliderborder1 = this.smartsliderborder1;


            smartsliderborder1.css('paddingTop', parseInt(smartsliderborder1.data('ss-p-t') * ratio) + 'px');
            smartsliderborder1.css('paddingRight', parseInt(smartsliderborder1.data('ss-p-r') * ratio) + 'px');
            smartsliderborder1.css('paddingBottom', parseInt(smartsliderborder1.data('ss-p-b') * ratio) + 'px');
            smartsliderborder1.css('paddingLeft', parseInt(smartsliderborder1.data('ss-p-l') * ratio) + 'px');

            smartsliderborder1.width(parseInt(smartsliderborder1.data('ss-w') * ratio));


            this.variables.width = smartsliderborder1.outerWidth(true);
            ss.width(this.variables.width);


            var canvases = this.smartslidercanvasinner;
            var oCanvasWidth = canvasWidth = parseInt(canvases.data('ss-w') * ratio),
                oCanvasHeight = parseInt(canvases.data('ss-h') * ratio),
                margin = 0,
                maxw = this.options.responsive.maxwidth,
                ratio2 = ratio;

            if (canvasWidth > this.options.responsive.maxwidth) {
                margin = parseInt((canvasWidth - maxw) / 2);
                ratio2 = maxw / canvases.data('ss-w');
                canvasWidth = parseInt(canvases.data('ss-w') * ratio2);
            }

            this.extraParallax = ratio / ratio2;

            var canvasHeight = parseInt(canvases.data('ss-h') * ratio2);
            
            this.variables.oCanvasWidth = oCanvasWidth;

            if (this.options.flux[0]) this.flux.changeSize(oCanvasWidth, canvasHeight);

            canvases.width(canvasWidth).height(canvasHeight).css({
                marginLeft: margin,
                marginRight: margin
            });

            this.slideList.css({
                width: canvases.outerWidth(true),
                height: canvases.outerHeight(true)
            });

            smartsliderborder1.css('fontSize', ss.data(this._currentmode+'fontsize') * ratio2 + 'px');

            smartsliderborder1.height(canvasHeight);
            
            this.variables.height = smartsliderborder1.outerHeight(true);
            ss.height(this.variables.height);

            this.slideDimension.w = canvasWidth;
            this.slideDimension.h = canvasHeight;

            this.variables.canvaswidth = canvasWidth;
            this.variables.canvasheight = canvasHeight;
            
            
            this.variables.outerwidth = ss.parent().width();
            this.variables.outerheight = ss.parent().height();
            
            
            this.slidebgList.width(oCanvasWidth);
            var bgfn = function () {
                $.each(_this.slidebgList, function(){
                    var $img = $(this);
                    $img.height(parseInt(oCanvasWidth/$img.data('ss-w')*$img.data('ss-h')));
                });
            };
            if(_this.imagesinited){
                bgfn();
            }else{
                _this.$slider.on('imagesinited', function(){
                    bgfn();
                });
            }


            for (var i = 0; i < window[this.id + '-onresize'].length; i++) {
                window[this.id + '-onresize'][i](ratio);
            }
            $(this).trigger('resize', [ratio, canvasWidth, canvasHeight]);

            var _this = this;
            this.load(function () {
                $(_this).trigger('load');
            });
            
            this.variablesRefreshed();
        },
        animateOut: function (i, reversed) {
            var _this = this;
            this._lastActive = i;

            this.initAnimation();

            var $slide = this.slideList.eq(i);
            $slide.on('ssanimationsended.ssmainanimateout',function () {
                $slide.off('ssanimationsended.ssmainanimateout');
                _this.$this.trigger('mainanimationoutend');
                _this.mainanimationended();
            }).trigger('ssoutanimationstart');
            this.__animateOut($slide, reversed).animateOut();
        },
        animateIn: function (i, reversed) {
            this._active = i;
            var _this = this,
                $slide = this.slideList.eq(i);

            $slide.width(this.slideList.width());
            $slide.on('ssanimationsended.ssmainanimatein',function () {
                $slide.off('ssanimationsended.ssmainanimatein');
                _this.$this.trigger('mainanimationinend');
                _this.mainanimationended();
            }).trigger('ssinanimationstart');

            if (this.options.flux[0]) {
                //make them synced
                var ended = null,
                endFN = function(){
                    _this.mainanimationended();
                    $slide.trigger('decrementanimation');
                };
                ended = function(){
                    ended = endFN;
                };
                
                $slide.trigger('incrementanimation');
                this.__animateIn($slide, reversed,function () {
                    ended();
                }).animateIn();
                this.flux.element.on('fluxTransitionEnd.ss', function (event) {
                    $(this).off('fluxTransitionEnd.ss');
                    ended();
                });
                this.flux.showImage(i);
            } else {
                this.__animateIn($slide, reversed,function () {
                    _this.mainanimationended();
                }).animateIn();
            }
        },

        initAnimation: function () {
            var currentAnimation = this.options.animation[Math.floor(Math.random() * this.options.animation.length)];
            this._animationOptions = {
                next: {},
                current: {}
            };

            this._animationOptions.next = $.merge(this.options.animationSettings, this._animationOptions.next);
            this._animationOptions.current = $.merge(this.options.animationSettings, this._animationOptions.current);

            switch (currentAnimation) {
                case 'horizontal':
                    this.__animateIn = this.__animateInHorizontal;
                    this.__animateOut = this.__animateOutHorizontal;
                    break;
                case 'vertical':
                    this.__animateIn = this.__animateInVertical;
                    this.__animateOut = this.__animateOutVertical;
                    break;
                case 'fade':
                    this.__animateIn = this.__animateInFade;
                    this.__animateOut = this.__animateOutFade;
                    break;
                default:
                    this.__animateIn = this.__animateInNo;
                    this.__animateOut = this.__animateOutNo;
                    break;
            }
        },

        __animateIn: function ($slide, reversed, end) {

        },

        __animateOut: function ($slide, reversed, end) {

        },

        __animateInNo: function ($slide, reversed, end) {
            if (end) end();
            return ssAnimationManager.getAnimation('nostatic', $slide, {});
        },

        __animateOutNo: function ($slide, reversed, end) {
            if (end) end();
            return ssAnimationManager.getAnimation('nostatic', $slide, {});
        },

        __animateInHorizontal: function ($slide, reversed, end) {

            var option = this._animationOptions.next;
            return ssAnimationManager.getAnimation((reversed && option.parallax >= 1) ? 'slidestaticlefttoright' : 'slidestaticrighttoleft', $slide, {
                width: this.slideDimension.w,
                height: this.slideDimension.h,
                intervalIn: option.duration,
                easingIn: option.easing,
                delayIn: option.delay,
                parallaxIn: option.parallax * this.extraParallax,
                target: {},
                endFn: function () {
                    if (end) end();
                }
            });
        },

        __animateOutHorizontal: function ($slide, reversed, end) {

            var _this = this,
                option = this._animationOptions.current,
                target = option.parallax < 1 ? {width: this.smartsliderborder2.width() * option.parallax} : {};

            return ssAnimationManager.getAnimation((reversed && option.parallax >= 1) ? 'slidestaticlefttoright' : 'slidestaticrighttoleft', $slide, {
                width: this.slideDimension.w,
                height: this.slideDimension.h,
                intervalOut: option.duration,
                easingOut: option.easing,
                delayOut: option.delay,
                parallaxOut: option.parallax * this.extraParallax,
                target: target,
                endFn: function () {
                    $slide.width(_this.smartsliderborder2.width());
                    if (end) end();
                }
            });
        },

        __animateInVertical: function ($slide, reversed, end) {

            var option = this._animationOptions.next;
            return ssAnimationManager.getAnimation((reversed && option.parallax >= 1) ? 'slidestatictoptobottom' : 'slidestaticbottomtotop', $slide, {
                width: this.slideDimension.w,
                height: this.slideDimension.h,
                intervalIn: option.duration,
                easingIn: option.easing,
                delayIn: option.delay,
                parallaxIn: option.parallax * this.extraParallax,
                target: {},
                endFn: function () {
                    if (end) end();
                }
            });
        },

        __animateOutVertical: function ($slide, reversed, end) {

            var _this = this,
                option = this._animationOptions.current,
                target = option.parallax < 1 ? {height: this.smartsliderborder2.height() * option.parallax} : {};

            return ssAnimationManager.getAnimation((reversed && option.parallax >= 1) ? 'slidestatictoptobottom' : 'slidestaticbottomtotop', $slide, {
                width: this.slideDimension.w,
                height: this.slideDimension.h,
                intervalOut: option.duration,
                easingOut: option.easing,
                delayOut: option.delay,
                parallaxOut: option.parallax * this.extraParallax,
                target: target,
                endFn: function () {
                    $slide.height(_this.smartsliderborder2.height());
                    if (end) end();
                }
            });
        },

        __animateInFade: function ($slide, reversed, end) {

            var option = this._animationOptions.next;
            return ssAnimationManager.getAnimation('fadestatic', $slide, {
                width: this.slideDimension.w,
                height: this.slideDimension.h,
                intervalIn: option.duration,
                easingIn: option.easing,
                delayIn: option.delay,
                parallaxIn: option.parallax * this.extraParallax,
                endFn: function () {
                    if (end) end();
                }
            });
        },

        __animateOutFade: function ($slide, reversed, end) {

            var option = this._animationOptions.current;

            return ssAnimationManager.getAnimation('fadestatic', $slide, {
                width: this.slideDimension.w,
                height: this.slideDimension.h,
                intervalOut: option.duration,
                easingOut: option.easing,
                delayOut: option.delay,
                parallaxOut: option.parallax * this.extraParallax,
                endFn: function () {
                    if (end) end();
                }
            });
        },
        initTouch: function () {
            if((this.options.touchanimation != 'horizontal' && this.options.touchanimation != 'vertical') || (typeof jQuery != 'undefined' && typeof jQuery.UIkit != 'undefined')){
                this._super();
                return;
            }
            
            var _this = this;
            var mode = this.options.touchanimation,
                reset = [];
            
            this.$slider.find('> div').eq(0).swipe({
                tap: function(event, target) {
                    var act = _this.slideList.eq(_this._active).trigger('click');
                    if(typeof act.attr("onclick") != undefined){
                        event.preventDefault();
                        event.stopPropagation();
                    }
                },
                swipe: function (event, direction, distance, duration, fingerCount) {
                    if(_this._animating) return;
                    if(_this.options.touchanimation == 'horizontal'){
                        _this.__animateHorizontalTouch(direction);
                    }else if(_this.options.touchanimation == 'vertical'){
                        _this.__animateVerticalTouch(direction);
                    }
                },
                swipeStatus:function(event, phase, direction, distance, duration, fingers){
                    if(_this._animating) return;
                    var active = _this._active,
                        next = null;
                    
                    if(_this.options.touchanimation == 'horizontal'){
                        if(direction == 'left'){
                            next = active + 1;
                            if (next === _this.slideList.length) next = 0;
                            _this.slideList.eq(active).css('left', -distance);
                            _this.slideList.eq(next).css('left', _this.slideDimension.w-distance)/*.css('display', 'block')*/;
                        }else if(direction == 'right'){
                            next = active - 1;
                            if (next < 0) next = _this.slideList.length - 1;
                            _this.slideList.eq(active).css('left', distance);
                            _this.slideList.eq(next).css('left', -_this.slideDimension.w+distance)/*.css('display', 'block')*/;
                        }
                        
                        if(phase=="end"){
                            reset = [];
                            if(distance < 75){
                                _this.slideList.eq(active).css('left', 0);
                                if(next !== null) _this.slideList.eq(next).css('left', '-1000%');
                            }
                        }
                    }else if(_this.options.touchanimation == 'vertical'){
                        if(direction == 'up'){
                            next = active + 1;
                            if (next === _this.slideList.length) next = 0;
                            _this.slideList.eq(active).css('top', -distance);
                            _this.slideList.eq(next).css('top', _this.slideDimension.h-distance).css('left', '0')/*.css('display', 'block')*/;
                        }else if(direction == 'down'){
                            next = active - 1;
                            if (next < 0) next = _this.slideList.length - 1;
                            _this.slideList.eq(active).css('top', distance);
                            _this.slideList.eq(next).css('top', -_this.slideDimension.h+distance).css('left', '0')/*.css('display', 'block')*/;
                        }
                        
                        if(phase=="end"){
                            reset = [];
                            if(distance < 75){
                                _this.slideList.eq(active).css('top', 0);
                                if(next !== null) _this.slideList.eq(next).css('left', '-1000%')/*.css('display', 'none')*/;
                            }
                        }
                    }
                    if(next !== null && typeof reset[next] == 'undefined'){
                        _this.slideList.eq(next).trigger('ssanimatelayerssetinstart');
                        reset[next] = true;
                    }
                },
                fallbackToMouseEvents: false,
                allowPageScroll: (_this.options.touchanimation == 'horizontal' ? 'vertical' : 'horizontal')
            });
            
            if(typeof window.MSGesture !== 'undefined'){
                var gesture = new MSGesture(),
                    el = this.$slider.find('> div').get(0),
                    start = {
                        x: 0,
                        y: 0
                    };
                gesture.target = el;
                
                if (mode == 'horizontal') {
                    el.style['-ms-touch-action'] = 'pan-x';
                    el.style['-ms-scroll-chaining'] = 'none';
                    el.style['touch-action'] = 'pan-x';
                    el.style['scroll-chaining'] = 'none';
                } else if (mode == 'vertical') {
                    el.style['-ms-touch-action'] = 'pan-y';
                    el.style['-ms-scroll-chaining'] = 'none';
                    el.style['touch-action'] = 'pan-y';
                    el.style['scroll-chaining'] = 'none';
                }
                
                var eventType = '';
                if (window.navigator.pointerEnabled) {
                    eventType = "pointerdown";
                } else if (window.navigator.msPointerEnabled) {
                    eventType = "MSPointerDown";
                }
                if(eventType){
                    el.addEventListener(eventType, function (evt) {
                        gesture.addPointer(evt.pointerId);
                    });
                }
                    
                var hOffset = 10,
                    vOffset = 10;  
                
                el.addEventListener("MSGestureStart", function(e){
                    start.x = e.offsetX;
                    start.y = e.offsetY;
                });

                el.addEventListener("MSGestureEnd", function(e){ 
                    var zoom = document.documentElement.clientWidth / window.innerWidth;
                    if (mode == 'horizontal') {
                        if (start.x-hOffset >= e.offsetX) { 
                            _this.next();
                        } else if (start.x+hOffset <= e.offsetX) {
                            _this.previous();
                        }
                    } else if (mode == 'vertical') {
                        if (start.y-vOffset >= e.offsetY) { 
                            _this.next();
                        } else if (start.y+vOffset <= e.offsetY) {
                            _this.previous();
                        }
                    }
                });
            }
        },
        
        __animateHorizontalTouch: function(direction){
            var target = {left: 0},
                active = this._active,
                i = null;
            if(direction == 'left'){
                i = active + 1;
                if (i === this.slideList.length) i = 0;
                target = {left: -this.slideDimension.w};
                this.__animateTouch(i, active, 'left', target, {left: 0});
            }else if(direction == 'right'){
                i = active - 1;
                if (i < 0) i = this.slideList.length - 1;
                target = {left: this.slideDimension.w};
                this.__animateTouch(i, active, 'left', target, {left: 0});
            }
        },
        
        __animateVerticalTouch: function(direction){
            var target = 0,
                active = this._active,
                i = null;

            if(direction == 'up'){
                i = active + 1;
                if (i === this.slideList.length) i = 0;
                target = {top: -this.slideDimension.h};
                this.__animateTouch(i, active, 'top', target, {top: 0});
            }else if(direction == 'down'){
                i = active - 1;
                if (i < 0) i = this.slideList.length - 1;
                target = {top: this.slideDimension.h};
                this.__animateTouch(i, active, 'top', target, {top: 0});
            }
        },
        
        __animateTouch: function(i, lastActive, prop, target, targetActive){
            
            if (!this.options.syncAnimations) {
                if (this._lastActive != i) this.slideList.eq(this._lastActive).trigger('ssanimatestop');
                this.slideList.eq(this._active).trigger('ssanimatestop');
            }

            var _this = this;

            this.pauseAutoPlay(true);

            this._animating = true;
            
            this.changeBullet(i);
            if (this.options.syncAnimations) _this._runningAnimations++;

            this._nextActive = i;
            
            this.changeBullet(i);
            
            $(this).trigger('mainanimationstart');

            this._active = i;
            this._lastActive = lastActive;
            
            this._runningAnimations++;
            
            if (this.options.flux[0]) this.flux.showImage(i);
            
            this.slideList.eq(lastActive).animate(target,{
                duration: 300,
                complete: function(){
                    $(this).css(prop, 0).css('left', '-1000%');
                    _this.$this.trigger('mainanimationoutend');
                    _this.mainanimationended();
                }
            }).trigger('ssanimatelayersout');
            this.slideList.eq(i).animate(targetActive,{
                duration: 300,
                complete: function(){
                    $(this).trigger('ssanimatelayersin');
                    _this.$this.trigger('mainanimationinend');
                    _this.mainanimationended();
                }
            });
        },
        randomize: function(){
            var sl = this.$slider.find('.smart-slider-canvas'),
                flux = this.$slider.find('.nextend-flux'),
                fluximg = flux.find('img');
            var p = sl.parent();
            
            if(fluximg.length > 0){
                sl.each(function(i){
                    this._flux = fluximg[i];
                });
            }
            
            sl = this.shuffle(sl);
            
            sl.each(function(){
                p.append(this);
                flux.append(this._flux);
            });
            
            sl.filter('.'+this._parent.slideActive).removeClass(this._parent.slideActive);
            sl.eq(0).addClass(this._parent.slideActive);
        }
    });

})(njQuery, window);/**
 * @preserve Flux Slider v1.4.4
 * http://www.joelambert.co.uk/flux
 *
 * Copyright 2011, Joe Lambert.
 * Free to use under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 */

// Flux namespace
window.flux = {
    version: '1.4.4'
};

(function ($) {
    flux.slider = function (elem, opts) {
        // Setup the flux.browser singleton to perform feature detection
        flux.browser.init();

        if (!flux.browser.supportsTransitions) {
            if (window.console && window.console.error)
                console.error("Flux Slider requires a browser that supports CSS3 transitions");
        }

        var _this = this;

        this.element = $(elem);

        // Make a list of all available transitions
        this.transitions = [];
        for (var fx in flux.transitions)
            this.transitions.push(fx);

        this.options = $.extend({
            autoplay: false,
            transitions: this.transitions,
            delay: 4000,
            pagination: false,
            controls: false,
            captions: false,
            width: 600,
            height: 400,
            onTransitionEnd: null,
            currentImageIndex: 0,
            nextImageIndex: 1
        }, opts);

        // Set the height/width if given [EXPERIMENTAL!]
        this.height = this.options.height ? this.options.height : null;
        this.width = this.options.width ? this.options.width : null;

        var ua = navigator.userAgent.toLowerCase(),
            ios = (ua.match(/(ipad|iphone|ipod)/g) ? true : false),
            android = (ua.indexOf("android") > -1);
        // Filter out non compatible transitions
        var newTrans = [];
        $(this.options.transitions).each(function (index, tran) {
            var t = new flux.transitions[tran](this),
                compatible = true;

            if (t.options.requires3d && (!flux.browser.supports3d || ios || android))
                compatible = false;

            if (t.options.compatibilityCheck)
                compatible = t.options.compatibilityCheck();

            if (compatible)
                newTrans.push(tran);
        });

        if(newTrans.length == 0){
            newTrans[0] = ['dissolve'];
        }

        this.options.transitions = newTrans;

        this.images = new Array();
        this.imageLoadedCount = 0;
        this.currentImageIndex = this.options.currentImageIndex;
        this.nextImageIndex = this.options.nextImageIndex;
        this.playing = false;


        this.container = $('<div class="fluxslider"></div>').appendTo(this.element);

        this.surface = $('<div class="surface" style="position: relative"></div>').appendTo(this.container);

        // Listen for click events as we may want to follow a link
        this.container.bind('click', function (event) {
            if ($(event.target).hasClass('hasLink'))
                window.location = $(event.target).data('href');
        });

        this.imageContainer = $('<div class="images loading"></div>').css({
            'position': 'relative',
            /*'overflow': 'hidden',*/
            'min-height': '100px'
        }).appendTo(this.surface);

        this.image1img = $();
        this.image2img = $();

        // If the height/width is already set then resize the container
        if (this.width && this.height) {
            this.imageContainer.css({
                width: this.width + 'px',
                height: this.height + 'px'
            });
        }

        // Create the placeholders for the current and next image
        this.image1 = $('<div class="image1" style="height: 100%; width: 100%"></div>').appendTo(this.imageContainer);
        this.image2 = $('<div class="image2" style="height: 100%; width: 100%"></div>').appendTo(this.imageContainer);

        $(this.image1).add(this.image2).css({
            'position': 'absolute',
            'top': '0px',
            'left': '0px'
        });

        this.els = $([]);
        // Get a list of the images to use
        this.element.find('img, a img').each(function (index, found_img) {
            var imgClone = found_img.cloneNode(false),
                link = $(found_img).parent();

            // If this img is directly inside a link then save the link for later use
            if (link.is('a'))
                $(imgClone).data('href', link.attr('href'));

            _this.images.push(imgClone);

            _this.els.push(found_img);
        });

        // Load the images afterwards as IE seems to load images synchronously
        for (var i = 0; i < this.images.length; i++) {
            var image = new Image();
            image.onload = function () {
                _this.imageLoadedCount++;

                _this.width = _this.width ? _this.width : this.width;
                _this.height = _this.height ? _this.height : this.height;

                if (_this.imageLoadedCount >= _this.images.length) {
                    _this.finishedLoading();
                    _this.setupImages();
                }
            };

            // Load the image to ensure its cached by the browser
            image.src = this.images[i].src;
        }

        // Catch when a transition has finished
        this.element.bind('fluxTransitionEnd', function (event, data) {
            // If the slider is currently playing then set the timeout for the next transition
            // if(_this.isPlaying())
            // 	_this.start();

            // Are we using a callback instead of events for notifying about transition ends?
            if (_this.options.onTransitionEnd) {
                event.preventDefault();
                _this.options.onTransitionEnd(data);
            }
        });

        // Should we auto start the slider?
        if (this.options.autoplay)
            this.start();

        // Handle swipes
        this.element.bind('swipeLeft',function (event) {
            _this.next(null, {direction: 'left'});
        }).bind('swipeRight', function (event) {
                _this.prev(null, {direction: 'right'});
            });

        // Under FF7 autoplay breaks when the current tab loses focus
        setTimeout(function () {
            $(window).focus(function () {
                if (_this.isPlaying())
                    _this.next();
            });
        }, 100);
    };

    flux.slider.prototype = {
        constructor: flux.slider,
        playing: false,
        start: function () {
            var _this = this;
            this.playing = true;
            this.interval = setInterval(function () {
                _this.transition();
            }, this.options.delay);
        },
        stop: function () {
            this.playing = false;
            clearInterval(this.interval);
            this.interval = null;
        },
        isPlaying: function () {
            return this.playing;
            //return this.interval != null;
        },
        next: function (trans, opts) {
            opts = opts || {};
            opts.direction = 'left';
            this.showImage(this.currentImageIndex + 1, trans, opts);
        },
        prev: function (trans, opts) {
            opts = opts || {};
            opts.direction = 'right';
            this.showImage(this.currentImageIndex - 1, trans, opts);
        },
        showImage: function (index, trans, opts) {
            this.setNextIndex(index);

            // Temporarily stop the transition interval
            //clearInterval(this.interval);
            //this.interval = null;

            this.setupImages();
            this.transition(trans, opts);
        },
        finishedLoading: function () {
            var _this = this;

            this.container.css({
                width: '100%',
                height: '100%'
            });

            this.imageContainer.removeClass('loading');

            // Should we setup a pagination view?
            if (this.options.pagination) {
                // TODO: Attach to touch events if appropriate
                this.pagination = $('<ul class="pagination"></ul>').css({
                    margin: '-50px 0 0 0',
                    padding: '0px',
                    position: 'relative',
                    zIndex: '10000',
                    'text-align': 'center',
                    border: 0
                });

                this.pagination.bind('click', function (event) {
                    event.preventDefault();
                    _this.showImage($(event.target).data('index'));
                });

                $(this.images).each(function (index, image) {
                    var li = $('<li data-index="' + index + '">' + (index + 1) + '</li>').css({
                        display: 'inline-block',
                        'margin-left': '0.5em',
                        'cursor': 'pointer'
                    }).appendTo(_this.pagination);

                    if (index == 0)
                        li.css('margin-left', 0).addClass('current');
                });

                this.container.append(this.pagination);
            }

            // Resize
            $(this.imageContainer).css({
                width: this.width + 'px',
                height: this.height + 'px'
            });

            $(this.image1).css({
                width: this.width + 'px',
                height: this.height + 'px'
            });

            $(this.image2).css({
                width: this.width + 'px',
                height: this.height + 'px'
            });

            this.container.css({
                width: this.width + 'px',
                height: this.height + (this.options.pagination ? this.pagination.height() : 0) + 'px'
            });

            // Should we add prev/next controls?
            if (this.options.controls) {
                var css = {
                    padding: '4px 10px 10px',
                    'font-size': '60px',
                    'font-family': 'arial, sans-serif',
                    'line-height': '1em',
                    'font-weight': 'bold',
                    color: '#FFF',
                    'text-decoration': 'none',
                    background: 'rgba(0,0,0,0.5)',
                    position: 'absolute',
                    'z-index': 2000
                };

                this.nextButton = $('<a href="#">»</a>').css(css).css3({
                    'border-radius': '4px'
                }).appendTo(this.surface).bind('click', function (event) {
                        event.preventDefault();
                        _this.next();
                    });

                this.prevButton = $('<a href="#">«</a>').css(css).css3({
                    'border-radius': '4px'
                }).appendTo(this.surface).bind('click', function (event) {
                        event.preventDefault();
                        _this.prev();
                    });

                var top = (this.height - this.nextButton.height()) / 2;
                this.nextButton.css({
                    top: top + 'px',
                    right: '10px'
                });

                this.prevButton.css({
                    top: top + 'px',
                    left: '10px'
                });
            }

            // Should we use captions?
            if (this.options.captions) {
                this.captionBar = $('<div class="caption"></div>').css({
                    background: 'rgba(0,0,0,0.6)',
                    color: '#FFF',
                    'font-size': '16px',
                    'font-family': 'helvetica, arial, sans-serif',
                    'text-decoration': 'none',
                    'font-weight': 'bold',
                    padding: '1.5em 1em',
                    opacity: 0,
                    position: 'absolute',
                    'z-index': 110,
                    width: '100%',
                    bottom: 0
                }).css3({
                        'transition-property': 'opacity',
                        'transition-duration': '800ms',
                        'box-sizing': 'border-box'
                    }).prependTo(this.surface);
            }

            this.updateCaption();
            this.els.remove();
        },
        changeSize: function (w, h) {
            this.width = w;
            this.height = h;
            this.options.width = w;
            this.options.height = h;
            this.imageContainer.width(w).height(h);
            this.image1img.width(w);
            this.image2img.width(w);
            this.image1.width(w).height(h);
            this.image2.width(w).height(h);
        },
        setupImages: function () {
            var img1 = this.getImage(this.currentImageIndex),
                css1 = {
                    //'background-image': 'url("'+img1.src+'")',
                    'z-index': 101,
                    'cursor': 'auto'
                };
            if(typeof img1 == 'undefined') return false;

            // Does this image have an associated link?
            if ($(img1).data('href')) {
                css1.cursor = 'pointer';
                this.image1.addClass('hasLink');
                this.image1.data('href', $(img1).data('href'));
            }
            else {
                this.image1.removeClass('hasLink');
                this.image1.data('href', null);
            }

            this.image1.css(css1).children().remove();

            this.image1img = $('<img src="' + img1.src + '" />').css({
                width: this.width + 'px'
            });

            this.image1.append(this.image1img);

            this.image2.children().remove();
            this.image2img = $('<img src="' + this.getImage(this.nextImageIndex).src + '" />').css({
                width: this.width + 'px'
            });
            this.image2.append(this.image2img);
            this.image2.css({
                //'background-image': 'url("'+this.getImage(this.nextImageIndex).src+'")',
                'z-index': 100
            }).show();

            if (this.options.pagination && this.pagination) {
                this.pagination.find('li.current').removeClass('current');
                $(this.pagination.find('li')[this.currentImageIndex]).addClass('current');
            }
        },
        transition: function (transition, opts) {
            // Allow a transition to be picked from ALL available transitions (not just the reduced set)
            if (transition == undefined || !flux.transitions[transition]) {
                // Pick a transition at random from the (possibly reduced set of) transitions
                var index = Math.floor(Math.random() * (this.options.transitions.length));
                transition = this.options.transitions[index];
            }

            var tran = null;

            try {
                tran = new flux.transitions[transition](this, $.extend(this.options[transition] ? this.options[transition] : {}, opts));
            }
            catch (e) {
                // If an invalid transition has been provided then use the fallback (default is to just switch the image)
                tran = new flux.transition(this, {fallback: true});
            }

            tran.run();

            this.currentImageIndex = this.nextImageIndex;
            this.setNextIndex(this.currentImageIndex + 1);
            this.updateCaption();
        },
        updateCaption: function () {
            var str = $(this.getImage(this.currentImageIndex)).attr('title');
            if (this.options.captions && this.captionBar) {
                if (str !== "")
                    this.captionBar.html(str);

                this.captionBar.css('opacity', str === "" ? 0 : 1);
            }
        },
        getImage: function (index) {
            index = index % this.images.length;

            return this.images[index];
        },
        setNextIndex: function (nextIndex) {
            if (nextIndex == undefined)
                nextIndex = this.currentImageIndex + 1;

            this.nextImageIndex = nextIndex;

            if (this.nextImageIndex > this.images.length - 1)
                this.nextImageIndex = 0;

            if (this.nextImageIndex < 0)
                this.nextImageIndex = this.images.length - 1;
        },
        increment: function () {
            this.currentImageIndex++;
            if (this.currentImageIndex > this.images.length - 1)
                this.currentImageIndex = 0;
        }
    };
})(njQuery);

/**
 * Helper object to determine support for various CSS3 functions
 * @author Joe Lambert
 */

(function ($) {
    flux.browser = {
        init: function () {
            // Have we already been initialised?
            if (flux.browser.supportsTransitions !== undefined)
                return;

            var div = document.createElement('div'),
                prefixes = ['-webkit', '-moz', '-o', '-ms'],
                domPrefixes = ['Webkit', 'Moz', 'O', 'Ms'];

            // Does the current browser support CSS Transitions?
            if (window.nModernizr && nModernizr.csstransitions !== undefined)
                flux.browser.supportsTransitions = nModernizr.csstransitions;
            else {
                flux.browser.supportsTransitions = this.supportsCSSProperty('Transition');
            }

            // Does the current browser support 3D CSS Transforms?
            if (window.nModernizr && nModernizr.csstransforms3d !== undefined){
                flux.browser.supports3d = nModernizr.csstransforms3d;
                flux.browser.supportspreserve3d = nModernizr.transformstylepreserve3d;
                if(!flux.browser.supportspreserve3d) flux.browser.supports3d = false;
            }else {
                // Custom detection when Modernizr isn't available
                flux.browser.supports3d = this.supportsCSSProperty("Perspective");

                if (flux.browser.supports3d && 'webkitPerspective' in $('body').get(0).style) {
                    // Double check with a media query (similar to how Modernizr does this)
                    var div3D = $('<div id="csstransform3d"></div>');
                    var mq = $('<style media="(transform-3d), (' + prefixes.join('-transform-3d),(') + '-transform-3d)">div#csstransform3d { position: absolute; left: 9px }</style>');

                    $('body').append(div3D);
                    $('head').append(mq);

                    flux.browser.supports3d = div3D.get(0).offsetLeft == 9;

                    div3D.remove();
                    mq.remove();
                }
            }

        },
        supportsCSSProperty: function (prop) {
            var div = document.createElement('div'),
                prefixes = ['-webkit', '-moz', '-o', '-ms'],
                domPrefixes = ['Webkit', 'Moz', 'O', 'Ms'];

            var support = false;
            for (var i = 0; i < domPrefixes.length; i++) {
                if (domPrefixes[i] + prop in div.style)
                    support = support || true;
            }

            return support;
        },
        translate: function (x, y, z) {
            x = (x != undefined) ? x : 0;
            y = (y != undefined) ? y : 0;
            z = (z != undefined) ? z : 0;

            return 'translate' + (flux.browser.supports3d ? '3d(' : '(') + x + 'px,' + y + (flux.browser.supports3d ? 'px,' + z + 'px)' : 'px)');
        },

        rotateX: function (deg) {
            return flux.browser.rotate('x', deg);
        },

        rotateY: function (deg) {
            return flux.browser.rotate('y', deg);
        },

        rotateZ: function (deg) {
            return flux.browser.rotate('z', deg);
        },

        rotate: function (axis, deg) {
            if (!axis in {'x': '', 'y': '', 'z': ''})
                axis = 'z';

            deg = (deg != undefined) ? deg : 0;

            if (flux.browser.supports3d)
                return 'rotate3d(' + (axis == 'x' ? '1' : '0') + ', ' + (axis == 'y' ? '1' : '0') + ', ' + (axis == 'z' ? '1' : '0') + ', ' + deg + 'deg)';
            else {
                if (axis == 'z')
                    return 'rotate(' + deg + 'deg)';
                else
                    return '';
            }
        }
    };

    $(function () {
        // To continue to work with legacy code, ensure that flux.browser is initialised on document ready at the latest
        flux.browser.init();
    });
})(njQuery);

(function ($) {
    /**
     * Helper function for cross-browser CSS3 support, prepends all possible prefixes to all properties passed in
     * @param {Object} props Ker/value pairs of CSS3 properties
     */
    $.fn.css3 = function (props) {
        var css = {};
        var prefixes = ['webkit', 'moz', 'ms', 'o'];

        for (var prop in props) {
            // Add the vendor specific versions
            for (var i = 0; i < prefixes.length; i++)
                css['-' + prefixes[i] + '-' + prop] = props[prop];

            // Add the actual version
            css[prop] = props[prop];
        }

        this.css(css);
        return this;
    };

    /**
     * Helper function to bind to the correct transition end event
     * @param {function} callback The function to call when the event fires
     */
    $.fn.transitionEnd = function (callback) {
        var _this = this;

        var events = ['webkitTransitionEnd', 'transitionend', 'oTransitionEnd'];

        for (var i = 0; i < events.length; i++) {
            this.bind(events[i], function (event) {
                // Automatically stop listening for the event
                for (var j = 0; j < events.length; j++)
                    $(this).unbind(events[j]);

                // Perform the callback function
                if (callback)
                    callback.call(this, event);
            });
        }

        return this;
    };

    flux.transition = function (fluxslider, opts) {
        this.options = $.extend({
            requires3d: false,
            after: function () {
                // Default callback for after the transition has completed
            }
        }, opts);

        this.slider = fluxslider;

        // We need to ensure transitions degrade gracefully if the transition is unsupported or not loaded
        if ((this.options.requires3d && !flux.browser.supports3d) || !flux.browser.supportsTransitions || this.options.fallback === true) {
            var _this = this;

            this.options.after = undefined;

            this.options.setup = function () {
                //console.error("Fallback setup()");
                _this.fallbackSetup();
            };

            this.options.execute = function () {
                //console.error("Fallback execute()");
                _this.fallbackExecute();
            };
        }
    };

    flux.transition.prototype = {
        constructor: flux.transition,
        hasFinished: false, // This is a lock to ensure that the fluxTransitionEnd event is only fired once per tansition
        run: function () {
            var _this = this;

            // do something
            if (this.options.setup !== undefined)
                this.options.setup.call(this);

            // Remove the background image from the top image
            this.slider.image1.css({
                'background-image': 'none'
            });

            this.slider.imageContainer.css('overflow', this.options.requires3d ? 'visible' : 'hidden');

            // For some of the 3D effects using Zepto we need to delay the transitions for some reason
            setTimeout(function () {
                if (_this.options.execute !== undefined)
                    _this.options.execute.call(_this);
            }, 5);
        },
        finished: function () {
            if (this.hasFinished)
                return;

            this.hasFinished = true;

            if (this.options.after)
                this.options.after.call(this);

            this.slider.imageContainer.css('overflow', 'hidden');

            this.slider.setupImages();

            // Trigger an event to signal the end of a transition
            this.slider.element.trigger('fluxTransitionEnd', {
                currentImage: this.slider.getImage(this.slider.currentImageIndex)
            });
        },
        fallbackSetup: function () {

        },
        fallbackExecute: function () {
            this.finished();
        }
    };

    flux.transitions = {};

    // Flux grid transition

    flux.transition_grid = function (fluxslider, opts) {
        return new flux.transition(fluxslider, $.extend({
            columns: 6,
            rows: 6,
            forceSquare: false,
            setup: function () {
                var imgWidth = this.slider.image1.width(),
                    imgHeight = this.slider.image1.height();

                var colWidth = Math.floor(imgWidth / this.options.columns),
                    rowHeight = Math.floor(imgHeight / this.options.rows);

                if (this.options.forceSquare) {
                    rowHeight = colWidth;
                    this.options.rows = Math.floor(imgHeight / rowHeight);
                }
                if(this.options.rows < 1) this.options.rows = 1;

                // Work out how much space remains with the adjusted barWidth
                var colRemainder = imgWidth - (this.options.columns * colWidth),
                    colAddPerLoop = Math.ceil(colRemainder / this.options.columns),

                    rowRemainder = imgHeight - (this.options.rows * rowHeight),
                    rowAddPerLoop = Math.ceil(rowRemainder / this.options.rows),

                    delayBetweenBars = 150,
                    height = this.slider.image1.height(),
                    totalLeft = 0,
                    totalTop = 0,
                    fragment = document.createDocumentFragment();

                for (var i = 0; i < this.options.columns; i++) {
                    var thisColWidth = colWidth,
                        totalTop = 0;

                    if (colRemainder > 0) {
                        var add = colRemainder >= colAddPerLoop ? colAddPerLoop : colRemainder;
                        thisColWidth += add;
                        colRemainder -= add;
                    }

                    for (var j = 0; j < this.options.rows; j++) {
                        var thisRowHeight = rowHeight,
                            thisRowRemainder = rowRemainder;

                        if (thisRowRemainder > 0) {
                            var add = thisRowRemainder >= rowAddPerLoop ? rowAddPerLoop : thisRowRemainder;
                            thisRowHeight += add;
                            thisRowRemainder -= add;
                        }

                        var tile = $('<div class="tile tile-' + i + '-' + j + '"></div>').css({
                            width: thisColWidth + 'px',
                            height: thisRowHeight + 'px',
                            position: 'absolute',
                            top: totalTop + 'px',
                            left: totalLeft + 'px'
                        });

                        this.options.renderTile.call(this, tile, i, j, thisColWidth, thisRowHeight, totalLeft, totalTop);

                        fragment.appendChild(tile.get(0));

                        totalTop += thisRowHeight;
                    }

                    totalLeft += thisColWidth;
                }

                // Append the fragement to the surface
                this.slider.image1.get(0).appendChild(fragment);

                this.slider.image1.find('>img').remove();
                //this.slider.image2.find('>img').remove();

            },
            execute: function () {
                var _this = this,
                    height = this.slider.image1.height(),
                    bars = this.slider.image1.find('div.barcontainer');

                this.slider.image2.hide();

                // Get notified when the last transition has completed
                bars.last().transitionEnd(function (event) {
                    _this.slider.image2.show();

                    _this.finished();
                });
                bars.css3({
                    'transform': flux.browser.rotateX(-90) + ' ' + flux.browser.translate(0, height / 2, height / 2)
                });
            },
            renderTile: function (elem, colIndex, rowIndex, colWidth, rowHeight, leftOffset, topOffset) {

            }
        }, opts));
    };
})(njQuery);

(function ($) {
    flux.transitions.bars = function (fluxslider, opts) {
        return new flux.transition_grid(fluxslider, $.extend({
            columns: 10,
            rows: 1,
            delayBetweenBars: 40,
            renderTile: function (elem, colIndex, rowIndex, colWidth, rowHeight, leftOffset, topOffset) {
                var $el = $(elem),
                    img = this.slider.image1.children().clone();
                img.css({
                    'position': 'absolute',
                    'top': 0,
                    'left': -leftOffset
                });
                $el.css('overflow', 'hidden').append(img)
                    .css3({
                        'transition-duration': '400ms',
                        'transition-timing-function': 'ease-in',
                        'transition-property': 'all',
                        'transition-delay': (colIndex * this.options.delayBetweenBars) + 'ms'
                    });
            },
            execute: function () {
                var _this = this;


                var height = this.slider.image1.height();

                var bars = this.slider.image1.find('div.tile');

                // Get notified when the last transition has completed
                $(bars[bars.length - 1]).transitionEnd(function () {
                    _this.finished();
                });

                setTimeout(function () {
                    bars.css({
                        'opacity': '0.5'
                    }).css3({
                            'transform': flux.browser.translate(0, height)
                        });
                }, 50);

            }
        }, opts));
    };
})(njQuery);

(function ($) {
    flux.transitions.bars3d = function (fluxslider, opts) {
        return new flux.transition_grid(fluxslider, $.extend({
            requires3d: true,
            columns: 7,
            rows: 1,
            delayBetweenBars: 450,
            perspective: 1000,
            renderTile: function (elem, colIndex, rowIndex, colWidth, rowHeight, leftOffset, topOffset) {

                var img = this.slider.image1.children().clone();
                img.css({
                    'position': 'absolute',
                    'top': 0,
                    'left': -leftOffset
                });

                var bar = $('<div class="bar-' + colIndex + '"></div>').append(img).css({
                        width: colWidth + 'px',
                        height: '100%',
                        position: 'absolute',
                        top: '0px',
                        left: '0px',
                        'z-index': 200,
                        overflow: 'hidden'

                        //'background-image': this.slider.image1.css('background-image'),
                        //'background-position': '-'+leftOffset+'px 0px',
                        //'background-repeat': 'no-repeat'
                    }).css3({
                            'backface-visibility': 'hidden'
                        }),

                    img2 = this.slider.image2.children().clone(),
                    bar2 = $(bar.get(0).cloneNode(false))/*.css({
                     'background-image': 'url('+img2[0].src+')'
                     })*/.css3({
                            'transform': flux.browser.rotateX(90) + ' ' + flux.browser.translate(0, -rowHeight / 2, rowHeight / 2)
                        }),
                    left = $('<div class="side bar-' + colIndex + '"></div>').css({
                        width: rowHeight + 'px',
                        height: rowHeight + 'px',
                        position: 'absolute',
                        top: '0px',
                        left: '0px',
                        background: '#222',
                        'z-index': 190/*,
                         overflow: 'hidden'*/
                    }).css3({
                            'transform': 'rotateY(-90deg) ' + flux.browser.translate(-rowHeight / 2, 0, rowHeight / 2),
                            'backface-visibility': 'hidden',
                            'transform-style': 'preserve-3d'
                        }),

                    right = $(left.get(0).cloneNode(false)).css3({
                        'transform': flux.browser.rotateY(90) + ' ' + flux.browser.translate(rowHeight / 2, 0, colWidth - rowHeight / 2)
                    });
                $(elem).css({
                    width: colWidth + 'px',
                    height: '100%',
                    position: 'absolute',
                    top: '0px',
                    left: leftOffset + 'px',
                    'z-index': colIndex > this.options.columns / 2 ? 1000 - colIndex : 1000 // Fix for Chrome to ensure that the z-index layering is correct!
                }).css3({
                        'transition-duration': '800ms',
                        'transition-timing-function': 'linear',
                        'transition-property': 'all',
                        'transition-delay': (colIndex * this.options.delayBetweenBars) + 'ms',
                        'transform-style': 'preserve-3d'
                    }).append(bar).append(bar2.append(img2.css({
                        'position': 'absolute',
                        'top': 0,
                        'left': -leftOffset
                    }))).append(right).append(left);
            },
            execute: function () {
                this.slider.image1.css3({
                    'perspective': this.options.perspective,
                    'perspective-origin': '50% 50%'
                }).css({
                        '-moz-transform': 'perspective(' + this.options.perspective + 'px)',
                        '-moz-perspective': 'none',
                        '-moz-transform-style': 'preserve-3d'
                    });

                var _this = this,
                    height = this.slider.image1.height(),
                    bars = this.slider.image1.find('div.tile');

                this.slider.image2.hide();

                // Get notified when the last transition has completed
                bars.last().transitionEnd(function (event) {
                    _this.slider.image1.css3({
                        'transform-style': 'flat'
                    });

                    _this.slider.image2.show();

                    _this.finished();
                });

                setTimeout(function () {
                    bars.css3({
                        'transform': flux.browser.rotateX(-90) + ' ' + flux.browser.translate(0, height / 2, height / 2)
                    });
                }, 50);
            }
        }, opts));
    };
})(njQuery);

(function ($) {
    flux.transitions.blinds = function (fluxslider, opts) {
        return new flux.transitions.bars(fluxslider, $.extend({
            execute: function () {
                var _this = this;

                var height = this.slider.image1.height();

                var bars = this.slider.image1.find('div.tile');

                // Get notified when the last transition has completed
                $(bars[bars.length - 1]).transitionEnd(function () {
                    _this.finished();
                });

                setTimeout(function () {
                    bars.css({
                        'opacity': '0.5'
                    }).css3({
                            'transform': 'scalex(0)' // 0.0001
                        });
                }, 50);
            }
        }, opts));
    }
})(njQuery);

(function ($) {
    flux.transitions.blinds3d = function (fluxslider, opts) {
        return new flux.transitions.tiles3d(fluxslider, $.extend({
            forceSquare: false,
            rows: 1,
            columns: 6
        }, opts));
    };
})(njQuery);

(function ($) {
    flux.transitions.zip = function (fluxslider, opts) {
        return new flux.transitions.bars(fluxslider, $.extend({
            execute: function () {
                var _this = this;

                var height = this.slider.image1.height();

                var bars = this.slider.image1.find('div.tile');

                // Get notified when the last transition has completed
                $(bars[bars.length - 1]).transitionEnd(function () {
                    _this.finished();
                });

                setTimeout(function () {
                    bars.each(function (index, bar) {
                        $(bar).css({
                            'opacity': '0.3'
                        }).css3({
                                'transform': flux.browser.translate(0, (index % 2 ? '-' + (2 * height) : height))
                            });
                    });
                }, 20);
            }
        }, opts));
    };
})(njQuery);

(function ($) {
    flux.transitions.blocks = function (fluxslider, opts) {
        return new flux.transition_grid(fluxslider, $.extend({
            forceSquare: true,
            delayBetweenBars: 100,
            renderTile: function (elem, colIndex, rowIndex, colWidth, rowHeight, leftOffset, topOffset) {
                var delay = Math.floor(Math.random() * 10 * this.options.delayBetweenBars);
                var img = this.slider.image1.children().clone();
                img.css({
                    'position': 'absolute',
                    'top': -topOffset,
                    'left': -leftOffset
                });
                $(elem).append(img).css({
                    /*'background-image': this.slider.image1.css('background-image'),
                     'background-position': '-'+leftOffset+'px -'+topOffset+'px'*/
                    overflow: 'hidden'
                }).css3({
                        'transition-duration': '350ms',
                        'transition-timing-function': 'ease-in',
                        'transition-property': 'all',
                        'transition-delay': delay + 'ms'
                    });

                // Keep track of the last elem to fire
                if (this.maxDelay === undefined)
                    this.maxDelay = 0;

                if (delay > this.maxDelay) {
                    this.maxDelay = delay;
                    this.maxDelayTile = elem;
                }
            },
            execute: function () {
                var _this = this;

                var blocks = this.slider.image1.find('div.tile');

                // Get notified when the last transition has completed
                this.maxDelayTile.transitionEnd(function () {
                    _this.finished();
                });

                setTimeout(function () {
                    blocks.each(function (index, block) {
                        $(block).css({
                            'opacity': '0'
                        }).css3({
                                'transform': 'scale(0.8)'
                            });
                    });
                }, 50);
            }
        }, opts));
    };
})(njQuery);

(function ($) {
    flux.transitions.blocks2 = function (fluxslider, opts) {
        return new flux.transition_grid(fluxslider, $.extend({
            cols: 12,
            forceSquare: true,
            delayBetweenDiagnols: 150,
            renderTile: function (elem, colIndex, rowIndex, colWidth, rowHeight, leftOffset, topOffset) {
                var delay = Math.floor(Math.random() * 10 * this.options.delayBetweenBars);
                var img = this.slider.image1.children().clone();
                img.css({
                    'position': 'absolute',
                    'top': -topOffset,
                    'left': -leftOffset
                });

                $(elem).append(img).css({
                    /*'background-image': this.slider.image1.css('background-image'),
                     'background-position': '-'+leftOffset+'px -'+topOffset+'px'*/
                    overflow: 'hidden'
                }).css3({
                        'transition-duration': '350ms',
                        'transition-timing-function': 'ease-in',
                        'transition-property': 'all',
                        'transition-delay': (colIndex + rowIndex) * this.options.delayBetweenDiagnols + 'ms',
                        'backface-visibility': 'hidden' // trigger hardware acceleration
                    });
            },
            execute: function () {
                var _this = this;

                var blocks = this.slider.image1.find('div.tile');

                // Get notified when the last transition has completed
                blocks.last().transitionEnd(function () {
                    _this.finished();
                });

                setTimeout(function () {
                    blocks.each(function (index, block) {
                        $(block).css({
                            'opacity': '0'
                        }).css3({
                                'transform': 'scale(0.8)'
                            });
                    });
                }, 50);
            }
        }, opts));
    };
})(njQuery);

(function ($) {
    flux.transitions.concentric = function (fluxslider, opts) {
        return new flux.transition(fluxslider, $.extend({
            blockSize: 60,
            delay: 150,
            alternate: false,
            setup: function () {
                var w = this.slider.image1.width(),
                    h = this.slider.image1.height(),
                    largestLength = Math.sqrt(w * w + h * h), // Largest length is the diagonal

                // How many blocks do we need?
                    blockCount = Math.ceil(((largestLength - this.options.blockSize) / 2) / this.options.blockSize) + 1, // 1 extra to account for the round border
                    fragment = document.createDocumentFragment();

                for (var i = 0; i < blockCount; i++) {
                    var thisBlockSize = (2 * i * this.options.blockSize) + this.options.blockSize;

                    var img = this.slider.image1.children().clone();
                    img.css({
                        'position': 'absolute',
                        'top': -(h - thisBlockSize) / 2,
                        'left': -(w - thisBlockSize) / 2
                    });

                    var block = $('<div></div>').attr('class', 'block block-' + i).append(img).css({
                        width: thisBlockSize + 'px',
                        height: thisBlockSize + 'px',
                        position: 'absolute',
                        top: ((h - thisBlockSize) / 2) + 'px',
                        left: ((w - thisBlockSize) / 2) + 'px',
                        overflow: 'hidden',

                        'z-index': 100 + (blockCount - i),
                        /*
                         'background-image': this.slider.image1.css('background-image'),
                         'background-position': 'center center'*/
                    }).css3({
                            'border-radius': thisBlockSize + 'px',
                            'transition-duration': '800ms',
                            'transition-timing-function': 'linear',
                            'transition-property': 'all',
                            'transition-delay': ((blockCount - i) * this.options.delay) + 'ms'
                        });

                    fragment.appendChild(block.get(0));
                }
                this.slider.image1.find('>img').remove();
                //this.slider.image1.append($(fragment));
                this.slider.image1.get(0).appendChild(fragment);
            },
            execute: function () {
                var _this = this;

                var blocks = this.slider.image1.find('div.block');

                // Get notified when the last transition has completed
                $(blocks[0]).transitionEnd(function () {
                    _this.finished();
                });

                setTimeout(function () {
                    blocks.each(function (index, block) {
                        $(block).css({
                            'opacity': '0'
                        }).css3({
                                'transform': flux.browser.rotateZ((!_this.options.alternate || index % 2 ? '' : '-') + '90')
                            });
                    });
                }, 50);
            }
        }, opts));
    };
})(njQuery);

(function ($) {
    flux.transitions.warp = function (fluxslider, opts) {
        return new flux.transitions.concentric(fluxslider, $.extend({
            delay: 30,
            alternate: true
        }, opts));
    };
})(njQuery);

(function ($) {
    flux.transitions.cube = function (fluxslider, opts) {
        return new flux.transition(fluxslider, $.extend({
            requires3d: true,
            barWidth: 100,
            direction: 'left',
            perspective: 1000,
            setup: function () {
                var width = this.slider.image1.width();
                var height = this.slider.image1.height();

                // Setup the container to allow 3D perspective

                this.slider.image1.css3({
                    'perspective': this.options.perspective,
                    'perspective-origin': '50% 50%'
                });

                this.cubeContainer = $('<div class="cube"></div>').css({
                    width: width + 'px',
                    height: height + 'px',
                    position: 'relative'
                }).css3({
                        'transition-duration': '800ms',
                        'transition-timing-function': 'linear',
                        'transition-property': 'all',
                        'transform-style': 'preserve-3d'
                    });

                var css = {
                    height: '100%',
                    width: '100%',
                    position: 'absolute',
                    top: '0px',
                    left: '0px',
                    overflow: 'hidden'
                };

                var img = this.slider.image1.children().clone();
                img.css({
                    'position': 'absolute',
                    'top': 0,
                    'left': 0
                });
                var currentFace = $('<div class="face current"></div>').append(img).css(css).css3({
                    'backface-visibility': 'hidden'
                });

                this.cubeContainer.append(currentFace);
                this.slider.image1.find('>img').remove();

                var img2 = this.slider.image2.children().clone();
                img2.css({
                    'position': 'absolute',
                    'top': 0,
                    'left': 0
                });

                var nextFace = $('<div class="face next"></div>').append(img2).css(css).css3({
                    'transform': this.options.transitionStrings.call(this, this.options.direction, 'nextFace'),
                    'backface-visibility': 'hidden'
                });

                this.cubeContainer.append(nextFace);

                this.slider.image1.append(this.cubeContainer);
            },
            execute: function () {
                var _this = this;

                var width = this.slider.image1.width();
                var height = this.slider.image1.height();

                this.slider.image2.hide();
                this.cubeContainer.transitionEnd(function () {
                    _this.slider.image2.show();

                    _this.finished();
                });

                setTimeout(function () {
                    _this.cubeContainer.css3({
                        'transform': _this.options.transitionStrings.call(_this, _this.options.direction, 'container')
                    });
                }, 50);
            },
            transitionStrings: function (direction, elem) {
                var width = this.slider.image1.width();
                var height = this.slider.image1.height();

                // Define the various transforms that are required to perform various cube rotations
                var t = {
                    'up': {
                        'nextFace': flux.browser.rotateX(-90) + ' ' + flux.browser.translate(0, height / 2, height / 2),
                        'container': flux.browser.rotateX(90) + ' ' + flux.browser.translate(0, -height / 2, height / 2)
                    },
                    'down': {
                        'nextFace': flux.browser.rotateX(90) + ' ' + flux.browser.translate(0, -height / 2, height / 2),
                        'container': flux.browser.rotateX(-90) + ' ' + flux.browser.translate(0, height / 2, height / 2)
                    },
                    'left': {
                        'nextFace': flux.browser.rotateY(90) + ' ' + flux.browser.translate(width / 2, 0, width / 2),
                        'container': flux.browser.rotateY(-90) + ' ' + flux.browser.translate(-width / 2, 0, width / 2)
                    },
                    'right': {
                        'nextFace': flux.browser.rotateY(-90) + ' ' + flux.browser.translate(-width / 2, 0, width / 2),
                        'container': flux.browser.rotateY(90) + ' ' + flux.browser.translate(width / 2, 0, width / 2)
                    }
                };

                return (t[direction] && t[direction][elem]) ? t[direction][elem] : false;
            }
        }, opts));
    };
})(njQuery);

(function ($) {
    flux.transitions.tiles3d = function (fluxslider, opts) {
        return new flux.transition_grid(fluxslider, $.extend({
            requires3d: true,
            forceSquare: true,
            columns: 5,
            perspective: 600,
            delayBetweenBarsX: 200,
            delayBetweenBarsY: 150,
            renderTile: function (elem, colIndex, rowIndex, colWidth, rowHeight, leftOffset, topOffset) {

                var img = this.slider.image1.children().clone();
                img.css({
                    'position': 'absolute',
                    'top': -topOffset,
                    'left': -leftOffset
                }),
                    tile = $('<div></div>').css({
                        width: colWidth + 'px',
                        height: rowHeight + 'px',
                        position: 'absolute',
                        top: '0px',
                        left: '0px',
                        //'z-index': 200, // Removed to make compatible with FF10 (Chrome bug seems to have been fixed)
                        /*
                         'background-image': this.slider.image1.css('background-image'),
                         'background-position': '-'+leftOffset+'px -'+topOffset+'px',
                         'background-repeat': 'no-repeat',*/
                        overflow: 'hidden',
                        '-webkit-transform': 'translateZ(0.1px)'
                    }).css3({
                            'backface-visibility': 'hidden'
                        });

                var img2 = this.slider.image2.children().clone();
                img2.css({
                    'position': 'absolute',
                    'top': -topOffset,
                    'left': -leftOffset
                }),
                    tile2 = $(tile.get(0).cloneNode(false)).append(img2)/*.css({
                     'background-image': this.slider.image2.css('background-image')
                     //'z-index': 190 // Removed to make compatible with FF10 (Chrome bug seems to have been fixed)
                     })*/.css3({
                            'transform': flux.browser.rotateY(180),
                            'backface-visibility': 'hidden'
                        });

                tile.append(img);

                $(elem).css({
                    'z-index': (colIndex > this.options.columns / 2 ? 500 - colIndex : 500) + (rowIndex > this.options.rows / 2 ? 500 - rowIndex : 500) // Fix for Chrome to ensure that the z-index layering is correct!
                }).css3({
                        'transition-duration': '800ms',
                        'transition-timing-function': 'ease-out',
                        'transition-property': 'all',
                        'transition-delay': (colIndex * this.options.delayBetweenBarsX + rowIndex * this.options.delayBetweenBarsY) + 'ms',
                        'transform-style': 'preserve-3d'
                    }).append(tile).append(tile2);
            },
            execute: function () {
                this.slider.image1.css3({
                    'perspective': this.options.perspective,
                    'perspective-origin': '50% 50%'
                });

                var _this = this;

                var tiles = this.slider.image1.find('div.tile');

                this.slider.image2.hide();

                // Get notified when the last transition has completed
                tiles.last().transitionEnd(function (event) {
                    _this.slider.image2.show();

                    _this.finished();
                });

                setTimeout(function () {
                    tiles.css3({
                        'transform': flux.browser.rotateY(180)
                    });
                }, 50);
            }
        }, opts));
    };
})(njQuery);

(function ($) {
    flux.transitions.turn = function (fluxslider, opts) {
        return new flux.transition(fluxslider, $.extend({
            requires3d: true,
            perspective: 1300,
            direction: 'left',
            setup: function () {

                var h = fluxslider.height,
                    h2 = h / 2,
                    w = fluxslider.width,
                    w2 = w / 2;
                var img = this.slider.image1.children().clone();
                img.css({
                    'position': 'absolute',
                    'top': 0,
                    'left': (this.options.direction == 'left' ? -1 * (this.slider.image1.width() / 2) : 0)
                }),
                    img2 = this.slider.image2.children().clone();
                img2.css({
                    'position': 'absolute',
                    'top': 0,
                    'left': (this.options.direction == 'left' ? 0 : -1 * (this.slider.image1.width() / 2))
                }),
                    img12 = img.clone();
                var tab = $('<div class="tab"></div>').css({
                        width: w2,
                        height: h,
                        position: 'absolute',
                        top: '0px',
                        left: this.options.direction == 'left' ? w2 : '0',
                        'z-index': 101
                    }).css3({
                            'transform-style': 'preserve-3d',
                            'transition-duration': '1000ms',
                            'transition-timing-function': 'ease-out',
                            'transition-property': 'all',
                            'transform-origin': this.options.direction == 'left' ? 'left center' : 'right center'
                        }),

                    front = $('<div></div>').append(img).appendTo(tab).css({
                        /*'background-image': this.slider.image1.css('background-image'),
                         'background-position': (this.options.direction == 'left' ? '-'+(this.slider.image1.width()/2) : 0)+'px 0',*/
                        width: w,
                        height: h,
                        position: 'absolute',
                        top: '0',
                        left: '0',
                        '-webkit-transform': 'translateZ(0.1px)',
                        overflow: 'hidden'
                    }).css3({
                            'backface-visibility': 'hidden'
                        }),

                    back = $('<div></div>').append(img2).appendTo(tab).css({
                        /*'background-image': this.slider.image2.css('background-image'),
                         'background-position': (this.options.direction == 'left' ? 0 : '-'+(this.slider.image1.width()/2))+'px 0',*/
                        width: w / 2,
                        height: h,
                        position: 'absolute',
                        top: '0',
                        left: '0',
                        overflow: 'hidden'
                    }).css3({
                            transform: flux.browser.rotateY(180),
                            'backface-visibility': 'hidden'
                        }),

                    current = $('<div></div>').append(img12.css('left', (this.options.direction == 'left' ? 0 : '-' + (this.slider.image1.width() / 2)))).css({
                        position: 'absolute',
                        top: '0',
                        left: this.options.direction == 'left' ? '0' : w2,
                        width: w2,
                        height: h,
                        /*'background-image': this.slider.image1.css('background-image'),
                         'background-position': (this.options.direction == 'left' ? 0 : '-'+(this.slider.image1.width()/2))+'px 0',*/
                        'z-index': 100,
                        overflow: 'hidden'
                    }),

                    overlay = $('<div class="overlay"></div>').css({
                        position: 'absolute',
                        top: '0',
                        left: this.options.direction == 'left' ? w2 : '0',
                        width: w2,
                        height: h,
                        background: '#000',
                        opacity: 1,
                        overflow: 'hidden'
                    }).css3({
                            'transition-duration': '800ms',
                            'transition-timing-function': 'linear',
                            'transition-property': 'opacity'
                        }),

                    container = $('<div></div>').css({
                        width: w,
                        height: h,
                        position: 'absolute',
                        top: 0,
                        left: 0
                    }).css3({
                            'perspective': this.options.perspective,
                            'perspective-origin': '50% 50%'
                        }).append(tab).append(current).append(overlay);

                this.slider.image1.find('>img').remove();
                this.slider.image1.append(container);
            },
            execute: function () {
                var _this = this;

                this.slider.image1.find('div.tab').first().transitionEnd(function () {
                    _this.finished();
                });

                setTimeout(function () {
                    _this.slider.image1.find('div.tab').css3({
                        // 179 not 180 so that the tab rotates the correct way in Firefox
                        transform: flux.browser.rotateY(_this.options.direction == 'left' ? -179 : 179)
                    });
                    _this.slider.image1.find('div.overlay').css({
                        opacity: 0
                    });
                }, 50);
            }
        }, opts));
    };
})(njQuery);

(function ($) {
    flux.transitions.dissolve = function (fluxslider, opts) {
        return new flux.transition(fluxslider, $.extend({
            setup: function () {

                var img1 = this.slider.image1.children().clone(),
                    img = $('<div class="image"></div>').append(img1).css({
                    width: '100%',
                    height: '100%'
                }).css3({
                        'transition-duration': '600ms',
                        'transition-timing-function': 'ease-in',
                        'transition-property': 'opacity'
                    });

                this.slider.image1.append(img);
            },
            execute: function () {
                var _this = this,
                    img = this.slider.image1.find('div.image');

                // Get notified when the last transition has completed
                $(img).transitionEnd(function () {
                    _this.finished();
                });
                this.slider.image1.find('>img').remove();

                setTimeout(function () {
                    $(img).css({
                        'opacity': '0.0'
                    });
                }, 50);
            }
        }, opts));
    };
})(njQuery);
var tmpModernizr = null;
if(typeof window.Modernizr !== "undefined" ) tmpModernizr = window.Modernizr;

;window.Modernizr=function(a,b,c){function z(a){j.cssText=a}function A(a,b){return z(m.join(a+";")+(b||""))}function B(a,b){return typeof a===b}function C(a,b){return!!~(""+a).indexOf(b)}function D(a,b){for(var d in a){var e=a[d];if(!C(e,"-")&&j[e]!==c)return b=="pfx"?e:!0}return!1}function E(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:B(f,"function")?f.bind(d||b):f}return!1}function F(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+o.join(d+" ")+d).split(" ");return B(b,"string")||B(b,"undefined")?D(e,b):(e=(a+" "+p.join(d+" ")+d).split(" "),E(e,b,c))}var d="2.6.2",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l={}.toString,m=" -webkit- -moz- -o- -ms- ".split(" "),n="Webkit Moz O ms",o=n.split(" "),p=n.toLowerCase().split(" "),q={},r={},s={},t=[],u=t.slice,v,w=function(a,c,d,e){var f,i,j,k,l=b.createElement("div"),m=b.body,n=m||b.createElement("body");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:h+(d+1),l.appendChild(j);return f=["&#173;",'<style id="s',h,'">',a,"</style>"].join(""),l.id=h,(m?l:n).innerHTML+=f,n.appendChild(l),m||(n.style.background="",n.style.overflow="hidden",k=g.style.overflow,g.style.overflow="hidden",g.appendChild(n)),i=c(l,a),m?l.parentNode.removeChild(l):(n.parentNode.removeChild(n),g.style.overflow=k),!!i},x={}.hasOwnProperty,y;!B(x,"undefined")&&!B(x.call,"undefined")?y=function(a,b){return x.call(a,b)}:y=function(a,b){return b in a&&B(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=u.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(u.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(u.call(arguments)))};return e}),q.backgroundsize=function(){return F("backgroundSize")},q.cssanimations=function(){return F("animationName")},q.csstransforms=function(){return!!F("transform")},q.csstransforms3d=function(){var a=!!F("perspective");return a&&"webkitPerspective"in g.style&&w("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}",function(b,c){a=b.offsetLeft===9&&b.offsetHeight===3}),a},q.csstransitions=function(){return F("transition")};for(var G in q)y(q,G)&&(v=G.toLowerCase(),e[v]=q[G](),t.push((e[v]?"":"no-")+v));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)y(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof f!="undefined"&&f&&(g.className+=" nextend-"+(b?"":"no-")+a),e[a]=b}return e},z(""),i=k=null,e._version=d,e._prefixes=m,e._domPrefixes=p,e._cssomPrefixes=o,e.testProp=function(a){return D([a])},e.testAllProps=F,e.testStyles=w,e.prefixed=function(a,b,c){return b?F(a,b,c):F(a,"pfx")},g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" nextend-js nextend-"+t.join(" nextend-"):""),e}(this,this.document),function(a,b,c){function d(a){return"[object Function]"==o.call(a)}function e(a){return"string"==typeof a}function f(){}function g(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function h(){var a=p.shift();q=1,a?a.t?m(function(){("c"==a.t?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){"img"!=a&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l=b.createElement(a),o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};1===y[c]&&(r=1,y[c]=[]),"object"==a?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),"img"!=a&&(r||2===y[c]?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i("c"==b?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),1==p.length&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&"[object Opera]"==o.call(a.opera),l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return"[object Array]"==o.call(a)},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,h){var i=b(a),j=i.autoCallback;i.url.split(".").pop().split("?").shift(),i.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]),i.instead?i.instead(a,e,f,g,h):(y[i.url]?i.noexec=!0:y[i.url]=1,f.load(i.url,i.forceCSS||!i.forceJS&&"css"==i.url.split(".").pop().split("?").shift()?"c":c,i.noexec,i.attrs,i.timeout),(d(e)||d(j))&&f.load(function(){k(),e&&e(i.origUrl,h,g),j&&j(i.origUrl,h,g),y[i.url]=2})))}function h(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var i,j,l=this.yepnope.loader;if(e(a))g(a,0,l,0);else if(w(a))for(i=0;i<a.length;i++)j=a[i],e(j)?g(j,0,l,0):w(j)?B(j):Object(j)===j&&h(j,l);else Object(a)===a&&h(a,l)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,null==b.readyState&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};
window.Modernizr.hyphenated = function(str) {
    if(!(str = Modernizr.prefixed(str))) return '';
    return Modernizr.prefixed(str).replace(/([A-Z])/g, function(str, m1) {
        return '-' + m1.toLowerCase();
    }).replace(/^ms-/, '-ms-');
};

window.Modernizr.transitionEnd = (function() {
    var transEndEventNames = {
        'WebkitTransition': 'webkitTransitionEnd',
        'MozTransition': 'transitionend',
        'OTransition': 'oTransitionEnd otransitionend',
        'msTransition': 'MSTransitionEnd',
        'transition': 'transitionend'
    };
    return transEndEventNames[Modernizr.prefixed('transition')];
})();

window.Modernizr.addValueTest = function(property,value){
    var testName= (property+value).replace(/-/g,'');
    Modernizr.addTest(testName , function () {
        var element = document.createElement('div');
        var body = document.getElementsByTagName('HEAD')[0];
        var properties = [];
        var upcaseProp  = property.replace(/(^|\-)([a-z])/g, function(a, b, c){
            return c.toUpperCase();
        });
        properties[property] = property;
        properties['Webkit'+upcaseProp] ='-webkit-'+property;
        properties['Moz'+upcaseProp] ='-moz-'+property;
        properties['ms'+upcaseProp] ='-ms-'+property;

        body.insertBefore(element, null);
        for (var i in properties) {
            if (typeof element.style[i] != 'undefined') {
                element.style[i] = value;
            }
        }
        //ie7,ie8 doesnt support getComputedStyle
        //so this is the implementation
        if(!window.getComputedStyle) {
            window.getComputedStyle = function(el, pseudo) {
                this.el = el;
                this.getPropertyValue = function(prop) {
                    var re = /(\-([a-z]){1})/g;
                    if (prop == 'float') prop = 'styleFloat';
                    if (re.test(prop)) {
                        prop = prop.replace(re, function () {
                            return arguments[2].toUpperCase();
                        });
                    }
                    try{
                        return el.currentStyle[prop] ? el.currentStyle[prop] : null;
                    }catch(e){
                        return null; // IE fix
                    }
                };
                return this;
            };
        }

        var st = window.getComputedStyle(element, null),
            currentValue = st.getPropertyValue("-webkit-"+property) ||
                st.getPropertyValue("-moz-"+property) ||
                st.getPropertyValue("-ms-"+property) ||
                st.getPropertyValue(property);

        if(currentValue!== value){
            element.parentNode.removeChild(element);
            return false;
        }
        element.parentNode.removeChild(element);
        return true;
    });
}
window.Modernizr.addValueTest('transform-style','preserve-3d')

window.nModernizr = window.Modernizr;

if(tmpModernizr) window.Modernizr = tmpModernizr;

(function($){ $(document).ready(function() {$(".nextend-hastip").qtip({
                position: {
                    my: "bottom center",
                    at: "top right"
                },
                style: {
                    tip: {                        
                        width: 12,
                        height: 6
                    }
                }
            });
            $(".nextend-element-hastip").qtip({
                position: {
                    my: "bottom center",
                    at: "top center"
                },
                style: {
                    tip: {                        
                        width: 12,
                        height: 6
                    }
                }
            });
        
}); })(njQuery);

