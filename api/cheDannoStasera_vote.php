<?php

$start = microtime(true);

error_reporting(0);

if (isset($_GET['vote'])) $vote =  intval($_GET['vote']) ;
else {
    $vote = 0; //0,1   state name
}


if (isset($_GET['program'])) $program =   ($_GET['program']) ;
else {
    $program = "null"; //0,1   state name
}




echo "<h1>Hai votato!</h1>";
echo "<h1>$vote</h1>";
echo "<h1>contenuto:</h1>";
echo "<h1>$program</h1>";
