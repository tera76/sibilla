<?php
$start = microtime(true);


$circ = <<<EOD
<pre>
          ┌─────────┐     ┌─┐
q_0: ─|0>─┤ Rx(π/2) ├──■──┤M├───
          └─────────┘┌─┴─┐└╥┘┌─┐
q_1: ─|0>────────────┤ X ├─╫─┤M├
                     └───┘ ║ └╥┘
c: 2/══════════════════════╩══╩═
</pre>
EOD;

print_r ($circ);

$randomSeed =  rand(1, 1024);

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
  CURLOPT_POSTFIELDS =>'{
	"query": "query runSimulator($qasm: String!, $seed: Int, $shots: Int) {\\n  runSimulator(qasm: $qasm, seed: $seed, shots: $shots) {\\n    statevector\\n    counts {\\n      state\\n      count\\n    }\\n  }\\n}\\n",
	"variables": {
		"qasm":"OPENQASM 2.0;\ninclude \"qelib1.inc\";\n\nqreg q[2];\ncreg c[2];\n\nreset q[0];\nreset q[1];\nrx(pi*1/(3-1)) q[0];\ncx q[0],q[1];\nmeasure q[0] -> c[0];\nmeasure q[1] -> c[1];",
		"seed": ' . $randomSeed . ',
		"shots": 1024
	}
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

$json = json_decode($response, true);



$counts = $json['data']['runSimulator']['counts'];

$n_observables_states= count($counts);



// q0 conta 1 quante volte? su quante?
$q0 = 0;
$q1 = 0;
$shots = 1024;


foreach ($counts as $food)  {
  $state = $food['state'];
  $count  = $food['count'];

   printStepMessage("Stato osservato: " . $state  . "; Conteggio: " . $count  ,100*  $count/$shots );


   if( in_array($state,   array("01", "11")  )) {
     $q0 = $q0 +   $count ;
   }

   if( in_array($state,   array("11", "10")  )) {
     $q1 = $q1 +   $count ;
   }
   }

   printStepMessage("q0 conta 1 quante volte? in perc. ", 100*$q0/$shots);
   printStepMessage("q1 conta 1 quante volte? in perc. ", 100*$q1/$shots);



  // printStepMessage("counts[]['state']",   $counts[]['state']);






die();



for ($i=0;$i < $n_observables_states;$i++ ) {
  printStepMessage("counts[$i]['state']",   $counts[$i]['state']);

  if ($counts[$i]['state'] = "01" or $counts[$i]['state'] =11  ) $q0 = $q0 + $counts['count'];

}
printStepMessage("$q0", $q0);

die();
printStepMessage("n_observables_states", $n_observables_states);


printStepMessage("quante volte q0 vale 1", $n_observables_states);





/*
 *  Terminate suite
 */

$end = microtime(true);
$duration = $end - $start;
printStepMessage("**** Duration", $duration);
die();

/*
 *  Now we define some standard function for style and print formatting
 */

function printStepMessage($step, $value)
{

    echo "<br><br><strong>" . $step . ":  </strong> " . $value;


}
