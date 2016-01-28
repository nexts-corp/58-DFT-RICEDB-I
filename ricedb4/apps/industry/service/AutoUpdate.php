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

    public function checkupdate() {
        try{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://10.3.1.172/ricedb3/api/auction/autoupdate/update");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        //echo $server_output;
        curl_close($ch);
        $msg=new \th\co\bpg\cde\collection\impl\CJMessage();
       // $server_output=utf8_decode($server_output);
        
        $msg->parse($server_output);// json_decode($server_output);
       // CJMessage
       // print_r($msg);
        $data=$msg->getValue(new \apps\common\model\SQLUpdate(),"lists");
       // print_r($data);
        $n=count($data);
      // print_r($data->lists);
        for($i=0;$i<$n;$i++){
           // echo $data->lists[$i]->sdata."<br>";
           // $this->datacontext->pdoQuery("");
          // $this->datacontext->pdoQuery(""+$data->lists[$i]->sdata);
             $sql = "EXEC sp_batch_exce :data";
             $param = array(
                    "data" =>  $data[$i]->sdata
             );
             //echo  str_replace("'", "''",$data->lists[$i]->sdata)."<br>";
             $this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate");
        }
        
         $sql = "EXEC sp_sync_update_data";
             $param = array(
                  
             );
             //echo  str_replace("'", "''",$data->lists[$i]->sdata)."<br>";
             $this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate");
             echo "is ok";
             header("Refresh:30");
             exit;
        }  catch (\Exception $ex){
            echo $ex;
            
        }
       // return true;
       // return   json_decode($server_output);
        
    }

    public function update() {


        $sql = "EXEC sp_sync_get_update :auctionId";
        $param = array(
            "auctionId" => $this->getStatus()->keyword
        );
        if ($update = $this->datacontext->pdoQuery($sql, $param, "apps\\common\\model\\SQLUpdate")) { //sql,param,class
            return $update;
        }
    }

}
