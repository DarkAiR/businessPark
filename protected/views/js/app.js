app =
{
    // ceils
    eventReposition: "repositionElements",

    _listeners: {},          // Слушатели событий

    bigWorkWidth: 272 * 3,
    workWidth: 272,
    workHeight: 272,
    borderSize: 50,         // Размер бордюра справа и слева
    animDuration: 500,      // Длительность анимации

    init: function()
    {
        $(window).on('resize', function() { app.resize(); });
    },

    resize: function()
    {
        var self = this;
        var windowWidth = $(window).width();
        var actualWidth = windowWidth - app.borderSize * 2;
        var contWidth = app.workWidth * 5;

        var ceils = 5;     // Количество отображаемых ячеек
        if (contWidth > actualWidth)
        {
            contWidth -= app.workWidth;
            ceils--;
            if (contWidth > actualWidth)
            {
                contWidth -= app.workWidth;
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
};

$(document).ready( function()
{
    app.init();
});