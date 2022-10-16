<?php




// http://localhost/sibilla/client/000input_output.php?q0state=1&q0nstates=3&q1state=0&q1nstates=3&state=2&q2nstates=3&q0rot=0&q1rot=0&shots=100
include_once './000ent_funcions.php';


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


if (isset($_GET['q2state'])) $q2state =  intval($_GET['q2state']);
else {
    $q2state = 0;
}


if (isset($_GET['q2nstates'])) $q2nstates =  intval($_GET['q2nstates']);
else {
    $q2nstates = 3;
}




if (isset($_GET['q0rot'])) $q0rot =  intval($_GET['q0rot']);
else {
    $q0rot = 0;
}

if (isset($_GET['q1rot'])) $q1rot =  intval($_GET['q1rot']);
else {
    $q1rot = 0;
}

if (isset($_GET['shots'])) $shots =  intval($_GET['shots']);

else {
    $shots = 1000;
}

// var_dump($shots);
//  die();

echo "<h1>Three qbit quantum circuit </h1>";
echo "<h2>Enjoy using url  parameters!</h2>";

echo "<br> q0state: "  . $q0state ;
echo "<br> q0nstates: " . $q0nstates ;
echo "<br>";
echo "<br> q1state: "  . $q1state ;
echo "<br> q1nstates: " . $q1nstates ;
echo "<br>";
echo "<br> q2state: "  . $q2state ;
echo "<br> q2nstates: " . $q2nstates ;
echo "<br>";
echo "<br> q0rot: "  . $q0rot ;
echo "<br>";
echo "<br> q1rot: "  . $q1rot ;
echo "<br>";
echo "<br> shots: "  . $shots ;





// $q0nstates = 5;

$qn0 = $q0nstates - 1;
$qn1 = $q1nstates - 1;
$qn2 = $q2nstates - 1;
$q0 = $q0state;
$q1 = $q1state;
$q2 = $q2state;
$qr0 = $q0rot;
$qr1 = $q1rot;

$circ = <<<EOD

<pre>
          ┌─────────────┐     ┌─────────────┐               ┌─┐
q_0: ─|0>─┤ Rx($q0 * π/$qn0) ├──■──┤ Rx($qr0 * π/$qn0) ├───────────────┤M├───
          ├─────────────┤┌─┴─┐└─────────────┘┌─────────────┐└╥┘┌─┐
q_1: ─|0>─┤ Rx($q1 * π/$qn1) ├┤ X ├───────■───────┤ Rx($qr1 * π/$qn1) ├─╫─┤M├
          ├─────────────┤└───┘     ┌─┴─┐     └───┬─┬───────┘ ║ └╥┘
q_2: ─|0>─┤ Rx($q2 * π/$qn2) ├──────────┤ X ├─────────┤M├─────────╫──╫─
          └─────────────┘          └───┘         └╥┘         ║  ║
c: 3/═════════════════════════════════════════════╩══════════╩══╩═
                                                  2          0  1
</pre>
EOD;


$circ_zero = <<<EOD

<pre>
          ┌─────────────┐     ┌─────────────┐               ┌─┐
q_0: ─|0>─┤ Rx(1 * π/2) ├──■──┤ Rx(1 * π/2) ├───────────────┤M├───
          ├─────────────┤┌─┴─┐└─────────────┘┌─────────────┐└╥┘┌─┐
q_1: ─|0>─┤ Rx(1 * π/2) ├┤ X ├───────■───────┤ Rx(1 * π/2) ├─╫─┤M├
          ├─────────────┤└───┘     ┌─┴─┐     └───┬─┬───────┘ ║ └╥┘
q_2: ─|0>─┤ Rx(1 * π/2) ├──────────┤ X ├─────────┤M├─────────╫──╫─
          └─────────────┘          └───┘         └╥┘         ║  ║
c: 3/═════════════════════════════════════════════╩══════════╩══╩═
                                                  2          0  1
</pre>
EOD;



print_r ($circ);

// $qasm = '"OPENQASM 2.0;\ninclude \"qelib1.inc\";\n\nqreg q[2];\ncreg c[2];\n\nreset q[0];\nreset q[1];\nrx(pi*' . $q0state . ' /(' . $q0nstates . '-1)) q[0];\ncx q[0],q[1];\nmeasure q[0] -> c[0];\nmeasure q[1] -> c[1];"';



$qasm_input = <<<EOD
"OPENQASM 2.0;
include \"qelib1.inc\";
qreg q[3];
creg c[3];

reset q[0];
reset q[1];
reset q[2];

rx(pi * $q0 / ($qn0 - 1)) q[0];
rx(pi * $q1 / ($qn1 - 1)) q[1];
rx(pi * $q2 / ($qn2 - 1)) q[2];

cx q[0], q[1];
rx(pi * $qr0 / ($qn0 - 1)) q[0];
cx q[1], q[2];
rx(pi * $qr1 / ($qn1 - 1)) q[1];
measure q[0] -> c[0];
measure q[1] -> c[1];
measure q[2] -> c[2];"
EOD;

$qasm  = str_replace("\n","\\n",$qasm_input);




echo "<br> request fron qasm:  " . $qasm . "<br>";

getMeasuresV2($qasm,$shots);
