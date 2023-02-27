<?php

$debug= false;
if($debug){

  echo "externalPageGetAction" . "<br>";

  $action = <<<EOD
  {
    "parameters": {
      "externalUrl": "https://https-programmitv-it.translate.goog/stasera.html?_x_tr_sl=auto&_x_tr_tl=it&_x_tr_hl=it&_x_tr_pto=wapp",
      "get": {
        "cicio": "//*[@id='cbe5']/span[1]/pre",
        "cicio2": "//*[@id=\"cbe5\"]/span[1]/pre"
      }
    }
  }
EOD;

$action2 = <<<EOD
{
  "parameters": {
    "externalUrl": "https://https-programmitv-it.translate.goog/stasera.html?_x_tr_sl=auto&_x_tr_tl=it&_x_tr_hl=it&_x_tr_pto=wapp",
    "get": {
      "cicio": "//*[@id='cbe5']/span[1]/pre",
      "cicio2": "//*[@id=\"cbe5\"]/span[1]/pre"
    }
  }
}
EOD;

$class = new externalPageGetAction();
$response = $class->externalPageGetAction($action);

  echo "response" . "<br>";
  var_dump($response) ;
  echo  "<br>" . "fin_e" . "<br>";


die();
}


class externalPageGetAction {

      public function __construct()
      {


      }


function externalPageGetAction($action)
{

  if (!is_array($action)) {
  $action=  json_decode($action, true); // decoding received JSON to array, idempotente!
}


    $response['from'] = "externalPageGetAction";

    $externalGetCall = $action["parameters"]["externalUrl"];
    $gets = $action["parameters"]["get"];

    $doc = new DOMDocument();
    @$doc->loadHTMLFile($externalGetCall);
    $xpath = new DOMXpath($doc);


    $returnArray = array();
    foreach ($gets as $key => $value) {

        $value1 = trim($xpath->query($value)->item(0)->nodeValue);

        if ($value1 == "") {
            $value1 = trim($xpath->query($value)->item(0)->textContent);

        }
        if ($value1 == "") {
            $value1 =  "--not found--";

        }


        $returnArray[$key] = $value1;
        $response['values'][$key] = $returnArray[$key] ;

    }

    // Inizializza l'array 'response' come un array vuoto se non è già stato inizializzato.
    if (!isset($GLOBALS['babboDiMinchia']['response'])) {
    $GLOBALS['babboDiMinchia']['response'] = array();
}

    array_push($GLOBALS['babboDiMinchia']['response'], $response);


    //   var_dump($returnArray);
    //  die();
    return $returnArray;


}
}
