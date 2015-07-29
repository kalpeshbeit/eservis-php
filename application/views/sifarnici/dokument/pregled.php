<!--poèetak #ajax-content--> 
 
 <div class="row"><!--Poèetak navigacije-->
    <div id="breadcrumb" class="col-xs-12">
        <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>">Po&#269;etna</a></li>
        <li><a href="#">Ra&#269;uni i ponude</a></li>   
        <li><a href="#"><?php echo (isset($vrstaDokumenta)) ? $vrstaDokumenta->vd_opis : 'Dokument' ?></a></li>
        </ol>
    </div>
 </div><!--Kraj navigacije-->
 
 
 <!--<div class="row show-grid-forms"><!--Poèetak naziva trenutne stranice
    <div class="col-sm-4">
        <h3 class="page-header"><?php echo (isset($vrstaDokumenta)) ? $vrstaDokumenta->vd_opis : 'Dokument' ?></h3>
    </div>               
 </div><!--kraj naziva trenutne stranice-->
<!-- <div class="alert alert-info">Dovrsite racun provjerom odabirom prodajnog mjesta i naplatnog uredaja te ga zakljucite!</div> -->

<div id="forma" class="row" style="display: none;"/> 
            
<div class="row" id="tablica"><!--Poèetak tablice s podacima-->     
    <div class="col-xs-12">
    <p> <div id="poruka"><!--Poèetak diva poruke o uspjehu pohrane/izmjene podataka-->
            </div><!--Kraj poruke o uspjehu--></p>
      
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-file-text"></i>
                    <span><?php echo (isset($vrstaDokumenta)) ? $vrstaDokumenta->vd_opis : 'Dokument' ?></span>
                    
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div><!--End header-->
            <div class="box-content no-padding"><!--Poèetak podataka-->
                <table class="table table-bordered table-striped table-heading table-datatable" id="datatable-33">
                    <thead>
                        <tr>
                            <th><?php echo (isset($vrstaDokumenta)) ? $vrstaDokumenta->vd_opis : 'Dokument' ?> broj</th>
                            <th>Tvrtka</th>                       
                            <th>Datum izrade</th>
                            <th>Iznos</th>
                            <th class="hidden-xs">Djelatnik</th>
                           
                            <?php if($vrstaDokumenta->vd_oznaka == "racun"){?>     
                            <th>Pla&#263;eno</th> 
                            <th>Fiskaliziran</th>                             
                            <?php } ?>
                            <th class="hidden-xs">Status</th>      
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                    <!-- Start: list_row -->
                        <?php 

                            $rank = 0; foreach ($table as $dokument) {?>
                                <tr class="oddrow clickable" id="<?php echo $dokument->do_id; ?>" <?php if ($dokument->do_status == "S") {echo 'style="color: red";';} ?>>
                                    <td><?php if($dokument->do_broj == 0){echo "";} else { if($vrstaDokumenta->vd_oznaka == "ponuda") { echo $dokument->do_broj;}else{echo $dokument->do_broj. ' / '.$dokument->PP. ' / '.$dokument->NU;}} ?></td>
                                    <td><?php if($dokument->partner) {echo $dokument->partner;} else {echo $dokument->pa_naziv;} ?></td>
                                    <td><?php echo isset($dokument->do_datum)? date("d.m.Y.", strtotime($dokument->do_datum)):''; ?></td>
                                    <td><?php echo  number_format((float)$dokument->do_iznos + $dokument->do_iznosPDV, 2, ',', '.') ?></td>
                                    <td class="hidden-xs"><?php echo $dokument->operater; ?></td>
            
                                    <?php if($vrstaDokumenta->vd_oznaka == "racun"){?>     
                                    <td><?php if($dokument->do_placeno == 1){echo 'Da';}else{echo 'Ne';}; ?></td>
                                    <td><?php if($dokument->do_jir){echo 'Da';}else{echo 'Ne';}; ?></td>
                                    <?php } ?>
                                     
                                    <td class="hidden-xs"><?php echo $dokument->do_status; ?></td> 
                                    <input id="broj<?php echo $dokument->do_id; ?>" type="hidden"  value="<?php echo $dokument->do_broj; ?>"/>       
                                </tr>                                
                            <?php } ?>
                                
                    <!-- End: list_row -->
                    </tbody> 

                </table>
                
                <input id="id_odabran" type="hidden"  value=""/>               
                
            </div><!--kraj podataka-->
        </div><!--kraj box-->
    </div>
