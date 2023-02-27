<?php

include_once "./getQueryFilmImage.php";
include_once "./externalServiceGetAction.php";
include_once "./externalPageGetAction.php";
include_once "./sqlAction.php";


$debug= false;
if($debug){

  echo "saveDataHistoryAction" . "<br>";

  $action = <<<EOD
  [
  [
    "staseraInTv_006_18reti_italia1_image_link",
    "https://www.googleapis.com/customsearch/v1?key=__GOOGLEAPITOKEN__&q=__QUERYFILM__&cx=02c284d1e5e214401&limit=1&totalResults=1",
    "items.__IDVAR__.pagemap.cse_image.0.src",
    "json"
  ]
]
EOD;


$class = new saveDataHistoryAction();
$response = $class->saveDataHistoryAction($action);

  echo "saveDataHistoryAction" . "<br> aaaa";
  var_dump($response) ;
  echo  "<br>" . "fin_e" . "<br>";


die();
}

class saveDataHistoryAction {

      public function __construct()
      {


      }
    function saveDataHistoryAction($allAlarms)
    {


      if (!is_array($allAlarms)) {
        $allAlarms=  json_decode($allAlarms, true); // decoding received JSON to array, idempotente!
      }



//     $allAlarms=  json_decode($allAlarms, true); // decoding received JSON to array, idempotente!

        foreach ($allAlarms as $item)
        {


            $name = $item[0];
            $url = $item[1];
            $locator = $item[2];
            $locatorType = $item[3];


            if ($locator != "localAction")
            {


                if ($locatorType == "" || $locatorType == "json")
                {
            // var_dump("*******************************" . $locatorType);



                    $is_Imagelink = preg_match("/_image_link/", $name);
                    if ($is_Imagelink)
                    {
                        // $url="https://www.googleapis.com/customsearch/v1?key=AIzaSyBEv-3jONsGVikOmPF9Kbd-AzANaZ4a9zo&q=ciccio&cx=02c284d1e5e214401&limit=1&totalResults=1";
                        $class = new getQueryFilmImage();
                        $query = $class->getQueryFilmImage($name);



                        //  $query="via%20col%20vento";
                        $url = preg_replace("/__QUERYFILM__/", $query, $url);
                        $token1 = "AIzaSyBEv-3jONsGVikOmPF9Kbd-AzANaZ4a9zo";
                        $token2 = "AIzaSyCqQ4gssseK6C2NlhapDw_iOfNHBV_50E0";
                        $url = preg_replace("/__GOOGLEAPITOKEN__/", $token1, $url);
                    }


                    if (strpos($locator, "__IDVAR__") > 0)
                    {
                        for ($ii = 0;$ii < 3;$ii++)
                        {
                            $locator_var = preg_replace('/__IDVAR__/', $ii, $locator);

                            $internalAction = <<<EOD
{
  "parameters": {
    "externalUrl": "$url",
    "get": {
      "$name": "$locator_var"
    }
  }
}
EOD;



                            $internalAction_decoded = json_decode($internalAction, true);


                            $class = new externalServiceGetAction();
                            $externalServiceGetAction = $class->externalServiceGetAction($internalAction_decoded);

                            $value = '';
                            $value = $externalServiceGetAction[$name];
                            if ($value != null && $value != '')
                            {
                                break;
                            }
                        }
                    }
                    else
                    {


                        $internalAction = <<<EOD
                    {
                    	"parameters": {
                    		"externalUrl": "$url",
                    		"get": {
                    			"$name": "$locator"
                    		}
                    	}
                    }
EOD;


                        $internalAction_decoded = json_decode($internalAction, true);



                        $class = new externalServiceGetAction();
                        $externalServiceGetAction = $class->externalServiceGetAction($internalAction_decoded);
                        $value = $externalServiceGetAction[$name];


                    }
                    $this->saveAlarmsOnDb($name, $value);
                }
                elseif ($locatorType == "xpath" || $locatorType == "html")
                {



                    //   var_dump("*******************************" . $locatorType);
                    $internalAction = <<<EOD
                    {
                    	"parameters": {
                    		"externalUrl": "$url",
                    		"get": {
                    			"$name": "$locator"
                    		}
                    	}
                    }
EOD;


                    $internalAction_decoded = json_decode($internalAction, true);

                    $class = new externalPageGetAction();
                    $externalServiceGetAction = $class->externalPageGetAction($internalAction_decoded);

                    $value = $externalServiceGetAction[$name];

                    $this->saveAlarmsOnDb($name, $value);
                }
            }
        }

        return "done";
    }



    function saveAlarmsOnDb($data, $value)
    {
        // apostrofi
        $value = str_replace("'", "’", $value);

        //   $query = "INSERT INTO syb_alarms_history (data,value) VALUES ('" . $data . "','" . $value . "');";
        $query = "INSERT INTO syb_alarms_history (data,value) VALUES ('$data','$value');";

        $internalAction["parameters"]["query"] = $query;

        $class = new sqlAction();
        $response = $class->sql($internalAction);

    }
}
