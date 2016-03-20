<?php
class HoursHelper extends AppHelper {
    function formatHours($hours, $minutes) {
        if((int)$hours === 1){
			$hours = $hours.' Stunde ';
		} else {
			$hours = $hours.' Stunden ';
		}
		
		if((int)$minutes === 1){
			$minutes = $minutes.' Minute';
		} else {
			$minutes = $minutes.' Minuten';
		}
		
		$time = $hours.$minutes;
        return $time;
    }
}
?>