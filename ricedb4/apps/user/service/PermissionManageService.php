<?php

namespace apps\user\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\user\interfaces\IPermissionManageService;
use apps\common\entity;
use th\co\bpg\cde\collection\impl\CJSONDecodeImpl;

class PermissionManageService extends CServiceBase implements IPermissionManageService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function lists() {
        $permission = new entity\Permission();
        return $this->datacontext->getObject($permission);
    }

    public function save($permission) {
        $json = new CJSONDecodeImpl();
       // $permission = $json->decode(new entity\Permission(), $permission);
        $data = $this->datacontext->getObject(new entity\Permission());
        if (count($data) > 0) {
            if (!$this->datacontext->removeObject($data)) {
                return $this->datacontext->getLastMessage();
            }
        }
        if (!$this->datacontext->saveObject($permission)) {
            return $this->datacontext->getLastMessage();
        }
        return true;
    }

}

?>