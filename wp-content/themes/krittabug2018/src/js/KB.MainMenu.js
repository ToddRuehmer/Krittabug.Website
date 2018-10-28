var mainMenu = {
    $trigger: {},
    $menu: {},
    $items: {},
    mainTimeline: {},
    open: false,
    init(callback) {
        var self = this;

        self.$trigger = $('.KB-MenuTrigger_js');
        self.$menu = $('.KB-MainNav_js');
        self.$items = $('.KB-MainNavLink_js, .KB-MainNavSidebar_js');
        self.run();
    },
    run() {
        var self = this;

        self.buildTimeline.bind(self)();

        self.$trigger.on('click', function(e) {
            e.preventDefault();

            if(!self.open) {
                self.openMenu.bind(self)();
            } else {
                self.closeMenu.bind(self)();
            }
        });

        $('body').on( function(e) {
            self.closeMenu.bind(self)();
        });
    },
    buildTimeline() {
        var self = this;
        
        self.mainTimeline = new TimelineMax({ paused: true })
        .fromTo(self.$menu, .4, {xPercent:-100}, {xPercent:100})
        .staggerFromTo(self.$items, .4, {rotationY:-90}, {rotationY:0}, .1, '-=.2');
    },
    openMenu() {
        var self = this;

        self.mainTimeline.play();
        self.open = true;
    },
    closeMenu() {
        var self = this;

        self.mainTimeline.reverse();
        self.open = false;
    }
}