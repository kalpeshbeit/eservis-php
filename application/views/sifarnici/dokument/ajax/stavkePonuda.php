<div  id="stavkePonuda">	
      
		<label>Stavke dokumenta:</label></br>
        <button id="dodajStavku" class="btn btn-default  btn-label-left hidden-xs hidden-sm" ><span><i class="fa fa-pencil fa-fw"/></span>Dodaj</button>
        <button id="urediStavku" disabled="disabled" class="btn btn-default btn-label-left hidden-xs hidden-sm"><span><i class="fa fa-edit fa-fw"/></span>Uredi</button>
        <button id="brisiStavku" disabled="disabled" class="btn btn-default btn-label-left hidden-xs hidden-sm"><span><i class="fa fa-edit fa-fw"/></span>Bri&#353;i</button>
    
    <form id="ponudaFormStavke" method="post" action="" class="form-horizontal">  
        <input id="idzag" name ="idzag" type="hidden"  value="<?php if(isset($idZaglavlja)){echo $idZaglavlja;} ?>"/>
        <input id="id_odabrana_stavka" name ="id_odabrana_stavka" type="hidden"  value=""/>
        <input id="index" name ="index" type="hidden"  value=""/>
        <table  class="table table-bordered  table-heading" id="stavke"> 
				<thead>
					<th>#</th> 
                    <th>Naziv / opis</th>
                    <th>Kolicina</th>
                    <th>Jmj</th>
                    <th>Cijena</th>
                    <th>Popust (%)</th>
                    <th>PDV (%)</th>
                    <th class="hidden-xs hidden-sm">Iznos</th>
                    <th class="hidden-xs hidden-sm">PDV iznos</th>
				</thead>

                <tbody> 
                        
                    <?php if (!empty($stavke)) {  ?>                
                        <?php  $rank = 0; foreach ($stavke as $stavka) { ?>
                        <tr id="<?php echo $stavka->sd_id ?>" class="oddrow clickable">
                            <td><?php echo ++$rank; ?>.</td>
                            <td><?php if($stavka->naziv){echo $stavka->naziv;} else {echo $stavka->ar_naziv;} ?></td>
                            <td><?php echo $stavka->sd_kolicina; ?></td>
                            <td><?php echo $stavka->JedinicaMjere_jm_sifra; ?></td>
                            <td><?php echo number_format($stavka->sd_cijenabruto, 2, ',', '.') ?></td>
                            <td><?php echo $stavka->sd_popust; ?></td>
                            <td><?php echo $stavka->porez_pz_posto; ?></td>
                            <td class="hidden-xs hidden-sm"><?php echo number_format($stavka->sd_iznosneto, 2, ',', '.'); ?></td>
                            <td class="hidden-xs hidden-sm"><?php echo number_format($stavka->sd_poreziznos, 2, ',', '.'); ?></td>
                        </tr>
                        <?php } ?>         
                        <?php }else{ ?>
                            
                            <tr id="nemastavki">
                                <td style="text-align: center;" colspan="9">Nemate dodanih stavki</td>
                            </tr>
                            
                        <?php   
                        } ?>            
                        
                        <tr id="novastavka" style="display: none;" class="oddrow clickablestavka clickable">
                        
                            <td style="min-width: 130px;">
                                <button  title="Spremi" class="btnstavka btn-default" id="spremistavku">Spremi</button>
                                <button type="reset" title="Odustani" class="btnstavka btn-default" id="odustani"><span><i class="fa fa-times fa-fw"/></span></button>
                            </td>
     
                             <td style="max-width: 200px;">  
                                <input id="artikl" name="artikl"  placeholder="<?php if(!isset($id)){echo "Odaberite artikl";} ?>"/> 
                                <input type="hidden"  id="artiklID" name="artiklID" value=""/> 
                                <input type="hidden"  id="artiklnaziv" name="artiklnaziv" value=""/> 
                                <textarea <?php if(isset($id)){if($object->Artikl_ar_id){echo 'style="display:none;overflow:auto;resize:none"';} else{ echo 'style="overflow:auto;resize:none"';}}else {echo 'style="display: none;overflow:auto;resize:none;"';}?>  placeholder="Dodatni opis artikla" id="opis"  name="opis" class="form-control" ><?php if(isset($id)){echo $object->ar_dodatniopis;} ?></textarea>
                             </td>
                             
                             <td  style="min-width: 80px;">
                                <input type="text" class="form-control" onpaste="return false;" onkeydown="provjeri(this);" name="kolicina" id="kolicina" value="1.00" />
                             </td>
                             
                             <td style="min-width: 100px;">  
                                  <select class="form-control" name="jedinicamjere" id ="jedinicamjere">
                                 <?php foreach ($mjere as $v){    ?>
                                 <option value="<?php echo $v->jm_sifra; ?>" <?php if(isset($id)){if($v->jm_sifra==$object->JedinicaMjere_jm_sifra){ ?> selected="selected" 
                                 <?php }} ?>><?php echo $v->jm_sifra; ?></option>
                                                             
                                 <?php } ?>
                                </select>
                             </td>
                             
                             <td style="min-width: 100px;">
                                <input type="text" class="form-control" onpaste="return false;" onkeydown="provjeri(this);" name="cijena" id="cijena" value="" />
                             </td>
                             
                             <td style="min-width: 80px;">
                                <input type="text" class="form-control" onpaste="return false;" onkeydown="provjeri(this);" name="popust" value="0.00" />
                             </td>
                             
                             <td style="min-width: 110px;">  
                                <select class="form-control" name="pdv" id="pdv" onchange="dohvatisifruporeznestope(this);">
                                 <?php foreach ($porezi as $v){    ?>
                                 <option value="<?php echo $v->PZ_POSTO; ?>" <?php if(isset($id)){if($v->pz_posto==$object->porez_pz_posto){ ?> selected="selected" <?php }} ?>><?php echo $v->PZ_POSTO; ?></option>
                                                             
                                 <?php } ?>
                                </select>
                             </td>
                             <input id="pdvsifra" type="hidden"  value=""/>    
                        </tr>
                          
                        
                            
               </tbody>
                
        </table>
        
        <?php 
        
        if(isset($idZaglavlja))
        {
         ?>  
           <div style="margin-left: 70%; width: 20%;">
            
                <table style="width: 100%;">
                <tbody>
                     <tr>
                        <td>UKUPNO:</td>
                        <td style="text-align: right;"><?php if(isset($sume)){echo number_format($sume->sumaIznos + $sume->sumaPopust, 2, ',', '.');} ?></td>
                    </tr>
                    <tr>
                        <td>IZNOS POPUSTA:</td>
                        <td style="text-align: right;"><?php if(isset($sume)){echo number_format($sume->sumaPopust, 2, ',', '.');} ?></td>
                    </tr>
                    <tr>

                        <td>OSNOVICA:</td>
                        <td style="text-align: right;"><?php if(isset($sume)){echo number_format($sume->sumaIznos, 2, ',', '.');} ?></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #000; border-top:  1px solid #000;;">
                        <td>PDV:</td>
                        <td style="text-align: right;"><?php if(isset($sume)){echo number_format($sume->sumaPorez, 2, ',', '.');} ?></td>
                    </tr>
                    <tr style="font-weight: bold; font-size: 1.2em;">
                        <td>IZNOS KN:</td>
                        <td style="text-align: right;"><?php if(isset($sume)){echo number_format($sume->sumaIznos + $sume->sumaPorez, 2, ',', '.');} ?></td>
                    </tr>
                </tbody>
                </table>
            </div> 
            
        <?php    
        }
        ?>

     </form>  
    
