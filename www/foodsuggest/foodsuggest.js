function getFood() {
    var SERVERPATH = "http://127.0.0.1:8080/foodsuggest/index.php"
    $.getJSON( SERVERPATH, function( data ) {
        var items = [];
        items.push('<table>' );
        $.each( data, function( key, val ) {
    	    items.push( '<tr><td class="'+val.group+'"></td><td class="text">'+val.name+'</td></tr>');
 
        });
        items.push('</table>');
        $("#foodsuggest").html(items.join( "" ));
    });
}

$(document).ready(function() {
	getFood();
  	setInterval( getFood, 1000 * 60 * 15 );
});

