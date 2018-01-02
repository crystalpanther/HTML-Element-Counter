/**
 * Created by elina on 1/2/2018.
 */
    function countElement (elem) {
        var result;
        result = elem.val();
        return result;
    }
    function loadURL() {
        var tag = $('#htmlElement');
        var window = $('.window');
        var x = countElement(tag);
        $.ajax({
            url: 'page.html',
            cache: false,
            success: function(data) {
                var element = $('<' + x + '>');
                element.html(data);
                var length = $('' + x, element).length;
                window.text('Total' + ' ' + tag.val() + ' ' + 'on the page is: ' + length);
            }
        });
    }