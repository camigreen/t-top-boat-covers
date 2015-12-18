(function ($, scope, undefined) {
    
    var is_touch_device = (function() {
    return (('ontouchstart' in window)
          || (navigator.MaxTouchPoints > 0)
          || (navigator.msMaxTouchPoints > 0));
    })();
    
    scope.ssFullpageSlider = scope.ssTypeBase.extend({
        extraParallax: 1,
         _screenSize: null,
        init: function (parent, $el, options) {
            var _this = this;

            this._screenSize = {
                w: 0,
                h: 0
            };
            
            options.flux[0] = (options.flux[0] && parseInt(options.flux[0])) ? true : false;
            
            this._super(parent, $el, options);
        },
        afterInit: function(){
            var _this = this;
            this._super();

            this.smartsliderborder2 = this.$slider.find('.smart-slider-border2');

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
                this.flux = new flux.slider('.nextend-flux', {
                    transitions: this.options.flux[1],
                    width: this.slideDimension.w,
                    height: this.slideDimension.h,
                    currentImageIndex: this._active,
                    nextImageIndex: this._active + 1
                });
            }
        },
        storeDefaults: function () {
            var ss = this.$slider,
              _this = this;

            ss.data('ss-outerwidth', ss.outerWidth(true));
            ss.data('ss-outerheight', ss.outerHeight(true));

            //ss.data('ss-fontsize', parseInt(ss.css('fontSize')));

            this.variables.margintop = 0;
            this.variables.marginright = 0;
            this.variables.marginbottom = 0;
            this.variables.marginleft = 0;
            
            this.variables.outerwidth = ss.parent().width();
            this.variables.outerheight = ss.parent().height();
                
            this.variables.width = ss.width();
            this.variables.height = ss.height();

            ss.data('ss-w', this.variables.width);
            ss.data('ss-h', this.variables.height);

            var smartsliderborder1 = this.smartsliderborder1 = ss.find('.smart-slider-border1');

            smartsliderborder1.data('ss-w', smartsliderborder1.width());
            smartsliderborder1.data('ss-h', smartsliderborder1.height());

            var canvases = this.smartslidercanvasinner = this.slideList.find('.smart-slider-canvas-inner');
            
            this.variables.canvaswidth = canvases.width();
            this.variables.canvasheight = canvases.height();
            
            canvases.data('ss-w', this.variables.canvaswidth);
            canvases.data('ss-h', this.variables.canvasheight);

            this.slideList.css({
                width: canvases.data('ss-w'),
                height: canvases.data('ss-h')
            });
            
            this.imagesinited = false;
            this.$slider.waitForImages(function () {
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
                
                var availableWidth = _this.variables.canvaswidth;
                var availableHeight = _this.variables.canvasheight;
                
                if($img.data('ss-w')/availableWidth < $img.data('ss-h')/availableHeight){
                    $img.width(availableWidth).css('height', 'auto').css('margin', 0);
                    var imgmargin = -parseInt((availableWidth/$img.data('ss-w')*$img.data('ss-h')-availableHeight)/2);
                    $img.css('marginTop', imgmargin);
                }else{
                    $img.height(availableHeight).css('width', 'auto').css('margin', 0);
                    var imgmargin = -parseInt((availableHeight/$img.data('ss-h')*$img.data('ss-w')-availableWidth)/2);
                    $img.css('marginLeft', imgmargin);
                }
            });

            this.variablesRefreshed();
        },
        _lastResizeEvent: '',
        onResize: function (fixedratio) {
            var _this = this;
            var ss = this.$slider;
            var ratio = 1,
                ratioH = 1,
                ratioV = 1;
            var modechanged = this.refreshMode(); //this._currentmode

            var screenSize = {
                w: document.body.clientWidth || document.documentElement.clientWidth,
                h: document.documentElement.clientHeight || document.body.clientHeight
            };

            if(this._lastResizeEvent == this._resizeEvent && is_touch_device && Math.abs(this._screenSize.h - screenSize.h) < 100){
                return false;
            }
            this._lastResizeEvent = this._resizeEvent;
            this._screenSize = screenSize;
            
            var availableWidth = ss.parent().width(),
                availableHeight = screenSize.h;

            var outerWidth = ss.data('ss-outerwidth'),
                outerHeight = ss.data('ss-outerheight');
            
            if (!this.options.responsive.upscale && availableWidth > outerWidth) availableWidth = outerWidth;

            if(typeof fixedratio == 'undefined'){
                if (availableWidth != outerWidth) {
                    ratioH = availableWidth / outerWidth;
                    ratioV = availableHeight / outerHeight;
                    if(ratioV < ratioH){
                        ratio = ratioV;
                    }else{
                        ratio = ratioH;
                    }
                }
    
                if (this.lastAvailableWidth == availableWidth && this.lastAvailableHeight == availableHeight) {
                    var _this = this;
                    this.$slider.waitForImages(function () {
                        $(_this).trigger('load');
                    });
                    return true;
                }
            }else{
                this.options.responsive.horizontal = true;
                this.options.responsive.vertical = true;
                availableWidth = outerWidth*fixedratio;
                availableHeight = outerHeight*fixedratio;
                ratio = fixedratio; 
                ratioH = fixedratio;
                ratioV = fixedratio;
            }
            this.lastAvailableWidth = availableWidth;
            this.lastAvailableHeight = availableHeight;
            
            this.variables.outerwidth = availableWidth;
            this.variables.outerheight = availableHeight;

            ss.css('fontSize', ss.data(this._currentmode+'fontsize') * ratio + 'px');

            var smartsliderborder1 = this.smartsliderborder1;

            smartsliderborder1.width(parseInt(smartsliderborder1.data('ss-w') * ratioH));

            this.variables.width = smartsliderborder1.outerWidth(true);
            ss.width(this.variables.width);


            var canvases = this.smartslidercanvasinner;
            var oCanvasWidth = canvasWidth = this.options.responsive.horizontal ? availableWidth : parseInt(canvases.data('ss-w') * ratio),
                oCanvasHeight = parseInt(canvases.data('ss-h') * ratio),
                margin = 0,
                maxw = this.options.responsive.maxwidth,
                ratio2 = ratio;

            if (canvasWidth > this.options.responsive.maxwidth) {
                margin = parseInt((canvasWidth - maxw) / 2);
                ratio2 = maxw / canvases.data('ss-w');
                canvasWidth = parseInt(canvases.data('ss-w') * ratio2);
                if(ratio2 < ratio){
                    ratio2 = ratio;
                }
            }

            this.extraParallax = ratio / ratio2;

            var canvasHeight = this.options.responsive.vertical ? availableHeight : parseInt(canvases.data('ss-h') * ratio2);
            
            if (this.options.flux[0]) this.flux.changeSize(oCanvasWidth, canvasHeight);
            
            canvases.width(canvasWidth).height(canvasHeight).css({
                marginLeft: margin,
                marginRight: margin
            });

            this.slideList.css({
                width: availableWidth,
                height: availableHeight
            });

            smartsliderborder1.css('fontSize', ss.data(this._currentmode+'fontsize') * ratio2 + 'px');

            smartsliderborder1.height(availableHeight);
            
            this.variables.height = smartsliderborder1.outerHeight(true);
            ss.height(this.variables.height);
            
            var mcanvast = parseInt((availableHeight-canvasHeight)/2);
            if(mcanvast < 0) mcanvast = 0;
            canvases.css('marginTop', mcanvast+'px');
            var mcanvasl = parseInt((availableWidth-canvasWidth)/2);
            if(mcanvasl < 0) mcanvasl = 0;
            canvases.css('marginLeft', mcanvasl+'px');

            this.slideDimension.w = availableWidth;
            this.slideDimension.h = availableHeight;
            
            this.variables.canvaswidth = availableWidth;
            this.variables.canvasheight = availableHeight;
            
            var bgfn = function () {
                $.each(_this.slidebgList, function(){
                    var $img = $(this);
                    if($img.data('ss-w')/availableWidth < $img.data('ss-h')/availableHeight){
                        $img.width(availableWidth).css('height', 'auto').css('margin', 0);
                        var imgmargin = -parseInt((availableWidth/$img.data('ss-w')*$img.data('ss-h')-availableHeight)/2);
                        $img.css('marginTop', imgmargin);
                    }else{
                        $img.height(availableHeight).css('width', 'auto').css('margin', 0);
                        var imgmargin = -parseInt((availableHeight/$img.data('ss-h')*$img.data('ss-w')-availableWidth)/2);
                        $img.css('marginLeft', imgmargin);
                    }
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

            this.$slider.waitForImages(function () {
                $(_this).trigger('load');
            });

            this.variablesRefreshed();
        },
        initScroll: function () {
            if (this.options.controls.scroll == 0) return;
            var _this = this;
            this.$slider.on('mousewheel', function (e, delta, deltaX, deltaY) {
                if(!_this._animating){
                    if (delta < 0) {
                        var i = _this._active + 1;
                        if (i === _this.slideList.length) return;
                        _this.next();
                    } else {
                        var i = _this._active - 1;
                        if (i < 0) return;
                        _this.previous();
                    }
                }
                e.preventDefault();
            });
        },
        changeTo: function (i, reversed, autoplay) {
            var t = parseInt(this.$slider.offset().top);
            if((this.options.focus.user || this.options.focus.autoplay) && (typeof autoplay == 'undefined' || this.options.focus.autoplay && autoplay) && $(document).scrollTop() != t){
                $('html, body').stop().animate({
                    scrollTop: t
                }, 500);
            }else{
                if(!this.options.carousel && i < this._active) reversed = true;
                this._super(i, reversed);
            }
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
                parallaxIn: option.parallax != 1 ? option.parallax * this.extraParallax : option.parallax,
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
                parallaxOut: option.parallax != 1 ? option.parallax * this.extraParallax : option.parallax,
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
                parallaxIn: option.parallax != 1 ? option.parallax * this.extraParallax : option.parallax,
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
                parallaxOut: option.parallax != 1 ? option.parallax * this.extraParallax : option.parallax,
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

})(njQuery, window);