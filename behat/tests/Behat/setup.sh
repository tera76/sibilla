# set exec permission to this file and run it inside the php api container



composer require behat/behat:dev-master behat/mink:dev-master behat/mink-extension:dev-master --dev

composer require --dev sensiolabs/behat-page-object-extension:^2.0

composer require imbo/behat-api-extension --dev

composer require behat/mink-selenium2-driver

composer require --dev phpunit/phpunit

composer require emuse/behat-html-formatter twig/twig:~1.0 --dev
