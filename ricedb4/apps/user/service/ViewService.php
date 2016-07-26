<?php

namespace apps\user\service;

use apps\user\interfaces\IViewService;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use th\co\bpg\cde\core\impl\CServiceLoaderImpl;

class ViewService extends CServiceBase implements IViewService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    public function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }

    public function userManage() {
        $view = new CJView("userManage", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function permissionManage() {
        $view = new CJView("permissionManage", CJViewType::HTML_VIEW_ENGINE);

        $userServ = new UserManageService();
        $view->role = $userServ->listsRole();
        $view->countRole = count($view->role) + 1;
        $view->permissions = $this->render();
        //return $this->render();
        return $view;
    }

    public function render() {
        $loader = new CServiceLoaderImpl();
        $apps = scandir("apps"); //array("auction","industry");
        $list_apps = [];
        $k = 0;
        $list_apps_keys = [];
        $role = bindec($this->createBy = \th\co\bpg\cde\core\impl\ChangdaoEngineImpl::$_CURRENT_USER->resources[0]);
        foreach ($apps as $i => $value) {
            if ($value !== "." && $value !== "..") {
                $app_load = $loader->load($value);
                $kk = $app_load->title;
                $list_apps[$kk] = $app_load;

                $rts = $list_apps[$kk]->routeTables;
                $list_apps[$kk]->sitemaps = false;
                $srts = [];

                $dataPermis = $this->datacontext->getObject(new \apps\common\entity\Permission());
                $userServ = new UserManageService();
                $dataRole = $userServ->listsRole();
                foreach ($rts as $i => $rt) {
                    if ($rt->sitemap == true) {
                        $xx = $rt->operationDesc;
                        for ($i = 0; $i < 8; $i++) {
                            $listsPer[$i] = array(
                                "checked" => "",
                                "role" => $dataRole[$i]['permission']
                            );
                        }
                        $rt->permission = $listsPer;
                        foreach ($dataPermis as $key => $value) {
                            if ($rt->service . '\\' . $rt->operationName == $value->resourceCode) {
                                $listsPer = [];
                                for ($i = 0; $i < strlen($value->permission); $i++) {
                                    if (substr($value->permission, $i, 1) == "1") {
                                        $listsPer[$i] = array(
                                            "checked" => "checked",
                                            "role" => $dataRole[$i]['permission']
                                        );
                                    } else {
                                        $listsPer[$i] = array(
                                            "checked" => "",
                                            "role" => $dataRole[$i]['permission']
                                        );
                                    }
                                }
                                $rt->permission = $listsPer;
                            }
                        }
                        $srts[$xx] = $rt;
                        $list_apps[$kk]->sitemaps = true;
                    }
                }
                ksort($srts);
                $list_apps[$kk]->routeTables = [];
                foreach ($srts as $i => $rt) {
//                    if (substr($rt->operationDesc, 0, 2) == ' M') {
//                        $rt->operationDesc = substr($rt->operationDesc, 5);
//                    } else {
//                        $rt->operationDesc = substr($rt->operationDesc, 1);
//                    }
//                    if (substr($rt->serviceDesc, 0, 2) == ' M') {
//                        $rt->serviceDesc = substr($rt->serviceDesc, 5);
//                    } else {
//                        $rt->serviceDesc = substr($rt->serviceDesc, 1);
//                    }
                    $list_apps[$kk]->routeTables[] = $rt;
                }
                $k++;
                //}
            }
        }
        ksort($list_apps);
        $list_apps_sort = [];
        foreach ($list_apps as $i => $a) {
//            if (substr($a->title, 0, 1) == 'M') {
//                $a->title = substr($a->title, 4);
//            }
            $list_apps_sort[] = $a;
        }

        $datax = [];
        $datax["apps"] = $list_apps_sort;

        return $datax["apps"];
    }

    public function profile() {
        $view = new CJView("profile", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

}
