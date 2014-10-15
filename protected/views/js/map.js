map = {
    svgW: 6803,
    svgH: 6750,
    zoom: 5,

    svgobject: null,    // svgobject
    mc: null,           // hammerjs
    snap: null,         // snap
    poly: null,         // выделенный полигон
    polyHover: null,    // наведенный полигон
    busyPoly: null,     // группа занятых полигонов
    areas: null,
    markers: {},        // маркеры на карте

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

        // zoom
        map.initZoom();
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

    initZoom: function()
    {
        $('.zoom .plus').click( function() {
            var dz = 0.0;
            if (map.zoom > 3)
                dz = -1.0;
            map.zoom += dz;
            map.setMapCoords(0, 0, dz);
        });
        $('.zoom .minus').click( function() {
            var dz = 0.0;
            if (map.zoom < 8)
                dz = 1.0;
            map.zoom += dz;
            map.setMapCoords(0, 0, dz);
        });
    },

    /**
     * Set map coords
     * deltaX/Y - screen offset
     */
    setMapCoords: function(deltaX, deltaY, deltaZoom)
    {
        deltaZoom = deltaZoom||0.0;

        // Center map
        var coords = map.getViewport();
        var cx = parseInt(coords.w / 2 + coords.x);
        var cy = parseInt(coords.h / 2 + coords.y);

        // Viewport size
        var vpW2 = parseInt(parseInt($('.map').css('width')) * map.zoom / 2); 
        var vpH2 = parseInt(parseInt($('.map').css('height')) * map.zoom / 2);

        // Move center
        cx3 = cx2 = cx - deltaX * map.zoom;
        cy3 = cy2 = cy - deltaY * map.zoom;
        if (deltaX >= 0  &&  cx - vpW2 >= 0) {
            cx3 = (cx2 - vpW2 >= 0) ? cx2 : vpW2;
        }
        if (deltaY >= 0  &&  cy - vpH2 >= 0) {
            cy3 = (cy2 - vpH2 >= 0) ? cy2 : vpH2;
        }
        if (deltaX < 0  &&  cx + vpW2 < map.svgW) {
            cx3 = (cx2 + vpW2 <= map.svgW) ? cx2 : map.svgW - vpW2;
        }
        if (deltaY < 0  &&  cy + vpH2 < map.svgH) {
            cy3 = (cy2 + vpH2 <= map.svgH) ? cy2 : map.svgH - vpH2;
        }

        var realDeltaX = (cx - cx3) / map.zoom;
        var realDeltaY = (cy - cy3) / map.zoom;

        // Move markers
        map.moveMarkers(realDeltaX, realDeltaY, deltaZoom);

        // Move info window
        map.info.move(realDeltaX, realDeltaY, deltaZoom);

        // Set viewbox and nav
        map.svgobject.setAttribute('viewBox', (parseInt(cx3-vpW2))+' '+(parseInt(cy3-vpH2))+' '+(parseInt(vpW2*2))+' '+(parseInt(vpH2*2)));
        map.nav.showViewport( map.getViewport() );
    },

    /**
     * Centered map
     */
    centerMapCoords: function()
    {
        var vpW = parseInt(parseInt($('.map').css('width')) * map.zoom);
        var vpH = parseInt(parseInt($('.map').css('height')) * map.zoom);
        var x = parseInt((map.svgW - vpW) / 2);
        var y = parseInt((map.svgH - vpH) / 2);
        map.svgobject.setAttribute('viewBox', x+' '+y+' '+vpW+' '+vpH);
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
        return {
            'x': parseInt(arr[0]),
            'y': parseInt(arr[1]),
            'w': parseInt(arr[2]),
            'h': parseInt(arr[3])
        };
    },

    /**
     * Create selected area
     */
    createSelectedPolygon: function(el, hover)
    {
        var poly = null;
        switch (el.prop("tagName")) {
            case 'polygon':
            case 'polyline':
                var points = el.attr('points');
                poly = map.snap.polyline(points);
                break;

            case 'path':
                var d = el.attr('d');
                poly = map.snap.path(d);
                break;
        }
        if (poly) {
            poly.attr('id', el.attr('id'));
            if (hover) {

                // Наведение
                poly.attr({
                    'fill': 'rgba(255,255,255,0.3)'
                });
                map.polyHover = poly;
            } else {

                // Выделение
                poly.attr({
                    'fill': 'rgba(255,255,255,0.5)',
                    'pointer-events': 'none'
                });
                map.poly = poly;
            }
        }
        return poly;
    },

    /**
     * Remove selected area
     */
    removeSelectedPolygon: function(hover)
    {
        if (hover) {
            if (map.polyHover == null)
                return;
            map.polyHover.remove();
            map.polyHover = null;
        } else {
            if (map.poly == null)
                return;
            map.poly.remove();
            map.poly = null;
        }
    },

    /**
     * Create polygon area
     */
    createPolygon: function(cont, el, style)
    {
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
            poly.attr(style);
//            poly.attr('display', 'none');
        }
        return poly;
    },

    /**
     * Create busy areas
     */
    createAreas: function()
    {
        map.busyPoly = map.snap.g();

        for (var prop in map.areas) {
            if (!map.areas.hasOwnProperty(prop))
                continue;

            var area = map.areas[prop];
            if (area.busy) {
                // Занятый
                map.createPolygon(map.busyPoly, $('[id^="area_"][id$="_' + prop + '"]'), {'fill':'rgba(225,83,83,0.3)'});
            }
        };

        map.showBusyAreas(false);
    },

    /**
     * Show/hide busy areas
     */
    showBusyAreas: function(isShow)
    {
        map.busyPoly.attr('display', isShow ? 'block' : 'none');
    },

    /**
     * Show/hide markers
     */
    showMarkers: function(key, selector, isShow)
    {
        // Смещение маркера от места появления для анимации
        var markerShowOffs = 20;

        if (isShow) {
            if (map.markers[key] == undefined) {
                // Create markers
                map.markers[key] = [];
                var vp = map.getViewport();

                var el = $(selector);
                el.each( function() {
                    var bBox = this.getBBox();
                    var cx = bBox.x + bBox.width / 2;
                    var cy = bBox.y + bBox.height / 2;
                    cx = parseInt((cx - vp.x) / map.zoom) + $('.map').offset().left / 2;
                    cy = parseInt((cy - vp.y) / map.zoom);

                    var marker = $('<div/>', {
                        class: 'marker '+key,
                        style: 'left:'+cx+'px; top:'+(cy-markerShowOffs)+'px;'
                    });
                    marker.css({opacity:0.0}).appendTo('.markers');
                    map.markers[key].push(marker);
                });
            }

            for (var i = 0; i < map.markers[key].length; i++) {
                map.markers[key][i]
                    .delay(Math.random()*300)
                    .animate({
                        top: '+='+markerShowOffs,
                        opacity: 1.0,
                    }, 400, "easeOutBounce"
                );
            };
        } else {
            for (var i = 0; i < map.markers[key].length; i++) {
                map.markers[key][i].animate({
                    top: '-='+markerShowOffs,
                    opacity: 0.0
                }, 500);
            };
        }
    },

    /**
     * Move markers
     */
    moveMarkers: function(deltaX, deltaY, deltaZoom)
    {
        // Viewport center
        var vpCx = parseInt($('.map').css('width')) / 2; 
        var vpCy = parseInt($('.map').css('height')) / 2;

        for (var prop in map.markers) {
            if (!map.markers.hasOwnProperty(prop))
                continue;

            for (var j = 0; j < map.markers[prop].length; j++) {
                var el = map.markers[prop][j];

                var elX = parseInt(el.css('left'));
                var elY = parseInt(el.css('top'));

                var elX2 = vpCx + (elX - vpCx) * (map.zoom - deltaZoom) / map.zoom;
                var elY2 = vpCy + (elY - vpCy) * (map.zoom - deltaZoom) / map.zoom;

                el.animate({
                    left: '+=' + (deltaX + (elX2 - elX)),
                    top: '+=' + (deltaY + (elY2 - elY))
                }, 0);
            }
        }
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

                map.info.setItemText('.window.free #js-info-status', 'свободен');
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
            map.info.setItemText('.window.free #js-info-status', 'свободен');
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
        },

        move: function(deltaX, deltaY, deltaZoom)
        {
            // Viewport center
            var vpCx = parseInt($('.map').css('width')) / 2; 
            var vpCy = parseInt($('.map').css('height')) / 2;

            var infoX = parseInt($('#js-info-window').css('left'));
            var infoY = parseInt($('#js-info-window').css('top'));

            var infoX2 = vpCx + (infoX - vpCx) * (map.zoom - deltaZoom) / map.zoom;
            var infoY2 = vpCy + (infoY - vpCy) * (map.zoom - deltaZoom) / map.zoom;

            $('#js-info-window').animate({
                'left': '+=' + (deltaX + (infoX2 - infoX)),
                'top': '+=' + (deltaY + (infoY2 - infoY))
            }, 0);
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
            var ratioW = navW / map.svgW;
            var ratioH = navH / map.svgH;

            var x = viewport.x * ratioW;
            var y = viewport.y * ratioH;
            var w = viewport.w * ratioW;
            var h = viewport.h * ratioH;
            if (x < 0)      x = 0;
            if (y < 0)      y = 0;
            if (x+w > navW) w = navW - x;
            if (y+h > navH) h = navH - y;

            map.nav.rect = map.nav.snap.rect(x,y,w,h)
                .attr({
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

        init: function(selector, showType)
        {
            var el = $(selector);
            map.filter.window = el;

            el.accordion({
                collapsible: true
            });

            el.find('.header').click( function() {
                $(this).find('.arrow').toggleClass('rotate');
            });

            el.find('#check-busy').click( function(ev) {
                var status = $(this).prop('checked');
                map.showBusyAreas(status);
            });
            el.find('#check-f1').click( function(ev) {
                var status = $(this).prop('checked');
                map.showMarkers('red', '[id^="red_"]', status); 
            });
            el.find('#check-f2').click( function(ev) {
                var status = $(this).prop('checked');
                map.showMarkers('yellow', '[id^="yellow_"]', status); 
            });
            el.find('#check-f3').click( function(ev) {
                var status = $(this).prop('checked');
                map.showMarkers('blue', '[id^="blue_"]', status); 
            });
            el.find('#check-f4').click( function(ev) {
                var status = $(this).prop('checked');
                map.showMarkers('purple', '[id^="purple_"]', status); 
            });
            el.find('#check-f5').click( function(ev) {
                var status = $(this).prop('checked');
                map.showMarkers('green', '[id^="green_"]', status); 
            });

            // Обрабатываем тип заранее заданные нажатия на фильтре
            switch (showType) {
                case 'busy':
                    el.find('#check-busy').trigger('click');
                    break;
            }
        }
    }
};