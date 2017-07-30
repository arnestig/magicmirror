function getFood() {
    var SERVERPATH = "http://127.0.0.1:8080/foodsuggest/index.php"
    $.getJSON( SERVERPATH, function( data ) {
        var items = [];
        $.each( data, function( key, val ) {
            items.push( "<tr><td class='left'><b>" + val.name + "</b></td><td class='right'>" + val.group +"</td></tr>" );
 
        });
        $("#foodsuggest").html(items.join( "" ));
    });
}

$(document).ready(function() {
	getFood();
  	setInterval( getFood, 1000 * 60 * 15 );
});

