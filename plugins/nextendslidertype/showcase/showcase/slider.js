(function ($, scope, undefined) {
    scope.ssShowcaseSlider = scope.ssTypeBase.extend({
        extraParallax: 1,
        init: function (parent, $el, options) {
            var _this = this;
            options.translate3d = nModernizr.csstransforms3d;
            this.smartsliderborder2 = $el.find('.smart-slider-border2');
            this.pipeline = $el.find('.smart-slider-pipeline');
            this.ocanvas = $el.find('.smart-slider-canvas');
            
            switch(options.showcase.direction){
                case 'vertical':
                  this.marginside = 'marginBottom';
                break;
                default:
                  this.marginside = 'marginRight';
            }
            
            
            this.showcase = {
                before: {},
                active: {},
                after: {}
            };
            
            if(!window.ssadmin){
                var animate = options.showcase.animate;
                for(k in animate){
                    if(animate[k]){
                        if(!nModernizr.transformstylepreserve3d){
                            if(k == 'z' || k == 'rotateY' || k == 'rotateX') continue;
                        }
                        this.showcase.before[k] = animate[k].before;
                        this.showcase.active[k] = animate[k].active;
                        this.showcase.after[k] = animate[k].after;
                    }
                }
            }
            
            this.pr = ['x', 'y', 'ntransition'];
            if(!options.translate3d){
                this.pr = ['left', 'top', 'animate'];
            }

            this._super(parent, $el, options);
        },
        afterInit: function(){
            var _this = this;
            this._super();
            
            this.$slider.find('.smart-slider-overlay').each(function(i){
                $(this).on('click touchstart',function(e){
                    _this.changeTo(i);
                    e.preventDefault();
                    e.stopPropagation();
                });
            });
            
            $(this).on('load.firstsub', function () {
                $(this).off('load.firstsub');
            });
            
            if(window.ssadmin) this.storeDefaults();
        },

        sizeInited: function () {

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
            
            this.smartsliderborder2.data('ss-w', this.smartsliderborder2.width());

            var smartsliderborder1 = this.smartsliderborder1 = ss.find('.smart-slider-border1');
            
            smartsliderborder1.data('ss-w', smartsliderborder1.width());
            smartsliderborder1.data('ss-h', smartsliderborder1.height());
            smartsliderborder1.data('ss-borderw', parseInt(smartsliderborder1.css('borderLeftWidth'))+parseInt(smartsliderborder1.css('borderRightWidth')));
            smartsliderborder1.data('ss-borderh', parseInt(smartsliderborder1.css('borderTopWidth'))+parseInt(smartsliderborder1.css('borderBottomWidth')));
            smartsliderborder1.data('ss-p-t', parseInt(smartsliderborder1.css('paddingTop')));
            smartsliderborder1.data('ss-p-r', parseInt(smartsliderborder1.css('paddingRight')));
            smartsliderborder1.data('ss-p-b', parseInt(smartsliderborder1.css('paddingBottom')));
            smartsliderborder1.data('ss-p-l', parseInt(smartsliderborder1.css('paddingLeft')));
            
            var canvases = this.smartslidercanvasinner = this.slideList.find('.smart-slider-canvas-inner');
                
            this.variables.canvaswidth = canvases.width();
            this.variables.canvasheight = canvases.height();
            
            this.pipelineProp = {
                x0: smartsliderborder1.data('ss-w')/2-this.variables.canvaswidth/2,
                y0: smartsliderborder1.data('ss-h')/2-this.variables.canvasheight/2,
                deltax: this.ocanvas.outerWidth(true),
                deltay: this.ocanvas.outerHeight(true)
            };
            
            switch(this.options.showcase.direction){
                case 'vertical':
                    this.pipeline.css(this.pr[0], parseInt(this.pipelineProp.x0))
                        .css(this.pr[1], parseInt(this.pipelineProp.y0-this._active*this.pipelineProp.deltay));
                    break;
                default:
                    this.pipeline.css(this.pr[0], parseInt(this.pipelineProp.x0-this._active*this.pipelineProp.deltax))
                        .css(this.pr[1], parseInt(this.pipelineProp.y0));
            }
            
            canvases.data('ss-w', this.variables.canvaswidth);
            canvases.data('ss-h', this.variables.canvasheight);
            
            this.slideList.css('transformOrigin', '50% 50% 0');
            
            this.slideList.css({
                width: this.variables.canvaswidth,
                height: this.variables.canvasheight
            });
            var maxzindex = this.slideList.length;
            for(var i = 0; i < this._active; i++){
                this.slideList.eq(i).css('zIndex', maxzindex-this._active+i).css(this.showcase.before);
            }
            this.slideList.eq(this._active).css('zIndex', maxzindex).css(this.showcase.active);
            for(var i = this._active+1; i < this.slideList.length; i++){
                this.slideList.eq(i).css('zIndex', maxzindex-i+this._active).css(this.showcase.after);
            }
            
            this.imagesinited = false;
            this.$slider.waitForImages(function () {
                $.each(_this.slidebgList, function(){
                    var $img = $(this);
                    var im = $("<img/>").attr("src", $img.attr("src"));
                    $img.data('ss-w', im[0].width);
                    $img.data('ss-h', im[0].height);
                });
                _this.imagesinited = true;
                _this.$slider.trigger('imagesinited');
            });

            this.variablesRefreshed();
        },
        onResize: function (fixedratio) {
            var _this = this,
                ss = this.$slider;
                
            var modechanged = this.refreshMode(); //this._currentmode

            var ratio = 1;
            var smartsliderborder1 = this.smartsliderborder1;

            var availableWidth = ss.parent().width()-smartsliderborder1.data('ss-borderw');

            var outerWidth = ss.data('ss-outerwidth');

            if (!this.options.responsive.upscale && availableWidth > outerWidth) availableWidth = outerWidth;
            
            if(typeof fixedratio == 'undefined'){
                if (availableWidth != outerWidth) {
                    ratio = availableWidth / outerWidth;
                }
    
                if (this.lastAvailableWidth == availableWidth || !this.options.responsive.downscale && ratio < 1) {
                    var _this = this;
                    this.$slider.waitForImages(function () {
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



            smartsliderborder1.css('paddingTop', parseInt(smartsliderborder1.data('ss-p-t') * ratio) + 'px');
            smartsliderborder1.css('paddingRight', parseInt(smartsliderborder1.data('ss-p-r') * ratio) + 'px');
            smartsliderborder1.css('paddingBottom', parseInt(smartsliderborder1.data('ss-p-b') * ratio) + 'px');
            smartsliderborder1.css('paddingLeft', parseInt(smartsliderborder1.data('ss-p-l') * ratio) + 'px');
            smartsliderborder1.width(parseInt(smartsliderborder1.data('ss-w') * ratio)+smartsliderborder1.data('ss-borderw')*ratio);


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
            }else{
                ratio2 = this.smartsliderborder2.width() / ss.data('ss-w');
                canvasWidth = parseInt(canvases.data('ss-w') * ratio2);
                //console.log(availableWidth , outerWidth,availableWidth / outerWidth);
                /*console.log(this.smartsliderborder2.width());
                ratio2 = this.smartsliderborder2.width() / this.smartsliderborder2.data('ss-w');
                canvasWidth = parseInt(canvases.data('ss-w') * ratio2);*/
            }

            this.extraParallax = ratio / ratio2;

            var canvasHeight = parseInt(canvases.data('ss-h') * ratio2);
            
            var smartsliderborder1height = parseInt(smartsliderborder1.data('ss-h') * ratio2)+smartsliderborder1.data('ss-borderh')*ratio2;
            if(smartsliderborder1height < canvasHeight) smartsliderborder1height = canvasHeight;

            canvases.width(canvasWidth).height(canvasHeight)/*.css({
                marginLeft: margin,
                marginRight: margin
            })*/;

            this.slideList.css({
                width: canvases.outerWidth(true),
                height: canvases.outerHeight(true)
            });

            smartsliderborder1.css('fontSize', ss.data(this._currentmode+'fontsize') * ratio2 + 'px');

            smartsliderborder1.height(smartsliderborder1height);
            //smartsliderborder1.height(canvasHeight);
            
            this.variables.height = smartsliderborder1.outerHeight(true);
            ss.height(this.variables.height);

            this.slideDimension.w = canvasWidth;
            this.slideDimension.h = canvasHeight;

            this.variables.canvaswidth = canvasWidth;
            this.variables.canvasheight = canvasHeight;
            
            
            this.variables.outerwidth = ss.parent().width();
            this.variables.outerheight = ss.parent().height();
            
            this.ocanvas.css(this.marginside, parseInt(this.options.showcase.distance*ratio2));
            
            this.pipelineProp.x0 = smartsliderborder1.width()/2-this.variables.canvaswidth/2;
            this.pipelineProp.y0 = smartsliderborder1.height()/2-this.variables.canvasheight/2;
            this.pipelineProp.deltax = this.ocanvas.outerWidth(true);
            this.pipelineProp.deltay = this.ocanvas.outerHeight(true);

            
            switch(this.options.showcase.direction){
                case 'vertical':
                    this.pipeline.css(this.pr[0], parseInt(this.pipelineProp.x0))
                        .css(this.pr[1], parseInt(this.pipelineProp.y0-this._active*this.pipelineProp.deltay));
                    break;
                default:
                    this.pipeline.css(this.pr[0], parseInt(this.pipelineProp.x0-this._active*this.pipelineProp.deltax))
                        .css(this.pr[1], parseInt(this.pipelineProp.y0));
            }
            
            
            this.slidebgList.width(oCanvasWidth);
            var bgfn = function () {
                $.each(_this.slidebgList, function(){
                    var $img = $(this),
                        imgh = oCanvasWidth/$img.data('ss-w')*$img.data('ss-h');
                    if(imgh >= canvasHeight-1 && imgh <= canvasHeight+1) imgh = canvasHeight;
                    $img.height(parseInt(canvasHeight));
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
                window[this.id + '-onresize'][i](ratio2);
            }
            $(this).trigger('resize', [ratio2, canvasWidth, canvasHeight]);

            var _this = this;
            this.$slider.waitForImages(function () {
                $(_this).trigger('load');
            });
            
            this.variablesRefreshed();
        },
        animateOut: function (i, reversed) {
            this._lastActive = i;
        },
        animateIn: function (i, reversed) {
            this._active = i;
            var _this = this,
                $slide = this.slideList.eq(i),
                $lastslide = this.slideList.eq(this._lastActive);
            
            $lastslide.on('ssanimationsended.ssmainanimateout',function () {
                $lastslide.off('ssanimationsended.ssmainanimateout');
                _this.$this.trigger('mainanimationoutend');
                _this.mainanimationended();
            }).trigger('ssoutanimationstart');
            
            if (!this.options.syncAnimations) {
                $lastslide.trigger('ssanimatelayersout');
            }
            
            $slide.on('ssanimationsended.ssmainanimatein',function () {
                $slide.off('ssanimationsended.ssmainanimatein');
                _this.$this.trigger('mainanimationinend');
                _this.mainanimationended();
            }).trigger('ssinanimationstart');

            
            $slide.trigger('incrementanimation');
            $lastslide.trigger('incrementanimation');
            
            var props = {};
            
            switch(this.options.showcase.direction){
                case 'vertical':
                    props[this.pr[0]] = parseInt(this.pipelineProp.x0);
                    props[this.pr[1]] = parseInt(this.pipelineProp.y0-this._active*this.pipelineProp.deltay);
                    break;
                default:
                    props[this.pr[0]] = parseInt(this.pipelineProp.x0-this._active*this.pipelineProp.deltax);
                    props[this.pr[1]] = parseInt(this.pipelineProp.y0);
            }
            
            (this.pipeline.delay(this.options.animationSettings.delay)[this.pr[2]])(props, {
                duration: this.options.animationSettings.duration,
                easing: this.options.animationSettings.easing,
                complete: function(){
                    $lastslide.trigger('decrementanimation');
                    $slide.trigger('decrementanimation');
                    _this.mainanimationended();
                }
            });
            var maxzindex = this.slideList.length;
            for(var j = 0; j < i; j++){
                this.slideList.eq(j).addClass('smart-slider-animate-out').css('zIndex', maxzindex-i+j)
                  .delay(this.options.animationSettings.delay)
                  .ntransition(this.showcase.before, {
                    duration: this.options.animationSettings.duration,
                    easing: this.options.animationSettings.easing,
                    complete: function(){
                        $(this).removeClass('smart-slider-animate-out');
                    }
                });
            }
            this.slideList.eq(i).addClass('smart-slider-animate-in').css('zIndex', maxzindex)
              .delay(this.options.animationSettings.delay)
              .ntransition(this.showcase.active, {
                duration: this.options.animationSettings.duration,
                easing: this.options.animationSettings.easing,
                complete: function(){
                    $(this).removeClass('smart-slider-animate-in');
                }
            });
            for(var j = i+1; j < this.slideList.length; j++){
                this.slideList.eq(j).addClass('smart-slider-animate-out').css('zIndex', maxzindex-j+i)
                  .delay(this.options.animationSettings.delay)
                  .ntransition(this.showcase.after, {
                    duration: this.options.animationSettings.duration,
                    easing: this.options.animationSettings.easing,
                    complete: function(){
                        $(this).removeClass('smart-slider-animate-out');
                    }
                });
            }
        }
    });

})(njQuery, window);