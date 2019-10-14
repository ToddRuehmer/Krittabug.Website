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

        $.each(self.$items, function(i) {
            var $this = $(this);
            
            self.mainTimeline.fromTo($this, .2, {
                scale   : 0,
                x       : "-50%",
                y       : "-50%",
                zIndex  : i*-1
            }, {
                scale   : 1,
                x       : "0%",
                y       : (i*75)+"%",
            }, i * 0.1);  
        });

        //.staggerFromTo(self.$items, .2, {scale:0,y:-100}, {scale:1,y:0}, .1, '-=.05');
    },
    openMenu() {
        var self = this;

        self.$trigger.addClass('open');
        self.$trigger.removeClass('closed');
        self.mainTimeline.play();
        self.open = true;
    },
    closeMenu() {
        var self = this;

        self.$trigger.addClass('closed');
        self.$trigger.removeClass('open');
        self.mainTimeline.reverse();
        self.open = false;
    }
}