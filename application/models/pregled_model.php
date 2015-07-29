<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pregled_model extends My_model {

     public function getDokument($id, $datOD, $datDO){ 
        $sql="SELECT dokument.*, partner.pa_naziv as partner, concat(operater.op_ime,' ', operater.op_prezime) as operater, naplatniuredjaj.nu_broj as NU, prodajnomjesto.pm_oznaka as PP FROM dokument JOIN operater ON dokument.operater_op_id = operater.op_id LEFT JOIN prodajnomjesto on prodajnomjesto.pm_id = dokument.prodajnoMjesto_pm_id LEFT JOIN naplatniuredjaj on naplatniuredjaj.nu_ID = dokument.naplatniuredjaj_nu_id left outer join partner on partner.pa_id = dokument.Partner_pa_id
        where dokument.do_datum between '".$datOD."' and '".$datDO."' and dokument.vrstadokumenta_vd_id =" .$id. " and dokument.firma_fi_id =". $this->session->userdata('firmaID')." and dokument.do_status <> 'I' order by dokument.do_broj desc";

        $query = $this->db->query($sql);
        return $query->result();
    }
    
    
    
    public function getProdajnaMjestaSva(){
        $sql="select prodajnomjesto.* from prodajnomjesto where prodajnomjesto.pm_id in (select naplatniuredjaj.prodajnoMjesto_pm_id from naplatniuredjaj)  and  prodajnomjesto.firma_fi_id =". $this->session->userdata('firmaID'); 

        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function getStanjeBlagajne($datOD, $datDO ,$pmID, $nuID, $vpID = NULL){ 
        

        if($vpID != NULL)
        {
            $sql="select sum(dokument.do_iznos) + sum(dokument.do_iznosPDV) as ukupno, sredstvoplacanja.sp_opis as placanje, sredstvoplacanja.sp_opis, prodajnomjesto.pm_oznaka from dokument join naplatniuredjaj on naplatniuredjaj.nu_id = dokument.naplatniuredjaj_nu_id join prodajnomjesto on prodajnomjesto.pm_id =dokument.prodajnoMjesto_pm_id  join sredstvoplacanja on sredstvoplacanja.sp_id =dokument.sredstvoplacanja_sp_id  and dokument.naplatniuredjaj_nu_id = ".$nuID." and dokument.prodajnoMjesto_pm_id = ".$pmID." and dokument.do_status <> 'I' and dokument.sredstvoplacanja_sp_id =".$vpID."  and dokument.do_datum between '".$datOD."' and '".$datDO."' and dokument.firma_fi_id =". $this->session->userdata('firmaID')." group by sredstvoplacanja.sp_id";       
        }
        else
        {
            $sql="select sum(dokument.do_iznos) + sum(dokument.do_iznosPDV) as ukupno, sredstvoplacanja.sp_opis as placanje, sredstvoplacanja.sp_opis, prodajnomjesto.pm_oznaka from dokument join naplatniuredjaj on naplatniuredjaj.nu_id = dokument.naplatniuredjaj_nu_id join prodajnomjesto on prodajnomjesto.pm_id =dokument.prodajnoMjesto_pm_id  join sredstvoplacanja on sredstvoplacanja.sp_id =dokument.sredstvoplacanja_sp_id  and dokument.naplatniuredjaj_nu_id = ".$nuID." and dokument.prodajnoMjesto_pm_id = ".$pmID." and dokument.do_status <> 'I' and dokument.do_datum between '".$datOD."' and '".$datDO."' and dokument.firma_fi_id =". $this->session->userdata('firmaID')." group by sredstvoplacanja.sp_id";
        }
        
        
        $query = $this->db->query($sql);
        return $query->result();
    } 
    
    
    public function getRekapitulacija($datOD, $datDO ,$pmID, $nuID, $vpID = NULL){ 
        

        if($vpID != NULL)
        {
            $sql ="SELECT sum(stavkedokumenta.sd_iznosneto) as sumaIznosa,  sum(stavkedokumenta.sd_poreziznos) as sumaPorez, stavkedokumenta.porez_pz_posto, poreznastopa.pzs_naziv, sredstvoplacanja.sp_opis, sredstvoplacanja.sp_id  

            FROM dokument left join stavkedokumenta on stavkedokumenta.dokument_do_id = dokument.do_id left join poreznastopa on poreznastopa.pzs_sifra = stavkedokumenta.poreznastopa_pz_sifra  join sredstvoplacanja on sredstvoplacanja.sp_id =dokument.sredstvoplacanja_sp_id   

            where dokument_do_id in (select dokument.do_id from dokument  join sredstvoplacanja on sredstvoplacanja.sp_id =dokument.sredstvoplacanja_sp_id join naplatniuredjaj on naplatniuredjaj.nu_id = dokument.naplatniuredjaj_nu_id join prodajnomjesto on prodajnomjesto.pm_id =dokument.prodajnoMjesto_pm_id and dokument.naplatniuredjaj_nu_id = ".$nuID." and dokument.prodajnoMjesto_pm_id = ".$pmID." 

            and dokument.do_status <> 'I' and dokument.sredstvoplacanja_sp_id =".$vpID." and dokument.do_datum between '".$datOD."' and '".$datDO."' ) and dokument.firma_fi_id =". $this->session->userdata('firmaID')."

            group by sredstvoplacanja.sp_opis ,porez_pz_posto order by  sredstvoplacanja.sp_opis asc, porez_pz_posto desc";
        }
        else
        {
            $sql ="SELECT sum(stavkedokumenta.sd_iznosneto) as sumaIznosa,  sum(stavkedokumenta.sd_poreziznos) as sumaPorez, stavkedokumenta.porez_pz_posto, poreznastopa.pzs_naziv, sredstvoplacanja.sp_opis, sredstvoplacanja.sp_id  

            FROM dokument left join stavkedokumenta on stavkedokumenta.dokument_do_id = dokument.do_id left join poreznastopa on poreznastopa.pzs_sifra = stavkedokumenta.poreznastopa_pz_sifra  join sredstvoplacanja on sredstvoplacanja.sp_id =dokument.sredstvoplacanja_sp_id   

            where dokument_do_id in (select dokument.do_id from dokument  join sredstvoplacanja on sredstvoplacanja.sp_id =dokument.sredstvoplacanja_sp_id join naplatniuredjaj on naplatniuredjaj.nu_id = dokument.naplatniuredjaj_nu_id join prodajnomjesto on prodajnomjesto.pm_id =dokument.prodajnoMjesto_pm_id and dokument.naplatniuredjaj_nu_id = ".$nuID." and dokument.prodajnoMjesto_pm_id = ".$pmID." 

            and dokument.do_status <> 'I'  and dokument.do_datum between '".$datOD."' and '".$datDO."' ) and dokument.firma_fi_id =". $this->session->userdata('firmaID')."

            group by sredstvoplacanja.sp_opis ,porez_pz_posto order by  sredstvoplacanja.sp_opis asc, porez_pz_posto desc";        
        }
        
        $query = $this->db->query($sql);
        return $query->result();
    }
   
}
?>
