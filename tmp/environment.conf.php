<?php
if (!defined('ENVIRONMENT')) define('ENVIRONMENT', 'dev');


 define('apiEntryPoint', "https://pasteurian-visitors.000webhostapp.com/sibilla/api/post.php");
if (!defined('apiEntryPoint')) define('apiEntryPoint', 'http://localhost/sibilla/api/post.php');
//  define('apiEntryPoint', "http://localhost/sibilla/api/post.php");



define('username', "id12397138_root");
define('password', "rootroot");
define('host', "localhost");
define('database', "id12397138_my_andreamatera");

if (!defined('username')) define('username', 'root');
if (!defined('password')) define('password', 'root');
if (!defined('host')) define('host', 'db');
if (!defined('database')) define('database', 'my_andreamatera');
if (!defined('loginAction')) define('loginAction', 'value');
if (!defined('logAction')) define('logAction', false);
