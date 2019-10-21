//
class Pixelate {
    constructor(options = {$image,$container}) {
        var self = this;

        self.$image = options.$image;
        self.$container = options.$container;
        
        //self.pixelateImage.bind(self)();
    }

    pixelateImage() {
        var $image = this.$image;
        this.pixelated = $image[0].closePixelate([
            //{ resolution: 64, size: 64 },
            //{ shape: 'diamond', resolution: 64, size: 64, offset: 32 },
            { shape: 'circle', resolution: 32, size: 32, offset: 16 },
            { shape: 'circle', resolution: 32, size: 32 },
          ]);
          $(this.pixelated.canvas).appendTo(this.$container);
    };
};