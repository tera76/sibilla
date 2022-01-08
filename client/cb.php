<?php

if (isset($_GET['n'])) {
    $n = $_GET['n'];
}
else $n =4;

if (isset($_GET['r'])) {
    $r = $_GET['r'];
}
else $r =3;

// http://localhost/sibilla/client/cb.php?n=16&r=15
// tartaglia e coeff binomiale



$start = microtime(true);




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
    echo "<table>";
    echo "<tr>";
    for ($n=0;$n <= $number; $n++) {
    //    echo "n: " . $n . "; cb: ";
        for($k=0; $k<=$n; $k++){
        //    echo "_" . $n . " k: " . $k . "<br>";
            $c =  coeffBin($n,$k);
          //  echo  $c . "; ";
            echo "<td>$c; </td>";
            // Output a row


    }

        echo "</tr>";

  //   echo "fine riga <br>";

    }
    echo "</table>";
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















