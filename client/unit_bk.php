<?php

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Behat\Behat\ApplicationFactory;

class MyClass
{
    public function hello()
    {
        return "world";
    }
}


$obj = new MyClass();
echo $obj->hello();

echo "ciccio1";



class BehatTest
{


    /**
     * @group Behat
     */
    public function testRunBehat()
    {


        define('BEHAT_BIN_PATH', __FILE__);


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
                    'You must set up the project dependencies, run the following commands:' . PHP_EOL .
                    'curl -s http://getcomposer.org/installer | php' . PHP_EOL .
                    'php composer.phar install' . PHP_EOL
                );
                exit(1);
            }
        }


        $factory = new  ApplicationFactory();


        $input = new ArrayInput(array(
            'behat',
            '-e' => 'test',
            '--format' => 'progress',
            '--tags' => '@orm,@database'
        ));

        $output = new ConsoleOutput();

           $result = $factory->createApplication()->getVersion();

          $result = $factory->createApplication()->run($input,output);
        echo "ciccio23323423423";
        echo "dddddd";


        return $result;


    }
}

echo "ciccio2";
$obj = new BehatTest();
echo $obj->testRunBehat();


?>