</div> <!-- .field-group -->



<script type="text/javascript">  


$(document).ready(function() {
$('#pdv')
    .trigger('change');   
     
$("#artikl")
    .on("change", function(e) 
    { 
        //dohvati cijenu, porez i jedinicu mjere odabranog artikla
        //ukoliko nije upisan proizvoljno ili je prazan
        
        var test = $('#artikl');
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
                    //ne popunjavaj pdv sa nekom od stopa ako nisi u sustavu pdv.a
                    
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
        
        

    $(".clickable").click(function() {  
        if($("#novastavka").is(":visible"))
        {
            if($("#id_odabrana_stavka").val() != "novastavka")
            {
                  if($("#novastavka").is(":visible") == 'false' || $("#uredjivanje").val() != 1)  
                  {       
                        $(".clickable").removeClass("active"); 
                        $(this).addClass("active");     
                        $('#brisiStavku').prop("disabled", false);
                        $('#urediStavku').prop("disabled", false); 
                  } 
            }
        }
        else
        {
            if($("#novastavka").is(":visible") == 'false' || $("#uredjivanje").val() != 1)  
            {       
                    $(".clickable").removeClass("active"); 
                    $(this).addClass("active");     
                    $('#brisiStavku').prop("disabled", false);
                    $('#urediStavku').prop("disabled", false); 
            } 
        }  
            
            
  });
  
    LoadSelect2Script(DemoSelect2);

  
    $('#stavke tr').click(function (event) {
                      
            if($("#novastavka").is(":visible"))
            {
                if($("#id_odabrana_stavka").val() != "novastavka")
                {
                      if($("#novastavka").is(":visible") == 'false' || $("#uredjivanje").val() != 1)  
                      {       
                            $("#id_odabrana_stavka").val($(this).attr('id'));
                            $("#index").val($(this).index()+1);          
                      } 
                }
            }
            else
            {
                  if($("#novastavka").is(":visible") == 'false' || $("#uredjivanje").val() != 1)  
                      {       
                            $("#id_odabrana_stavka").val($(this).attr('id'));
                            $("#index").val($(this).index()+1);          
                      } 
            }  

     });    
     

    
    $('.close-link').click(function (event) {       
        CloseModalBox();
    });
    
    
    
    $('#stavke tbody tr:eq(0)').click();       
});

 

$('#dodajStavku').click(function(evnt){
        
    if($('#status').val() != "Z" && $('#status').val() != "S")
    {
          //loadaj isto samo na kraju loadaj praznu formicu za unos 

          evnt.preventDefault();   
          
          //provjeri da li se dodaje novi dokument sa stavkama ili editira postojeci
          //identifikator je ID dokumenta
          id = $("#id").val();

          if(id != "")
          {
                if($("#novastavka").is(":visible"))
                {
                     //nista ne raid
                }
                else
                {

                    $.post("<?php echo site_url().'dokument/prikaziStavke'; ?>",{id:id}, function(data) {
                        if (data != 'false') { 

                           
                            $('#stavkePonuda').empty();
                            $('#stavkePonuda').html(data);
                            $('#nemastavki').hide();
                            $("#novastavka").show("slow"); 
                            $('#stavke tbody tr:last').click();   
    
                        }
                    });
                }
           
          }
          else
          {
              //provjeri da li je veæ otvorena forma za unos
              if($("#novastavka").is(":visible"))
              {
                  
              }
              else
              {
              
                $("#novastavka").show("slow"); 
                $('#stavke tbody tr:last').click();       
              }      
          }
    } 
    else
    {
         evnt.preventDefault();   
    } 
        
       
         
}); 

$('#urediStavku').click(function(evnt){
       
    if($('#status').val() != "Z" && $('#status').val() != "S")
    {
          idzag = $("#idzag").val();
          id = $("#id_odabrana_stavka").val(); 
          evnt.preventDefault();   


    var rowCount = $('#stavke tbody tr:visible').length;
    var visible = $("#novastavka").is(":visible");
           
    //provjeri da nije otvoren dialog za dodavanje te takoðer da je stavka odabrana (kliknuta)
        if(rowCount > 0 && visible == false && $("#id_odabrana_stavka").val() != "novastavka")
        {
            
            
        } 
            
          if($("#novastavka").is(":visible"))
          {
                       
           //ništa ne radi

          }
          else
          {
            if($("#uredjivanje").val() != 1 && $("#id_odabrana_stavka").val() != "novastavka")
            {

             $.post("<?php echo site_url().'dokument/dodajStavku'; ?>",{id:id, idzag:idzag}, function(data) {

                if (data != 'false') {   

                    $("#uredjivanje").val("1"); 
                    index = $("#index").val();
                    $("#stavke").find("tr").eq(index).html(data);   
  
                    $("#stavke").find("tr").eq(index).addClass("actives");   
                    $("#stavke").find("tr").eq(index).click();      
                                      
                      
                }
           }); 
               
          } 
          
          }         
          
    } 
    else
    {
         evnt.preventDefault();   
    }  
         
});

$('#brisiStavku').click(function(evnt){
      

    if($('#status').val() != "Z" && $('#status').val() != "S")
    {
        //provjeri  postoji li barem jedan artikl u tablici
    evnt.preventDefault();
    var rowCount = $('#stavke tbody tr:visible').length;
    var visible = $("#novastavka").is(":visible");
           
    //provjeri da nije otvoren dialog za dodavanje te takoðer da je stavka odabrana (kliknuta)
        if(rowCount > 0 && visible == false && $("#id_odabrana_stavka").val() != "novastavka")
        { 

            var header = 'Brisanje stavke dokumenta';
                                                     
            var form = $('<div class="form-group"><label">&#381;elite obrisati odabranu stavku?</label></div>'+
            '<div class="form-group">'+
            '<button id="delete" type="delete" onclick="obrisistavku()" class="btn btn-danger btn-label-left">'+
                                '<span><i class="fa fa-trash-o"></i></span>'+
                                'Obri&#353;i</button>'+' '+                       
                                '<button id="cancel" onclick="cancel()" class="btn btn-default btn-label-left">'+
                                '<span><i class="fa fa-reply txt-danger"></i></span>'+
                                'Odustani'+
                                '</button></div>');
                
            OpenModalBox(header, form);
        } 
    } 
    else
    {
         evnt.preventDefault();   
    } 
   
}); 



function obrisistavku(id)
{
    $('.preloader').show();
    
    id = $("#id_odabrana_stavka").val();       
    idzag = $("#idzag").val();
    $.post("<?php echo site_url().'administracija/brisanje/stavkedokumenta'; ?>", {id:id, idzag:idzag}, function(data) {
        if (data != 'false') {
            var obj = $.parseJSON(data);

            $('.preloader').hide(); 

            $.post("<?php echo site_url().'dokument/prikaziStavke'; ?>",{id:idzag}, function(data) {
                if (data != 'false') {   
                    //index = $("#index").val();
                    $('#stavkePonuda').empty();
                    $('#stavkePonuda').html(data);
                    //$('#stavke tr').eq(index).click(); 
                    CloseModalBox();
                    
                    $('#poruka').html(obj.poruka);
                    $('#poruka').show();
                    setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                    }, 5000);
                         
                }
            });    
        }
    }); 
}


