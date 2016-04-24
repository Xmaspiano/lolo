<?php

$servername  = 'localhost';
$dbname      = 'lolo';
$dbusername  = 'root';
$dbpassword  = '';//'e790f1e1a8';//'china987456isv';
$printerror  =  true;

define('TABLE_PREFIX', 'lolo_');
define('WX_API_APPID', "wx4926b4f78a063692");
define('WX_API_APPSECRET', "d0e3f0247e772da6d8f36a902a5f515d");
define('BZLS_WEBSIT_URL','http://www.raymine.com/hdbxs'); //设定活动网站地址

define('BZLS_ACTIVE_LIMITED_DATE','2016-01-25');//设定活动截至日期凌晨0点0分
define('BZLS_HELP_SCORE', 20); //每次助跑分数设定
define('SHOW_DATA_ROWS', 20);//查询多少名排名
define('WEB_GAME_TITLE', "答题游戏");//游戏页面标题
define('BDHD', true);
define('BASEPATH', dirname(dirname(__FILE__)).'/');
define('WEIXI_COOKIE_ID', "answersecvrnty");
define("SCOPE_BASE", "snsapi_base");
define("SCOPE_USERINFO", "snsapi_userinfo");
define("DEBUG", "DEBUG");
define("INFO", "INFO");
define("ERROR", "ERROR");
define("STAT", "STAT");


?>