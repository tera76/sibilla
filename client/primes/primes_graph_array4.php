<?php

$start = microtime(true);
$primes =
    array(
        2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97, 101, 103, 107, 109, 113, 127, 131, 137, 139, 149, 151, 157, 163, 167, 173, 179, 181, 191, 193, 197, 199, 211, 223, 227, 229, 233, 239, 241, 251, 257, 263, 269, 271, 277, 281, 283, 293, 307, 311, 313, 317, 331, 337, 347, 349, 353, 359, 367, 373, 379, 383, 389, 397, 401, 409, 419, 421, 431, 433, 439, 443, 449, 457, 461, 463, 467, 479, 487, 491, 499, 503, 509, 521, 523, 541, 547, 557, 563, 569, 571, 577, 587, 593, 599, 601, 607, 613, 617, 619, 631, 641, 643, 647, 653, 659, 661, 673, 677, 683, 691, 701, 709, 719, 727, 733, 739, 743, 751, 757, 761, 769, 773, 787, 797, 809, 811, 821, 823, 827, 829, 839, 853, 857, 859, 863, 877, 881, 883, 887, 907, 911, 919, 929, 937, 941, 947, 953, 967, 971, 977, 983, 991, 997


);

$mumber = 1000;

 // echo "<span style='color:black;background-color:Magenta;'>suuca</span>";
 // die();

for ($x = 2; $x <= $mumber; $x++) {

    echo "<br> <span style='color:black;background-color:white;'>$x is the number \t</span>";

    $isPrime = true;
    $isPrime = true;
    foreach ($primes as &$value) {
        $factor = 0;
if ($value < $x) {


    $exp   =   getFactor($x, $value);
    if ($exp == 0)  echo "<span style='color:white;background-color:white;'>$exp</span>";
else  if ($exp == 1)  echo "<span style='color:black;background-color:orange;'>$exp</span>";
else  if ($exp == 2)  echo "<span style='color:black;background-color:red;'>$exp</span>";
else  if ($exp == 3)  echo "<span style='color:black;background-color:yellow;'>$exp</span>";
else  if ($exp == 4)  echo "<span style='color:black;background-color:blue;'>$exp</span>";
else  if ($exp == 5)  echo "<span style='color:black;background-color:Magenta;'>$exp</span>";
else  if ($exp == 6)  echo "<span style='color:black;background-color:blue;'>$exp</span>";
else  if ($exp == 7)  echo "<span style='color:black;background-color:Grey;'>$exp</span>";
else  if ($exp == 8)  echo "<span style='color:black;background-color:black;'$exp</span>";
else  if ($exp == 0)  echo "<span style='color:black;background-color:black;'>$exp</span>";
else  if ($exp == 9)   echo "<span style='color:black;background-color:black;'>$exp</span>";
else echo "<span style='color:black;background-color:white;'>$exp</span>";

    if ($exp != 0 ) { $isPrime=false;}


         }

    }
   if ($isPrime==true) echo "<span style='color: green; background-color:white;'> $x is prime</span>";
}


$end = microtime(true);
$duration = $end - $start;
printStepMessage("**** Daaaaaaauration", $duration);

die();


function getFactor($number, $divisor)
{
    $i = $number;

$factor = 0;


while ($i % $divisor == 0 ) {
    $i = $i / $divisor;
    $factor++ ;

}
    return $factor;
}



function printStepMessage($step, $value)
{

    echo "<span style='color: black; background-color:white;'><br><br><strong>" . $step . ":  </strong><br>" . $value . "</span>";


}



