<?php
   // Setting the timezone
   $tz = 'Asia/Kolkata';   
   date_default_timezone_set($tz);
   
   // Retrieving the default timezone
   $timeZone = date_default_timezone_get();
   print("Default timezone: ".$timeZone);
   print("\n");
   $today = date('Y-m-d H:m:s');

   // Comparing the timezone with ini-set timezone 
   if (strcmp($timeZone, ini_get('date.timezone'))) { 
        echo ini_get('date.timezone');
      print('Script timezone and ini-set timezone are not the same.'); 
   } else { 
      print('Script timezone and ini-set timezone are the same.'); 
   } 
?>
