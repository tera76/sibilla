<?php

$start = microtime(true);



$n =70;
$r = 20;

$NcR = coeffBin($n,$r);
echo "The factorial of $n is: " .fact($n)."<br>";
echo "The factorial of $r is: " .fact($r)."<br>";

echo "The NcR value of $n and $r is: " .$NcR."<br>";



////////////////////
// stop
$end = microtime(true);

$duration = $end - $start;
echo "<br><br><br> **** Duration is: $duration"  ;


die();


// factorial

function fact($number) {
    if ($number == 0) return 1;
    return $number * fact($number - 1);
}


// binomial

function coeffBin($n,$r) {
    $NcR = fact($n) / (fact($r) * fact($n - $r));

    return $NcR;
}