</div><!--kraj tablice s podacima-->


<!--End #ajax-content-->


<script type="text/javascript">
// Run Datables plugin and create 3 variants of settings


$(document).ready(function() {   
    
    $(".dataTables_filter").append('');
    
    LoadDataTablesScripts(AllTables); 
     
    $(".clickable").click(function() { 

        $(".clickable").removeClass("active"); 
        $(this).addClass("active");     
        $('#brisi').prop("disabled", false);
        $('#uredi').prop("disabled", false);
        $('#storno').prop("disabled", false);
        $('#ispis').prop("disabled", false);
        $('#ispisSkini').prop("disabled", false);
        $('#racun').prop("disabled", false);
  });
  
    $('#datatable-33 tr').click(function (event) {       
          $("#id_odabran").val($(this).attr('id'));
     });    
                   

    
    $('.close-link').click(function (event) {       
        CloseModalBox();
    });  
    
                                  
});



function AllTables(){
    TestTable33();  
        
   $('.dataTables_filter').each(function(){
        $(this).find('label input[type=search]').attr('placeholder', 'PretraÅ¾i');   
        $(this).find('label input[type=text]').attr('placeholder', 'PretraÅ¾i');
    });
    
    
    $(".dataTables_filter").append('&nbsp&nbsp&nbsp<button class="btn btn-default  btn-label-left hidden-xs hidden-sm" onclick="dodaj(<?php echo $vrstaDokumenta->vd_id; ?>);" ><span><i class="fa fa-pencil fa-fw"/></span>Dodaj</button>&nbsp');
    
    $(".dataTables_filter").append('<button id="uredi" disabled="disabled" class="btn btn-default btn-label-left hidden-xs hidden-sm" onclick="uredi();" ><span><i class="fa fa-edit fa-fw"/></span>Uredi</button>');
    
    $(".dataTables_filter").append('<?php if ($vrstaDokumenta->vd_racun_iz_ponude == 1) echo '&nbsp<button id="racun"  disabled="disabled" class="btn btn-default btn-label-left hidden-xs hidden-sm" onclick="dodajRacunPonuda();" ><span><i class="fa fa-file-text fa-fw"/></span>Ra&#269;un</button>' ?> ');
    
    $(".dataTables_filter").append('<button id="ispisSkini" disabled="disabled" class="btn btn-default btn-label-left hidden-md hidden-lg" onclick="ispisSkini(<?php echo $vrstaDokumenta->vd_id; ?>);" ><span><i class="fa fa-print fa-fw"/></span>Preuzmi PDF</button>&nbsp');      
    
    $(".dataTables_filter").append('<button id="ispis" disabled="disabled" class="btn btn-default btn-label-left hidden-xs hidden-sm" onclick="ispis(<?php echo $vrstaDokumenta->vd_id; ?>);" ><span><i class="fa fa-print fa-fw"/></span>Ispis</button>&nbsp');  
                                                                                                        
    $(".dataTables_filter").append('<button id="brisi" disabled="disabled" class="btn btn-default btn-label-left txt-danger hidden-xs hidden-sm" onclick="brisi();" ><span><i class="fa fa-trash-o txt-danger"/></span>Bri&#353;i</button>&nbsp');
    
    $(".dataTables_filter").append('<?php if ($vrstaDokumenta->vd_racun_iz_ponude == 0) echo '<button id="storno" disabled="disabled" class="btn btn-default btn-label-left txt-danger hidden-xs hidden-sm" onclick="storno();" ><span><i class="fa fa-times txt-danger"/></span>Storno</button>&nbsp'?>');
    
    $('#datatable-33 tbody tr:eq(0)').click();      
    
}


function brisi()
{  
    //alert($("#id_odabran").val());
    <?php 
    //ako je racun onda dozvoli brisanje samo nezakljucenih
    if($vrstaDokumenta->vd_id == 2)
    { ?>
        BrojOdabranogDokumenta = $('#broj'+$("#id_odabran").val()).val();

        if(BrojOdabranogDokumenta == 0)
        {
            var header = 'Brisanje dokumenta';

            var form = $('<div class="form-group"><label">&#381;elite obrisati odabrani dokument?</label></div>'+
            '<div class="form-group">'+                                         

            '<button id="delete" type="delete" onclick="obrisi(<?php echo $vrstaDokumenta->vd_id; ?>)" class="btn btn-danger btn-label-left">'+
                                '<span><i class="fa fa-trash-o"></i></span>'+
                                'Obri&#353;i</button>'+' '+                       
                                '<button id="cancel" onclick="cancel()" class="btn btn-default btn-label-left">'+
                                '<span><i class="fa fa-reply txt-danger"></i></span>'+
                                'Odustani'+
                                '</button>');
                
            OpenModalBox(header, form);
        }   
   <?php }
    else
    {   ?>
        //ako je ponuda dozvoli brisanje svega
        var header = 'Brisanje dokumenta';

        var form = $('<div class="form-group"><label">&#381;elite obrisati odabrani dokument?</label></div>'+
        '<div class="form-group">'+                                         

        '<button id="delete" type="delete" onclick="obrisi(<?php echo $vrstaDokumenta->vd_id; ?>)" class="btn btn-danger btn-label-left">'+
                            '<span><i class="fa fa-trash-o"></i></span>'+
                            'Obri&#353;i</button>'+' '+                       
                            '<button id="cancel" onclick="cancel()" class="btn btn-default btn-label-left">'+
                            '<span><i class="fa fa-reply txt-danger"></i></span>'+
                            'Odustani'+
                            '</button>');
            
        OpenModalBox(header, form);
    <?php }   ?>

    
}

function obrisi(id)
{   
    $('.preloader').show();

    
    idvrstedok = id;
    id = $("#id_odabran").val();       
    
    $.post("<?php echo site_url().'administracija/brisanje/dokument'; ?>", {id:id, idzag:id}, function(data) {
        if (data != 'false') {
            var obj = $.parseJSON(data);
       
            $('.preloader').hide();
        

           $.post("<?php echo site_url().'administracija/vrati/dokument'; ?>",{id:idvrstedok}, function(data) {
                    if (data != 'false') {
   
                    $('#ajax-content').empty();
                    $('#ajax-content').html(data);                  
                    $('#ajax-content').show(); 
                    
                   

                     CloseModalBox();
                    }
                    $('#poruka').html(obj.poruka); 
                    $('#poruka').show();    
                    setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                    }, 10000);                  
                   
                   
                });  
        }
    }); 
}

