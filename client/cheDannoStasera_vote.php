da<?php

$start = microtime(true);

error_reporting(0);

if (isset($_GET['vote'])) $vote =  intval($_GET['vote']) ;
else {
    $vote = 0; //0,1   state name
}

$leonIconUp= "&#128077;";
$leonIconDown= "&#128078;";

if($vote==1) $noteString="si! good! " . $leonIconUp;
else if($vote==-1) $noteString="no! fuck!" . $leonIconDown;
else if($vote==null) $noteString="booooooo!";

echo "<h3>Hai votato!</h3>";
echo "<h2>$noteString</h2>";




//nex
if (isset($_GET['program'])) $program =   ($_GET['program']) ;
else {
    $program = "null"; //0,1   state name
}

echo "<h3>per il contenuto:</h3>";
echo "<p>$program</p>";

$str = $program;

// $recucedTitle1 = preg_replace('/([0-9]|0[0-9]|1[0-9]|2[0-3]).[0-5][0-9]/', '',   $str);

$recucedTitle1 = preg_replace('/([0-2][0-9]|1[0-9]|2[0-3]).[0-5][0-9]/', '',   $str);


$words = explode(" ", trim($recucedTitle1));



$emptyArray = (array) "";
$words = explode(" ", trim($recucedTitle1));

$recucedTitle2 = trim($words[0] . " " . $words[1] . " " . $words[2]);


$recucedTitle3 = preg_replace('/"/','\"', $recucedTitle2);

$recucedTitle4 = preg_replace('/\'/',"\'", $recucedTitle3);

$recucedTitle = $recucedTitle1;
// var_dump($words[0] . ' ' . $words[2]);





echo "<br> reduced title: ";
echo $recucedTitle;
echo "<br>";


if($vote==1) {

  $tvQueryAddFilterPreferred = "INSERT INTO syb_tv_preferred(`keys`) VALUES('$recucedTitle');";
  $tvQueryDeleteFilterPreferred = "DELETE FROM syb_tv_notPreferred where `keys`='$recucedTitle' limit 1;";
}
  else if($vote==-1) {
    $tvQueryAddFilterPreferred = "INSERT INTO syb_tv_notPreferred(`keys`) VALUES('$recucedTitle');";
  //  $tvQueryDeleteFilterPreferred = "DELETE FROM syb_tv_preferred where `keys`='$recucedTitle' limit 1;";
    $tvQueryDeleteFilterPreferred = "select * from  syb_tv_preferred limit 1;"; // onutile fake query
  }


tvVoteAddRemove($tvQueryAddFilterPreferred, $tvQueryDeleteFilterPreferred);
echo "<a href=\"cheDannoStasera.php\">GO BACK</a>";

	//			echo "<button onclick="history.back()">Go Back</button>";
function tvVoteAddRemove($valueAdd, $valueRemove)

{



// $tvQueryAddFilterNotPreferred = "INSERT INTO syb_tv_notPreferred(`keys`) VALUES('$value');";
// echo $value;
$postdata = <<<EOD
{
"request": [        {
        "name": "login",
        "parameters": {
            "email": "ciccio",
            "keyCode1": "1970"
        }
    },
{
  "name": "sql",
  "parameters": {
    "query": "$valueAdd"
  }
},
{
"name": "sql",
"parameters": {
"query": "$valueRemove"
}
}
]
}
EOD;

$opts = array('http' =>
    array(
        'method' => 'POST',
        'header' => ["content-type: application/json",
        "access_token: bearer 1970"
      ],
        'content' => $postdata
    )
);

    require __DIR__ . "/../api/conf/environment.conf.php";

    $url = apiEntryPoint;

    $context = stream_context_create($opts);

    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        exit("Unable to update data at $url");
    }

    if (JSON_ERROR_NONE !== json_last_error()) {
        exit("Failed to parse json: " . json_last_error_msg());
    }

    $response = json_decode($response);

    $ciccio = $response->response;
  }
