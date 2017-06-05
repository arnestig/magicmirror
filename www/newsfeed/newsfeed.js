function parseNews() {
    $.getJSON( "JSON-URL-HERE", function( data ) {
        var items = [];
	var newsItem = data.articles[Math.floor(Math.random()*data.articles.length)];
	items.push( "<b><p class=newscaption>" + newsItem.title + "</b></br><p class=newstext>" + newsItem.description + "</p>");
 
        $("#newsfeed").html(items.join( "" ));
    });
}

$(document).ready(function() {
	parseNews();
  	setInterval( parseNews, 1000 * 60 * 5 );
});

