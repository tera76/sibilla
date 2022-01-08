<?php

$start = microtime(true);



$n =14;
$r = 5;

$NcR = coeffBin($n,$r);
echo "The factorial of $n is: " .fact($n)."<br>";
echo "The factorial of $r is: " .fact($r)."<br>";

echo "The NcR value of $n and $r is: " .$NcR."<br>";

tartaglia($n);

////////////////////
// stop
$end = microtime(true);

$duration = $end - $start;
echo "<br><br><br> **** Duration is: $duration"  ;


die();

function tartaglia($number) {
    echo "tartaglia<br>";
    for ($n=0;$n <= $number; $n++) {
        echo "n: " . $n . "; cb: ";
        for($k=0; $k<=$n; $k++){
        //    echo "_" . $n . " k: " . $k . "<br>";
            $c =  coeffBin($n,$k);
            echo  $c . "; ";
            // Output a row
            echo "<table>";
            echo "<tr>";
            echo "<td>$n</td>";
            echo "<td><a>$k</a></td>";
            echo "</tr>";
            echo "</table>";
    }
    echo "fine riga <br>";

    }
    echo "fine script <br>";
}

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















