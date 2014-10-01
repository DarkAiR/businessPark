map = {
    svgobject: null,    // svgobject
    mc: null,           // hammerjs
    snap: null,         // snap

    /**
     * Init SVG
     */
    init: function(svgobject)
    {
        map.svgobject = svgobject;
        map.initHammerJS();

        // Создаем объект для рисования в SVG
        map.snap = Snap('.map svg');
    },

    /**
     * Init hammerJS and dragging
     */
    initHammerJS: function()
    {
        map.mc = Hammer(map.svgobject);

        mc = map.mc;
        mc.get('pan').set({ direction: Hammer.DIRECTION_ALL, 'threshold':32 });
        mc.get('pinch').set({ enable: true });
        mc.get('rotate').set({ enable: true });
        mc.get('tap').set({ 'enable': true, 'threshold':32, 'time':1000 });

        var dragging = null;
        var pageX = 0;
        var pageY = 0;

        // Центрируем карту
        map.centerMapCoords(map.svgobject);

        mc.on("panstart", function(e) {
            dragging = map.svgobject;
            pageX = e.center.x;
            pageY = e.center.y;
        });
        mc.on("panend", function(e) {
            dragging = null;
            pageX = 0;
            pageY = 0;
        });
        mc.on("panmove", function(e) {
            if (dragging) {
                var deltaX = e.center.x - pageX;
                var deltaY = e.center.y - pageY;
                pageX = e.center.x;
                pageY = e.center.y;
                //$('#debug2').html('xy ('+pageX+', '+pageY+')<br>' + 'delta ('+deltaX+', '+deltaY+')<br>');
                map.setMapCoords(deltaX, deltaY);
            }
        });
    },

    /**
     * Set map coords
     */
    setMapCoords: function(deltaX, deltaY)
    {
        var coords = map.svgobject.getAttribute('viewBox').split(' ');
        var width  = parseInt(map.svgobject.getAttribute('width'));
        var height = parseInt(map.svgobject.getAttribute('height'));
        var viewPortW = parseInt($('.map').css('width'));
        var viewPortH = parseInt($('.map').css('height'));

        var x = parseInt(coords[0]);
        var y = parseInt(coords[1]);
        var w = parseInt(coords[2]);
        var h = parseInt(coords[3]);

        var ratioW = w / width;
        var ratioH = h / height;

        //$('#debug').html('xy ('+x+', '+y+')<br>' + 'wh ('+w+', '+h+')<br>' + 'ratio ('+ratioW+', '+ratioH+')<br>');

        x -= deltaX * ratioW;
        y -= deltaY * ratioH;

        if (x < 0)
            x = 0;
        if (y < 0)
            y = 0;
        if (x > w - viewPortW * ratioW)
            x = w - viewPortW * ratioW;
        if (y > h - viewPortH * ratioH)
            y = h - viewPortH * ratioH;

        map.svgobject.setAttribute('viewBox', x+' '+y+' '+w+' '+h);
    },

    /**
     * Centered map
     */
    centerMapCoords: function()
    {
        var coords = map.svgobject.getAttribute('viewBox').split(' ');
        var width  = parseInt(map.svgobject.getAttribute('width'));
        var height = parseInt(map.svgobject.getAttribute('height'));
        var viewPortW = parseInt($('.map').css('width'));
        var viewPortH = parseInt($('.map').css('height'));

        var x = parseInt(coords[0]);
        var y = parseInt(coords[1]);
        var w = parseInt(coords[2]);
        var h = parseInt(coords[3]);
        x = (w - viewPortW * (w / width)) / 2;
        y = (h - viewPortH * (h / height)) / 2;

        map.svgobject.setAttribute('viewBox', x+' '+y+' '+w+' '+h);
    },

    /**
     * Resize map
     */
    resize: function()
    {
        var footerH = $('.footer .footer-inner').height();
        var w = window.innerWidth;
        var h = window.innerHeight - footerH;
        if (w < 1024)
            w = 1024;
        if (w > 2048)
            w = 2048;
        if (h < 512)
            h = 512;
        $('.map').css({
            'width': w + 'px',
            'margin-left': parseInt(-w/2) + 'px'
        });
        $('.map-container').css({
            'height': h + 'px'
        });
        map.setMapCoords(0, 0);
    }
};




filter = {
    resize: function()
    {
        //$('#js-filter').css({'left':'11px', 'top':'11px'});
    }
};