(function ($, scope, undefined) {

    scope.smartSliderGallery = NClass.extend({
        lastI: 0,
        init: function (options) {
            var _this = this;

            this.current = 0;
            this.id = options.id;
            this.node = options.node;
            
            this.thumbnails = this.node.find('.nextend-thumbnail-container .nextend-thumbnail');
        },
        change: function (i) {
            this.thumbnails.not(this.thumbnails.eq(i)).removeClass('active');
            this.thumbnails.eq(i).addClass('active');
        }
    });
})(njQuery, window);