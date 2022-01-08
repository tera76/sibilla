<?php

zzz = <<<EOD
{
	"request": [{
		"name": "login",
		"parameters": {
			"keyCode1": "1976"
		}
	}, {
		"name": "sql",
		"from": "todaytv",
		"parameters": {
			"query": "select title, notes , link from syb_book_library where id < 500 order by id desc ;    "
		}
	}]
}
EOD;


$dataToarray = json_decode($data);
$data = json_encode($dataToarray, JSON_PRETTY_PRINT);

$testCallresponse = myLibrary($data);


function myLibrary($data)
{



    $postdata = $data; //http_build_query($data);
    $opts = array('http' =>
        array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );


    require __DIR__ . '/../api/conf/environment.conf.php';

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
    /*
var_dump($response);
echo ($response);
die();
    */
    $ciccio = $response->response;
 ;
    $tv = null;

foreach ($ciccio as $chiave => $responseItem) {

    if ($responseItem->from == 'todaytv') {

        $tv = $responseItem->values ;
        //righe
        $size = sizeof($tv);
        var_dump($size);
        echo "<br>";
        echo "<br>";
       for($i=0;$i< $size;$i++){
           echo $tv[$i][0] . " - " ;
           echo $tv[$i][1] . " - " ;;
           if($tv[$i][2] != null && $tv[$i][2]  != "") {
           echo "<a href='". $tv[$i][2] ."'>Link</a>";}
           echo "<br>";
           echo "<br>";



      //  var_dump($tv[$i][0]);
       }
die();



    }


}


    // initialize var used in the page
   $maxSize= sizeof($tv);
    printf($maxSize);

  die();


    printf($tv[i][0]);
    echo "<br>";
    printf($tv[0][1]);
    echo "<br>";
    echo "<br>";
    printf($tv[1][0]);
    echo "<br>";
    printf($tv[1][1]);
    echo "<br>";
    echo "<br>";
    printf($tv[2][0]);
    echo "<br>";
    printf($tv[2][1]);
    echo "<br>";
    echo "<br>";
    printf($tv[3][0]);
    echo "<br>";
    printf($tv[3][1]);
    echo "<br>";
    echo "<br>";
    printf($tv[4][0]);
    echo "<br>";
    printf($tv[4][1]);
    echo "<br>";
    echo "<br>";
    printf($tv[5][0]);
    echo "<br>";
    printf($tv[5][1]);
   // die();





    $data = <<<EOD

<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <title>Hello Work Report</title>
    <link href="http://bit.ly/GPvP5H" rel="stylesheet" type="text/css">
</head>

<body>

<h1>The Sibilla test Report</h1>

<form action="insert.php" method="post">
    Value1: <input type="text" name = "field1" /><br/>
    Value2: <input type="text" name = "field2" /><br/>
    Value3: <input type="text" name = "field3" /><br/>
    Value4: <input type="text" name = "field4" /><br/>
    Value5: <input type="text" name = "field5" /><br/>
    <input type="submit" />
</form>

Hello world, <br>
 
    
 
 
 
EOD;
    echo "$data";

}




