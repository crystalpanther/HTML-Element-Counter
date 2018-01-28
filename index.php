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
<form id="form" action="dataBase.php" method="get" onsubmit=";return false"">
    <label for="url">Enter URL</label>
    <input type="text" id="url" name="url">
    <label for="htmlElement">Enter HTML Element Tag</label>
    <input type="text" id="htmlElement" name="htmlElement">

<input type="submit" id="button" value="Send" onclick="loadURL()">
<input type="submit" value="Get stat" onclick="getStat()">
</form>


<div class="window">
    Result:
</div>
<div id="content"></div>
<div>

</div>

<script src="js/jquery-2.1.4.min.js"></script>

<script src="js/main.js"></script>
</body>
</html>