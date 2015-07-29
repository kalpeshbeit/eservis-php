
    <table align="left" id ="firma">

        <?php if (isset($firma)) {  ?>
            <tr >
                 <td><?php echo $firma->fi_naziv; ?></td>              
            </tr>
              <tr >
                 <td><?php echo $firma->fi_adresa; ?></td>              
            </tr>
              <tr >
                 <td><?php echo @$firma->fi_mjesto; ?></td>              
            </tr>
              <tr >                    
                 <td>OIB: <?php echo @$firma->fi_oib; ?></td>                            
            </tr>              
            <tr >                    
                 <td style="width: 250px">IBAN: <?php echo @$firma->fi_iban; ?></td>                            
            </tr>
        <?php
        }
        ?>
    </table>




    <table align="right" id="partner">
        <tr>
        <td>ZA:</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>        
        </tr>

        <?php if(!empty($partner)) { ?>
        <tr>
            <td><?php echo $partner->pa_naziv ?></td>
        </tr>
        <tr>
            <td><?php echo $partner->pa_posta. ' ' .$partner->pa_mjesto ?></td>  
        </tr>
        <tr>
            <td><?php echo $partner->pa_adresa ?></td> 
        </tr>
        <tr> 
            <td><?php if($partner->pa_oib){echo "OIB:";} ?><?php echo $partner->pa_oib ?></td>  
        </tr>
        <?php } else {?>
         <tr>
            <td><?php echo $zaglavlje->pa_naziv ?></td>
        </tr>
        <tr>
            <td><?php echo $zaglavlje->pa_adresa ?></td>
        </tr>
        <tr>
            <td><?php echo $zaglavlje->pa_posta. ' ' .$zaglavlje->pa_mjesto ?></td>  
        </tr>
        <tr> 
            <td><?php if($zaglavlje->pa_oib){echo "OIB:";} ?><?php echo $zaglavlje->pa_oib ?></td>  
        </tr>
        
        <?php }?>
        
        
         <?php if(!empty($zaglavlje->do_osoba)) { ?>
           <tr>
            <td>N/R: <?php echo $zaglavlje->do_osoba; ?></td>
        </tr>
      
        <?php }?>
      
    </table> 



    <div id="naslov" style="padding: 20 0;">
        <h2 align="center"><?php echo $vrstaDokumenta->vd_opis ?> broj <?php echo $zaglavlje->do_broj;?><?php echo isset($zaglavlje->PP)? '/':'' ?><?php echo $zaglavlje->PP; ?><?php echo isset($zaglavlje->PP)? '/':'' ?><?php echo $zaglavlje->NU; ?></h2>
    </div>



    <table align="left">
        <tr>
            <td align="right">Datum i vrijeme: </td><td> &nbsp;<?php echo date("d.m.Y", strtotime($zaglavlje->do_datum)). ' ' .date("H:i:s", strtotime($zaglavlje->do_vrijeme)); ?></td>     
        </tr>
        <tr>
            <td align="right">Mjesto izdavanja: </td><td> &nbsp;<?php echo $zaglavlje->do_mjestoizdavanja;?></td>   
        </tr>
        
        <tr>
            <td colspan="2"><hr/></td>
        </tr>
        
          <?php if($zaglavlje->do_napomena) {?>
            <tr>
                <td>Napomena:</td>
                <td>&nbsp;<?php echo $zaglavlje->do_napomena; ?></td>                            
            </tr>                       
        <?php   
        } ?> 
    </table>

     <table class="table" align="left" repeat_header="1" style="margin-top: 10px;">
         <thead>
            <tr bgcolor="silver">
                <td>RBR.</td>
                <td width="200px">OPIS</td> 
                <td>KOLICINA</td> 
                <td>JMJ</td> 
                <td>CIJENA</td>                 
                <?php if($sume->sumaPopust > 0){ ?>
                <td>POPUST</td> 
                <?php } ?>  
                
                
                <td>IZNOS</td>
                <?php if($this->session->userdata('UsustavuPDV') == 1){ ?>

                <td>POREZ</td>
                <td>PDV</td>
                <?php } ?>
 
                <td>UKUPNO</td>   
            </tr>
         </thead>

         <tbody>     
            <?php if (!empty($prikaziStavke)) {  ?>                          
            <?php $rank = 0; foreach ($prikaziStavke as $stavka) { ?>

            <tr>
                <td><?php echo ++$rank; ?>.</td>
                <td><?php if($stavka->naziv){echo $stavka->naziv;}else{echo $stavka->ar_naziv;} ?></td>
                <td align="right"><?php echo $stavka->sd_kolicina; ?></td>
                <td><?php echo $stavka->JedinicaMjere_jm_sifra; ?></td>
                <td align="right"><?php echo number_format($stavka->sd_cijenabruto, 2, ',', '.'); ?></td>
                <?php if($sume->sumaPopust > 0){ ?>
                <td align="right"><?php echo number_format($stavka->sd_iznospopusta, 2, ',', '.'); ?></td>
                <?php } ?>
                <td align="right"><?php echo number_format($stavka->sd_iznosneto, 2, ',', '.'); ?></td>
                 <?php if($this->session->userdata('UsustavuPDV') == 1){ ?>
                <td align="right"><?php echo $stavka->porez_pz_posto; ?></td> 
                <td align="right"><?php echo  number_format($stavka->sd_poreziznos,  2, ',', '.'); ?></td> 
                <?php } ?>
               
                <td align="right"><?php echo number_format($stavka->sd_poreziznos + $stavka->sd_iznosneto,  2, ',', '.')?></td>   
                                
            </tr> 
            
             <?php if($stavka->ar_opis != "")
             {?>
              
             <tr style="border: none;">
                <td></td>
                <td style="font-style: italic; font-size: 0.8em" colspan="8"><?php echo $stavka->ar_opis; ?></td>
                
            </tr> 
                 
             <?php }else if($stavka->ar_dodatniopis !=""){ ?>
                 
             <tr style="border: none;">
                  <td></td>
                  <td style="font-style: italic; font-size: 0.8em" colspan="8"><?php echo $stavka->ar_dodatniopis; ?></td>
             </tr> 
                 
             <?php    
             }  ?>       

            
             <?php }}
             else{ ?>
                            
                <tr id="nemastavki">
                    <td style="text-align: center;" <?php if($this->session->userdata('UsustavuPDV') == 0){ echo 'colspan="7"';} else {echo 'colspan="9"';} ?> >Nemate dodanih stavki</td>
                </tr>
                            
            <?php   
            } ?>            
            

            <tr>
                <td colspan="5" align="right" bgcolor="white"><b>SVEUKUPNO:</b></td>
                <?php if($sume->sumaPopust > 0){ ?>
                <td bgcolor="silver"><?php echo number_format($sume->sumaPopust, 2, ',', '.'); ?></td>
                <?php } ?>
                <td bgcolor="silver"><?php echo  number_format((float)$zaglavlje->do_iznos, 2, ',', '.'); ?></td>
                
                 <?php if($this->session->userdata('UsustavuPDV') == 1){ ?>

                <td bgcolor="silver" align="center">/</td>
                <td bgcolor="silver"><?php echo  number_format((float)$zaglavlje->do_iznosPDV, 2, ',', '.'); ?></td>
                <?php } ?>
               
                <td bgcolor="silver"><?php echo  number_format($zaglavlje->do_iznos + $zaglavlje->do_iznosPDV,  2, ',', '.'); ?>Kn</td>
             
            </tr>
         </tbody> 
     </table>



    <table align="left" id ="podnozje" style="margin-top: 20px;">
        <tr>
            <td>Ponuda  vrijedi do:</td><td>&nbsp;<?php echo date("d.m.Y.", strtotime($zaglavlje->do_valuta))  ; ?></td>     
        </tr>          
        <tr>
            <td>Rok isporuke:</td><td>&nbsp;do 7 radnih dana od vidljive uplate *</td>     
        </tr>       
       
        <tr>
            <td>Na&#269;ina pla&#263;anja:</td>
            <td>&nbsp;<?php echo $zaglavlje->sp_opis; ?></td>                            
        </tr>  
        <tr>
            <td>Ponudu izradio:</td>
            <td>&nbsp;<?php echo $zaglavlje->operater; ?></td>              
        </tr>     
    </table>   
    
    
    <div id="napomena" style="position: absolute; bottom:120px;">
        <p style="font-size: 11px">*U slu&#269;aju Va&#353;e kasnije uplate ne garantiramo gore navedene cijene niti rok isporuke.</p> 
    </div>
  
    




<script type="text/javascript"> 

$(document).ready(function() {  
    
     $(window).keydown(function(event){
     if(event.keyCode == 13) {
         event.preventDefault();
         return false;
         }
     });
    

    $('.close-link1').click(function (event) {       
        //vrati pocetni popis svih dokumenata

        $('#forma').hide();
        $('#tablica').show();
        $('#tablica tbody tr:eq(0)').click();
        
    });   
    
});   
 

    
</script>
