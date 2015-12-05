(function($, scope, undefined) {

    scope.smartSliderHorizontal = NClass.extend({
        lastI: 0,
        init: function(options) {
            var _this = this;

            this.current = 0;
            this.id = options.id;
            this.node = options.node;
            this.thumbnailperpage = parseInt(options.thumbnailperpage);
            if (this.thumbnailperpage < 1)
                this.thumbnailperpage = 1;

            var width = this.node.find('> .nextend-thumbnail-container').width();

            this.strip = this.node.find('.nextend-thumbnail-strip');

            this.thumbnails = this.node.find('.nextend-thumbnail-strip .nextend-thumbnail');
            if (this.thumbnailperpage > this.thumbnails.length)
                this.thumbnailperpage = this.thumbnails.length;

            this.node.parent().on('loaded', function() {
                _this.loaded();
            });
        },
        loaded: function() {
            var _this = this;


            this.storeDefaults();

            this.resizeThumbnails(1);

            this.arrowLeft = this.node.find('.nextend-arrow-left').on('click', function() {
                _this.previous();
            });

            this.arrowRight = this.node.find('.nextend-arrow-right').on('click', function() {
                _this.next();
            });

            if (window[this.id + '-onresize']) {
                window[this.id + '-onresize'].push(function(ratio) {
                    _this.onResize(ratio);
                });
            }

        },
        storeDefaults: function() {
        },
        onResize: function(ratio) {

            this.resizeThumbnails(ratio);

            this.change(this.lastI);
        },
        resizeThumbnails: function(ratio, w) {

            var width = this.node.find('> .nextend-thumbnail-container').width();

            var height = this.thumbnails.outerHeight(true);

            this.strip.parent().css('height', height).css('width', width - this.node.find('.nextend-arrow-left').width() - this.node.find('.nextend-arrow-right').width());

            var fwidth = this.strip.parent().width();
            var thumbnailwidth = w ? w : this.thumbnails.width();

            if (thumbnailwidth + 10 > fwidth / this.thumbnailperpage) {
                this.cthumbnailperpage = parseInt(fwidth / (thumbnailwidth + 10));
            } else {
                this.cthumbnailperpage = this.thumbnailperpage;
            }

            var margin = parseInt((fwidth - thumbnailwidth * this.cthumbnailperpage) / (2 * this.cthumbnailperpage));
            this.thumbnails.each(function() {
                $(this).css({
                    marginLeft: margin,
                    marginRight: margin
                });
            });
            this.panewidth = (thumbnailwidth + margin * 2) * this.cthumbnailperpage;

            this.panes = Math.ceil(this.thumbnails.length / this.cthumbnailperpage) - 1;

            this.strip.css('height', '100%').css('width', (this.thumbnails.outerWidth() + 2 * margin) * this.thumbnails.length + 1000);
        },
        next: function() {
            if (this.current < this.panes) {
                this.switchTo(this.current + 1);
            }
        },
        previous: function() {
            if (this.current > 0) {
                this.switchTo(this.current - 1);
            }
        },
        switchTo: function(i) {
            if (window.nextendDir == 'rtl') {
                this.strip.stop().animate({
                    marginRight: this.panewidth * -i
                }, {
                    duration: 700,
                    easing: 'easeInOutCubic'
                });
                this.current = i;
            } else {
                this.strip.stop().animate({
                    marginLeft: this.panewidth * -i
                }, {
                    duration: 700,
                    easing: 'easeInOutCubic'
                });
                this.current = i;
            }
        },
        change: function(i) {
            this.thumbnails.not(this.thumbnails.eq(i)).removeClass('active');
            this.thumbnails.eq(i).addClass('active');
            var $this = this;
            var fn = function() {
                var pane = parseInt(i / $this.cthumbnailperpage);
                $this.switchTo(pane);
                $this.lastI = i;
            }
            var test = function() {
                if (typeof this.cthumbnailperpage == 'undefined') {
                    setTimeout(test, 300);
                } else {
                    fn();
                }
            };
            test();
        }
    });
})(njQuery, window);