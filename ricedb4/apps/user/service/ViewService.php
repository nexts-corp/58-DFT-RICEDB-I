<?php

namespace apps\user\service;

use apps\user\interfaces\IViewService;
use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use th\co\bpg\cde\core\impl\CServiceLoaderImpl;
use th\co\bpg\cde\collection\impl\CViewLoader;

class ViewService extends CServiceBase implements IViewService {

    public function userManager() {
        $view = new CJView("userManager", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function roleManager() {
        $view = new CJView("roleManager", CJViewType::HTML_VIEW_ENGINE);

        $userServ = new UserManagerService();
        $view->role = $userServ->listsRole();
        $view->countRole = count($view->role)+1;
        $view->permission = $this->render();
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
//              // print_r($app_load->getConfig("Sitemap"));
               // print_r($app_load);
                //if (substr($app_load->title, 0, 1) == 'M') {
                    $kk = $app_load->title;
                    $list_apps[$kk] = $app_load;

                    $rts = $list_apps[$kk]->routeTables;
                    $list_apps[$kk]->sitemaps = false;
                    $srts = [];
                    foreach ($rts as $i => $rt) {
                        if ($rt->sitemap == true) {
                        //    if ($rt->resource != null && $rt->resource != "*") {
                           //     $permin = bindec($rt->resource);
                          //      if (($role & $permin) > 0) {
                          //          $xx = $rt->operationDesc;
                           //         $srts[$xx] = $rt;
                           //         $list_apps[$kk]->sitemaps = true;
                              //  }
                          //  } else {
                                $xx = $rt->operationDesc;
                                $srts[$xx] = $rt;
                                $list_apps[$kk]->sitemaps = true;
                           // }
                        }
                    }
                    ksort($srts);
                    $list_apps[$kk]->routeTables = [];
                    foreach ($srts as $i => $rt) {
                        //$rt->operationDesc = substr($rt->operationDesc, 4);
                        $list_apps[$kk]->routeTables[] = $rt;
                    }
                    $k++;
                //}
            }
        }
        ksort($list_apps);
        $list_apps_sort = [];
        foreach ($list_apps as $i => $a) {
            //$a->title = substr($a->title, 4);
            $list_apps_sort[] = $a;
        }

        $datax = [];
        $datax["apps"] = $list_apps_sort;
        // $cc = $this->render2($datax, "home");
        return $datax["apps"];
    }

    /*public function render2($datax, $appId) {
        $this->_context_path = \th\co\bpg\cde\core\impl\ChangdaoEngineImpl::$_CONTEXT_PATH;
        $datax["_context_path"] = \th\co\bpg\cde\core\impl\ChangdaoEngineImpl::$_CONTEXT_PATH;
        $loaders = array("apps/" . $appId . '/views', "views");
        if (!is_dir("views")) {
            $loaders = array("apps/" . $appId . '/views');
        }
        $options = array('extension' => '.html');
        $m = new \Mustache_Engine(array(
            'loader' => new CViewLoader($loaders, $options),
            'charset' => 'UTF-8',
            'helpers' => array(
            )
        ));
        return $m->render("nav", $datax);
    }*/

}
