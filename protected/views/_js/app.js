app =
{
    // ceils
    eventReposition: "repositionElements",

    _listeners: {},          // Слушатели событий

    gridWidth: 288,
    gridHeight: 288,
    borderSize: 50,         // Размер бордюра справа и слева
    animDuration: 500,      // Длительность анимации

    isInit: false,

    init: function()
    {
        $(window).on('resize', function() { app.resize(); });
    },

    resize: function( isInit )
    {
        app.isInit = isInit || false;
//        if (isInit)
//            return;

        var self = this;
        var windowWidth = $(window).width();
        var actualWidth = windowWidth - app.borderSize * 2;
        var contWidth = app.gridWidth * 5;

        var ceils = 5;     // Количество отображаемых ячеек
        if (contWidth > actualWidth)
        {
            contWidth -= app.gridWidth;
            ceils--;
            if (contWidth > actualWidth)
            {
                contWidth -= app.gridWidth;
                ceils--;
            }
        }
        app.fire({type:app.eventReposition, ceils:ceils});
    },

    addListener: function(type, listener)
    {
        if (typeof this._listeners[type] == "undefined")
            this._listeners[type] = [];
        this._listeners[type].push(listener);
    },

    fire: function(event)
    {
        var event = event;
        if (typeof event == "string")
            event = { type:event };
        if (!event.target)
            event.target = this;
        if (!event.type)
            throw new Error("Event object missing 'type' property.");
        
        if (this._listeners[event.type] instanceof Array)
        {
            var listeners = this._listeners[event.type];
            for (var i = 0, len = listeners.length; i < len; i++)
                listeners[i].call(this, event);
        }
    },

    /**
     Плавно изменить размеры элемента
     */
    resizeElement: function(el, contWidth, onlyWidth, options)
    {
        onlyWidth = onlyWidth || false;
        var isHideAnim = el.data('isHideAnim') !== undefined;
        var isShowAnim = el.data('isShowAnim') !== undefined;
        var onComplete = (options && options['complete']) || function(){};
        var onProgress = (options && options['progress']) || function(){};

        if (contWidth < el.width())
        {
            if (isShowAnim)
            {
                el.stop();
                el.removeData('isShowAnim');
                isShowAnim = false;
                isHideAnim = false;
            }
            if (!isHideAnim)
            {
                el.data('isHideAnim', true);
                
                var params = { 'width': contWidth+'px' };
                if (!onlyWidth)
                    params['margin-left'] = '-'+Math.floor(contWidth/2)+'px';

                el.animate(params, {
                    'duration': (app.isInit)? 0 : app.animDuration,
                    'progress': onProgress,
                    'complete': function()
                    {
                        el.removeData('isHideAnim');
                        onComplete.call();
                    }
                });
            }
        }
        else if (contWidth > el.width())
        {
            if (isHideAnim)
            {
                el.stop();
                el.removeData('isHideAnim');
                isShowAnim = false;
                isHideAnim = false;
            }
            if (!isShowAnim)
            {
                el.data('isShowAnim', true);

                var params = { 'width': contWidth+'px' };
                if (!onlyWidth)
                    params['margin-left'] = '-'+Math.floor(contWidth/2)+'px';

                el.animate(params, {
                    'duration': (app.isInit)? 0 : app.animDuration,
                    'progress': onProgress,
                    'complete': function()
                    {
                        el.removeData('isShowAnim');
                        onComplete.call();
                    }
                });
            }
        }
    }
};

$(document).ready( function()
{
    app.init();
});