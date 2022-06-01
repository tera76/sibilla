<?php

$data = null;
if(isset($_GET['request'])) $data= $_GET['request'];

if ($data == "") {
    $data = <<<EOD
    {
        "request": [
            {
                "name": "login",
                "parameters": {
                    "email": "ciccio",
                    "keyCode1": "1970"
                }
            },
            {
                "name": "sql",
                "from": "todaytv",
                "parameters": {
                    "query": "select distinct data,value from (select  * from syb_alarms_history where  data like 'staseraInTv%' and  DATE(`timestamp`) >= CURDATE()  order by timestamp desc) as h    "
                }
            }
        ]
    }
EOD;
}

$dataToarray = json_decode($data);
$data = json_encode($dataToarray, JSON_PRETTY_PRINT);

// $data = $_POST['request'];

$testCallresponse = testCall($data);

//$testCallresponse = exec(testCall($data));

$duration = $testCallresponse['duration'];
$response = $testCallresponse['response'];

//$data = $_POST['request'];



function testCall($data)
{


//Recupero il valore del parametro "$code"
// $data = $_POST['request'];
//    echo '*********** send: ', '</br>';
    //   echo $data;

    $postdata = $data; //http_build_query($data);
    $opts = array('http' =>
        array(
            'method' => 'POST',
            'header' => ["content-type: application/json",
            "access_token: bearer 1970"
          ],
            'content' => $postdata
        )
    );


    require __DIR__ . '/../api/conf/environment.conf.php';


    //  $url = "http://localhost/sibilla/api/post.php";
    // $url = "https://pasteurian-visitors.000webhostapp.com/sibilla/api/post.php";
    $url = apiEntryPoint;


    $context = stream_context_create($opts);

    $start = microtime(true);
    $response = file_get_contents($url, false, $context);
    $end = microtime(true);

    $duration = $end - $start;
    $output = "";

    //   $output .= "'</br>', '*********** time: ',$duration, '</br>'";

    //   $output .= "'</br>', '*********** received: ', '</br>'";
    if ($response === false) {
        exit("Unable to update data at $url");
    }


    if (JSON_ERROR_NONE !== json_last_error()) {
        exit("Failed to parse json: " . json_last_error_msg());
    }


    // var_dump($response);

    $response = json_decode($response);
    $response = json_encode($response, JSON_PRETTY_PRINT);
    $output = array();
    $output['response'] = $response;


    $output['duration'] = $duration;
    return $output;

}

?>



<!doctype html>
<html itemscope="itemscope" itemtype="http://schema.org/WebPage">
<head>
    <meta content="IE=8" http-equiv="X-UA-Compatible"/>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type"/>

    <meta NAME="GENERATOR" Content="Sibilla - test api">
    <title>Sibilla api test page</title>


</head>
<body>


<form method=”post”>
    <div>
        <legend>Sibilla test page</legend>
        <div align="left"><textarea rows="30" cols="60" name="request"><?php echo $data; ?></textarea>
            <textarea readonly rows="30" cols="60" name="response"><?php echo $response; ?></textarea></div>
    </div>
    <div><input type="submit" name="submit" value="send"></div>
    <label for="lfname">Response time: <?php echo $duration; ?></label>

</form>


</body>
</html>
