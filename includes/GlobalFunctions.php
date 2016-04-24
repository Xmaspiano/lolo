<?php

// +---------------------------------------------+
// |     Copyright  2014 - 2028 BDHD  YXX        |
// |     http://www.wisco.com.cn                 |
// |     This file may not be redistributed.     |
// +---------------------------------------------+

if(!defined('BDHD')) die('File not found!');

// #####################

function DisplayDate($timestamp = 0, $dateformat = '', $time = 0){
	global $_CFG;

	if(!$dateformat){
		$dateformat = $_CFG['cDateFormat'] . Iif($time, ' H:i:s');
	}

	$timezoneoffset = ForceInt($_CFG['cTimezone']);

	return @gmdate($dateformat, Iif($timestamp, $timestamp, time()) + (3600 * $timezoneoffset));
}

// #####################

function DisplayTime($timestamp = 0, $timeformat = 'H:i:s'){
	global $_CFG;

	$timezoneoffset = ForceInt($_CFG['cTimezone']);

	return @gmdate($timeformat, Iif($timestamp, $timestamp, time()) + (3600 * $timezoneoffset));
}

// #####################

function Iif($expression, $returntrue, $returnfalse = ''){
	if($expression){
		return $returntrue;
	}else{
		return $returnfalse;
	}
}

// #####################

function SafeSql($source){
	$entities_match = array(',',';','$','!','@','#','%','^','&','*','_','(',')','{','}','|',':','"','<','>','?','[',']','\\',"'",'.','/','*','+','~','`','=');
	return str_replace($entities_match, '', trim($source));
}

// #####################

function SafeSearchSql($source){
	$entities_match = array('$','!','@','#','%','^','&','*','_','(',')','{','}','|',':','"','<','>','?','[',']','\\',"'",'.','/','*','~','`','=');
	return str_replace($entities_match, '', trim($source));
}


// #####################

function IsEmail($email){
	return preg_match("/^[a-z0-9]+[.a-z0-9_-]*@[a-z0-9]+[.a-z0-9_-]*\.[a-z0-9]+$/i", $email);
}

// #####################

function IsName($name){
	$entities_match = array(',',';','$','!','@','#','%','^','&','*','(',')','{','}','|',':','"','<','>','?','[',']','\\',"'",'/','*','+','~','`','=');
	for ($i = 0; $i<count($entities_match); $i++) {
	     if(strpos($name, $entities_match[$i])){
               return false;
		 }
	}
   return true;
}

// #####################

function IsPass($pass){
   return preg_match("/^[[:alnum:]]+$/i", $pass);
}

// #####################

function PassGen($length = 8){
	$str = 'abcdefghijkmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	for ($i = 0, $passwd = ''; $i < $length; $i++)
		$passwd .= substr($str, mt_rand(0, strlen($str) - 1), 1);
	return $passwd;
}

// #####################

function IsGet($VariableName) {
	if (isset($_GET[$VariableName])) {
		return true;
	} else {
		return false;
	}

}

// #####################

function IsPost($VariableName) {
	if (isset($_POST[$VariableName])) {
		return true;
	} else {
		return false;
	}

}

// #####################

function ForceIncomingString($VariableName, $DefaultValue = '') {
	if (isset($_GET[$VariableName])) {
		return ForceString($_GET[$VariableName], $DefaultValue);
	} elseif (isset($_POST[$VariableName])) {
		return ForceString($_POST[$VariableName], $DefaultValue);
	} else {
		return $DefaultValue;
	}
}

// #####################

function ForceIncomingInt($VariableName, $DefaultValue = 0) {
	if (isset($_GET[$VariableName])) {
		return ForceInt($_GET[$VariableName], $DefaultValue);
	} elseif (isset($_POST[$VariableName])) {
		return ForceInt($_POST[$VariableName], $DefaultValue);
	} else {
		return $DefaultValue;
	}
}

// #####################

function ForceIncomingFloat($VariableName, $DefaultValue = 0) {
	if (isset($_GET[$VariableName])) {
		return doubleval($_GET[$VariableName]);
	} elseif (isset($_POST[$VariableName])) {
		return doubleval($_POST[$VariableName]);
	} else {
		return $DefaultValue;
	}
}

// #####################

function ForceIncomingCookie($VariableName, $DefaultValue = '') {
	if (isset($_COOKIE[$VariableName])) {
		return ForceString($_COOKIE[$VariableName], $DefaultValue);
	} else {
		return $DefaultValue;
	}
}

// #####################

function EscapeSql($query_string) {

	if (get_magic_quotes_gpc()) {
		$query_string = stripslashes($query_string);
	}

	$query_string = htmlspecialchars(str_replace (array('\0', '　'), '', $query_string), ENT_QUOTES);
	
	if(function_exists('mysql_real_escape_string')) {
		$query_string = mysql_real_escape_string($query_string);
	}else if(function_exists('mysql_escape_string')){
		$query_string = mysql_escape_string($query_string);
	}else{
		$query_string = addslashes($query_string);
	}

	return $query_string;
}

// #####################

