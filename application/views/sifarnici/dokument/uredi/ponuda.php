 <!--Poèetak #forma div.a-->
      
<div class="col-xs-12 col-sm-12">
  <p><div id="poruka"></div><!--Poèetak diva poruke o uspjehu pohrane/izmjene podataka--></p>       
    <div class="box">
        <div class="box-header"><!--Poèetak headera forme-->
            <div class="box-name">
                <i class="fa fa-file-text"></i>
                <span><?php if(isset($id)){echo "Uredi ponudu";} else {echo "Dodaj ponudu";} ?></span>
            </div>
            <div class="box-icons">
                <a class="close-link1">
                <i class="fa fa-times"></i>
                </a>
            </div>
            <div class="no-move"></div>
        </div><!--Kraj headera forme-->
        <div class="box-content"><!--Poèetak sadržaja forme-->
            <form id="ponudaForm" method="post" action="" class="form-horizontal">
                <input id="id" name="id" type="hidden"  value="<?php if(isset($id)){echo $id;} ?>"/>
                <fieldset>                         
                    <div class="form-group">
                        <label for="partner" class="col-lg-2 control-label">Partner</label>
                            <div class="col-lg-4">
                                 <input id="partner" name="partner" placeholder="<?php if(!isset($id)){echo "Odaberite partnera";} ?>"/> 
                                 <input type="hidden"  id="partnerID" name="partnerID" value=""/> 
                                 <input type="hidden"  id="partnernaziv" name="partnernaziv" value=""/> 
                            </div>                                                        
                    </div>  
                    <div id ="dodatnoPartner" class="form-group" <?php if(isset($id)){if($object->Partner_pa_id){echo 'style="display: none;"';}}else {echo 'style="display: none;"';} ?>>
                        <div class="col-lg-offset-2">
                            <div class="col-lg-4">
                                 <label ><a onclick="prikaziDodatnoPartner();" href="#">>> Dodatno o kupcu</a></label>
                            </div>
                        </div>                           
                            
                    </div> 
                    
                     <div  id="dodatno_partner_unos" class="form" style="display: none;"> 
                        <div class="form-group has-feedback">  
                            <label for="adresa" class="col-lg-3 control-label">Adresa</label>
                            <div class="col-lg-2">  
                                <input type="text" id="adresa" class="form-control" name="adresa"  value="<?php echo isset($id)?  $object->pa_adresa : ''; ?>"/>
                            </div>                        
                        </div>  
                        <div class="form-group has-feedback">  
                            <label for="mjesto" class="col-lg-3 control-label">Mjesto</label>
                            <div class="col-lg-2">  
                                <input type="text" id="mjesto_partner" class="form-control" name="mjesto_partner"  value="<?php echo isset($id)?  $object->pa_mjesto : ''; ?>"/>
                            </div>
                        </div>  
                        <div class="form-group has-feedback">  
                            <label for="posta" class="col-lg-3 control-label">Po&#353;ta</label>
                            <div class="col-lg-2">  
                                <input type="text" id="posta" class="form-control" name="posta"  value="<?php echo isset($id)?  $object->pa_posta : ''; ?>" />
                            </div>
                            
                        </div>  
                        <div class="form-group has-feedback">  
                            <label for="oib" class="col-lg-3 control-label">OIB</label>
                            <div class="col-lg-2">  
                                <input type="text" id="oib" class="form-control" name="oib"  value="<?php echo isset($id)?  $object->pa_oib : ''; ?>"/>
                            </div>
                            
                        </div>
                     </div>
                     
                    <div class="form-group has-feedback"> 
                        <label for="datum" class="col-lg-2 control-label">Datum i vrijeme</label>
                            <div class="col-lg-2">
                                <input type="text" id="datum" class="form-control" name="datum" placeholder="npr. 01.01.2014." value="<?php echo isset($id)? date("d.m.Y.", strtotime($object->do_datum)): date("d.m.Y."); ?>" disabled="disabled"/>
                                <span class="fa fa-calendar form-control-feedback"/>
                            </div>
                            <div class="col-lg-2">
                                <input type="text" id="vrijeme" name="vrijeme" class="form-control" placeholder="08:00" value="<?php echo isset($id)? date("H:i", strtotime($object->do_vrijeme)) : date("H:i"); ?>"  data-original-title="" title="" disabled="disabled"/>
                                <span class="fa fa-clock-o form-control-feedback"/> 
                            </div>
                    </div>
                    
                    <div class="form-group">  
                        <label for="poslovni_prostor" class="col-lg-2 control-label">Broj ponude</label>
                            <div class="col-lg-5">  
                            
                            <!--- ID vrste dok koji se sprema automatski u bazu za novododani dokument, ali služi i za raèunanje broja sljedeæeg dokumenta --->
                            <input id="id_vrsteDokumenta" name="id_vrsteDokumenta" type="hidden" value="<?php echo $idvrstedokumenta->vd_id; ?>" />
                            <table>
                                <tr>
                                    <td>     
                                        <input type="text" class="form-control" id="broj_ponude" name="broj_ponude" value="<?php echo isset($id)?  $object->do_broj : $broj_dokumenta->broj; ?>" disabled="disabled"/>
                                    </td>   
                                    
                                </tr>
                            </table> 
                            </div>
                    </div> 
                    
                    <div class="form-group"> 
                        <label class="col-lg-2 control-label" for ="nacin_placanja">Na&#269;in pla&#263;anja</label>
                            <div class="col-lg-4">                                
                                 <select id="nacin_placanja" name="nacin_placanja">
                                    <?php foreach ($sredstvoplacanja as $v){    ?>
                                        <option value="<?php echo $v->sp_id; ?>" <?php if(isset($id)){if($v->sp_id==$object->sredstvoplacanja_sp_id){ ?> selected="selected" <?php }} ?>><?php echo $v->sp_opis; ?></option>
                                    <?php } ?>
                                </select>
                            </div>     
                    </div> 
                    
                     <div class="form-group has-feedback">      
                        <label class="col-lg-2 control-label"></label>
                            <div class="col-lg-2">
                                  <button class="btn btn-default btn-label-left" id="ponuda_dodatno"><span><i class="fa fa-arrows-v fa-fw"/></span>Otvori dodatno</button>
                            </div>
                     </div> 

    
                    <div  id="dodatno_ponuda" class="form"  style="display: none;"> 
                        <h3 class="page-header"></h3>
                        <div class="form-group has-feedback">  
                            <label for="datum_valuta" class="col-lg-2 control-label">Vrijedi do:</label>
                            <div class="col-lg-2">  
                                <input type="text" id="datum_valuta" class="form-control" name="datum_valuta" placeholder="npr. 01.01.2014." value="<?php echo isset($id)? date("d.m.Y.", strtotime($object->do_valuta)): date("d.m.Y."); ?>"/>
                                <span class="fa fa-calendar form-control-feedback"/>
                            </div>
                        </div>
                       
     
                        <div class="form-group">  
                        <label for="mjesto" class="col-lg-2 control-label">Mjesto izdavanja</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" id="mjesto" name="mjesto" value="<?php echo isset($id)? $object->do_mjestoizdavanja : $this->session->userdata('firma_mjesto'); ?>"/>

                            </div>
                        </div> 
                        
                        
                        <?php if(isset($id)){ ?>
                        <div class="form-group">  
                        <label class="col-lg-2 control-label">Dokument izradio/la</label>
                            <div class="col-lg-3 ">
                                <input type="text" class="form-control" name="izradio" value="<?php echo isset($id)? $table->operater .' / ' .date("d.m.Y. H:i", strtotime($table->do_datumizmjene)): ''; ?>" readonly ="readonly"/>
                            </div>
                        </div>
                        <?php } ?>  
                        
                        <div class="form-group">  
                        <label for="napomena" class="col-lg-2 control-label">Napomena</label>
                            <div class="col-lg-3">
                                <textarea type="text" maxlength="255" class="form-control" id="napomena" name="napomena"><?php if(isset($id)){echo $object->do_napomena;} ?></textarea>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">  
                        <label for="osoba" class="col-lg-2 control-label">Prima na ruke</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" id="osoba" name="osoba" value="<?php if(isset($id)){echo $object->do_osoba;} ?>"/>
                            </div>
                        </div>

                        <div >
                
                </fieldset>
                

                    <div id="stavkePonuda">
                    <!-- ovdje se loadaju stavke ponude iz vanjske skripte -->
                    </div>  

                 
                    <div class="form-group">  
                    <h3 class="page-header"></h3>     
                        <div class="col-sm-offset-3 bs-example">
                            <div class="col-sm-6">
                                <button id="spremi" type="submit" class="btn btn-primary">Spremi</button> 
                                <button type="reset" class="btn btn-default close-link1">Odustani</button>
                            </div>
                        </div>                           
                    </div>
             </form>
            
        </div><!--kraj sadržaja forme-->
    
    </div> <!--kraj box-->  

   
