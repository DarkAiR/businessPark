map = {
    svgobject: null,    // svgobject
    mc: null,           // hammerjs
    snap: null,         // snap
    poly: null,
    freePoly: null,
    busyPoly: null,
    freePolyArr: [],
    busyPolyArr: [],
    areas: null,

    /**
     * Init SVG
     */
    init: function(svgobject, areas)
    {
        map.svgobject = svgobject;
        map.areas = areas;

        map.initHammerJS();

        // Создаем объект для рисования в SVG
        map.snap = Snap('.map svg');

        // Создание участков
        map.createAreas();
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

                var infoWndX = parseInt($('#js-info-window').css('left'));
                var infoWndY = parseInt($('#js-info-window').css('top'));
                $('#js-info-window').css({
                    'left': infoWndX + deltaX + 'px',
                    'top': infoWndY + deltaY + 'px'
                });
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
        map.nav.showViewport( map.getViewport() );
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
    },

    /**
     * Get viewport
     */
    getViewport: function()
    {
        var arr = map.svgobject.getAttribute('viewBox').split(' ');
        var width  = parseInt(map.svgobject.getAttribute('width'));
        var height = parseInt(map.svgobject.getAttribute('height'));
        return {
            'x':arr[0] * width / arr[2],
            'y':arr[1] * height / arr[3],
            'w':$('.map').width(),
            'h':$('.map').height(),
            'totalW':width,
            'totalH':height
        };
    },

    /**
     * Create selected area
     */
    createSelectedPolygon: function(el)
    {
        var tagName = el.prop("tagName");
        switch (tagName) {
            case 'polygon':
            case 'polyline':
                var points = el.attr('points');
                map.poly = map.snap.polyline(points);
                map.poly.attr('id', el.attr('id'));
                map.poly.attr('fill', 'rgba(255,255,255,0.3)');
                break;

            case 'path':
                var d = el.attr('d');
                map.poly = map.snap.path(d);
                map.poly.attr('id', el.attr('id'));
                map.poly.attr('fill', 'rgba(255,255,255,0.3)');
                break;
        }
        return map.poly;
    },

    /**
     * Remove selected area
     */
    removeSelectedPolygon: function()
    {
        if (map.poly == null)
            return;
        map.poly.remove();
        map.poly = null;
    },

    /**
     * Create polygon area
     */
    createPolygon: function(cont, el, fill)
    {
        fill = fill||'rgba(255,150,0,0.15)';
        var poly = null;
        var tagName = el.prop("tagName");
        switch (tagName) {
            case 'polygon':
            case 'polyline':
                var points = el.attr('points');
                poly = cont.polyline(points);
                break;

            case 'path':
                var d = el.attr('d');
                poly = cont.path(d);
                break;
        }
        if (poly != null) {
            var id = el.attr('id');
            poly.attr('id', id);
            poly.attr('fill', fill);
//            poly.attr('display', 'none');
        }
        return poly;
    },

    /**
     * Create busy areas
     */
    createAreas: function()
    {
        map.freePoly = map.snap.g();
        map.busyPoly = map.snap.g();

        for (var prop in map.areas) {
            if (map.areas.hasOwnProperty(prop)) {
                var area = map.areas[prop];
                if (area.busy) {
                    poly = map.createPolygon(map.busyPoly, $('[id^="area_"][id$="_' + prop + '"]'), 'rgba(255,50,50,0.15)');
                    if (poly)
                        map.busyPolyArr.push(poly);
                }
                else {
                    poly = map.createPolygon(map.freePoly, $('[id^="area_"][id$="_' + prop + '"]'), 'rgba(0,255,0,0.15)');
                    if (poly)
                        map.freePolyArr.push(poly);
                }
            } 
        };

        map.showFreeAreas(false);
        map.showBusyAreas(false);
    },

    /**
     * Show/hide free areas
     */
    showFreeAreas: function(isShow)
    {
        map.freePoly.attr('display', isShow ? 'block' : 'none');
    },

    /**
     * Show/hide busy areas
     */
    showBusyAreas: function(isShow)
    {
        map.busyPoly.attr('display', isShow ? 'block' : 'none');
    },



    /**
     * Info window
     */
    info: {
        // Set text and show/hide item element
        setItemText: function(selector, value, suffix)
        {
            suffix = suffix||'';
            var el = $(selector);
            if (value) {
                el.text( value + suffix );
                el.closest('.item').show();
            }
            else {
                el.text('');
                el.closest('.item').hide();
            }
        },

        // Set last class at items list
        setItemLast: function(selector)
        {
            var el = $(selector);
            el.find('.item').removeClass('last');

            var lastItem = null;
            el.find('.item').each( function() {
                if ($(this).css('display') != 'none')
                    lastItem = $(this);
            });
            if (lastItem != null)
                lastItem.addClass('last');
        },

        // Show free or busy info window
        showInfoWindow: function(area)
        {
            if (area.busy) {
                $('.window.busy').show();
                $('.window.free').hide();

                map.info.setItemText('.window.busy #js-info-status', 'занят');
                map.info.setItemText('#js-info-resident', area.resident);

                // После обработки всех пунктов
                map.info.setItemLast('.window.busy');
            } else {
                $('.window.busy').hide();
                $('.window.free').show();

                map.info.setItemText('.window.busy #js-info-status', 'свободен');
                map.info.setItemText('#js-info-square', area.square, ' га');
                map.info.setItemText('#js-info-size', area.size);

                // После обработки всех пунктов
                map.info.setItemLast('.window.free');
            }
        },

        // Show empty info window
        showEmptyInfoWindow: function()
        {
            $('.window.busy').hide();
            $('.window.free').show();
            $('.window.free .item').hide();
        },

        // Set window position
        setPosition: function(x, y)
        {
            var wnd = $('#js-info-window');
            var wndW = wnd.width();
            var wndH = wnd.height();
            
            var mapWnd = $('.map');
            var mapW = mapWnd.width();
            var mapH = mapWnd.height();
            var mapOffs = mapWnd.offset();

            //x -= mapOffs.left;
            y -= mapOffs.top;

            // Отступы от края карты
            var paddingH = 0;
            var paddingW = 22;

            // Не даем окну вылезти за пределы карты
            if (x < wndW/2 + paddingW)          x = wndW/2 + paddingW;
            if (x + wndW/2 + paddingW > mapW)   x = mapW - wndW/2 - paddingW;
            if (y < wndH + paddingH)            y = wndH + paddingH;
            if (y > mapH - paddingH)            y = mapH - paddingH;

            // Позиционируемся в центр низ
            x -= wndW/2;
            y -= wndH;

            wnd.css({
                'left': x+'px',
                'top': y+'px'
            });
            wnd.show();
        }
    },


    /**
     * Navigation window
     */
    nav: {
        snap: null,
        window: null,
        rect: null,

        init: function(selector)
        {
            var el = $(selector);
            map.nav.window = el.find('#js-window');

            var switchBtn = el.find('#js-switch-btn');
            switchBtn.click( function() {
                $(this).toggleClass('show');
                map.nav.window.toggleClass('show');
            });

            map.nav.snap = Snap(selector+' #js-window svg');
        },

        showViewport: function(viewport)
        {
            if (map.nav.rect != null)
                map.nav.rect.remove();
            map.nav.rect = null;

            var navW = map.nav.window.width();
            var navH = map.nav.window.height();
            var ratioW = navW / viewport.totalW;
            var ratioH = navH / viewport.totalH;

            map.nav.rect = map.nav.snap.rect(
                viewport.x * ratioW,
                viewport.y * ratioH,
                viewport.w * ratioW,
                viewport.h * ratioH
            ).attr({
                'fill': "rgba(255,255,255,1)",
                'fill-opacity': 0.2,
                'stroke': "rgba(0,0,0,0.2)",
                'strokeWidth': 1 
            });
        }
    },


    /**
     * Filter
     */
    filter: {
        window: null,

        init: function(selector)
        {
            var el = $(selector);
            map.filter.window = el;

            el.accordion({
                collapsible: true
            });

            el.find('#check-free').click( function(ev) {
                var status = $(this).prop('checked');
                if (status == true)
                    map.showFreeAreas(true);
                else
                    map.showFreeAreas(false);
            });
            el.find('#check-busy').click( function(ev) {
                var status = $(this).prop('checked');
                if (status == true)
                    map.showBusyAreas(true);
                else
                    map.showBusyAreas(false);
            });
        }
    }
};