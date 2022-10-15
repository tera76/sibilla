<?php

function getMeasuresV2($qasm, $shots, $loop = 1)
{
    for ($i = 1;$i <= $loop;$i++)
    {
        $randomSeed = rand(1, 1024);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://quantum-computing.ibm.com/api/graphql/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
  	"query": "query runSimulator($qasm: String!, $seed: Int, $shots: Int) {\\n  runSimulator(qasm: $qasm, seed: $seed, shots: $shots) {\\n    statevector\\n    counts {\\n      state\\n      count\\n    }\\n  }\\n}\\n",
  	"variables": {
  		"qasm": ' . $qasm . ',
     	"seed": ' . $randomSeed . ',
  		"shots": ' . $shots . '
  	}
  }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ) ,
        ));

        if ($shots > 1)
        {
            getMeasures($curl,$shots);
        }
        else
        {
            printStepMessage("Singlr measure loop: ", $i);

            getSingleShot($curl);
        }

    }

}







function getMeasures($curl, $shots)
{
    $start = microtime(true);

    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response, true);

    $counts = $json['data']['runSimulator']['counts'];
    $n_observables_states = count($counts);

    // q0 conta 1 quante volte? su quante?
    $q0 = 0;
    $q1 = 0;

    printStepMessage("Shots: ", $shots);
sort($counts);

printHistogramCountsAll($counts,$shots);


foreach ($counts as $food)
{
    $state = $food['state'];
    $count = $food['count'];
    $count_perc = 100 * $count / $shots;

    printStepMessage("Stato osservato: " . $state . "; Conteggio: " . $count, $count_perc . " %" . " \t ");
  //  printHistogramCounts($state, $count_perc);
    switch ($state)
    {
        case '00':

        break;
        case '01':

            $q0 = $q0 + $count;
        break;
        case '10':

            $q1 = $q1 + $count;
        break;
        case '11':

            $q0 = $q0 + $count;
            $q1 = $q1 + $count;
        break;
        default:
            // code...erro

        break;
    }

}

$q0_perc = 100 * $q0 / $shots;
$q1_perc = 100 * $q1 / $shots;
printStepMessage("<br>Alice osserva q0=1 nel ", $q0_perc . " % delle sue misure;");


printStepMessage("Bob osserva q1=1 nel  ", $q1_perc . " % delle sue dmisure;");

if ($q0_perc == $q1_perc) {

  printStepMessage("Le misure di A e B sono ","corrrelate!"  );
}

// color box

showBox($q0_perc,$q1_perc);

/*
printStepMessage("Single measure?", "spettro, distribuzione, no sequenza?");

printStepMessage("Entanglement, conta anche la sequenza delle misure ?", "");
printStepMessage("Come coordinare  la sequenza delle misure ?", "");
*/
/* Data la statistica ritornare uno stato a caso
 *
*/
// printStepMessage("counts[]['state']",   $counts[]['state']);


/*
 *  Terminate suite
*/

$end = microtime(true);
$duration = $end - $start;
printStepMessage("<br> **** Duration", $duration);


}

/*
 *  Now we define some standard function for style and print formatting
*/



function showBox($c1, $c2)
{


   $color1 = percentageToColor($c1);
   $color2 = percentageToColor($c2);
   echo "<br>";
echo $c1 . " hex" . $color1  . "<br>" ;
echo $c1 . " hex" . $color1  ." <br>" ;
// $color= "$c1" http://www.perbang.dk/rgb/7F7F7F/;
  echo '<tr><td><div style="width:102px; height:102px; background-color:'.$color1.'"></div></td>';
  echo '<td><div style="width:102px; height:102px; background-color:'.$color2.'"></div></td><tr>';

}


function percentageToColor($c)
{
  if($c== 0) return "#000000"; // nero
  if($c> 0 &  $c< 10) return "#191919"; // nero
  else if($c>= 10 & $c < 20 ) return "#333333";
  else if($c>= 20 & $c < 35 ) return "#4C4C4C";
  else if($c>= 30 & $c < 50 ) return "#666666";
  else if($c>= 50 & $c < 60 ) return "#7F7F7F";
  else if($c>= 60 & $c < 70 ) return "#999999";
  else if($c>= 70 & $c < 80 ) return "#B2B2B2";
  else if($c>= 80 & $c < 90 ) return "#CCCCCC";
  else if($c>= 90 & $c < 100 ) return "#E5E5E5"; // bianco
  if($c == 100) return "#FFFFFF";
  else return "#CC1919";
}




function getSingleShot($curl)
{

    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response, true);

    $counts = $json['data']['runSimulator']['counts'];
    $n_observables_states = count($counts);

    foreach ($counts as $food)
    {
        $state = $food['state'];
        $count = $food['count'];

        printStepMessage("Single measure observed: <big style=\"color:Tomato;\">" . $state . "</big>", "");

        printStepMessage(" Alice Single Observation: <big style=\"color:Tomato;\">" . $state[0] . "</big>", "");
        printStepMessage(" Bob Single Observation: <big style=\"color:Tomato;\">" . $state[1] . "</big>", "");

    }
}

function printStepMessage($step, $value)
{

    echo "<br><strong>" . $step . "\t" . ":  </strong>" . "\t" . $value . "\t";

}

function printHistogramCounts($label, $perc)
{
    $decimal = $perc / 1;

    echo "&nbsp  <strong>" . $label . ":  </strong> &nbsp ";
    for ($i = 1;$i < $decimal;$i++)
    {
        echo "*";
    }
    // echo "<br>";

}

function printHistogramCountsAll($counts, $shots)
{
$expected_states = ['00','01','10','11'];

      foreach ($expected_states as $stato)      {
      $count_perc = 0;
      foreach ($counts as $food)      {

        $state = $food['state'];
        $count = $food['count'];

        if($state == $stato ){

        $count_perc = 100 * $count / $shots;
        }


      }
      printStepMessage(" state "  , " ");
  //    printStepMessage("Stato osservato: " . $stato . "; Conteggio: " . $count, $count_perc . " %" . " \t <br> ");

      printHistogramCounts($stato, $count_perc);


}




}
