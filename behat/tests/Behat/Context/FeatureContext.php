<?php


use Behat\Behat\Context\SnippetAcceptingContext;


use Behat\Behat\EventDispatcher\Event\AfterStepTested;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\BeforeFeatureScope;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Behat\Hook\Scope\BeforeStepScope;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use \emuse\BehatHTMLFormatter\BehatHTMLFormatterExtension;
use Behat\Behat\Hook\Call\AfterStep;
use Behat\Behat\Tester\Result\ExecutedStepResult;
use emuse\BehatHTMLFormatter\Classes\Step;
use Behat\Behat\Hook\Scope\AfterFeatureScope;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;

class FeatureContext extends RawMinkContext implements SnippetAcceptingContext
{
    use AssertTrait;

    /**
     * @var Step[]
     */


    protected static $currentFeature;
    protected static $currentSuite;
    public $currentScenario;
    public static $time;
    public static $date;
    public static $transformArray;


    public function __construct()
    {

    }


    /**
     * @BeforeSuite
     */
    public static function BeforeSuite(BeforeSuiteScope $scope)
    {
        global $report;
        $report = "";
        $report = "null_BeforeSuite ";


    }

    /**
     * @BeforeScenario
     */
    public function BeforeScenario(BeforeScenarioScope $scope)
    {
        global $report;

        $this->currentScenario = $scope->getScenario();
        $feature = $scope->getFeature();


        //scenario head
        $print = '<h2>';
        $print .= '<div>';
        $print .= $scope->getScenario()->getKeyword(). ": ";
        $print .= '</div>';
        $print .= '</h2>';


        $print .= '<h4>';
        $print .= '<div>';
        $print .= $scope->getScenario()->getTitle();
        $print .= '</div>';
        $print .= '</h4>';


        $report = $report . $print;
        return $print;
    }


    /**
     * Take screen-shot when step fails.
     * Take screenshot on result step (Then)
     * Works only with Selenium2Driver.
     *
     * @AfterScenario
     * @param \Behat\Behat\Hook\Scope\AfterScenarioScope
     */
    public function AfterScenario(\Behat\Behat\Hook\Scope\AfterScenarioScope $scope)
    {
        global $report;


        $print = "";


    }


    /**
     * Take screen-shot when step fails.
     * Take screenshot on result step (Then)
     * Works only with Selenium2Driver.
     *
     * @AfterStep
     * @param AfterStepScope $scope
     */
    public function AfterStep(AfterStepScope $scope)
    {

        global $report;


        $print = "";

        if (!$scope->getTestResult()->isPassed()) {


            $print .= '<h4>';
            $print .= '<div>';
            $print .= '<p style="color:red;">This is a bug: </p>';
            $print .= 'Failed step: ' . $scope->getStep()->getText();
            $print .= '</div>';;
            $print .= '</h4>';


        }

        // $currentSuite = self::$currentSuite;
        // var_dump('ciccio $currentSuite$currentSuite$currentSuite');
        //  var_dump($currentSuite);
        //  die();
        //if test has failed, and is not an api test, get screenshot


        //   var_dump($this->getSession()->getDriver());

        if (!$scope->getTestResult()->isPassed()) {
            $report = $report . $print;
            //  $driver = $this->getSession()->getDriver();
            //  if (!$driver instanceof Selenium2Driver) {
            return;
        }

        //create filename string
        //       $fileName = basename($scope->getFeature()->getFile()) . '.' . $this->currentScenario->getLine() . '.' . $scope->getStep()->getLine();
        //      $fileName = str_replace('.feature', '', $fileName);

        //     $fileNamePng = $fileName . '.png';
        //     $fileNameHtml = $fileName . '.html';
        /*
         * Determine destination folder!
         * This must be equal to the printer output path.
         * How the fuck do I get that in here???
         *
         * Fuck it, create a temporary folder for the screenshots and
         * let the Printer copy those to the assets folder.
         * Spend too many time here! And output is not the contexts concern, it's the printers concern.
         */

        //   $temp_destination = getcwd() . DIRECTORY_SEPARATOR . "html_report/screenshots";
        //   if (!is_dir($temp_destination)) {
        //       mkdir($temp_destination, 0777, true);
        //   }


        // if ($this->getSession()->isStarted()) {
        //     $this->saveScreenshot($fileNamePng, $temp_destination);

        #    $eventResult = $this->getStopwatch()->stop($scope->getStep()->getText());
        #    fwrite(STDOUT,'ciccio', 10);
        //  $screenshotPathFile = 'screenshots' . '/' . $fileNamePng;
        //    sprintf(" screenshot generated: " . $temp_destination . '/' . $fileNamePng);

        //   $print .= '<div>';
        //   $print .= '<p><img src=' . $screenshotPathFile . ' alt="screenshot"></p>';
        //   $print .= '</div>';


        // Let us save the page source code on errors:
        // It helps us debug the test.

        //create filename string
        //  $htmlContent = sprintf('<!DOCTYPE html><html>%s</html>', $this->getSession()->getPage()->getHtml());
        //  file_put_contents(implode(DIRECTORY_SEPARATOR, array($temp_destination, $fileNameHtml)), $htmlContent);

        // $print .= '<div>';
        // $print .= '<p><a href=' . implode(DIRECTORY_SEPARATOR, array("/sibilla/behat/html_report/screenshots", $fileNameHtml)) . '>html page</a></p>';
        //  $print .= '</div>';


        //    $file = 'html_report/Index.html';
        //      file_put_contents($file, $print, FILE_APPEND);

        //        }

        //   }

    }


    /**
     * @AfterFeature
     *
     * @param \Behat\Behat\Hook\Scope\AfterFeatureScope $scope
     * @return string  : HTML generated
     *
     */
    public static function AfterFeature(\Behat\Behat\Hook\Scope\AfterFeatureScope $scope)
    {
        global $report;


        $print = "";
        if (!$scope->getTestResult()->isPassed()) {


            $print .= '<h3>';
            $print .= '<div>';

            $print .= '</div>';


            $print .= '<div>';
            $print .= '</div>';
            $print .= '</h3>';

     //       $report = $report . "AfterFeature: " . $print . "      ";

        }

      //  $report = $report . "_AfterFeature ";

    }


    public function setTransformValues($customArray = '')
    {
        global $report;


        $report = $report . "_setTransformValues ";

        self::$time = time();
        self::$date = date('Ymd', self::$time);
        self::$transformArray = array(
            "<time>" => self::$time,
            "<date>" => self::$date,
        );
        foreach ((array)$customArray as $key => $value) {
            self::$transformArray[$key] = $value;
        }
    }

}



