
<?php


use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Behat\Behat\ApplicationFactory;
require_once __DIR__ . '/../behat/vendor/bin/behat';




class BehatTest
{


    public function testRunBehat()
    {


      //  define('BEHAT_BIN_PATH', __FILE__);

  //      define('BEHAT_BIN_PATH', getcwd() . '/../behat/vendor/bin/behat');
//echo  BEHAT_BIN_PATH;
  // die();

        if (is_file($autoload = getcwd() . '/../behat/vendor/autoload.php')) {
            require $autoload;
        }



        $behat =new \Behat\Behat\ApplicationFactory();

       // $behat->setAutoExit(false);
     //     $input = new ArrayInput([  '--tags' => '@zzz' , '--format'=>'pretty']);
      //     $input = new ArrayInput(array('--tags' => '@zzz'));
        $input = new ArrayInput(array(
            '../behat/tests/Behat/Features/ttt.feature'
        ));

        $inputm = new ArrayInput(array(
            '-e' => 'dev',
            '--help'
        ));
        $output = new ConsoleOutput();
        echo "pre";
        $result = $behat->createApplication()->run($input, $output) ;
        $out1 = ob_get_contents();
        echo $result;
        echo $out1;
        echo "post";
       // var_dump( $output->getErrorOutput());





        return $result;


    }
}

echo "ciccio2";
$obj = new BehatTest();
  $obj->testRunBehat();


?>