function dodaj(id)
{
     
    <?php 
        if($this->session->userdata('licenca_ispravna') == 1)
        { ?>
    //saljem ID dokumenta
    $('#tablica').hide();
  
    $.post("<?php echo site_url().'dokument/dodaj/dokument'; ?>",{id:id}, function(data) {
        if (data != 'false') {
            $('#forma').empty();
            $('#forma').html(data);
            $('#forma').show();
            
              
                    $('#poruka').html(obj.poruka); 
                    $('#poruka').show();    
                    setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                    }, 10000);

        } 
        else 
        {
        }
    });  
        <?php }    
    ?>
   
   
}






function cancel()
{
    CloseModalBox();  
}


function uredi()
{
    id = $("#id_odabran").val();
    
    $('#tablica').hide();

    $.post("<?php echo site_url().'dokument/uredjivanje/dokument'; ?>", {id:id}, function(data) {
        if (data != 'false') {
            $('#forma').empty();
            $('#forma').html(data);
            $('#forma').show();
            
            
            id = $("#id_odabran").val();

            $.post("<?php echo site_url().'dokument/prikaziStavke'; ?>",{id:id}, function(data) {
                if (data != 'false') {   
                    $('#stavkePonuda').empty();
                    $('#stavkePonuda').html(data);
                    
                    <?php if($vrstaDokumenta->vd_oznaka =="ponuda") {?>
                    //ako je ponuda prikazi btn za ispis
                    
                   $('#spremi').html("Spremi i ispi&#353;i");
                    
                    <?php }else {?>
                    
                    $('#spremi').hide();
                    $('#ispisi').show();                  
                    
                    <?php } ?>
                    
                    $('#poruka').html(obj.poruka);
                    $('#poruka').show();     
                    setTimeout(function() {
                    $('#poruka').fadeOut('fast');
                    }, 5000);
                    
                    
                }
             });
             
        } else {
        }
    });    
}


