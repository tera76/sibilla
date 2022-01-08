<?php

include_once 'externalServiceGetAction.php';

function getTitleSubstringFromCorriereAction($action)
{




    $titleSubstring = "";


    $internalAction = '{"parameters": {';
    $internalAction .= '"externalUrl": "https://toprated.rcs.it/toprated/rest/request.action?site=rcscorriereproddef&dominio=www.corriere.it&tipologia=articolo&interazione=piuvisti&giorni=1&numerorisultati=10",';
    $internalAction .= '"get": {';
    $internalAction .= '"title": "classifica.dettaglioClassifica.0.title"}}}';



    $internalAction_decoded = json_decode($internalAction, true);

   $ciccio =  externalServiceGetAction($internalAction_decoded);




   $title = $ciccio['title'];
    $titleSubstring = substr($title,0,8);

    $response['from'] = "getTitleSubstringFromCorriere";
    $response['values']['titleSubstring'] = $titleSubstring;

    //  $GLOBALS['babboDiMinchia'] .= '{"from":"getTitleSubstringFromCorriere","values": {';
   // $GLOBALS['babboDiMinchia'] .= '"titleSubstring":"' . $titleSubstring . '"';
   // $GLOBALS['babboDiMinchia'] .= '}},';

      array_push($GLOBALS['babboDiMinchia']['response'], $response);
    return $titleSubstring;
}

