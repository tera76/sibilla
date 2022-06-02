<?php

include_once './00ent_funcions.php';


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

$qasm = '"OPENQASM 2.0;\ninclude \"qelib1.inc\";\n\nqreg q[2];\ncreg c[2];\n\nreset q[0];\nreset q[1];\nrx(pi*1/(3-1)) q[0];\ncx q[0],q[1];\nmeasure q[0] -> c[0];\nmeasure q[1] -> c[1];"';
var_dump( $qasm);

die();
getMeasuresV2($qasm,1024);
# getMeasuresV2($qasm, 1);
echo "<br>Una sequenza di tre singole misure, a caso ";

getMeasuresV2($qasm, 1, 3);
 die();
