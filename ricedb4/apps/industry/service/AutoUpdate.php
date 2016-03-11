<?php

namespace apps\industry\service;


use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\industry\interfaces\IAutoUpdate;

class AutoUpdate extends CServiceBase implements IAutoUpdate {

    public $datacontext;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    function getStatus() {
        $sql = "SELECT"
                . " st"
                . " FROM " . $this->ent . "\\Status st"
                . " WHERE st.active = :active";
        $param = array(
            "active" => "Y"
        );
        $data = $this->datacontext->getObject($sql, $param); //get STATUS is Active

        return $data[0];
    }


	
	public function download() {
        $sql = "EXEC sp_sync_get_update :auctionId";
        $param = array(
            "auctionId" => $this->getStatus()->keyword
        );
        if ($update = $this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate")) { //sql,param,class
            return $update;
        }
    }
	
	public function upload($data){
		 try{
			$n=count($data);
			for($i=0;$i<$n;$i++){
				 $sql = "EXEC sp_batch_exce :data";
				 $param = array(
						"data" =>  $data[$i]->sdata
				 );
				 
				 $this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate");
			}
			
			$sql = "EXEC sp_sync_update_data";
		    $param = array();
		    $this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate");
			return "ok";
        }  catch (\Exception $ex){
            echo $ex;
            
        }
	}

    public function checkupdate() {
        try{
			$out=((new \DateTime())->format('Y-m-d H:i:s'))." : Update Data From Master Server  <br/>";
			$out.=$this->download4Master();
			
			$out.="<br/>".((new \DateTime())->format('Y-m-d H:i:s'))." : Upload Data to Master Server  <br/>";
			$out.=$this->upload2Master();
			
			echo $out;
			header("Refresh:30");
			exit;
        }  catch (\Exception $ex){
            echo $ex;
			header("Refresh:30");
        }
    }
	
	public function download4Master(){
		  try{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://riceauction.dft.go.th/ricedb4/api/auction/autoupdate/download");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			curl_close($ch);
		   
			$msg=new \th\co\bpg\cde\collection\impl\CJMessage();
			$msg->parse($server_output);
			$data=$msg->getValue(new \apps\common\model\SQLUpdate(),"lists");
			return $this->upload($data);
			
        }  catch (\Exception $ex){
            return $ex;
        }
	}
	
	public function upload2Master(){
		 try{
			$datas=$this->download();
			$msg=new \th\co\bpg\cde\collection\impl\CJMessage();
			$msg->add("lists",$datas);
			$json=$msg->toJson();
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://riceauction.dft.go.th/ricedb4/api/auction/autoupdate/upload");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			curl_close($ch);
			return $server_output;
		 }  catch (\Exception $ex){
            return $ex;
        }
	}

}