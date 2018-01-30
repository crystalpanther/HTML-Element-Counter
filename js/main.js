/**
 * Created by elina on 1/2/2018.
 */
$(window).on('load', function () {
    function loadURL() {
        var url = $('#url').val();
        var htmlElement = $('#htmlElement').val();
        var domain = url.match(/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/img);
        var duration;
        var startTIme = Date.now();

        if (domain) {
            domain = domain[0];
        }
        var windows = $('.window');
        var formData = {
            'url': url,
            'htmlElement': htmlElement,
            'domain': domain,
            'duration': duration
        };

        $.ajax({
            url: 'parsing.php',
            type: 'POST',
            data: formData,
            headers: {
                'Access-Control-Allow-Origin': '*' //access CORS
            },
            success: function (data) {
                var d = new Date(); //identify the date
                var day = d.getDate();
                var month = d.getMonth() + 1;
                var year = d.getFullYear();
                var hour = d.getHours();
                var min = d.getMinutes();

                var nowTime = day + '/' + month + '/' + year + ' ' + hour + ':' + min; //show up the time

                var el = '<' + htmlElement + '>';

                var element = $(el); //take an input value
                var pages = element.html(data);
                var length = $(htmlElement, element).length;
                windows.html('URL ' + url + ' Fetched on ' + nowTime + ' , took ' + duration + 'msec. ' + 'Element ' + '<' +
                    htmlElement + '>' + ' appeared ' + length + ' times in page.' + ' ' + domain); // output

            },
            error: function () {
                console.log('error');
            },
        });

        var endTime = Date.now();
        duration = endTime - startTIme;
    }
    function getStat() {
        var url = $('#url').val();
        var htmlElement = $('#htmlElement').val();

        var domain = url.match(/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/img);
        domain = domain[0];

        var windows = $('.window');
        var staticOut = $('#content');

        $.ajax({
            url: 'dataBase.php',
            type: 'GET',
            data: {
                'url': url,
                'htmlElement': htmlElement,
                'domain': domain
            },
            headers: {
                'Access-Control-Allow-Origin': '*' //access CORS
            },
            success: function (data) {
                $('#content').html(data);
            },
            error: function () {
                console.log('error');
            }
        });
    }
    $('#form').each(function () {
        function checkInput() {
            var url = $('#url');
            var element = $('#htmlElement');
            if (url.val() === '') {
                url.addClass('red');
                $('#error-url').text('Please add URL address');
                return false;
            }
            else if (!url.val().match(/^[a-zA-Z]+:\/\//)) {
                url.addClass('red');
                $('#error-url').text('Please add correct URL address (http:// or https://) ');
                return false;
            }
            else if (element.val() === '') {
                element.addClass('red');
                $('#error-tag').text('Please add tag');
                return false;
            }
            return true;
        }

        // setInterval(function() {
        //     //Запускаем функцию проверки полей на заполненность
        //     checkInput();
        //     var sizeEmpty = section.find('.red').size();
        //     //считаем количество заполненных полей
        //     if(sizeEmpty > 0) {
        //         if (btn.hasClass('.pull-right')){
        //             return false;
        //         } else {
        //             btn.addClass('.pull-right');
        //         }
        //     } else {
        //         btn.removeClass('.pull-right');
        //
        //     }
        // }, 500);

        //событие клика по кнопке отправить
        $('#getUrl').click('on', function () {
            $('input').each(function () {
                checkInput();
                if (checkInput() === true) {
                    $(this).removeClass('red');
                    $('.error-msg').text('');
                    loadURL();
                }
            });

        });
        $('#getStat').click('on', function () {
            $('input').each(function () {
                checkInput();
                if (checkInput() === true) {
                    $(this).removeClass('red');
                    $('.error-msg').text('');
                    getStat();
                }
            });
        });
    });
});



