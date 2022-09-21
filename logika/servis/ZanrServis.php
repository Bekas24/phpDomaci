<?php

class ZanrServis{
    private $broker;
    
    public function __construct($b){
        $this->broker=$b;
    }

    public function vratiSve(){
        return $this->broker->ucitajKOlekciju("select * from zanr");
    }
}

?>