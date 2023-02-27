<?php

$debug= false;
if($debug){

  echo "externalServiceGetAction" . "<br>";

  $action = <<<EOD
  {
    "parameters": {
      "externalUrl": "https://toprated.rcs.it/toprated/rest/request.action?site=rcscorriereproddef&dominio=www.corriere.it&tipologia=articolo&interazione=piuvisti&giorni=1&numerorisultati=10",
      "get": {
        "cicio": "classifica.dettaglioClassifica.0.title",
        "cicio2": "classifica.dettaglioClassifica.0.title"
      }
    }
  }
EOD;

$class = new externalServiceGetAction();
$response = $class->externalServiceGetAction($action);
#  $response = externalServiceGetAction->externalServiceGetAction($action);
  echo "response" . "<br>";
  var_dump($response) ;
  echo  "<br>" . "fin_e" . "<br>";


die();
}

class externalServiceGetAction {

      public function __construct()
      {
      }

function externalServiceGetAction($action)
{

if (!is_array($action)) {
  $action=  json_decode($action, true); // decoding received JSON to array, idempotente!
}



  $response['from'] = "externalServiceGet";
  $externalGetCall = $action["parameters"]["externalUrl"];




  $gets = $action["parameters"]["get"];


    //  $GLOBALS['babboDiMinchia'] .= "{\"from\":\"externalServiceGetAction\",\"values\": {";



    $externalJson = file_get_contents($externalGetCall);
    $decoded_externalJson = json_decode($externalJson, true); // decoding received JSON to array



    $returnArray = array();

    foreach ($gets as $key => $value) {



        $explodedGetTree = explode(".", $value);
        $jsonChild = $decoded_externalJson;

        foreach ($explodedGetTree as $child) {

            $jsonChild = $jsonChild[$child];

        }


        //  $GLOBALS['babboDiMinchia'] .= '"' . $key . '":"' . $jsonChild . '",';

        $returnArray[$key] = $jsonChild;

        $response['values'][$key] =   $returnArray[$key];

    }

    // Inizializza l'array 'response' come un array vuoto se non è già stato inizializzato.
    if (!isset($GLOBALS['babboDiMinchia']['response'])) {
    $GLOBALS['babboDiMinchia']['response'] = array();}

    array_push($GLOBALS['babboDiMinchia']['response'], $response);
    // $GLOBALS['babboDiMinchia'] .= '"":""}},';

    return $returnArray;
    // die();

}

}
