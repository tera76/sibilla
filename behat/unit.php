<?php


use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Behat\Behat\ApplicationFactory;




class BehatTest
{


    public function testRunBehat()
    {
        global $report ;
        $report="diocane";
echo           $report ;



         define('BEHAT_BIN_PATH', __FILE__);



        if (is_file($autoload = getcwd() . '/vendor/autoload.php')) {
            require $autoload;
        }



        $behat =(new  ApplicationFactory())->createApplication();


//        $input = new \Symfony\Component\Console\Input\StringInput('--format --out std  --tags @zzz ');

        $input = new \Symfony\Component\Console\Input\StringInput('--format pretty --out std --format html --out html_report --tags @zzz');


        $output = new ConsoleOutput();

        $result="ciccio_unit0";
        try {
      $behat->doRun($input,$output);
        } catch (Exception $e) {
            echo $e;
        }
        echo $e;


        return $result;


    }
}

echo "ciccio2</br>";

global $report;
echo $report;

$obj = new BehatTest();
     $obj->testRunBehat();

echo $report;
?>