<?php

namespace apps\user\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\user\interfaces\IProfileService;

class ProfileService extends CServiceBase implements IProfileService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function get($username) {
        $sql = "SELECT"
                . " ur.id, ur.name, ur.surname, ur.username, rl.role,"
                . " dp.department, ur.email, ur.telephone, ur.address,ur.isActive "
                . " FROM " . $this->ent . "\\User ur"
                . " JOIN " . $this->ent . "\\Role rl WITH rl.code = ur.roleCode"
                . " JOIN " . $this->ent . "\\Department dp WITH dp.id = ur.departmentId"
                . " WHERE ur.username = :username ";
        $param = array("username" => $username);
        return $this->datacontext->getObject($sql, $param)[0];
    }

    public function update($user) {
        $return = true;

        $info = new \apps\common\entity\User();
        $info->id = $user->id;
        $dataInfo = $this->datacontext->getObject($info);
//        $dataInfo[0]->name = $user->name;
//        $dataInfo[0]->surname = $user->surname;
        //$dataInfo[0]->roleCode = $user->roleCode;
        //$dataInfo[0]->departmentId = $user->departmentId;
//        $dataInfo[0]->email = $user->email;
//        $dataInfo[0]->telephone = $user->telephone;
//        $dataInfo[0]->address = $user->address;
        //$dataInfo[0]->isActive = $user->isActive;
//        if ($user->username) {
//            $checkuser = new \apps\common\entity\User();
//            $checkuser->username = $user->username;
//            $dataCheck = $this->datacontext->getObject($checkuser);
//            if (count($dataCheck) > 0) {
//                $return = false;
//            } else {
//                $dataInfo[0]->username = $user->username;
//            }
//        }
        if ($user->password) {
            $dataInfo[0]->password = $user->password;
        }
        if ($return) {
            if (!$this->datacontext->updateObject($dataInfo[0])) {
                $return = $this->datacontext->getLastMessage();
            }
        }
//        else {
//            $return = "Username นี้มีผู้ใช้งานแล้ว";
//        }

        return $return;
    }

}

?>