<?php
include_once dirname ( __FILE__ ) . '/Class.Database.php';

/**
 */
class BzlsHandle {
	private $_DB;
	function __construct($dbusername, $dbpassword, $dbname, $servername, $printerror) {
		$this->_DB = new MySQL ( $dbusername, $dbpassword, $dbname, $servername, true, $printerror );
		$dbpassword = ''; // 将config.php文件中的密码付值为空, 增加安全性
	}
	public static function getOAuth2URL($redirect_uri, $scope = 'snsapi_userinfo') {
		$tmpurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . WX_API_APPID . "&redirect_uri=".urlencode($redirect_uri)."&response_type=code&scope=$scope&state=0#wechat_redirect";
		return $tmpurl;
	}
	public static function getAccossToken($code) {
		$tmpurl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . WX_API_APPID . "&secret=" . WX_API_APPSECRET . "&code=$code&grant_type=authorization_code";
		$json = doCurlGetRequest ( $tmpurl, $arr = array () );
		$data = json_decode ( $json, true );
		if (! $data || $data ['errcode']) {
			return false;
		} else {
			return $data;
		}
	}
	public static function getUserInfoFromToken($data) {
		$tmpurl = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $data ['access_token'] . "&openid=" . $data ['openid'] . "&lang=zh_CN";
		$json = doCurlGetRequest ( $tmpurl, $arr = array () );
		$data = json_decode ( $json, true );
		if (! $data || $data ['errcode']) {
			return false;
		} else {
			return $data;
		}
	}
	public static function checkAccessToken($access_token, $openid) {
		$tmpurl = "https://api.weixin.qq.com/sns/auth?access_token=$access_token&openid=$openid";
		$json = doCurlGetRequest ( $tmpurl, $arr = array () );
		$data = json_decode ( $json, true );
		
		if ($data ['errcode'] == 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 获取GUID
	 */
	public static function create_guid() {
		$charid = strtoupper ( md5 ( uniqid ( mt_rand (), true ) ) );
		$hyphen = chr ( 45 ); // "-"
		                      // $uuid = chr ( 123 ) . // "{"
		                      // substr ( $charid, 0, 8 ) . $hyphen . substr ( $charid, 8, 4 ) . $hyphen . substr ( $charid, 12, 4 ) . $hyphen . substr ( $charid, 16, 4 ) . $hyphen . substr ( $charid, 20, 12 ) . chr ( 125 ); // "}"
		$uuid = substr ( $charid, 0, 8 ) . substr ( $charid, 8, 4 ) . substr ( $charid, 12, 4 ) . substr ( $charid, 16, 4 ) . substr ( $charid, 20, 12 ); // "}"
		
		return $uuid;
	}
	
	// #####################授权表##################################
	/**
	 */
	function findAuthorizationDb($openid) {
		$rs = $this->_DB->getOne ( "SELECT access_token,refresh_token FROM " . TABLE_PREFIX . "authorize WHERE openid = '$openid'" );
		if ($rs == false) {
			return false;
		} else {
			return $rs ['access_token'];
		}
	}
	/**
	 */
	function createAuthorizationDb($data) {
		$openid = $data ['openid'];
		$access_token = $data ['access_token'];
		$refresh_token = $data ['refresh_token'];
		$this->_DB->exe ( "INSERT INTO " . TABLE_PREFIX . "authorize (openid, access_token, refresh_token) VALUES ('$openid', '$access_token', '$refresh_token')" );
		$this->_DB->insert_id ();
	}
	
	/**
	 */
	function updateAuthorizationDn($data) {
		$openid = $data ['openid'];
		$access_token = $data ['access_token'];
		$refresh_token = $data ['refresh_token'];
		$this->_DB->exe ( "UPDATE " . TABLE_PREFIX . "authorize SET access_token = '$access_token' ,refresh_token='$refresh_token' ,lasttime=CURRENT_TIMESTAMP WHERE openid = '$openid'" );
	}
	
	// #####################用户表#############################
	function findUserinfoDb($openid) {
		$rs = $this->_DB->getOne ( "SELECT * FROM " . TABLE_PREFIX . "userinfo WHERE openid = '$openid'" );
		if ($rs == false) {
			return false;
		} else {
			return $rs;
		}
	}
	function createUserinfoDb($userinfo) {
		$openid = $userinfo ['openid'];
		$nickname = $userinfo ['nickname'];
		$sex = $userinfo ['sex'];
		$province = $userinfo ['province'];
		$city = $userinfo ['city'];
		$headimgurl = $userinfo ['headimgurl'];
		$privilege = $userinfo ['privilege'];
		$country = $userinfo ['country'];
		
		$this->_DB->exe ( "INSERT INTO " . TABLE_PREFIX . "userinfo (openid, nickname, sex,province,city,headimgurl,country,privilege) VALUES ('$openid', '$nickname', '$sex','$province','$city','$headimgurl','$country','$privilege')" );
		$this->_DB->insert_id ();
	}
	
	// ###########################助跑表##############################
	function findHelpDb($openid, $aid) {
		$rs = $this->_DB->getOne ( "SELECT aid,openid FROM " . TABLE_PREFIX . "help  WHERE openid = '$openid' AND aid= '$aid'" );
		if ($rs == false) {
			return false;
		} else {
			return $rs;
		}
	}
	function findeHelpListDB($aid) {
		$rs = $this->_DB->getAll ( "SELECT aid,openid,DATE_FORMAT(createtime,'%m-%d %H:%i:%s') As createtime FROM " . TABLE_PREFIX . "help  WHERE aid = '$aid' ORDER BY createtime desc" );
		if ($rs == false) {
			return false;
		} else {
			return $rs;
		}
		// while ( $help = ) {
		// echo $help ['openid'];
		// }
	}
	function createHelpDb($help) {
		$aid = $help ['aid'];
		$openid = $help ['openid'];
		$this->_DB->exe ( "INSERT INTO " . TABLE_PREFIX . "help (aid, openid) VALUES ('$aid', '$openid')" );
		$this->_DB->insert_id ();
	}
	
	// ########################活动表#########################
	function createActivity($activity) {
		$aid = $activity ['aid'];
		$openid = $activity ['openid'];
		$scoreA = $activity ['scoreA'];
		$scoreB = $activity ['scoreB'];
		$scoreC = $activity ['scoreC'];
		$step = $activity ['step'];
		$this->_DB->exe ( "INSERT INTO " . TABLE_PREFIX . "activity (aid, openid,scoreA,scoreB,scoreC,step) VALUES ('$aid', '$openid',$scoreA,$scoreB,$scoreC,$step)" );
		$this->_DB->insert_id ();
	}
	function updateScoreA($aid, $scoreA) {
		$step = 1;
		$this->_DB->exe ( "UPDATE " . TABLE_PREFIX . "activity SET scoreA=$scoreA ,step=$step WHERE aid = '$aid'" );
		$this->_DB->insert_id ();
	}
	function updateScoreB($aid, $scoreB) {
		$step = 1;
		$this->_DB->exe ( "UPDATE " . TABLE_PREFIX . "activity SET scoreB=$scoreB,step=$step  WHERE aid = '$aid'" );
		$this->_DB->insert_id ();
	}
	function updateScoreC($aid, $scoreC) {
		$this->_DB->exe ( "UPDATE " . TABLE_PREFIX . "activity SET scoreC=$scoreC,createtime='". date("Y-m-d H:i:s",time()) ."' WHERE aid = '$aid'" );
		$this->_DB->insert_id ();
	}
	function updateScoreAB($aid, $scoreA, $scoreB) {
		$this->_DB->exe ( "UPDATE " . TABLE_PREFIX . "activity SET scoreA=$scoreA,scoreB=$scoreB,createtime='".date("Y-m-d H:i:s",time())."' WHERE aid = '$aid'" );
		$this->_DB->insert_id ();
	}

	function updateScoreDate($aid) {
		$this->_DB->exe ( "UPDATE " . TABLE_PREFIX . "activity SET createtime='".date("Y-m-d H:i:s",time())."' WHERE aid = '$aid'" );
		$this->_DB->insert_id ();
	}

	function findActivityByAid($aid) {
		$rs = $this->_DB->getOne ( "SELECT * FROM " . TABLE_PREFIX . "activity  WHERE aid = '$aid'" );
		if ($rs == false) {
			return false;
		} else {
			return $rs;
		}
	}
	function findActivityByOpenid($openid) {
		$rs = $this->_DB->getOne ( "SELECT * FROM " . TABLE_PREFIX . "activity  WHERE openid = '$openid'" );
		if ($rs == false) {
			return false;
		} else {
			return $rs;
		}
	}
	// ##############################管理页面#############################//
	function findAdmin($username, $password) {
		$tempsql = "SELECT username FROM " . TABLE_PREFIX . "admin WHERE loginname = '$username' and password='$password'";
		$user = $this->_DB->getOne ( $tempsql );
		if ($user == false) {
			return false;
		} else {
			return $user;
		}
	}
	function updateAdmin($loginname, $newpassword1) {
		$tempsql = "UPDATE " . TABLE_PREFIX . "admin SET password = '$newpassword1' WHERE loginname='$loginname'";
		$this->_DB->exe ( $tempsql );
		return $this->_DB->insert_id;
	}
	function getUserScore() {
		return $this->_DB->getAll ( "select  a.openid,a.nickname,a.sex,a.province,a.city,a.headimgurl,b.createtime,b.scoreA,b.scoreB,b.scoreC,b.step,b.aid
					from " . TABLE_PREFIX . "userinfo a," . TABLE_PREFIX . "activity b where a.openid=b.openid order by b.scoreA desc,b.scoreB asc,b.createtime asc " );
	}
	
	function getUserHelp($aid){
		return $this->_DB->getAll("select a.nickname,a.sex,a.province,a.city,a.headimgurl,b.createtime from bzls_userinfo a,bzls_help b
		where a.openid=b.openid and b.aid='$aid' order by b.createtime desc");
	}
	
	//########################联系方式页面##########################//
	function createContact($data){
			$openid = $data ['openid'];
			$username = $data ['username'];
			$telno = $data ['telno'];
			$contact = $data ['contact'];
			$college = $data ['college'];
			$this->_DB->exe ( "INSERT INTO " . TABLE_PREFIX . "usercontact (openid, username, telno, contact, college) VALUES ('$openid', '$username', '$telno','$contact','$college')" );
			$this->_DB->insert_id ();
		}
	function findContact($openid){
		$rs = $this->_DB->getOne ( "SELECT * FROM " . TABLE_PREFIX . "usercontact  WHERE openid = '$openid'" );
		if ($rs == false) {
			return false;
		} else {
			return $rs;
		}
	}	
	function findContactorderByScore(){
		$rs = $this->_DB->getAll ( "SELECT a.openid, a.nickname, a.sex, a.province, a.city, a.headimgurl, b.scoreA, b.scoreB, b.scoreC, b.step, b.aid,c.username,c.contact,c.telno
FROM bzls_userinfo a, bzls_activity b,bzls_usercontact c
WHERE a.openid = b.openid and c.openid=b.openid
ORDER BY b.scoreA + b.scoreB + b.scoreC DESC " );
		if ($rs == false) {
			return false;
		} else {
			return $rs;
		}
	}

	function getUserScoreLimit20() {
		return $this->_DB->getRow ( "select  a.openid,a.nickname,a.sex,a.province,a.city,a.headimgurl,b.scoreA,b.scoreB,b.scoreC,b.step,b.aid
					from " . TABLE_PREFIX . "userinfo a," . TABLE_PREFIX . "activity b where a.openid=b.openid order by b.scoreA desc limit 20" );
	}
	
	function getImgUrl() {
		return $this->_DB->getAll ( "select * from " . TABLE_PREFIX . "imgurl order by no asc " );
	}
	
	function updImgUrl($id, $no, $url) {
		$this->_DB->exe ( "UPDATE " . TABLE_PREFIX . "imgurl set no = '".$no."',url = '".$rul."'  where id = '".$id."' " );
		$this->_DB->insert_id ();
	}
	
	function instImgUrl($no, $url) {
		$this->_DB->exe ( "INSERT INTO " . TABLE_PREFIX . "imgurl (no, url) VALUES ('$id', '$url')" );
		$this->_DB->insert_id ();
	}
}

?>