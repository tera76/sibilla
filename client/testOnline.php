<?php


// outputs the username that owns the running php/httpd process
// (on a system with the "whoami" executable in the path)
$output=null;
$retval=null;
$command1 = "cd ../behat; ./vendor/bin/behat --format pretty --out std --format html --out html_report tests/Behat/Features/onLine.feature";
// $command1 = "ls -lrt ../behat/vendor/bin/behat --version";
//  exec($command1, $output, $retval);
echo "Returnedsadsdsdsfd";



define('BEHAT_BIN_PATH',     __FILE__);




if (is_file($autoload = getcwd() . '/../behat/vendor/autoload.php')) {
    require $autoload;
}



if (!class_exists('Behat\Behat\ApplicationFactory', true)) {



    if (is_file($autoload = __DIR__ . '/../vendor/autoload.php')) {
        require($autoload);
    } elseif (is_file($autoload = __DIR__ . '/../../../autoload.php')) {
        require($autoload);
    } else {
        fwrite(STDERR,
            'You must set up the project dependencies, run the following commands:'.PHP_EOL.
            'curl -s http://getcomposer.org/installer | php'.PHP_EOL.
            'php composer.phar install'.PHP_EOL
        );
        exit(1);
    }
}





$factory = new \Behat\Behat\ApplicationFactory();


use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
// $input = new ArrayInput(['behat', '--version']);
$input = new ArrayInput([]);

$output = new ConsoleOutput();

try {

    $result = $factory->createApplication()->getVersion();
    var_dump("errrrrror");
} catch (Exception $e) {
    var_dump("errrrrror");
    print_r($e);
    die();
}


var_dump($result) ;
echo "<br>123123123123";
die();



echo "<br>stop";
die();


echo "<br>stop";
die();

print_r($factory->createApplication()->run());

echo "<br>stop";
die();
$factory->createApplication()->run("version");

die();






echo "<br>Returned with status $retval and output:\n";
echo '<br>';
print_r($output);
?>