var masonries = {
    $target: {},
    masonries: [],
    init() {
        var self = this;

        self.$target = $('.KB-Articles_js');
        self.run();
    },
    run() {
        var self = this;

        $.each(self.$target, function() {
            var $target = $(this);

            self.masonries.push(new Masonry({$wrapper:$('.KB-Articles_js'), $articles:$('.KB-Article_js')}));
        });
    }
}

class Masonry {
    constructor(options = {$wrapper:{},$articles:{}}) {
        var self = this;

        self.$wrapper = options.$wrapper;
        self.$articles = options.$articles;
        self.$images = this.$wrapper.find('img');
        self.highest = 0;
        self.curColumn = 0;
        self.colCount = 2;
        self.cols = [];
        for(var i=0;i<self.colCount;i++) {
            self.cols.push(new Column());
        }
        self.colWidth = self.$articles.eq(0).outerWidth(true);
        
        $(window).on('load', function() { self.adjust() });
        $(window).on('resize', function() { self.adjust() });
    }

    adjust() {
        var self = this;

        self.highest = 0;
        self.curColumn = 0;
        self.colWidth = self.$articles.eq(0).outerWidth(true);
        
        $.each(self.$articles, function(a) {
            let $article = $(this);
            let tempHeights = [];

            for(var i=0;i<self.colCount;i++) {
                if(a==0) { self.cols[i].height = 0; };
                tempHeights.push(self.cols[i].height);
            }

            self.highest = Math.min(...tempHeights);
            self.curColumn = tempHeights.indexOf(self.highest);
            
            $article.css({
                top: self.highest,
                left: self.curColumn * self.colWidth
            });
            
            self.cols[self.curColumn].height += $article.outerHeight(true);
            self.highest = self.cols[self.curColumn].height;
        });

        self.$wrapper.css({height:self.highest});
    }
};

class Column {
    constructor(options = {}) {
        var self = this;

        self.index = 0;
        self.height = 0;
    }
};