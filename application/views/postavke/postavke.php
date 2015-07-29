
        
<!--Start Breadcrumb-->
    <div class="row">
        <div id="breadcrumb" class="col-xs-12">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url();?>">Po&#269;etna</a></li>  
                <li><a href="#">Postavke</a></li>
            </ol>
        </div>
    </div>
<!--End Breadcrumb-->
          
<!--Poèetak naziva trenutne stranice<div class="row show-grid-forms">
    <div class="col-sm-4">
        <h3 class="page-header">Postavke aplikacije</h3>
    </div>               
</div><!--kraj naziva trenutne stranice-->
           
<div class="row" id="tablica"><!--Poèetak tablice s podacima-->     
    <div class="col-xs-12"> 
    


    <fieldset>
    <div class="panel-body"> 

        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-file-text"></i>
                    <span>Upute za rad</span>                  
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>

            </div><!--End header-->
            <div class="box-content no-padding"><!--Poèetak podataka-->
            
                <div class="alert alert-info">
                     Koraci:<br/>
                     <ol>
                      <li>Potrebno je dodati poslovni prostor klikom na gumb "Dodaj"</li>
                      <li>Nakon toga potrebno je dodati barem jedan naplatni ure&#273;aj (kasa, blagajna) koji je vezan prodajno mjesto</li>
                      <li>Zatim dodati datoteku certifikata koju dobijete od FINA.e te upisati ispravnu lozinku</li>
                      <li>Prijaviti poslovni prostor klikom na gumb "Prijavi poslovni prostor"</li>
                      <li>Spremni ste za izradu svog prvog fiskalnog ra&#269;una!</li>
                     </ol>
                     
                     Dodatak:<br/>
                     <ul><li>Svaku naknadnu promjenu podataka poslovnog prostora (npr. radno vrijeme, adresa, zatvaranje) morate prijaviti poreznoj upravi klikom na gumb "Prijavi poslovni prostor"</li></ul>
                </div>
            </div>
        </div>    
            <div id="poruka"></div>
        <!-- Nav tabs -->      
        <ul class="nav nav-tabs">           
            <li class="active"><a href="#fiskalizacija" data-toggle="tab">Postavke fiskalizacije</a></li>
            <!--<li><a href="#racun" data-toggle="tab">Postavke ra&#269;una</a></li>
            <li><a href="#ostalo" data-toggle="tab">Ostale postavke</a></li>-->
        </ul>
                            
        <div class="box-content"><!--<!-- Tab panes -->     
         
            <div class="tab-content">
            
            <div class="tab-pane fade in active" id="fiskalizacija">
            
            <div id="accordion">
                                 
            <h3>Poslovni prostor</h3>
            <div id="fiskalizacija_poslovniProstor">
             
            <!--- ovdje poèima forma unos poslovnog prostora--->                       
            <form id="poslovniprostorForm" method="post" action="" class="form-horizontal">
                                    
                    <input id="id_prostor" name="id_prostor" type="hidden"  value="<?php if(isset($id)){echo $id;} ?>"/>
                   
                    <div class="bs-example">
                        <button id="dodajPP" type="button" onclick="dodajProstor();" class="btn btn-default hidden-xs">Dodaj</button>
                        <button id="urediPP" type="button" disabled="disabled" onclick="urediProstor();" class="btn btn-default hidden-xs">Uredi</button>
                        <button id="brisiPP" type="button" disabled="disabled" onclick="brisiProstor();" class="btn btn-default hidden-xs">Ukloni</button>

                        <button id="registrirajPP" type="button" disabled="disabled" onclick="registrirajProstor()" class="btn btn-danger btn-label-left"><span><i class="fa fa-exclamation"></i></span>Prijavi poslovni prostor</button>
                    </div>                           

                    <table class="table table-bordered table-heading">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Oznaka poslovnog prostora</th>
                                <th>Datum otvaranja</th>
                                <th>Datum zatvaranja</th>
                                <th class="hidden-xs">Datum registracije</th>
                                <!--<th class="hidden-xs">Oznaka zatvaranja</th>   -->
                                <th class="hidden-xs">Zatvoreno</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $rank = 0; foreach ($prodajnomjesto as $prodmjesto) {?>
                                <tr class="oddrow clickable PP" id="<?php echo $prodmjesto->pm_id; ?>">
                                    <td class="id-td"><?php echo ++$rank; ?></td>
                                    <td><?php echo $prodmjesto->pm_oznaka; ?></td>
                                    <td><?php echo isset($prodmjesto->pm_datumOtvaranja)? date("d.m.Y.", strtotime($prodmjesto->pm_datumOtvaranja)):''; ?></td>
                                    <td><?php echo isset($prodmjesto->pm_datumZatvaranja)? date("d.m.Y.", strtotime($prodmjesto->pm_datumZatvaranja)):''; ?></td>
                                    <td class="hidden-xs"><?php echo isset($prodmjesto->pm_datumRegistracije)? date("d.m.Y.", strtotime($prodmjesto->pm_datumRegistracije)):''; ?></td>
<!--                                <td class="hidden-xs"><?php echo $prodmjesto->pm_oznakaZatvaranja; ?></td>-->  
                                    <td class="hidden-xs"><?php if($prodmjesto->pm_zatvoreno == 1){echo 'Da';}else{echo 'Ne';} ?></td>    
                                </tr>
                                
                            <?php } ?>
                        </tbody>
                    </table>
            </form>    
                   
            </div><!---kraj <div id="fiskalizacija_poslovniProstor">--->
        
            <h3>Naplatni ure&#273;aj</h3>
            
            <div id="fisklizacija_naplatniUredaj">
                                                                        
            <!--- ovdje poèima forma unos  naplatnog ureðaja--->                          
            <form id="naplatniuredajForm" method="post" action="" class="form-horizontal">
            <input id="id_uredjaj" name="id_uredjaj" type="hidden"  value="<?php if(isset($id)){echo $id;} ?>"/>
                 
            <button id="dodajNU" type="button" onclick="dodajUredjaj();" class="btn btn-default hidden-xs">Dodaj</button>
            <button id="urediNU" type="button" onclick="urediUredjaj();" disabled="disabled" class="btn btn-default hidden-xs">Uredi</button>
            <button id="brisiNU" type="button" onclick="brisiUredjaj();" disabled="disabled" class="btn btn-default hidden-xs">Ukloni</button>


            <table class="table table-bordered table-heading">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Broj naplatnog ure&#273;aja</th>
                    <th>Oznaka poslovnog prostora</th>
                    </tr>
                </thead>
                <tbody>
                     <?php 
                            $rank = 0; foreach ($naplatniuredjaj as $uredjaj) {?>
                                <tr class="oddrow clickable NU" id="<?php echo $uredjaj->nu_id; ?>">
                                    <td class="id-td"><?php echo ++$rank; ?></td>
                                    <td><?php echo $uredjaj->nu_broj; ?></td>
                                    <td><?php echo $uredjaj->pm_oznaka; ?></td>
                                </tr> 
                     <?php } ?>
                </tbody>
            </table>

            </form>    
            </div><!--- kraj <div id="fisklizacija_naplatniUredaj"> --->

            <h3>Certifikat</h3>
                <div id="fiskalizacija_certifikat">
                              
                  <!--- ovdje poèima forma unos  certifikata---> 
                   <div class="box-content"><!--Poèetak sadržaja forme-->                                
                    <form id="certifikatForm" enctype="multipart/form-data" method="post"  class="form-horizontal">
                                               
                        <fieldset>                      
                            <div class="form-group">    
                                <label class="col-sm-3 control-label">Status certifikata:</label> 
                                 <div class="col-sm-6">
                                       <?php echo isset($certifikat->fi_certifikat)? '<label>Certifikat je u&#269;itan &nbsp;</label><button id="delete" type="delete" onclick="obrisiCertifikat()" class="btn btn-danger btn-label-left"><span><i class="fa fa-trash-o"></i></span>Obri&#353;i</button>':'Certifikat jo&#353; nije u&#269;itan'; ?>
                                 </div>   
                            </div>
                            <div class="form-group">
                                 <label class="col-sm-3 control-label">Odaberite datoteku (.pfx, .cer, .p12):</label>
                                    <div class="col-sm-6">
                                        <input id="certifikat" name="certifikat" type="file"  accept=".pfx,.p12,.cer">
                                    </div>
                            </div>
                            <div class="form-group"> 
                                <label class="col-sm-3 control-label">Lozinka certifikata</label>
                                 <div class="col-sm-3">
                                    <input type="password" class="form-control" name="lozinka" placeholder="lozinka vaseg certifikata" value="<?php if(isset($certifikat)){echo '******';} ?>"/>
                                 </div>
                            </div>
                            <div class="form-group">                              
                                <div class="col-sm-3 col-sm-offset-3">
                                    <button id="spremi" type="submit" class="btn btn-primary btn-label-left"><span><i class="fa fa-upload fa-fw"/></span>U&#269;itaj</button>
                                </div>
                            </div>                            
                        </fieldset>
                             
                    </form>    
                   </div>
              
                </div>
        </div>  
        </div>
        
        <!--<div class="tab-pane fade" id="racun">
            <h4>U izradi</h4>
            <p>Ovdje idu postavke racuna (izgled, sadr&#382;aj i ispis)</p>      
        </div>
        
        
         <div class="tab-pane fade" id="ostalo">
            <h4>U izradi</h4>
            <p>Ovdje idu postavke racuna (izgled, sadr&#382;aj i ispis)</p>  
        </div>-->
                             
        </div>
        </div>                     
        </div>
    </fieldset>
                              
    </div><!--- kraj .col 12 --->                                
</div><!--- kraj #tablice --->                

<!--- ovaj dio je za custom validator kojeg imam u JS folderu
    
koristi se ovako

 var validate = validate_naplatni_uredjaj();

    if (validate) {
    
     //neki kod koji se izvrsava
    }

 <script src="<?php echo base_url(); ?>assets/js/custom_validation.js" type="text/javascript" charset="utf-8"></script>            ---> 
 
           
<script type="text/javascript">


$(document).ready(function() {  
    
    $('#main .collapse-link').click();   
        
    
    LoadBootstrapValidatorScript(FormValidator);          
     
    $('.table tr').click(function (event) {       
          $("#id_prostor").val($(this).attr('id'));
          $("#id_uredjaj").val($(this).attr('id'));
    
     });    
     
    var icons = {
        header: "ui-icon-circle-arrow-e",
        activeHeader: "ui-icon-circle-arrow-s"
    };
    // Make accordion feature of jQuery-UI
    $("#accordion").accordion({icons: icons });

    //za otvaranje onog indexa kojeg želiš
    //$("#accordion").accordion({ active: 1, event: "onload" });
    
    $(".clickable").click(function() { 
        $(".clickable").removeClass("active"); 
        $(this).addClass("active");     
    }); 
    
    $(".PP").click(function() { 
        //$('#urediPP').prop("disabled", false);
        //$('#brisiPP').prop("disabled", false);
        $('#brisiNU').prop("disabled", true);
        $('#urediNU').prop("disabled", true);

        provjeriPrijavuPoslovnogProstora();
    }); 
    
    $(".NU").click(function() {      
        //$('#brisiNU').prop("disabled", false);
        //$('#urediNU').prop("disabled", false);
        $('#urediPP').prop("disabled", true);
        $('#brisiPP').prop("disabled", true);
        $('#registrirajPP').prop("disabled", true);
        
        provjeriNaplatniUredjaj();
    });   
    
});


function provjeriPrijavuPoslovnogProstora()
{
    //provjera prostora vrati true ukoliko se nije prijaviti, false ukoliko je zatvren i ne smije se prijavljivati
        id = $("#id_prostor").val(); 
     
       $.post("<?php echo site_url().'postavke/provjeri_poslovni_prostor'; ?>",{id: id}, function(data) {
            var obj = $.parseJSON(data);  
            
            if(obj.uspjelo == "1")
            {
                $('#registrirajPP').prop("disabled", false); 
                $('#urediPP').prop("disabled", false);     
                $('#brisiPP').prop("disabled", false);      
            }
            else
            {
                $('#registrirajPP').prop("disabled", true);     
                $('#urediPP').prop("disabled", true);     
                $('#brisiPP').prop("disabled", true);     
            }
     
    });
}

function provjeriNaplatniUredjaj()
{
    //provjera prostora vrati true ukoliko se nije prijaviti, false ukoliko je zatvren i ne smije se prijavljivati
        idPP = $("#id_prostor").val(); 
        idNU = $("#id_uredjaj").val(); 
     
       $.post("<?php echo site_url().'postavke/provjeri_naplatni_uredjaj'; ?>",{idPP: idPP}, function(data) {
            var obj = $.parseJSON(data);  
            
            if(obj.uspjelo != "1")
            {
                $('#urediNU').prop("disabled", true);     
                $('#brisiNU').prop("disabled", true);     
            }
            else
            {
                $('#urediNU').prop("disabled", false);     
                $('#brisiNU').prop("disabled", false);     
            }
     
    });
} 

function registrirajProstor()
{

    event.preventDefault();
    id = $("#id_prostor").val();   
    
    var r = confirm("Zelite prijaviti poslovni prostor?");
    if (r == true) 
    {
        $.post("<?php echo site_url().'fiskalizacija/fiskal'; ?>",{request: "PoslovniProstorZahtjev", id: id}, function(data) {
            
                    if (data != 'false') {
                        var obj = $.parseJSON(data);
                        
                       $.post("<?php echo site_url().'postavke/pregled'; ?>", function(data) {
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

}

     
$("#certifikatForm").submit(function(event){
        
    event.preventDefault(); //Prevent Default action. 
    var formObj = $(this);
    var formURL = "<?php echo site_url().'postavke/upload_certifikat/certifikat'; ?>";
    var formData = new FormData(this);
    
    $.ajax({
        url: formURL,
        type: 'POST',
        data:  formData,
        mimeType:"multipart/form-data",
        contentType: false,
        cache: false,
        processData:false, 
            success: function(data)
            {     
                var obj = $.parseJSON(data);
                 if(obj.uspjelo != "0")
                 {
                    $.post("<?php echo site_url().'postavke/pregled'; ?>", function(data) {
                            if (data != 'false') {
                                $('#ajax-content').empty();
                                $('#ajax-content').html(data);
                           
                                $('#ajax-content').show();
                                $("#accordion").accordion({ active: 2});
                            }
                            $('#poruka').html(obj.poruka);
                            $('#poruka').show();     
                            setTimeout(function() {
                            $('#poruka').fadeOut('fast');
                            }, 10000);
                        });  
                 }
                 else
                 {
                     $('#poruka').html(obj.poruka);
                     $('#poruka').show(); 
                     setTimeout(function() {
                        $('#poruka').fadeOut('fast');
                     }, 10000);    
                 }                        
            },
            error: function(data) 
            {        
                var obj = $.parseJSON(data);  
                                              
                $('#poruka').html(obj.poruka);
                $('#poruka').show();
            
                setTimeout(function() {
                $('#poruka').fadeOut('fast');
                }, 10000);
            }          
     });

}); 



function dodajProstor()
{
    
    $.post("<?php echo site_url().'postavke/dodaj/prodajnomjesto'; ?>", function(data) {
        if (data != 'false') {
            var form = data;
            var header = 'Dodaj poslovni prostor';
            
            OpenModalBox(header,form);
            
        } else {
        }
    });
   
}


function dodajUredjaj()
{
    
    $.post("<?php echo site_url().'postavke/dodaj/naplatniuredjaj'; ?>", function(data) {
        if (data != 'false') {
            var form = data;
            var header = 'Dodaj naplatni ure&#273;aj';
            
            OpenModalBox(header,form);  
            
        } else {
        }
    });
   
}


function brisiProstor()
{
    //alert($("#id_odabran").val());
    var header = 'Brisanje poslovnog prostora';
                                          
    var form = $('<div class="form-group"><label">&#381;elite obrisati odabrani poslovni prostor?</label></div>'+
    '<div class="form-group">'+
    '<button id="delete" type="delete" onclick="obrisiPoslProstor()" class="btn btn-danger btn-label-left">'+
                        '<span><i class="fa fa-trash-o"></i></span>'+
                        'Obri&#353;i</button>'+' '+                       
                        '<button id="cancel" onclick="cancel()" class="btn btn-default btn-label-left">'+
                        '<span><i class="fa fa-reply txt-danger"></i></span>'+
                        'Odustani'+
                        '</button></div>'
    
    );
        
    OpenModalBox(header, form);
}

function brisiUredjaj()
{
    //alert($("#id_odabran").val());
    
    var header = 'Brisanje naplatnog ure&#273;aja';

                                             
    var form = $('<div class="form-group"><label">&#381;elite obrisati odabrani naplatni ure&#273;aj?</label></div>'+
                '<div class="form-group">'+
                '<button id="delete" type="delete" onclick="obrisiNaplatniUredjaj()" class="btn btn-danger btn-label-left">'+
                        '<span><i class="fa fa-trash-o"></i></span>'+
                        'Obri&#353;i</button>'+' '+                       
                        '<button id="cancel" onclick="cancel()" class="btn btn-default btn-label-left">'+
                        '<span><i class="fa fa-reply txt-danger"></i></span>'+
                        'Odustani'+
                        '</button></div>'
    );
        
    OpenModalBox(header, form  );
}


function obrisiPoslProstor()
{
    id = $("#id_prostor").val();

    $.post("<?php echo site_url().'administracija/brisanje/prodajnomjesto'; ?>", {id:id}, function(data) {
        if (data != 'false') {
            var obj = $.parseJSON(data);
            
           $.post("<?php echo site_url().'postavke/pregled'; ?>", function(data) {
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

function obrisiNaplatniUredjaj()
{
    id = $("#id_uredjaj").val();
    
    $.post("<?php echo site_url().'administracija/brisanje/naplatniuredjaj'; ?>", {id:id}, function(data) {
        if (data != 'false') {
            var obj = $.parseJSON(data);
            
           $.post("<?php echo site_url().'postavke/pregled'; ?>", function(data) {
                    if (data != 'false') {
                    $('#ajax-content').empty();
                    $('#ajax-content').html(data);                   
                    $('#ajax-content').show();
                    $("#accordion").accordion({ active: 1});                    
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

function obrisiCertifikat()
{
    event.preventDefault();
    
    var r = confirm("Zelite obrisati certifikat?");
    if (r == true) 
    {
        $.post("<?php echo site_url().'postavke/delete_certifikat'; ?>", function(data) {
            if (data != 'false') {
                var obj = $.parseJSON(data);
                
               $.post("<?php echo site_url().'postavke/pregled'; ?>", function(data) {
                        if (data != 'false') {
                            $('#ajax-content').empty();
                            $('#ajax-content').html(data);
                            $('#poruka').html(obj.poruka);
                            $('#poruka').show();     
                            $('#ajax-content').show();
                            $("#accordion").accordion({ active: 2});
                        }
                        setTimeout(function() {
                        $('#poruka').fadeOut('fast');
                        }, 10000);
                    });  
            }
        });       
    }
     
}


function cancel()
{
    CloseModalBox();
}


function urediProstor()
{
    id = $("#id_prostor").val();

    $.post("<?php echo site_url().'postavke/uredjivanje/prodajnomjesto'; ?>", {id:id}, function(data) {
        if (data != 'false') {
            
            var form = data;
            var header = 'Uredi poslovni prostor';
            
            OpenModalBox(header,form);
            
        } else {
        }
    });
}



function urediUredjaj()
{
    id = $("#id_uredjaj").val();

    $.post("<?php echo site_url().'postavke/uredjivanje/naplatniuredjaj'; ?>", {id:id}, function(data) {
        if (data != 'false') {
            
            var form = data;
            var header = 'Uredi naplatni ure&#273;aj';
            
            OpenModalBox(header,form);
            
        } else {
        }
    });
}


</script>





