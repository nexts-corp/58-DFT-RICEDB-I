<?php

namespace apps\user\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\user\interfaces\IUserManageService;

class UserManageService extends CServiceBase implements IUserManageService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function listsUser() {
        $sql = "SELECT"
                . " ur.id, ur.name, ur.surname, ur.username, rl.role,"
                . " dp.department, ur.email, ur.telephone, ur.address,ur.isActive "
                . " FROM " . $this->ent . "\\User ur"
                . " JOIN " . $this->ent . "\\Role rl WITH rl.code = ur.roleCode"
                . " JOIN " . $this->ent . "\\Department dp WITH dp.id = ur.departmentId";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsRole() {
        $sql = "SELECT"
                . " rl.id, rl.role, rl.code,rl.permission "
                . " FROM " . $this->ent . "\\Role rl "
                . " Order by rl.permission desc";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function listsDepartment() {
        $sql = "SELECT"
                . " dp.id, dp.department"
                . " FROM " . $this->ent . "\\Department dp";
        $data = $this->datacontext->getObject($sql);

        return $data;
    }

    public function insert($user) {
        $return = true;

        $chk_user = new \apps\common\entity\User();
        $chk_user->username = $user->username;
        $count_user = $this->datacontext->getObject($chk_user);
        if (count($count_user) == 0) {
            $chk_name = new \apps\common\entity\User();
            $chk_name->name = $user->name;
            $chk_name->surname = $user->surname;
            $count_name = $this->datacontext->getObject($chk_name);
            if (count($count_user) == 0) {
                if (!$this->datacontext->saveObject($user)) {
                    $return = $this->datacontext->getLastMessage();
                }
            } else {
                $return = "ชื่อกับนามสกุลนี้ถูกใช้แล้ว";
            }
        } else {
            $return = "ชื่อผู้ใช้งานนี้ถูกใช้แล้ว";
        }
        return $return;
    }

    public function update($user) {
        $return = true;

        $info = new \apps\common\entity\User();
        $info->id = $user->id;
        $dataInfo = $this->datacontext->getObject($info);
        $dataInfo[0]->name = $user->name;
        $dataInfo[0]->surname = $user->surname;
        $dataInfo[0]->roleCode = $user->roleCode;
        $dataInfo[0]->departmentId = $user->departmentId;
        $dataInfo[0]->email = $user->email;
        $dataInfo[0]->telephone = $user->telephone;
        $dataInfo[0]->address = $user->address;
        $dataInfo[0]->isActive = $user->isActive;
        if ($user->username) {
            $checkuser = new \apps\common\entity\User();
            $checkuser->username = $user->username;
            $dataCheck = $this->datacontext->getObject($checkuser);
            if (count($dataCheck) > 0) {
                $return = "ชื่อผู้ใช้งานนี้ถูกใช้แล้ว";
            } else {
                $dataInfo[0]->username = $user->username;
            }
        }

        if ($user->name || $user->surname) {
            $chk_name = new \apps\common\entity\User();
            $chk_name->name = $user->name;
            $chk_name->surname = $user->surname;
            $count_name = $this->datacontext->getObject($chk_name);
            if (count($count_name) > 0) {
                $return = "ชื่อกับนามสกุลนี้ถูกใช้แล้ว";
            } else {
                $dataInfo[0]->name = $user->name;
                $dataInfo[0]->surname = $user->surname;
            }
        }

        if ($user->password) {
            $dataInfo[0]->password = $user->password;
        }
        if ($return) {
            if (!$this->datacontext->updateObject($dataInfo[0])) {
                $return = $this->datacontext->getLastMessage();
            }
        }
        return $return;
    }

    public function delete($user) {
        $return = true;

        $info = new \apps\common\entity\User();
        $info->id = $user->id;
        $dataInfo = $this->datacontext->getObject($info);
        if (!$this->datacontext->removeObject($dataInfo)) {
            $return = $this->datacontext->getLastMessage();
        }
        return $return;
    }

}

?>