<?php
namespace apps\home\widget;
use th\co\bpg\cde\core\CWidget;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use th\co\bpg\cde\core\impl\CServiceLoaderImpl;
use th\co\bpg\cde\core\impl\ChangdaoEngineImpl;
use th\co\bpg\cde\collection\impl\CI18NImpl;
use th\co\bpg\cde\collection\impl\CViewLoader;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class NavWidget extends CWidget {
    function __construct() {
        
    }
    public function render() {
        $loader = new CServiceLoaderImpl();
        $apps = scandir("apps");//array("auction","industry");
        //ksort( $apps);
       // print_r( $apps);
		$list_apps = [];
        $k=0;
		$list_apps_keys = [];
		$role=bindec($this->createBy = \th\co\bpg\cde\core\impl\ChangdaoEngineImpl::$_CURRENT_USER->resources[0]);
        foreach ($apps as $i => $value) {
			if($value!=="." && $value!==".."){
				$app_load=$loader->load($value);
				$kk=$app_load->title;
				$list_apps[$kk] =$app_load;
				
				$rts=$list_apps[$kk]->routeTables;
				$list_apps[$kk]->sitemaps=false;
			  //ksort( $list_apps[$k]->routeTables);
			   $srts=[];
			   foreach ($rts as $i => $rt) {
					if($rt->sitemap==true){
						
						$permin=bindec($rt->resource);
						if(($role & $permin)>0){
							$xx= $rt->operationDesc;
							$srts[$xx]=$rt;
							$list_apps[$kk]->sitemaps=true;
						}
				   }
				}
				ksort( $srts);
				$list_apps[$kk]->routeTables=[];
				foreach ($srts as $i => $rt) {
					 $list_apps[$kk]->routeTables[]=$rt;
				}
				//print_r($srts);
				//$list_apps[$k]->routeTables=[]
				//$list_apps[$k]->routeTables=$srts;
			   /// print_r($list_apps[$k]->routeTables);
				$k++;
			}
        }
		ksort($list_apps);
		$list_apps_sort = [];
		foreach ($list_apps as $i => $a) {
			$list_apps_sort[]=$a;
		}
		
		//print_r( $this->createBy = \th\co\bpg\cde\core\impl\ChangdaoEngineImpl::$_CURRENT_USER);
        
        //exit();
      // print_r($list_apps);
	  // exit();
       // $view = new CJView("nav", CJViewType::HTML_VIEW_ENGINE);
       // $view->apps = $list_apps;
        $datax=[];
        $datax["apps"]=$list_apps_sort;
        $cc=$this->render2($datax, "home");
        return $cc;
    }
    public function render2($datax,$appId) {
        $this->_context_path = \th\co\bpg\cde\core\impl\ChangdaoEngineImpl::$_CONTEXT_PATH;
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
    }
}