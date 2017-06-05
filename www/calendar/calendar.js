function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function setClock() {
	var weekday = new Array(7);
	weekday[0] = "Söndag";
	weekday[1] = "Måndag";
	weekday[2] = "Tisdag";
	weekday[3] = "Onsdag";
	weekday[4] = "Torsdag";
	weekday[5] = "Fredag";
	weekday[6] = "Lördag";

	var month = new Array(12);
	month[0] = "Jan";
	month[1] = "Feb";
	month[2] = "Mars";
	month[3] = "April";
	month[4] = "Maj";
	month[5] = "Juni";
	month[6] = "Juli";
	month[7] = "Aug";
	month[8] = "Sep";
	month[9] = "Okt";
	month[10] = "Nov";
	month[11] = "Dec";

	var d = new Date();
        var items = [];
	items.push('<h3>'+weekday[d.getDay()]+', '+month[d.getMonth()]+' '+d.getDate()+', '+d.getFullYear()+'</h3>');
	items.push('<h2>'+addZero(d.getHours())+':'+addZero(d.getMinutes())+':'+addZero(d.getSeconds())+'</h2>');
	$("#clock").html(items.join( "" ));

}

function parseCalendar() {
    $.getJSON( "calendar/calendar.json", function( data ) {
        var items = [];
	items.push('<div id="clock"></div><hr><table>');
        $.each( data, function( key, val ) {
            items.push( "<tr><td class='left'><b>" + val.summary + "</b></td><td class='right'>" + val.startdate +"</td></tr>" );
        });
	items.push('</table>');
 
        $("#calendar").html(items.join( "" ));
    });
}

$(document).ready(function() {
	parseCalendar();
	setClock();
  	setInterval( parseCalendar, 1000 * 60 * 5 );
	setInterval( setClock, 1000 );
});

