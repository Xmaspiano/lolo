<?php

// +---------------------------------------------+
// |     Copyright  2014 - 2028 BDHD  YXX        |
// |     http://www.wisco.com.cn                 |
// |     This file may not be redistributed.     |
// +---------------------------------------------+


// error_reporting(E_ALL & ~E_NOTICE);

@include('./config/config.php');
include(BASEPATH . 'includes/BaseUrl.php');
//include(BASEPATH . 'includes/Class.Database.php');
include(BASEPATH . 'includes/Functions.php');
include(BASEPATH . 'includes/MiniLog.php');
include(BASEPATH . 'includes/ErrorCode.php');
include(BASEPATH . 'includes/BzlsHandle.php');
$BzlsHandle=new BzlsHandle($dbusername, $dbpassword, $dbname, $servername, $printerror);

?>