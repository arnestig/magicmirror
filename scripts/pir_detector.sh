#!/bin/sh

# setup GPIO
gpio mode 28 in #IR sensor
gpio mode 29 in #push button
gpio mode 29 down

LAST_BTN=0
LAST_SCREEN_ON=0
TV_STATE=0

toggle_tv()
{
	if [ "${TV_STATE}" -eq "0" ]; then
		vcgencmd display_power 1 > /dev/null 2>&1
		TV_STATE=1
		LAST_SCREEN_ON=$(date +%s --date "600 seconds")
	else
		vcgencmd display_power 0 > /dev/null 2>&1
		TV_STATE=0
	fi
}

while true; do 
	sleep 0.1
	IRVAL=$(gpio read 28)
	BTNVAL=$(gpio read 29)
	
	# handle button override
	if [ "${BTNVAL}" -eq "1" ]; then
		EPOCHS=$(date +%s)
		if [ ${EPOCHS} -gt ${LAST_BTN} ]; then
			toggle_tv
		fi
		LAST_BTN=${EPOCHS}
	fi

	# handle ir sensor
	if [ ${LAST_SCREEN_ON} -lt $(date +%s) ]; then
		if [ "${IRVAL}" -eq "1" ]; then
			if [ "${TV_STATE}" -eq "0" ]; then
				toggle_tv
			fi
		else
			if [ "${TV_STATE}" -eq "1" ]; then
				toggle_tv
			fi
		fi
	fi
	if [ "${IRVAL}" -eq "1" ]; then
		LAST_SCREEN_ON=$(date +%s --date "600 seconds")
	fi
done


