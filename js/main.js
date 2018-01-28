/**
 * Created by elina on 1/2/2018.
 */



function loadURL () {
    var duration;
    var start = new Date();
    var url = $('#url').val();
    var htmlElement = $('#htmlElement');

    //        if (!url.match(/^[a-zA-Z]+:\/\//))
    //        {
    //            url = 'https://' + url;
    //        }


    var domain = url.match(/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/img);
    if(domain) {
        domain = domain[0];
    }

    var windows = $('.window');
    var staticOut = $('#content');


    var formData = {
        url: url,
        'htmlElement': htmlElement,
        'domain': domain,
        'duration' : duration
    }
    $.ajax({
        url:'parsing.php',
        type:'POST',
        data: formData,
        headers: {
            'Access-Control-Allow-Origin': '*' //access CORS
        },
        success: function (data) {
            var d = new Date(); //identify the date

            var day  = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            var hour = d.getHours();
            var min = d.getMinutes();

            var nowTime = day + '/' + month + '/' + year + ' ' + hour + ':' + min; //show up the time

            var el = '<' + htmlElement + '>';


            var element = $(el); //take an input value


            var pages = element.html(data);
            var length = $(htmlElement, element).length;
            staticOut.text(data);
            windows.text('URL ' +  url +  ' Fetched on ' + nowTime + ' , took ' + duration + 'msec. ' +'Element ' +  '<' +
                htmlElement + '>' + ' appeared ' + length + ' times in page.' + ' ' + domain); // output
        },
        error: function () {
            console.log('error');
        }

    });
    duration = new Date() - start;

}
function getStat() {
    var url = $('#url').val();
    var htmlElement = $('#htmlElement');
    var domain = url.match(/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/img);
    domain = domain[0];

    var windows = $('.window');
    var staticOut = $('#content');


    $.ajax({
        url:'dataBase.php',
        type:'GET',
        data: {
            'url': url,
            'htmlElement': htmlElement,
            'domain': domain
        },
        headers: {
            'Access-Control-Allow-Origin': '*' //access CORS
        },
        success: function(data) {
            staticOut.html(data);
        },
        error: function () {
            console.log('error');
        }
    });
}


