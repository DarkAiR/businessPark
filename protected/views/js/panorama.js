panorama = {
    arr: {},

    init: function(data)
    {
        panorama.arr = data;

        // Нажатие на кнопках выбора вида
        $('#js-views').delegate('.view-button', 'click', function(ev) {
            var id = $(this).attr('data-id');
            var version = parseInt($(this).attr('data-version'));

            switch (version) {
                // Старая панорама
                case  1:    // Panorama::VERSION_1
                    $('#panoDIV').hide();
                    $('#js-panorams .panorama').hide();
                    $('[data-id="'+id+'"]').show();
                    break;

                // Новая панорама
                case  2:    // Panorama::VERSION_2
                    $('#panoDIV').show();
                    $('#js-panorams .panorama').hide();
                    embedpano({                    
                        swf: "/panotour/"+id,
                        target: "panoDIV",
                        passQueryParameters: true
                    });
                    break;
            }
        });

        // Этот код должен идти после назначения обработчика на view-button
        $('#js-date-items li').click( function(ev) {
            var date = $(this).attr('data-id');
            var dateText = $(this).text();

            $('#js-date-value .value').text(dateText);

            if (panorama.arr[date] == undefined) {
                console.error('Date "' + date + '" not found');
                return false;
            }

            var output = '';
            var index = 1;
            var arr = panorama.arr[date];
            for (var prop in arr) {
                if (!arr.hasOwnProperty(prop))
                    continue;
                output += "<div class='view-button' data-id='" + arr[prop]['swf'] + "' data-version='" + arr[prop]['version'] + "'>Вид " + index + "</div>";
                index++;
            }
            $('#js-views').html(output);

            // Нажимаем кнопку первого вида
            $('#js-views .view-button:first').trigger('click');
        });
        // Нажимаем кнопку первой даты
        $('#js-date-items li:first').trigger('click');
    }
};