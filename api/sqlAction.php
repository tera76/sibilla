<?php
require __DIR__ . '/conf/environment.conf.php';


$debug= false ;
if($debug){
  echo "sql" . "\r\n";
  $action = <<<EOD
  {
  	"from": "fdfsds",
  	"parameters": {
  		"query": "select * from syb_alarms_map;"
  	}
  }
EOD;
$class = new sqlAction();
$response = $class->sql($action);


var_dump($response) ;
echo  "\r\n" . "fin_e" . "\r\n";
die();
}



class sqlAction {

      public function __construct()
      {


      }


function sql($action)
{


    // Reporting E_NOTICE can be good too (to report uninitialized
// variables or catch variable name misspellings ...)
    error_reporting(E_ERROR);

    if (!is_array($action)) {
      $action=  json_decode($action, true); // decoding received JSON to array, idempotente!
    }



    $from_parameter = $action["from"];
    if(!isset($from_parameter)) $from_parameter = "sql";

    $sql = $action["parameters"]["query"];

    $dbConnect = new mysqli(host, username, password, database) or die("Errore durante la connessione al database");


    if (strpos(strtoupper($sql), 'SELECT') === 0) {
        // It starts with 'SELECT
        $data = $dbConnect->query($sql)->fetch_all();

    } else {

        $data = $dbConnect->query($sql);
     //    var_dump($dbConnect->error);
     //  die();
    }

        header("content-type:application/json");

    $response['from'] = $from_parameter;
    $response['query'] = $sql;
    $response['values'] = $data;
    // $GLOBALS['babboDiMinchia'] .= '{"from":"$from","query":"' . $sql . '","values":[';
    // $GLOBALS['babboDiMinchia'] .= json_encode($data);
    //  $GLOBALS['babboDiMinchia'] .= "]},";



    // Inizializza l'array 'response' come un array vuoto se non è già stato inizializzato.
    if (!isset($GLOBALS['babboDiMinchia']['response'])) {
    $GLOBALS['babboDiMinchia']['response'] = array();}

    array_push($GLOBALS['babboDiMinchia']['response'], $response);
    $dbConnect->close();

    return $data;

}    }