function ispis(idvrstaDok)
{
    //provjeri broj_odabranog i ako je 0 ne dozvoli ispis racuna jer nisu zavrseni
    BrojOdabranogDokumenta = $('#broj'+$("#id_odabran").val()).val();

    if(BrojOdabranogDokumenta != 0)
    {
        id = $("#id_odabran").val();
         
        //dohvati pdf i prikazi ga na view report
        //posalji id dokumenta i id partnera ako postoji

        $('.preloader2').show();    

            $.post("<?php echo site_url().'dokument/prikaziizvjestaj'; ?>",{id:id, idvrstaDok:idvrstaDok}, function(data) {                                            
                if (data != 'false') {
                    $('#tablica').hide();
                    $('#forma').empty();
                    $('#forma').html(data); 
                    $('#forma').show(); 
                }
            });
    }   
}

function ispisSkini(idvrstaDok)
{
    //provjeri broj_odabranog i ako je 0 ne dozvoli ispis racuna jer nisu zavrseni
    BrojOdabranogDokumenta = $('#broj'+$("#id_odabran").val()).val();

    if(BrojOdabranogDokumenta != 0)
    {
        id = $("#id_odabran").val();
         
        //dohvati pdf i prikazi ga na view report
        //posalji id dokumenta i id partnera ako postoji

        //$('.preloader2').show();    

        //$('#report').attr('src', "<?php echo site_url(); ?>dokument/pdfskiniMobilno/"+id+"/"+idvrstaDok+"/")
        
         window.location = "<?php echo site_url(); ?>dokument/pdfskiniMobilno/"+id+"/"+idvrstaDok+"";
    }   
}

function dodajRacunPonuda()
{
    var r = confirm("Zelite kreirati racun iz odabrane ponude?");
    if (r == true) 
    {
    // dohvati zaglavlje i spremi ga u bazu (uduplaj veæ postojeæe) sa statusom "I" te brojem racuna 0
     id = $("#id_odabran").val(); 
    
    $.post("<?php echo site_url().'dokument/racunizponude'; ?>",{id:id}, function(data) {
        if (data != 'false') {
            
            var obj = $.parseJSON(data);
             
             if(obj.uspjelo == "1")
             {

                 id = obj.id;

        
                $('#tablica').hide();

                $.post("<?php echo site_url().'dokument/uredjivanje/dokument'; ?>", {id:id}, function(data) {
                    if (data != 'false') {
                        $('#forma').empty();
                        $('#forma').html(data);
                        $('#forma').show();
                        
                        
                          id = $("#id_odabran").val(); 

                        $.post("<?php echo site_url().'dokument/prikaziStavke'; ?>",{id:id}, function(data) {
                            if (data != 'false') {   
                                $('#stavkePonuda').empty();
                                $('#stavkePonuda').html(data);
                                

                                
                                $('#spremi').hide();
                                $('#ispisi').show();                  
                                

                                
                                $('#poruka').html(obj.poruka);
                                $('#poruka').show();     
                                setTimeout(function() {
                                $('#poruka').fadeOut('fast');
                                }, 5000);
                                
                                
                            }
                         });
                         
                    } else {
                    }
                }); 
                } 

        } 
        else 
        {
            
        }
    });
    //pri spremanju vrati novi ID zaglavlja
    
    
    //dohvati stavke i spremi za generirani ID zaglavlja 
    
    
    // dodavanja/editiranje tog raèuna da se može nastaviti dodavati ili ukljanjati stavke te završiti
           
    }         
}


