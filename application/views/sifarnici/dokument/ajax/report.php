 <!--Poèetak #forma div.a-->
      
<div class="col-xs-12 col-sm-12">
    <div class="box">
        <input id="id_odabran" name="id_odabran" type="hidden"  value="<?php if(isset($id)){echo $id;} ?>"/>
        <div class="box-header"><!--Poèetak headera forme-->
            <div class="box-name">
                <i class="fa fa-file-text"></i>
                <span>Pregled dokumenta</span>
            </div>
            <div class="box-icons">
                <a class="close-link1">
                <i class="fa fa-times"></i>
                </a>
            </div>
            <div class="no-move"></div>
        </div><!--Kraj headera forme-->

        <div class="box-content" style="height: 100%;"><!--Poèetak sadržaja forme-->
 
 

                <div class="col-sm-6">
                    <button id="urediDokument" class="btn btn-default btn-label-left hidden-xs hidden-sm"><span><i class="fa fa-edit fa-fw"/></span>Uredi</button>
                    <button id="pdf" class="btn btn-default btn-label-left"><span><i class="fa fa-file fa-fw"/></span>Preuzmi PDF</button>

                    <button class="btn btn-default btn-label-left close-link1"><span><i class="fa fa-times fa-fw"/></span>Zatvori</button>
                </div>

                    
        <iframe id="report" name="report" src="<?php echo site_url(); ?>dokument/pdf/<?php echo $id ?>/<?php echo $idvrstaDok; ?>/<?php echo $vrstaDok->vd_oznaka; ?>" style="width:100%; height: 800px;" frameborder="0"></iframe>

        </div>
    </div> <!--kraj box-->  


</div>     

<!--Kraj #forma div.a-->

<script type="text/javascript"> 
$(document).ready(function() {  
    
     $(window).keydown(function(event){
     if(event.keyCode == 13) {
         event.preventDefault();
         return false;
         }
     });
    
    //$('.preloader2').hide();
    setTimeout(function() {
        $('.preloader2').fadeOut('slow');
      }, 1000);


    $('.close-link1').click(function (event) {       
        //vrati pocetni popis svih dokumenata
                
        //osvjezi pregled
         idvrstedok =  '<?php echo $vrstaDok->vd_id; ?>';
     
        // osvježiti tablicu prilikom zatvaranja forme za unos i editiranje
        $.post("<?php echo site_url().'administracija/vrati/dokument'; ?>",{id:idvrstedok}, function(data) {
                if (data != 'false') {

                $('#ajax-content').empty();
                $('#ajax-content').html(data);                  
                $('#ajax-content').show();

                 CloseModalBox();
                }    
            });  

        $('#forma').hide();
        $('#tablica').show();
        $('#tablica tbody tr:eq(0)').click();

     });   
 
     $('#pdf').click(function (event) {       
         
        //download pdf

        $('#report').attr('src', "<?php echo site_url(); ?>dokument/pdfskini/<?php echo $id ?>/<?php echo $idvrstaDok; ?>/<?php echo $vrstaDok->vd_oznaka ?>/<?php echo $vrstaDok->vd_oznaka; ?>")

     });   

     $('#urediDokument').click(function (event) {       

        id = $("#id_odabran").val();

        $('#tablica').hide();

        $.post("<?php echo site_url().'dokument/uredjivanje/dokument'; ?>", {id:id}, function(data) {
            if (data != 'false') {
                $('#forma').empty();
                $('#forma').html(data);
                $('#forma').show();
                
                
                id = $("#id").val();

                $.post("<?php echo site_url().'dokument/prikaziStavke'; ?>",{id:id}, function(data) {
                    if (data != 'false') {   
                        $('#stavkePonuda').empty();
                        $('#stavkePonuda').html(data);
                        
                        //sakrij button za spremanje zaglavlja i editiranje a prikazi btn za ispis               

                        
                    <?php if($vrstaDok->vd_oznaka =="ponuda") {?>
                    //ako je ponuda prikazi btn za ispis
                    
                   $('#spremi').html("Spremi i ispi&#353;i");
                    
                    <?php }else {?>
                    
                    $('#spremi').hide();
                    $('#ispisi').show();                  
                    
                    <?php } ?>
                    }
                 });
             
             } else {
            }
        });    

     });      
});   
 

    
</script>