function html($String) {
	 return str_replace(array('&amp;','&#039;','&quot;','&lt;','&gt;'), array('&','\'','"','<','>'), $String);
}

// #####################

function ForceInt($InValue, $DefaultValue = 0) {
	$iReturn = intval($InValue);
	return ($iReturn == 0) ? $DefaultValue : $iReturn;
}

// #####################

function ForceString($InValue, $DefaultValue = '') {
	if (is_string($InValue)) {
		$sReturn = EscapeSql(trim($InValue));
		if (empty($sReturn) && strlen($sReturn) == 0) $sReturn = $DefaultValue;
	} else {
		$sReturn = EscapeSql($DefaultValue);
	}
	return $sReturn;
}

// #####################
function GetIP() {
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$thisip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$thisip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$thisip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$thisip = $_SERVER['REMOTE_ADDR'];
	}

	preg_match("/[\d\.]{7,15}/", $thisip, $thisips);
	$thisip = $thisips[0] ? $thisips[0] : 'unknown';
	return $thisip;
}

// #####################

function header_nocache() {
	header("Expires: Mon, 18 Jul 1988 01:08:08 GMT"); // Date in the past
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache"); // HTTP/1.0
}

// #####################

function header_utf8() {
	header("Content-type: text/html; charset=UTF-8");
}
// ###############获取访问IP
function getRealIp()
{
	if (isset($_SERVER)){
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
			$realip = $_SERVER["HTTP_CLIENT_IP"];
		} else {
			$realip = $_SERVER["REMOTE_ADDR"];
		}
	} else {
		if (getenv("HTTP_X_FORWARDED_FOR")){
			$realip = getenv("HTTP_X_FORWARDED_FOR");
		} else if (getenv("HTTP_CLIENT_IP")) {
			$realip = getenv("HTTP_CLIENT_IP");
		} else {
			$realip = getenv("REMOTE_ADDR");
		}
	}
	preg_match("/[\d\.]{7,15}/", $realip, $thisips);
	$realip = $thisips[0] ? $thisips[0] : 'unknown';
	return $realip;
}

//######### 获取时间
function getCurrentTime() 
{   
	date_default_timezone_set('PRC');
	$secondTime = time();
	return date('Y-m-d H:i:s', $secondTime);	
}




/**
 * @desc 封装curl的调用接口，post的请求方式
 */
function doCurlPostRequest($url, $requestString, $timeout = 5) {   
	if($url == "" || $requestString == "" || $timeout <= 0){
		return false;
	}

    $con = curl_init((string)$url);
    curl_setopt($con, CURLOPT_HEADER, false);
    curl_setopt($con, CURLOPT_POSTFIELDS, $requestString);
    curl_setopt($con, CURLOPT_POST, true);
    curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);

    return curl_exec($con);
}  

/**
 * @desc 封装curl的调用接口，get的请求方式
 */
function doCurlGetRequest($url, $data = array(), $timeout = 10) {
	if($url == "" || $timeout <= 0){
		return false;
	}
	if($data != array()) {
		$url = $url . '?' . http_build_query($data);	
	}
	$con = curl_init((string)$url);
	curl_setopt($con, CURLOPT_HEADER, false);
	curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);

	return curl_exec($con);
}

// #####################

function CreateVVC() {
	global $DB;

	$DB->exe("INSERT INTO " . TABLE_PREFIX . "vvc VALUES (NULL, '', '".time()."')");

	return $DB->insert_id();
}

// ##################### 以下未用

function CheckVVC($vvcid, $code) {
	global $DB;

	if(!$code){return false;}

	if(is_numeric($vvcid)){
		$verifycode = $DB->getOne("SELECT code FROM " . TABLE_PREFIX . "vvc WHERE vvcid = '$vvcid'");

		if($verifycode['code'] == strtoupper($code)){
			$DB->exe("DELETE FROM " . TABLE_PREFIX . "vvc WHERE vvcid = '$vvcid'");
			return true;
		}
	}
	return false;
}

// #####################
function storeCache(){
	global $DB;

	$folder = BASEPATH . "cache/";
	@chmod($folder, 0777);

	if(!is_writeable($folder)) {
		return false;
	}

	$filename = $folder . "online_cache.php";

	$getsupporters = $DB->query("SELECT ug.usergroupid, ug.groupname, ug.groupename, ug.description, ug.descriptionen, u.type, u.userid, u.username, u.isonline, u.userfrontname, u.userfrontename FROM " . TABLE_PREFIX . "usergroup ug INNER JOIN " . TABLE_PREFIX . "user u ON ug.usergroupid = u.usergroupid WHERE  ug.usergroupid <>1 AND ug.activated = 1 AND u.activated = 1 ORDER BY ug.displayorder ASC, u.displayorder ASC");

    $arr = array();

	while($row=$DB->fetch($getsupporters)){
		$arr[$row['usergroupid']]['groupname']   = $row['groupname'];
		$arr[$row['usergroupid']]['groupename']   = $row['groupename'];
		$arr[$row['usergroupid']]['description']   = $row['description'];
		$arr[$row['usergroupid']]['descriptionen']   = $row['descriptionen'];
		$arr[$row['usergroupid']]['user'][$row['userid']]['username']  = $row['username'];
		$arr[$row['usergroupid']]['user'][$row['userid']]['type']  = $row['type'];
		$arr[$row['usergroupid']]['user'][$row['userid']]['isonline']  = $row['isonline'];
		$arr[$row['usergroupid']]['user'][$row['userid']]['isbusy']  = '0';
		$arr[$row['usergroupid']]['user'][$row['userid']]['userfrontname']  = $row['userfrontname'];
		$arr[$row['usergroupid']]['user'][$row['userid']]['userfrontename']  = $row['userfrontename'];
	}

	$online_cache = "<?php
if(!defined('WELIVE')) die('File not found!');

\$welive_onlines  = " . var_export($arr, true) . ";

?>";


	$fp = @fopen($filename, 'rb');
	$contents = @fread($fp, filesize($filename));
	@fclose($fp);
	$contents =  trim($contents);

	if($contents != $online_cache){
		$fp = @fopen($filename, 'wb');
		@fwrite($fp, $online_cache);
		@fclose($fp);
	}

	return Iif(empty($arr), true, $arr);
}

