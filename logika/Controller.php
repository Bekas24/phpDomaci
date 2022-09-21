<?php
include '../../logika/dbbroker.php';
include '../../logika/servis/ZanrServis.php';
include '../../logika/servis/PisacServis.php';
include '../../logika/servis/KnjigaServis.php';
class Controller{

    private $broker;
    private $zanrServis;
    private $knjigaServis;
    private $pisacServis;
    private static $controller;

    private function __construct(){
        $this->broker=new Broker("localhost",'root','','books');
        $this->zanrServis=new ZanrServis($this->broker);
        $this->knjigaServis=new KnjigaServis($this->broker);
        $this->pisacServis=new PisacServis($this->broker);
    }
    public static function getController(){
        if(!isset($controller)){
            $controller=new Controller();
        }
        return $controller;
    }
    public function obradiZahtev($akcija){
        try {
           echo json_encode($this->vratiUspesno($this->izvrsi($akcija)));
        } catch (Exception $ex) {
            echo json_encode($this->vratiGresku($ex->getMessage()));
        }
    }
    public function izvrsi($akcija){
        if($akcija=='vratiZanrove'){
            return $this->zanrServis->vratiSve();
        }
        if($akcija=='vratiKnjige'){
            return $this->knjigaServis->vratiSve();
        }
        if($akcija=='vratiPisce'){
            return $this->pisacServis->vratiSve();
        }
        if($akcija=='kreirajPisca'){
            return $this->pisacServis->kreiraj($_POST);
        }
        if($akcija=='kreirajKnjigu'){
            return $this->knjigaServis->kreiraj($_POST);
        }
        if($akcija=='izmeniPisca'){
            return $this->pisacServis->izmeni($_GET['id'],$_POST);
        }
        if($akcija=='izmeniKnjigu'){
            return $this->knjigaServis->izmeni($_GET['id'],$_POST);
        }
        if($akcija=='obrisiPisca'){
            $this->pisacServis->obrisi($_GET['id']);
            return null;
        }
        if($akcija=='obrisiKnjigu'){
            $this->knjigaServis->obrisi($_GET['id']);
            return null;
        }
    }
    public function vratiUspesno($podaci){
        if(!isset($podaci)){
            return[
                "status"=>true,
            ];
        }
        return[
            "status"=>true,
            "data"=>$podaci
        ];
    }
    public function vratiGresku($greska){
        return[
            "status"=>false,
            "error"=>$greska
        ];
    }
}


?>