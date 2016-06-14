<?php
namespace apps\home\widget;
use th\co\bpg\cde\core\CWidget;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use th\co\bpg\cde\core\impl\CServiceLoaderImpl;
use th\co\bpg\cde\core\impl\ChangdaoEngineImpl;
use th\co\bpg\cde\collection\impl\CI18NImpl;
use th\co\bpg\cde\collection\impl\CViewLoader;
use th\co\bpg\cde\data\CDataContext;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class NavWidget extends CWidget {
	public $datacontext;
	public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";
	
    function __construct() {
         $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(NULL);
    }
	
	function DateThai()
	{
		$strYear = date("Y")+543;
		$strMonth= date("n");
		$strDay= date("j");
	
		$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤภษาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

	

	function getAuction($status){
        $sql = "SELECT"
                ." st"
            ." FROM ".$this->ent."\\Status st"
            ." WHERE st.active = :active ";
        $param = array(
            "active" =>$status
        );
		
        $data = $this->datacontext->getObject($sql, $param); //get STATUS is Active
        
        if(count($data)>0){
			//13 มิถุนายน 2559
			$d1=$data[0]->auctionDateFirst;
			$d2=$data[0]->auctionDateLast;
			$c= $this->DateThai();
			if($d1==$c || $d2==$c){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
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
				$chk=true;
				if($value=="auction"  ){
					$chk=$this->getAuction("Y");
				}else if($value=="industry"){
					$chk=$this->getAuction("YA");
				}
				
				if($chk){
					$app_load=$loader->load($value);
					$kk=$app_load->title;
					$list_apps[$kk] =$app_load;
					
					$rts=$list_apps[$kk]->routeTables;
					$list_apps[$kk]->sitemaps=false;
				  //ksort( $list_apps[$k]->routeTables);
				   $srts=[];
				   foreach ($rts as $i => $rt) {
						if($rt->sitemap==true){
							if($rt->resource!=null &&  $rt->resource!="*"){
								$permin=bindec($rt->resource);
								if(($role & $permin)>0){
									$xx= $rt->operationDesc;
									$srts[$xx]=$rt;
									$list_apps[$kk]->sitemaps=true;
								}
							}else{
								$xx= $rt->operationDesc;
							    $srts[$xx]=$rt;
							    $list_apps[$kk]->sitemaps=true;
							}
					   }
					}
					ksort( $srts);
					$list_apps[$kk]->routeTables=[];
					foreach ($srts as $i => $rt) {
						 $rt->operationDesc=substr($rt->operationDesc,4);
						 $list_apps[$kk]->routeTables[]=$rt;
					}
					//print_r($srts);
					//$list_apps[$k]->routeTables=[]
					//$list_apps[$k]->routeTables=$srts;
				   /// print_r($list_apps[$k]->routeTables);
					$k++;
				}
			}
        }
		ksort($list_apps);
		$list_apps_sort = [];
		foreach ($list_apps as $i => $a) {
			 $a->title=substr($a->title,4);
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
		$datax["_context_path"]= \th\co\bpg\cde\core\impl\ChangdaoEngineImpl::$_CONTEXT_PATH;
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