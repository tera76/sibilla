<?php


function externalPageGetAction($action)
{

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
        $response['values'][$key] = $value1;

    }
    array_push($GLOBALS['babboDiMinchia']['response'], $response);


    //   var_dump($returnArray);
    //  die();
    return $returnArray;


}
