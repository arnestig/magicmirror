#!/usr/bin/perl

use warnings;
use strict;
use Data::Dumper;
use Date::Parse;
use POSIX;
use utf8;
use JSON::XS;

our $guid;
our %events;
our $found_object = 0;
our $last_key;
our @active_events;
our @json_output;

our @weekdays = qw/måndag tisdag onsdag torsdag fredag lördag söndag/;

sub time_until_tomorrow {
    return str2time(strftime("%Y-%m-%d",localtime(time+86400)))-str2time(scalar(localtime));
}

sub time_until_next_week {
    return (7-strftime("%u",localtime(time)))*86400;
}

sub sec2human {
    my($secs,$date) = @_;
    my ($ss,$mm,$hh,$day,$month,$year,$zone) = strptime( $date );

    if ($secs >= 8*24*60*60) { return sprintf 'senare' }
    elsif ( $secs >= time_until_next_week() ) { return sprintf 'nästa vecka %s', $weekdays[ (localtime(str2time($date)))[6]-1] }
    elsif ( $secs >= time_until_tomorrow()+86400 ) { return sprintf '%s %.2d:%.2d', $weekdays[ (localtime(str2time($date)))[6]-1],$hh,$mm }
    elsif ( $secs >= time_until_tomorrow() ) { return sprintf 'imorgon %.2d:%.2d', $hh,$mm }
    else { return sprintf 'idag %.2d:%.2d', $hh,$mm }
}

# main
open( ICAL_INPUT, "<calendar.ics" ) or die "$!";
binmode ICAL_INPUT, ":utf8";
while( <ICAL_INPUT> ) {
	$_ =~ s/\r//g;
	$_ =~ s/\\,/,/g;
	$_ =~ s/;VALUE=DATE//g;
	my($key,$val) = $_ =~ /([A-Z]+):(.*)/;
	if ( not defined $key ) {
		if ( $::last_key eq "DESCRIPTION" ) {
			$::events{ $guid }{ DESCRIPTION } .= $_;
		}
	} else {
		$::last_key = $key;
		if ( $key eq "BEGIN" && $val eq "VEVENT" ) {
			$::found_object = 1;
			$::guid = int(rand(100000));
			next;
		}
		if ( $key eq "END" && $val eq "VEVENT" ) {
			$::found_object = 0;
			next;
		}
		if ( $found_object == 1 ) {
			if ( $key =~ /DESCRIPTION|DTSTART|DTEND|SUMMARY|LOCATION/ ) {
				$::events{ $guid }{ $key } = $val;
			}
		}
	}
}
close( ICAL_INPUT );

foreach my $id ( keys %::events ) {
	my $event_time = str2time($::events{ $id }{ DTSTART });
	my $cur_time = str2time(scalar(localtime));
	if ( $event_time > $cur_time ) {
		$::events{ $id }{ TIMEUNTIL } = $event_time - $cur_time;
		push( @::active_events, $::events{ $id } );
	}
}
foreach my $cur_ev ( sort { str2time($a->{ DTSTART }) <=> str2time($b->{ DTSTART }) } @::active_events ) {
	my $startdate = sec2human($cur_ev->{ TIMEUNTIL },$cur_ev->{ DTSTART });
	push( @::json_output, {
		'summary' => $cur_ev->{ SUMMARY },
		'description' => $cur_ev->{ DESCRIPTION },
		'startdate' => $startdate } 
    );
}


while ( $#::json_output > 9 ) {
	pop(@::json_output);
}
open( OUTPUT_JSON, ">calendar.json" ) or die "$!";
print OUTPUT_JSON encode_json( \@::json_output );
close( OUTPUT_JSON );
