//
class Pixelate {
    constructor(options = {$image}) {
        var self = this;

        //self.$wrapper = options.$wrapper;
        self.$image = options.$image[0];
        
        self.pixelateImage.bind(self)();
    }

    pixelateImage() {
        this.pixelated = new BreathingHalftone(this.$image, {
            bgColor: 'f1f0f2',
            dotSize: 1/100,
            fgColor: 'ccc',
            hoverDiameter: 0.3,
            initVelocity: 0.03,
            isAdditive: false,
            oscAmplitude: .2,
            friction: 1,
            channels: [ 'lum' ]
        });
    };
};