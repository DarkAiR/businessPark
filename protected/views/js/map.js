map = {
    svgW: 6803,
    svgH: 6750,
    zoom: 5,

    svgobject: null,        // svgobject
    mc: null,               // hammerjs
    snap: null,             // snap
            
    selectedPolyId: 0,      // Выделения полигона

    poly: null,             // выделенный полигон
    polyHover: null,        // наведенный полигон
    busyPoly: null,         // группа занятых полигонов
    areas: null,
    structureAreas: null,
    markers: {},            // маркеры на карте

    /**
     * Init SVG
     */
    init: function(svgobject, areas, structureAreas)
    {
        map.svgobject = svgobject;
        map.areas = areas;
        map.structureAreas = structureAreas;

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
        var hammerMarker    = Hammer($('#js-markers').get(0));
        var hammerNav       = Hammer($('#js-window').get(0));

        mc = map.mc;
        mc.get('pan').set({ direction: Hammer.DIRECTION_ALL, 'threshold':32 });
        mc.get('pinch').set({ enable: true });
        mc.get('rotate').set({ enable: true });
        mc.get('tap').set({ 'enable': true, 'threshold':32, 'time':1000 });

        hammerMarker.get('tap').set({ 'enable': true, 'threshold':32, 'time':1000 });

        hammerNav.get('pan').set({ direction: Hammer.DIRECTION_ALL, 'threshold':1 });
        hammerNav.get('tap').set({ 'enable': true/*, 'threshold':32, 'time':1000*/ });

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

        mc.on('tap', function(e) {
            var id = $(e.target).attr('data-id');

            var regStr = /^area_/i;
            if (regStr.exec(id)) {
                if (id != map.selectedPolyId) {
                    map.removeSelectedPolygon();
                    map.createSelectedPolygon($(e.target));
                    map.selectedPolyId = id;
                }

                var cadastralNumber = /\d+$/i.exec(id);
                if (cadastralNumber != null) {
                    cadastralNumber = cadastralNumber[0];

                    // Устанавливаем кадастровый номер здесь, чтобы он появился даже у отсутсвующего окна
                    $('#js-cadastral-number').text( cadastralNumber );

                    var x = e.pointers[0].pageX;
                    var y = e.pointers[0].pageY;
                    if (map.areas[cadastralNumber] != undefined)
                        map.info.showInfoWindow( map.areas[cadastralNumber], x, y );
                    else
                        map.info.showEmptyInfoWindow(x, y);

                    //map.info.setPosition(x, y - 30);        // Смещение окна, подбирается вручную
                }
            }
        });

        hammerMarker.on('tap', function(e) {
            if (map.infrastructure.hasHover == true)
                return;

            var areaId = $(e.target).attr('data-area') + '';

            var offs = $(e.target).offset();
            var x = offs.left + $(e.target).outerWidth()/2;
            var y = offs.top + $(e.target).outerHeight()/2;

            map.infrastructure.toggleWindow(areaId, x, y);
        });


        // Map navigation
        hammerNav.on("panstart", function(e) {
            var x = e.pointers[0].pageX;
            var y = e.pointers[0].pageY;
            map.nav.panstart(x, y);
        });
        hammerNav.on("panend", function(e) {
            map.nav.panend();
        });
        hammerNav.on("panmove", function(e) {
            var x = e.pointers[0].pageX;
            var y = e.pointers[0].pageY;
            map.nav.panmove(x, y);
        });
        hammerNav.on('tap', function(e) {
            var x = e.pointers[0].pageX;
            var y = e.pointers[0].pageY;
            map.nav.click(x, y);
        });
    },

    initZoom: function()
    {
        $('.zoom .plus').click( function() {
            var dz = (map.zoom > 3) ? -1.0 : 0.0;
            map.zoom += dz;
            map.setMapCoords(0, 0);
        });
        $('.zoom .minus').click( function() {
            var dz = (map.zoom < 8) ? 1.0 : 0.0;
            map.zoom += dz;
            map.setMapCoords(0, 0);
        });
    },

    /**
     * Set map coords
     * deltaX/Y - screen offset
     */
    setMapCoords: function(deltaX, deltaY)
    {
        // Center map
        var coords = map.getViewport();
        var cx = parseInt(coords.w / 2 + coords.x);
        var cy = parseInt(coords.h / 2 + coords.y);

        // Viewport size
        var vpW2 = parseInt(parseInt($('.map').css('width')) * map.zoom / 2); 
        var vpH2 = parseInt(parseInt($('.map').css('height')) * map.zoom / 2);

        // Move center
        cx2 = cx - deltaX * map.zoom;
        cy2 = cy - deltaY * map.zoom;

        if (deltaX >= 0  &&  cx - vpW2 >= 0) {
            cx = (cx2 - vpW2 >= 0) ? cx2 : vpW2;
        }
        if (deltaY >= 0  &&  cy - vpH2 >= 0) {
            cy = (cy2 - vpH2 >= 0) ? cy2 : vpH2;
        }
        if (deltaX < 0  &&  cx + vpW2 < map.svgW) {
            cx = (cx2 + vpW2 <= map.svgW) ? cx2 : map.svgW - vpW2;
        }
        if (deltaY < 0  &&  cy + vpH2 < map.svgH) {
            cy = (cy2 + vpH2 <= map.svgH) ? cy2 : map.svgH - vpH2;
        }

        // Set viewbox and nav
        map.svgobject.setAttribute('viewBox', (parseInt(cx-vpW2))+' '+(parseInt(cy-vpH2))+' '+(parseInt(vpW2*2))+' '+(parseInt(vpH2*2)));
        map.nav.showViewport();

        // Place markers and info window
        map.placeMarkers();
        map.info.placeWindow();
        map.infrastructure.placeWindow();
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

        // Максимальный размер карты, по сути не важно сколько здесь точек
        if (w > 20480)
            w = 20480;
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
            poly.attr('data-id', el.attr('id'));
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
            poly.attr('data-id', id);
            poly.attr(style);
//            poly.attr('display', 'none');
        }
        return poly;
    },

    /**
     * Create areas
     */
    createAreas: function()
    {
        map.busyPoly    = map.snap.g();

        for (var prop in map.areas) {
            if (!map.areas.hasOwnProperty(prop))
                continue;

            var area = map.areas[prop];
            if (area.busy) {
                // Занятый
                map.createPolygon(map.busyPoly, $('[id^="area_"][id$="_' + prop + '"]'), {'fill':'rgba(225,83,83,0.3)'});
            }
        };

        for (var groupName in map.structureAreas) {
            if (!map.structureAreas.hasOwnProperty(groupName))
                continue;

            $('[id^="'+groupName+'_"]').each( function() {
                map.createPolygon(map.busyPoly, $(this), {'fill':'rgba(225,83,83,0.3)'});
            });
        };

        overFunc = function(ev)
        {
            map.removeSelectedPolygon(true);
            var poly = map.createSelectedPolygon($(this), true);
            if (poly) {
                poly.mouseout( function() {
                    map.removeSelectedPolygon(true);
                });
            }
        };

        $('[id^="area_"]').mouseover(overFunc);

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
     *
     */
    nameCleanup: function(str)
    {
        return str.replace(/\_\d+\_$/g, "");
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

                $(selector).each( function() {

                    // Fix name
                    var id = map.nameCleanup($(this).attr('id'));
                    $(this).attr('id', id);

                    var marker = $('<div/>', {
                        class: 'marker '+key,
                    });
                    marker
                        .css({opacity:0.0})
                        .attr('data-area', id)
                        .mouseenter(map.infrastructure.onEnter)
                        .mouseleave(map.infrastructure.onLeave)
                        .appendTo('.markers');
                    map.markers[key].push(marker);
                });
            }

            map.placeMarkers();

            for (var i = 0; i < map.markers[key].length; i++) {
                map.markers[key][i]
                    .animate({
                        top: '-='+markerShowOffs
                    }, 0)
                    .delay(Math.random()*300)
                    .animate({
                        top: '+='+markerShowOffs,
                        opacity: 1.0,
                    }, 400, "easeOutBounce");
            };
        } else {
            for (var i = 0; i < map.markers[key].length; i++) {
                map.markers[key][i]
                    .delay(Math.random()*150)
                    .animate({
                        top: '-='+markerShowOffs,
                        opacity: 0.0
                    }, 500);
            };
        }
    },

    /**
     * Place markers
     */
    placeMarkers: function()
    {
        var vp = map.getViewport();
        var mapOffsX = $('.map').offset().left / 2;

        for (var prop in map.markers) {
            if (!map.markers.hasOwnProperty(prop))
                continue;

            for (var j = 0; j < map.markers[prop].length; j++) {
                var marker = map.markers[prop][j];
                var areaId = marker.attr('data-area');
                var area = $(map.svgobject).find('#'+areaId).get(0);

                var bBox = area.getBBox();
                var cx = bBox.x + bBox.width / 2;
                var cy = bBox.y + bBox.height / 2;
                cx = parseInt((cx - vp.x) / map.zoom) + mapOffsX;
                cy = parseInt((cy - vp.y) / map.zoom);

                marker.css({
                    'left': cx+'px',
                    'top': cy+'px'
                });
            }
        }
    },


    /**
     * Infrastructure window
     */
    infrastructure: {
        areaId: null,       // Id последней отображенной инфы
        isShow: false,
        hasHover: false,    // Выключается, если можно работать через hover

        toggleWindow: function(areaId, x, y)
        {
            var arr = /^(\w+)\_.*\_(\d+)$/i.exec(areaId);
            var type = arr[1];
            var number = arr[2];

            if (map.structureAreas[type] == undefined)
                return;

            if (map.structureAreas[type][number] == undefined)
                return;

            var wnd = $('#js-structure-info-window');
            if (map.infrastructure.isShow == false || map.infrastructure.areaId != areaId ) {
                wnd.find('.text').html(map.structureAreas[type][number]['name']);
                map.infrastructure.areaId = areaId;

                map.infrastructure.storeCoords(x, y);
                map.infrastructure.placeWindow();
            } else {
                map.infrastructure.closeWindow();
            }
        },

        closeWindow: function()
        {
            $('#js-structure-info-window').hide();
            map.infrastructure.isShow = false;
            map.infrastructure.areaId = null;
        },

        // Store coords
        storeCoords: function(x, y)
        {
            var vp = map.getViewport();
            var mapOffsX = $('.map').offset().left;
            var mapOffsY = $('.map').offset().top;

            x = (x - mapOffsX) * map.zoom + vp.x;
            y = (y - mapOffsY) * map.zoom + vp.y;

            $('#js-structure-info-window')
                .attr({
                    'data-x': x,
                    'data-y': y
                })
                .show();
            
            map.infrastructure.isShow = true;
            map.info.closeWindow();
        },

        // Place window
        placeWindow: function()
        {
            if (!map.infrastructure.isShow)
                return;

            var wnd = $('#js-structure-info-window');
            var wndW = wnd.width();
            var wndH = wnd.height();
            var x = wnd.attr('data-x');
            var y = wnd.attr('data-y');

            var mapWnd = $('.map');
            var mapW = mapWnd.width();
            var mapH = mapWnd.height();
            var mapOffsX = mapWnd.offset().left;
            var mapOffsY = mapWnd.offset().top;

            var vp = map.getViewport();

            x = (x - vp.x) / map.zoom + mapOffsX;
            y = (y - vp.y) / map.zoom - 20;     // Смещение окна, подбирается вручную

            // Позиционируемся в центр низ
            x -= wndW/2;
            y -= wndH;

            wnd.css({
                'left': x+'px',
                'top': y+'px'
            });
        },

        onEnter: function(ev)
        {
            map.infrastructure.hasHover = true;

            var areaId = $(this).attr('data-area') + '';

            var offs = $(this).offset();
            var x = offs.left + $(this).outerWidth()/2;
            var y = offs.top + $(this).outerHeight()/2;

            map.infrastructure.toggleWindow(areaId, x, y);
        },

        onLeave: function(ev)
        {
            map.infrastructure.closeWindow();
        }
    },


    /**
     * Info window
     */
    info: {
        isShow: false,

        init: function()
        {
            // Окно информации
            $('#js-info-close-btn').click( function(ev) {
                map.removeSelectedPolygon();
                map.selectedPolyId = 0;
                map.info.closeWindow();
            });
        },

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
        showInfoWindow: function(area, x, y)
        {
            if (area.busy) {
                $('.window.busy').show();
                $('.window.free').hide();

                map.info.setItemText('.window.busy #js-info-status', 'занят');
                map.info.setItemText('.window.busy #js-info-resident', area.resident);

                // После обработки всех пунктов
                map.info.setItemLast('.window.busy');
            } else {
                $('.window.busy').hide();
                $('.window.free').show();

                map.info.setItemText('.window.free #js-info-status', 'свободен');
                map.info.setItemText('.window.free #js-info-square', area.square, ' га');
                map.info.setItemText('.window.free #js-info-size', area.size);

                // После обработки всех пунктов
                map.info.setItemLast('.window.free');
            }

            map.info.storeCoords(x, y);
            map.info.placeWindow();
        },

        // Show empty info window
        showEmptyInfoWindow: function(x, y)
        {
            $('.window.busy').hide();
            $('.window.free').show();
            $('.window.free .item').hide();

            map.info.setItemText('.window.free #js-info-status', 'свободен');

            map.info.storeCoords(x, y);
            map.info.placeWindow();
        },

        // Store coords
        storeCoords: function(x, y)
        {
            var vp = map.getViewport();
            var mapOffsX = $('.map').offset().left;
            var mapOffsY = $('.map').offset().top;

            x = (x - mapOffsX) * map.zoom + vp.x;
            y = (y - mapOffsY) * map.zoom + vp.y;

            $('#js-info-window')
                .attr({
                    'data-x': x,
                    'data-y': y
                })
                .show();
            
            map.info.isShow = true;
            map.infrastructure.closeWindow();
        },

        // Place window
        placeWindow: function()
        {
            if (!map.info.isShow)
                return;

            var wnd = $('#js-info-window');
            var wndW = wnd.width();
            var wndH = wnd.height();
            var x = wnd.attr('data-x');
            var y = wnd.attr('data-y');

            var mapWnd = $('.map');
            var mapW = mapWnd.width();
            var mapH = mapWnd.height();
            var mapOffsX = mapWnd.offset().left;
            var mapOffsY = mapWnd.offset().top;

            var vp = map.getViewport();

            x = (x - vp.x) / map.zoom/* + mapOffsX*/;
            y = (y - vp.y) / map.zoom;

            // Смещение окна, подбирается вручную
            y -= 20;
/*
            // Отступы от края карты
            var paddingH = 0;
            var paddingW = 22;

            // Не даем окну вылезти за пределы карты
            if (x < wndW/2 + paddingW)          x = wndW/2 + paddingW;
            if (x + wndW/2 + paddingW > mapW)   x = mapW - wndW/2 - paddingW;
            if (y < wndH + paddingH)            y = wndH + paddingH;
            if (y > mapH - paddingH)            y = mapH - paddingH;
*/
            // Позиционируемся в центр низ
            x -= wndW/2;
            y -= wndH;

            wnd.css({
                'left': x+'px',
                'top': y+'px'
            });
        },

        closeWindow: function()
        {
            $('#js-info-window').hide();
            map.info.isShow = false;
        }
    },


    /**
     * Navigation window
     */
    nav: {
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

            map.nav.rect = el.find('#js-selector');
        },

        showViewport: function()
        {
            var viewport = map.getViewport();
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

            map.nav.rect.css({
                left:   x+'px',
                top:    y+'px',
                width:  w,
                height: h
            })
        },

        setViewportCenter: function(cx, cy)
        {
            var viewport = map.getViewport();
            var navW = map.nav.window.width();
            var navH = map.nav.window.height();
            var ratioW = navW / map.svgW;
            var ratioH = navH / map.svgH;

            var w = viewport.w * ratioW;
            var h = viewport.h * ratioH;
            if (w > navW) w = navW;
            if (h > navH) h = navH;
            x = cx - w / 2;
            y = cy - h / 2;

            if (x < 0)      x = 0;
            if (y < 0)      y = 0;
            if (x+w > navW) x = navW - w;
            if (y+h > navH) y = navH - h;

            map.nav.rect.css({
                left:   parseInt(x) + 'px',
                top:    parseInt(y) + 'px'
            })

            viewport.x = x / ratioW;
            viewport.y = y / ratioH;
            map.svgobject.setAttribute('viewBox', viewport.x+' '+viewport.y+' '+viewport.w+' '+viewport.h);
        },

        click: function(x, y)
        {
            var offs = map.nav.window.offset();
            map.nav.setViewportCenter(x - offs.left, y - offs.top);
        },

        panstart: function(x, y)
        {
            $('body').addClass('noSelect');
            var offs = map.nav.window.offset();
            map.nav.setViewportCenter(x - offs.left, y - offs.top);
        },

        panend: function()
        {
            $('body').removeClass('noSelect');
        },

        panmove: function(x, y)
        {
            var offs = map.nav.window.offset();
            map.nav.setViewportCenter(x - offs.left, y - offs.top);
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