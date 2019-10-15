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

        self.mainTimeline.addLabel('start');
        $.each(self.$items, function(i) {
            var $this = $(this);
            
            self.mainTimeline
            .fromTo($this, .2, {
                scale   : 0,
                x       : "-50%",
                y       : "-50%",
                zIndex  : i*-1
            }, {
                scale   : 1,
                x       : "0%",
                y       : (i*75)+"%",
                ease    : CustomEase.create("custom", "M0,0 C0.548,0.432 0.71,0.752 0.804,1.056 0.853,1.215 0.854,0.886 1,1")
            }, i * 0.05)
        });
        self.mainTimeline.addLabel('open');
        $.each(self.$items, function(i) {
            var $this = $(this);
            
            self.mainTimeline
            .to($this, .2, {
                scale   : 0,
                x       : "-50%",
                y       : "-50%"
            })
        });
        self.mainTimeline.addLabel('close');
    },
    openMenu() {
        var self = this;

        self.$trigger.addClass('open');
        self.$trigger.removeClass('closed');
        self.mainTimeline.tweenFromTo('start','open');
        self.open = true;
    },
    closeMenu() {
        var self = this;

        self.$trigger.addClass('closed');
        self.$trigger.removeClass('open');
        self.mainTimeline.tweenFromTo('open','close');
        self.open = false;
    }
}