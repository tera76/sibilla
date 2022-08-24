<?php

// http://localhost/sibilla/client/001paramEnt.php?q0nstates=6&q0state=5

include_once './00ent_funcions.php';


// 2 * 2 stati in input alla pagina
// set default 2 qubit with 3 states param
// q0 in H state (state b in a,b,c)
// q1 in state 0 (state a on a b c)
// same orientation?

if (isset($_GET['q0state'])) $q0state =  intval($_GET['q0state']) ;
else {
    $q0state = 1; //0,1   state name
}
if (isset($_GET['q0nstates'])) $q0nstates =  intval($_GET['q0nstates']);
else {
    $q0nstates = 3;
}

if (isset($_GET['q1state'])) $q1state =  intval($_GET['q1state']);
else {
    $q1state = 0;
}


if (isset($_GET['q1nstates'])) $q1nstates =  intval($_GET['q1nstates']);
else {
    $q1nstates = 3;
}



echo "<br> q0state: "  . $q0state ;
echo "<br> q0nstates" . $q0nstates ;

echo "<br>";

echo "<br> q1state: "  . $q1state ;
echo "<br> q1nstates" . $q1nstates ;




// $q0nstates = 5;

$n = $q0nstates - 1;

$circ = <<<EOD
<pre>
          ┌─────────────┐     ┌─┐
q_0: ─|0>─┤ Rx($q0state * π/$n) ├──■──┤M├───
          └─────────────┘┌─┴─┐└╥┘┌─┐
q_1: ─|0>────────────────┤ X ├─╫─┤M├
                         └───┘ ║ └╥┘
c: 2/══════════════════════════╩══╩═
</pre>
EOD;

print_r ($circ);

$qasm = '"OPENQASM 2.0;\ninclude \"qelib1.inc\";\n\nqreg q[2];\ncreg c[2];\n\nreset q[0];\nreset q[1];\nrx(pi*' . $q0state . ' /(' . $q0nstates . '-1)) q[0];\ncx q[0],q[1];\nmeasure q[0] -> c[0];\nmeasure q[1] -> c[1];"';
getMeasuresV2($qasm,1024);

// echo "<br>Una sequenza di tre singole misure, a caso ";
// getMeasuresV2($qasm, 1, 3);
 die();



//misura correlata a se stessa^ feetback?
