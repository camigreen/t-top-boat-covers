(function ($, scope, undefined) {

    scope.smartSliderVertical = NClass.extend({
        init: function (options) {
            var _this = this;

            this.current = 0;

            this.id = options.id;
            this.node = options.node;
            this.thumbnailperpage = parseInt(options.thumbnailperpage);
            if(this.thumbnailperpage < 1) this.thumbnailperpage = 1;

            var height = this.node.find('> .nextend-thumbnail-container').height();

            this.strip = this.node.find('.nextend-thumbnail-strip');

            this.thumbnails = this.node.find('.nextend-thumbnail-strip .nextend-thumbnail');
            
            this.node.parent().on('loaded', function(){
                _this.loaded();
            });
        },
        
        loaded: function(){
            var _this = this;

            this.storeDefaults();

            this.resizeThumbnails(1);

            this.node.find('.nextend-arrow-top').on('click', function () {
                _this.previous();
            });
            
            this.node.find('.nextend-arrow-bottom').on('click', function () {
                _this.next();
            });
            
            this.node.on('mousewheel', function (e, delta, deltaX, deltaY) {
                if (delta < 0) {
                    if(_this.next()) e.preventDefault();
                } else {
                    if(_this.previous()) e.preventDefault();
                }
                
            });
            
            if (window[this.id + '-onresize']) {
                window[this.id + '-onresize'].push(function (ratio) {
                    _this.onResize(ratio);
                });
            }
        },

        storeDefaults: function () {
            var ratio = this.node.width()/this.node.parent().data('ss-outerwidth');

            this.node.data('ss-w', this.node.width()*ratio );
            this.thumbnails.data('ss-h', this.thumbnails.height()*ratio );
        },

        onResize: function (ratio) {

            var aH = parseInt(this.thumbnails.data('ss-h') * ratio);

            this.thumbnails.height(aH);

            this.resizeThumbnails(ratio);

            this.strip.stop().css('marginTop', -this.paneheight * this.current);
        },

        resizeThumbnails: function (ratio) {

            var height = this.node.find('> .nextend-thumbnail-container').parent().height();

            var paneheight = height - this.node.find('.nextend-arrow-top').height() - this.node.find('.nextend-arrow-bottom').height();

            this.strip.parent().css('height', paneheight);

            var thumbnailheight = (paneheight) / this.thumbnailperpage - this.thumbnails.outerHeight(true) + this.thumbnails.height();

            this.thumbnails.height(thumbnailheight);


            var thumbnailOuterHeight = this.thumbnails.outerHeight(true);

            this.strip.css('height', thumbnailOuterHeight * this.thumbnails.length);

            //this.paneheight = thumbnailOuterHeight * this.thumbnailperpage;
            
            this.paneheight = paneheight;

            this.panes = Math.ceil(this.thumbnails.length / this.thumbnailperpage) - 1;
        },

        next: function () {
            if (this.current < this.panes) {
                this.switchTo(this.current + 1);
                return true;
            }
            return false;
        },

        previous: function () {
            if (this.current > 0) {
                this.switchTo(this.current - 1);
                return true;
            }
            return false;
        },

        switchTo: function (i) {
            this.strip.stop().animate({
                marginTop: this.paneheight * -i
            }, {
                duration: 700,
                easing: 'easeInOutCubic'
            });
            this.current = i;
        },
        change: function (i) {
            this.thumbnails.not(this.thumbnails.eq(i)).removeClass('active');
            this.thumbnails.eq(i).addClass('active');
            var pane = parseInt(i / this.thumbnailperpage);
            this.switchTo(pane);
        }
    });
})(njQuery, window);