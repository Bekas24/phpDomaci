<?php

class Broker{
   
    private $mysqli;
    public function __construct($host,$username,$pass,$db){
        $this->mysqli = new mysqli($host,$username,$pass,$db);
        $this->mysqli->set_charset("utf8");
    }

    function getLastId(){
        return $this->mysqli->insert_id;
    }

    function ucitajKOlekciju($upit){
        $rezultat=$this->mysqli->query($upit);
       
        if(!$rezultat){
          throw new Exception($this->mysqli->error);
        }
        $rez=[];
            while($red=$rezultat->fetch_object()){
                $rez[]=$red;
            }
            return $rez;
    }

    function ucitajJedan($upit){
         $rezultat=$this->mysqli->query($upit);
       
        if(!$rezultat){
          throw new Exception($this->mysqli->error);
        }
        return $rezultat->fetch_object();
    }

    function upisi($upit){
        $rezultat=$this->mysqli->query($upit);
    
        if(!$rezultat){
           throw new Exception($this->mysqli->error);
        }
    }
   
}

?>
