panorama = {
    arr: {},

    init: function(data)
    {
        panorama.arr = data;

        // Нажатие на кнопках выбора вида
        $('#js-views').delegate('.view-button', 'click', function(ev) {
            var id = $(this).attr('data-id');
            $('#js-panorams .panorama').hide();
            $('[data-id="'+id+'"]').show();
        });

        // Этот код должен идти после назначения обработчика на view-button
        $('#js-date-items li').click( function(ev) {
            var date = $(this).attr('data-id');
            
            $('#js-date-value .value').text(date);

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
                output += "<div class='view-button' data-id='" + arr[prop]['swf'] + "'>Вид " + index + "</div>";
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