$('#odustani').click(function(evnt){
      
        $("#novastavka").hide();
        document.getElementById("ponudaFormStavke").reset(); 
        $("#artikl").select2("val", ""); 
        $('#nemastavki').show("slow");

}); 


$('#spremistavku').click(function(evnt){
          
      evnt.preventDefault();   
          
      id = $("#id").val(); 
         
      if(id != "")
      {
          //spremi stavku za taj dokument
          
           var test = $('#artikl');
           var ID = $(test).select2('data').id;
           var text = $(test).select2('data').text;
           var sifra =  $("#pdvsifra").val();   
                        
            if(ID == text)
            {
                $('#artiklID').val('');
                $('#artiklnaziv').val(text);
            }
            else
            {
                $('#artiklID').val(ID);
                $('#artiklnaziv').val(text);
            } 
          
          //provjeri postoji li id stavke onda update napravi   
          
          $.post("<?php echo site_url().'dokument/process_form_stavka/stavkedokumenta'; ?>",
            $("#ponudaFormStavke").serialize() +'&pdvsifra='+ sifra,
        
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
                  
                    
                      $.post("<?php echo site_url().'dokument/prikaziStavke'; ?>",{id:id}, function(data) {
                            if (data != 'false') {   
                                //index = $("#index").val();
                                $('#stavkePonuda').empty();
                                $('#stavkePonuda').html(data);
                                //$('#stavke tr').eq(index).click(); 
                                
                                $("#novastavka").show("slow"); 
                                $('#stavke tbody tr:last').click();
                                 
                                $('#poruka').html(obj.poruka);
                                $('#poruka').show();
                                setTimeout(function() {
                                $('#poruka').fadeOut('fast');
                                }, 5000);        
                            }
                        });    

                }
        });

      }
    
}); 


function DemoSelect2(){
    //$('#s2_with_tag').select2({placeholder: "Odaberite"});
    //$('#s2_country').select2(); 
        
    
    //popunjavanje inputa za partnera
    $("#artikl").select2({
         //minimumInputLength:1,
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

            callback({ id:  '<?php if(isset($id)){echo $object->Artikl_ar_id;}?>', text: '<?php if(isset($id)){echo $object->ar_naziv;} ?>' });
         }
   
        }); 
        
        
}


 function dohvatisifruporeznestope(that)
 {
    //dohvati sifru pdv.a
 
        $.post("<?php echo site_url().'dokument/getPorezneStopeSifra'; ?>", {posto: that.value}, function(data) {
             
             var obj = $.parseJSON(data);
             
             if (data != 'false') {   
                $('#pdvsifra').val(obj.pzs_sifra); 

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
