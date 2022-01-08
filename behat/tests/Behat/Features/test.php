<?php
// this is the model for json response

$GLOBALS['cacca']['response'] = array();
cacca();


function cacca()
{

    echo "start";



    $fuck['from'] = "ciccio";
    $fuck['values'] = "ffffff";


    array_push($GLOBALS['cacca']['response'] , $fuck);


    $fuck['from'] = "ciccioss";
    $fuck['values'] = "ffffff";


    array_push($GLOBALS['cacca']['response']  , $fuck);
    var_dump(json_encode($GLOBALS['cacca']));


    echo "fine";
    die();

    $stronzo = array("ss", "dd", "dd");

    $fuck['from'] = "ciccioss";
    $fuck['values'] = $stronzo;

    array_push($stack['cacca']['response'], $fuck);


    print_r($stack['cacca']);
    var_dump(json_encode($stack['cacca']));


    echo "fine";
}