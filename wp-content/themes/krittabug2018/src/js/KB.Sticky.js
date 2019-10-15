class Sticky {
    constructor(options = {$wrapper,$sticky}) {
        var self = this;

        self.$wrapper = options.$wrapper;
        self.$sticky = options.$sticky;
        self.scrollTop = 0;
        self.stickAt = 0;
        
        self.getSizes.bind(self)();
        self.animate.bind(self)();
    }

    animate() {
        window.requestAnimationFrame(this.animate.bind(this));

        this.scrollTop = $(window).scrollTop();
        if (this.scrollTop < this.staticAt) {
            this.$sticky.addClass('static').removeClass('stuck');
        } else if (this.scrollTop >= this.stickAt) {
            this.$sticky.addClass('stuck').removeClass('static');
        } else {
            this.$sticky.removeClass('stuck static');
        }
    };
    getSizes() {
        var self = this;

        self.staticAt = self.$wrapper.offset().top - parseInt(self.$sticky.css('marginTop'));
        self.stickAt = self.$wrapper.outerHeight() - parseInt(self.$sticky.css('marginTop')) + self.$wrapper.offset().top - self.$sticky.outerHeight();

        //$(window).off('resize');
        $(window).on('resize', function() {
            self.getSizes.bind(self)();
        });
    }
};