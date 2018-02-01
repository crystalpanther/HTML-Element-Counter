<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,500i,700,700i&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700&amp;subset=latin-ext" rel="stylesheet">
    <title>HTML element counter</title>
</head>
<body>


<div class="form-container">
    <div class="wrapper">
        <h1>HTML element counter</h1>
        <form id="form" id="form" action="parsing.php" method="POST" onsubmit=" ; return false"">
            <div class="url">
                <input type="text" id="url" class="input" name="url" placeholder="Enter URL">
                <span class="error-msg" id="error-url"></span>
            </div>
            <div class="element">
                <input type="text" id="htmlElement" class="input" name="htmlElement" placeholder="Enter tag">
                <span class="error-msg" id="error-tag"></span>
            </div>

            <div class="buttons">
                <input type="submit" class="button" id="getUrl" value="Count tag">
                <input type="submit" class="button" id="getStat" value="Get statistics">
            </div>
        </form>
    </div>
</div>


<div class="output">
    <div class="preloader " id="#p_prldr">
        <div class="preload-three">
            <div class="circle-three" id="center"></div>
            <div class="circle-three" id="left"></div>
            <div class="circle-three" id="right"></div>
        </div>
    </div>
    <div class="window"></div>
    <div id="content"></div>
</div>
<div>
    <span id ='span'></span>
</div>

<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/counter.js"></script>
<script src="js/main.js"></script>
<script  src="parsing.php"></script>
</body>
</html>