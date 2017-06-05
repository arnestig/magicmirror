<?php
    echo '<html><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="css/mirror.css">
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="weather/jquery.simpleWeather.js"></script>
    <script src="weather/weather.js"></script>
    <script src="calendar/calendar.js"></script>
    <script src="newsfeed/newsfeed.js"></script>
    <style>
table {
	height: 100%;
	width: 100%;
}
tr { 
	height: 50%;
}
td { 
	width: 50%;
}
iframe { 
	width: 100%;
	height: 100%;
	border: none;
}

tr.top {
	valign: top;
}

tr.bottom {
	vertical-align: bottom;
}

td.left {
	vertical-align: top;
	text-align: left;
}

td.right {
	vertical-align: top;
	text-align: right;
}

</style>
</head>
<body>';
	echo '<table>
  		<tr class="top">
    		<td class="left"><div id="calendar"></div></td>
    		<td class="right"><div id="weather"></div></td>
  		</tr>
  		<tr class="bottom">
    		<td class="left"><div id="newsfeed"></div></td>
    		<td>d</td>
  		</tr>
	     </table></body></html>';
?>
