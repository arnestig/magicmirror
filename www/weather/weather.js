// v3.1.0
//Docs at http://simpleweatherjs.com
function replaceDate(date) {
	var dates_en = [ 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun' ];
	var dates_se = [ 'Mån', 'Tis', 'Ons', 'Tors', 'Fre', 'Lör', 'Sön' ];
	return dates_se[ dates_en.indexOf( date ) ];
}

function getWeather() {
	$.simpleWeather({
    	location: 'Bankeryd, SE',
    	woeid: '',
    	unit: 'c',
    	success: function(weather) {
    	html = '<h2 class="large"><i id="caption-large" class="icon-'+weather.code+'"></i> '+weather.temp+'&deg;</h2>';
      	for ( i = 1; i < 4; i++ ) {
		weather.forecast[i].day = replaceDate(weather.forecast[i].day);
        	html += '<h3>'+weather.forecast[i].day+'&nbsp;<i id="caption" class="icon-'+weather.forecast[i].code+'"></i>&nbsp;&nbsp;'+weather.forecast[i].high+'&nbsp;/&nbsp;'+weather.forecast[i].low+'</h3>';
      	}
     	 
      	$("#weather").html(html);
    	},
    	error: function(error) {
      	$("#weather").html('<p>'+error+'</p>');
    	}
  	});
}

$(document).ready(function() {
	getWeather();
  	var i = setInterval( getWeather, 1000 * 60 * 5);
});

