


     <td style="min-width: 130px;">
        <button  title="Spremi" class="btnstavka btn-default" id="spremistavku">Spremi</button>
        <button type="reset" title="Odustani" class="btnstavka btn-default" id="odustani"><span><i class="fa fa-times fa-fw"/></span></button>
     </td>
     
      <td style="max-width: 200px;">  
        <input id="artikl<?php echo $object->Artikl_ar_id ?>" name="artikl<?php echo $object->Artikl_ar_id ?>" placeholder="<?php if(!isset($id)){echo "Odaberite artikl";} ?>"/> 
        <input type="hidden"  id="artiklID" name="artiklID" value=""/> 
        <input type="hidden"  id="artiklnaziv" name="artiklnaziv" value=""/> 
        <textarea <?php if(isset($id)){ if($object->Artikl_ar_id){ echo 'style="display:none;overflow:auto;resize:none"';} else {echo 'style="overflow:auto;resize:none"';}} else { echo 'style="display: none;overflow:auto;resize:none"';} ?>  placeholder="Dodatni opis artikla" id="opis"  name="opis" class="form-control" ><?php if(isset($id)){echo $object->ar_dodatniopis;} ?></textarea>
     </td>
     
        <td style="min-width: 80px;">  
        <input type="text" class="form-control" onpaste="return false;" onkeydown="provjeri(this);" id="kolicina" name="kolicina" value="<?php if(isset($id)){echo $object->sd_kolicina;} ?>" />
     </td>
     
     <td style="min-width: 100px;">  
             <select  class="form-control" name="jedinicamjere" id="jedinicamjere">
                <?php foreach ($mjere as $v){    ?>
                    <option value="<?php echo $v->jm_sifra; ?>" <?php if(isset($id)){if($v->jm_sifra==$object->JedinicaMjere_jm_sifra){ ?> selected="selected" 
                <?php }} ?>><?php echo $v->jm_sifra; ?></option>
                <?php } ?>
             </select>
     </td>
     
      <td style="min-width: 100px;">  
        <input type="text" class="form-control"  onpaste="return false;" onkeydown="provjeri(this);" name="cijena" id="cijena" value="<?php if(isset($id)){echo $object->sd_cijenabruto;} ?>" />
     </td>
     
      <td style="min-width: 80px;">  
        <input type="text" class="form-control" onpaste="return false;" onkeydown="provjeri(this);" name="popust" value="<?php if(isset($id)){echo $object->sd_popust;} ?>" />
     </td>
     
      <td style="min-width: 110px;">  
        <select class="form-control" name="pdv" id="pdv" onchange="dohvatisifruporeznestope(this);">
            <?php foreach ($porezi as $v){    ?>
                <option value="<?php echo $v->PZ_POSTO; ?>" <?php if(isset($id)){if($v->PZ_POSTO==$object->porez_pz_posto){ ?> selected="selected" <?php }} ?>><?php echo $v->PZ_POSTO; ?></option>  
            <?php } ?>
        </select>
     </td> 
     <input id="uredjivanje" type="hidden"  value="1"/>
     <input id="pdvsifra" type="hidden"  value=""/>

  
<script type="text/javascript">  