function storno()
{
    BrojOdabranogDokumenta = $('#broj'+$("#id_odabran").val()).val();

    if(BrojOdabranogDokumenta != 0)
    {
    //alert($("#id_odabran").val());
    
        var header = 'Storniranje dokumenta';

                                                 
        var form = $('<div class="form-group"><label">&#381;elite stornirati odabrani dokument?</label></div>'+
        '<div class="form-group">'+
        '<button id="storno" type="storno" onclick="storniraj(<?php echo $vrstaDokumenta->vd_id; ?>)" class="btn btn-danger btn-label-left">'+
                            '<span><i class="fa fa-trash-o"></i></span>'+
                            'Storniraj</button>'+' '+                       
                            '<button id="cancel" onclick="cancel()" class="btn btn-default btn-label-left">'+
                            '<span><i class="fa fa-reply txt-danger"></i></span>'+
                            'Odustani'+
                            '</button></div>');
            
        OpenModalBox(header, form);
    }
}



function storniraj(idvrstedok)
{
    
    
     id = $("#id_odabran").val();       
     $('.preloader2').show();
     

    //provjeri poslovni prostor
    
    
    
    //ako je poslovni prostor u redu storniraj

    $.post("<?php echo site_url().'dokument/storniraj'; ?>",{id:id}, function(data) {                                            
        if (data != 'false') {
             var obj = $.parseJSON(data);
             
             if(obj.status != "0")
             {
                   sp_id = obj.sp_id;
                   vd_id = obj.vd_id;
                   id = obj.id_novog;
                          
             $.post("<?php echo site_url().'dokument/dohvatiSredstvoPlacanja'; ?>",{id:sp_id}, function(data) {
                
                    var obj = $.parseJSON(data);
                    if (data != 'false') {
                       
                       if(obj.placeno == 1)
                       {
                            //fiskalizacija
                            $.post("<?php echo site_url().'fiskalizacija/fiskal'; ?>",{request: "RacunZahtjev", id: id}, function(data) { 
                                                               
                               //dohvati pdf i prikazi ga na view report
                                //posalji id dokumenta i id partnera ako postoji
                                                                                          
                                
                                $.post("<?php echo site_url().'dokument/prikaziizvjestaj'; ?>",{id:id, idvrstaDok:vd_id}, function(data) {
                                    if (data != 'false') {
                                        $('#tablica').hide();
                                        $('#forma').empty();
                                        $('#forma').html(data);                  
                                        $('#forma').show();  
                                         CloseModalBox();
                                    }
                                });
        
                        
                            }); 
                           
                       }    
                       else
                       {   
                            //alert(idvrstaDok);
                            $('.preloader2').show();    
                            
                            $.post("<?php echo site_url().'dokument/prikaziizvjestaj'; ?>",{id:id, idvrstaDok:idvrstaDok}, function(data) {
                                if (data != 'false') {   
                                      $('#forma').empty();
                                      $('#forma').html(data);                  
                                      $('#forma').show(); 
                                     CloseModalBox();
                                }
                            }); 
                       }
                      
                    }
                 });
             }
             else
             {
                 CloseModalBox();

                 $('.preloader2').fadeOut('slow');
                
                 $('#poruka').html(obj.poruka);
                 $('#poruka').show();
                    setTimeout(function() {
                        $('#poruka').fadeOut('slow');
                    }, 10000);
             }          
        }
    });

}

</script>
