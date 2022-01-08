<?php

namespace Base;

use AssertTrait;
use Behat\Gherkin\Node\PyStringNode;
use Imbo\BehatApiExtension\Context\ApiContext;
use phpDocumentor\Reflection\Types\This;
use PHPUnit\Framework\Assert;
use Services\DatabaseConnection;
use Traits\ContainerAware;
use Utils\Container;

$authToken = null;

class ApiFeaturesContext extends ApiContext
{
    use AssertTrait;
    use ContainerAware;

    protected $parameters;

    /**
     * @var DatabaseConnection
     */
    protected $databaseConnection;

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
        $container = Container::getInstance();
      //  $databaseConnection = $container->get(DatabaseConnection::class);

        $config = new \Doctrine\DBAL\Configuration;
        $connectionParams = array(


            'dbname' => $this->parameters['database_name'],
            'user' => $this->parameters['database_user'],
            'password' => $this->parameters['database_password'],
            'host' => $this->parameters['database_host'],
            'driver' => 'pdo_mysql'
        );
        $this->connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

    }



    /**
     * @param
     * @Given I have the q-variable :qvar
     * @Given I add the q-variable :qvar
     */

    public function initializeQVar($qvar)
    {
    $sql = "INSERT INTO quantum_experience.q_variables (q_variables) VALUES ('$qvar')";
        $this->connection->exec($sql);

    }



    /**
     * @param
     * @param
     * @param
     * @Then Count of :arg1 in :arg2 should be equal to equal to :arg3
     */

    public function CountOnTable($variable,$table,$count )
    {

 var_dump($variable,$table, $count );
       die();


        $sql = "select count(*) from $table where $variables = $count";

     //   $this->connection->fetchAll($sql);
        $data = $this->connection->fetchAll($sql);
        var_dump("data: " . $data);
        $count = $data[0]['count(*)'];
        var_dump("count: " . $count);
        Assert::assertGreaterThanOrEqual("1", $count);
    }











    /**
     * @Given I am authenticated as admin user
     */
    public function authenticatedAsAdmin()
    {
        $token = $this->container->getParameter('auth.admin.token');
        $this->addRequestHeader('X-API-KEY', $token);
        $this->addRequestHeader('Content-Type', 'application/json');
    }

    /**
     * @Given Authentication token is done
     */
    public function generateAuthenticationToken()
    {
        $credentials = $this->parameters['auth']['admin'];

        $this->setRequestBody = $this->setRequestBody(
            '{"email":"admin@leadspark.app","password":"admin"}');
        //     $this->requestOptions = $options;
        $this->addRequestHeader('Content-Type', 'application/json');
        $this->requestPath('/login', 'POST');
        $resp = $this->response->getBody()->getContents();
        //       var_dump($resp);
        $resp_json = json_decode($resp);


        //        var_dump($resp_json);

        $token = $resp_json->{"token"};

        //      var_dump($token);

        $GLOBALS['authToken'] = $token;
        $this->addRequestHeader('Authorization', 'Bearer ' . $token);
        return $GLOBALS['authToken'];


    }


    public function getLeadIdByLeadStatus($arg1)
    {
        $id = 0;

        $config = new \Doctrine\DBAL\Configuration;

        $sql = "SELECT id  FROM lead where  status_id= '" . $arg1 . "' order by updated_at desc limit 1;";

        $data = $this->databaseConnection->doQuery($sql);
        $id = $data[0]['id'];
        return $id;


    }


    public function getLeadIdByLeadName($arg1,$status='')
    {
        $id = 0;
        if ($status == ''  ) {
        $sql = "SELECT id  FROM lead where concat(coalesce (first_name,''),' ', coalesce (last_name,'')) = '" . $arg1 . "' order by created_at desc limit 1;";
        var_dump($sql);
    } else {

$sql = "SELECT id  FROM lead where concat(coalesce (first_name,''),' ', coalesce (last_name,'')) = '" . $arg1 . "' and status_id='" . $status . "' order by created_at desc limit 1;";
}
       // var_dump($status);
       //  var_dump($sql);
$data = $this->databaseConnection->doQuery($sql);

        $id = $data[0]['id'];
        return $id;


    }

    public function getLeadIdByLeadNameAndStatusTask($arg1,$status)
    {
        $id = 0;

            $sql = "SELECT id  FROM lead where concat(coalesce (first_name,''),' ', coalesce (last_name,'')) = '" . $arg1 . "' and id in (select lead_id from task where status_id='" . $status . "' ) order by created_at desc limit 1;";


        $data = $this->databaseConnection->doQuery($sql);

        $id = $data[0]['id'];


        return $id;


    }



    public function getOpportunityIdByOpportunityName($arg1)
    {
        $id = 0;


        $sql = "SELECT id  FROM opportunity where   name = '" . $arg1 . "' order by created_at desc limit 1;";


        $data = $this->databaseConnection->doQuery($sql);
        $id = $data[0]['id'];
        return $id;


    }

    public function getTaskIdByLeadId($arg1)
    {
        $id = 0;

        $sql = "SELECT id  FROM task where lead_id ='" . $arg1 . "' order by created_at desc limit 1;";
        #  var_dump($sql);
        $data = $this->databaseConnection->doQuery($sql);
        $id = $data[0]['id'];

        return $id;


    }



    public function getUnqualifiedLeadIdByLeadName($arg1)
    {
        $id = 0;



        $sql = "SELECT id  FROM lead where  oncat(first_name,' ', last_name) = '" . $arg1 . "' and status_id=4 order by created_at desc limit 1;";


        $data = $this->databaseConnection->doQuery($sql);
        $id = $data[0]['id'];
        return $id;


    }


    public function getContactIdByContactName($arg1)
    {
        $id = 0;



        $sql = "SELECT id  FROM contact where  concat(first_name,' ', last_name) = '" . $arg1 . "' order by created_at desc limit 1;";


        $data = $this->databaseConnection->doQuery($sql);
        $id = $data[0]['id'];
        var_dump("id for name Contact: ");
        var_dump($id);
        return $id;


    }

    public function getEmailIdByContactId($arg1)
    {
        $id = 0;



        $sql = "SELECT id  FROM contact_email where contact_id = '" . $arg1 . "' order by created_at desc limit 1;";


        $data = $this->databaseConnection->doQuery($sql);
        $id = $data[0]['id'];
        var_dump("mailId for name ContactId: ");
        var_dump($id);
        return $id;


    }

    public function getPhoneIdByContactId($arg1)
    {
        $id = 0;



        $sql = "SELECT id  FROM contact_phone where contact_id = '" . $arg1 . "' order by created_at desc limit 1;";


        $data = $this->databaseConnection->doQuery($sql);
        $id = $data[0]['id'];
        var_dump("phoneId for name ContactId: ");
        var_dump($id);
        return $id;


    }



    public function getAccountIdByAccountName($arg1)
    {
        $id = 0;



        $sql = "SELECT id  FROM account where name = '" . $arg1 . "' order by created_at desc limit 1;";


        $data = $this->databaseConnection->doQuery($sql);
        $id = $data[0]['id'];
        var_dump("AccountID: ",$id );
        return $id;


    }

    /**
     * @Given I request contact by name :path using HTTP GET
     */
    public function requestContactByName($fieldName)
    {
        $id = $this->getContactIdByContactName($fieldName);
        $this->requestPath('/contacts/' . $id);


    }


    /**
     * @Given I request lead by name :path using HTTP GET
     */
    public function requestLeadByName($fieldName)
    {
        $id = $this->getLeadIdByLeadName($fieldName);
        $this->requestPath('/leads/' . $id);

    }

    /**
     * @Given I request opportunity by name :path using HTTP GET
     */
    public function requestOpportunityByName($fieldName)
    {
        $id = $this->getOpportunityIdByOpportunityName($fieldName);
        $this->requestPath('/opportunities/' . $id);

    }


    public function getSmsEmailTemplateIdBySmsTemplateName($arg1)
    {
        $id = 0;

        $config = new \Doctrine\DBAL\Configuration;
        $connectionParams = array(


            'dbname' => $this->parameters['database_name'],
            'user' => $this->parameters['database_user'],
            'password' => $this->parameters['database_password'],
            'host' => $this->parameters['database_host'],
            'driver' => 'pdo_mysql'
        );


        $connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

        $sql = "SELECT id  FROM template where name= '" . $arg1 . "' order by created_at desc limit 1;";


        $data = $connection->fetchAll($sql);
        $id = $data[0]['id'];
        var_dump("id for name sms template: ");
        var_dump($id);
        return $id;


    }

    /**
     * @Given I request sms template by name :path using HTTP GET
     */
    public function requestSmsTemplateByName($fieldName)
    {
        $id = $this->getSmsEmailTemplateIdBySmsTemplateName($fieldName);
        $this->requestPath('/sms_templates/' . $id);

    }

    /**
     * @Given I request email template by name :path using HTTP GET
     */
    public function requestEmailTemplateByName($fieldName)
    {
        $id = $this->getSmsEmailTemplateIdBySmsTemplateName($fieldName);
        $this->requestPath('/email_templates/' . $id);

    }

    /**
     * @Given I request account by name :path using HTTP GET
     */
    public function requestAccountByName($fieldName)
    {
        $id = $this->getAccountIdByAccountName($fieldName);
        $this->requestPath('/accounts/' . $id);

    }


    public function getVehicleIdByModelAndVersion($arg1)
    {
        $id = 0;




        $sql = "select id from vehicle_registry_item where vehicle_id=(SELECT id  FROM vehicle where trim(concat(model,version)) = '" . $arg1 . "' order by created_at desc limit 1);";


        $data = $this->databaseConnection->doQuery($sql);
        $id = $data[0]['id'];


        return $id;


    }


    public function getVehicleRegistryItemIdByVersion($arg1)
    {
        $id = 0;

        $vehicleId = $this->getVehicleIdByVersion($arg1);




        $sql = "SELECT id  FROM vehicle_registry_item where vehicle_id  = '" . $vehicleId . "' order by created_at desc limit 1;";


        $data = $this->databaseConnection->doQuery($sql);
        $id = $data[0]['id'];

        var_dump("ciccio11 getVehicleIdByVersion");
        var_dump($id);
        //   die();

        return $id;


    }


    /**
     * @Given I request vehicle by version :path using HTTP GET
     */
    public function requestVehicleByVersion($fieldName)
    {
        $id = $this->getVehicleIdByVersion($fieldName);
        $this->requestPath('/vehicles/' . $id);

    }

    /**
     * @When I request tasks current-step by subject :path using HTTP GET
     */
    public function requestTaskCurrentStepBySubject($fieldName)
    {
        $id = $this->getTaskIdBySubject($fieldName);
        $this->requestPath('/tasks/' . $id . "/current-step");

    }


    /**
     * @When I request tasks next-step by subject :path using HTTP GET
     */
    public function requestTaskNextStepBySubject($fieldName)
    {
        $id = $this->getTaskIdBySubject($fieldName);
        $this->requestPath('/tasks/' . $id . "/next-step");

    }


    /**
     * @Given I request vehicle_registry_items by version :path using HTTP GET
     */
    public function requestVehicleRegistryByVersion($fieldName)
    {
        $id = $this->getVehicleRegistryItemIdByVersion($fieldName);
        $this->requestPath('/vehicle_registry_items/' . $id);

    }


    /**
     * @Given I insert test fixture base
     */
    public function fixtureBase()
    {



        # Andy Fixture


        $sql1 = "INSERT IGNORE INTO source (id, name) values ('4177bc00-ad45-4d6e-a880-f9f6a2cf7632','TestWebAndy');";
        $sql2 = "INSERT IGNORE INTO source_detail (id, source_id, name, logo_url) values ('55c05fd4-da49-41d3-96aa-38a053634d8e','4177bc00-ad45-4d6e-a880-f9f6a2cf7632','www.testAndy.com','www.testAndy.com');";
        $sql3 = "INSERT IGNORE INTO channel (id, name) values ('55c05fd4-da49-41d3-96aa-38a053634d8f','test channel1Andy');";
            $sql4 = "INSERT IGNORE INTO account (id, account_type_id,name,created_at,updated_at) values ('19794d90-996e-48bc-95eb-3db5c51547fd','private','Andy Fixture1 Account','2019-10-01 13:25:09','2019-10-01 13:25:09');";
        $sql5 = "INSERT IGNORE INTO contact (id, country_code,account_id,first_name,last_name,created_at,updated_at) values ('f1c39dac-4b22-474d-96cf-f3a05cc28e13' ,'IT','19794d90-996e-48bc-95eb-3db5c51547fd','Andy Contact1', 'Fixture','2019-10-01 13:25:09','2019-10-01 13:25:09');";
        $sql6 = "INSERT IGNORE INTO contact_email (id, contact_id,email) values ('0c47cf48-8378-4eb3-ab13-35d34e15f320' ,'f1c39dac-4b22-474d-96cf-f3a05cc28e13','andyfixture.contact1@ew1.eu');";
        $sql7 = "INSERT IGNORE INTO contact_phone (id, contact_id,phone_number) values ('11e52a65-7ca8-48e7-917b-4ddeff3b977b' ,'f1c39dac-4b22-474d-96cf-f3a05cc28e13','328100000');";


        $this->databaseConnection->exec($sql1);
        $this->databaseConnection->exec($sql2);
        $this->databaseConnection->exec($sql3);
        $this->databaseConnection->exec($sql4);
        $this->databaseConnection->exec($sql5);
        $this->databaseConnection->exec($sql6);
        $this->databaseConnection->exec($sql7);

        # Greg Fixture

        $sql1 = "INSERT IGNORE INTO source (id, name) values ('4177bc00-ad45-4d6e-a880-f9f6a2cf7634','TestWebGreg');";
        $sql2 = "INSERT IGNORE INTO source_detail (id, source_id, name, logo_url) values ('55c05fd4-da49-41d3-96aa-38a053634d8a','4177bc00-ad45-4d6e-a880-f9f6a2cf7634','www.testGreg.com','www.testGreg.com');";
        $sql3 = "INSERT IGNORE INTO channel (id, name) values ('55c05fd4-da49-41d3-96aa-38a053634d8a','test channel1Greg');";
        $sql4 = "INSERT IGNORE INTO account (id, account_type_id,name,created_at,updated_at) values ('19794d90-996e-48bc-95eb-3db5c51547fe','private','Greg Fixture1 Account','2019-10-01 13:25:09','2019-10-01 13:25:09');";
        $sql5 = "INSERT IGNORE INTO contact (id, country_code,account_id,first_name,last_name,created_at,updated_at) values ('f1c39dac-4b22-474d-96cf-f3a05cc28e14' ,'IT','19794d90-996e-48bc-95eb-3db5c51547fe','Greg Contact', 'Fixture One','2019-10-01 13:25:09','2019-10-01 13:25:09');";
        $sql6 = "INSERT IGNORE INTO contact_email (id, contact_id,email) values ('0c47cf48-8378-4eb3-ab13-35d34e15f321' ,'f1c39dac-4b22-474d-96cf-f3a05cc28e14','gregfixture1.contact@ew1.eu');";
        $sql7 = "INSERT IGNORE INTO contact_phone (id, contact_id,phone_number) values ('11e52a65-7ca8-48e7-917b-4ddeff3b977c' ,'f1c39dac-4b22-474d-96cf-f3a05cc28e14','328100000');";

        $this->databaseConnection->exec($sql1);
        $this->databaseConnection->exec($sql2);
        $this->databaseConnection->exec($sql3);
        $this->databaseConnection->exec($sql4);
        $this->databaseConnection->exec($sql5);
        $this->databaseConnection->exec($sql6);
        $this->databaseConnection->exec($sql7);

    }


    public function getTaskIdBySubject($arg1)
    {

        $id = "";




        $sql = "SELECT id  FROM task where subject  = '" . $arg1 . "' order by created_at desc limit 1;";


        $data = $this->databaseConnection->doQuery($sql);
        $id = $data[0]['id'];

        return $id;


    }


    public function getRuleIdByName($arg1)
    {

        $id = "";

        $sql = "SELECT id  FROM rule_engine_rule where name  = '" . $arg1 . "' order by created_at desc limit 1;";

        $data = $this->databaseConnection->doQuery($sql);
        $id = $data[0]['id'];

        return $id;


    }


    public function getBusinessUnitIdByName($arg1)
    {

        $id = "";




        $sql = "SELECT id  FROM business_unit where name  = '" . $arg1 . "' limit 1;";


        $data = $this->databaseConnection->doQuery($sql);
        $id = $data[0]['id'];

        return $id;


    }


    /**
     * @Given the rule engine request body for :arg1 is:
     */
    public function theRuleEngineRequestBodyForDemoBUIs($arg1, PyStringNode $string)
    {


        $buId = $this->getBusinessUnitIdByName($arg1);
        $string = str_replace("%demoBUid%", $buId, $string);
        $string = str_replace("%demoBUName%", $arg1, $string);

        $this->setRequestBody($string);


    }


    /**
     * @Given patch the account name :arg1 with payload:
     */
    public function theAccountPatchRequestBodyIs($arg1, PyStringNode $string)
    {


        $id = $this->getAccountIdByAccountName($arg1);
        $string = str_replace("%accountId%", $id, $string);
       $this->setRequestBody($string);
        $this->requestPath("/accounts/". $id);
        $this->setRequestMethod('PATCH');
        $this->sendRequest();

    }

    /**
     * @Given invalidate the lead qualification name :arg1 with payload:
     */
    public function invalidateNameRequestBodyIs($arg1, PyStringNode $string)
    {

        $leadId = $this->getLeadIdByLeadNameAndStatusTask($arg1,'open');
        $taskId = $this->getTaskIdByLeadId($leadId);

        $string = str_replace("%taskId%", $taskId, $string);
        $string = str_replace("%leadId%", $leadId, $string);
        $this->setRequestBody($string);
        $this->requestPath("/lead-qualification/invalidate");
        $this->setRequestMethod('POST');
        $this->sendRequest();

    }

    /**
     * @Given call the lead qualification name :arg1 with payload:
     */
    public function callNameRequestBodyIs($arg1, PyStringNode $string)
    {

        $leadId = $this->getLeadIdByLeadName($arg1);
        $taskId = $this->getTaskIdByLeadId($leadId);

        $string = str_replace("%taskId%", $taskId, $string);
        $string = str_replace("%leadId%", $leadId, $string);
        $this->setRequestBody($string);
        $this->requestPath("/calls");
        $this->setRequestMethod('POST');
        $this->sendRequest();

    }

    /**
     * @Given patch the lead name :arg1 with payload:
     */
    public function patchLeadNameWithPayload($arg1, PyStringNode $string)
    {

        $leadId = $this->getLeadIdByLeadName($arg1);

        $taskId = $this->getTaskIdByLeadId($leadId);


        $contactId = $this->getContactIdByContactName("Andy Contact1 Fixture");


        $emailId =$this->getEmailIdByContactId($contactId);
        $phoneId =$this->getPhoneIdByContactId($contactId);
        $accountId =$this->getAccountIdByAccountName("Andy Fixture1 Account");


        $string = str_replace("%taskId%", $taskId, $string);
        $string = str_replace("%leadId%", $leadId, $string);
        $string = str_replace("%contactId%", $contactId, $string);
        $string = str_replace("%emailId%", $emailId, $string);
        $string = str_replace("%phoneId%", $phoneId, $string);
        $string = str_replace("%accountId%", $accountId, $string);


        $this->setRequestBody($string);
        $this->requestPath("/leads/" . $leadId);
        $this->setRequestMethod('PATCH');
        $this->sendRequest();

    }

    /**
     * @Given patch the status opportunity name :arg1 with payload:
     */
    public function patchStatusOpportunityWithPayload($arg1, PyStringNode $string)
    {

        $opportunityId = $this->getOpportunityIdByOpportunityName($arg1);


        $string = str_replace("%opportunityId%", $opportunityId, $string);

        $this->setRequestBody($string);
        $this->requestPath("/opportunity/" . $opportunityId . "/status");
        $this->setRequestMethod('PATCH');
        $this->sendRequest();

    }


    /**
     * @Given I post opportunity for contact :arg1 with payload:
     */
    public function postOpportunityNameForContactWithPayload($arg1, PyStringNode $string )
    {
        $contactId = $this->getContactIdByContactName($arg1);
        $string = str_replace("%contactId%", $contactId, $string);
        $this->setRequestBody($string);

    }
}
