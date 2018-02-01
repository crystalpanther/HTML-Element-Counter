/**
 * Created by elina on 1/2/2018.
 */
let duration;
let startTIme = Date.now();
function loadURL() {
    let url = $('#url').val();
    let htmlElement = $('#htmlElement').val();
    let domain = url.match(/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/img);
    if (domain) {
        domain = domain[0];
    }
    let windows = $('.window');
    let formData;
    formData = {
        'url': url,
        'htmlElement': htmlElement,
        'domain': domain,
        'duration': duration
    };

    $.ajax({
        url: 'parsing.php',
        type: 'POST',
        data: formData,
        timeout: 10000,
        beforeSend : function() {
            $('.preload-three').addClass('visible');
        },
        headers: {
            'Access-Control-Allow-Origin': '*' //access CORS
        },
        success: function (data, textStatus, XMLHttpRequest) {
            let d = new Date(); //identify the date
            let day = d.getDate();
            let month = d.getMonth() + 1;
            let year = d.getFullYear();
            let hour = d.getHours();
            let min = d.getMinutes();

            let nowTime = day + '/' + month + '/' + year + ' ' + hour + ':' + min; //show up the time

            let el = '<' + htmlElement + '>';

            let element = $(el); //take an input value
            let pages = element.html(data);
            let length = $(htmlElement, element).length;
            windows.text('URL ' + url + ' Fetched on ' + nowTime + ' , took ' + duration + 'msec. ' + 'Element ' + '<' +
                htmlElement + '>' + ' appeared ' + length + ' times in page.' + ' ' + domain); // output
            //$('#content').html(data);
        },
        error: function(textStatus, XMLHttpRequest){
            alert('error');
        },
        complete : function() {
            $('.preload-three').removeClass('visible');
        }
    });

}
let endTime = Date.now();
duration = endTime - startTIme;
function getStat() {
    let url = $('#url').val();
    let htmlElement = $('#htmlElement').val();

    let domain = url.match(/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/img);
    domain = domain[0];

    let windows = $('.window');
    let staticOut = $('#content');

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

function checkInput() {
    let url = $('#url');
    let element = $('#htmlElement');
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

$('#getUrl').click('on', function () {
        checkInput();
        if (checkInput() === true) {
            $(this).removeClass('red');
            $('.error-msg').text('');
            loadURL();
        }

});
$('#getStat').click('on', function () {
    checkInput();
    if (checkInput() === true) {
        $(this).removeClass('red');
        $('.error-msg').text('');
        getStat();
    }
});
