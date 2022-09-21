<?php

class KnjigaServis{
    private $broker;
    
    public function __construct($b){
        $this->broker=$b;
    }

    public function vratiSve(){
        $knjige= $this->broker->ucitajKOlekciju("select p.*, z.naziv as 'zanr_naziv',pe.ime as 'pisac_ime',pe.prezime as 'pisac_prezime' from knjiga p inner join zanr z on (z.id=p.zanr) inner join pisac pe on(pe.id=p.pisac)");
        $res=[];
        foreach($knjige as $knjiga){
            $res[]=$this->toDto($knjiga);
        }
        return $res;
    }
    public function vratiJednu($id){
        $knjiga= $this->broker->ucitajJedan("select p.*, z.naziv as 'zanr_naziv',pe.ime as 'pisac_ime',pe.prezime as 'pisac_prezime' from knjiga p inner join zanr z on (z.id=p.zanr) inner join pisac pe on(pe.id=p.pisac) where p.id=".$id);
        return $this->toDto($knjiga);
    }
    public function kreiraj($knjigaDto){
        $this->broker->upisi("insert into knjiga(naziv,trajanje,zanr,pisac) values('".$knjigaDto['naziv'].
                                "',".$knjigaDto['trajanje'].",".$knjigaDto['zanr'].",".$knjigaDto['pisac'].")");
        $id=$this->broker->getLastId();
        return $this->vratiJednu($id);
    }
    public function izmeni($id,$knjigaDto){
        $this->broker->upisi("update knjiga set naziv='".$knjigaDto['naziv']."', trajanje=".$knjigaDto['trajanje'].
                                ", zanr=".$knjigaDto['zanr']." , pisac=".$knjigaDto['pisac']." where id=".$id);
        return $this->vratiJednu($id);
    }
    public function obrisi($id){
        $this->broker->upisi("delete from knjiga where id=".$id);
    }
    private function toDto($knjiga){
        return [
            "id"=>$knjiga->id,
            "naziv"=>$knjiga->naziv,
            "trajanje"=>$knjiga->trajanje,
            "zanr"=>[
                "id"=>$knjiga->zanr,
                "naziv"=>$knjiga->zanr_naziv
            ],
            "pisac"=>[
                "id"=>$knjiga->pisac,
                "ime"=>$knjiga->pisac_ime,
                "prezime"=>$knjiga->pisac_prezime
            ]
        ];
    }
}

?>