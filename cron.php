<?php
$url = "https://pasteurian-visitors.000webhostapp.com/sibilla/client/alarms.php";

    $cron1 = file_get_contents($url, false);
   echo "cron1: " . $cron1;