</div>     

<!--Kraj #forma div.a-->

<script type="text/javascript"> 
$(document).ready(function() { 


     $('#pdv')
        .trigger('change'); 
       
        
     $(window).keydown(function(event){
     if(event.keyCode == 13) {
         event.preventDefault();
         return false;
         }
     });
     
     $("#partner").on('change', function(e) {
    // Access to full data
       e.preventDefault();
       var test = $('#partner');
       var ID = $(test).select2('data').id;
       var text = $(test).select2('data').text;

        if(ID == text)
        {
            //ako su jednaki znaci da je korisnik upisao nekog kupca koji nije u bazi
            //omoguci korisniku da doda podatke o partneru koji æe biti dostupni samo ovaj put
            $('#dodatnoPartner').show();
        }
        else
        {
            $('#dodatnoPartner').hide();
            $('#dodatno_partner_unos').hide();
        }
    });
     
    $('#poslovni_prostor')
        .trigger('change');     
        
  
    $( "#ponuda_dodatno").click(function(evnt) {
     
     evnt.preventDefault();
     
     if($("#dodatno_ponuda").is(":visible"))
     {
        $("#dodatno_ponuda").hide("slow"); 
        $("#ponuda_dodatno").html('<span><i class="fa fa-arrows-v fa-fw"/></span>Otvori dodatno'); 
     }
     else
     {
        $("#dodatno_ponuda").show("slow"); 
        $("#ponuda_dodatno").html('<span><i class="fa fa-arrows-v fa-fw"/></span>Zatvori dodatno'); 
     }    
     }); 
     
     
     $( "#dodatnoPartner").click(function(evnt) {
     
     evnt.preventDefault();
     
     if($("#dodatno_partner_unos").is(":visible"))
     {
        $("#dodatno_partner_unos").hide(); 
     }
     else
     {
        $("#dodatno_partner_unos").show(); 
     }
                      
    });       
        
    $('#datum, #datum_valuta,#datum_isporuke').datepicker($.extend({
      showMonthAfterYear: false,
      dateFormat:'d MM, y',
      changeMonth: true,
      changeYear: true, 
      yearRange: '-60:+10',
      autoclose: true,
      showButtonPanel: true
    },
    $.datepicker.regional['hr']
  ));    
  
  
  $('#vrijeme').timepicker();    
  
    
   //podešavanje trenutnog datum i vremena 
  //$('#vrijeme').timepicker('setTime', new Date());
  //$('#datum').timepicker('setDate', new Date());
     

     LoadSelect2Script(DemoSelect2);    
     LoadBootstrapValidatorScript(FormValidator);      
     
     
    $('.close-link1').click(function (event) {     
        
        idvrstedok = $("#id_vrsteDokumenta").val();       
        
        // osvježiti tablicu prilikom zatvaranja forme za unos i editiranje
        $.post("<?php echo site_url().'administracija/vrati/dokument'; ?>",{id:idvrstedok}, function(data) {
                if (data != 'false') {

                $('#ajax-content').empty();
                $('#ajax-content').html(data);                  
                $('#ajax-content').show();

                 CloseModalBox();
                }
               
               
        });  
        
        $('#tablica').show();
        document.getElementById("ponudaForm").reset();  

        $('#forma').hide();

        $('#tablica tbody tr:eq(0)').click();
      
     }); 
     
     
      $('#spremi').click(function(evnt){
                    
          //provjeri postoji li barem jedna stavka u tablici dodana
          
          //sakrij red za upozorenje o praznim stavkama da ga ne broji
          $('#nemastavki').hide();
           var rowCount = $('#stavke tbody tr:visible').length;
           $('#nemastavki').show();
           var visible = $("#novastavka").is(":visible");
           

           /* if(rowCount > 0 && visible == false)
            { */
            
          //zapisujem ID naplatnog uredjaja sam u sebe na submit jer ga iz nekog razloga ne pokupi s forme  
          var naplatni = $('#naplatni_uredjaj');
          var ID = $(naplatni).select2('data').id;
          $('#naplatni_uredjaj').val(ID);
          
          evnt.preventDefault();   
            
           var test = $('#partner');
           var ID = $(test).select2('data').id;
           var text = $(test).select2('data').text;
    
            if(ID == text)
            {
                $('#partnerID').val('');
                $('#partnernaziv').val(text);
                
            }
            else
            {
                $('#partnerID').val(ID);
                $('#partnernaziv').val(text);
            } 
            
            
            $('#spremi').attr("disabled", true); 
            $('.preloader').show();
        
            
            
           
          $.post("<?php echo site_url().'dokument/process_form/dokument'; ?>",
            
            $("#ponudaForm").serialize(),
            
            function (data) {
            
            var obj = $.parseJSON(data);

            if (obj.uspjelo == 0)
            {   
                //$('#poruka').html(obj.poruka); //Add the AJAX response to some div that is going to show the message
                $('.preloader').hide();
            }
            else
            {
                $("#dodatno_ponuda").hide("slow"); 
                $("#dodatno_partner_unos").hide("slow");
               
                $('.preloader').hide(); 
                $('#poruka').html(obj.poruka);
                $('#poruka').show(); 
                    setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                    }, 10000);
                    
                    $('#spremi').attr("disabled", false); 
                    
                    if(obj.IDzag)
                    {
                        $("#id").val(obj.IDzag);
                    }
                    
                $.post("<?php echo site_url().'dokument/prikaziStavke'; ?>",{id: $("#id").val()}, function(data) {
                    if (data != 'false') {
                        $('#stavkePonuda').empty();
                        $('#stavkePonuda').html(data); 
                        $('#spremi').html("Spremi i ispi&#353;i");
                    }
                });
                

                if(rowCount > 0)
                {
                    //dohvati pdf i prikazi ga na view report
                    //posalji id dokumenta i id partnera ako postoji
                    id = $('#id').val();
                    idvrstaDok = $('#id_vrsteDokumenta').val();
                    $('.preloader2').show();    

                     $.post("<?php echo site_url().'dokument/prikaziizvjestaj'; ?>",{id:id, idvrstaDok:idvrstaDok}, function(data) {                                            
                        if (data != 'false') {
                            $('#forma').empty();
                            $('#forma').html(data); 
                        }
                    });
 

                }
                
            }
        });
            
            /*}
            else
            {
                alert("Morate dodati barem jednu stavku!!");
                evnt.preventDefault();
            }*/
    }); 
      
    
});   
 

function DemoSelect2(){
    //$('#s2_with_tag').select2({placeholder: "Odaberite"});
    //$('#s2_country').select2(); 
    
    $('#nacin_placanja').select2({minimumResultsForSearch: -1});

    
    //popunjavanje inputa za partnera
    $("#partner").select2({
         //minimumInputLength:1,
         maximumInputLength: 50,
         //placeholder: "Odaberite partnera",
         allowClear: true,
         createSearchChoice:function(term, data) { if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {return {id:term, text:term};} },
            multiple: false,
            data: [
                 <?php foreach ($partneri as $v){    ?>
                 {
                   id:   '<?php echo $v->pa_id; ?>',
                   text: '<?php echo $v->pa_naziv; ?>'
                 },
                                                 
                 <?php } ?>
             
             ],

         initSelection: function (element, callback) {      

            callback({ id:  '<?php if(isset($id)){echo $object->Partner_pa_id;}?>', text: '<?php if(isset($id)){if($object->partner){ echo $object->partner;}else{echo $object->pa_naziv;}} ?>' });    
         }
        });   
    }
    
</script>