// #####################
function refreshCache($userid, $item, $new_value = '0'){
	$filename = BASEPATH . "cache/online_cache.php";

	if(file_exists($filename)){
		include($filename);

		foreach($welive_onlines AS $key => $value){
			if(array_key_exists($userid, $value['user'])){
				$welive_onlines[$key]['user'][$userid][$item] = $new_value;
				if($item == 'isonline'){
					$welive_onlines[$key]['user'][$userid]['isbusy'] = '0'; //更改了在线状态时, 重置忙碌状态为不忙
				}

				$online_cache = "<?php
if(!defined('WELIVE')) die('File not found!');

\$welive_onlines  = " . var_export($welive_onlines, true) . ";

?>";
				$fp = @fopen($filename, 'wb');
				@fwrite($fp, $online_cache);
				@fclose($fp);
			}
		}
	}else{
		storeCache(); //文件不存在时创建缓存
	}
}

// #####################
function checkbusy($userid){
	$filename = BASEPATH . "cache/online_cache.php";
	$groupid = 0;

	include($filename);

	//查询当前客服的用户组ID
	foreach($welive_onlines AS $key => $value){
		if(array_key_exists($userid, $value['user'])){
			if(!$value['user'][$userid]['isbusy']) return 0; //当前客服不忙
			$groupid = $key;
			break;
		}
	}

	$groupusers = $welive_onlines[$groupid]['user'];

	//查询当前用户组不忙客服的ID
	foreach($groupusers AS $key => $value){
		if($key != $userid && $value['isonline'] && !$value['isbusy']){
			return $key;  //返回一个在线且不忙的客服的ID
		}
	}

	return 0; //未找到不忙客服
}


/*
 * 默认打开所有的日志文件文件
 * ERROR,INFO,DEBUG日志级别分别对应的关闭标记文件为：NO_ERROR, NO_INFO, NO_DEBUG
 */
function isLogLevelOff($logLevel)
{
	$swithFile = BASEPATH . 'logs/' . 'NO_' . $logLevel;
	if (file_exists($swithFile)){
		return true;
	}else {
		return false;
	}
}


/**
 * @author pacozhong
 * 日志函数的入口
 * @param string $confName 日志配置名
 * @param string $logLevel 级别
 * @param int $errorCode 错误码
 * @param string $logMessage 日志内容
 */
function ccdb_log($confName ,$logLevel, $errorCode, $logMessage = "no error msg")
{
	if (isLogLevelOff($logLevel)){
		return;
	}
	
	$st = debug_backtrace();

	$function = ''; //调用interface_log的函数名
	$file = '';     //调用interface_log的文件名
	$line = '';     //调用interface_log的行号
	foreach($st as $item) {
		if($file) {
			$function = $item['function'];
			break;
		}
		if($item['function'] == 'gourd_log') {
			$file = $item['file'];
			$line = $item['line'];
		}
	}
	
	$function = $function ? $function : 'main';
	
	//为了缩短日志的输出，file只取最后一截文件名
	$file = explode("/", rtrim($file, '/'));
	$file = $file[count($file)-1];
	$prefix = "[$file][$function][$line][$logLevel][$errorCode] ";
	if($logLevel == INFO || $logLevel == STAT) {
		$prefix = "[$logLevel]" ;
	}
	$logMessage = genErrMsg($errorCode , $logMessage);
	$logFileName = $confName . "_" . strtolower($logLevel);
	MiniLog::instance(BASEPATH . "logs/")->log($logFileName, $prefix . $logMessage);
	if (isLogLevelOff("DEBUG") || $logLevel == "DEBUG"){
		return ;
	}else {
		MiniLog::instance(BASEPATH . "logs/")->log($confName . "_" . "debug", $prefix . $logMessage);
	}
}

/**
 * @author pacozhong
 * 接口层日志函数
 */
function gourd_log($logLevel, $errorCode, $logMessage = "no error msg")
{
	ccdb_log('gourd', $logLevel, $errorCode, $logMessage);
}



?>