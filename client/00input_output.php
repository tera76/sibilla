<?php


// http://localhost/sibilla/client/0000input_output.php?q0state=1&q1state=1&q0states=3&q1states=3&q0rot=2
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

if (isset($_GET['q0rot'])) $q0rot =  intval($_GET['q0rot']);
else {
    $q0rot = 0;
}

if (isset($_GET['shots'])) $shots =  intval($_GET['shots']);

else {
    $shots = 1000;
}

// var_dump($shots);
//  die();

echo "<h1>Two qbit quantum circuit </h1>";
echo "<h2>Enjoy using url  parameters!</h2>";

echo "<br> q0state: "  . $q0state ;
echo "<br> q0nstates: " . $q0nstates ;
echo "<br>";
echo "<br> q1state: "  . $q1state ;
echo "<br> q1nstates: " . $q1nstates ;
echo "<br>";
echo "<br> q0rot: "  . $q0rot ;
echo "<br>";
echo "<br> shots: "  . $shots ;





// $q0nstates = 5;

$n = $q0nstates - 1;
$m = $q1nstates - 1;
$a = $q0state;
$b = $q1state;
$c = $q0rot;
$circ = <<<EOD

<pre>
          ┌──────────────┐     ┌─────────────┐┌─┐
q_0: ─|0>─┤ Rx($a * π/$n)  ├──■──┤ Rx($c * π/$n) ├┤M├
          ├──────────────┤┌─┴─┐└───┬─┬───────┘└╥┘
q_1: ─|0>─┤ Rx($b * π/$m)  ├┤ X ├────┤M├─────────╫─
          └──────────────┘└───┘    └╥┘         ║
c: 2/═══════════════════════════════╩══════════╩═
                                    1          0
</pre>
EOD;

print_r ($circ);

// $qasm = '"OPENQASM 2.0;\ninclude \"qelib1.inc\";\n\nqreg q[2];\ncreg c[2];\n\nreset q[0];\nreset q[1];\nrx(pi*' . $q0state . ' /(' . $q0nstates . '-1)) q[0];\ncx q[0],q[1];\nmeasure q[0] -> c[0];\nmeasure q[1] -> c[1];"';



$qasm_input = <<<EOD
"OPENQASM 2.0;
include \"qelib1.inc\";
qreg q[2];
creg c[2];
reset q[0];
reset q[1];
rx(pi*$q0state/($q0nstates-1)) q[0];
rx(pi*$q1state/($q1nstates-1)) q[1];

measure q[0] -> c[0];
measure q[1] -> c[1];"
EOD;

$qasm_input = str_replace("\n","\\n",$qasm_input);





$qasm = <<<EOD
"OPENQASM 2.0;
include \"qelib1.inc\";
qreg q[2];
creg c[2];
reset q[0];
reset q[1];
rx(pi*$q0state/($q0nstates-1)) q[0];
rx(pi*$q1state/($q1nstates-1)) q[1];
cx q[0],q[1];
rx(pi*$q0rot/($q0nstates-1)) q[0];
measure q[0] -> c[0];
measure q[1] -> c[1];"
EOD;

$qasm = str_replace("\n","\\n",$qasm);
echo "<br> request fron qasm:  " . $qasm . "<br>";

getMeasuresV2($qasm,$shots);
