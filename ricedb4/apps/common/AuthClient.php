<?php

namespace apps\common;

use \th\co\bpg\cde\core\COAuthClient;
use Firebase\JWT\JWT;

//use th\co\bpg\cde\data\CDataContext;

class AuthClient extends COAuthClient {

    //public $datacontext;
    /* public function __construct($params) {
      parent::__construct($params);
      if(isset($_COOKIE['token'])){
      $this->token= $_COOKIE['token'];
      }
      }

      public function authorization() {
      return parent::authorization();
      }

      public function authenticate(){
      $token=parent::authenticate();
      if($token){
      setcookie("token", $token,0, "/");
      return true;
      }
      return false;
      } */

    protected $token;
    protected $params;

    public function __construct($params) {
        $this->params = $params;
        if (isset($_COOKIE['token'])) {
            $this->token = $_COOKIE['token'];
        }
        //echo \th\co\bpg\cde\core\impl\ChangdaoEngineImpl::$_CURRENT_APP_ID;
        //$this->datacontext = new CDataContext(NULL);
        //$this->datacontext=\th\co\bpg\cde\core\impl\ChangdaoEngineImpl::$_CURRENT_DB["default"];
        // $this->datacontext = new CDataContext(NULL);
    }

    public function authenticatexxx() {
        //echo "xxxxxx";
        $key = $this->params["OAUTH2_ACCESS_KEY"];
        $code = null;
        if (!$code && isset($_GET[$key])) {
            $code = $_GET[$key];
        }
        // echo $code;
        if ($code) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->params['OAUTH2_TOKEN_URI']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->params["OAUTH2_ACCESS_KEY"] . "=" . $code);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //echo "xxxxxxxxxx";
            echo $this->params['OAUTH2_TOKEN_URI'];
            $server_output = curl_exec($ch);
            echo $server_output;
            $this->token = $server_output;
            curl_close($ch);

            if ($this->token) {
                setcookie("token", $this->token, 0, "/");
                return true;
            }
            return true;
        } else {
            $this->authorization();
            return false;
        }
    }

    public function authenticate() {
        //  $this->logger->info("authenticate.....");
        //\th\co\bpg\cde\core\impl\ChangdaoEngineImpl::$_CURRENT_APP_ID="oauth";
        $key = $this->params["OAUTH2_ACCESS_KEY"];
        $code = null;
        if (!$code && isset($_GET[$key])) {
            $code = $_GET[$key];
        }
        if ($code) {
            $euid = $code; // $this->getRequest()->code;
            $uid = base64_decode($euid);

            $uidd = (array) JWT::decode($uid, "123456", array('HS256'));

            $check = new \apps\common\entity\User();
            $check->id = $uidd['uid'];
            $check->name = $uidd['name'];
            $check->code = $uidd['code'];
            $check->role = $uidd['role'];
            $check->domain = $uidd['domain'];
            $check->resources = $uidd['resources'];

            //$user = $this->datacontext->getObject($check);
            //if (count($user) > 0) {
            //$role = new \apps\common\entity\Role();
            //$role->code = $user[0]->roleCode;
            //$xrole = $this->datacontext->getObject($role);
//
            $acc = new \th\co\bpg\cde\collection\CJAccount();
            $acc->code = $check->code;
            $acc->name = $check->name;
            $acc->role = $check->role;
            $acc->domain = $check->domain;
            $acc->resources = array();
            $acc->resources[] = $check->resources;

            $uinfo = JWT::encode($acc, "123456");
            $uinfo = base64_encode($uinfo);
            // return $uinfo;
            $this->token = $uinfo;
            // exit();
            if ($this->token) {
                setcookie("token", $this->token, 0, "/");
                return true;
            }
            return true;
            //}else {
            //	$this->authorization();
            //return false;
            //}
        } else {
            $this->authorization();
            return false;
        }
    }

    public function authorization() {
        $p = array(
            "OAUTH2_CALLBACK_URL" => $this->params["OAUTH2_CALLBACK_URL"]
        );
        $data = JWT::encode($p, $this->params["OAUTH2_CLIENT_SECRET"]);
        $data = base64_encode($this->params["OAUTH2_CLIENT_ID"] . "|" . $data);
        $authUrl = $this->params["OAUTH2_AUTH_URL"] . "?" . $this->params["OAUTH2_ACCESS_KEY"] . "=" . $data;
        header('Location: ' . $authUrl);
        if ($this->params['WITH_AJAX_CALL']) {
            http_response_code("401");
        }
        exit();
    }

    public function getAccessToken() {

        return $this->token;
    }

    public function getUserInfo() {
        // $logger = \Logger::getLogger("root");
        // $logger->info($this->token);
        // $logger->info($this->params["OAUTH2_CLIENT_SECRET"]);
        // $data = base64_decode($this->token);
        //echo 
        $data = base64_decode($this->token);
        $acc = JWT::decode($data, $this->params["OAUTH2_CLIENT_SECRET"], array('HS256'));
        //return $this->
        // $acc = new \th\co\bpg\cde\collection\CJAccount();
        // $acc->code = "xxx";
        //    print_r($acc);
        setcookie("userinfo", $acc->name, 0, "/");
        setcookie("username", $acc->code, 0, "/");
        return $acc;
    }

}
