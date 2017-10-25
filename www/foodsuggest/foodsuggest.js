function getFood() {
    var SERVERPATH = "http://localhost/foodsuggest/index.php"
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

