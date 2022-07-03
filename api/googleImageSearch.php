<?php
 echo $_GET['film'];

if (isset($_GET['film'])) {
   $film =  $_GET['film'];

} else {
    $film = "";
}


 echo "<td><img src=\"$film\"></td>";


     // code...

 die();
