
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




    <div id="naslov" style="padding: 20 0;">
        <h2 align="center">Rekapitulacija za kasu <?php echo $naplatniuredjaj->nu_broj; ?> u poslovnici <?php echo $prodajnomjesto->pm_oznaka; ?></h2>
        <h3 align="center">Za razdoblje od <?php echo date("d.m.Y", strtotime($datOD)); ?>  do <?php echo date("d.m.Y", strtotime($datDO)); ?> </h3>
    </div>

      <table class="table" align="left" repeat_header="1" style="margin-top: 10px;">
         
        <thead>
           <tr bgcolor="silver">         

                <td align="right"> Naziv </td>
                <td align="right"> %poreza</td>
                <td align="right"> Osnovica</td>
                <td align="right"> Iznos poreza</td>
                
            </tr>
        
        </thead>
        <tbody>
         <?php if (!empty($table)) {  
                $ukupno = 0.00;
                $id = 0;     
             ?>                          
            <?php $rank = 0; foreach ($table as $porez) { 
                if( $id != $porez->sp_id)
                { ?>
                   <tr style="border:solid 1px;">           
                     <td colspan="4" align="left" >Nacin placanja: <b><?php echo $porez->sp_opis; ?></b></td>        
                   </tr>

                <?php 
                }
                ?>
             
            <tr style="border: none;"> 
            
                <td align="right"><?php echo $porez->pzs_naziv; ?></td>
                <td align="right" ><?php echo $porez->porez_pz_posto; ?></td>
                <td align="right" ><?php echo number_format($porez->sumaIznosa, 2, ',', '.') ?></td>
                <td align="right" ><?php echo number_format($porez->sumaPorez, 2, ',', '.') ?></td>
                  <?php  
                  $ukupno = $ukupno + $porez->sumaPorez ;
                 
                  ?>                            
            </tr> 
            <?php
            
           
             $id = $porez->sp_id;   
            } ?>
                
         <?php } else{ 
                  $ukupno = 0; 
                 ?>
                            
                <tr> 
                    <td style="text-align: center;" colspan="4">Nemate stavki </td>
                </tr>  
                            
            <?php   
            } ?> 
            
             <tr>
                <td colspan="3" align="right" bgcolor="white"><b>SVEUKUPNO:</b></td>
             
               
                <td  align="right" bgcolor="silver"><?php  echo number_format($ukupno,  2, ',', '.'); ?>&nbsp;Kn</td>
             
            </tr>          
            

        </tbody>
     
     
     </table>
     


    <table align="left" id ="podnozje" style="margin-top: 20px;">
        <tr>
            <td>Izradio:</td>
            <td><?php echo $this->session->userdata('ime')." ".$this->session->userdata('prezime');  ?></td>              
        </tr>     
    </table>   
    



<script type="text/javascript"> 

$(document).ready(function() {  
    
     $(window).keydown(function(event){
     if(event.keyCode == 13) {
         event.preventDefault();
         return false;
         }
     });
    
});   
 

    
</script>
