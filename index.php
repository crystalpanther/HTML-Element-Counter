<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <title>HTML element counter</title>
</head>
<body>

<h1>HTML element counter</h1>
<form id="form" action="dataBase.php" method="get">
    <label for="url">Enter URL</label>
    <input type="text" id="url" name="url">
    <label for="htmlElement">Enter HTML Element Tag</label>
    <input type="text" id="htmlElement" name="htmlElement">


</form>
<button onclick="loadURL()">Send</button>

<div class="window">
    Result:
</div>
<div id="content"></div>
<div>

</div>

<script src="js/jquery-2.1.4.min.js"></script>
<script>
    function loadURL () {
        var htmlElement = $('#htmlElement').val();
        var url = $('#url').val();
        var windows = $('.window');
        var staticOut = $('#content');
        var res;
        var formData = {
            'url' : url,
            'htmlElement' : htmlElement
        }
        var a = Date.now(); //the start time of the script
        $.ajax({
            url:'server.php',
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

                var element = $('<' + htmlElement + '>'); //take an input value
                var pages = element.html(data);
                var length = $(htmlElement, element).length;

                windows.text('URL ' +  url +  ' Fetched on ' + nowTime + ' , took ' + res + 'msec. ' +'Element ' +  '<' +
                    htmlElement + '>' + ' appeared ' + length + ' times in page.'); // output
            },
            error: function () {
                console.log('error');
            }

        });

        var b = Date.now();
        res = b - a;

        $.ajax({
            url:'dataBase.php',
            type:'GET',
            data: {
                'url': url,
                'htmlElement': htmlElement,
                'time': res
            },
            headers: {
                'Access-Control-Allow-Origin': '*' //access CORS
            },
            success: function(data) {
                staticOut.text(data);
            },
            error: function () {
                console.log('error');
            }
        });
    }

</script>


<!--<script src="js/main.js"></script>-->
</body>
</html>