<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pocetna_model extends My_model {
    
    //ovaj ID je vd_oznaka vrste dokumenta
    public function getDokumentNedovrsen($id){
        $sql="SELECT dokument.*, concat(operater.op_ime,' ', operater.op_prezime) as operater, vrstadokumenta.vd_id, vrstadokumenta.vd_oznaka FROM dokument JOIN operater ON dokument.operater_op_id = operater.op_id  JOIN vrstadokumenta ON vrstadokumenta.vd_id = dokument.vrstadokumenta_vd_id
        where vrstadokumenta.vd_oznaka ='" .$id. "' and dokument.do_status ='I' and dokument.firma_fi_id =". $this->session->userdata('firmaID');

        $query = $this->db->query($sql);
        return $query->result();        

    }     
    
    
    public function getDokumentNeplacen($id){
        $sql="SELECT dokument.*, concat(operater.op_ime,' ', operater.op_prezime) as operater, vrstadokumenta.vd_id, vrstadokumenta.vd_oznaka FROM dokument JOIN operater ON dokument.operater_op_id = operater.op_id  JOIN vrstadokumenta ON vrstadokumenta.vd_id = dokument.vrstadokumenta_vd_id
        where vrstadokumenta.vd_oznaka ='" .$id. "' and dokument.do_status ='Z' and dokument.do_placeno= 0 and dokument.firma_fi_id =". $this->session->userdata('firmaID')." order by dokument.do_datum desc";

        $query = $this->db->query($sql);
        return $query->result();        

    }        
    
    public function getPonudeOtvorene($id){
        $sql="SELECT dokument.*, concat(operater.op_ime,' ', operater.op_prezime) as operater, vrstadokumenta.vd_id, vrstadokumenta.vd_oznaka FROM dokument JOIN operater ON dokument.operater_op_id = operater.op_id  JOIN vrstadokumenta ON vrstadokumenta.vd_id = dokument.vrstadokumenta_vd_id
        where vrstadokumenta.vd_oznaka ='" .$id. "' and dokument.do_status ='Z' and dokument.do_valuta >= curdate() and dokument.firma_fi_id =". $this->session->userdata('firmaID')." order by dokument.do_datum desc";

        $query = $this->db->query($sql);
        return $query->result();        

    }       
    
    
    public function getNefiskalizirane(){
        $sql="SELECT dokument.do_id  FROM dokument  JOIN vrstadokumenta ON vrstadokumenta.vd_id = dokument.vrstadokumenta_vd_id join sredstvoplacanja on sredstvoplacanja.sp_id = dokument.sredstvoplacanja_sp_id
        where vrstadokumenta.vd_id = 2 and (dokument.do_status ='Z' or dokument.do_status = 'S') and (dokument.do_jir ='' or dokument.do_jir is null) and dokument.firma_fi_id =". $this->session->userdata('firmaID')." and sredstvoplacanja.sp_fiskalizirati != 0 order by dokument.do_broj desc";

        $query = $this->db->query($sql);

        return $query->num_rows();
        
    }  
    
    public function getVrsteDokumenta()
    {
        $sql="select vrstadokumenta.* from vrstadokumenta order by vd_id desc";
        $query = $this->db->query($sql);
        return $query->result();       
    }
    
    
    public function getStatistike()
    {    
         $sql="select (select count(dokument.do_id)   from dokument where dokument.vrstadokumenta_vd_id= 1 and firma_fi_id = ".$this->session->userdata('firmaID').") as ponude, (select  count(dokument.do_id)  from dokument where dokument.vrstadokumenta_vd_id= 2 and firma_fi_id =". $this->session->userdata('firmaID').") as racuni ,  (SELECT count(do_id) FROM dokument     where dokument.vrstadokumenta_vd_id= 2 and dokument.do_status ='Z' and dokument.do_placeno= 0 and dokument.firma_fi_id =". $this->session->userdata('firmaID').") as neplaceniracuni";

         $query = $this->db->query($sql);
         $result = $query->result();  
         return $result[0];  
                        
    }     
    
    public function chartNajprodavanijiArtikli()
    {    
         $sql="select count(stavkedokumenta.artikl_ar_id) as broj, stavkedokumenta.ar_naziv as naziv  from stavkedokumenta join dokument on dokument.do_id = stavkedokumenta.dokument_do_id and dokument.firma_fi_id = ".$this->session->userdata('firmaID')." group by artikl_ar_id order by broj asc limit 5";

         $query = $this->db->query($sql);
         return $query->result(); 
                        
    }      
    
    public function charSumePoDanu()
    {    
         $sql="select sum(dokument.do_iznos + dokument.do_iznosPDV) as suma, dokument.do_datum as datum  from dokument  where dokument.firma_fi_id =".$this->session->userdata('firmaID')." and dokument.do_status ='Z' and dokument.vrstadokumenta_vd_id = 2  and dokument.do_datum BETWEEN (CURRENT_DATE() - INTERVAL 1 MONTH) AND CURRENT_DATE() group by dokument.do_datum ";

         $query = $this->db->query($sql);
         return $query->result(); 
                        
    }      
      
}
?>
