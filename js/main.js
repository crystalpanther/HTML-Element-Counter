/**
 * Created by elina on 1/2/2018.
 */
    function countElement (elem) {
        var result;
        result = elem.val(); //take an input with "htmlElement" id
        return result; //return value
    }
    function loadURL() {
        var tag = $('#htmlElement');
        var url = 'page.html';
        var window = $('.window');
        var x = countElement(tag); //send for the function as an argument '#htmlElement' value
        $.ajax({
            url: url, //using test page for counting elements
            cache: false,
            type: "POST",
            contentType: 'application/javascript',
            crossDomain: true,
            success: function(data) {
                var element = $('<' + x + '>'); //take an input value and
                var d = new Date(); //create a new object for take current time
                var curr_date = d.getDate();

                var month = new Array();
                month[0] = "January";
                month[1] = "February";
                month[2] = "March";
                month[3] = "April";
                month[4] = "May";
                month[5] = "June";
                month[6] = "July";
                month[7] = "August";
                month[8] = "September";
                month[9] = "October";
                month[10] = "November";
                month[11] = "December";

                var curr_month = month[d.getMonth()];
                var curr_year = d.getFullYear();
                var pages = element.html(data);
                var length = $(x, element).length;
                window.text(
                    'URL' + ' ' + url + ' ' + 'Fetched on' + ' ' +
                    curr_date + ' ' + curr_month + ' ' + curr_year + ', ' + 'took' + ' ' + timeSec + '. ' +
                    'Element' + ' ' + tag.val() + ' ' + 'appeared ' + length + ' ' + 'times in page.'
                );
            },
            error: function () {
                window.text('Sorry, try again');
            }
        });
    }