$(document).ready(function() {

   LoadSelect2Script(DemoSelect2);

     $('#pdv')
        .trigger('change'); 
      
              
   $("#artikl<?php echo $object->Artikl_ar_id ?>")
    .on("change", function(e) 
    { 
        //dohvati cijenu, porez i jedinicu mjere odabranog artikla
        //ukoliko nije upisan proizvoljno ili je prazan
        
        var test = $('#artikl<?php echo $object->Artikl_ar_id ?>');
        var ID = $(test).select2('data').id;
        var text = $(test).select2('data').text;
        
       
        
        //ako nije prazno (kad netko obrise) i ako se ne ponavlja text
        if(e.val != "" && e.val != text)
        {
            id= e.val;
            
            //dohvati za taj id artikla podatke 
            $.post("<?php echo site_url().'dokument/dohvaticijenuPDVJmj/artikl'; ?>",{id:id}, function(data) {
                 
                 var obj = $.parseJSON(data);
                 
                 if (data != 'false') {   

                    $('#cijena').val(obj.ar_malopcijena);                       
                    $('#jedinicamjere').val(obj.JedinicaMjere_jm_sifra); 
                             
                    <?php if($this->session->userdata('UsustavuPDV') == 1)
                    { ?>         
                        document.getElementById('pdv').value=obj.pdv;
                    <?php } ?>  
                    
                     $('#pdv').trigger('change'); 
                       
                }
             });
             $('#opis').hide();
        }
         else
        {
            if(ID == text)
            {
                //ako su jednaki znaci da je korisnik upisao nekog kupca koji nije u bazi
                //omoguci korisniku da doda podatke o partneru koji æe biti dostupni samo ovaj put
                $('#opis').show();
            }
        }
    
    });
    
    


$('#odustani').click(function(evnt){
          
          idstavka = $("#id_odabrana_stavka").val(); 
          evnt.preventDefault();   
          
           id = $("#id").val();

          if(id != "")
          {
            $.post("<?php echo site_url().'dokument/prikaziStavke'; ?>",{id:id}, function(data) {
                if (data != 'false') {   
                    index = $("#index").val(); 
                    
                    $('#stavkePonuda').empty();
                    $('#stavkePonuda').html(data);
                   
                    
                    $("#stavke").find("tr").eq(index).click();      
                }
             });
          }
}); 



$('#spremistavku').click(function(evnt){
          
          evnt.preventDefault();   
          
          idzag = $("#id").val();

            var artik = $('#artikl<?php echo $object->Artikl_ar_id ?>');
            
               var IDart = $(artik).select2('data').id;
               var textart = $(artik).select2('data').text; 
               var sifra =  $("#pdvsifra").val();      

                if(IDart == textart)
                {
                    IDart = '';
                }               
                

          if(idzag != "")
          {
              //spremi stavku za taj dokument  
              //provjeri postoji li id stavke onda update napravi
              
              id = $("#id_odabrana_stavka").val(); 

            y = $('#ponudaFormStavke').find('select').filter(':visible');
            x = $('#ponudaFormStavke').find('input').filter(':visible').filter("input[type!='button']").filter("input[type!='submit']")
            var z = jQuery.merge(x,y);
  
              
          $.post("<?php echo site_url().'dokument/process_form_stavka/stavkedokumenta'; ?>",
          //ovdje trebam serialize samo taj red koji editiram
            
            //$("#ponudaFormStavke").serialize(),
            z.serialize() + '&idzag=' + idzag + '&id_odabrana_stavka=' + id + '&artiklID=' + IDart + '&artiklnaziv=' + textart + '&opis=' + $("#opis").val()+'&pdvsifra='+ sifra,

   
            function (data) {

            
            var obj = $.parseJSON(data);

            if (obj.uspjelo == 0)
            {   
                //$('#poruka').html(obj.poruka); //Add the AJAX response to some div that is going to show the message
                $('.preloader').hide();
            }
            else
            {       
                $('.preloader').hide(); 
               
                
                 //osvjezi
                        
                 $.post("<?php echo site_url().'dokument/prikaziStavke'; ?>",{id:idzag}, function(data) {
                    if (data != 'false') {   

                       index = $("#index").val();
                       $('#stavkePonuda').empty();
                       $('#stavkePonuda').html(data);
                       $('#stavke tr').eq(index).click(); 
                       
                       $('#poruka').html(obj.poruka);
                       $('#poruka').show();
                       setTimeout(function() {
                            $('#poruka').fadeOut('fast');
                        }, 10000);     
                                
                    }
                 });

            }
        });
          }

}); 


});

 function dohvatisifruporeznestope(that)
 {
    //dohvati sifru pdv.a
                
        //dohvati za taj id artikla podatke 
        $.post("<?php echo site_url().'dokument/getPorezneStopeSifra'; ?>", {posto: that.value}, function(data) {
             
             var obj = $.parseJSON(data);
             
             if (data != 'false') {   

                $('#pdvsifra').val(obj.pzs_sifra);

            }
         });

 }   

function DemoSelect2(){
    //$('#s2_with_tag').select2({placeholder: "Odaberite"});
    //$('#s2_country').select2(); 
    //popunjavanje inputa za artikl
       $("#artikl<?php echo $object->Artikl_ar_id ?>").select2({
         //minimumInputLength:1,
         width: 'resolve',
         maximumInputLength: 50,
         //placeholder: "Odaberite partnera",
         allowClear: true,
         createSearchChoice:function(term, data) { if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {return {id:term, text:term};} },
            multiple: false,
            data: [

                   <?php foreach ($artikli as $v){    ?>
                 {
                   id:   '<?php echo $v->ar_id; ?>',
                   text: '<?php echo $v->ar_naziv; ?>'
                 },
                                                 
                 <?php } ?>
            
             ],
             
         initSelection: function (element, callback) {      

            callback({ id:  '<?php if(isset($id)){echo $object->Artikl_ar_id;}?>', text: '<?php if(isset($id)){if($object->naziv){echo $object->naziv;}else{ echo $object->ar_naziv;}} ?>' });
         }
   
        }); 
}


function provjeri(that)
{
   if (that.value.indexOf(",") >= 0) {
    that.value = that.value.replace(/\,/g,".");
    }
    
}

</script>            



