tabmenu =
{
    eventTabSelect: "eventTabSelect",

    _items: {},
    _active: false,

    init: function()
    {
        var itemsEl = $('[tab_menu_item]');
        var pagesEl = $('[tab_menu_page]');
        var bFirst = true;
        var firstItemId = false;

        itemsEl.each( function()
        {
            var itemEl = $(this);
            var itemId = itemEl.attr('tab_menu_item');
            pagesEl.each( function()
            {
                var pageEl = $(this);
                var pageId = pageEl.attr('tab_menu_page');
                if (pageId == itemId)
                {
                    tabmenu._items[itemId] = {'item':itemEl, 'page':pageEl};

                    // Hide page until no one item selected
                    pageEl.hide();

                    if (bFirst)
                    {
                        bFirst = false;
                        firstItemId = itemId;
                    }
                }
            });

            itemEl.click( function()
            {
                tabmenu.select( $(this).attr('tab_menu_item') );
                return false;
            });
        });
        tabmenu.select( firstItemId );
    },

    /**
     * Выбор пункта меню
     */
    select: function( itemId )
    {
        if (itemId === false)
            return;
        if (tabmenu._items[itemId] === undefined)
            return;

        // Отключаем старую страницу
        if (tabmenu._active !== false && tabmenu._items[tabmenu._active] !== undefined)
        {
            tabmenu._items[tabmenu._active]['item'].parent().removeClass('active');
            tabmenu._items[tabmenu._active]['page'].hide();
        }
        tabmenu._items[itemId]['item'].parent().addClass('active');
        tabmenu._items[itemId]['page'].show();

        app.fire({type:tabmenu.eventTabSelect, elem:tabmenu._items[itemId]['page']});

        tabmenu._active = itemId;
    }
};